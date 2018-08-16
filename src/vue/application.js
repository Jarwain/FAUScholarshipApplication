import Vue from 'vue';
import router from '@/routers/application';
import store from '@/stores/application';

Vue.config.productionTip = false;

new Vue({
	router,
	store,
}).$mount('#app');
