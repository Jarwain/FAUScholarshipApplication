<template>
  <b-card class="scholarship"
          :border-variant="isActive ? 'success' : 'danger'"
          :header-border-variant="isActive ? 'success' : 'danger'">
    <div slot="header" class="d-flex justify-content-between align-items-center">
      <h5 class="d-inline-block mb-0">
        <b-link :href="scholarship.url"
                v-if="scholarship.url">
          {{ scholarship.name }}
        </b-link> 
        <span v-else>{{ scholarship.name }}</span>
        <small class="text-muted">
          {{ scholarship.id }}
        </small>
      </h5> 
      <div class="d-inline-block ">
        <b-button :pressed.sync="isActive" :variant="isActive ? 'success' : 'danger'">
          {{ isActive ? "Active" : "Inactive" }}
        </b-button>
        <b-button href="#" variant="primary">
          <icon name="edit" />
        </b-button>
      </div>
    </div>
    <div class="card-text">
      <h6 class="card-subtitle text-muted mb-2">{{ scholarship.url }}</h6>
        {{ scholarship.description }}
    </div>
    <div slot="footer">
      <icon name="chevron-up" v-b-toggle="scholarship.id"/>
      <b-collapse :id="scholarship.id">
        <b-card>
          Deadline: {{scholarship.deadline}} | Limit: {{scholarship.limit}}
        </b-card>
      </b-collapse>
    </div>
  </b-card>
</template>

<script>
export default {
  name: 'Scholarship',
  props: ['scholarship'],
  data() {
    return {
      isActive: this.scholarship.active,
    };
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
svg{
  transition: 300ms ease all;
}
svg.collapsed {
  transform: rotate(180deg);
}

.card-header h5 > a {
  color: inherit;
  text-decoration: underline dotted;
}
.card-header h5 > a:hover {
  text-decoration-style: solid;
}

.scholarship + .scholarship{
  margin-top: 1.25rem;
}
</style>
