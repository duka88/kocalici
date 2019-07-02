<template>
      <div class="col-6">
        <h2 class="mb-4">Ingredients</h2>
        <ul v-for="ingridient in ingridients" class="ingredients_list">
          <li >{{ingridient.pivot}} <span class="list_bold">{{ingridient.name}}</span></li>
        
          
        </ul>
      </div>
</template>

<script>
    export default {
       props:['recipe_id'],

       data(){
          return {
            ingridients: {}

          }
       },

       methods:{
         loadIngridients(){
            axios.get(`/api/ingredients/${this.recipe_id}`)
                .then(({data}) => {

                   this.ingridients = data
                })
         }
       },
       created(){
        this.loadIngridients();
       }
    }
</script>
