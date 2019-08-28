<template>
 <div class="content-wrapper" style="min-height: 1126px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2>
        {{user.name}} Profile
      </h2>
    
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" :src="`/img/S/${user.profile.image}`" alt="User profile picture">

              <h3 class="profile-username text-center">{{user.profile.full_name}}</h3>

              <p class="text-muted text-center">{{user.role}}</p>

              <ul class="list-group list-group-unbordered">
                
                <li class="list-group-item">
                  <b>Recipe Book</b> <a class="pull-right">{{user.likes}}</a>
                </li>
                <li class="list-group-item">
                  <b>Comments</b> <a class="pull-right">{{user.comments}}</a>
                </li>
              </ul>

             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary my-5">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              

              <p class="text-muted">
                {{user.profile.about}}
              </p>

              <hr>

           

             

            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="" ><a href="#RecipeBook" @click="loadRecipeBook"  data-toggle="tab" aria-expanded="true"  class="nav-link active" >Recipe Book</a></li>
              <li class=""><a @click="loadComments" href="#timeline" data-toggle="tab" aria-expanded="true" class="nav-link">Comments</a></li>             
              <li class=""><a @click="settings" href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">Settings</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane mt-4 active" id="RecipeBook">
           <!-----------Recipes------------>
                  <div class="row justify-content-center">
                    <div v-for="likedRecipe in recipeBook.data" :key="likedRecipe.id" class="col-md-4" >             
                      <div class="card my-card">
                       <div class="archive-like mb-3 single_recipe_info_text image">
                        <p @click="togleLike" class="heart py-2"><i @click="togleLike(likedRecipe.recipe.likes[0].like)"
                        :class="{'fas':likedRecipe.recipe.likes[0].like, 'far':!likedRecipe.recipe.likes[0].count }"
                         class="fa-heart"></i><span class="text-dark">({{likedRecipe.recipe.likes[0].count}})</span></p>
                           <div class="image">
                                <a :href="`/recipes/${likedRecipe.recipe.slug}`">
                                 <img :src="`/img/MD/${likedRecipe.recipe.image}`" width="100%" height="300">
                                 </a>
                            </div> 
                          <div class="card-body archive align-items-center">
                            <div class="card-title  d-flex justify-content-center">
                              <a :href="`/recipes/${likedRecipe.recipe.slug}`"><h2>{{likedRecipe.recipe.title}} </h2></a>
                          </div>
                      
                         

                         
                        </div>                    
                         

                         
                        </div>
                         <div class="card-footer  team-icons d-flex  justify-content-around">

                            <span><i class="fas fa-utensils mr-2"></i>{{likedRecipe.recipe.servings}}</span>
                            <span><i class="far fa-clock mr-2"></i>{{likedRecipe.recipe.time}}</span>
                            <span><i class="far fa-chart-bar mr-2"></i></i>{{likedRecipe.recipe.dificulty}}</span>
                            <span><i class="fas fa-star mr-2"></i></i>{{likedRecipe.recipe.score | numberFormat}}</span>

                        </div>
                      </div>
              
                    </div>


      <!-----------End Recipes------------>

           
                   </div>
          <pagination :data="recipeBook"  @pagination-change-page="paginateRecipeBook"></pagination>
        <!-- Comments ------------------------------>
                 </div>
              <!-- /.tab-pane -->
              <div class="tab-pane mt-4 " id="timeline">
                <!-- The timeline -->
                <ul v-for="(comment, index) in comments.data" class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red">
                          {{comment.time}}
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-comments bg-yellow"></i>

                    <div class="timeline-item">
                     
                      <h3 class="timeline-header d-flex justify-content-between align-middle"><a :href="`/recipes/${comment.recipe.slug}`">{{comment.recipe.title}}
                        </a><p ><span class="font-weight-bold">score</span><i class="fas fa-star"></i> {{comment.score}}
                                <span v-if="comment.user_notification == 0"
                                class="notification" 
                                @click="checked(comment.id)">remove notification</span></p>
            
    
                        
                      </h3>
                      <div   class="timeline-body" v-html="comment.comment"></div>
        
 
                      
                      <div class="timeline-footer">
                          <ul v-for="(reply, index) in comment.replies" class="timeline timeline-inverse">
                              <!-- timeline time label -->
                              <li class="time-label">
                                    <span class="bg-red">
                                      {{reply.time}}
                                    </span>
                              </li>
                              <!-- /.timeline-label -->
                              <!-- timeline item -->
                              <li>
                                <i class="fa fa-comments bg-yellow"></i>

                                <div class="timeline-item">
                                 
                                  <h3 class="timeline-header d-flex justify-content-between align-middle"><a :href="`/recipes/${reply.recipe.slug}`">{{reply.recipe.title}}
                                    </a>
                        

                                    
                                  </h3>
                                  <div   class="timeline-body" v-html="reply.comment"></div>
                    
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item --> 
                </ul>
                             
                       
                      
                        
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item --> 
                </ul>

          <pagination :data="comments"  @pagination-change-page="paginateComments"></pagination>
              </div>
              <!-- /.tab-pane -->
        <!----- End Comments ------------------------------>
         

              <div class="tab-pane mt-4" id="settings">
                <form  @submit.prevent="updateProfile()" class="form-horizontal">
                  <div class="form-group">
                        <input v-model="userForm.name" type="text" name="name" id="name" placeholder="name" 
                              class="form-control" :class="{'is-invalid': userForm.errors.has('name')}">
                              <has-error :form="userForm" field="name"></has-error>
                     </div>
                  <div class="form-group">
                       <input v-model="userForm.full_name" type="text" name="full_name" id="full_name" placeholder="full_name" 
                              class="form-control" :class="{'is-invalid': userForm.errors.has('full_name')}">
                              <has-error :form="userForm" field="full_name"></has-error>
                     </div>
                  
                  <div class="form-group">
                   <textarea v-model="userForm.about"  name="about" id="about" placeholder="about" class="form-control" :class="{'is-invalid': userForm.errors.has('about')}"></textarea>
                              <has-error :form="userForm" field="about"></has-error>
                  </div>
                  <div class="form-group">
                      <input v-model="userForm.email" type="text" name="email" id="email" placeholder="email" 
                              class="form-control" :class="{'is-invalid': userForm.errors.has('email')}">
                              <has-error :form="userForm" field="email"></has-error>
                    </div>
                
                 
                  <div class="form-group">
                  
                    <div v-if="!userForm.imageUpload.image"> 
                    <img class="profile-user-img img-responsive img-circle" :src="`/img/S/${user.profile.image}`" alt="User profile picture">                            
                         <label class="custom-file-upload d-flex mt-2 mb-4"> 
                            <input  style="display: none" type="file" @change="onFileChange(userForm.imageUpload, $event)">Change Image 
                         </label> 
                        </div>
                        <div v-else>
                          <img :src="userForm.imageUpload.image" class="profile-user-img img-responsive img-circle">
                          <button @click="removeImage(userForm.imageUpload)">Cancel</button>
                        </div>
                       
                  </div>
                
                   
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <a @click="editProfile = true" v-if='!editProfile'  class="edit"><i class="fas fa-edit"></i> Edit</a> 
                      <a v-if='editProfile' @click="updateProfile()" class="edit"><i class="fas fa-edit"></i> Edit</a>
                      <a v-if='editProfile' @click="settings" class="cancel">Cancel</a>

                    </div>
                  </div>
                </form>
                
              </div>
              <!-- /.tab-pane -->
            
       
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
    </div>
      <!-- /.row -->


   


    </section>
    <!-- /.content -->
  </div>
</template>

<script>
 import { mapActions } from 'vuex';

    export default {


        data(){
            return{             
               
                user:{},
                editProfile: false,
                userForm: new Form({
                   id: '',
                   name: '',                           
                   email: '',                  
                 
                   imageUpload:{
                    image: false,
                    name: ''
                   },           
                  about: '',
                  image: '',
                  full_name: ''
                }),
                                
                recipeBook:{},
                like: '',
                
              
            }
        },

        methods:{
            loadProfile(){
               axios.get(`/profile`)
                      .then(({data}) =>{
                        this.user = data.data;
                      })
            },
            settings(){
               this.userForm.id = this.$gate.idUser();
               
               this.userForm.name = this.user.name;              
               this.userForm.email = this.user.email;
               this.userForm.image = this.user.profile.image;
               this.userForm.full_name = this.user.profile.full_name;
               this.userForm.about = this.user.profile.about;
               this.editProfile = false;
            },
           
            updateProfile(){
               let vm = this;
                this.userForm.put(`/profile`)
                             .then(()=>{
                                toast.fire({
                                  type: 'success',
                                  title: 'Profile updated successfully'
                                 })
                               vm.editProfile = false; 
                               vm.loadProfile();
                              })
                            .catch((error) => {
                               if (error.response) {
                              toast.fire({
                              type: 'error',
                              title: error.response.data.message
                            })               
                           } 
                        } );
            },
            onFileChange(item, e) {
              let files = e.target.files || e.dataTransfer.files;
              let name = e.target.files[0].name
              if (!files.length)
                return;
              this.createImage(item, files[0], name);
           
            },
            createImage(item, file, name) {
              let image = new Image();
              let reader = new FileReader();

              reader.onload = (e) => {
                item.image = e.target.result; 
                item.name = name; 

              };
              reader.readAsDataURL(file);
            },
            removeImage: function (item) {
              item.image = false; 
                    }, 
   
            
            loadRecipeBook(){
                axios.get(`/my-likes`)
                      .then(({data}) =>{
                        this.recipeBook = data;
                      })
            },
            paginateRecipeBook(page = 1){
               axios.get(`/my-likes?page=` + page)
                    .then(data => {
                       this.recipeBook = data.data;
                      });
        },
        togleLike(like){
                  let vm = this;
                  axios.post('/like',{
                    like: like,
                  })
                     .then(({data}) => {
                      vm.loadRecipeBook();
                                        
                     }) 
                },
        checked(id){

             this.$store.dispatch('approved', id );

          },         
        ...mapActions([                  
                'loadComments',
                'paginateComments',
                'approved',
                'commentDelete',
                'reply'
              ]),
               
      },
       computed: {
          
        comments(){
              return this.$store.state.comments;
           }
        },
        created(){            
            this.$store.dispatch('loadComments'); 
        },
      filters: {
         round: function(value){
           return Math.round(value);
         },
         numberFormat: function(value){
          
          if(value != null){
           value = (Math.round(value * 10) / 10).toFixed(1);

           return value;
         }else{
          return value;
         }
        }
      },
        created(){
          this.loadRecipeBook();
          this.loadProfile();
          
        }
    }
</script>
 