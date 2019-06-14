<template>
     <div class="container">
       <div class="form-group"> 
             <label for="title">Title</label>
             <input name="title" v-model="recipe.title" type="text" class="form-control">
             
        </div>     
        <div class="form-gropup">
            <label for="title">Description</label>
            <input name="description"  type="text" v-model="recipe.description" class="form-control">
        </div>    
        <div class="form-gropup mb-4">
            <label for="title">Category</label>
            <select v-model="recipe.category_id" class="form-control">
                <option v-for="category in categories" :value="category.id">{{category.name}}</option>
            </select>
        </div>
         <div class="form-group">
              <label>Tags</label>
          <div class="tags-input" >
              <div class="selected-tag" v-for="(selectedTag, key) in tagsArray">{{ selectedTag }} <span class="remove-tag" v-on:click="removeTag( key )">&times;</span> </div>
                <input type="text"  class="new-tag-input" v-model="currentTag" v-on:keyup="searchTags" v-on:keyup.enter="addNewTag" v-on:keydown.up="changeIndex( 'up' )" v-on:keydown.delete="handleDelete" v-on:keydown.down="changeIndex( 'down' )" v-bind:class="{ 'duplicate-warning' : duplicateFlag }" placeholder="Add a tag"/>
                  </div>
              <div class="tag-autocomplete" v-show="showAutocomplete">
                <div class="tag-search-result" v-for="(tag, key) in tagSearchResults" v-bind:class="{ 'selected-search-index' : searchSelectedIndex == key }" v-on:click="selectTag( tag.name )">{{ tag.name }}</div>
          </div>
        </div>       
        <div class="form-gropup mb-4">    
            <ckeditor :editor="editor" v-model="recipe.content" :config="editorConfig"></ckeditor>
        </div>
           <button class="btn btn-primary mb-4" @click="uploadRecipe">Save</button>
          <!-------------Gallery ------------------->

                    <div v-for="(item, index) in items"  class="form-gropup">
                        <div v-if="!item.image">
                         <h3 v-if="index === 0">Main Image</h3>                     
                         <label class="custom-file-upload"> 
                          <input  style="display: none" type="file" @change="onFileChange(item, $event)">Custom Upload
                         </label> 
                        </div>
                        <div v-else>
                          <img :src="item.image"  height="300" width="480">
                          <button @click="removeImage(item)">Remove image</button>
                        </div>
                      </div>                   
                 </div>
         <!-------------End Gallery ------------------->     
              
                
    </div>
</template>

<script>
 import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        data(){
            return{
               editor: ClassicEditor,                
                editorConfig: {
                    // The configuration of the rich-text editor.
                },              
               newtags: {},               
               categories: {},
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
               photos: {},
               name: '',
               show: '',
               number: 0,
               id: '',
               currentTag: '',
               tagsArray: [],
               tagSearchResults: [],
               duplicateFlag: false,
               searchSelectedIndex: -1,
               pauseSearch: false,
                recipe: {
                 content: '',
                 title: '',                 
                 category_id: '',
                 description: '',
                 
               },
            
            }

        },
        props: ['user_id'],
        computed: {
          /*
            Determines if we should show the autocomplete or not.
          */
            showAutocomplete: function(){
                return this.tagSearchResults.length == 0 ? false : true;
            }
        },
        methods: {
           onFileChange(item, e) {
              let files = e.target.files || e.dataTransfer.files;
              let name = e.target.files[0].name
              if (!files.length)
                return;
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

            uploadGallery(){
                axios.post('/api/gallery',{
                    image: this.photo,
                    name: this.name                   
                })
            },
            loadGallery(){
                axios.get('api/gallery')
                     .then(({data}) => {
                        this.photos = data.data;
                        this.show = data.data[0].image;
                     })
                     

            },         
            loadCategories(){
                axios.get('api/category')
                     .then(({data}) => {
                        this.categories = data.data;
                       
                     })
            },
            editGallery(recipe_id = null){
                axios.put('api/gallery',{
                    image: this.photo,
                    name: this.name,
                    id: this.id
                   
                })
            },

            uploadRecipe(){
                let image = this.items[0];

                axios.post('api/recipe',{    
                      title: this.recipe.title,
                      description: this.recipe.description,
                      content: this.recipe.content,
                      image: image.image,
                      name: image.name,
                      user_id: this.user_id,                      
                      category_id: this.recipe.category_id,
                      gallery: this.items,
                      tags: this.tagsArray  
                })
                .then(({data}) => {                     
                     let recipe_id = data.id;

                });
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
          this.tagsArray.push( tag );

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
          this.tagsArray.push( newTagName );

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
        Remove the tag from the tags array.
      */
      removeTag( tagIndex ){
        this.tagsArray.splice( tagIndex, 1 );

        /*
          Emit that the tags have been edited.
        */
       
      },

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
          axios.get( 'api/searchTag' , {
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

                return this.tagsArray.indexOf( tagName ) > -1;
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
        this.tagsArray.splice( tagIndex, 1 );
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
                    this.tagsArray.splice( this.tagsArray.length - 1, 1);
                     }
            },       

        },

       created() {
            this.loadGallery();
            this.loadCategories();
        
          
          
        }
    }
</script>
