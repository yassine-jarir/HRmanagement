<template>
  <VaSidebar v-model="writableVisible" :width="sidebarWidth" :color="color" minimized-width="0">
    <VaAccordion v-model="value" multiple>
      <VaCollapse v-for="(route, index) in navigationRoutes.routes" :key="index">
        <template #header="{ value: isCollapsed }">
                <VaSidebarItem
        :to="route.children ? undefined : { name: route.name }"
        :active="routeHasActiveChild(route)"
        :active-color="activeColor"
        :text-color="textColor(route)"
        :aria-label="`${route.children ? 'Open category ' : 'Visit'} ${route.displayName}`"
        role="button"
        hover-opacity="0.10"
      >

            <VaSidebarItemContent class="py-3 pr-2 pl-4">
              <VaIcon
                v-if="route.meta.icon"
                aria-hidden="true"
                :name="route.meta.icon"
                size="20px"
                :color="iconColor(route)"
              />
              <VaSidebarItemTitle class="flex justify-between items-center leading-5 font-semibold">
                {{ route.displayName }}
                <VaIcon v-if="route.children" :name="arrowDirection(isCollapsed)" size="20px" />
              </VaSidebarItemTitle>
            </VaSidebarItemContent>
          </VaSidebarItem>
        </template>
        <template #body>
          <div v-for="(childRoute, index2) in route.children" :key="index2">
            <VaSidebarItem
              :to="{ name: childRoute.name }"
              :active="isActiveChildRoute(childRoute)"
              :active-color="activeColor"
              :text-color="textColor(childRoute)"
              :aria-label="`Visit ${route.displayName}`"
              hover-opacity="0.10"
            >
              <VaSidebarItemContent class="py-3 pr-2 pl-11">
                <VaSidebarItemTitle class="leading-5 font-semibold">
                  {{ childRoute.displayName }}
                </VaSidebarItemTitle>
              </VaSidebarItemContent>
            </VaSidebarItem>
          </div>
        </template>
      </VaCollapse>
    </VaAccordion>
  </VaSidebar>
</template>

<script >
import { defineComponent, watch, ref, computed } from 'vue'
import { useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'
import { useColors } from 'vuestic-ui'

 import adminRoutes from './adminRoutes.js'
import employeeRoutes from './employeeRoutes.js'

export default defineComponent({
  name: 'Sidebar',
  props: {
    visible: { type: Boolean, default: true },
    mobile: { type: Boolean, default: false },
    role: { type: String, required: true },
  },
  emits: ['update:visible'],
  
  setup: (props, { emit }) => {
    const { getColor, colorToRgba } = useColors()
    const route = useRoute()
    const { t } = useI18n()

    const value = ref([])

    const writableVisible = computed({
      get: () => props.visible,
      set: (v) => emit('update:visible', v),
    })

    const isActiveChildRoute = (child) => route.name === child.name

    const routeHasActiveChild = (section) => {
      if (!section.children) {
        return route.path.endsWith(`${section.name}`)
      }
      return section.children.some(({ name }) => route.path.endsWith(`${name}`))
    }

    const setActiveExpand = () =>
      (value.value = navigationRoutes.value.routes.map((route) => routeHasActiveChild(route)))

    const sidebarWidth = computed(() => (props.mobile ? '100vw' : '280px'))
    const color = computed(() => getColor('background-secondary'))
    const activeColor = computed(() => colorToRgba(getColor('focus'), 0.1))

    const iconColor = (route) => (routeHasActiveChild(route) ? 'primary' : 'secondary')
    const textColor = (route) => (routeHasActiveChild(route) ? 'primary' : 'textPrimary')
    const arrowDirection = (state) => (state ? 'va-arrow-up' : 'va-arrow-down')

     const navigationRoutes = computed(() => {
      return props.role === 'admin' ? adminRoutes : employeeRoutes
    })

    watch(() => route.fullPath, setActiveExpand, { immediate: true })

    return {
      writableVisible,
      sidebarWidth,
      value,
      color,
      activeColor,
      navigationRoutes,
      routeHasActiveChild,
      isActiveChildRoute,
      t, 
      iconColor,
      textColor,
      arrowDirection,
    }
  },
})
</script>
