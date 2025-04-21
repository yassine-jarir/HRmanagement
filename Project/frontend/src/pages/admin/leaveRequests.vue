<template>
  <div class="leave-requests">
    <div class="card">
      <h2 class="card-title">Leave Requests</h2>
      <div class="card-content">
        <div class="table-container">
          <table class="table" v-if="leaveRequests.length">
            <thead>
              <tr>
                <th>ID</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Employee ID</th>
                <th>Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="request in leaveRequests" :key="request.id">
                <td>{{ request.id }}</td>
                <td>{{ formatDate(request.created_at) }}</td>
                <td>{{ formatDate(request.updated_at) }}</td>
                <td>{{ request.emplyee_id }}</td>
                <td>{{ request.type }}</td>
                <td>{{ formatDate(request.start_date) }}</td>
                <td>{{ formatDate(request.end_date) }}</td>
                <td>{{ request.reason }}</td>
                <td>
                  <span :class="['status-badge', `status-${request.status}`]">
                    {{ request.status }}
                  </span>
                </td>
                <td>
                  <button
                    v-if="isAdmin && request.status === 'pending'"
                    @click="updateStatus(request.id, 'approved')"
                    class="btn btn-success btn-sm"
                  >
                    Approve
                  </button>
                  <button
                    v-if="isAdmin && request.status === 'pending'"
                    @click="updateStatus(request.id, 'rejected')"
                    class="btn btn-danger btn-sm"
                  >
                    Reject
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <div v-else class="empty-state">
            No leave requests found
          </div>
        </div>
        <div v-if="loading" class="loading-overlay">
          Loading...
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'

const loading = ref(false)
const leaveRequests = ref([])
const isAdmin = ref(true) // You should set this based on user role

const formatDate = (date: string) => {
  if (!date) return ''
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const fetchLeaveRequests = async () => {
  try {
    loading.value = true
    const response = await axios.get(`${import.meta.env.VITE_APP_API_URL}/api/leave`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('access_token')}`,
        'Content-Type': 'application/json'
      }
    })
    leaveRequests.value = response.data
  } catch (error) {
    console.error('Error fetching leave requests:', error)
  } finally {
    loading.value = false
  }
}

const updateStatus = async (id: number, status: 'approved' | 'rejected') => {
  try {
    loading.value = true
    await axios.put(`/api/leave-requests/${id}`, { status })
    await fetchLeaveRequests()
  } catch (error) {
    console.error('Error updating leave request:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchLeaveRequests()
})
</script>

<style scoped>
.leave-requests {
  padding: 2rem;
}

.card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 1.5rem;
}

.card-title {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
  color: #2c3e50;
}

.table-container {
  overflow-x: auto;
  position: relative;
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

.btn {
  padding: 0.375rem 0.75rem;
  border-radius: 4px;
  font-weight: 500;
  cursor: pointer;
  border: none;
  font-size: 0.875rem;
  margin-right: 0.5rem;
}

.btn-success {
  background-color: #22c55e;
  color: white;
}

.btn-success:hover {
  background-color: #16a34a;
}

.btn-danger {
  background-color: #ef4444;
  color: white;
}

.btn-danger:hover {
  background-color: #dc2626;
}

.empty-state {
  text-align: center;
  padding: 2rem;
  color: #6b7280;
}

.loading-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 255, 255, 0.8);
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 500;
  color: #4a5568;
}

@media (max-width: 768px) {
  .leave-requests {
    padding: 1rem;
  }
}
</style>