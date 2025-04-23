import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'

import AuthLayout from '../layouts/AuthLayout.vue'
import AppLayout from '../layouts/AppLayout.vue'
import RouteViewComponent from '../layouts/RouterBypass.vue'

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    redirect: { name: 'login' }
  },
  {
    name: 'admin',
    path: '/',
    component: AppLayout,
    meta: { requiresAuth: true },
    children: [
      {
        name: 'dashboard',
        path: 'dashboard',
        component: () => import('../pages/admin/dashboard/Dashboard.vue'),
        meta: { 
          requiresAuth: true,
          role: 'admin'
        },  
      },
      
      {
        name: 'leaveRequests',
        path: 'leaveRequests',
        component: () => import('../pages/admin/leaveRequests.vue'),
        meta:{
          requiresAuth: true,
          role: 'admin'
        }
      },

      {
        name: 'dashboard',
        path: 'dashboard',
        component: () => import('../pages/admin/dashboard/Dashboard.vue'),
        meta: { 
          requiresAuth: true,
          role: 'admin'
        },  
      },
      
      {
        name: 'leaveRequests',
        path: 'leaveRequests',
        component: () => import('../pages/admin/leaveRequests.vue'),
        meta:{
          requiresAuth: true,
          role: 'admin'
        }
      },
      {
        name: 'payroll',
        path: 'payroll',
        component: () => import('../pages/admin/PayrollManagement.vue'),
        meta: {
          requiresAuth: true,
          role: 'admin'
        }
      },
      {
        name: 'users',
        path: 'users',
        component: () => import('../pages/admin/UsersPage.vue'),
        meta: { 
          requiresAuth: true , 
          role: 'admin'
        },
      },
      {
        name: 'tasks',
        path: 'tasks',
        component: () => import('../pages/admin/ManageTasks.vue'),
        meta: { 
          requiresAuth: true, 
          role: 'admin'
        },
      },
      {
        name: 'settings',
        path: 'settings',
        component: () => import('../pages/settings/Settings.vue'),
      },
      {
        name: 'preferences',
        path: 'preferences',
        component: () => import('../pages/preferences/Preferences.vue'),
      },

      // {
      //   name: 'projects',
      //   path: 'projects',
      //   component: () => import('../pages/projects/ProjectsPage.vue'),
      // },
      {
        name: 'payments',
        path: '/payments',
        component: RouteViewComponent,
        children: [
          {
            name: 'payment-methods',
            path: 'payment-methods',
            component: () => import('../pages/payments/PaymentsPage.vue'),
          },
          {
            name: 'billing',
            path: 'billing',
            component: () => import('../pages/billing/BillingPage.vue'),
          },
          {
            name: 'pricing-plans',
            path: 'pricing-plans',
            component: () => import('../pages/pricing-plans/PricingPlans.vue'),
          },
        ],
      },
      {
        name: 'faq',
        path: '/faq',
        component: () => import('../pages/faq/FaqPage.vue'),
      },
    ],
    
  },
  {
    name: 'employee',
    path: '/',
    component: AppLayout,
    meta: { requiresAuth: true },
    children: [
      {
        name: 'dashboard',
        path: 'dashboard',
        component: () => import('../pages/admin/dashboard/Dashboard.vue'),
        meta: { 
          requiresAuth: true,
          role: 'employee'
        },  
      },
      {
        name: 'dashboard',
        path: 'dashboard',
        component: () => import('../pages/employee/dashboard.vue'),
        meta: { 
          requiresAuth: true,
          role: 'employee'
        },  
      },
      {
        name : 'profile',
        path : 'profile',
        component : () => import('../pages/employee/EmployeePorfile.vue'),
      },
      {
        name : 'startWork',
        path : 'startWork',
        component : () => import('../pages/employee/StartWork.vue'),
      }
      ,
      {
        name : 'requestLeave',
        path : 'requestLeave',
        component : () => import('../pages/employee/RequestLeave.vue'),
      }
    ],
    
  },
 
  {
    path: '/auth',
    component: AuthLayout,
    children: [
      {
        name: 'login',
        path: 'login',
        component: () => import('../pages/auth/Login.vue'),
      },
      {
        name: 'signup',
        path: 'signup',
        component: () => import('../pages/auth/Signup.vue'),
      },
      {
        name: 'recover-password',
        path: 'recover-password',
        component: () => import('../pages/auth/RecoverPassword.vue'),
      },
      {
        name: 'recover-password-email',
        path: 'recover-password-email',
        component: () => import('../pages/auth/CheckTheEmail.vue'),
      },
      {
        path: '',
        redirect: { name: 'login' },
      },
    ],
  },
  {
    name: '404',
    path: '/404',
    component: () => import('../pages/404.vue'),
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: { name: '404' },
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    }
    if (to.hash) {
      return { el: to.hash, behavior: 'smooth' }
    } else {
      window.scrollTo(0, 0)
    }
  },
  routes,
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('access_token')
  const role = JSON.parse(localStorage.getItem('user') || '{}').role
   
  const isAuthenticated = !!token

  if (to.meta.requiresAuth && !isAuthenticated) {
    next({ name: 'login' })
  } else if (to.meta.role && role !== to.meta.role) {
    console.log("to.meta.role" , to.meta.role);
    console.log("role" , role);
    next({ name: '404' }) 
  } else {
    next()
  }
})

export default router