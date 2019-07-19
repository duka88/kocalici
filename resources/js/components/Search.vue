<template>
  <div class="d-flex justify-content-between w-100">
   <div @keyup.esc="overlayClose">
    <form @submit.prevent="searchIt" class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" @click="overlayOpen" @keyup="searchRecipe"  v-model="search" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" >
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    <div class="contaier " v-if="overlay">
       <div class="row overlay">
         <div class="col ">
             <button @click="overlayClose" class="btn btn-small btn-danger">X</button>
             <VuexRecipe></VuexRecipe>
         </div>
            
       </div> 
       
    </div>
   </div> 
    <ul class="navbar-nav ml-auto">
 
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown" >
        <a class="nav-link notification" data-toggle="dropdown" href="#">
          <i class="far fa-comments "></i>
          <span v-if="comments.length > 0" class="badge badge-danger navbar-badge ">{{comments[0].admin_count}}er</span>
        </a>
        <div class="dropdown-menu notification-meny dropdown-menu-lg dropdown-menu-right">
          <a v-for="comment in comments" @click="checked(comment.id)" class="dropdown-item ">
            <!-- Message Start -->
            <div class="media">
              <img :src="`/img/XS/${comment.user.profile}`" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  {{comment.recipe.title}}
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i>{{comment.score}}</span>
                </h3>
                <p class="text-sm" v-html="">{{comment.excerpt}}</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{comment.time}}</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
         
          <div class="dropdown-divider"></div>
           <router-link to="/get-comments" class="dropdown-item dropdown-footer">See All Messages</router-link> 

        </div>
         
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link notification" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
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
               
              
            }
        },
        methods: {
            searchRecipe: _.debounce(function(){

             
              this.$store.dispatch('searchIt',
               {search: this.search, category: 0, order: 'created_at', direction: 'desc' });
               }, 500),
           
            overlayOpen(event){
                this.overlay = true;
                this.$emit('overlay', true);
                document.documentElement.classList.add('overlay-active');
            },
            overlayClose(){
                this.overlay = false;
                this.$emit('overlay', false);
                document.documentElement.classList.remove('overlay-active');
            },
            checked(id){
             this.$store.dispatch('approved', id );
             
           },
            /*loadComments(){
               axios.get('/new_comments')
                    .then(({data})=>{
                       this.comments = data;
                    }) 
            },*/
          
          
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
            this.$store.dispatch('loadNotifications'); 
        },
     
        filters: {
            slice: function(value){
              
              let slice = value.slice(0,50); 
             return `${slice}...`;
            }
        },    
    }
</script>