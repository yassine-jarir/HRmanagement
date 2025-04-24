<template>
  <div class="profile-page min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-12 px-4">
    <div class="max-w-6xl mx-auto">
       <VaCard class="header-card mb-8 overflow-hidden">
        <div class="relative h-48 bg-gradient-to-r from-primary to-secondary">
          <div class="absolute -bottom-20 left-8 flex items-end space-x-6">
            <div class="relative">
              <div class="w-32 h-32 rounded-xl overflow-hidden border-4 border-white shadow-lg">
                <!-- <VaAvatar
                  :src="profileData.profile_picture || ''"
                  :text="profileData.name ? profileData.name[0] : ''"
                  size="large"
                  class="w-full h-full"
                  color="primary"
                /> -->
              </div>
            </div>
            <div class="mb-6">
              <h1 class="text-3xl font-bold text-white">{{ profileData.name }}</h1>
              <!-- <p class="text-white/80">{{ profileData.position }}</p> -->
            </div>
          </div>
        </div>
        <div class="h-20"></div>
      </VaCard>

      <div class="flex justify-end gap-4 mb-6">
        <button 
          @click="showProfileModal = true"
          class="bg-primary hover:bg-primary/90 text-white font-semibold py-2 px-4 rounded-lg shadow-sm flex items-center gap-2"
        >
          <i class="fas fa-user-edit"></i>
          Update Profile
        </button>
        <button 
          @click="showPasswordModal = true"
          class="bg-secondary hover:bg-secondary/90 text-white font-semibold py-2 px-4 rounded-lg shadow-sm flex items-center gap-2"
        >
          <i class="fas fa-key"></i>
          Change Password
        </button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
         <VaCard class="info-section-card transform hover:-translate-y-1 transition-all duration-300">
          <VaCardTitle>
            <div class="flex items-center space-x-2">
              <VaIcon name="person" class="text-primary text-xl" />
              <span>Personal Information</span>
            </div>
          </VaCardTitle>
          <VaCardContent>
            <div class="space-y-4">
              <div class="info-row">
                <VaIcon name="email" class="text-primary" />
                <div>
                  <p class="text-sm text-gray-500">Email</p>
                  <p class="font-medium">{{ profileData.email }}</p>
                </div>
              </div>
              <div class="info-row">
                <VaIcon name="phone" class="text-primary" />
                <div>
                  <p class="text-sm text-gray-500">Phone</p>
                  <p class="font-medium">{{ profileData.phone || 'Not set' }}</p>
                </div>
              </div>
              <div class="info-row">
                <VaIcon name="cake" class="text-primary" />
                <div>
                  <p class="text-sm text-gray-500">Name</p>
                  <p class="font-medium">{{ profileData.name }}</p>
                </div>
              </div>
            </div>
          </VaCardContent>
        </VaCard>

         <VaCard class="info-section-card transform hover:-translate-y-1 transition-all duration-300">
          <VaCardTitle>
            <div class="flex items-center space-x-2">
              <VaIcon name="business" class="text-primary text-xl" />
              <span>Work Information</span>
            </div>
          </VaCardTitle>
          <VaCardContent>
            <div class="space-y-4">
              <div class="info-row">
                <VaIcon name="domain" class="text-primary" />
                <div>
                  <p class="text-sm text-gray-500">Department</p>
                  <p class="font-medium">{{ profileData.department || 'Not set' }}</p>
                </div>
              </div>
              <div class="info-row">
                <VaIcon name="calendar_today" class="text-primary" />
                <div>
                  <p class="text-sm text-gray-500">Role</p>
                  <p class="font-medium">{{ profileData.role }}</p>
                </div>
              </div>
            </div>
          </VaCardContent>
        </VaCard>

         <VaCard class="info-section-card transform hover:-translate-y-1 transition-all duration-300">
          <VaCardTitle>
            <div class="flex items-center space-x-2">
              <VaIcon name="location_on" class="text-primary text-xl" />
              <span>Location</span>
            </div>
          </VaCardTitle>
          <VaCardContent>
            <div class="space-y-4">
              <div class="info-row">
                <VaIcon name="home" class="text-primary" />
                <div>
                  <p class="text-sm text-gray-500">Address</p>
                  <p class="font-medium">{{ profileData.address || 'Not set' }}</p>
                </div>
              </div>
            </div>
          </VaCardContent>
        </VaCard>
      </div>

      <!-- Profile Update Modal -->
      <div v-if="showProfileModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg w-full max-w-md relative">
          <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Update Profile</h3>
            <button @click="showProfileModal = false" class="text-gray-500 hover:text-gray-700">
              <i class="fas fa-times"></i>
            </button>
          </div>

          <div class="p-4">
            <form @submit.prevent="updateProfile" class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input
                  v-model="editForm.name"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                  required
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                  v-model="editForm.email"
                  type="email"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                  required
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input
                  v-model="editForm.phone"
                  type="tel"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea
                  v-model="editForm.address"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                  rows="3"
                ></textarea>
              </div>

              <div class="flex justify-end gap-3 mt-6">
                <button
                  type="button"
                  @click="showProfileModal = false"
                  class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md font-medium"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  class="px-4 py-2 bg-primary text-white hover:bg-primary/90 rounded-md font-medium"
                  :disabled="loading"
                >
                  {{ loading ? 'Saving...' : 'Save Changes' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Password Update Modal -->
      <div v-if="showPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg w-full max-w-md relative">
          <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Change Password</h3>
            <button @click="showPasswordModal = false" class="text-gray-500 hover:text-gray-700">
              <i class="fas fa-times"></i>
            </button>
          </div>

          <div class="p-4">
            <form @submit.prevent="updatePassword" class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input
                  v-model="passwordForm.password"
                  type="password"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                  required
                  minlength="6"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                <input
                  v-model="passwordForm.password_confirmation"
                  type="password"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                  required
                />
              </div>

              <div class="flex justify-end gap-3 mt-6">
                <button
                  type="button"
                  @click="showPasswordModal = false"
                  class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md font-medium"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  class="px-4 py-2 bg-secondary text-white hover:bg-secondary/90 rounded-md font-medium"
                  :disabled="loading"
                >
                  {{ loading ? 'Updating...' : 'Update Password' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useToast } from 'vuestic-ui'

const { init: toast } = useToast()
const loading = ref(false)
const showProfileModal = ref(false)
const showPasswordModal = ref(false)

const profileData = ref({
  name: '',
  email: '',
  phone: '',
  address: '',
  profile_picture: '',
  date_of_birth: '',
  department: '',
  position: '',
  hire_date: ''
})

const editForm = ref({
  name: '',
  email: '',
  phone: '',
  address: ''
})

const passwordForm = ref({
  password: '',
  password_confirmation: ''
})

onMounted(async () => {
  try {
    const response = await axios.get(`${import.meta.env.VITE_APP_API_URL}/api/profile`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('access_token')}`
      }
    })
    profileData.value = { ...profileData.value, ...response.data.employee }
    editForm.value = {
      name: profileData.value.name,
      email: profileData.value.email,
      phone: profileData.value.phone || '',
      address: profileData.value.address || ''
    }
  } catch (error) {
    console.error('Error fetching profile data:', error)
    toast({
      message: 'Failed to load profile data',
      color: 'danger'
    })
  }
})

const updateProfile = async () => {
  try {
    loading.value = true
    const response = await axios.put(
      `${import.meta.env.VITE_APP_API_URL}/api/employee/profile`,
      editForm.value,
      {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('access_token')}`,
          'Content-Type': 'application/json'
        }
      }
    )

    profileData.value = { ...profileData.value, ...response.data.employee }
    showProfileModal.value = false
    toast({
      message: 'Profile updated successfully',
      color: 'success'
    })
  } catch (error) {
    console.error('Error updating profile:', error)
    toast({
      message: error.response?.data?.message || 'Error updating profile',
      color: 'danger'
    })
  } finally {
    loading.value = false
  }
}

const updatePassword = async () => {
  if (passwordForm.value.password !== passwordForm.value.password_confirmation) {
    toast({
      message: 'Passwords do not match',
      color: 'danger'
    })
    return
  }

  try {
    loading.value = true
    await axios.put(
      `${import.meta.env.VITE_APP_API_URL}/api/employee/profile`,
      {
        password: passwordForm.value.password,
        password_confirmation: passwordForm.value.password_confirmation
      },
      {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('access_token')}`,
          'Content-Type': 'application/json'
        }
      }
    )

    showPasswordModal.value = false
    passwordForm.value = {
      password: '',
      password_confirmation: ''
    }
    toast({
      message: 'Password updated successfully',
      color: 'success'
    })
  } catch (error) {
    console.error('Error updating password:', error)
    toast({
      message: error.response?.data?.message || 'Error updating password',
      color: 'danger'
    })
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.profile-page {
  min-height: 100vh;
}

.header-card {
  border-radius: 1rem;
  overflow: hidden;
  transition: all 0.3s ease;
}

.header-card:hover {
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.info-section-card {
  border-radius: 1rem;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.info-row {
  display: flex;
  align-items: center;
  gap: 1rem; 
  padding: 0.75rem;
  border-radius: 0.5rem;
  background: rgba(var(--va-primary-rgb), 0.05);
}

.info-row:hover {
  background: rgba(var(--va-primary-rgb), 0.1);
}

@media (max-width: 768px) {
  .header-card {
    border-radius: 0.75rem;
  }

  .info-section-card {
    border-radius: 0.75rem;
  }
}

.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
</style>
