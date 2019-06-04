<template>
    <div class="container">
        <div class="container mb-5">
              <div class="row justify-content-center">
              <form @submit.prevent="rateRecipe" class="form-control">
             
                       
                  <input v-model="score" type="range" name ="score" min="1" max="10" value="5" class="form-control" id="score">
                 <span >{{score}}{{avg}}</span>
  
                                            
                 <button class="btn btn-success" type="submit" name="submit" value="submit" />Rate </button>
            
              </form>
            </div>
          </div>
    </div>
</template>

<script>
    export default {
        props: ['post_id', 'user_id'],
        data(){
            return {
                 avg: '',
                 score: '5',
                
                }
               
            },
        methods:{    
            rateRecipe(){
                let vm = this;

                axios.post('/api/rating',{ 
                recipe_id: this.post_id,
                user_id: this.user_id,
                score: this.score}
                )
                .then(({data}) => {
                    vm.loadScores();
                   
            })

          },
          loadScores(){
              axios.get(`/api/rating/${this.user_id}/${this.post_id}`)
                   .then(({data}) =>{

                        this.avg = data
                      })
                      .catch(error => {
                        console.log(error);
                      })
          }
        },
        created(){
            this.loadScores();
        }
        
    }
</script>
