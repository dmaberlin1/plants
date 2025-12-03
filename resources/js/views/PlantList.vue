<template>
    <div class="plant-list">
        <div class="header">
            <h2>Plants</h2>
            <button @click="goToCreate" class="btn btn-primary">+ Add Plant</button>
        </div>

        <div v-if="loading" class="loading">Loading...</div>

        <div v-else class="plants-grid">
            <div v-for="plant in plants" :key="plant.id" class="plant-card">
                <h3>{{ plant.title }}</h3>
                <p><strong>Age:</strong> {{ plant.age }} years</p>
                <p><strong>Type:</strong> {{ plant.type?.title }}</p>

                <div v-if="plant.protection_products?.length" class="protection-products">
                    <p class="products-label"><strong>Protection Products:</strong></p>
                    <ul class="products-list">
                        <li v-for="product in plant.protection_products" :key="product.id">
                            {{ product.title }}
                            <span class="dose">({{ product.pivot?.dose }} ml/l)</span>
                        </li>
                    </ul>
                </div>
                <p v-else class="no-products">No protection products</p>

                <div class="actions">
                    <button @click="viewPlant(plant.id)" class="btn btn-info">View</button>
                    <button @click="editPlant(plant.id)" class="btn btn-primary">Edit</button>
                    <button @click="confirmDelete(plant)" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>

        <ConfirmDialog
            :show="deleteDialog.show"
            title="Delete Plant"
            :message="`Are you sure you want to delete '${deleteDialog.plantName}'? This action cannot be undone.`"
            confirmText="Delete"
            cancelText="Cancel"
            @confirm="handleDeleteConfirm"
            @cancel="handleDeleteCancel"
        />
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import ConfirmDialog from '../components/ConfirmDialog.vue'

const store = useStore()
const router = useRouter()

const plants = computed(() => store.getters['plants/allPlants'])
const loading = computed(() => store.getters['plants/isLoading'])

const deleteDialog = ref({
    show: false,
    plantId: null,
    plantName: ''
})

onMounted(() => {
    store.dispatch('plants/fetchPlants')
})

const goToCreate = () => router.push('/plants/create')
const viewPlant = (id) => router.push(`/plants/${id}`)
const editPlant = (id) => router.push(`/plants/${id}/edit`)

const confirmDelete = (plant) => {
    deleteDialog.value = {
        show: true,
        plantId: plant.id,
        plantName: plant.title
    }
}

const handleDeleteConfirm = async () => {
    await store.dispatch('plants/deletePlant', deleteDialog.value.plantId)
    deleteDialog.value.show = false
}

const handleDeleteCancel = () => {
    deleteDialog.value.show = false
}
</script>

<style scoped>
.plant-list {
    background: white;
    border-radius: 12px;
    padding: 2rem;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.loading {
    text-align: center;
    padding: 2rem;
    color: #666;
}

.plants-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.plant-card {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    transition: transform 0.2s, box-shadow 0.2s;
}

.plant-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.plant-card h3 {
    margin: 0 0 1rem 0;
    color: #333;
}

.plant-card p {
    margin: 0.5rem 0;
    color: #666;
}

.protection-products {
    margin: 1rem 0;
    padding: 0.75rem;
    background: white;
    border-radius: 6px;
    border: 1px solid #e0e0e0;
}

.products-label {
    margin: 0 0 0.5rem 0 !important;
    color: #333 !important;
}

.products-list {
    margin: 0;
    padding-left: 1.5rem;
    list-style: disc;
}

.products-list li {
    margin: 0.25rem 0;
    color: #555;
}

.dose {
    color: #28a745;
    font-weight: 500;
}

.no-products {
    color: #999 !important;
    font-style: italic;
}

.actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
}

.actions .btn {
    flex: 1;
    padding: 0.5rem;
    font-size: 0.9rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-info {
    background: #17a2b8;
    color: white;
}

.btn-info:hover {
    background: #138496;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
}

.btn-primary {
    background: #6366f1;
    color: white;
}

.btn-primary:hover {
    background: #4f46e5;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
}
</style>
