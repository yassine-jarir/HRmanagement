<template>
  <div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-6xl mx-auto">
       <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
          <div>
            <h5 class="text-xl font-semibold">
              Timesheet <small class="text-gray-500">{{ currentDate }}</small>
            </h5>
          </div>
          <div class="text-2xl font-mono">{{ currentTime }}</div>
        </div>
        
        <div class="text-center my-6">
          <div class="text-3xl font-bold text-gray-700 mb-2">
            {{ hoursWorked }} Hours
          </div>
          <div class="flex justify-center mt-6">
            <button 
              v-if="!isWorking"
              @click="showStartWorkModal"
              class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors"
            >
              Clock In
            </button>
            <button 
              v-else
              @click="endWork"
              class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
            >
              Clock Out
            </button>
          </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-4">
          <div class="text-center p-4 bg-gray-50 rounded-lg">
            <div class="text-sm text-gray-500">Scheduled</div>
            <div class="text-lg font-semibold">8:00 hrs</div>
          </div>
          <div class="text-center p-4 bg-gray-50 rounded-lg">
            <div class="text-sm text-gray-500">Today</div>
            <div class="text-lg font-semibold">{{ hoursWorked }} hrs</div>
          </div>
          <div class="text-center p-4 bg-gray-50 rounded-lg">
            <div class="text-sm text-gray-500">Balance</div>
            <div class="text-lg font-semibold">{{ 8 - parseFloat(hoursWorked) }} hrs</div>
          </div>
        </div>
      </div>

      <!-- Start Work Modal -->
      <VaModal v-model="showModal" :title="'Start Work'" hide-default-actions>
        <div class="p-4">
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Select Task</label>
            <select 
              v-model="selectedTaskId"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
            >
              <option value="" disabled>Choose a task</option>
              <option v-for="task in tasks" :key="task.id" :value="task.id">
                {{ task.task_name }}
              </option>
            </select>
          </div>
          
          <div class="flex justify-end space-x-3">
            <VaButton flat @click="showModal = false">Cancel</VaButton>
            <VaButton 
              @click="handleStartWork"
              :disabled="!selectedTaskId"
              color="primary"
            >
              Start Work
            </VaButton>
          </div>
        </div>
      </VaModal>

      <!-- Timesheet Table Section -->
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="pointage in pointages" :key="pointage.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">{{ formatDate(pointage.start_time) }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ formatTime(pointage.start_time) }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ pointage.end_time ? formatTime(pointage.end_time) : '---' }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                {{ pointage.end_time ? calculateDuration(pointage.start_time, pointage.end_time) : '---' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">{{ pointage.tasks?.task_name || '---' }}</td>
            </tr>
            <tr v-if="pointages.length === 0">
              <td colspan="5" class="px-6 py-4 text-center text-gray-500">No time entries found</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import { useToast } from 'vuestic-ui'

const { init: toast } = useToast()

const pointages = ref([])
const tasks = ref([])
const isWorking = ref(false)
const currentSession = ref(null)
const selectedTaskId = ref('')
const userStorage = JSON.parse(localStorage.getItem('user'))
const currentTime = ref('')
const showModal = ref(false)
const hoursWorked = ref('0.0')

const currentDate = computed(() => {
  return new Date().toLocaleDateString('en-US', {
    month: '2-digit',
    day: '2-digit',
    year: 'numeric'
  })
})

const currentTask = computed(() => {
  if (!currentSession.value?.task_id) return null
  return tasks.value.find(task => task.id === currentSession.value.task_id)
})

const fetchTasks = async () => {
  try {
    const response = await axios.get(`${import.meta.env.VITE_APP_API_URL}/api/taskss`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('access_token')}`
      }
    })
    tasks.value = response.data
  } catch (error) {
    console.error('Error fetching tasks:', error)
    toast({
      message: 'Failed to load tasks',
      color: 'danger'
    })
  }
}

const fetchPointages = async () => {
  try {
    const response = await axios.get(`${import.meta.env.VITE_APP_API_URL}/api/emplyeePoint`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('access_token')}`
      }
    })
    pointages.value = response.data.pointages
    // Check if there's an ongoing session
    const activeSession = pointages.value.find(p => !p.end_time)
    if (activeSession) {
      isWorking.value = true
      currentSession.value = activeSession
    }
  } catch (error) {
    toast({
      message: 'Failed to load timesheet',
      color: 'danger'
    })
    console.error('Error fetching pointages:', error)
  }
}

const updateClock = () => {
  const now = new Date()
  currentTime.value = now.toLocaleTimeString('en-US', {
    hour12: false,
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
  })
}

const showStartWorkModal = () => {
  showModal.value = true
}

const handleStartWork = async () => {
  await startWork()
  showModal.value = false
}

const updateHoursWorked = () => {
  if (currentSession.value && !currentSession.value.end_time) {
    const start = new Date(currentSession.value.start_time)
    const now = new Date()
    const hours = (now - start) / (1000 * 60 * 60)
    hoursWorked.value = hours.toFixed(1)
  } else {
    hoursWorked.value = '0.0'
  }
}

const startWork = async () => {
  if (!selectedTaskId.value) {
    toast({
      message: 'Please select a task first',
      color: 'warning'
    })
    return
  }

  try {
    const response = await axios.post(`${import.meta.env.VITE_APP_API_URL}/api/startWork`, {
      task_id: selectedTaskId.value,
      employee_id: userStorage.id
    }, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('access_token')}`
      }
    })
    isWorking.value = true
    currentSession.value = response.data.pointage
    selectedTaskId.value = ''
    console.log(JSON.parse(localStorage.getItem('user').id))
    await fetchPointages()
    toast({
      message: 'Successfully clocked in',
      color: 'success'
    })
  } catch (error) {
    toast({
      message: 'Failed to clock in',
      color: 'danger'
    })
    console.error('Error starting work:', error)
  }
}

const endWork = async () => {
  try {
    await axios.post(`${import.meta.env.VITE_APP_API_URL}/api/endWork`, {}, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('access_token')}`
      }
    })
    isWorking.value = false
    currentSession.value = null
    hoursWorked.value = '0.0'
    await fetchPointages()
    toast({
      message: 'Successfully clocked out',
      color: 'success'
    })
  } catch (error) {
    toast({
      message: 'Failed to clock out',
      color: 'danger'
    })
    console.error('Error ending work:', error)
  }
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString()
}

const formatTime = (dateString) => {
  return new Date(dateString).toLocaleTimeString()
}

const formatDateTime = (dateString) => {
  return new Date(dateString).toLocaleString()
}

const calculateDuration = (startTime, endTime = null) => {
  const start = new Date(startTime)
  const end = endTime ? new Date(endTime) : new Date()
  const diff = Math.abs(end - start)
  const hours = Math.floor(diff / 3600000)
  const minutes = Math.floor((diff % 3600000) / 60000)
  return `${hours}h ${minutes}m`
}

onMounted(() => {
  fetchPointages()
  fetchTasks()

   updateClock()
  setInterval(updateClock, 1000)
  console.log(userStorage)
   setInterval(updateHoursWorked, 60000)  
})
</script>

<style scoped>
.bg-primary-dark {
  background-color: var(--va-primary-darken);
}
</style>