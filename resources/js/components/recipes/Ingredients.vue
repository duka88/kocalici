<template>
      <div class="col-6">
        <h2 class="mb-4">Ingredients</h2>
        <button @click="decrement" class="btn-sm btn-primary">-</button><span>{{ingredients.servings}}</span><button @click="increment" class="btn-sm btn-primary">+</button>
        <ul v-for="ingridient in ingredients.ingredients" :key="ingridient.id" class="ingredients_list">
          <li >{{calculate(ingridient.pivot.amount)}} <span class="list_bold">{{ingridient.name}}</span></li>
        
         
        </ul>
      </div>
</template>

<script>
    export default {
       props:['recipe_id'],

       data(){
          return {
            ingredients: {}

          }
       },

       methods:{
         loadIngridients(){
            axios.get(`/api/ingredients/${this.recipe_id}`)
                .then(({data}) => {

                   this.ingredients = data.data
                })
         },
         decrement(){
          if(this.ingredients.servings > 0){
            this.ingredients.servings--;
          }
         },
         increment(){
          this.ingredients.servings++;
         },
         calculate(value){
             return `${parseInt(value)*this.ingredients.servings}${value.replace(/[0-9]/g, '')}`  
         }
       },       
       
       created(){
        this.loadIngridients();
       }
    }
</script>
