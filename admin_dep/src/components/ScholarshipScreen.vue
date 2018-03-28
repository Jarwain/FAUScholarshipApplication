<template>
  <div>
    <b-card>
      <h2 slot="header">
        Scholarships
      </h2>
      <b-row>
        <b-col cols="auto">
          <b-nav pills card vertical>
            <b-nav-item to="/scholarship/view">
              View
            </b-nav-item>
            <b-nav-item to="/scholarship/add">
              Add
            </b-nav-item>
            <b-nav-item disabled>
              Edit
            </b-nav-item>
          </b-nav>
        </b-col>
        <b-col>
          <router-view></router-view>
        </b-col>
      </b-row>
    </b-card>
  </div>
</template>

<script>
export default {
  name: 'ScholarshipScreen',
  props: [],
  components: {
  },
  data() {
    return {
    };
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
