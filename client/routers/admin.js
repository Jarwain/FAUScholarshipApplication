import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

// Generates a separate chunk for this route
// Which is lazy-loaded
function loadView(view) {
	return () => import(/* webpackChunkName: "view-[request]" */ `@/views/${view}.vue`);
}

const router = new Router({
	mode: 'history',
	base: `${process.env.BASE_URL}application/`,
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
		/* {
			path: '*',
		}, */
	],
});

export default router;
