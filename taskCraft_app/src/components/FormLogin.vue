<script setup>
import { Form } from 'vee-validate'
import {computed, reactive} from "vue";
import { toTypedSchema } from '@vee-validate/zod'
import TextInput from "@/components/fields/TextInput.vue";
import * as zod from 'zod'
import TCButton from "@/components/fields/TCButton.vue";
import {useUserStore} from "@/stores/useUserStore.js";
import {useRouter} from "vue-router";
import useNotification from "@/composables/useNotification.js";

// Data
const user = useUserStore()
const router = useRouter()
const { notify } = useNotification()
const localState = reactive({
  form: {
    email: null,
    password: null
  },
  sending: false
})

// Computed Property
const loginValidationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      email: zod.string({message: 'Email is required'}).email({ message: 'Please use a valid email' }),
      password: zod.string({message: 'Password is required'})
    })
  )
})


// Methods
const onSubmit = async () => {
  try {
    localState.sending = true

    const response = await user.login(localState.form)

    if (response.status === 200) {
      notify('success', 'User signed in successfully')
      return await router.push('/dashboard')
    }

    notify('error', 'Oops! something went wrong')
  } catch (error) {
    console.log(error)
  } finally {
    localState.sending = false
  }
}

const onInvalidSubmit = (error) => {
  console.log(error)
}

</script>

<template>
  <div class="container">
    <h1 class="text-3xl font-bold justify-center">Sign In</h1>
    <h3 class="text-5xl font-thin">Welcome Back.</h3>

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
              button-text="Login"
              class="w-full"
            />
          </div>
        </div>
      </Form>
    </div>
  </div>
</template>

<style lang="scss" scoped>
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
        width: 75%;
        padding: 1rem;
      }
    }
  }
</style>
