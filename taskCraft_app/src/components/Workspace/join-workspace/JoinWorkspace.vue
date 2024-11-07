<script setup>
import {Form} from "vee-validate";
import TextInput from "@/components/fields/TextInput.vue";
import TCButton from "@/components/fields/TCButton.vue";
import {computed, onBeforeMount, reactive, ref} from "vue";
import {toTypedSchema} from "@vee-validate/zod";
import * as zod from "zod";
import useNotification from "@/composables/useNotification.js";
import {useWorkspaceStore} from "@/stores/useWorkspaceStore.js";

// Data
const localState = reactive({
  registered: false,
  sending: false,
  form: {
    workspaceName: null,
    email: null,
    password: null
  }
})
const invalidInvitationLink = ref(true)
const ownerName = ref('')
const { notify } = useNotification()
const workspace = useWorkspaceStore()


// Computed
const loginValidationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      name: zod.string({message: 'Workspace Name is required'}),
      email: zod.string({message: 'Email is required'}).email({ message: 'Please use a valid email' }),
      password: zod.string({message: 'Password is required'}).min(8, {message: 'Password must have at least 8 characters long'})
    })
  )
})

// Hooks
onBeforeMount(() => {
  const query = window.location.search

  if (query) {
    const urlParams = new URLSearchParams(query)
    const token = urlParams.get('token')

    if (!token) {
      invalidInvitationLink.value = true
    } else {
      invalidInvitationLink.value = false

      initWorkspaceData(token)
    }

  } else {
    invalidInvitationLink.value = true
  }
})

const initWorkspaceData = async (token) => {
  try {
    const response = await workspace.getJoinData(token)

    if(response.status === 200) {
      localState.form.workspaceName = response.data?.data?.name ?? ''
      ownerName.value = response.data?.data?.owner?.name ?? ''

    } else {
      invalidInvitationLink.value = true
    }

  } catch (e) {
    console.error(e)

    notify('error', 'Oops something went wrong!')
  }
}

// Methods
const onSubmit = (fields) => {
  console.log(fields)
}

const onInvalidSubmit = (error) => {
  console.log(error)
}


</script>

<template>
  <div class="container" v-if="invalidInvitationLink">
    <h3 class="text-2xl font-thin"> This Link is invalid.!</h3>
  </div>
  <template v-else>
    <div  v-if="!localState.registered" class="container">
      <h1 class="text-3xl font-bold justify-center">Join Workspace!</h1>
      <h3 class="text-2xl font-thin">
        {{
          ownerName
            ? ownerName + ' is inviting you to collaborate!.'
            : 'You are invited to collaborate!'
        }}
      </h3>

      <div class="section__body flex justify-center">
        <Form
          class="form__alt w-full flex justify-center"
          :validation-schema="loginValidationSchema"
          @submit="onSubmit"
          @invalid-submit="onInvalidSubmit"
        >
          <div class="form__section flex flex-col">
            <div class="form__row">
              <div class="form__controls">
                <TextInput
                  name="workspaceName"
                  type="text"
                  label="Workspace Name"
                  placeholder=""
                  v-model="localState.form.workspaceName"
                  show-error
                  disabled
                />
              </div>
            </div>

            <div class="form__row">
              <div class="form__controls">
                <TextInput
                  name="email"
                  type="email"
                  label="Email"
                  placeholder="johnDoe@gmail.com"
                  v-model="localState.form.email"
                  show-error
                />
              </div>
            </div>

            <div class="form__row">
              <div class="form__controls">
                <TextInput
                  name="password"
                  type="password"
                  label="Password"
                  placeholder="***********"
                  v-model="localState.form.password"
                  show-error
                />
              </div>
            </div>

            <div class="form__row">
              <TCButton
                :loading="localState.sending"
                id="submitButton"
                button-type="submit"
                type="success"
                button-text="Join TaskCraft to Collaborate"
                class="w-full"
              />
            </div>
            <div class="form__row">
              or
            </div>
            <div class="form__row">
              <TCButton
                :loading="localState.sending"
                id="submitButton"
                button-type="submit"
                type="info"
                button-text="Login to your account"
                class="w-full"
              />
            </div>
          </div>
        </Form>
      </div>
    </div>
    <div v-else class="container">
      <h1 class="text-3xl font-bold justify-center">Thank You!</h1>
      <h3 class="text-2xl font-thin">Please check your inbox to verify your email address.</h3>
    </div>
  </template>

</template>

<style scoped>
.container {
  text-align: center;

  .form__section {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100%;
    padding: 1.6rem;

    .form__row {
      width: 100%;
      padding: 1rem;
    }
  }
}
</style>
