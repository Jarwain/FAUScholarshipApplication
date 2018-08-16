import Vue from 'vue';
import Router from 'vue-router';
import store from '@/stores/application';

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
			name: 'search',
			component: loadView('ScholarshipSearch'),
		},
		{
			path: '/select',
			name: 'select',
			component: loadView('ScholarshipSelect'),
		},
		{
			path: '/apply',
			name: 'apply',
			component: loadView('ScholarshipApply'),
			beforeEnter: (to, from, next) => {
				// If no applications have been selected
				// console.log(store);
				if (Object.keys(store.state.applications).length !== 0) {
					next();
				}
				next(false);
			},
		},
		/* { TODO: 404
			path: '*',
		}, */
	],
});

export default router;
