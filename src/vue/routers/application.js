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
			path: '/',
			alias: '/list',
			name: 'list',
			component: loadView('ScholarshipList'),
		},
		{
			path: '/apply',
			name: 'apply',
			component: loadView('ScholarshipApply'),
			beforeEnter: (to, from, next) => {
				// If no applications have been selected
				console.log(store.state.selected_scholarships);
				if (store.state.selected_scholarships.length === 0) {
					next({ name: 'list' });
				}
				next();
			},
		},
		{
			path: '*',
			name: '404',
			redirect: { name: 'list' },
		},
	],
});

export default router;
