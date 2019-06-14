<template>
        <div class="row">
               <div class="col-12 mb-3 single_recipe_info_text image">
                    <p class="heart"><i class="fas fa-heart ml-5"></i><span class="text-dark">(5)</span></p>
                    <img class="single_recipe_img w-100" :src="`/img/MD/${photos[show].image}`" width="480px" height="480px">
                  </div>             
              <div v-for="(photo, index) in photos" :key="photo.id" class="col-3">               
                <img v-if="index < 4" class="single_recipe_img  w-100" :src="`/img/MD/${photo.image}`" width="100px" height="100px" @click="show = index">
              </div>
          

         </div> 
</template>

<script>
    export default {
        data(){
           return{
             photos: {},
             show: 0,

           }     
        },
        props:['recipe_id'],
        methods: {
              loadGallery(){
                axios.get(`/api/gallery/${this.recipe_id}`)
                     .then(({data}) => {
                        this.photos = data.data;  
                       this.photos.unshift(data.data[0].recipe);
                                        
                     }) 
                }
                
        },
        created(){
            this.loadGallery();
        }
    }
</script>
