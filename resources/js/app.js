
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'; 
import {store} from './store';
import CKEditor from '@ckeditor/ckeditor5-vue';
import {Form , HasError, AlertError} from 'vform';
import Gate from "./gate";




Vue.prototype.$gate = new Gate(window.user);

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);



Vue.use(CKEditor);
Vue.use(VueRouter);

const categories = Vue.component('categories-component', require('./components/Categories.vue').default);
const allRecipe = Vue.component('create-recipe-component', require('./components/recipes/AllRecipe.vue').default);
const comments = Vue.component('comment-component', require('./components/Comments.vue').default);
const addRecipe = Vue.component('create-recipe-component', require('./components/recipes/CreateRecipe.vue').default);
const users = Vue.component('user-component', require('./components/user/Users.vue').default);
const profile = Vue.component('profile-component', require('./components/user/Profile.vue').default);
const login = Vue.component('login-component', require('./components/Login.vue').default);
const trash = Vue.component('create-recipe-component', require('./components/recipes/Trash.vue').default);

Vue.component('VuexRecipe', require('./components/VuexRecipe.vue').default);
Vue.component('footer-component', require('./components/Footer.vue').default)
Vue.component('recipes-component', require('./components/Recipes.vue').default);
Vue.component('fridge-component', require('./components/Fridge.vue').default);
Vue.component('score-component', require('./components/Score.vue').default);
Vue.component('ingredients-component', require('./components/recipes/Ingredients.vue').default);
Vue.component('tag-component', require('./components/Tag.vue').default);
Vue.component('gallery-component', require('./components/Gallery.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('search-component', require('./components/Search.vue').default);
Vue.component('edit-recipe-component', require('./components/recipes/EditRecipe.vue').default);

const routes = [
  { path: '/home', redirect: '/profile'},
  { path: '/categories', component: categories},
  { path: '/trash', component: trash},
  { path: '/all-recipe', component: allRecipe},
  { path: '/get-comments', component: comments},
 
  { path: '/add-recipe', component: addRecipe},
  { path: '/users', component: users},
  { path: '/profile', component: profile},
  { path: '/login', component: login},
  { path: '/score', component:  require('./components/Score.vue').default}
]

const router = new VueRouter({
   mode: 'history',
   
   routes // short for `routes: routes`
});


////////Alert////////////
import swal from 'sweetalert2';
window.swal = swal;
const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

axios.get('/api/user').then(response => {
   console.log(response.data);
   console.log(134);
});

window.toast = toast;

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
    data:{
      overlay: false  
    },
    methods:{
      overlayFn(value){
         console.log(value);
          this.overlay = value;   
      }
    }
  
   
});
