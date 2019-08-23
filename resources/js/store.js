import Vue from 'vue';
import Vuex from 'vuex';
import {Form , HasError, AlertError} from 'vform';

Vue.use(Vuex);

export const store = new Vuex.Store({

  state:{
     overlay: '',
     category: '',
  	 search: '',
  	 recipes: {},
     usersRecipes: {},
     userSort: 'created_at',
     userDirection: 'DESC',
     userSearch: 0,
     order: '',
     direction: '',   
     notifications: {},
     comments: {}
  },
  getters: {
    
  },

  mutations:{
     toggleOverlay: (state, payload)=>{
         state.overlay = payload;
     },
     searchIt: (state, data)=>{
       	state.recipes = data.data;
        state.search = data.payLoad.search;
        state.category = data.payLoad.category;
        state.order = data.payLoad.order;
        state.direction = data.payLoad.direction;
     },
     loadNotifications: (state, data)=>{
      
        state.notifications = data.data;  
     },
     loadComments: (state, data)=>{
        state.comments = data.data;
     },
     searchInput: (state)=>{
        state.recipes = {};
     },
       
     loadUsersRecipes: (state, data)=>{
        state.usersRecipes = data.data;
     },
     usersRecipesSort: (state, data)=>{

        state.userSort = data.userSort;
        state.userDirection = data.userDirection;
        if(data.userSearch){
          state.userSearch = data.userSearch;
        }else{
          state.userSearch = 0;
        }
       
     }
    
  },
  actions: {

  	searchIt: ({commit, state}, payLoad) =>{     
       
         axios.get(`/api/search/${payLoad.search}/${payLoad.category}/${payLoad.order}/${payLoad.direction}`)
                   .then(({data})=>{
                       commit('searchIt', {data: data, payLoad: payLoad});
                       
                    })  
            },
     getResults:({commit, state}, payLoad)=>{
     	   axios.get(`/api/search/${state.search}/${state.category}/${state.order}/${state.direction}?page=${payLoad}`)
                   .then(({data})=>{
                       commit('searchIt', {data: data});
                    })  
            },
     loadNotifications: ({commit})=>{
          
           axios.get('/notifications')
                .then(({data})=>{
                   commit('loadNotifications', {data: data.data});
                })

        },
      loadComments: ({commit})=>{
          axios.get('/comments')
                  .then(({data})=>{
                    commit('loadComments', {data: data});
                  })
      },
      paginateComments: ({commit}, payLoad)=>{
           axios.get(`/comments?page=${payLoad}`)
                  .then(({data})=>{
                    commit('loadComments', {data: data});
                  })
      },
      approved: ({commit, dispatch }, payLoad)=>{
                
                axios.post('/approved',{id: payLoad})
                    .then(()=>{
                       toast.fire({
                            type: 'success',
                            title: 'Comment readed successfully'
                           })
                     dispatch('loadNotifications');
                     dispatch('loadComments');  
                    })
            },
      commentDelete: ({commit, dispatch}, payLoad)=>{
              swal.fire({
                      title: 'Are you sure?',
                      text: "Comment will be deleted",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                     if (result.value) {

                     axios.delete(`/api/comment/${payLoad}`)
                       .then(()=>{
                         toast.fire(
                              'Deleted!',
                              'Comment has been deleted.',
                              'success'
                              );
                         dispatch('loadNotifications');
                         dispatch('loadComments');                                
                       }) 
                          
                    }
                 })        
            

           },
      reply: ({commit, dispatch}, payLoad)=>{
            axios.post('/raply',{ 
                recipe_id: payLoad.recipeId,
                
                comment: payLoad.comment,                
                perent_comment_id: payLoad.id}
                )
                .then(({data}) => {
                  toast.fire({
                            type: 'success',
                            title: 'Replyed successfully'
                           })
                    dispatch('loadNotifications');
                    dispatch('loadComments');         
                   
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
       loadUsersRecipes: ({commit, state})=>{

               axios.get(`/users_recipe/${state.userSort}/${state.userDirection}/${state.userSearch}`)
                      .then(({data}) =>{
                        commit('loadUsersRecipes', {data:data})
                      })
              
            },

       usersRecipesSort: ({commit, dispatch}, payLoad)=>{
                commit('usersRecipesSort',  payLoad );
                dispatch('loadUsersRecipes');
       },      
       paginateRecipes: ({commit, state}, payLoad)=>{
              axios.get(`/users_recipe/${state.userSort}/${state.userDirection}/${state.userSearch}?page=${payLoad}`)
                    .then(({data}) => {
                        commit('loadUsersRecipes', {data:data})
                      });
             
            },                          
     }             
  	
  
});