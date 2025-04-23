<template>
  <div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-semibold">Time Tracking</h2>
      <div class="space-x-2">
        <div v-if="!isWorking" class="flex items-center gap-4">
          <select 
            v-model="selectedTaskId"
            class="block w-64 px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            required
          >
            <option value="" disabled>Select a task</option>
            <option v-for="task in tasks" :key="task.id" :value="task.id">
              {{ task.task_name }}
            </option>
          </select>
          <button 
            @click="startWork"
            :disabled="!selectedTaskId"
            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            Start Work
          </button>
        </div>
        <button 
          v-else
          @click="endWork"
          class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
        >
          End Work
        </button>
      </div>
    </div>

    <!-- Current Status -->
    <div v-if="isWorking" class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
      <h3 class="font-medium text-blue-900 mb-2">Current Session</h3>
      <p class="text-blue-800">
        Started at: {{ formatDateTime(currentSession.start_time) }}
        <br>
        Task: {{ currentTask?.task_name || 'Unknown Task' }}
        <br>
        Duration: {{ calculateDuration(currentSession.start_time) }}
      </p>
    </div>

    <!-- Timesheet Table -->
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
            <td class="px-6 py-4 whitespace-nowrap">{{ pointage.task?.task_name || '---' }}</td>
          </tr>
          <tr v-if="pointages.length === 0">
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No time entries found</td>
          </tr>
        </tbody>
      </table>
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

const currentTask = computed(() => {
  if (!currentSession.value?.task_id) return null
  return tasks.value.find(task => task.id === currentSession.value.task_id)
})

const fetchTasks = async () => {
  try {
    const response = await axios.get(`${import.meta.env.VITE_APP_API_URL}/api/tasks`, {
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
      employee_id: localStorage.getItem('user_id'),
      task_id: selectedTaskId.value
    }, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('access_token')}`
      }
    })
    isWorking.value = true
    currentSession.value = response.data.pointage
    selectedTaskId.value = ''
    await fetchPointages()
    toast({
      message: 'Work session started',
      color: 'success'
    })
  } catch (error) {
    toast({
      message: 'Failed to start work session',
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
    await fetchPointages()
    toast({
      message: 'Work session ended',
      color: 'success'
    })
  } catch (error) {
    toast({
      message: 'Failed to end work session',
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
})
</script>