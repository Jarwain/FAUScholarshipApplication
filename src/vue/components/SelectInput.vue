<template>
	<div class='form-group'>
    <label class='col-sm-3 col-form-label' :for="name">{{question}}</label>
    <select v-model="localValue" :multiple="props['multi']" class='form-control'>
			<option v-if="!props['multi']" disabled selected value>{{question}}</option>
			<option v-for="option in props['haystack']" :key='option' :value='option'>{{option}}</option>";
    </select>
  </div>
</template>

<script>
export default {
  name: 'SelectInput',
  props: {
    name: {
      type: String,
      default: '',
      required: true,
    },
    question: {
      type: String,
      default: '',
      required: true,
    },
    props: {
      type: Object,
      required: true,
    },
    value: {
      default: () => [],
      required: true,
    },
  },
  computed: {
    localValue: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit('input', value);
      },
    },
  },
  data() {
    return {

    };
  },
};
</script>

