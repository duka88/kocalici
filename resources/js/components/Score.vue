<template>
    
              <form @submit.prevent="rateRecipe" >
                <div class="form-group">                   
                    <input 
                     v-model="score" type="range" step="0.01" name ="score" min="1" max="10" value="5" class="form-control" id="score">
                   <span >{{score}}</span>
               </div>    
                 <div class="form-gropup mb-4">    
               <ckeditor :editor="editor" v-model="comment" :config="editorConfig"></ckeditor>
               </div>
  
                                            
                 <button class="btn btn-success" >Rate</button>
            
              </form>
        
   
</template>

<script>
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {

        props: ['recipe_id', 'user_id'],
        data(){
            return {
              editor: ClassicEditor,                
                editorConfig: {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],

                },
                 avg: '',
                 score: '5',
                 comment: ''
                }
               
            },
        methods:{    
            rateRecipe(){
                let vm = this;

                axios.post('/api/rating',{ 
                recipe_id: this.recipe_id,
                user_id: this.user_id,
                score: this.score,
                comment: this.comment}
                )
                .then(({data}) => {
                    vm.loadScores();
                   
            })

          },
          loadScores(){
              axios.get(`/api/rating/${this.recipe_id}`)
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
