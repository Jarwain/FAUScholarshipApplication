<template>
<div id="app" role="main" class="container">
  <h2>Student Information</h2>
  <p>Fill out as much as you can.</p>
  <form>
    <div class="form-row">
      <div class="form-group col">
        <label for="first_name">First Name</label>
        <input v-model="student.first_name" type="text" class="form-control" name="first_name" placeholder="First name" required>
      </div>
      <div class="form-group col">
        <label for="last_name">Last Name</label>
        <input v-model="student.last_name" type="text" class="form-control" name="last_name" placeholder="Last name" required>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col">
        <label for="znumber">Z-number</label>
        <input v-model="student.znumber" type="text" class="form-control" id="znumber" name="znumber" placeholder="Z12345678" required>
      </div>
      <div class="form-group col">
        <label for="email">Email address</label>
        <input v-model="student.email" type="email" class="form-control" id="email" name="email" placeholder="name@fau.edu" required>
      </div>
    </div>
    <qualifier-input v-for="qualifier in qualifiers" :key="qualifier.id"
      :qualifier="qualifier"
      v-model="student.qualifications[qualifier.id]"
    >
    </qualifier-input>
  </form>
</div>
</template>

<script>
import axios from 'axios'
import QualifierInput from '@/components/QualifierInput.vue';

export default {
  name: 'ApplicationStudent',
  components: {
    QualifierInput
  },
  data() {
    return {
      qualifiers: window.FAUobj.qualifiers,
      student: {},
    };
  },
};
</script>
