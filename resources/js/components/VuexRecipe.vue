<template>
    <div class="container"> 
        <div v-if="recipes.data" class="row">
          <div class="col-3">
            <button  class="btn btn-primary mr-2" v-for="category in uniqCategory"
              @click="selectCategory(category.category.id)">{{category.category.name}}</button>        
            </div>
            <div class="col-6">
              <button class="btn btn-primary mr-2"  @click="sort('time')">Time</button>
              <button class="btn btn-primary mr-2" @click="sort('dificulty')">Dificulty</button>
              <button class="btn btn-primary mr-2" @click="sort('score')">Score</button>
              <button class="btn btn-primary mr-2" @click="sort('likes')">Likes</button>
            </div>
            <div class="col-3">
              <button class="btn btn-primary mr-2" @click="upDown('asc')"><i class="fas fa-arrow-up"></i></button>
              <button class="btn btn-primary mr-2" @click="upDown('desc')""><i class="fas fa-arrow-down"></i></button>
              
            </div>
        </div>

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
                     <h4 class="primary-color d-flex justify-content-center"><i class="far fa-clock"></i>{{recipe.time}} min</h4>
                      </div>
                      <div class="col-lg-6  d-flex justify-content-center ">
                          <h2 class="prosek "><i class="fas fa-utensils"></i>{{recipe.avg |  numberFormat}}</h2>
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
        
        <pagination :data="recipes"  @pagination-change-page="getResult"></pagination>
      </nav>
    </div>
</template>

<script>
  import { mapActions } from 'vuex'
    export default {
       data(){
        return {
          category: 0,
          order: '',
          recipe_id: '',
          pagination: {},
        }
       },
       methods: {         
        getResult(page = 1){
            this.$store.dispatch('getResults', page);
         },
        sort(sort){
        
          this.$store.dispatch('searchIt', {search: this.$store.state.search, category: this.$store.state.category, order: sort, direction: this.$store.state.direction});
        },
        selectCategory(id){
         this.$store.dispatch('searchIt', {search: this.$store.state.search, category: id, order: this.$store.state.order, direction: this.$store.state.direction });

         },
       upDown(direction){
         this.$store.dispatch('searchIt', {search: this.$store.state.search, category: this.$store.state.category, order: this.$store.state.order, direction: direction });
       },
     },
    created() {
            
        },
    computed: {
      ...mapActions([
         'getResults'
        ]),
      recipes(){
        return this.$store.state.recipes;
      },
      uniqCategory(){
          return  _.uniqBy(this.$store.state.recipes.data,'category.name');
        },
    
  
    },    
    filters: {
        numberFormat: function(value){
          
          if(value != null){
           value = (Math.round(value * 10) / 10).toFixed(1);

           return value;
         }else{
          return value;
         }
        }
    },    
    }
</script>


