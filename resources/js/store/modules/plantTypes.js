import axios from 'axios'

export default {
  namespaced: true,

  state: {
    plantTypes: [],
    loading: false
  },

  getters: {
    allPlantTypes: state => state.plantTypes,
    isLoading: state => state.loading
  },

  mutations: {
    SET_PLANT_TYPES(state, types) {
      state.plantTypes = types
    },

    SET_LOADING(state, loading) {
      state.loading = loading
    }
  },

  actions: {
    async fetchPlantTypes({ commit }) {
      commit('SET_LOADING', true)

      try {
        const response = await axios.get('/api/v1/plant-types')
        commit('SET_PLANT_TYPES', response.data.data)
      } catch (error) {
        console.error('Failed to load plant types:', error)
      } finally {
        commit('SET_LOADING', false)
      }
    }
  }
}
