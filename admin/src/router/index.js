import Vue from 'vue';
import Router from 'vue-router';
import Home from '@/components/Home';
import ScholarshipViewer from '@/components/ScholarshipViewer';
import ScholarshipEditor from '@/components/ScholarshipEditor';
import Scholarship from '@/components/Scholarship';
import ScholarshipScreen from '@/components/ScholarshipScreen';

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home,
    },
    {
      path: '/scholarship',
      component: ScholarshipScreen,
      children: [
        {
          path: '',
          redirect: 'view',
        },
        {
          path: 'view',
          component: ScholarshipViewer,
        },
        {
          path: 'add',
          component: ScholarshipEditor,
        },
        // EDIT will be a 'Mass Edit'
        // Priority: Low
        {
          path: 'edit',
          component: ScholarshipEditor,
        },
      ],
    },
    {
      path: '/scholarship/:id',
      component: Scholarship,
    },
    /*{
      path: '/application',
      name: 'Application',
      component: ApplicationViewer,
    },
    {
      path: '/search',
      name: 'Search',
      component: SearchViewer,
    }*/
  ],
});
