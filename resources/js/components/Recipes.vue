<template>
    <div class="container">
        <ul>
            <li><button  @click="selectCategory(0)">All</button></li>
            <li><button  @click="selectCategory(1)">Cake</button></li>
            <li><button  @click="selectCategory(2)">Cookie</button></li>
            
        </ul>
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
         <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="loadRecipes(pagination.prev_page_url)">Previous</a></li>

          <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
      
          <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item" ><a class="page-link" href="#" @click="loadRecipes(pagination.next_page_url)">Next</a></li>
        </ul>
      </nav>
    </div>
</template>

<script>
    export default {
       data(){
        return {
          category: 0,
          recipes: {},
          recipe_id: '',
          pagination: {},
        }
       },
       methods: {
         loadRecipes(page_url){
          let vm = this;
          page_url = page_url || `api/recipes/${this.category}`
            axios.get(page_url)
                 .then(({data}) => {
                    this.recipes = data;
                    vm.makePagination(data.meta, data.links);
                               
                 })
               .catch(error => {
              console.log(error)
            });
         },
        
       makePagination() {
      let pagination = {
        current_page: this.recipes.meta.current_page,
        last_page: this.recipes.meta.last_page,
        next_page_url: this.recipes.links.next,
        prev_page_url: this.recipes.links.prev
      };

      this.pagination = pagination;
    },
    selectCategory(id){
       this.category = id ;
       this.loadRecipes();
     },
    },
    created() {
            this.loadRecipes();
        }
    }
</script>

