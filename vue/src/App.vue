<template>
<main id="app" role="main" class="container">
  <div class="d-flex justify-content-between flex-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1>
      Yaaay
    </h1>
  </div>
  <ul class="pagination">
    <li class="page-item" :class="{disabled: idx == 0}">
      <a class="page-link" @click="idx = idx-1" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <li v-for="(test, i) in tests" :key="i" class="page-item" :class="{active: idx == i}">
      <a class="page-link" @click="idx = i">{{i+1}}</a>
    </li>
    <li class="page-item" :class="{disabled: idx == tests.length-1}">
      <a class="page-link" href="#" @click="idx = idx+1" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
  <h2>{{tests[idx].title}}</h2>
  <p>{{tests[idx].message}}</p>
  <component :is="tests[idx].comp"></component>
</main>
</template>

<script>
import StudentForm from './components/scaffold/StudentForm.vue';
import ScholarshipSelect from './components/ScholarshipSelect.vue';

export default {
  name: 'app',
  components: {
    StudentForm,
    ScholarshipSelect
  },
  data(){
    return {
      idx: 1,
      tests: [
        {
          title: "Student Information",
          message: "Fill out as much as you can",
          comp: StudentForm
        },
        {
          title: "Select Scholarship",
          message: "Fill out as much as you can",
          comp: ScholarshipSelect
        }
      ]
    }
  }
}
</script>

<style>

</style>
