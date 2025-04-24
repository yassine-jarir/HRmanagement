export default {
  routes: [
    {
      name: 'admin-dashboard',
      displayName: 'Dashboard',
      meta: { icon: 'dashboard' },
    },
    {
      name: 'users',
      displayName: 'Employees',
      meta: { icon: 'groups' },
    },
    {
      name: 'leaveRequests',
      displayName: 'Leave Requests',
      meta: {
        icon: 'pending_actions',
      },
    },
    {
      name: 'tasks',
      displayName: 'Tasks',
      meta: {
        icon: 'assignment',
      },
    },
    {
      name: 'payroll',
      displayName: 'Payroll Management',
      meta: {
        icon: 'account_balance_wallet',
      },
    },
  ],
}
