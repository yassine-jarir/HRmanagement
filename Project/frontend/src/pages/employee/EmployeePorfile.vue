<template>
  <div class="profile-page min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-5xl mx-auto">
      <!-- Main Profile Card -->
      <VaCard class="mb-6 shadow-sm hover:shadow-md transition-all duration-300">
        <div class="p-6">
          <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <!-- Profile Image -->
            <div class="relative">
              <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-white shadow-md bg-white">
                <img 
                  v-if="profileData.profile_image" 
                  :src="getImageUrl(profileData.profile_image)" 
                  alt="Profile Picture"
                  class="w-full h-full object-cover"
                />
                <div 
                  v-else 
                  class="w-full h-full bg-gray-100 flex items-center justify-center"
                >
                  <VaIcon name="person" size="large" class="text-gray-400" />
                </div>
              </div>
            </div>
            
            <!-- Profile Info -->
            <div class="flex-1">
              <h1 class="text-2xl font-bold text-gray-800">{{ profileData.name }}</h1>
              <p class="text-gray-500 mb-4">{{ profileData.department || 'No Department' }}</p>
              
              <div class="flex flex-wrap gap-4">
                <div class="flex items-center gap-2 text-gray-600">
                  <VaIcon name="email" size="small" class="text-primary" />
                  <span>{{ profileData.email }}</span>
                </div>
                <div class="flex items-center gap-2 text-gray-600">
                  <VaIcon name="phone" size="small" class="text-primary" />
                  <span>{{ profileData.phone || 'Not set' }}</span>
                </div>
                <div class="flex items-center gap-2 text-gray-600">
                  <VaIcon name="home" size="small" class="text-primary" />
                  <span>{{ profileData.address || 'Not set' }}</span>
                </div>
              </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex md:flex-col gap-3">
              <button 
                @click="showProfileModal = true"
                class="bg-primary hover:bg-primary/90 text-white font-medium py-2 px-4 rounded-lg shadow-sm flex items-center gap-2 text-sm"
              >
                <i class="fas fa-user-edit"></i>
                Edit Profile
              </button>
              <button 
                @click="showPasswordModal = true"
                class="bg-gray-700 hover:bg-gray-800 text-white font-medium py-2 px-4 rounded-lg shadow-sm flex items-center gap-2 text-sm"
              >
                <i class="fas fa-key"></i>
                Change Password
              </button>
            </div>
          </div>
        </div>
      </VaCard>

      <!-- Information Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Personal Information -->
        <VaCard class="info-card shadow-sm hover:shadow-md transition-all duration-300">
          <div class="p-5">
            <div class="flex items-center justify-between mb-4">
              <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <VaIcon name="person" class="text-primary" />
                <span>Personal Information</span>
              </h3>
              <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                <VaIcon name="contact_page" class="text-primary" />
              </div>
            </div>
            
            <div class="space-y-4">
              <div class="info-item">
                <p class="text-sm text-gray-500">Full Name</p>
                <p class="font-medium text-gray-800">{{ profileData.name }}</p>
              </div>
              <div class="info-item">
                <p class="text-sm text-gray-500">Email Address</p>
                <p class="font-medium text-gray-800">{{ profileData.email }}</p>
              </div>
              <div class="info-item">
                <p class="text-sm text-gray-500">Phone Number</p>
                <p class="font-medium text-gray-800">{{ profileData.phone || 'Not provided' }}</p>
              </div>
            </div>
          </div>
        </VaCard>

        <!-- Work Information -->
        <VaCard class="info-card shadow-sm hover:shadow-md transition-all duration-300">
          <div class="p-5">
            <div class="flex items-center justify-between mb-4">
              <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <VaIcon name="business" class="text-primary" />
                <span>Work Information</span>
              </h3>
              <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                <VaIcon name="work" class="text-primary" />
              </div>
            </div>
            
            <div class="space-y-4">
              <div class="info-item">
                <p class="text-sm text-gray-500">Department</p>
                <p class="font-medium text-gray-800">{{ profileData.department || 'Not specified' }}</p>
              </div>
              <div class="info-item">
                <p class="text-sm text-gray-500">Role</p>
                <p class="font-medium text-gray-800">Employee</p>
              </div>
              <div class="info-item">
                <p class="text-sm text-gray-500">Status</p>
                <div class="flex items-center gap-2">
                  <span class="w-2 h-2 rounded-full bg-green-500"></span>
                  <p class="font-medium text-gray-800">Active</p>
                </div>
              </div>
            </div>
          </div>
        </VaCard>

        <!-- Location Information -->
        <VaCard class="info-card shadow-sm hover:shadow-md transition-all duration-300">
          <div class="p-5">
            <div class="flex items-center justify-between mb-4">
              <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <VaIcon name="location_on" class="text-primary" />
                <span>Location</span>
              </h3>
              <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                <VaIcon name="home" class="text-primary" />
              </div>
            </div>
            
            <div class="space-y-4">
              <div class="info-item">
                <p class="text-sm text-gray-500">Address</p>
                <p class="font-medium text-gray-800">{{ profileData.address || 'Not provided' }}</p>
              </div>
              <div class="info-item">
                <p class="text-sm text-gray-500">Last Login</p>
                <p class="font-medium text-gray-800">Today</p>
              </div>
              <div class="info-item">
                <p class="text-sm text-gray-500">Time Zone</p>
                <p class="font-medium text-gray-800">UTC+00:00</p>
              </div>
            </div>
          </div>
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
              <!-- Profile Image Upload -->
              <div class="text-center mb-6">
                <div class="inline-block relative">
                  <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-primary mb-2 mx-auto">
                    <img 
                      v-if="imagePreview" 
                      :src="imagePreview" 
                      alt="Profile Preview" 
                      class="w-full h-full object-cover"
                    />
                    <img 
                      v-else-if="profileData.profile_image" 
                      :src="getImageUrl(profileData.profile_image)" 
                      alt="Current Profile" 
                      class="w-full h-full object-cover"
                    />
                    <div v-else class="w-full h-full flex items-center justify-center bg-gray-100">
                      <VaIcon name="person" size="large" class="text-gray-400" />
                    </div>
                  </div>
                  <label class="block text-sm font-medium text-primary cursor-pointer">
                    Change Photo
                    <input 
                      type="file" 
                      ref="fileInput" 
                      @change="handleImageUpload" 
                      accept="image/*" 
                      class="hidden"
                    />
                  </label>
                </div>
              </div>

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

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                <input
                  v-model="editForm.department"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                />
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <input
                  v-model="passwordForm.current_password"
                  type="password"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                  required
                />
              </div>

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
                  class="px-4 py-2 bg-gray-700 text-white hover:bg-gray-800 rounded-md font-medium"
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
const imagePreview = ref(null)
const selectedFile = ref(null)
const apiUrl = import.meta.env.VITE_APP_API_URL || ''

const profileData = ref({
  name: '',
  email: '',
  phone: '',
  address: '',
  department: '',
  profile_image: null
})

const editForm = ref({
  name: '',
  email: '',
  phone: '',
  address: '',
  department: ''
})

const passwordForm = ref({
  current_password: '',
  password: '',
  password_confirmation: ''
})

const getImageUrl = (imagePath) => {
  if (!imagePath) return ''
  return `${apiUrl}/storage/${imagePath}`
}

onMounted(async () => {
  try {
    const response = await axios.get(`${apiUrl}/api/profile`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('access_token')}`
      }
    })
    profileData.value = { ...profileData.value, ...response.data.employee }
    editForm.value = {
      name: profileData.value.name,
      email: profileData.value.email,
      phone: profileData.value.phone || '',
      address: profileData.value.address || '',
      department: profileData.value.department || ''
    }
  } catch (error) {
    console.error('Error fetching profile data:', error)
    toast({
      message: 'Failed to load profile data',
      color: 'danger'
    })
  }
})

const handleImageUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
     const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
  }
};

const updateProfile = async () => {
  try {
    loading.value = true;
 
    const payload = { 
      ...editForm.value, 
      profile_image: imagePreview.value ? imagePreview.value.split(',')[1] : null  
    };

    const response = await axios.put(
      `${apiUrl}/api/employee/profile`, 
      payload,
      {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('access_token')}`,
          'Content-Type': 'application/json',
        },
      }
    );

     profileData.value = { ...profileData.value, ...response.data.employee };

     selectedFile.value = null;
    imagePreview.value = null;

     showProfileModal.value = false;

     toast({
      message: 'Profile updated successfully',
      color: 'success',
    });
  } catch (error) {
    console.error('Error updating profile:', error);
    toast({
      message: error.response?.data?.message || 'Error updating profile',
      color: 'danger',
    });
  } finally {
    loading.value = false;
  }
};

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
      `${apiUrl}/api/employee/password`,
      {
        current_password: passwordForm.value.current_password,
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
      current_password: '',
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

.info-card {
  border-radius: 0.75rem;
  height: 100%;
  transition: all 0.3s ease;
}

.info-item {
  padding: 0.75rem;
  border-radius: 0.5rem;
  background: #f8fafc;
  transition: all 0.2s ease;
}

.info-item:hover {
  background: #f1f5f9;
  transform: translateY(-2px);
}

@media (max-width: 768px) {
  .info-card {
    margin-bottom: 1rem;
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