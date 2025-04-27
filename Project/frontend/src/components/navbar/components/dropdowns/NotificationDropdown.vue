<template>
  <VaDropdown :offset="[13, 0]" class="notification-dropdown" stick-to-edges :close-on-content-click="false">
    <template #anchor>
      <VaButton preset="secondary" color="textPrimary" class="notification-button">
        <VaBadge overlap>
           <template v-if="unreadNotifications.length > 0">
            <span :class="['notification-count', { 'has-unread': unreadNotifications.length > 0 }]">
              {{ unreadNotifications.length }}+
            </span>
          </template>
          <VaIconNotification class="notification-dropdown__icon" />
        </VaBadge>
      </VaButton>
    </template>

    <VaDropdownContent class="h-full sm:max-w-[420px] sm:h-auto notification-content">
      <section class="notification-list-container">
        <div class="notification-header">
          <h3 class="text-lg font-medium">Notifications</h3>
        </div>
        
        <div class="notification-scrollable">
          <VaList class="space-y-1">
            <template v-for="(item, index) in notifications" :key="item.id">
              <VaListItem
                class="text-base notification-item"
                @click="markAsRead(item.id)"
                :class= "{ 'unread': !item.read_at } "
              >
                <VaListItemSection icon class="mx-0 p-0">
                  <VaIcon :name="item.icon" color="secondary" />
                </VaListItemSection>
                <VaListItemSection>
                  {{ item.message }}
                </VaListItemSection>
                <VaListItemSection icon class="mx-1">
                  {{ item.updated_at }}
                </VaListItemSection>
              </VaListItem>
              <VaListSeparator v-if="item.separator && index !== notifications.length - 1" class="mx-3" />
            </template>
          </VaList>
        </div>

        <div class="notification-footer">
          <VaButton preset="primary" class="w-full view-all-btn" @click="displayAllNotifications = !displayAllNotifications" >
            {{ displayAllNotifications ? t('notifications.less') : t('notifications.all') }}
          </VaButton>
        </div>
      </section>
    </VaDropdownContent>
  </VaDropdown>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useI18n } from 'vue-i18n'
import VaIconNotification from '../../../icons/VaIconNotification.vue'
import { useRouter } from 'vue-router'
 
const router = useRouter()

const { t } = useI18n()

 const displayAllNotifications = ref(false)

const notifications = ref([])

const unreadNotifications = computed(() => {
  return notifications.value.filter(notification => !notification.read_at)
})

const fetchNotifications = async () => {
  try {
    const response = await fetch(`${import.meta.env.VITE_APP_API_URL}/api/notifications`, {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('access_token')}`
      }
    })
    const data = await response.json()

    notifications.value = data.map((item) => {
       if (item.data.leave_request && item.data.leave_type) {
         return {
          message: `New leave request: ${item.data.leave_type}`,
          icon: 'event_note', 
          id: item.id,
          updateTimestamp: new Date(item.created_at).toLocaleString(),
          read_at: item.read_at,
        }
      } else {
        return {
          message:  `New Task : ${item.data.task_name}`,
          icon: item.data.icon || 'notification_important',
          id: item.id,
          updateTimestamp: new Date(item.created_at).toLocaleString(),
          read_at: item.read_at,
        }
      }
    })
  } catch (error) {
    console.error('Error fetching notifications:', error)
  }
}


const markAsRead = async (notificationId) => {
  
  try {
    const response = await fetch(`${import.meta.env.VITE_APP_API_URL}/api/notifications/${notificationId}/mark-as-read`, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
        'Content-Type': 'application/json',
      },
    })

    const data = await response.json()

    if (response.ok) {
      const notification = notifications.value.find((notif) => notif.id === notificationId)
      if (notification) {
        notification.read_at = new Date().toLocaleString() 
      }
      console.log(data.message)
      const user = await JSON.parse(localStorage.getItem('user')) 
      if (user.role === 'admin') {
        router.push({name : 'leaveRequests'})
      }else if(user.role === 'employee'){
        router.push({name : 'employee-tasks'})

      }
    } else {
      console.error('Failed to mark notification as read:', data.message)
    }
  } catch (error) {
    console.error('Error marking notification as read:', error)
  }
}

onMounted(() => {
  fetchNotifications()
})
</script>

<style lang="scss" scoped>
.notification-dropdown {
  cursor: pointer;

  .notification-button {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    
    &:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
  }

  .notification-dropdown__icon {
    position: relative;
    display: flex;
    align-items: center;
    transition: color 0.2s ease;
  }

  .va-dropdown__anchor {
    display: inline-block;
  }

  .notification-count {
    font-size: 0.875rem;
    font-weight: 600;
    margin-left: 0.5rem;
    display: inline-block;
    color: transparent; /* Make the number hidden by default */
    background-color: rgba(255, 0, 0, 0.2); /* Light red background */
    border-radius: 50%;
    padding: 0.25rem 0.5rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }

  .notification-count.has-unread {
    color: #f44336; /* Modern red color for unread notifications */
    background-color: rgba(255, 0, 0, 0.1); /* Light red background */
    padding: 0.25rem 0.5rem;
    display: inline-block;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.15); /* Subtle shadow to stand out */
    font-size: 0.875rem;
  }
}

.notification-content {
  border-radius: 8px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.notification-list-container {
  display: flex;
  flex-direction: column;
  max-height: 500px;
}

.notification-header {
  padding: 1rem;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.notification-scrollable {
  overflow-y: auto;
  max-height: 320px;
  padding: 0.5rem 1rem;
  scrollbar-width: thin;
  
  &::-webkit-scrollbar {
    width: 6px;
  }
  
  &::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }
  
  &::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
    
    &:hover {
      background: #a1a1a1;
    }
  }
}

.notification-footer {
  padding: 1rem;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
}

.notification-item {
  position: relative;
  border-radius: 6px;
  padding: 0.75rem;
  margin-bottom: 0.5rem;
  transition: all 0.2s ease;
  cursor: pointer; /* Added cursor pointer */
  
  &:hover {
    background-color: rgba(0, 0, 0, 0.03);
    transform: translateX(2px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }
  
  &.unread {
    background-color: rgba(173, 216, 230, 0.3); /* Light blue for unread */
    
    &:hover {
      background-color: rgba(173, 216, 230, 0.5); /* Darker light blue on hover */
    }
    
    &::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 4px;
      background-color: #4a90e2;
      border-top-left-radius: 6px;
      border-bottom-left-radius: 6px;
    }
  }
}

.view-all-btn {
  transition: all 0.2s ease;
  border-radius: 6px;
  cursor: pointer;
  
  &:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
  }
}
</style>