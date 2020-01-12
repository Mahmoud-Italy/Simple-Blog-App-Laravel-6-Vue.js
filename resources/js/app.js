require('./bootstrap');
   
window.Vue = require('vue');
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import store from './store';
import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

import { i18n } from './locales.js';

import VueApexCharts from 'vue-apexcharts';
Vue.use(VueApexCharts);
Vue.component('apexchart', VueApexCharts);

import VueNoty from 'vuejs-noty';
import 'vuejs-noty/dist/vuejs-noty.css';
Vue.use(VueNoty, {
    timeout: 4000,
    progressBar: true,
    layout: 'bottomRight'
});

import VoerroTagsInput from '@voerro/vue-tagsinput';
Vue.component('tags-input', VoerroTagsInput);

Vue.config.productionTip = false;

const routes = [

    // ** FRONTEND ** \\

    // HOME
    { path: '/', name: 'home', component: require('./components/frontend/posts/List.vue').default },
    { path: '/post/:name/:id', name: 'show', component: require('./components/frontend/posts/Show.vue').default },
    
    // CONTACT US
    { path: '/contact', name: 'contact', component: require('./components/frontend/contact/List.vue').default },
    
    // AUTH
    { path: '/signup', name: 'signup', component: require('./components/frontend/auth/Signup.vue').default, beforeEnter: requireUnAuth },
    { path: '/verify', name: 'verify', component: require('./components/frontend/auth/Verify.vue').default, beforeEnter: requireUnAuth },
    { path: '/login', name: 'login', component: require('./components/frontend/auth/Login.vue').default, beforeEnter: requireUnAuth },
    { path: '/forgot', name: 'forgot', component: require('./components/frontend/auth/Forgot.vue').default, beforeEnter: requireUnAuth},
    { path: '/reset', name: 'reset', component: require('./components/frontend/auth/Reset.vue').default, beforeEnter: requireUnAuth },


    // ** BACKEND ** \\

    // DASHBOARD
    { path: '/dashboard/explore', name: 'dashboard', component: require('./components/backend/layouts/Dashboard.vue').default, beforeEnter: requireAuth },
    { path: '/dashboard/login', name: 'cp-login', component: require('./components/backend/auth/Login.vue').default, beforeEnter: requireUnAuth },

    // POSTS
    { path: '/dashboard/posts', name: 'posts', component: require('./components/backend/posts/List.vue').default, beforeEnter: requireAuth },
    { path: '/dashboard/post/create', name: 'post-create', component: require('./components/backend/posts/Create.vue').default, beforeEnter: requireAuth },
    { path: '/dashboard/post/edit/:id', name: 'post-edit', component: require('./components/backend/posts/Edit.vue').default, beforeEnter: requireAuth },

    // COMMENTS
    { path: '/dashboard/comments', name: 'comments', component: require('./components/backend/comments/List.vue').default, beforeEnter: requireAuth },

    // MEMBERS
    { path: '/dashboard/members', name: 'members', component: require('./components/backend/users/Members.vue').default, beforeEnter: requireAuth },

    // AUTHORS
    { path: '/dashboard/authors', name: 'authors', component: require('./components/backend/users/Authors.vue').default, beforeEnter: requireAuth },

    // MESSAGES
    { path: '/dashboard/messages', name: 'messages', component: require('./components/backend/messages/List.vue').default, beforeEnter: requireAuth },
    { path: '/dashboard/message/:id', name: 'message-show', component: require('./components/backend/messages/Show.vue').default, beforeEnter: requireAuth },
    
    // SETTINGS
    { path: '/dashboard/settings', name: 'settings', component: require('./components/backend/settings/appSetting.vue').default, beforeEnter: requireAuth },
    
    // UTILITES
    { path: '/access-denied', name: 'access-denied', component: require('./components/backend/utility/AccessDenied.vue').default },
    { path: '*', name: 'not-found', component: require('./components/backend/utility/404.vue').default },
]
  

function requireAuth(to, from, next) {
  store.dispatch('fetchAccessToken');
  if (!store.state.accessToken) { next('/'); } 
  else { next(); }
}

function requireUnAuth(to, from, next) {
  store.dispatch('fetchAccessToken');
  if (store.state.accessToken) { next('/dashboard'); } 
  else { next(); }
}

const router = new VueRouter({
  mode: 'history',
  base: '/',
  fallback: true,
  routes 
})

const app = new Vue({
  i18n,
  router
}).$mount('#app')
