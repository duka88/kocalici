<template>
  <div class="d-flex justify-content-between">
   <div @keyup.esc="overlayClose">
    <form @submit.prevent="searchIt" class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="" @click="overlayOpen" @keyup="searchRecipe"  v-model="search" type="text" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="news-button" >
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
   <transition name="search" tag="div" class="row justify-content-center" mode="out-in">  
    <div class="contaier " v-if="overlay">
      
       <div class="row overlay"> 
         <div class="col ">
             <p @click="overlayClose" class="close-search text-danger">X</p>
             <VuexRecipe></VuexRecipe>
         </div>
            
       </div> 
     
    </div>
   </transition>   
   </div> 
  
    <ul v-if="$gate.getAuth()"  class="navbar-nav ml-auto">
    
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown" >
        <a class="nav-link notification" data-toggle="dropdown" href="#">
          <i class="far fa-comments "></i>
          <span v-if="comments.length > 0 && $gate.isAdmin()" class="badge badge-danger navbar-badge ">{{comments[0].admin_count}}</span>
          <span v-else-if="comments.length " class="badge badge-danger navbar-badge ">{{comments.length}}</span>
        </a>
        <div class="dropdown-menu notification-meny dropdown-menu-lg dropdown-menu-right">
          <a v-for="comment in comments" @click="checked(comment.id)" class="dropdown-item ">
            <!-- Message Start -->
            <div class="media">              
             <!--<img v-if="comment.user.profile" :src="`/img/XS/${comment.user.profile}`" alt="User Avatar" class="img-size-50 mr-3 img-circle">-->
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  {{comment.recipe.title}}
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i>{{comment.score }}</span>
                </h3>
                <p class="text-sm" v-html="">{{comment.excerpt}}</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{comment.time}}</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
         
          <div class="dropdown-divider"></div>
           <router-link v-if="$gate.isAdmin()" to="/get-comments" class="dropdown-item dropdown-footer">See All Messages</router-link> 
           <p v-else @click="redirect" class="dropdown-item dropdown-footer">See All Messages</p>  
        </div>
         
      </li>
      <!-- Notifications Dropdown Menu -->
     
  
  
    </ul>

 </div>  
</template>

<script>
    import { mapActions } from 'vuex';
    export default {

        data(){
            return{
                overlay: false,
                search:'',
                location: ''
               
              
            }
        },
        methods: {
          redirect(){
             window.location.replace('/my_profile');
          },
            searchRecipe: _.debounce(function(){

             
              this.$store.dispatch('searchIt',
               {search: this.search, category: 0, order: 'created_at', direction: 'desc' });
               }, 500),
           
            overlayOpen(event){
                this.overlay = true;
                this.$store.commit( 'toggleOverlay',true);
               
                document.documentElement.classList.add('overlay-active');
            },
            overlayClose(){
                this.overlay = false;
                this.$store.commit( 'toggleOverlay',false);
                
                this.search= '';
                document.documentElement.classList.remove('overlay-active');
            },
            checked(id){
             this.$store.dispatch('approved', id );
             
           },
           logout(){
              axios.post('logout')
                  .then(()=>{
                     window.location.replace("/");
                  }) 

           },
           
          
          
            ...mapActions([               
                'searchIt',
                'loadComments',
                'loadNotifications',
                'approved'
              ]),
            
        },
        computed: {
           
           comments(){
              return this.$store.state.notifications;
           }
        },
         created(){  
           this.location = document.title;          
            this.$store.dispatch('loadNotifications'); 
        },
     
        filters: {
           round: function(value){
             return Math.round(value);
           }
        },    
    }
</script>