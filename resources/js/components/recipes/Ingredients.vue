<template>
      <div class="col-6">
        <h2 class="mb-4">Ingredients</h2>
        <div class="row align-items-center">
          <p @click="decrement" class="servings m-0" :class="{'servings-click' : togleDec}"><i class="fas fa-minus "></i></p><span class="mx-3 counter">{{ingredients.servings}}</span>
          <p @click="increment" class="servings m-0" :class="{'servings-click' : togleInc}"><i class="fas fa-plus"></i></p>
          </div>
        <ul  class="ingredients_list mt-4">
       
          <li v-for="ingridient in ingredients.ingredients" :key="ingridient.id">
             
               <span >{{calculate(ingridient.pivot.amount)}}</span> 
               
               <span class="list_bold">{{ingridient.name}}</span></li>
          
         
        </ul>
      </div>
</template>

<script>
    export default {
       props:['recipe_id'],

       data(){
          return {
            togleDec: false,
            togleInc: false,
            ingredients: {},
            servings: '',
          }
       },

       methods:{
         loadIngridients(){
            axios.get(`/api/ingredients/${this.recipe_id}`)
                .then(({data}) => {

                   this.ingredients = data.data;
                   this.servings = data.data.servings;
                })
         },
         decrement(){
          if(this.ingredients.servings > 0){
            this.ingredients.servings--;
            this.togleDec = true;

            setTimeout(function(){ this.togleDec = false }.bind(this), 100)
          }
         },
         increment(){
          
          this.ingredients.servings++;
          this.togleInc = true;
           setTimeout(function(){  this.togleInc = false }.bind(this), 100)
         },
         calculate(value){
             return `${Math.round((parseInt(value)/this.servings)*this.ingredients.servings)/10}${value.replace(/[0-9]/g, '')}`  
         }
       },       
       
       created(){
        this.loadIngridients();
       }
    }
</script>
