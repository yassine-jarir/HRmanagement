<template>
  <VaForm ref="form" @submit="submit">
    <h1 class="font-semibold text-4xl mb-4">Log in</h1>
    <p class="text-base mb-4 leading-5">
      New to Vuestic?
      <RouterLink :to="{ name: 'signup' }" class="font-semibold text-primary">Sign up</RouterLink>
    </p>
    <VaInput
      v-model="formData.email"
      :rules="[validators.required, validators.email]"
      class="mb-4"
      label="Email"
      type="email"
    />
    <VaValue v-slot="isPasswordVisible" :default-value="false">
      <VaInput
      @clickAppendInner.stop= " isPasswordVisible.value = !isPasswordVisible.value "
        v-model="formData.password"
        :rules="[validators.required]"
        :type="isPasswordVisible.value ? 'text' : 'password'"
        class="mb-4"
        label="Password"
      >
        <template #appendInner>
          <VaIcon
            :name="isPasswordVisible.value ? 'mso-visibility_off' : 'mso-visibility'"
            class="cursor-pointer"
            color="secondary"
          />
        </template>
      </VaInput>
    </VaValue>

    <div class="auth-layout__options flex flex-col sm:flex-row items-start sm:items-center justify-between">
      <VaCheckbox v-model="formData.keepLoggedIn" class="mb-2 sm:mb-0" label="Keep me signed in on this device" />
      <RouterLink :to="{ name: 'recover-password' }" class="mt-2 sm:mt-0 sm:ml-1 font-semibold text-primary">
        Forgot password?
      </RouterLink>
    </div>

    <div class="flex justify-center mt-4">
      <VaButton class="w-full" @click="submit">Login</VaButton>
    </div>
  </VaForm>
</template>

<script setup>
 
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useForm, useToast } from 'vuestic-ui'
import { validators } from '../../services/utils'
   
const { validate } = useForm('form')
const router= useRouter()
const { init } = useToast()
  
const formData = reactive({
  email: '',
  password: '',
  keepLoggedIn: false,
})

const submit = async () => {
  if (validate()) {
    try {
      const response = await fetch(`${import.meta.env.VITE_APP_API_URL}/api/login`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          email: formData.email,
          password: formData.password,
        }),
      })
 
      const result = await response.json()
      console.log(result);

      if (response.ok) {
        localStorage.setItem('access_token', result.access_token)
        localStorage.setItem('user', JSON.stringify(result.user))

        init({ message: "You've successfully logged in", color: 'success' })
         
         const user = JSON.parse(localStorage.getItem('user'))
        if (user.role === 'admin') {
          router.push({ name: 'admin-dashboard' });
        } else {
          router.push({ name: 'employee-dashboard' });
        }
        console.log(response);
        
      }
       else {
        init({ message: result.message || 'Login failed', color: 'danger' })
      }
    } catch (error) {
      init({ message: 'An error occurred. Please try again.', color: 'danger' })
      console.log(response);
      
    }
  }
}
</script> 