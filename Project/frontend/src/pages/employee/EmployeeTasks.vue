<template>
  <div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
      <header class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">My Tasks</h1>
        <p class="mt-2 text-sm text-gray-600">View and manage your assigned tasks</p>
      </header>

      <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div v-if="loading" class="flex flex-col items-center justify-center py-16">
          <div class="w-12 h-12 border-4 border-gray-200 border-t-blue-600 rounded-full animate-spin mb-4"></div>
          <p class="text-gray-500">Loading tasks...</p>
        </div>

        <div v-else-if="assignedTasks.length === 0" class="flex flex-col items-center justify-center py-16 text-center">
          <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-1">No tasks assigned</h3>
          <p class="text-gray-500 max-w-sm">You currently don't have any tasks assigned to you</p>
        </div>

        <div v-else class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Spent</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="task in assignedTasks" :key="task.id" class="hover:bg-gray-50">
                <td class="px-6 py-4">
                  <div class="font-medium text-gray-900">{{ task.task_name }}</div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-500 line-clamp-2">{{ task.description || 'No description' }}</div>
                </td>
                <td class="px-6 py-4">
                  <span 
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                    :class="{
                      'bg-gray-100 text-gray-800': task.status === 'To Do',
                      'bg-yellow-100 text-yellow-800': task.status === 'In Progress',
                      'bg-purple-100 text-purple-800': task.status === 'Review',
                      'bg-green-100 text-green-800': task.status === 'Done'
                    }"
                  >
                    {{ task.status }}
                  </span>
                </td>
                <td class="px-6 py-4">
                  {{ calculateTimeSpent(task) }}
                </td>
              </tr>
            </tbody>
          </table>
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
const loading = ref(true)
const assignedTasks = ref([])

const fetchAssignedTasks = async () => {
  try {
    const response = await axios.get(`${import.meta.env.VITE_APP_API_URL}/api/taskss`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('access_token')}`
      }
    })
    console.log('Assigned tasks:', response)
    assignedTasks.value = response.data
  } catch (error) {
    console.error('Error fetching tasks:', error)
    toast({
      message: 'Failed to load tasks',
      color: 'danger'
    })
  } finally {
    loading.value = false
  }
}

const calculateTimeSpent = (task) => {
  if (!task.pointages || task.pointages.length === 0) return '0h 0m'
  
  const totalMinutes = task.pointages.reduce((total, pointage) => {
    const start = new Date(pointage.start_time)
    const end = pointage.end_time ? new Date(pointage.end_time) : new Date()
    return total + (end - start) / (1000 * 60)
  }, 0)

  const hours = Math.floor(totalMinutes / 60)
  const minutes = Math.round(totalMinutes % 60)
  return `${hours}h ${minutes}m`
}

onMounted(() => {
  fetchAssignedTasks()
})
</script>