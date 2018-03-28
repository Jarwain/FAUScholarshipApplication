<template>
<v-container fluid grid-list-lg class="pa-0">
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
        <v-flex xs12 sm11 md10 lg8
          v-for="scholarship in scholarshipCategory(category.id)"
          :key="scholarship.id" >
        </v-flex>
      </v-layout>
    </v-tab-item>
  </v-tabs>
  <v-btn dark fab fixed bottom right color="red darken-4" to="/scholarships/add">
    <v-icon>add</v-icon>
  </v-btn>
</v-container>
</template>

<script>

export default {
  name: 'ScholarshipList',
  props: [],
  components: {

  },
  data() {
    return {
      categories: [
        {
          id: 1,
          name: 'Online',
        },
        {
          id: 2,
          name: 'Offline',
        },
        {
          id: 3,
          name: 'External',
        },
      ],
      tabs: null,
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
    scholarshipCategory(cat) {
      if (this.scholarships) {
        return this.scholarships.filter(e => e.category === cat);
      }
      return null;
    },
  },
};
</script>