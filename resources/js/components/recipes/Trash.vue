<template>
    <div class="container">
               <div class="card"  >
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>
                <form @submit.prevent="searchRecipe" class="form-inline ml-3">
                      <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar"  @keyup="searchRecipe"  v-model="search" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                          <button class="btn btn-navbar" >
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </form>
              <div class="card-tools">
                    <router-link to="/add-recipe" class="nav-link">                       
                        <p class="text-success">ADD RECIPE</p>
                      </router-link>
              </div>
             
              </div>     
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th @click="Sort('category_id')">Category <i class="fas "
                      :class="{'fa-chevron-down':recipeDirection == 'DESC' && recipeSort=='category_id', 'fa-chevron-up':recipeDirection == 'ASC'  && recipeSort=='category_id' }"></i></th>
                    <th @click="Sort('title')">Title <i class="fas" 
                      :class="{'fa-chevron-down':recipeDirection == 'DESC' && recipeSort=='title', 'fa-chevron-up':recipeDirection== 'ASC'  && recipeSort=='title' }"></i></th>
                    <th @click="Sort('score')">Avg <i class="fas"
                      :class="{'fa-chevron-down':recipeDirection == 'DESC' && recipeSort=='score', 'fa-chevron-up':recipeDirection== 'ASC'  && recipeSort=='score' }"></i></th>
                    <th @click="Sort('likes')">Likes <i class="fas"
                      :class="{'fa-chevron-down':recipeDirection == 'DESC' && recipeSort=='likes', 'fa-chevron-up':recipeDirection== 'ASC'  && recipeSort=='likes' }"></i></th>
                    <th @click="Sort('created_at')">Created_at <i class="fas" 
                      :class="{'fa-chevron-down':recipeDirection == 'DESC' && recipeSort=='created_at', 'fa-chevron-up':recipeDirection== 'ASC'  && recipeSort=='created_at' }"></i></th>
                    <th>Modify</th>
                  </tr>
                  <tr v-for="recipe in recipes.data" :key="recipe.id">
                    <td>{{recipe.id}}</td>
                    <td>{{recipe.category}}</td>
                    <td>{{recipe.title}}</td>
                    <td>{{recipe.score }}</td>
                    <td>{{recipe.likes || 0}}</td>
                    <td>{{recipe.created_at}}</td>
                    <td >
                        <a @click="restoreRecipe(recipe.id)">                 
                          <i class="fas fa-redo text-success"></i>
                        </a> / 
                        <a @click="deleteRecipe(recipe.id)">
                            <i class="fa fa-trash text-danger"></i>
                        </a>
                       </td>
                  </tr>
                  
                </tbody></table>
              </div>       
                     


      <!-----------End Recipes------------>

           
        <div class="card-footer">          
          <pagination :data="recipes"  @pagination-change-page="paginate"></pagination>
        </div>
      </div>
   </div>
 </template>   
<script>
  export default {
      data(){
        return{ 
            search: '',
            recipeSort: 'created_at',
            recipeDirection: 'DESC',
            recipes: {}, 
        }
      },

  methods: {
        searchRecipe: _.debounce(function(){

             
              this.loadRecipes();
               }, 500),
       loadRecipes(){
           
            let search = 0;
            
            if(this.search){
                search = this.search;
            }

            axios.get(`/trash/${this.recipeSort}/${this.recipeDirection}/${search}`)
                 .then(({data})=>{
                    this.recipes = data;
                 })
        },
        Sort(value){
          
           this.recipeSort = value;
              if(this.recipeDirection == 'DESC'){
                 this.recipeDirection = 'ASC';
                this.loadRecipes();                                
               }else{
                this.recipeDirection = 'DESC';
                 this.loadRecipes(); 
               }  

        },
        paginate(page = 1){
            let search = 0;
            
            if(this.search){
                search = this.search;
            }
            axios.get(`/trash/${this.recipeSort}/${this.recipeDirection}/${search}?page=${page}`)
                 .then(({data})=>{
                    this.recipes = data;
                 })
        },
        deleteRecipe(id){
               let vm = this;

               swal.fire({
                      title: 'Are you sure?',
                      text: "You won't be able to revert this!",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                     if (result.value) {

                     axios.delete(`/recipe/${id}`)
                           .then(()=>{
                              toast.fire(
                              'Deleted!',
                              'Your file has been deleted.',
                              'success'
                              );
                              vm.loadRecipes();
                           })
                         }
                 })        
            },
        restoreRecipe(id){
           let vm = this;

           axios.get(`/restore/${id}`)
                .then(()=>{
                  toast.fire(
                        'success',
                        'Recipe has been restored.',
                        'success'
                              );

                   vm.loadRecipes();
                  
                })
        }    
      },
      created(){
        this.loadRecipes();
      }

      }
 </script>     