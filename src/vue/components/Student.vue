<template>
<div class="card">
	<h5 class="card-header">
		Student Info
	</h5>
	<div class="card-body">
		<dl class="row mb-0">
		  <dt class="col-sm-3">Z-Number</dt>
		  <dd class="col-sm-9">{{znumber}}</dd>

		  <dt class="col-sm-3">First Name</dt>
		  <dd class="col-sm-9">{{first_name}}</dd>

		  <dt class="col-sm-3">Last Name</dt>
		  <dd class="col-sm-9">{{last_name}}</dd>

		  <dt class="col-sm-3">E-mail</dt>
		  <dd class="col-sm-9">{{email}}</dd>
		</dl>
	</div>
	<div class="card-footer">
		<a class="" data-toggle="collapse" href="#qualifications">
			Qualifications
		</a>
		<div class="collapse" id="qualifications">
			{{qualifications}}
		</div>
	</div>
</div>
</template>

<script>
export default {
	name: 'Student',
	components: {
	},
	props: {
		first_name: {
			type: String,
		},
		last_name: {
			type: String,
		},
		znumber: {
			type: String,
		},
		email: {
			type: String,
		},
		qualifications: {
			type: Object,
		},
	},
};
</script>
