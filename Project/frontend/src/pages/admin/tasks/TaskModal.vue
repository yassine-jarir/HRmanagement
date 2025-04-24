<template>
  <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75 backdrop-blur-sm" 
           aria-hidden="true"
           @click="closeModal"></div>

      <div class="inline-block w-full max-w-xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl sm:my-16">
        <div class="absolute top-0 right-0 pt-4 pr-4">
          <button
            type="button"
            class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none"
            @click="closeModal"
          >
            <span class="sr-only">Close</span>
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <div class="sm:flex sm:items-start">
          <div class="w-full mt-3 sm:mt-0">
            <h3 class="text-2xl font-semibold leading-6 text-gray-900" id="modal-title">
              {{ editingTask ? 'Edit Task' : 'Create New Task' }}
            </h3>
            <div class="mt-6">
              <form @submit.prevent="handleSubmit" class="space-y-6">
                <div>
                  <label for="taskName" class="block text-sm font-medium text-gray-700">Task Name</label>
                  <input 
                    type="text" 
                    id="taskName" 
                    v-model="formData.task_name" 
                    class="block w-full px-4 py-3 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                  />
                </div>

                <div>
                  <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                  <textarea 
                    id="description" 
                    v-model="formData.description" 
                    rows="4" 
                    class="block w-full px-4 py-3 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                  ></textarea>
                </div>
                
                <div>
                  <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                  <select 
                    id="status" 
                    v-model="formData.status" 
                    class="block w-full px-4 py-3 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  >
                    <option value="To Do">To Do</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Review">Review</option>
                    <option value="Done">Done</option>
                  </select>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700">Assign Users</label>
                  <div class="p-3 mt-1 border border-gray-300 rounded-lg max-h-48 overflow-y-auto custom-scrollbar">
                    <div v-if="users.length === 0" class="py-2 text-center text-gray-500">
                      No users available
                    </div>
                    <div v-else v-for="user in users" 
                         :key="user.id" 
                         class="flex items-center p-2.5 hover:bg-gray-50 rounded-lg transition-colors duration-150 ease-in-out">
                      <input 
                        type="checkbox" 
                        :id="'user-' + user.id"
                        :value="user.id"
                        v-model="formData.user_ids"
                        class="w-4 h-4 border-gray-300 rounded text-blue-600 focus:ring-blue-500"
                      />
                      <label :for="'user-' + user.id" class="ml-3 text-sm text-gray-700 cursor-pointer">
                        {{ user.name }}
                      </label>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="mt-8 sm:flex sm:flex-row-reverse sm:px-6">
          <button 
            type="button"
            class="inline-flex justify-center w-full px-6 py-3 text-base font-medium text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
            @click="handleSubmit"
          >
            {{ editingTask ? 'Update Task' : 'Create Task' }}
          </button>
          <button 
            type="button"
            class="inline-flex justify-center w-full px-6 py-3 mt-3 text-base font-medium text-gray-700 transition-colors duration-150 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
            @click="closeModal"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, watch , onMounted } from 'vue'

const props = defineProps({
  taskForm: {
    type: Object,
    required: true
  },
  users: {
    type: Array,
    required: true
  },
  editingTask: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['submit', 'close'])

const formData = reactive({
  task_name: '',
  description: '',
  status: 'To Do',
  user_ids: []
})

 watch(() => props.taskForm, (newVal) => {
  formData.task_name = newVal.task_name
  formData.description = newVal.description
  formData.status = newVal.status
  formData.user_ids = [...newVal.user_ids]
}, { deep: true, immediate: true })

const handleSubmit = () => {
   Object.assign(props.taskForm, formData)
  emit('submit')
}

const closeModal = () => {
  emit('close')
}
 
</script>

<style scoped>
.custom-scrollbar {
  scrollbar-width: thin;
  scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
}

.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: rgba(156, 163, 175, 0.5);
  border-radius: 3px;
}

.backdrop-blur-sm {
  backdrop-filter: blur(4px);
}

@keyframes modalFade {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.modal-content {
  animation: modalFade 0.3s ease-out forwards;
}
</style>