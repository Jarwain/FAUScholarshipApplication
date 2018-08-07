<template>
<form>
	<qualifier-input v-for="qualifier in qualifiers" :key="qualifier.id"
		:qualifier="qualifier"
		v-model="answers[qualifier.id]"
	>
	</qualifier-input>
	
</form>
</template>

<script>
import axios from 'axios';
import QualifierInput from './QualifierInput.vue';
export default {
  name: 'StudentForm',
  components: {
		QualifierInput
  },
  created(){
		axios
			.get('https://boc22finaid.fau.edu/scholarship/api/qualifier/', 
				{ headers:{'Accept': 'application/json'} })
			.then(response => (this.qualifiers = response.data));
  },
  data(){
		return {
			qualifiers: [],
			answers: {}
		};
  },
}
</script>

