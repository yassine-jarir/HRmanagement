<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">HR Dashboard</h1>

     <div v-if="loading" class="text-center p-4">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
      <p class="mt-2 text-gray-600">Loading dashboard data...</p>
    </div>

     <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
      {{ error }}
    </div>

     <div v-if="!loading" class="grid grid-cols-1 md:grid-cols-3 gap-6">
       <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
          <h3 class="text-gray-500 text-sm font-medium">Total Employees</h3>
          <div class="bg-blue-100 p-3 rounded-full">
            <i class="fas fa-users text-blue-600"></i>
          </div>
        </div>
        <p class="text-3xl font-bold mt-4">{{ stats.total_employees || 0 }}</p>
      </div>

       <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
          <h3 class="text-gray-500 text-sm font-medium">Tasks</h3>
          <div class="bg-green-100 p-3 rounded-full">
            <i class="fas fa-tasks text-green-600"></i>
          </div>
        </div>
        <p class="text-3xl font-bold mt-4">{{ stats.tasks?.total || 0 }}</p>
        <div class="flex justify-between mt-2 text-sm">
          <span class="text-green-500">{{ stats.tasks?.active || 0 }} Active</span>
          <span class="text-blue-500">{{ stats.tasks?.completed || 0 }} Completed</span>
        </div>
      </div>

      <!-- Monthly Payroll Card -->
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
          <h3 class="text-gray-500 text-sm font-medium">Monthly Payroll</h3>
          <div class="bg-purple-100 p-3 rounded-full">
            <i class="fas fa-money-bill text-purple-600"></i>
          </div>
        </div>
        <p class="text-3xl font-bold mt-4">${{ stats.total_payroll || 0 }}</p>
        <p class="text-sm text-gray-500 mt-2">Current Month</p>
      </div>
    </div>

     <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
       <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Task Distribution</h3>
        <div class="flex items-center justify-center" style="height: 300px">
          <canvas ref="taskChartRef"></canvas>
        </div>
      </div>

       <PayrollChart />
    </div>
 
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import axios from 'axios'
import Chart from 'chart.js/auto'
import PayrollChart from './components/PayrollChart.vue'

const loading = ref(true)
const error = ref(null)
const stats = ref({})
const taskChartRef = ref(null)
 let taskChart = null

 

const fetchStats = async () => {
  try {
    loading.value = true
    error.value = null
    
    const token = localStorage.getItem('access_token')
    const { data } = await axios.get(`${import.meta.env.VITE_APP_API_URL}/api/dashboard-stats`, {
      headers: { Authorization: `Bearer ${token}` }
    })
    
    stats.value = data
    updateTaskChart()
  } catch (err) {
    console.error('Dashboard error:', err)
    error.value = 'Failed to load dashboard statistics. Please try again.'
  } finally {
    loading.value = false
  }
}

const initTaskChart = () => {
  if (taskChartRef.value && !taskChart) {
    taskChart = new Chart(taskChartRef.value, {
      type: 'doughnut',
      data: {
        labels: ['Active Tasks', 'Completed Tasks'],
        datasets: [{
          data: [0, 0],
          backgroundColor: ['#06b450', '#3B82F6'],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom'
          }
        },
        cutout: '70%'
      }
    })
  }
}

const updateTaskChart = () => {
  if (taskChart && stats.value.tasks) {
    taskChart.data.datasets[0].data = [
      stats.value.tasks.active || 0,
      stats.value.tasks.completed || 0
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
