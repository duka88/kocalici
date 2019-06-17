
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

Vue.use(CKEditor);
Vue.use(VueRouter);

const routes = [
  { path: '/cake', component:  require('./components/recipes/Cake.vue').default},
  { path: '/cookie', component:  require('./components/recipes/Cookie.vue').default},
  { path: '/recipes', component: require('./components/Recipes.vue').default},
  { path: '/score', component:  require('./components/Score.vue').default}
]

const router = new VueRouter({
   mode: 'history',
  routes // short for `routes: routes`
});

Vue.component('recipes-component', require('./components/Recipes.vue').default);
Vue.component('fridge-component', require('./components/Fridge.vue').default);
Vue.component('score-component', require('./components/Score.vue').default);
Vue.component('create-recipe-component', require('./components/CreateRecipe.vue').default);
Vue.component('tag-component', require('./components/Tag.vue').default);
Vue.component('gallery-component', require('./components/Gallery.vue').default);




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
