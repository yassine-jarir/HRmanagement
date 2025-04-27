<template>
  <div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
      <header class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Welcome, {{ user?.name }}</h1>
        <p class="mt-2 text-sm text-gray-600">Here's your current statistics and overview</p>
      </header>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center justify-between">
            <h3 class="text-gray-500 text-sm font-medium">Hours & Earnings</h3>
            <div class="bg-blue-100 p-3 rounded-full">
              <i class="fas fa-clock text-blue-600"></i>
            </div>
          </div>
          <div class="mt-4">
            <p class="text-2xl font-bold text-gray-900">{{ stats.hoursSalary?.totalHours || 0 }} H</p>
            <p class="text-sm text-gray-500 mt-1">Hours Worked This Month</p>
          </div>
          <div class="mt-4">
            <p class="text-2xl font-bold text-green-600">${{ stats.hoursSalary?.salary || 0 }}</p>
            <p class="text-sm text-gray-500 mt-1">Earnings This Month</p>
          </div>
        </div>


        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center justify-between">
            <h3 class="text-gray-500 text-sm font-medium">Tasks Overview</h3>
            <div class="bg-purple-100 p-3 rounded-full">
              <i class="fas fa-tasks text-purple-600"></i>
            </div>
          </div>
          <div class="mt-4">
            <p class="text-2xl font-bold text-gray-900">{{ stats.tasks?.total || 0 }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Assigned Tasks</p>
          </div>
          <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
              <p class="text-lg font-semibold text-green-600">{{ stats.tasks?.completed || 0 }}</p>
              <p class="text-sm text-gray-500">Completed</p>
            </div>
            <div>
              <p class="text-lg font-semibold text-blue-600">{{ stats.tasks?.active || 0 }}</p>
              <p class="text-sm text-gray-500">In Progress</p>
            </div>
            <div>
              <p class="text-lg font-semibold text-blue-600">{{ stats.tasks?.to_do || 0 }}</p>
              <p class="text-sm text-gray-500">To Do</p>
            </div>
          </div>
        </div>


        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center justify-between">
            <h3 class="text-gray-500 text-sm font-medium">Leave Requests</h3>
            <div class="bg-yellow-100 p-3 rounded-full">
              <i class="fas fa-calendar text-yellow-600"></i>
            </div>
          </div>
          <div class="mt-4">
            <p class="text-2xl font-bold text-gray-900">{{ stats.leaves?.total_leaves || 0 }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Leave Requests</p>
          </div>
          <div class="grid grid-cols-3 gap-2 mt-4">
            <div>
              <p class="text-lg font-semibold text-yellow-600">{{ stats.leaves?.pending || 0 }}</p>
              <p class="text-sm text-gray-500">Pending</p>
            </div>
            <div>
              <p class="text-lg font-semibold text-green-600">{{ stats.leaves?.approved || 0 }}</p>
              <p class="text-sm text-gray-500">Approved</p>
            </div>
            <div>
              <p class="text-lg font-semibold text-red-600">{{ stats.leaves?.rejected || 0 }}</p>
              <p class="text-sm text-gray-500">Rejected</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'


const loading = ref(true)
const stats = ref({
  hoursSalary: null,
  tasks: null,
  leaves: null
})

const user = JSON.parse(localStorage.getItem('user'))

const fetchStats = async () => {
  try {
    loading.value = true
    const [hoursSalaryRes, tasksRes, leavesRes] = await Promise.all([
      axios.get(`${import.meta.env.VITE_APP_API_URL}/api/employee/stats/hoursSalary`, {
        headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
      }),
      axios.get(`${import.meta.env.VITE_APP_API_URL}/api/employee/stats/tasks`, {
        headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
      }),
      axios.get(`${import.meta.env.VITE_APP_API_URL}/api/employee/stats/leaves`, {
        headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
      })
    ])

    stats.value = {
      hoursSalary: hoursSalaryRes.data,
      tasks: tasksRes.data.tasks,
      leaves: leavesRes.data
    }


  } catch (error) {
    console.error('Error fetching stats:', error)
  } finally {
    loading.value = false
  }
}


onMounted(() => {
  fetchStats()
})

</script>