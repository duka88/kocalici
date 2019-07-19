<template>
    <div class="container">
          <div class="tab-pane active" id="timeline">
                <!-- The timeline -->
             <ul v-for="(comment, index) in comments.data"
                 v-if="!comment.perent_comment_id" class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red">
                          {{comment.time}}
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-comments bg-yellow"></i>

                    <div class="timeline-item">
                     
                      <h3 class="timeline-header d-flex justify-content-between align-middle"><a class="text-dark" href="#">{{comment.recipe.title}}
                        </a><p >
                           
                            <span class="font-weight-bold ml-5">score</span><i class="fas fa-star"></i> {{comment.score }}</p>                   
                      </h3>
                      <div   class="timeline-body" v-html="comment.comment"></div>
    
                  
                      
                      <div class="timeline-footer">
                        <div v-if="commentReply == comment.id" class="form-gropup mb-4">    
                            <ckeditor   :editor="editor" v-model="replyComment" :config="editorConfig"></ckeditor>
                        </div>
                         <div class="d-flex justify-content-between">
                          <div>
                             <a v-if="commentReply == comment.id" @click="updateComments(comment)" class="mr-3 reply"><i class="fas  fa-reply"></i> Reply</a>
                              <a v-else @click="replyComments(comment.id)" class="mr-3 reply" ><i class="fas  fa-reply"></i> Reply</a>
                           
                             <a v-if="commentReply == comment.id" @click="commentReply = false"  class="mr-3 cancel ">Cancel</a>
                              <a v-else class="delete" @click="deleteComment(comment.id)"><i class="fas fa-trash-alt"></i> Delete</a>
                           </div>    
                           <div>
                              <span v-if="comment.admin_notification == 0"
                                class="notification" 
                                @click="checked(comment.id)">remove notification</span>
                                
                           </div>
                         </div>  
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item --> 
                      <ul v-for="comment in comment.replies" class="timeline timeline-inverse ml-5">
                  <!-- timeline time label -->
                          <li class="time-label">
                                <span class="bg-red">
                                  {{comment.time}}
                                </span>
                          </li>
                          <!-- /.timeline-label -->
                          <!-- timeline item -->
                          <li>
                            <i class="fa fa-comments bg-yellow"></i>

                            
                             <div class="timeline-item">
                              <h3 class="timeline-header d-flex justify-content-between align-middle"><a href="#" class="text-dark">{{comment.recipe.title}}
                                </a><p v-if="!commentReply">
                                    
                                   
                                    <span class="font-weight-bold">score</span><i class="fas fa-star"></i> {{comment.score}}</p>
                                     
                                 
                                                         
                              </h3>  
                              <div  v-if="!commentReply" class="timeline-body" v-html="comment.comment"></div>
                                 <div class="timeline-footer">
                                  <div class="d-flex justify-content-between"> 
                                   <div>
                                    <a v-if="!commentReply" class="delete" @click="deleteComment(comment.id)" ><i class="fas fa-trash-alt"></i> Delete</a> 
                                   </div> 
                                   <div>
                                      <span v-if="comment.admin_notification == 0"
                                        class="notification"
                                        @click="checked(comment.id)">remove notification</span>
                                        
                                   </div>
                                </div>
                             </div>
                            </div>  
                          </li>
                          <!-- END timeline item -->
                          <!-- timeline item --> 

                           
                        </ul>

                </ul>

          <pagination :data="comments"  @pagination-change-page="paginateComment"></pagination>
              </div>
       </div> 
   </template>

<script>
import { mapActions } from 'vuex';
 import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        data() {
            return { 
              editor: ClassicEditor,                
                editorConfig: {
                    toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],

                },             
                commentReply: false,
                replyComment:'' 
                
            }
        },

        methods: {
         paginateComment(page = 1){
            this.$store.dispatch('paginateComments', page);
          },
          checked(id){
             this.$store.dispatch('approved', id );

          },
          updateComments(comment){

            this.commentReply = false;

            this.$store.dispatch('reply',
                { id: comment.id, comment: this.replyComment, recipeId: comment.recipe.id  } );
          },
          replyComments(id){
              this.commentReply = id;
          }, 
          deleteComment(id){
             this.$store.dispatch('commentDelete', id);
          },
          ...mapActions([                  
                'loadComments',
                'paginateComments',
                'approved',
                'commentDelete',
                'reply'
              ]),
        },
        computed: {
          
           comments(){
              return this.$store.state.comments;
           }
        },
         created(){            
            this.$store.dispatch('loadComments'); 
        },
        filters: {
         round: function(value){
           return Math.round(value);
         }
      },
        
    }
</script>
