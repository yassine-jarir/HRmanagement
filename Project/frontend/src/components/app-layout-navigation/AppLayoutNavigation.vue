<template>
  <div class="flex gap-2">
    <VaIconMenuCollapsed
      class="cursor-pointer"
      :class="{ 'x-flip': !isSidebarMinimized }"
      :color="collapseIconColor"
      @click="isSidebarMinimized = !isSidebarMinimized"
    />

    <nav class="flex items-center">
      <VaBreadcrumbs>
        <VaBreadcrumbsItem 
          label="Home" 
          :to="getDashboardRoute"
        />
        <VaBreadcrumbsItem
          v-for="item in breadcrumbItems"
          :key="item.label"
          :label="item.label"
          :to="item.to"
        />
      </VaBreadcrumbs>
    </nav>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useColors } from 'vuestic-ui'
import VaIconMenuCollapsed from '../icons/VaIconMenuCollapsed.vue'
import { storeToRefs } from 'pinia'
import { useGlobalStore } from '../../stores/global-store'
import adminRoutes from '../sidebar/adminRoutes'
import employeeRoutes from '../sidebar/employeeRoutes'

const { isSidebarMinimized } = storeToRefs(useGlobalStore())
const router = useRouter()
const route = useRoute()

const userRole = computed(() => {
  const user = JSON.parse(localStorage.getItem('user') || '{}')
  return user.role || 'employee'
})

const getDashboardRoute = computed(() => ({
  name: userRole.value === 'admin' ? 'admin-dashboard' : 'employee-dashboard',
  params: {}
}))

const findRouteDisplay = (name: string): string | null => {
  const routes = userRole.value === 'admin' ? adminRoutes.routes : employeeRoutes.routes
  return routes.find(r => r.name === name)?.displayName || null
}

const breadcrumbItems = computed(() => {
  const items = []
  if (route.name && route.name !== getDashboardRoute.value.name) {
    const displayName = findRouteDisplay(route.name as string)
    if (displayName) {
      items.push({
        label: displayName,
        to: { name: route.name }
      })
    }
  }
  return items
})

const { getColor } = useColors()
const collapseIconColor = computed(() => getColor('secondary'))
</script>

<style lang="scss" scoped>
.x-flip {
  transform: scaleX(-100%);
}
</style>
