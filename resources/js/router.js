import { createRouter, createWebHistory } from 'vue-router'
import PlantList from './views/PlantList.vue'
import PlantForm from './views/PlantForm.vue'

const routes = [
  {
    path: '/',
    name: 'plant-list',
    component: PlantList
  },
  {
    path: '/plants/create',
    name: 'plant-create',
    component: PlantForm
  },
  {
    path: '/plants/:id/edit',
    name: 'plant-edit',
    component: PlantForm
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
