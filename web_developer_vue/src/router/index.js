import { createRouter, createWebHistory } from 'vue-router'

import DiskonView from '@/views/DiskonView.vue'

const routes = [
  { path: '/', name: 'discount', component: DiskonView },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
