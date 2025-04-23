<template>
  <div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
      <header class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Payroll Management</h1>
        <p class="mt-2 text-sm text-gray-600">Manage and calculate payroll for all employees</p>
      </header>

      <div class="mb-6 flex justify-end">
        <button
          @click="calculateAllPayrolls"
          :disabled="loading"
          class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
        >
          <span v-if="loading" class="mr-2">
            <span class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin inline-block"></span>
          </span>
          Calculate All Payrolls
        </button>
      </div>

      <EmployeePayrollList :employees="employees" />
    </div>

    <div v-if="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-xl text-center">
        <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-gray-700">Calculating payrolls...</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useToast } from 'vuestic-ui'
import EmployeePayrollList from './components/EmployeePayrollList.vue'

const { init: toast } = useToast()

const employees = ref([])
const loading = ref(false)
  
const calculateAllPayrolls = async () => {
  try {
    // loading.value = true
    const response = await axios.get(`${import.meta.env.VITE_APP_API_URL}/api/calculPayroll`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('access_token')}`
      }
    })
    console.log('All payrolls:', response.data)
    toast({
      message: 'All payrolls calculated successfully',
      color: 'success'
    })
    employees.value = response.data.payrolls
   } catch (error) {
    console.error('Error calculating payrolls:', error)
    toast({
      message: 'Failed to calculate payrolls',
      color: 'danger'
    })
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  calculateAllPayrolls()
})
</script>
