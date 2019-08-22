<template>

    <div class="col-12 my-5 col-">
     <div class="row">
      <div class="col-12 my-5">
        <div class="row d-flex justify-content-center">
          <div   :class="{'active-border-top' : active == 0}" 
            class="filter_category "  @click="selectCategory(0)">
             
             
               <img :src="`/img/S/cake3.jpg`" class="mt-3 img-responsive img-circle"  alt="">
               <p class="text-center">All</p>
             
           </div>
          <div  v-for="(category, index) in categories" :class="{'active-border-top' : active == category.id}" :key="category.id"
            class="filter_category "  @click="selectCategory(category.id)">
             <div @click="selectCategory(category.id)">
             
               <img :src="`/img/S/${category.image}`" class="mt-3 img-responsive img-circle"  alt="">
               <p class="text-center">{{category.name}}</p>
             </div>
           </div>
          </div>
       </div>
       <div class="col-10 offset-1">
            <div class="row justify-content-between">
             
                <div class="col-9  d-flex flex-row">
                  <p class="filter_search"  @click="sort('time')">Time</p>
                  <p class="filter_search" @click="sort('dificulty')">Dificulty</p>
                  <p class="filter_search" @click="sort('score')">Score</p>
                  <p class="filter_search" @click="sort('likes')">Likes</p>
                </div>
                <div class="col-3  d-flex flex-row justify-content-end">
                  <p class="filter_search" @click="upDown('asc')"><i class="fas fa-arrow-up"></i></p>
                  <p class="filter_search" @click="upDown('desc')"><i class="fas fa-arrow-down"></i></p>
                  
                </div>
            </div>
         
            <div class="row justify-content-center">
             <transition-group name="fade" tag="div" class="row justify-content-center" mode="out-in">
                <div  v-for="recipe in recipes.data" :key="recipe.id" class="col-4" >   
                          
                        <div class="card my-card">
                           <div class="image">
                              <a :href="`/recipes/${recipe.slug}`">
                               <img :src="`/img/MD/${recipe.image}`" width="100%" height="300">
       `                        </a>
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
             
              </transition-group>
            </div>
          
             <nav aria-label="Page navigation example">
            
            <pagination :data="recipes"  @pagination-change-page="getResult"></pagination>
          </nav>
       </div>
     </div>    
    </div>
</template>

<script>
    export default {
       data(){
        return {
          active: 0,
          category: 0,
          categories: {},
          recipes: {},
          recipe_id: '',
          pagination: {},
          order: 'created_at',
          direction: 'desc'
        }
       },
       methods: {
         loadRecipes(){
            axios.get( `api/recipes/${this.category}/${this.order}/${this.direction}`)
                 .then(({data}) => {
                    this.recipes = data;           
                               
                 })
               .catch(error => {
              console.log(error)
            });
         },
        
       getResult(page = 1) {
          axios.get( `api/recipes/${this.category}/${this.order}/${this.direction}?page=${page}`)
                 .then(({data}) => {
                    this.recipes = data;           
                               
                 })
               .catch(error => {
              console.log(error)
            });
    },
    loadCategory(){
      axios.get('/api/category')
           .then(({data})=>{
              this.categories = data.data;
           })
    },
    selectCategory(id){

       this.category = this.active  = id ;
       this.loadRecipes();

     },
     sort(sort){        
         this.order = sort;
         this.loadRecipes();
        },
    upDown(sort){
       this.direction = sort;
       this.loadRecipes();
      },   
    },

    created() {
            this.loadRecipes();
            this.loadCategory();
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

