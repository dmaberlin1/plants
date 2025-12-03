import axios from 'axios'

export default {
  namespaced: true,

  state: {
    products: [],
    loading: false
  },

  getters: {
    allProducts: state => state.products,
    isLoading: state => state.loading
  },

  mutations: {
    SET_PRODUCTS(state, products) {
      state.products = products
    },

    SET_LOADING(state, loading) {
      state.loading = loading
    }
  },

  actions: {
    async fetchProducts({ commit }) {
      commit('SET_LOADING', true)

      try {
        const response = await axios.get('/api/v1/protection-products')
        commit('SET_PRODUCTS', response.data.data)
      } catch (error) {
        console.error('Failed to load protection products:', error)
      } finally {
        commit('SET_LOADING', false)
      }
    }
  }
}
