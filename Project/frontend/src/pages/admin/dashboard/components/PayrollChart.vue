<template>
  <div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-4">Monthly Payroll Trends</h3>
    <div class="relative" style="height: 300px">
      <div v-if="loading" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
      </div>
      <canvas ref="chartRef"></canvas>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import axios from 'axios'
import Chart from 'chart.js/auto'

const loading = ref(true)
const chartRef = ref(null)
let chart = null

const API_URL = import.meta.env.VITE_APP_API_URL

const fetchPayrollData = async () => {
  try {
    loading.value = true
    const token = localStorage.getItem('access_token')
    const { data } = await axios.get(`${API_URL}/api/payroll-chart`, {
      headers: { Authorization: `Bearer ${token}` }
    })

    if (data.payroll_data) {
      updateChart(data.payroll_data)
    }
  } catch (error) {
    console.error('Failed to fetch payroll data:', error)
  } finally {
    loading.value = false
  }
}

const initChart = () => {
  if (chartRef.value && !chart) {
    chart = new Chart(chartRef.value, {
      type: 'line',
      data: {
        labels: [],
        datasets: [{
          label: 'Monthly Payroll',
          data: [],
          borderColor: '#8B5CF6',
          backgroundColor: 'rgba(139, 92, 246, 0.1)',
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: value => `$${new Intl.NumberFormat('en-US').format(value)}`
            }
          }
        }
      }
    })
  }
}

const updateChart = (payrollData) => {
  if (chart) {
    chart.data.labels = payrollData.map(item => item.month)
    chart.data.datasets[0].data = payrollData.map(item => item.total)
    chart.update()
  }
}

onMounted(() => {
  initChart()
  fetchPayrollData()
})

onUnmounted(() => {
  if (chart) {
    chart.destroy()
  }
})

defineExpose({
  refreshData: fetchPayrollData
})
</script>