<template>
	<div>
		<bool-input v-if="qualifier.type == 'bool'" v-bind="qualifier" v-model="localValue">
		</bool-input>
		<range-input v-if="qualifier.type == 'range'" v-bind="qualifier" v-model="localValue">
		</range-input>
		<select-input v-if="qualifier.type == 'select'" v-bind="qualifier" v-model="localValue">
		</select-input>
	</div>
</template>

<script>
import BoolInput from './BoolInput.vue';
import RangeInput from './RangeInput.vue';
import SelectInput from './SelectInput.vue';

export default {
  name: 'QualifierInput',
  components: {
    BoolInput,
    RangeInput,
    SelectInput,
  },
  props: {
    qualifier: {
      type: Object,
      required: true,
    },
    value: {
      required: false,
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

