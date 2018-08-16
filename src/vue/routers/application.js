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
	base: `${process.env.BASE_URL}`,
	routes: [
		{
			path: '/search',
			name: 'search',
			component: loadView('ScholarshipSearch'),
		},
		{
			path: '/list',
			name: 'list',
			alias: '/',
			component: loadView('ScholarshipList'),
		},
		{
			path: '/apply',
			name: 'apply',
			component: loadView('ScholarshipApply'),
			beforeEnter: (to, from, next) => {
				// If no applications have been selected
				// console.log(store);
				if (Object.keys(store.state.selected_scholarships).length !== 0) {
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
