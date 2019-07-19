<template>
        <div>
              <form @submit.prevent="rateRecipe" v-if="rate" >
                <div class="form-group"> 
                                  
                    <input 
                     v-model="score"  type="range" step="0.01" name ="score" min="1" max="10" value="5" class="form-control" id="score">
                   <span >{{score | round}}</span>
               </div>    
                 <div class="form-gropup mb-4">    
               <ckeditor :editor="editor" v-model="comment" :config="editorConfig"></ckeditor>
               </div>
  
                                            
                 <button class="btn btn-success" >Rate</button>
            
              </form>
        
             <div class="col-12 comment "  v-for="(comment,index) in comments" :key="comment.id"  v-if="!comment.comment_parent">
                  <div class="avatar">
                    <img src="/img/XS/300px-No_image_available.svg.png" alt="">
                  </div>
                  <div class="comment-content">
                    <div class="comment-name">
                      <p>{{comment.user.name}}</p>
                    </div>
                    <div class="comment-score">
                      <p v-html="starRating(comment.score)"></p>
                    </div>
                  </div>
                  <div class="comment-text" v-html="comment.comment">
                  </div>

                   <!-----------Reply------------->
                    <div class="col-12 comment ml-4"  v-for="(reply,index) in comment.replies" :key="reply.id" >
                        <div class="avatar">
                          <img src="/img/XS/300px-No_image_available.svg.png" alt="">
                        </div>
                        <div class="comment-content">
                          <div class="comment-name">
                            <p>{{reply.user.name}}</p>
                          </div>
                          <div class="comment-score">
                            <p v-html="starRating(reply.score)"></p>
                          </div>
                        </div>
                        <div class="comment-text" v-html="reply.comment">
                        </div>                       
                    </div>



                    <!-----------Reply------------->
                     <form @submit.prevent="replyCreate(comment.id)" v-if="showReply == comment.id" >
                                                  <div class="form-gropup mb-4">    
                       <ckeditor :editor="editor" v-model="reply" :config="editorConfig"></ckeditor>
                       </div> 
                       <button  class="btn btn-success">Reply</button>           
                 </form>
                   <button @click="showReply = comment.id" v-if="showReply != comment.id" class="btn btn-success">Reply</button>
                   
              </div>
             
     </div>        
</template>

<script>
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {

        props: ['recipe_id', 'user_id'],
        data(){
            return {
              editor: ClassicEditor,                
                editorConfig: {
                    toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],

                },
                 avg: '',
                 score: '5',
                 comment: '',
                 reply: '',
                 comments: {},
                 rate: '',
                 showReply: 'no'  

                }
               
            },
        methods:{    
            rateRecipe(){
                let vm = this;

                axios.post('/rating',{ 
                recipe_id: this.recipe_id,
                user_id: this.user_id,
                score: this.score,
                comment: this.comment}
                )
                .then(({data}) => {
                    vm.loadScores();
                    vm.loadComments();         
                   
            })

          },
          replyCreate(id){
              let vm = this;

                axios.post('/raply',{ 
                recipe_id: this.recipe_id,
                user_id: this.user_id,
                perent_comment_id: id,                
                comment: this.reply}
                )
                .then(({data}) => {
                    
                    vm.loadComments();         
                   
            })
          },
          loadComments(){
             axios.get(`/api/comments/${this.recipe_id}`)
                  .then(({data}) =>{
                    this.comments = data.data
                  })
          },
          loadScores(){
              axios.get(`/api/rating/${this.recipe_id}/${this.user_id}`)
                   .then(({data}) =>{

                        this.avg = data[1];
                        this.rate = data[0];
                      })
                      .catch(error => {
                        console.log(error);
                      })
          },
          starRating(avg){
               let star = "";
            for (let i = 1; i <= 10; i+=2){
                    if(avg > 1){
                      star += '<i class="fas fa-star"></i>';
                     avg = avg - 2;
                    }else if(avg > 0.5){  
                      star += '<i class="fas fa-star-half-alt"></i>';
                     avg = avg - 2;
                  }else { 
                    star += '<i class="far fa-star"></i>';
                  }
                }

                return star;
             }
          
        },
        filters: {
         round: function(value){
           return Math.round(value);
         }
        },
        created(){
            this.loadScores();
            this.loadComments();
            console.log(this.starRating(8));
        }
        
    }
</script>
