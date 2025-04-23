<template>
  <div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-6xl mx-auto">
      <h1 class="text-2xl font-bold mb-6">Payroll Management</h1>
      <EmployeePayrollList />
    </div>
  </div>
</template>

<script setup>
import EmployeePayrollList from './components/EmployeePayrollList.vue'
</script>