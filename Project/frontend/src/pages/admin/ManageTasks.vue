<template>
    <div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">
      <div class="max-w-6xl mx-auto">
 
        <div class="mb-6 flex justify-end">
          <button 
            @click="showAddTaskModal = true"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add New Task
          </button>
        </div>
 
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Tasks List</h2>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
              {{ tasks.length }} Tasks
            </span>
          </div>
          
          <div v-if="loading" class="flex flex-col items-center justify-center py-16">
            <div class="w-12 h-12 border-4 border-gray-200 border-t-blue-600 rounded-full animate-spin mb-4"></div>
            <p class="text-gray-500">Loading tasks...</p>
          </div>
          
          <div v-else-if="tasks.length === 0" class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">No tasks yet</h3>
            <p class="text-gray-500 max-w-sm">Click the "Add New Task" button to create your first task</p>
          </div>
  
          <div v-else class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr class="bg-gray-50">
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Name</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Users</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="task in tasks" :key="task.id" class="hover:bg-gray-50 transition-colors">
                  <td class="px-6 py-4">
                    <div class="font-medium text-gray-900">{{ task.task_name }}</div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-500 line-clamp-2">{{ task.description || 'No description' }}</div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1">
                      <span 
                        v-for="user in task.users" 
                        :key="user.id" 
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                      >
                        {{ user.name }}
                      </span>
                      <span v-if="!task.users?.length" class="text-sm text-gray-400">None</span>
                    </div>
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
                      {{ task.status || 'To Do' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-right">
                    <div class="flex justify-end space-x-2">
                      <button 
                        class="flex items-center justify-center p-1 rounded-md text-blue-600 hover:bg-blue-50 transition-colors"
                        @click="editTask(task)"
                        title="Edit"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                      </button>
                      <button 
                        class="flex items-center justify-center p-1 rounded-md text-red-600 hover:bg-red-50 transition-colors"
                        @click="deleteTask(task.id)"
                        title="Delete"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  
      <TaskModal 
          v-if="showAddTaskModal || editingTask"
          :taskForm="taskForm"
          :users="users"
          :editingTask="editingTask"
          @submit="handleSubmit"
          @close="() => { showAddTaskModal = false; editingTask = null }"
        />
    </div>
  </template>
  
  <script setup>
  import { ref, reactive, onMounted } from 'vue'
  import axios from 'axios'
  import TaskModal from './tasks/TaskModal.vue'
  
  const tasks = ref([])
  const users = ref([])
  const loading = ref(false)
  const editingTask = ref(null)
  const showAddTaskModal = ref(false)
  
  const taskForm = reactive({
    task_name: '',
    description: '',
    user_ids: [],
    status: 'To Do'
  })
   
  const fetchTasks = async () => {
    try {
      loading.value = true
      const response = await axios.get(`${import.meta.env.VITE_APP_API_URL}/api/tasks`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('access_token')}`,
          'Content-Type': 'application/json'
        }
      })
      tasks.value = response.data
      users.value = response.data
      console.log('Tasks fetched:', tasks.value)
      console.log('Users fetched:', users.value)  

    } catch (error) {
      console.error('Error fetching tasks:', error)
    } finally {
      loading.value = false
    }
  }
  
  const fetchUsers = async () => {
    try {
      const response = await axios.get(`${import.meta.env.VITE_APP_API_URL}/api/Employee`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('access_token')}`,
          'Content-Type': 'application/json'
        }
      })
      users.value = response.data
    } catch (error) {
      console.error('Error fetching users:', error)
    }
  }
  
  const handleSubmit = async () => {
    try {
      loading.value = true
      const payload = {
        task_name: taskForm.task_name,
        description: taskForm.description,
        status: taskForm.status,
        user_ids: taskForm.user_ids
      }
      
      if (editingTask.value) {
        await axios.put(`${import.meta.env.VITE_APP_API_URL}/api/tasks/${editingTask.value.id}`, payload, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('access_token')}`,
            'Content-Type': 'application/json'
          }
        })
      } else {
        await axios.post(`${import.meta.env.VITE_APP_API_URL}/api/tasks`, payload, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('access_token')}`,
            'Content-Type': 'application/json'
          }
        })
      }
      await fetchTasks()
      resetForm()
    } catch (error) {
      console.error('Error saving task:', error)
      alert(error.response?.data?.message || 'Error saving task')
    } finally {
      loading.value = false
    }
  }
  
  const editTask = (task) => {
    editingTask.value = task
    taskForm.task_name = task.task_name
    taskForm.description = task.description || ''
    taskForm.user_ids = task.users ? task.users.map(user => user.id) : []
    taskForm.status = task.status || 'To Do'
    showAddTaskModal.value = true
  }
  
  const deleteTask = async (taskId) => {
    if (!confirm('Are you sure you want to delete this task?')) return
    
    try {
      loading.value = true
      await axios.delete(`${import.meta.env.VITE_APP_API_URL}/api/tasks/${taskId}`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('access_token')}`,
          'Content-Type': 'application/json'
        }
      })
      await fetchTasks()
    } catch (error) {
      console.error('Error deleting task:', error)
    } finally {
      loading.value = false
    }
  }
  
  const resetForm = () => {
    editingTask.value = null
    showAddTaskModal.value = false
    taskForm.task_name = ''
    taskForm.description = ''
    taskForm.user_ids = []
    taskForm.status = 'To Do'
  }
  
  onMounted(() => {
    fetchTasks()
    fetchUsers()
  })
  </script>
  
  <style>
  .modal-enter-active,
  .modal-leave-active {
    transition: opacity 0.25s ease;
  }
  
  .modal-enter-from,
  .modal-leave-to {
    opacity: 0;
  }
  </style>