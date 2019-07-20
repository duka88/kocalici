<template>
    <div class="container"> 
        <div v-if="recipes.data" class="row">
          <div class="col-3 d-flex flex-row">
            <p  class="filter_search" v-for="category in uniqCategory"
              @click="selectCategory(category.category.id)">{{category.category.name}}</p>        
            </div>
            <div class="col-6 d-flex flex-row">
              <p class="filter_search"  @click="sort('time')">Time</p>
              <p class="filter_search" @click="sort('dificulty')">Dificulty</p>
              <p class="filter_search" @click="sort('score')">Score</p>
              <p class="filter_search" @click="sort('likes')">Likes</p>
            </div>
            <div class="col-3 d-flex flex-row">
              <p class="filter_search" @click="upDown('asc')"><i class="fas fa-arrow-up"></i></p>
              <p class="filter_search" @click="upDown('desc')"><i class="fas fa-arrow-down"></i></p>
              
            </div>
        </div>

        <div class="row justify-content-center">
            <div v-for="recipe in recipes.data" :key="recipe.id" class="col-md-4" >             
                    <div class="card my-card">
                       <div class="image">
                          <a :href="`/recipes/${recipe.slug}`">
                           <img :src="`/img/MD/${recipe.image}`" width="100%" height="300">
                           </a>
                          </div> 
                        <div class="card-body archive align-items-center">
                          <div class="card-title  d-flex justify-content-center">
                            <a :href="`/recipes/${recipe.slug}`"><h2>{{recipe.title}} </h2></a>
                          </div>
                      
                         

                         
                        </div>
                        <div class="card-footer  team-icons d-flex  justify-content-around">

                          <span><i class="fas fa-utensils mr-2"></i>{{recipe.servings}}</span>
                          <span><i class="far fa-clock mr-2"></i>{{recipe.time}}</span>
                          <span><i class="far fa-chart-bar mr-2"></i></i>{{recipe.dificulty}}</span>
                          <span><i class="fas fa-star mr-2"></i></i>{{recipe.avg | numberFormat}}</span>

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


