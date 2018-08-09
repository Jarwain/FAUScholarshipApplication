import Vue from 'vue';
import Router from 'vue-router';
import StudentForm from './views/StudentForm.vue';

Vue.config.productionTip = false;

const router = new Router({
	mode: 'history',
	base: process.env.BASE_URL,
	routes: [
		{
			path: '/',
			name: 'student',
			component: StudentForm,
		},
		{
			path: '/select',
			name: 'select',
			// route level code-splitting
			// this generates a separate chunk (about.[hash].js) for this route
			// which is lazy-loaded when the route is visited.
			component: () => import(/* webpackChunkName: "about" */ './views/ScholarshipSelect.vue'),
		},
	],
});

new Vue({
	router,
}).$mount('#appl');
