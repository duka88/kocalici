<template>
    <div class="container">
         
       <div class="card"  >
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>
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
                      :class="{'fa-chevron-down':userDirection == 'DESC' && userSort=='category_id', 'fa-chevron-up':userDirection == 'ASC'  && userSort=='category_id' }"></i></th>
                    <th @click="Sort('title')">Title <i class="fas" 
                      :class="{'fa-chevron-down':userDirection == 'DESC' && userSort=='title', 'fa-chevron-up':userDirection== 'ASC'  && userSort=='title' }"></i></th>
                    <th @click="Sort('score')">Avg <i class="fas"
                      :class="{'fa-chevron-down':userDirection == 'DESC' && userSort=='score', 'fa-chevron-up':userDirection== 'ASC'  && userSort=='score' }"></i></th>
                    <th @click="Sort('likes')">Likes <i class="fas"
                      :class="{'fa-chevron-down':userDirection == 'DESC' && userSort=='likes', 'fa-chevron-up':userDirection== 'ASC'  && userSort=='likes' }"></i></th>
                    <th @click="Sort('created_at')">Created_at <i class="fas" 
                      :class="{'fa-chevron-down':userDirection == 'DESC' && userSort=='created_at', 'fa-chevron-up':userDirection== 'ASC'  && userSort=='created_at' }"></i></th>
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
                        <a>
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



       <div   class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog " role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5  class="modal-title" id="exampleModalLabel">Add New</h5>
                    <h5  class="modal-title" id="exampleModalLabel">Update</h5>
                    <button  type="button" class="close" data-dismiss="modal" aria-label="Close">
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
             
               <img v-if="recipeForm.gallery[index -1]"
                 :src="`/img/XS/${recipeForm.gallery[index -1].image}`">
              <img v-else :src="item.image" class="w-100">
             
              
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

<!----------tags----------->

         <div class="form-group mb-4">            
          <label>Ingredients</label>
          <div class="tags-input" >
            
            <p v-for="tag in recipeForm.tags">
                {{tag.name}} <span> {{tag.pivot.amount}}</span>
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


 <!----------tags----------->
         

        </div>       
        <div class="form-gropup mb-4">    
            <ckeditor :editor="editor" v-model="recipeForm.content" :config="editorConfig" :class="{'is-invalid': recipeForm.errors.has('content')}"></ckeditor>
             <has-error :form="recipeForm" field="content"></has-error>
        </div>
        <button class="large_button mb-4" >Add Recipe</button>                
      </div>
                 
          </div>
          </div>
          </div>


   

















    
     
                
    </div>
    </div>

</template>

<script>
   import { mapActions } from 'vuex';
   import { mapState } from 'vuex';
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
 
    export default {
         
        data(){            
            return {
               items: [
                   {
                     image: false,
                     name: ''
                   },
                   {
                     image: false,
                     name: ''
                   },
                   {
                     image: false,
                     name: ''
                   },
                   {
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

            }
        },

        methods:{
            onFileChange(item, index, e) {
               
              let files = e.target.files || e.dataTransfer.files;
              let name = e.target.files[0].name
              if (!files.length)
                return;           
            
             this.recipeForm.gallery[index -1] = false;
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
            removeImage: function (item) {
              item.image = false; 
                    }, 
                      
           Sort(value){
              this.sort = value;
              if(this.userDirection == 'DESC'){
                this.$store.dispatch('usersRecipesSort',
                {userSort: value, userDirection: 'ASC' })
                 
               }else{
                 this.$store.dispatch('usersRecipesSort',
                {userSort: value, userDirection: 'DESC' })
               }
             

            },       
            paginate(page = 1){
               this.$store.dispatch('paginateRecipes', page); 
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
      computed: {
        recipes(){
            return this.$store.state.usersRecipes;
        },
        showAutocomplete: function(){
                return this.tagSearchResults.length == 0 ? false : true;
            },

      ...mapState([
         'userSort',
         'userDirection'
        ])

      }, 
        
      filters: {
         round: function(value){
           return Math.round(value);
         },
      }, 
     
    }
</script>
