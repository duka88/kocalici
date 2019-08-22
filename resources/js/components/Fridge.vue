<template>
    <div class="container">
        <div class="row justify-content-center">
            <div v-for="recipe in recipes" :key="recipe.id" class="col-md-4" > 


               <p v-for='tag in recipe.tags'>
                 {{tag.name}}
               </p>


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
                          <h2 class="prosek "><i class="fas fa-utensils"></i> 50</h2>
                      </div>
                  </div>
                 

                 
                </div>
                <div class="card-footer  team-icons d-flex justify-content-between">

                  <a href="#"><i class="fab fa-facebook social-link"></i></a><a href="#"><i class="fab fa-instagram social-link"></i></a><a href="#"><i class="fab fa-twitter social-link"></i></a><a href="#"><i class="fab fa-yelp social-link"></i></a>

                </div>
              </div>
      
 
           </div>
      
        </div> 
        <div class="row justify-content-center">
            <form @submit.prevent="searchedRecipes">
               <div v-for='tag in tags'>
                <input type="checkbox" v-model="searchRecipes" :value="tag.id">{{tag.name}}
                <br>
               </div>
                <button type="submit" class="btn btn-success btn-block">Save</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                tags: {},
                recipes: {},
                searchRecipes:[],
               
            }
        },
        methods: {
            loadTags(){
                axios.get('/api/fridge')
                      .then(({data}) =>{
                        this.tags = data.data
                      })
                      .catch(error => {
                        console.log(error);
                      })
            },
            searchedRecipes(page_url){
             
             
                 axios.get(`/api/fridged?tag=${this.searchRecipes}`)
               
                 .then(({data}) => {
                    this.recipes = data.data;                                   
             
                 })
            },
        

        },
            created(){
                this.loadTags();
        }
    }
</script>

