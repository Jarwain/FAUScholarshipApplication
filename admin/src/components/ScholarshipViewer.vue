<template>
  <b-card no-body>
    <b-card-header v-if="loading">
      <icon name="refresh" spin></icon> Loading...
    </b-card-header>
    <div class="error" v-if="error">
      {{error}}
    </div>
    <b-tabs card v-if="!loading && !error">
      <b-tab title="Internal" active>
        <scholarship v-for="scholarship in scholarships" 
          v-if="scholarship.category_ref === 1" 
          :key="scholarship.id" 
          :scholarship="scholarship" />            
      </b-tab>
      <b-tab title="External">
        <scholarship v-for="scholarship in scholarships" 
          v-if="scholarship.category_ref === 3" 
          :key="scholarship.id"
          :scholarship="scholarship" />
      </b-tab>
    </b-tabs>
  </b-card>
</template>

<script>
import scholarships from '@/assets/scholarship.json';
import Scholarship from '@/components/Scholarship';

export default {
  name: 'ScholarshipViewer',
  props: [],
  components: {
    Scholarship,
  },
  data() {
    return {
      scholarships,
      loading: true,
      error: null,
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      this.axios.get('https://boc22finaid.fau.edu/scholarship/api/scholarship/site')
        .then((res) => {
          this.loading = false;
          this.scholarships = res.data;
        })
        .catch((err) => {
          this.error = err;
          /*
          if (err.response) {
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            console.log(err.response.data);
            console.log(err.response.status);
            console.log(err.response.headers);
          } else if (err.request) {
            // The request was made but no response was received
            // `err.request` is an instance of XMLHttpRequest in the browser and an instance of
            // http.ClientRequest in node.js
            console.log(err.request);
          } else {
            // Something happened in setting up the request that triggered an Error
            console.log('Error', err.message);
          }
          console.log(err.config);
          */
        });
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
