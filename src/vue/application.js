import Vue from 'vue';
import Router from 'vue-router';
import App from './views/Application.vue';

Vue.config.productionTip = false;

const router = new Router({
	mode: 'history',
	base: process.env.BASE_URL,
	routes: [
		{
			path: '/',
			name: 'home',
			component: Application.vue,
		},
		{
			path: '/about',
			name: 'about',
			// route level code-splitting
			// this generates a separate chunk (about.[hash].js) for this route
			// which is lazy-loaded when the route is visited.
			component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
		},
	],
});

new Vue({
	router,
	render: h => h(App),
}).$mount('#app');
