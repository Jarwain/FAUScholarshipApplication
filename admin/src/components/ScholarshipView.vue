<template>
<v-container fluid >
  <v-layout>
    <v-card>
      <v-toolbar card dense :color="scholarship.active ? 'green' : 'red'">
        <v-toolbar-title>{{ scholarship.name }} ~ <small>{{ scholarship.id }}</small></v-toolbar-title>
      </v-toolbar>
      <v-divider />
      <v-card-text>
        {{ scholarship.description }}
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
  </v-layout>
</v-container>
</template>

<script>

export default {
  name: 'ScholarshipList',
  props: ['id'],
  components: {

  },
  computed: {
    scholarship() {
      const sch = this.$store.getters.scholarshipById(this.id);
      if(typeof sch === 'undefined' || !sch){
        // TODO: Make API call
      }
      
      return sch;
    },
  },
  data() {
    return {
    };
  },
};
</script>