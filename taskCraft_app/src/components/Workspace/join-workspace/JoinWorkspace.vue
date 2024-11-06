<script setup>
import {Form} from "vee-validate";
import TextInput from "@/components/fields/TextInput.vue";
import TCButton from "@/components/fields/TCButton.vue";
import {computed, reactive} from "vue";
import {toTypedSchema} from "@vee-validate/zod";
import * as zod from "zod";

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

// Methods
const onSubmit = (fields) => {
  console.log(fields)
}

const onInvalidSubmit = (error) => {
  console.log(error)
}


</script>

<template>
  <div v-if="!localState.registered" class="container">
    <h1 class="text-3xl font-bold justify-center">Join Workspace!</h1>
    <h3 class="text-2xl font-thin">John Doe is inviting you to collaborate!.</h3>

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
              button-text="Register"
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
