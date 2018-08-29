import Vue from 'vue';
import router from '@/routers/application';
import store from '@/stores/application';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faSpinner, faQuestionCircle } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faSpinner);
library.add(faQuestionCircle);

Vue.component('font-awesome-icon', FontAwesomeIcon);

Vue.config.productionTip = false;

new Vue({
	router,
	store,
}).$mount('#app');
