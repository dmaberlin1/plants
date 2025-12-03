<template>
    <div class="plant-form">
        <h2>{{ isEdit ? 'Edit Plant' : 'Create Plant' }}</h2>

        <form @submit.prevent="handleSubmit">
            <div class="form-group">
                <label>Title</label>
                <input v-model="form.title" required />
            </div>

            <div class="form-group">
                <label>Age</label>
                <input v-model.number="form.age" type="number" required />
            </div>

            <div class="form-group">
                <label>Type</label>
                <select v-model="form.type_id" required>
                    <option value="">Select type</option>
                    <option v-for="type in plantTypes" :key="type.id" :value="type.id">
                        {{ type.title }}
                    </option>
                </select>
            </div>

            <!-- ✅ НОВОЕ: Секция Protection Products -->
            <div class="form-group">
                <label>Protection Products</label>

                <div class="protection-products-list">
                    <div
                        v-for="(product, index) in form.protection_products"
                        :key="index"
                        class="protection-product-item"
                    >
                        <select v-model="product.id" required class="product-select">
                            <option value="">Select product</option>
                            <option
                                v-for="p in availableProducts(product.id)"
                                :key="p.id"
                                :value="p.id"
                            >
                                {{ p.title }}
                            </option>
                        </select>

                        <input
                            v-model.number="product.dose"
                            type="number"
                            step="0.01"
                            placeholder="Dose (ml/l)"
                            required
                            class="dose-input"
                        />

                        <button
                            type="button"
                            @click="removeProduct(index)"
                            class="btn btn-remove"
                        >
                            ✕
                        </button>
                    </div>

                    <button
                        type="button"
                        @click="addProduct"
                        class="btn btn-add-product"
                        :disabled="!canAddMoreProducts"
                    >
                        + Add Protection Product
                    </button>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" @click="goBack" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">{{ isEdit ? 'Update' : 'Create' }}</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'

const store = useStore()
const router = useRouter()
const route = useRoute()

const isEdit = computed(() => !!route.params.id)
const plantTypes = computed(() => store.getters['plantTypes/allPlantTypes'])
const protectionProducts = computed(() => store.getters['protectionProducts/allProducts'])

const form = ref({
    title: '',
    age: 0,
    type_id: '',
    protection_products: []
})

// Доступные продукты (исключая уже выбранные)
const availableProducts = (currentProductId) => {
    const selectedIds = form.value.protection_products
        .map(p => p.id)
        .filter(id => id && id !== currentProductId)

    return protectionProducts.value.filter(p => !selectedIds.includes(p.id))
}

// Можно ли добавить еще продукты
const canAddMoreProducts = computed(() => {
    return form.value.protection_products.length < protectionProducts.value.length
})

const addProduct = () => {
    form.value.protection_products.push({
        id: '',
        dose: null
    })
}

const removeProduct = (index) => {
    form.value.protection_products.splice(index, 1)
}

onMounted(async () => {
    await Promise.all([
        store.dispatch('plantTypes/fetchPlantTypes'),
        store.dispatch('protectionProducts/fetchProducts')
    ])

    if (isEdit.value) {
        const plant = await store.dispatch('plants/fetchPlant', route.params.id)

        form.value = {
            title: plant.title,
            age: plant.age,
            type_id: plant.type.id,
            protection_products: plant.protection_products?.map(p => ({
                id: p.id,
                dose: p.pivot?.dose || null
            })) || []
        }
    }
})

const handleSubmit = async () => {
    try {
        // Фильтруем только заполненные продукты
        const validProducts = form.value.protection_products.filter(p => p.id && p.dose)

        const dataToSubmit = {
            ...form.value,
            protection_products: validProducts
        }

        if (isEdit.value) {
            await store.dispatch('plants/updatePlant', {
                id: route.params.id,
                data: dataToSubmit
            })
        } else {
            await store.dispatch('plants/createPlant', dataToSubmit)
        }
        router.push('/')
    } catch (error) {
        console.error(error)
    }
}

const goBack = () => router.push('/')
</script>

<style scoped>
.plant-form {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    max-width: 600px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
}

/* ✅ НОВЫЕ СТИЛИ для Protection Products */
.protection-products-list {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 1rem;
    background: #f8f9fa;
}

.protection-product-item {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
    align-items: center;
}

.product-select {
    flex: 2;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 6px;
}

.dose-input {
    flex: 1;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 6px;
}

.btn-remove {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 6px;
    width: 32px;
    height: 32px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.btn-remove:hover {
    background: #c82333;
}

.btn-add-product {
    width: 100%;
    padding: 0.5rem;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
}

.btn-add-product:hover:not(:disabled) {
    background: #218838;
}

.btn-add-product:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.form-actions .btn {
    flex: 1;
}
</style>
