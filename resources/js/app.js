
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'; 
import {store} from 'store';
import CKEditor from '@ckeditor/ckeditor5-vue';
import {Form , HasError, AlertError} from 'vform';

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.use(CKEditor);
Vue.use(VueRouter);



const users = Vue.component('user-component', require('./components/user/Users.vue').default);
const dashboard = Vue.component('dashboard-component', require('./components/dashboard/Dashboard.vue').default);
const profile = Vue.component('profile-component', require('./components/user/Profile.vue').default);

Vue.component('recipes-component', require('./components/Recipes.vue').default);
Vue.component('fridge-component', require('./components/Fridge.vue').default);
Vue.component('score-component', require('./components/Score.vue').default);
const addRecipe = Vue.component('create-recipe-component', require('./components/recipes/CreateRecipe.vue').default);
Vue.component('tag-component', require('./components/Tag.vue').default);
Vue.component('gallery-component', require('./components/Gallery.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));

const routes = [
  { path: '/dashboard', component: dashboard},
  { path: '/add-recipe', component: addRecipe},
  { path: '/users', component: users},
  { path: '/profile', component: profile},
  { path: '/score', component:  require('./components/Score.vue').default}
]

const router = new VueRouter({
   mode: 'history',
  routes // short for `routes: routes`
});



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,
    router,
   
});
