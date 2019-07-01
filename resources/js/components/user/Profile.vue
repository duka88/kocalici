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
                  <b>Posted Recipes</b> <a class="pull-right">{{user.recipes}}</a>
                </li>
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
              <li class="" ><a href="#RecipeBook" @click="loadRecipeBook"  data-toggle="tab" aria-expanded="true"  class="nav-link active" active>Recipe Book</a></li>
              <li class=""><a @click="loadComments" href="#timeline" data-toggle="tab" aria-expanded="true" class="nav-link">Comments</a></li>
              <li class=""><a href="#activity" @click="loadRecipes"  data-toggle="tab" aria-expanded="false" class="nav-link">Posted Recipes</a></li>
              <li class=""><a @click="settings" href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">Settings</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="RecipeBook">
           <!-----------Recipes------------>
                  <div class="row justify-content-center">
                    <div v-for="likedRecipe in recipeBook.data" :key="likedRecipe.id" class="col-md-4" >             
                      <div class="card my-card">
                          <div class="col-12 mb-3 single_recipe_info_text image">
                    <p @click="togleLike" class="heart py-2"><i @click="togleLike(likedRecipe.recipe.likes[0].like)"
                    :class="{'fas':likedRecipe.recipe.likes[0].like, 'far':!likedRecipe.recipe.likes[0].count }"
                     class="fa-heart"></i><span class="text-dark">({{likedRecipe.recipe.likes[0].count}})</span></p>
                    <img class="single_recipe_img w-100" :src="`/img/MD/${likedRecipe.recipe.image}`" width="480px" height="480px">
                  </div>  
                        <div class="card-body">
                          <div class="card-title d-flex justify-content-center">
                            <a href="<?php the_permalink(); ?>"class="text-capitalize btn card-link  " >{{likedRecipe.recipe.title}}</a>
                          </div>
                          <div class="row">
                              <div class="col-lg-6 ">
                                   <h4 class="primary-color d-flex justify-content-center"><i class="fas fa-dollar-sign "></i> 45</h4>
                             <h4 class="primary-color d-flex justify-content-center"><i class="far fa-clock"></i>60 min</h4>
                              </div>
                              <div class="col-lg-6  d-flex justify-content-center ">
                                  <h2 class="prosek "><i class="fas fa-utensils"></i>{{likedRecipe.recipe.score }}</h2>
                              </div>
                          </div>
                         

                         
                        </div>
                        <div class="card-footer  team-icons d-flex justify-content-between">

                          <a href="#"><i class="fab fa-facebook social-link"></i></a><a href="#"><i class="fab fa-instagram social-link"></i></a><a href="#"><i class="fab fa-twitter social-link"></i></a><a href="#"><i class="fab fa-yelp social-link"></i></a>

                        </div>
                      </div>
              
                    </div>


      <!-----------End Recipes------------>

           
                   </div>
          <pagination :data="recipeBook"  @pagination-change-page="paginateRecipeBook"></pagination>
        <!-- Comments ------------------------------>
                 </div>
              <!-- /.tab-pane -->
              <div class="tab-pane active" id="timeline">
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
                     
                      <h3 class="timeline-header d-flex justify-content-between align-middle"><a href="#">{{comment.recipe.title}}
                        </a><p v-if="!commentEdit"><span class="font-weight-bold">score</span><i class="fas fa-star"></i> {{comment.score}}</p>
                               <input  v-if="commentEdit"
                          v-model="commentForm.score" type="range" step="0.01" name ="score" min="1" max="10" value="5" class="form-control w-25" id="score">
                         <span  v-if="commentEdit">{{commentForm.score | round}}</span>            

                        
                      </h3>
                      <div  v-if="!commentEdit" class="timeline-body" v-html="comment.comment"></div>
                 <div class="form-gropup mb-4">    
            <ckeditor  v-if="commentEdit" :editor="editor" v-model="commentForm.comment" :config="editorConfig"></ckeditor>
        </div>
 
                      
                      <div class="timeline-footer">
                        <a v-if="!commentEdit" @click="editComments(comment)" class="btn btn-primary btn-xs">Edit</a>
                         <a v-if="commentEdit" @click="updateComments" class="btn btn-success btn-xs">Done</a>
                        <a v-if="!commentEdit" @click="deleteComment(comment.id)" class="btn btn-danger btn-xs">Delete</a>
                         <a v-if="commentEdit" @click="commentEdit = false" class="btn btn-warning btn-xs">Cancel</a>
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
         

              <div class="tab-pane" id="settings">
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
                       <input v-model="userForm.password" type="password" name="password" id="password" placeholder="password" 
                              class="form-control" :class="{'is-invalid': userForm.errors.has('password')}">
                              <has-error :form="userForm" field="password"></has-error>
                    </div>  
                 
                  <div class="form-group">
                  
                    <div v-if="!userForm.imageUpload.image"> 
                    <img class="profile-user-img img-responsive img-circle" :src="`/img/S/${user.profile.image}`" alt="User profile picture">                            
                         <label class="custom-file-upload"> 
                            <input  style="display: none" type="file" @change="onFileChange(userForm.imageUpload, $event)">Edit Image 
                         </label> 
                        </div>
                        <div v-else>
                          <img :src="userForm.imageUpload.image" class="profile-user-img img-responsive img-circle">
                          <button @click="removeImage(userForm.imageUpload)">Cancel</button>
                        </div>
                       
                  </div>
                
                   
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary">Edit</button>
                     

                    </div>
                  </div>
                </form>
                <button @click="settings" class="btn btn-warning">Cancel</button>
              </div>
              <!-- /.tab-pane -->
            
            <div class="tab-pane" id="activity">
           <!-----------Recipes------------>
                  <div class="row justify-content-center">
                    <div v-for="recipe in recipes.data" :key="recipe.id" class="col-md-4" >             
                      <div class="card my-card">
                         <img :src="`/img/MD/${recipe.image}`" width="480px" height="300">
                        <div class="card-body">
                          <div class="card-title d-flex justify-content-center">
                            <a href="<?php the_permalink(); ?>"class="text-capitalize btn card-link  " >{{recipe.title}}</a>
                          </div>
                          <div class="row">
                              <div class="col-lg-6 ">
                                   <h4 class="primary-color d-flex justify-content-center"><i class="fas fa-dollar-sign "></i> 45</h4>
                             <h4 class="primary-color d-flex justify-content-center"><i class="far fa-clock"></i>60 min</h4>
                              </div>
                              <div class="col-lg-6  d-flex justify-content-center ">
                                  <h2 class="prosek "><i class="fas fa-utensils"></i>{{recipe.avg }}</h2>
                              </div>
                          </div>
                         

                         
                        </div>
                        <div class="card-footer  team-icons d-flex justify-content-between">

                          <a href="#"><i class="fab fa-facebook social-link"></i></a><a href="#"><i class="fab fa-instagram social-link"></i></a><a href="#"><i class="fab fa-twitter social-link"></i></a><a href="#"><i class="fab fa-yelp social-link"></i></a>

                        </div>
                      </div>
              
                    </div>


      <!-----------End Recipes------------>

           
                   </div>
          <pagination :data="recipes"  @pagination-change-page="paginateRecipes"></pagination>
            </div>
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
 import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    export default {


        data(){
            return{
                editor: ClassicEditor,                
                editorConfig: {
                    toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],

                },
                user:{},
                userForm: new Form({
                   id: '',
                   name: '',                           
                   email: '',                  
                   password: '',
                   imageUpload:{
                    image: false,
                    name: ''
                   },           
                  about: '',
                  image: '',
                  full_name: ''
                }),
                recipes:{},                
                recipeBook:{},
                like: '',
                comments: {},
                commentForm: new Form({
                    id: '',
                    comment: '',
                    score: ''
                   
                }),
                commentEdit: false,

            }
        },

        methods:{
            loadProfile(){
               axios.get(`/api/profile/${this.$gate.idUser()}`)
                      .then(({data}) =>{
                        this.user = data.data;
                      })
            },
            settings(){
               this.userForm.id = this.$gate.idUser();
                this.userForm.password = this.user.password;
               this.userForm.name = this.user.name;              
               this.userForm.email = this.user.email;
               this.userForm.image = this.user.profile.image;
               this.userForm.full_name = this.user.profile.full_name;
               this.userForm.about = this.user.profile.about;
            },
            updateProfile(){
               let vm = this;
                this.userForm.put(`/profile`)
                             .then(()=>{
                               vm.loadProfile();
                              })
                             
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
            loadRecipes(){

               axios.get(`/api/users_recipe/${this.$gate.idUser()}`)
                      .then(({data}) =>{
                        this.recipes = data;
                      })
              
            },
            paginateRecipes(page = 1){
               axios.get(`/api/users_recipe/${this.$gate.idUser()}?page=` + page)
                    .then(data => {
                        this.recipes = data.data;
                      });
             
            },
            loadComments(){
              axios.get(`/api/users_comments/${this.$gate.idUser()}`)
                   .then(({data}) => {
                    this.comments = data;
                   })
            },
            paginateComments(page = 1){
               axios.get(`/api/users_comments/${this.$gate.idUser()}?page=` + page)
                    .then(data => {
                       this.comments = data.data;
                      });
             
            },
            editComments(comment){
              this.commentEdit = true;
              this.commentForm.fill(comment);
            },
            updateComments(){
              let vm = this;
              this.commentForm.put(`/api/update_comment/${this.commentForm.id}`)
                              .then(()=>{
                                vm.loadComments();
                                this.commentEdit = false;
                              })
            },
            deleteComment(id){
                let vm = this;
                axios.delete(`/api/comment/${id}`)
                      .then(()=>{
                                vm.loadComments();                               
                              })
            },
            loadRecipeBook(){
                axios.get(`/api/my-likes/${this.$gate.idUser()}`)
                      .then(({data}) =>{
                        this.recipeBook = data;
                      })
            },
            paginateRecipeBook(page = 1){
               axios.get(`/api/my-likes/${this.$gate.idUser()}?page=` + page)
                    .then(data => {
                       this.recipeBook = data.data;
                      });
        },
        togleLike(like){
                  let vm = this;
                  axios.post('/api/like',{
                    like: like,
                  })
                     .then(({data}) => {
                      vm.loadRecipeBook();
                                        
                     }) 
                },
      },
      filters: {
         round: function(value){
           return Math.round(value);
         }
      },
        created(){
          this.loadRecipeBook();
          this.loadProfile();
          
        }
    }
</script>
