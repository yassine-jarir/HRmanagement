<script lang="ts" setup>
 import NotFoundImage from '../components/NotFoundImage.vue'
</script>

<template>
  <div class="flex flex-col justify-between h-screen items-center bg-[var(--va-background-secondary)]">
    <RouterLink to="/">
      <VuesticLogo :gradient="false" class="my-8 h-5" />
    </RouterLink>

    <div class="flex flex-col items-center gap-6 px-4 my-8">
      <NotFoundImage />
      <h1 class="va-h1 text-center sm:text-5xl text-4xl">unauthorized</h1>

      <p class="text-center">
        you are not authorized to view this page.
        <br />
      </p>

      <div class="flex flex-col sm:flex-row gap-4">
        <VaButton to="/auth">Go to Login</VaButton>
      
      </div>
    </div>

    <div />
  </div>
</template>
