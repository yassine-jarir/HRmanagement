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
            <p class="text-2xl font-bold text-gray-900">{{ stats.hoursSalary?.hours_worked || 0 }}h</p>
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
              <p class="text-lg font-semibold text-blue-600">{{ stats.tasks?.in_progress || 0 }}</p>
              <p class="text-sm text-gray-500">In Progress</p>
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
            <p class="text-2xl font-bold text-gray-900">{{ stats.leaves?.total || 0 }}</p>
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

 
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Task Progress</h3>
        <div class="relative" style="height: 300px">
          <div v-if="loading" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
          </div>
          <canvas ref="taskChartRef"></canvas>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import axios from 'axios'
import Chart from 'chart.js/auto'

const loading = ref(true)
const stats = ref({
  hoursSalary: null,
  tasks: null,
  leaves: null
})
const taskChartRef = ref(null)
let taskChart = null
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
      tasks: tasksRes.data,
      leaves: leavesRes.data
    }

    updateTaskChart()
  } catch (error) {
    console.error('Error fetching stats:', error)
  } finally {
    loading.value = false
  }
}

const initTaskChart = () => {
  if (taskChartRef.value && !taskChart) {
    taskChart = new Chart(taskChartRef.value, {
      type: 'doughnut',
      data: {
        labels: ['Completed', 'In Progress', 'To Do'],
        datasets: [{
          data: [0, 0, 0],
          backgroundColor: ['#10B981', '#3B82F6', '#9CA3AF']
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    })
  }
}

const updateTaskChart = () => {
  if (taskChart && stats.value.tasks) {
    taskChart.data.datasets[0].data = [
      stats.value.tasks.completed || 0,
      stats.value.tasks.in_progress || 0,
      stats.value.tasks.total - (stats.value.tasks.completed + stats.value.tasks.in_progress) || 0
    ]
    taskChart.update()
  }
}

onMounted(() => {
  fetchStats()
  initTaskChart()
})

onUnmounted(() => {
  if (taskChart) {
    taskChart.destroy()
  }
})
</script>