<template>
  <div>
    <scholarship-toolbar :subtitle="title">
    </scholarship-toolbar>
    <router-view></router-view>
    <v-btn dark fab fixed bottom right color="red" to="/scholarships/add">
      <v-icon>add</v-icon>
    </v-btn>
  </div>
</template>

<script>
import ScholarshipItem from '@/components/ScholarshipItem';
import ScholarshipToolbar from '@/components/ScholarshipToolbar';

export default {
  name: 'ScholarshipOverview',
  props: ['title'],
  components: {
    ScholarshipItem,
    ScholarshipToolbar,
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
