import { createRouter, createWebHistory } from 'vue-router'
import PlantList from './views/PlantList.vue'
import PlantForm from './views/PlantForm.vue'
import PlantDetail from './views/PlantDetail.vue'

const routes = [
    {
        path: '/',
        name: 'PlantList',
        component: PlantList
    },
    {
        path: '/plants/create',
        name: 'PlantCreate',
        component: PlantForm
    },
    {
        path: '/plants/:id',
        name: 'PlantDetail',
        component: PlantDetail
    },
    {
        path: '/plants/:id/edit',
        name: 'PlantEdit',
        component: PlantForm
    }
]

export default createRouter({
    history: createWebHistory(),
    routes
})
