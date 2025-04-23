<template>
    <div class="profile-page min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-12 px-4">
      <div class="max-w-6xl mx-auto">
        <!-- Profile Header Card -->
        <VaCard class="header-card mb-8 overflow-hidden">
          <div class="relative h-48 bg-gradient-to-r from-primary to-secondary">
            <div class="absolute -bottom-20 left-8 flex items-end space-x-6">
              <div class="relative">
                <div class="w-32 h-32 rounded-xl overflow-hidden border-4 border-white shadow-lg">
                  <VaAvatar
                    :src="profileData.profile_picture || ''"
                    :text="profileData.name ? profileData.name[0] : ''"
                    size="large"
                    class="w-full h-full"
                    color="primary"
                  />
                </div>
              </div>
              <div class="mb-6">
                <h1 class="text-3xl font-bold text-white">{{ profileData.name }}</h1>
                <p class="text-white/80">{{ profileData.position }}</p>
              </div>
            </div>
          </div>
          <div class="h-20"></div>
        </VaCard>
  
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
                    <p class="text-sm text-gray-500">Birth Date</p>
                    <p class="font-medium">{{ profileData.date_of_birth }}</p>
                  </div>
                </div>
              </div>
            </VaCardContent>
          </VaCard>
  
          <!-- Work Info Card -->
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
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  
  // Use reactive references
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
  
  onMounted(async () => {
    try {
      const profileRes = await axios.get(`${import.meta.env.VITE_APP_API_URL}/api/profile`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('access_token')}`
        }
      })
      

      profileData.value = { ...profileData.value, ...profileRes.data.employee[0] }
      console.log(profileData.value.name);
  
    } catch (error) {
      console.error('Error fetching profile data:', error)
    }
  })
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
  </style>
  