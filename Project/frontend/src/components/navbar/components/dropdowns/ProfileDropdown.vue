<template>
  <div class="profile-dropdown-wrapper">
    <VaDropdown v-model="isShown" :offset="[9, 0]" class="profile-dropdown" stick-to-edges>
      <template #anchor>
        <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
    <span class="font-medium text-gray-600 dark:text-gray-300">JL</span>
</div>
      </template>
      <VaDropdownContent
        class= "profile-dropdown__content md:w-60 px-0 py-4 w-full"
        :style= "{ '--hover-color': hoverColor }">
        <VaList v-for="group in options" :key="group.name">
          <header v-if="group.name" class="uppercase text-[var(--va-secondary)] opacity-80 font-bold text-xs px-4">
            {{ t(`user.${group.name}`) }}
          </header>
          <VaListItem
            v-for="item in group.list"
            :key="item.name"
            class="menu-item px-4 text-base cursor-pointer h-8"
            @click="handleLogout(item)"
          >
            <VaIcon :name="item.icon" class="pr-1" color="secondary" />
            {{ t(`user.${item.name}`) }}
          </VaListItem>
          <VaListSeparator v-if="group.separator" class="mx-3 my-2" />
        </VaList>
      </VaDropdownContent>
    </VaDropdown>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { useColors } from 'vuestic-ui'
import {useRouter } from 'vue-router'
import axios from "axios"
const { colors, setHSLAColor } = useColors()
const hoverColor = computed(() => setHSLAColor(colors.focus, { a: 0.1 }))

const { push } = useRouter()

const handleLogout =  (item) => {
  if (item.to === 'login') {
 
    axios.post(`${import.meta.env.VITE_APP_API_URL}/api/logout`,
    {},
      {
        headers  : {
          'Authorization' : `Bearer ${localStorage.getItem('access_token')}`
        }
      }
    ).then(() => {
      localStorage.removeItem('user')
      localStorage.removeItem('access_token')
     push({name : 'login'})
    }).catch((error) => {
      console.error('Logout failed:', error)
    })
  }
} 

const { t } = useI18n()

 

 
 const  options = [
      {
        name: 'account',
        separator: true,
        list: [
          {
            name: 'profile',
            to: 'preferences',
            icon: 'mso-account_circle',
          },
          {
            name: 'settings',
            to: 'settings',
            icon: 'mso-settings',
          },
          {
            name: 'billing',
            to: 'billing',
            icon: 'mso-receipt_long',
          },
          {
            name: 'projects',
            to: 'projects',
            icon: 'mso-favorite',
          },
        ],
      },
      {
        name: 'explore',
        separator: true,
        list: [
          {
            name: 'faq',
            to: 'faq',
            icon: 'mso-quiz',
          },
          {
            name: 'helpAndSupport',
            href: 'https://discord.gg/u7fQdqQt8c',
            icon: 'mso-error',
          },
        ],
      },
      {
        name: '',
        separator: false,
        list: [
          {
            name: 'logout',
            to: 'login',
            icon: 'mso-logout',
          },
        ],
      },
    ]
 

const isShown = ref(false)



</script>

<style lang="scss">
.profile-dropdown {
  cursor: pointer;

  &__content {
    .menu-item:hover {
      background: var(--hover-color);
    }
  }

  &__anchor {
    display: inline-block;
  }
}
</style>
