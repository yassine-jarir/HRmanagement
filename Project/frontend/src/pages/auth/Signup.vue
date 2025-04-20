  <template>
    <VaForm ref="form" @submit.prevent="submit">
      <h1 class="font-semibold text-4xl mb-4">Sign up</h1>
      <p class="text-base mb-4 leading-5">
        Have an account?
        <RouterLink :to="{ name: 'login' }" class="font-semibold text-primary">Login</RouterLink>
      </p>

      <VaInput
        v-model="formData.email"
        :rules="[(v) => !!v || 'Email field is required', (v) => /.+@.+\..+/.test(v) || 'Email should be valid']"
        class="mb-4"
        label="Email"
        type="email"
      />
      <VaValue v-slot="isPasswordVisible" :default-value="false">
        <VaInput
          ref="password1"
          v-model="formData.password"
          :rules="passwordRules"
          :type="isPasswordVisible.value ? 'text' : 'password'"
          class="mb-4"
          label="Password"
          messages="Password should be 8+ characters: letters, numbers, and special characters."
          @clickAppendInner.stop= "isPasswordVisible.value = !isPasswordVisible.value "
        >

          <template #appendInner>
            <VaIcon
              :name= "isPasswordVisible.value ? 'mso-visibility_off' : 'mso-visibility'"
              class= "cursor-pointer"
              color= "secondary"
            />
          </template>
        </VaInput>

        <VaInput
          ref= "name"
          v-model="formData.name"
          class="mb-4"
          label="Name"
         >
          <template #appendInner>
            <VaIcon
              class="cursor-pointer"
              color="secondary"
            />
          </template>
        </VaInput>

      </VaValue>

      <div class="flex justify-center mt-4">
        <VaButton class="w-full" @click="submit"> Create account</VaButton>
      </div>
    </VaForm>
  </template>

  <script  setup>
  import { reactive } from 'vue'
  import { useRouter } from 'vue-router'
  import { useForm, useToast } from 'vuestic-ui'

  const { validate } = useForm('form')
  const { push } = useRouter()
  const { init } = useToast()

  const formData = reactive({
    email: '',
    password: '',
    name: '',
  })

  const submit = async () => {
  if (validate()) {
    try {
      const response = await fetch(`${import.meta.env.VITE_APP_API_URL}/api/register`, {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
          },
        body: JSON.stringify({
          email: formData.email,
          password: formData.password,
          name : formData.name,
        }),
      })
 
      const result = await response.json()
      console.log(result);

      if (response.ok) {
        init({ message: "You've successfully register in", color: 'success' })
          push({ name: 'login' })
              } else {    
        init({ message: result.message || 'Register failed', color: 'danger' })
      }
    } catch (error) {
      init({ message: 'An error occurred. Please try again.', color: 'danger' })
    }
  }
     
}
  const passwordRules = [
    (v) => !!v || 'Password field is required',
    (v) => (v && v.length >= 8) || 'Password must be at least 8 characters long',
    (v) => (v && /[A-Za-z]/.test(v)) || 'Password must contain at least one letter',
    (v) => (v && /\d/.test(v)) || 'Password must contain at least one number',
    (v) => (v && /[!@#$%^&*(),.?":{}|<>]/.test(v)) || 'Password must contain at least one special character',
  ]
  </script>