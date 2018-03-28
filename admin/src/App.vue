<template>
  <v-app>
    <v-toolbar color="indigo darken-4" dark flat clipped-left app>
      <v-toolbar-side-icon></v-toolbar-side-icon>
      <v-toolbar-title>FAU Scholarship Administration Panel</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-items>
        <v-btn to="/scholarships" flat>Scholarships</v-btn>
        <v-btn flat>Search</v-btn>
        <v-btn flat>Applications</v-btn>
      </v-toolbar-items>
        <v-flex xs3 class="mx-3">
        <v-text-field
          prepend-icon="search"
          label="Search"
          solo-inverted
          flat >
        </v-text-field>
      </v-flex>
    </v-toolbar>
    <v-content>
      <router-view />
    </v-content>
  </v-app>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      menu_items: [
        {
          name: 'Scholarships',
          link: '/scholarships',
        },
      ],
    };
  },
};
</script>
