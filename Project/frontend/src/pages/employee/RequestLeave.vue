<template>
  <div class="leave-request-form">
    <va-card class="mb-6">
      <va-card-title>Request Leave</va-card-title>
      <va-card-content>
        <form @submit.prevent="submitLeaveRequest">
          <div class="row mb-4">
            <div class="flex xs12 md6">
              <va-select
                v-model="leaveRequest.type"
                label="Leave Type"
                :options="leaveTypes"
                class="mb-4"
                required
              />
            </div>
          </div>

          <div class="row mb-4">
            <div class="flex xs12 md6">
              <div class="form-group">
                <va-input
                  v-model="leaveRequest.start_date"
                  type="date"
                  label="Start Date"
                  class="mb-4"
                  required
                />
              </div>
            </div>
            <div class="flex xs12 md6">
              <div class="form-group">
                <va-input
                  v-model="leaveRequest.end_date"
                  type="date"
                  label="End Date"
                  class="mb-4"
                  required
                  :min="leaveRequest.start_date"
                />
              </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="flex xs12">
              <va-textarea
                v-model="leaveRequest.reason"
                label="Reason"
                class="mb-4"
                required
              />
            </div>
          </div>

          <div class="row">
            <div class="flex xs12">
              <va-button type="submit" :loading="loading">
                Submit Request
              </va-button>
            </div>
          </div>
        </form>
      </va-card-content>
    </va-card>

    <!-- Leave Request History -->
    <va-card>
      <va-card-title>My Leave Requests</va-card-title>
      <va-card-content>
        <div class="table-container">
          <table class="table" v-if="myLeaveRequests.length">
            <thead>
              <tr>
                <th>Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Submitted On</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="request in myLeaveRequests" :key="request.id">
                <td>{{ request.type }}</td>
                <td>{{ formatDate(request.start_date) }}</td>
                <td>{{ formatDate(request.end_date) }}</td>
                <td>{{ request.reason }}</td>
                <td>
                  <span :class="['status-badge', `status-${request.status}`]">
                    {{ request.status }}
                  </span>
                </td>
                <td>{{ formatDate(request.created_at) }}</td>
              </tr>
            </tbody>
          </table>
          <div v-else class="empty-state">
            No leave requests found
          </div>
        </div>
      </va-card-content>
    </va-card>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useToast } from 'vuestic-ui'

export default {
  name: 'RequestLeave',
  setup() {
    const { init } = useToast()
    const loading = ref(false)
    const myLeaveRequests = ref([])
    const leaveRequest = ref({
      type: '',
      start_date: '',
      end_date: '',
      reason: ''
    })

    const leaveTypes = [
      'Annual Leave',
      'Sick Leave',
      'Personal Leave',
      'Family Leave',
      'Other'
    ]

    const formatDate = (date) => {
      if (!date) return ''
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      })
    }

    const fetchMyLeaveRequests = async () => {
      try {
        const response = await axios.get(
          `${import.meta.env.VITE_APP_API_URL}/api/leave-requests`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('access_token')}`,
              'Content-Type': 'application/json'
            }
          }
        )
        myLeaveRequests.value =  response.data.leave_requests
        console.log('Leave requests:', myLeaveRequests.value)

      } catch (error) {
        console.error('Error fetching leave requests:', error)
        init({
          message: 'Failed to load leave request history',
          color: 'danger'
        })
      } 
    }

    const submitLeaveRequest = async () => {
      try {
        loading.value = true
        await axios.post(
          `${import.meta.env.VITE_APP_API_URL}/api/leave-requests`,
          leaveRequest.value,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('access_token')}`,
              'Content-Type': 'application/json'
            }
          }
        )

        init({
          message: 'Leave request submitted successfully!',
          color: 'success'
        })

         leaveRequest.value = {
          type: '',
          start_date: '',
          end_date: '',
          reason: ''
        }
        
         await fetchMyLeaveRequests()
      } catch (error) {
        init({
          message: error.response?.data?.message || 'Error submitting leave request',
          color: 'danger'
        })
      } finally {
        loading.value = false
      }
    }

    onMounted(() => {
      fetchMyLeaveRequests()
    })

    return {
      leaveRequest,
      leaveTypes,
      loading,
      myLeaveRequests,
      formatDate,
      submitLeaveRequest
    }
  }
}
</script>

<style scoped>
.leave-request-form {
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

.row {
  display: flex;
  flex-wrap: wrap;
  margin: -12px;
  width: 100%;
}

.flex {
  padding: 12px;
}

.xs12 {
  flex: 0 0 100%;
  max-width: 100%;
}

@media (min-width: 768px) {
  .md6 {
    flex: 0 0 50%;
    max-width: 50%;
  }
}

/* Add styling for Vuestic inputs */
:deep(.va-input-wrapper),
:deep(.va-select),
:deep(.va-textarea) {
  width: 100%;
  min-width: 250px;
}

:deep(.va-select__value) {
  width: 100%;
}

.table-container {
  overflow-x: auto;
  margin-top: 1rem;
}

.table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
  font-size: 0.875rem;
}

.table th,
.table td {
  padding: 0.75rem;
  border-bottom: 1px solid #e2e8f0;
  text-align: left;
}

.table th {
  background-color: #f7fafc;
  font-weight: 600;
  color: #4a5568;
}

.table tr:hover {
  background-color: #f8fafc;
}

.status-badge {
  padding: 0.25rem 0.5rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 500;
}

.status-pending {
  background-color: #fef3c7;
  color: #92400e;
}

.status-approved {
  background-color: #dcfce7;
  color: #166534;
}

.status-rejected {
  background-color: #fee2e2;
  color: #991b1b;
}

.empty-state {
  text-align: center;
  padding: 2rem;
  color: #6b7280;
}
</style>
