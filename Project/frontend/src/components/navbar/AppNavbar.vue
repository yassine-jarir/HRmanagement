<template>
  <VaNavbar class="app-layout-navbar py-2 px-0 min-h-[60px]">
    <template #left >
      <div class="left max-h-[90px]" >
        <Transition v-if="isMobile" name="icon-fade" mode="out-in">
          <!-- <VaIcon
            color="primary"
            :name="isSidebarMinimized ? 'menu' : 'close'"
            size="24px"
            style="margin-top: 3px"
            @click="isSidebarMinimized = !isSidebarMinimized"
          /> -->
          <img src="../../../public/logo.png" alt="" class="navbar-logo">
        </Transition>
        <RouterLink to="/" aria-label="Visit home page">
          <!-- <VuesticLogo /> -->
          <img src="../../../public/logo.png" alt="HR Management Logo" class="navbar-logo">
        </RouterLink>
      </div>
    </template>
    <template #right>
      <AppNavbarActions class="app-navbar__actions" :is-mobile="isMobile" />
    </template>
  </VaNavbar>
</template>

<script setup>
import { storeToRefs } from 'pinia'
import { useGlobalStore } from '../../stores/global-store'
import AppNavbarActions from './components/AppNavbarActions.vue'


defineProps({
  isMobile: { type: Boolean, default: false },
})

const GlobalStore = useGlobalStore()

const { isSidebarMinimized } = storeToRefs(GlobalStore)
</script>

<style lang="scss" scoped>
.va-navbar {
  z-index: 2;

  @media screen and (max-width: 950px) {
    .left {
      width: 100%;
    }

    .app-navbar__actions {
      display: flex;
      justify-content: space-between;
    }
  }
}

.left {
  display: flex;
  align-items: center;
  margin-left: 1rem;

  & > * {
    margin-right: 1rem;
  }

  & > *:last-child {
    margin-right: 0;
  }
}

.navbar-logo {
  width: 100%; 
  max-width: 200px; 
  height: auto;
  object-fit: contain; 
}

.icon-fade-enter-active,
.icon-fade-leave-active {
  transition: transform 0.5s ease;
}

.icon-fade-enter,
.icon-fade-leave-to {
  transform: scale(0.5);
}
</style>
