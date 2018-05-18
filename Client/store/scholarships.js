import api from '@/assets/api/scholarships.js'

export const state = () => ({
  all: {},
  error: {
    status: false,
    message: ''
  }
})

export const mutations = {
  error (state, msg) {
    state.error.status = true
    state.error.message = msg
  },
  setScholarships (state, scholarships) {
    state.all = scholarships
  }
}

export const actions = {
  initialize ({ commit }) {
    api.getScholarships()
      .then(res => {
        commit('setScholarships', res)
      })
      .catch(err => {
        commit('error', err)
      })
  }
}
