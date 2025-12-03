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
        <p>Age: {{ plant.age }} years</p>
        <p>Type: {{ plant.type?.title }}</p>
        
        <div class="actions">
          <button @click="editPlant(plant.id)" class="btn btn-primary">Edit</button>
          <button @click="deletePlant(plant.id)" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'

const store = useStore()
const router = useRouter()

const plants = computed(() => store.getters['plants/allPlants'])
const loading = computed(() => store.getters['plants/isLoading'])

onMounted(() => {
  store.dispatch('plants/fetchPlants')
})

const goToCreate = () => router.push('/plants/create')
const editPlant = (id) => router.push(`/plants/${id}/edit`)
const deletePlant = async (id) => {
  if (confirm('Delete plant?')) {
    await store.dispatch('plants/deletePlant', id)
  }
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
  margin-bottom: 2rem;
}

.plants-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1.5rem;
}

.plant-card {
  background: #f8f9fa;
  padding: 1.5rem;
  border-radius: 8px;
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
}
</style>
