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

const form = ref({
  title: '',
  age: 0,
  type_id: '',
  protection_products: []
})

onMounted(async () => {
  await store.dispatch('plantTypes/fetchPlantTypes')
  
  if (isEdit.value) {
    const plant = await store.dispatch('plants/fetchPlant', route.params.id)
    form.value = {
      title: plant.title,
      age: plant.age,
      type_id: plant.type.id,
      protection_products: []
    }
  }
})

const handleSubmit = async () => {
  try {
    if (isEdit.value) {
      await store.dispatch('plants/updatePlant', {
        id: route.params.id,
        data: form.value
      })
    } else {
      await store.dispatch('plants/createPlant', form.value)
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

.form-actions {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
}

.form-actions .btn {
  flex: 1;
}
</style>
