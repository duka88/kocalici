<template>
        <div class="rate-recipe">
              <form @submit.prevent="rateRecipe" v-if="rate" >
                <div class="form-group d-flex align-items-center"> 
                                  
                    <input 
                     v-model="score"  type="range" step="0.01" name ="score" min="1" max="10" value="5" class="form-control" id="score">
                   <span class="counter">{{score | round}}</span>
               </div>    
                 <div class="form-gropup mb-4">    
              
                  <textarea v-model="comment" class="form-control" id="exampleFormControlTextarea1" rows="10" cols="30"></textarea> 
                  </div>                          
                 <a @click="rateRecipe" class="filter_search" >ADD COMMENT</a>
            
              </form>
         <transition-group name="list" tag="div" mode="out-in" > 
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
                       <a @click="showReply = comment.id" v-if="showReply != comment.id" class="reply ml-3"><i class="fas  fa-reply mr-2"></i>Reply</a>
                   
                   <!-----------Reply------------->

                  <transition-group name="list" tag="div" mode="out-in" >  
                    <div class="col-12 comment ml-4" 
                         v-for="(reply,index) in comment.replies"
                         v-if=" index < show(comment.id)"
                          :key="reply" >
                        <div class="avatar">
                          <img src="/img/XS/300px-No_image_available.svg.png" alt="">
                       
                        </div>
                        <div class="comment-content"> 
                          <div class="comment-name">
                            <p>{{reply.user.name}}</p>
                          </div>
                           
                        </div>
                        <div class="comment-text" v-html="reply.comment">
                        </div>                       
                    </div>
                   
                  </transition-group>
                   <button v-if="comment.replies.length > show(comment.id)" 
                    @click="loadMoreReples(comment.id)" > Load More Repy</button> 
                     
                 
                    <!-----------Reply------------->
                     <form @submit.prevent="replyCreate(comment.id)" v-if="showReply == comment.id" >
                     <div class="form-gropup mb-4">    
                       <textarea v-model="reply" class="form-control" id="exampleFormControlTextarea1" rows="10" cols="30"></textarea>
                       </div> 
                      <a @click="replyCreate(comment.id, index)" class="mr-3 reply" ><i class="fas  fa-reply mr-2"></i>Reply</a> <a @click="cancel" class="cancel">Cancel</a>          
                 </form>
                 
                   
              </div>
       </transition-group>    
       <button @click="loadMoreComments(pagination.next_page_url)" v-if="pagination.next_page_url"> Load More</button>
     </div>        
</template>
  
<script>


    export default {

        props: ['recipe_id'],
        data(){
            return {
                 replyCount: 1,
                 commentId: '',
                 avg: '',
                 score: '5',
                 comment: '',
                 reply: '',
                 comments: {},
                 rate: '',
                 showReply: 'no',
                 pagination: {}

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
                  toast.fire(
                        'success',
                        'Comentet is successful',
                        'success'
                              );
                    vm.loadScores();
                    this.comments.unshift(data.data);       
                   
                })
                .catch((error) => {
                       if (error.response) {
                              toast.fire({
                              type: 'error',
                              title: error.response.data.message
                            })               
                           } 
                        } );

          },
          loadMoreReples(id){
            this.replyCount += 2;
            this.commentId = id; 
          },
          show(id){
             if(id == this.commentId){
              return this.replyCount;
             }else{
              return 1;
             }

          },
           loadComments(){
            let vm = this;
             axios.get(`/comments/${this.recipe_id}`)
                  .then(({data}) =>{
                    
                      this.comments = data.data;
                   
                    vm.loadMore(data.meta, data.links);
                 
                  })
          },
          loadMoreComments(page_url){
             let vm = this;
             
              axios.get(page_url)
                  .then(({data}) =>{
                    data.data.forEach((item)=>{
                        console.log(item)
                         this.comments.push(item); 
                    })                    
                   
                    vm.loadMore(data.meta, data.links);
                 
                  })

          },
          loadMore(meta, links){
             let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
              };

            this.pagination = pagination;
          },
          replyCreate(id, index){
              let vm = this;

                axios.post('/raply',{ 
                recipe_id: this.recipe_id,
                user_id: this.user_id,
                perent_comment_id: id,                
                comment: this.reply}
                )
                .then(({data}) => {
                     toast.fire(
                        'success',
                        'Raply is successful',
                        'success'
                              )
                    this.comments[index].replies.push({
                        comment: this.reply,
                        user:{
                          name: this.$gate.getName()
                        }
                      }); 
                    this.showReply = false; 
                    this.reply = "";       
                   
              })
              .catch((error) => {
                       if (error.response) {
                              toast.fire({
                              type: 'error',
                              title: error.response.data.message
                            })               
                           } 
                        } );  
          },
          cancel(){
             this.showReply = false; 
            this.reply = "";  
          },
         
          loadScores(){
              axios.get(`/rating/${this.recipe_id}/`)
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
