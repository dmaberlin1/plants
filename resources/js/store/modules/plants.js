import plantService from '../../services/plantService'

export default {
  namespaced: true,

  state: {
    plants: [],
    currentPlant: null,
    loading: false,
    error: null
  },

  getters: {
    allPlants: state => state.plants,
    plantById: state => id => state.plants.find(p => p.id === id),
    currentPlant: state => state.currentPlant,
    isLoading: state => state.loading,
    error: state => state.error
  },

  mutations: {
    SET_PLANTS(state, plants) {
      state.plants = plants
    },

    ADD_PLANT(state, plant) {
      state.plants.unshift(plant)
    },

    UPDATE_PLANT(state, updatedPlant) {
      const index = state.plants.findIndex(p => p.id === updatedPlant.id)
      if (index !== -1) {
        state.plants.splice(index, 1, updatedPlant)
      }
    },

    REMOVE_PLANT(state, plantId) {
      state.plants = state.plants.filter(p => p.id !== plantId)
    },

    SET_CURRENT_PLANT(state, plant) {
      state.currentPlant = plant
    },

    CLEAR_CURRENT_PLANT(state) {
      state.currentPlant = null
    },

    SET_LOADING(state, loading) {
      state.loading = loading
    },

    SET_ERROR(state, error) {
      state.error = error
    },

    CLEAR_ERROR(state) {
      state.error = null
    }
  },

  actions: {
    async fetchPlants({ commit }) {
      commit('SET_LOADING', true)
      commit('CLEAR_ERROR')

      try {
        const response = await plantService.getAll()
        commit('SET_PLANTS', response.data.data)
      } catch (error) {
        const errorMessage = error.response?.data?.message || 'Failed to load plants'
        commit('SET_ERROR', errorMessage)
        
        this.dispatch('showNotification', {
          message: errorMessage,
          type: 'error'
        })
      } finally {
        commit('SET_LOADING', false)
      }
    },

    async fetchPlant({ commit }, plantId) {
      commit('SET_LOADING', true)
      commit('CLEAR_ERROR')

      try {
        const response = await plantService.getById(plantId)
        commit('SET_CURRENT_PLANT', response.data.data)
        return response.data.data
      } catch (error) {
        const errorMessage = error.response?.data?.message || 'Failed to load plant'
        commit('SET_ERROR', errorMessage)
        throw error
      } finally {
        commit('SET_LOADING', false)
      }
    },

    async createPlant({ commit }, plantData) {
      commit('SET_LOADING', true)
      commit('CLEAR_ERROR')

      try {
        const response = await plantService.create(plantData)
        commit('ADD_PLANT', response.data.data)

        this.dispatch('showNotification', {
          message: 'Plant created successfully',
          type: 'success'
        })

        return response.data.data
      } catch (error) {
        const errorMessage = error.response?.data?.message || 'Failed to create plant'
        commit('SET_ERROR', errorMessage)

        this.dispatch('showNotification', {
          message: errorMessage,
          type: 'error'
        })

        throw error
      } finally {
        commit('SET_LOADING', false)
      }
    },

    async updatePlant({ commit }, { id, data }) {
      commit('SET_LOADING', true)
      commit('CLEAR_ERROR')

      try {
        const response = await plantService.update(id, data)
        commit('UPDATE_PLANT', response.data.data)

        this.dispatch('showNotification', {
          message: 'Plant updated successfully',
          type: 'success'
        })

        return response.data.data
      } catch (error) {
        const errorMessage = error.response?.data?.message || 'Failed to update plant'
        commit('SET_ERROR', errorMessage)

        this.dispatch('showNotification', {
          message: errorMessage,
          type: 'error'
        })

        throw error
      } finally {
        commit('SET_LOADING', false)
      }
    },

    async deletePlant({ commit }, plantId) {
      commit('SET_LOADING', true)
      commit('CLEAR_ERROR')

      try {
        await plantService.delete(plantId)
        commit('REMOVE_PLANT', plantId)

        this.dispatch('showNotification', {
          message: 'Plant deleted successfully',
          type: 'success'
        })
      } catch (error) {
        const errorMessage = error.response?.data?.message || 'Failed to delete plant'
        commit('SET_ERROR', errorMessage)

        this.dispatch('showNotification', {
          message: errorMessage,
          type: 'error'
        })

        throw error
      } finally {
        commit('SET_LOADING', false)
      }
    },

    setCurrentPlant({ commit }, plant) {
      commit('SET_CURRENT_PLANT', plant)
    },

    clearCurrentPlant({ commit }) {
      commit('CLEAR_CURRENT_PLANT')
    }
  }
}
