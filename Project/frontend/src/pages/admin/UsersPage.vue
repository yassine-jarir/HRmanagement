<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Liste des Employés</h1>

    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
      <thead class="bg-gray-100 text-gray-700 text-left">
        <tr>
          <th class="py-3 px-4">ID</th>
          <th class="py-3 px-4">Nom</th>
          <th class="py-3 px-4">Email</th>
          <th class="py-3 px-4">Rôle</th>
          <th class="py-3 px-4 text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="employee in employees" :key="employee.id" class="border-b hover:bg-gray-50">
          <td class="py-3 px-4">{{ employee.id }}</td>
          <td class="py-3 px-4">{{ employee.name }}</td>
          <td class="py-3 px-4">{{ employee.email }}</td>
          <td class="py-3 px-4">{{ employee.role || '—' }}</td>
          <td class="py-3 px-4 text-right space-x-2">

            <VaButton @click="editEmployee(employee)">
                modifier
            </VaButton>

            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" @click="deleteEmployee(employee.id)">
              Supprimer
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <p v-if="employees.length === 0" class="mt-4 text-gray-500">Aucun employé trouvé.</p>

    <VaModal
      v-model="showModal"
      message="Classic modal overlay which represents a dialog box or other interactive component, such as a dismissible alert, sub-window, etc."
      ok-text="Apply"
      blur
    />

    <VaModal
      v-model="showEditModal"
      title="Modifier l'employé"
      ok-text="Enregistrer"
      cancel-text="Annuler"
      @ok="updateEmployee"
      @cancel="closeEditModal"
    >
      <form @submit.prevent="updateEmployee">
        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
          <input
            v-model="selectedEmployee.name"
            type="text"
            id="name"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            v-model="selectedEmployee.email"
            type="email"
            id="email"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>
        <div class="mb-4">
          <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
          <input
            v-model="selectedEmployee.role"
            type="text"
            id="role"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
          <select name="" id="">
            <option value="employee">employee</option>
            <option value="admin">admin</option>
           </select>
        </div>
      </form>
    </VaModal>
  </div>
</template>

<script>
import axios from 'axios'

export default {
   data() {
    return {
      employees: [],
      showModal: false,
      showEditModal: false,
      selectedEmployee: {},
    }
  },
  mounted() {
    this.fetchEmployees()
    console.log(localStorage.getItem('access_token'));
  },
  methods: {
    async fetchEmployees() {
      try {
        const response = await axios.get(`${import.meta.env.VITE_APP_API_URL}/api/Employee`,
        {
          headers : {
            'Authorization' : `Bearer ${localStorage.getItem('access_token')}`,
            'Content-type' : 'application/json'
          }
        })
        this.employees = response.data
        consoloe.log('Employés récupérés :', response.data)
      } catch (error) {
        console.error('Erreur lors de la récupération des employés :', error)
      }
    },
    editEmployee(employee) {
      this.selectedEmployee = { ...employee };
      this.showEditModal = true;
    },
    closeEditModal() {
      this.showEditModal = false;
      this.selectedEmployee = {};
    },
    async updateEmployee() {
      try {
        const response = await axios.put(
          `${import.meta.env.VITE_APP_API_URL}/api/Employee/${this.selectedEmployee.id}`,
          this.selectedEmployee,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('access_token')}`,
              'Content-type': 'application/json',
            },
          }
        );
        const updatedEmployee = response.data;
        this.employees = this.employees.map((emp) =>
          emp.id === updatedEmployee.id ? updatedEmployee : emp
        );
        this.closeEditModal();
      } catch (error) {
        console.error("Erreur lors de la mise à jour de l'employé :", error);
      }
    },
    async deleteEmployee(id) {
      if (confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')) {
        try {
          await axios.delete(`/api/Employee/${id}`)
          this.employees = this.employees.filter(emp => emp.id !== id)
        } catch (error) {
          console.error('Erreur lors de la suppression :', error)
        }
      }
    },
  },
}
</script>

