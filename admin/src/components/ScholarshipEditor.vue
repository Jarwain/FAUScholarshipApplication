<template>
<v-container fluid class="pa-0">
  <v-tabs dark
    centered
    v-model="tabs"
    slider-color="indigo darken-4"
    color="red darken-4" >
    <v-tab
      v-for="category in categories"
      :key="category.id"
      ripple >
      {{ category.name }}
    </v-tab>
    <v-tab-item
      class="pt-3"
      v-for="category in categories"
      :key="category.id" >
      <v-layout row wrap justify-center>
        <v-flex xs12 sm11 md10 lg8>
          <scholarship-item v-bind.sync="scholarship" ></scholarship-item>
        </v-flex>
      </v-layout>
    </v-tab-item>
  </v-tabs>
</v-container>
</template>

<script>
import ScholarshipToolbar from '@/components/ScholarshipToolbar';

export default {
  name: 'ScholarshipEditor',
  props: [],
  components: {
    ScholarshipToolbar,
  },
  data() {
    return {
      tabs: null,
    };
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
