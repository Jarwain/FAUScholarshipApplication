<template>
  <b-card no-body>
    <b-card-header v-if="loading">
      <icon name="refresh" spin></icon> Loading...
    </b-card-header>
    <div class="error" v-if="error">
      {{error}}
    </div>
    <b-tabs card v-if="scholarships && !error">
      <b-tab title="Online" active>
        <scholarship v-for="scholarship in scholarships" 
          v-if="scholarship.category === 1" 
          :key="scholarship.id" 
          :scholarship="scholarship" />            
      </b-tab>
      <b-tab title="Offline">
        <scholarship v-for="scholarship in scholarships" 
          v-if="scholarship.category === 2" 
          :key="scholarship.id" 
          :scholarship="scholarship" />            
      </b-tab>
      <b-tab title="External">
        <scholarship v-for="scholarship in scholarships" 
          v-if="scholarship.category === 3" 
          :key="scholarship.id"
          :scholarship="scholarship" />
      </b-tab>
    </b-tabs>
  </b-card>
</template>

<script>
// import scholarships from '@/assets/scholarship.json';
import Scholarship from '@/components/Scholarship';

export default {
  name: 'ScholarshipViewer',
  props: [],
  components: {
    Scholarship,
  },
  data() {
    return {
      scholarships: null,
      loading: true,
      error: null,
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      this.axios.get('https://boc22finaid.fau.edu/scholarship/api/scholarships/')
        .then((res) => {
          this.loading = false;
          this.scholarships = res.data;
        })
        .catch((err) => {
          this.error = err;
          console.log(`ERROR: ${err}`);
        });
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
