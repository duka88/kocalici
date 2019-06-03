<template>
    <div class="container">
        <div class="row justify-content-center">
            <div v-for="recipe in recipes" :key="recipe.id" class="col-md-4" >             
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
          <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="loadRecipes(pagination.prev_page_url)">Previous</a></li>

          <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
      
          <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item" ><a class="page-link" href="#" @click="loadRecipes(pagination.next_page_url)">Next</a></li>
        </ul>
      </nav>
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
                pagination: {},
            }
        },
        methods: {
            loadTags(){
                axios.get('api/fridge')
                      .then(({data}) =>{
                        this.tags = data.data
                      })
                      .catch(error => {
                        console.log(error);
                      })
            },
            searchedRecipes(page_url){
               let vm = this;

               axios({
                    method: 'post',
                    url: '/api/fridge/',
                    data: {
                      tag: this.searchRecipes
                    }
                  })
                 .then(({data}) => {
                    this.recipes = data.data;
                    console.log(data.meta, data.links);
                    vm.makePagination(data.meta, data.links);
                    
                 })
            },
            makePagination(meta, links) {
              let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
              };

                this.pagination = pagination;
            },

        },
            created(){
                this.loadTags();
        }
    }
</script>
