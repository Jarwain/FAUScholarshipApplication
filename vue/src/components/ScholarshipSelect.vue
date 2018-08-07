<template>
<div>
	<selectable-scholarship v-for="(scholarship, code) in scholarships" :key="code"
		v-if="scholarship.active"
		v-bind="scholarship"
		:selected="selected.indexOf(code) != -1"
		@click="toggleSelected(code)"
	>
	</selectable-scholarship>
</div>
</template>

<script>
import axios from 'axios';
import SelectableScholarship from './SelectableScholarship.vue';

export default {
  name: 'ScholarshipSelect',
  components: {
		SelectableScholarship
  },
  created(){
		axios
			.get('https://boc22finaid.fau.edu/scholarship/api/scholarship/', 
				{ headers:{'Accept': 'application/json'} })
			.then(response => (this.scholarships = response.data));
  },
  data(){
		return {
			scholarships: {},
			selected: []
		};
  },
  method: {
		isSelected(code){
			return this.selected.indexOf(code) != -1;
		},
		toggleSelected(code){
			if(this.isSelected(code)){
				this.selected.splice(this.selected.indexOf(code),1);
			} else {
				this.selected.push(code);
			}
		}
  },
}
</script>

