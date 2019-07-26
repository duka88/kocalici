import Vue from 'vue';
import Vuex from 'vuex';
import {Form , HasError, AlertError} from 'vform';

Vue.use(Vuex);

export const store = new Vuex.Store({

  state:{
     category: '',
  	 search: '',
  	 recipes: {},
     usersRecipes: {},
     userSort: 'created_at',
     userDirection: 'DESC',
     order: '',
     direction: '',   
     notifications: {},
     comments: {}
  },
  getters: {
    
  },

  mutations:{
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
                     dispatch('loadNotifications');
                     dispatch('loadComments');  
                    })
            },
      commentDelete: ({commit, dispatch}, payLoad)=>{
             axios.delete(`/api/comment/${payLoad}`)
                  .then(()=>{
                         dispatch('loadNotifications');
                         dispatch('loadComments');                                
                       }) 

           },
      reply: ({commit, dispatch}, payLoad)=>{
            axios.post('/raply',{ 
                recipe_id: payLoad.recipeId,
                
                comment: payLoad.comment,                
                perent_comment_id: payLoad.id}
                )
                .then(({data}) => {
                    
                    dispatch('loadNotifications');
                    dispatch('loadComments');         
                   
            })
          },
        loadRecipe: ({commit}, payLoad)=>{
              axios.get(`/api/recipe/${payLoad}`)
                  .then(({data})=>{
                     commit('loadRecipe', {data:data})
                  })
        },
       loadUsersRecipes: ({commit, state})=>{

               axios.get(`/users_recipe/${state.userSort}/${state.userDirection}`)
                      .then(({data}) =>{
                        commit('loadUsersRecipes', {data:data})
                      })
              
            },

       usersRecipesSort: ({commit, dispatch}, payLoad)=>{
                commit('usersRecipesSort',  payLoad );
                dispatch('loadUsersRecipes');
       },      
       paginateRecipes: ({commit, state}, payLoad)=>{
              axios.get(`/users_recipe/${state.userSort}/${state.userDirection}?page=${payLoad}`)
                    .then(({data}) => {
                        commit('loadUsersRecipes', {data:data})
                      });
             
            },                          
     }             
  	
  
});