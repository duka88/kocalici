import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
  state:{
     category: '',
  	 search: '',
  	 recipes: {},
     order: '',
     direction: ''
  },
  mutations:{
     searchIt: (state, data)=>{
     	state.recipes = data.data;
      state.search = data.payLoad.search;
      state.category = data.payLoad.category;
      state.order = data.payLoad.order;
      state.direction = data.payLoad.direction;
     },
    
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
                       commit('searchIt', {data: data})
                    })  
            },
     }       
  	
   

});