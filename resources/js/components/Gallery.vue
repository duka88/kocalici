<template>
        <div class="row">
           
               <div class="col-12 mb-3 single_recipe_info_text image">
                    <p @click="togleLike" class="heart py-2"><i 
                    :class="{'fas':like, 'far':!like }"
                     class="fa-heart"></i><span class="text-dark">({{count}})</span></p>
                    <img class="single_recipe_img w-100" :src="`/img/MD/${photos[show]}`" width="480px" height="480px">
                  </div>             
              <div v-for="(photo, index) in photos" :key="photo.id" class="col-3">               
                <img v-if="index < 4" class="single_recipe_img  w-100" :src="`/img/MD/${photo}`" width="100px" height="100px" @click="show = index">
              </div>
        

         </div> 
</template>

<script>
    export default {
        data(){
           return{
             count: '' ,
             like: '',
             photos: {},
             show: 0,

           }     
        },
        props:['recipe_id'],
        methods: {
              loadGallery(){
                axios.get(`/api/gallery/${this.recipe_id}`)
                     .then(({data}) => {
                        this.photos = data.data.gallery;  
                       this.photos.unshift(data.data.image);
                                        
                     }) 
                },
                togleLike(){
                  let vm = this;
                  axios.post('/like',{
                    recipe_id: this.recipe_id,                    
                    value: 1,
                    like: this.like,   
                  })
                     .then(({data}) => {
                        vm.loadlikes();
                        vm.myLike();
                                        
                     })
                      .catch((error) => {
                          if (error.response) {
                             if(error.response.data.message == "Unauthenticated." ){

                                var massage = 'Must be log-in to like';
                             }else{
                                var massage = error.response.data.message;
                             }
                         

                              toast.fire({
                              type: 'error',
                              title: massage
                            })               
                           } 
                        } ); 
                },
                loadlikes(){
                  axios.get(`/api/like/${this.recipe_id}`)
                       .then(({data}) =>{
                       
                         this.count = data;
                        
                       })
                },
              myLike(){
                  axios.get(`/api/myLike/${this.recipe_id}/${this.user_id}`)
                       .then(({data}) =>{
                       
                         this.like = data[0];
                        
                       })
                }
             
              

                
        },

        created(){
            this.loadGallery();
            this.loadlikes();
            this.myLike();
        }
    }
</script>
