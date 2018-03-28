<template>
  <div id="app">
    <b-navbar toggleable="md" type="dark" variant="dark">
      <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
      <b-navbar-brand to="/">FAU Financial Aid <small class="text-muted">Scholarship Panel</small></b-navbar-brand>
      <b-collapse is-nav id="nav_collapse">
        <b-navbar-nav>
          <b-nav-item to="/scholarship">Scholarships</b-nav-item>
          <b-nav-item >Search</b-nav-item>
          <b-nav-item >Applications</b-nav-item>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
    <b-container fluid>
      <router-view></router-view>
    </b-container>
  </div>
</template>

<script>
export default {
  name: 'app',
  data() {
    return {
    };
  },
};
</script>

<style>
.container-fluid {
  padding-right: 0px;
  padding-left: 0px;
}
</style>
