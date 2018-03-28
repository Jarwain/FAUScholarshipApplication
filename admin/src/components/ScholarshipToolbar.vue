<template>
  <v-toolbar color="red darken-4" dark tabs>
    <v-toolbar-side-icon></v-toolbar-side-icon>
    <v-toolbar-title>
      Scholarships{{subtitle ? `: ${subtitle}` : ''}}
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <v-flex xs3 class="mx-3">
      <v-text-field
        prepend-icon="search"
        label="Search"
        solo-inverted
        flat >
      </v-text-field>
    </v-flex>
    <slot name="extension" slot="extension"></slot>
  </v-toolbar>
</template>

<script>
export default {
  name: 'ScholarshipToolbar',
  props: {
    subtitle: {
      type: String,
      default: null,
    },
  },
};
</script>