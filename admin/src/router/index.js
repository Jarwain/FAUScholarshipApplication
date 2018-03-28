import Vue from 'vue';
import Router from 'vue-router';
import ScholarshipList from '@/components/ScholarshipList';
import ScholarshipEditor from '@/components/ScholarshipEditor';
import ScholarshipView from '@/components/ScholarshipView';

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      alias: ['/scholarships', '/scholarships/view'],
      component: ScholarshipList,
    },
    {
      path: '/scholarships/add',
      component: ScholarshipEditor,
    },
    {
      path: '/scholarships/view/:id',
      component: ScholarshipView,
      props: true,
    },
  ],
});
