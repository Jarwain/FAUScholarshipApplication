import Vue from 'vue';
import Router from 'vue-router';

Vue.config.productionTip = false;

Vue.use(Router);

// Generates a separate chunk for this route
// Which is lazy-loaded
function loadView(view) {
	return () => import(/* webpackChunkName: "view-[request]" */ `@/views/${view}.vue`);
}

const router = new Router({
	mode: 'history',
	base: process.env.BASE_URL,
	routes: [
		{
			path: '/',
			name: 'student',
			component: loadView('StudentForm'),
		},
		{
			path: '/select',
			name: 'select',
			component: loadView('ScholarshipSelect'),
		},
	],
});

new Vue({
	router,
}).$mount('#app');
