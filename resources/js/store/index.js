import { createStore } from 'vuex'
import plants from './modules/plants'
import plantTypes from './modules/plantTypes'
import protectionProducts from './modules/protectionProducts'

export default createStore({
  modules: {
    plants,
    plantTypes,
    protectionProducts
  },

  state: {
    notification: {
      show: false,
      message: '',
      type: 'success'
    }
  },

  mutations: {
    SET_NOTIFICATION(state, { message, type = 'success' }) {
      state.notification = {
        show: true,
        message,
        type
      }
    },

    CLEAR_NOTIFICATION(state) {
      state.notification = {
        show: false,
        message: '',
        type: 'success'
      }
    }
  },

  actions: {
    showNotification({ commit }, { message, type = 'success' }) {
      commit('SET_NOTIFICATION', { message, type })
      
      setTimeout(() => {
        commit('CLEAR_NOTIFICATION')
      }, 3000)
    }
  }
})
