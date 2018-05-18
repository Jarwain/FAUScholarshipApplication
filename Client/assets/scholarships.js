import axios from 'axios'

module.exports = function ScholarshipApi (moduleOptions) {
  return {
    getScholarships () {
      return axios.get('https://boc22finaid.fau.edu/scholarship/api/scholarship/')
    }
  }
}
