<template>
    <div class="plant-detail">
        <div v-if="loading" class="loading">Loading...</div>

        <div v-else-if="plant" class="plant-content">
            <div class="header">
                <h1>{{ plant.title }}</h1>
                <div class="actions">
                    <button @click="editPlant" class="btn btn-primary">Edit</button>
                    <button @click="confirmDelete" class="btn btn-danger">Delete</button>
                    <button @click="goBack" class="btn btn-secondary">Back</button>
                </div>
            </div>

            <div class="details-grid">
                <div class="detail-card">
                    <h3>Basic Information</h3>
                    <div class="info-row">
                        <span class="label">ID:</span>
                        <span class="value">{{ plant.id }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Title:</span>
                        <span class="value">{{ plant.title }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Age:</span>
                        <span class="value">{{ plant.age }} years</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Type:</span>
                        <span class="value">{{ plant.type?.title }}</span>
                    </div>
                </div>

                <div class="detail-card">
                    <h3>Protection Products</h3>
                    <div v-if="plant.protection_products?.length" class="products-list">
                        <div
                            v-for="product in plant.protection_products"
                            :key="product.id"
                            class="product-item"
                        >
                            <div class="product-info">
                                <span class="product-name">{{ product.title }}</span>
                                <span class="product-dose">{{ product.pivot?.dose }} ml/l</span>
                            </div>
                        </div>
                    </div>
                    <p v-else class="no-products">No protection products assigned</p>
                </div>
            </div>
        </div>

        <div v-else class="error">
            Plant not found
        </div>

        <!-- Красивый диалог подтверждения -->
        <ConfirmDialog
            :show="deleteDialog.show"
            title="Delete Plant"
            :message="`Are you sure you want to delete '${plant?.title}'? This action cannot be undone.`"
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
import { useRouter, useRoute } from 'vue-router'
import ConfirmDialog from '../components/ConfirmDialog.vue'

const store = useStore()
const router = useRouter()
const route = useRoute()

const plant = computed(() => store.getters['plants/currentPlant'])
const loading = computed(() => store.getters['plants/isLoading'])

const deleteDialog = ref({
    show: false
})

onMounted(async () => {
    await store.dispatch('plants/fetchPlant', route.params.id)
})

const editPlant = () => {
    router.push(`/plants/${route.params.id}/edit`)
}

const confirmDelete = () => {
    deleteDialog.value.show = true
}

const handleDeleteConfirm = async () => {
    await store.dispatch('plants/deletePlant', route.params.id)
    deleteDialog.value.show = false
    router.push('/')
}

const handleDeleteCancel = () => {
    deleteDialog.value.show = false
}

const goBack = () => {
    router.push('/')
}
</script>

<style scoped>
.plant-detail {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    max-width: 900px;
    margin: 0 auto;
}

.loading {
    text-align: center;
    padding: 3rem;
    color: #666;
}

.error {
    text-align: center;
    padding: 3rem;
    color: #dc3545;
    font-size: 1.2rem;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e0e0e0;
}

.header h1 {
    margin: 0;
    color: #333;
}

.actions {
    display: flex;
    gap: 0.5rem;
}

.btn {
    padding: 0.625rem 1.25rem;
    border: none;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
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

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
}

.details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

@media (max-width: 768px) {
    .details-grid {
        grid-template-columns: 1fr;
    }
}

.detail-card {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
}

.detail-card h3 {
    margin: 0 0 1rem 0;
    color: #333;
    font-size: 1.2rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e0e0e0;
}

.info-row:last-child {
    border-bottom: none;
}

.label {
    font-weight: 600;
    color: #666;
}

.value {
    color: #333;
}

.products-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.product-item {
    background: white;
    padding: 1rem;
    border-radius: 6px;
    border: 1px solid #e0e0e0;
}

.product-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.product-name {
    font-weight: 500;
    color: #333;
}

.product-dose {
    background: #28a745;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

.no-products {
    color: #999;
    font-style: italic;
    text-align: center;
    padding: 2rem;
}
</style>
