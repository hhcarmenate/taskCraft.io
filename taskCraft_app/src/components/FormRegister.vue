<script setup>
import { Form } from 'vee-validate'
import {computed, reactive} from "vue";
import { toTypedSchema } from '@vee-validate/zod'
import TextInput from "@/components/fields/TextInput.vue";
import * as zod from 'zod'
import TCButton from "@/components/fields/TCButton.vue";

const localState = reactive({
  form: {
    name: null,
    email: null,
    password: null
  }
})

const loginValidationSchema = computed(() => {
  return toTypedSchema(
    zod.object({
      name: zod.string({message: 'Name is required'}),
      email: zod.string({message: 'Email is required'}).email({ message: 'Please use a valid email' }),
      password: zod.string({message: 'Password is required'}).min(8, {message: 'Password must have at least 8 characters long'})
    })
  )
})

</script>

<template>
  <div class="container">
    <h1 class="text-3xl font-bold justify-center">Sign Up</h1>
    <h3 class="text-2xl font-thin">Please complete the following information.</h3>

    <div class="section__body flex justify-center">
      <Form
        class="form__alt w-full flex justify-center"
        :validation-schema="loginValidationSchema"
      >
        <div class="form__section flex flex-col">
          <div class="form__row">
            <div class="form__controls">
              <TextInput
                name="name"
                type="text"
                label="Name"
                placeholder="John Doe"
                v-model="localState.form.name"
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
              id="submitButton"
              button-type="success"
              type="submit"
              button-text="Register"
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
