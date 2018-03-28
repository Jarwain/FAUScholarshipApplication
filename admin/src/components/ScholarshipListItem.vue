<template>
  <v-card raised>
    <v-toolbar card dense :color="active ? 'green' : 'red'">
      <v-toolbar-title>{{ name }} ~ <small>{{ id }}</small></v-toolbar-title>
    </v-toolbar>
    <v-divider />
    <v-card-text>
      {{ description }}
    </v-card-text>
    <v-card-actions>
      <v-btn color="info">
        View
      </v-btn>
      <v-btn color="amber">
        Edit
      </v-btn>
      <v-spacer></v-spacer>
      <v-btn :outline="!active"
        :color="active ? 'green' : 'red accent-4'"
        @click="$emit('update:active', !active)" >

        {{ active ? 'Active' : 'Inactive' }}
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  name: 'ScholarshipListItem',
  props: ['active', 'id', 'name', 'description'],
  data() {
    return {
    };
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
