<template>
    <div class="container">
               <div class="card"  >
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>
                <form @submit.prevent="searchRecipe" class="form-inline ml-3">
                      <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar"  @keyup="searchRecipe"  v-model="search" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                          <button class="btn btn-navbar" >
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </form>
              <div class="card-tools">
                    <router-link to="/add-recipe" class="nav-link">                       
                        <p class="text-success">ADD RECIPE</p>
                      </router-link>
              </div>
             
              </div>     
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th @click="Sort('category_id')">Category <i class="fas "
                      :class="{'fa-chevron-down':recipeDirection == 'DESC' && recipeSort=='category_id', 'fa-chevron-up':recipeDirection == 'ASC'  && recipeSort=='category_id' }"></i></th>
                    <th @click="Sort('title')">Title <i class="fas" 
                      :class="{'fa-chevron-down':recipeDirection == 'DESC' && recipeSort=='title', 'fa-chevron-up':recipeDirection== 'ASC'  && recipeSort=='title' }"></i></th>
                    <th @click="Sort('score')">Avg <i class="fas"
                      :class="{'fa-chevron-down':recipeDirection == 'DESC' && recipeSort=='score', 'fa-chevron-up':recipeDirection== 'ASC'  && recipeSort=='score' }"></i></th>
                    <th @click="Sort('likes')">Likes <i class="fas"
                      :class="{'fa-chevron-down':recipeDirection == 'DESC' && recipeSort=='likes', 'fa-chevron-up':recipeDirection== 'ASC'  && recipeSort=='likes' }"></i></th>
                    <th @click="Sort('created_at')">Created_at <i class="fas" 
                      :class="{'fa-chevron-down':recipeDirection == 'DESC' && recipeSort=='created_at', 'fa-chevron-up':recipeDirection== 'ASC'  && recipeSort=='created_at' }"></i></th>
                    <th>Modify</th>
                  </tr>
                  <tr v-for="recipe in recipes.data" :key="recipe.id">
                    <td>{{recipe.id}}</td>
                    <td>{{recipe.category}}</td>
                    <td>{{recipe.title}}</td>
                    <td>{{recipe.score }}</td>
                    <td>{{recipe.likes || 0}}</td>
                    <td>{{recipe.created_at}}</td>
                    <td >
                        <a @click="newModal(recipe)">
                            <i class="fa fa-edit text-primary"></i>
                        </a>
                        /
                        <a @click="deleteRecipe(recipe.id)">
                            <i class="fa fa-trash text-danger"></i>
                        </a>
                       </td>
                  </tr>
                  
                </tbody></table>
              </div>       
                     


      <!-----------End Recipes------------>

           
        <div class="card-footer">          
          <pagination :data="recipes"  @pagination-change-page="paginate"></pagination>
        </div>
      </div>


   <!----------Edit------------>
       
       <div   class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog " role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5  class="modal-title" id="exampleModalLabel">Add New</h5>
                    <h5  class="modal-title" id="exampleModalLabel">Update</h5>
                    <button @click="closeModel"  type="button" class="close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
    <div class="container py-5" v-if="recipeForm">
       <div class="form-group"> 
             <label for="title">Title</label>
             <input name="title" id='title'  v-model="recipeForm.title" type="text" class="form-control" :class="{'is-invalid': recipeForm.errors.has('title')}">
               <has-error :form="recipeForm" field="title"></has-error>
        </div>     
        <div class="form-group">
            <label for="title">Description</label>
            <input name="description"  type="text" v-model="recipeForm.description" class="form-control"  :class="{'is-invalid': recipeForm.errors.has('description')}">
               <has-error :form="recipeForm" field="description"></has-error>
        </div>    
        <div class="form-group mb-4">
            <label for="title">Category</label>
            <select  v-model="recipeForm.category" class="form-control" name="category_id"
            :class="{'is-invalid': recipeForm.errors.has('category_id')}">
              
                <option v-for="category in recipeForm.categories" >{{category.name}}</option>
            </select>
            <has-error :form="recipeForm" field="category_id"></has-error>
        </div>

     <!-------------Image-------------->   

        
         <div class="row"> 
           <div class="col-12">
             <p class="w-100 mb-0 font-weight-bold">Main Image</p>
              <img v-if="items[0].image" :src="items[0].image" class="w-100">
               <img v-else :src="`/img/XS/${recipeForm.image}`" alt="">
                
                    <label class="custom-file-upload d-flex mt-2 mb-4"> 
                            <input  style="display: none" type="file" @change="onFileChange(items[0], 0, $event)">Change Image 
                         </label>
            </div> 
           
           <p class="w-100 mb-0 font-weight-bold">Gallery</p> 
           <div v-for="(item, index) in items" v-if="index !=0 "  class="col-4 ">
         
            <img v-if="item.name" :src="item.image" class="w-100">
              <img v-if="typeof recipeForm.gallery[index -1] == 'object'" :src="`/img/XS/${recipeForm.gallery[index -1].image}`" class="w-100">
             
              
             <label class="custom-file-upload d-flex mt-2 mb-4"> 
                            <input  style="display: none" type="file" @change="onFileChange(item, index, $event)">Change Image 
                         </label>
            
           </div>
        </div>
        </div> 
     <!-------------Image--------------> 


        <div class="range-wrap mb-4">
          <div class="form-group range-box d-flex flex-wrap align-items-center"> 
                      <label for="title" class="d-block w-100">Dificulty</label>              
                      <input 
                       v-model="recipeForm.dificulty" type="range" step="0.01" name ="dificulty" min="1" max="10"  id="dificulty">
                     <span class="score d-block">{{recipeForm.dificulty | round }}</span>
                 </div> 
          <div class="form-group range-box d-flex flex-wrap align-items-center"> 
                      <label for="title" class="d-block w-100">Servings</label>              
                      <input 
                       v-model="recipeForm.servings" type="range" step="0.01" name ="servings" min="1" max="100" id="servings">
                     <span class="score d-block">{{recipeForm.servings | round}}</span>
                 </div> 
          <div class="form-group range-box d-flex flex-wrap align-items-center">
                      <label for="title" class="d-block w-100">Time (m)</label>                                 
                      <input 
                       v-model="recipeForm.time" type="range" step="0.01" name ="time" min="1" max="240"  id="time">
                     <span class="score d-block">{{recipeForm.time | round}}</span>
                 </div> 
          </div>

<!----------tags------------>

         <div class="form-group mb-4">            
          <label>Ingredients</label>
          <div class="tags-input" >
            
            <p v-for="(tag, index) in recipeForm.tags" v-if="tag.name">

                <span >{{tag.name}}</span>         
                      
                <span v-if="tag.id != tagAmount" class="ml-3">{{tag.pivot.amount}}</span>
                  <input v-else v-model="currentAmount" type="text"> 
                  <i @click='editAmount(tag.id)'
                     v-if="tag.id != tagAmount" class="fa fa-edit text-primary"></i>

                        /                       
                 <i v-if="tag.id != tagAmount"  @click='deleteTag(index)' class="fa fa-trash text-danger"></i>
                 <span v-else>
                     <i  @click="doneEditTag(index)" class="fas fa-check"></i>
                     <span @click="cancelEditTag">Cancel</span>
                 </span>
                 
            </p>
            
  
            <div class="tags-wrap mb-3" v-if="tagsArray.tags.length > 0">
              <div class="selected-tag" v-for="(selectedTag, key) in tagsArray.tags">
                <span class="font-weight-bold">Ingredient: </span>{{ selectedTag }}
                 / <span class="font-weight-bold">Amount:</span> {{ tagsArray.amount[key] }} 
                 <span class="remove-tag" v-on:click="removeTag( key )">&times;</span>
              </div>
            </div>
              <div class="form-row">
                <div class="form-group col-md-6 mb-0 d-flex flex-wrap">
                  <input ref="tag" type="text"  class="new-tag-input form-control"
                   :class="{'is-invalid': recipeForm.errors.has('tag')}" name='tag'
                   v-model="currentTag" v-on:keyup="searchTags" v-on:keyup.enter="addNewTag" v-on:keydown.up="changeIndex( 'up' )" v-on:keydown.delete="handleDelete" v-on:keydown.down="changeIndex( 'down' )" v-bind:class="{ 'duplicate-warning' : duplicateFlag }" placeholder="Add ingredient">

                  <has-error :form="recipeForm" field="tag"></has-error>

                  <input v-model="currentAmount" type="text" v-on:keyup.enter="addAmount"  placeholder="Enter amount" class="form-control amount-input">

                  <div class="tag-autocomplete" v-show="showAutocomplete">
                    <div class="tag-search-result" v-for="(tag, key) in tagSearchResults" v-bind:class="{ 'selected-search-index' : searchSelectedIndex == key }" v-on:click="selectTag( tag.name )">{{ tag.name }}</div>
                  </div>
                </div>
              </div>
          </div>


 <!----------tags------------>
         

        </div>       
        <div class="form-gropup mb-4">    
            <ckeditor :editor="editor" v-model="recipeForm.content" :config="editorConfig" :class="{'is-invalid': recipeForm.errors.has('content')}"></ckeditor>
             <has-error :form="recipeForm" field="content"></has-error>
        </div>
        <button @click="updateRecipe" class="large_button mb-4" >Update Recipe</button>                
      </div>
                 
          </div>
          </div>
          </div>               
    </div>

    </div>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    export default {
      data(){
        return{        
           
            items: [
                   {
                     id: '',
                     image: false,
                     name: ''
                   },
                   { 
                     id: '',
                     image: false,
                     name: ''
                   },
                   { 
                     id: '',
                     image: false,
                     name: ''
                   },
                   {
                     id: '',
                     image: false,
                     name: ''
                   }
                 
                ],  
               tagSearchResults: [],
               duplicateFlag: false,
               searchSelectedIndex: -1,
               pauseSearch: false,
                recipeForm: new Form ({
                   content: '',
                   id:'',
                   title: '',                 
                   category: '',
                   description: '',
                   servings: 5,
                   description: '',
                   dificulty: 5,
                   time: 5,
                   image: '',
                   name: '', 
                   gallery: '', 
                   tags: '',
                   amount: '',
                   categories:''
                }),
                updateRecipeForm: new Form ({
                   content: '',
                   id:'',
                   title: '',                 
                   category: '',
                   description: '',
                   servings: 5,
                   description: '',
                   dificulty: 5,
                   time: 5,
                   image: '',
                   name: '', 
                   gallery: '', 
                   tags: '',
                   amount: '',
                   categories:''
                }),
                tagAmount: false,
                categories: {},
                
                editor: ClassicEditor,                
                editorConfig: {
                    // The configuration of the rich-text editor.
                }, 

            
               currentTag: '',
               currentAmount: '',
               tagsArray: {
                  tags:[],
                  amount:[]
                },
            search: '',
            recipeSort: 'created_at',
            recipeDirection: 'DESC',
            recipes: {}, 
              
        }
      },
      methods: {
        searchRecipe: _.debounce(function(){

             
              this.loadRecipes();
               }, 500),
       loadRecipes(){
           
            let search = 0;
            
            if(this.search){
                search = this.search;
            }

            axios.get(`/all-recipes/${this.recipeSort}/${this.recipeDirection}/${search}`)
                 .then(({data})=>{
                    this.recipes = data;
                 })
        },
        Sort(value){
          
           this.recipeSort = value;
              if(this.recipeDirection == 'DESC'){
                 this.recipeDirection = 'ASC';
                this.loadRecipes();                                
               }else{
                this.recipeDirection = 'DESC';
                 this.loadRecipes(); 
               }  

        },
        paginate(page = 1){
            let search = 0;
            
            if(this.search){
                search = this.search;
            }
            axios.get(`/all-recipes/${this.recipeSort}/${this.recipeDirection}/${search}?page=${page}`)
                 .then(({data})=>{
                    this.recipes = data;
                 })
        },
        updateRecipe(){
                let vm = this;

                for(let tag in this.recipeForm.tags){
                  if(this.recipeForm.tags[tag].name){ 
                   vm.tagsArray.tags.push(this.recipeForm.tags[tag].name);
                   vm.tagsArray.amount.push(this.recipeForm.tags[tag].pivot.amount);
                  }
                };
                this.updateRecipeForm.fill(this.recipeForm);
                this.updateRecipeForm.gallery = this.items;
                this.updateRecipeForm.image = this.items[0];
                this.updateRecipeForm.tags = this.tagsArray;
                this.updateRecipeForm.put('/edit-recipe')
                        .then(()=>{                          
                            toast.fire({
                            type: 'success',
                            title: 'Recipe updated successfully'
                          })
                           vm.loadRecipes();
                           $('#addNew').modal('hide');  

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
            onFileChange(item, index, e) {
               
              let files = e.target.files || e.dataTransfer.files;
              let name = e.target.files[0].name;
              let vm = this;
              if (!files.length)
                return;           
            if(index != 0 &&  vm.recipeForm.gallery[index -1]){
              vm.items[index].id = vm.recipeForm.gallery[index -1].id;
              vm.recipeForm.gallery[index -1] = false;
              }
            this.createImage(item, files[0], name);
           
            },
            createImage(item, file, name) {
              let image = new Image();
              let reader = new FileReader();

              reader.onload = (e) => {
                item.image = e.target.result; 
                item.name = name; 

              };
              reader.readAsDataURL(file);
            },
            closeModel(){
              let vm = this;  
              for(let i=0; i < 4 ; i++){               
                vm.items[i].image = false;
                vm.items[i].name = '';
              }
              for(let i=0; i < this.tagsArray.tags.length; i++){
                vm.tagsArray.tags = '';
                vm.tagsArray.amount = '';
              }   
               this.currentAmount = '';
               this.currentTag = '';
               this.recipeForm.reset();
              $('#addNew').modal('hide');
            },
            deleteRecipe(id){
               let vm = this;
              
               swal.fire({
                      title: 'Are you sure?',
                      text: "Recipe will be moved to trash!",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                     if (result.value) {

                     axios.delete(`/recipe/${id}`)
                           .then(()=>{
                              toast.fire(
                              'Deleted!',
                              'Recipe has been moved to trash.',
                              'success'
                              );
                              vm.loadRecipes();
                           })
                         }
                 })        

            },
            removeImage: function (item) {
              item.image = false; 
                    }, 
            editAmount(tag){

              this.tagAmount = tag;

            },
            doneEditTag(index){
               this.tagsArray.amount.push(this.currentAmount);
               this.tagsArray.tags.push(this.recipeForm.tags[index].name);
               this.recipeForm.tags[index]= {};
               this.tagAmount = false;
               this.currentAmount = '';
            }, 
            cancelEditTag(){
               this.currentAmount = '';
               this.tagAmount = false; 
           }, 
           deleteTag(index){
               
               this.recipeForm.tags[index].name = '';
               this.recipeForm.tags[index] = {};
           }, 
           addAmount(){
               this.tagsArray.amount.push(this.currentAmount);
               this.currentAmount = "";
               this.$refs.tag.focus();
            },
           newModal(value){
                $('#addNew').modal('show');
                this.title = value;
                this.recipeForm.fill(value);
                
                
            }, 
            /*
        Handles the selection of a tag from the autocomplete.
      */
      selectTag( tag ){
        /*
          Check if there are duplicates in the array.
        */
        if( !this.checkDuplicates( tag ) ){
          /*
            Clean the tag name and add it to the array.
          */
          tag = this.cleanTagName( tag );
          this.tagsArray.tags.push( tag );

          /*
            Emit the tags array and reset the inputs.
          */
         

          this.resetInputs();
        }else{
          /*
            Flag as duplicate
          */
          this.duplicateFlag = true;
        }
      },

      /*
        Adds a new tag from the input
      */
      addNewTag(){
        /*
          If the tag is not a duplicate, continue.
        */
        if( !this.checkDuplicates( this.currentTag ) ){
          var newTagName = this.cleanTagName( this.currentTag );
          this.tagsArray.tags.push( newTagName );
         this.$refs.tag.nextElementSibling.focus();
          /*
            Emit the tags have been edited.
          */
        

          /*
            Reset the inputs
          */
          this.resetInputs();
        }else{
          this.duplicateFlag = true;
        }
      },

      /*
      
    

      /*
        Allows the user to select a tag going up or down on the
        autocomplete.
      */
      changeIndex( direction ){
        /*
          Flags to pause the search since we don't want to search on arrows up
          or down.
        */
                this.pauseSearch = true;

        /*
          If the direction is up and we are not at the beginning of the tags array,
          we move the index up and set the current tag to that in the autocomplete.
        */
                if( direction == 'up' && ( this.searchSelectedIndex -1 > -1 ) ){
                    this.searchSelectedIndex = this.searchSelectedIndex - 1;
                    this.currentTag = this.tagSearchResults[this.searchSelectedIndex].name;
                }

        /*
          If the direction is down and we are not at the end of the tags array, we
          move the index down and set the current tag to that of the autocomplete.
        */
                if( direction == 'down' && ( this.searchSelectedIndex + 1 <= this.tagSearchResults.length - 1 ) ){
                    this.searchSelectedIndex = this.searchSelectedIndex + 1;
                    this.currentTag = this.tagSearchResults[this.searchSelectedIndex].name;
                }
            },

      /*
        Searches the API route for tags with the autocomplete.
      */
      searchTags(){
        if( this.currentTag.length > 2 && !this.pauseSearch ){
          this.searchSelectedIndex = -1;
          axios.get( '/api/searchTag' , {
            params: {
              q: this.currentTag
            }
          }).then( function( response ){
            this.tagSearchResults = response.data;
          }.bind(this));
        }
      },

      /*
        Check for tag duplicates.
      */
      checkDuplicates( tagName ){
                tagName = this.cleanTagName( tagName );

                return this.tagsArray.tags.indexOf( tagName ) > -1;
            },

      /*
        Cleans the tag to remove any unnecessary whitespace or
        symbols.
      */
      cleanTagName( tagName ){
        /*
          Convert to lower case
        */
        var cleanTag = tagName.toLowerCase();

        /*
          Trim whitespace from beginning and end of tag and
          convert anything not a letter or number to a dash.
        */
        cleanTag = cleanTag.trim().replace(/[^a-zA-Z0-9]/g,'-');

        /*
          Remove multiple instance of '-' and group to one.
        */
        cleanTag = cleanTag.replace(/-{2,}/, '-');

        /*
          Get rid of leading and trailing '-'
        */
        cleanTag = this.trimCharacter(cleanTag, '-');

        /*
          Return the clean tag
        */
        return cleanTag;
      },

      /*
        Remove the tag from the tags array.
      */
      removeTag( tagIndex ){
        this.tagsArray.tags.splice( tagIndex, 1 );
        this.tagsArray.amount.splice( tagIndex, 1 );
      },

      /*
        Trims any leading or ending characters
      */
      trimCharacter (string, character) {
        if (character === "]") c = "\\]";
        if (character === "\\") c = "\\\\";
        return string.replace(new RegExp(
          "^[" + character + "]+|[" + character + "]+$", "g"
        ), "");
      },

      /*
        Reset the inputs for the tags input
      */
      resetInputs(){
        this.currentTag = '';
        this.tagSearchResults = [];
        this.duplicateFlag = false;
        this.searchSelectedIndex = -1;
        this.pauseSearch = false;
      },

      
      /*
        Handles the deletion in the tag input.
      */
            handleDelete(){
                this.duplicateFlag = false;
                this.pauseSearch = false;
                this.searchSelectedIndex = -1;

        /*
          If the current tag has no data, we remove the last tag.
        */
                if( this.currentTag.length == 0 ){
                    this.tagsArray.tags.splice( this.tagsArray.tags.length - 1, 1);
                     }
            }, 

      },
      created(){
        this.loadRecipes();
      },
        computed: {
      
        showAutocomplete: function(){
                return this.tagSearchResults.length == 0 ? false : true;
            }
     },
      filters: {
         round: function(value){
           return Math.round(value);
         },
      },
    }
</script>
