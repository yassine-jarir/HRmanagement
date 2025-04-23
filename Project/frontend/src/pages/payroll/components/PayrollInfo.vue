<template>
  <div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-semibold">Payroll Information</h2>

      <div class="flex items-center gap-4">
        <!-- Date Range Filter -->
        <div class="flex items-center space-x-2">
          <div>
            <label class="block text-sm text-gray-500">From</label>
            <input 
              type="date" 
              v-model="dateRange.from"
              class="block w-40 px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          <div>
            <label class="block text-sm text-gray-500">To</label>
            <input 
              type="date" 
              v-model="dateRange.to"
              class="block w-40 px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
        </div>

        <button 
          @click="calculatePayroll"
          :disabled="loading"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2 h-[42px] mt-6"
        >
          <span v-if="loading" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
          Calculate Payroll
        </button>
      </div>
    </div>

    <div v-if="payroll" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <!-- Hours Worked -->
      <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="text-sm font-medium text-gray-500 mb-1">Hours Worked</h3>
        <p class="text-2xl font-bold text-gray-900">{{ payroll.hours_worked }}h</p>
        <p class="text-sm text-gray-500 mt-1">Current Period</p>
      </div>

      <!-- Rate per Hour -->
      <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="text-sm font-medium text-gray-500 mb-1">Rate per Hour</h3>
        <p class="text-2xl font-bold text-gray-900">$20.00</p>
        <p class="text-sm text-gray-500 mt-1">Standard Rate</p>
      </div>

      <!-- Total Salary -->
      <div class="bg-blue-50 p-4 rounded-lg">
        <h3 class="text-sm font-medium text-blue-600 mb-1">Total Salary</h3>
        <p class="text-2xl font-bold text-blue-900">${{ payroll.salary.toFixed(2) }}</p>
        <p class="text-sm text-blue-600 mt-1">Payment Date: {{ formatDate(payroll.payment_date) }}</p>
      </div>
    </div>

    <!-- Payroll History -->
    <div class="mt-8">
      <h3 class="text-lg font-medium mb-4">Payroll History</h3>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hours Worked</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-if="payroll" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">{{ formatDate(payroll.payment_date) }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ payroll.hours_worked }}h</td>
              <td class="px-6 py-4 whitespace-nowrap">${{ payroll.salary.toFixed(2) }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Calculated
                </span>
              </td>
            </tr>
            <tr v-if="!payroll">
              <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                No payroll records found for the selected period
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div v-if="!payroll && !loading" class="text-center py-8 text-gray-500">
      Select a date range and click "Calculate Payroll" to see your pay period information
    </div>

    <div v-if="loading" class="text-center py-8 text-gray-500">
      Calculating payroll information...
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import { useToast } from 'vuestic-ui'

const { init: toast } = useToast()

const payroll = ref(null)
const loading = ref(false)
const dateRange = ref({
  from: new Date().toISOString().split('T')[0], 
  to: new Date().toISOString().split('T')[0]
})

const calculatePayroll = async () => {
  try {
    // loading.value = true
    const response = await axios.get(`${import.meta.env.VITE_APP_API_URL}/api/calculPayroll`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('access_token')}`
      },
      params: {
        from_date: dateRange.value.from,
        to_date: dateRange.value.to
      }
    })
    console.log(response.data);
    
    payroll.value = response.data.payroll
    toast({
      message: 'Payroll calculated successfully',
      color: 'success'
    })
  } catch (error) {
    console.error('Error calculating payroll:', error)
    toast({
      message: 'Failed to calculate payroll',
      color: 'danger'
    })
  } finally {
    loading.value = false
  }
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString()
}

 watch(dateRange, () => {
   payroll.value = null
}, { deep: true })
</script>