<template>
     <div class="container">
       <div class="form-group"> 
             <label for="title">Title</label>
             <input name="title" id='title' v-model="form.title" type="text" class="form-control" :class="{'is-invalid': form.errors.has('title')}">
               <has-error :form="form" field="title"></has-error>
        </div>     
        <div class="form-gropup">
            <label for="title">Description</label>
            <input name="description"  type="text" v-model="form.description" class="form-control"  :class="{'is-invalid': form.errors.has('description')}">
               <has-error :form="form" field="description"></has-error>
        </div>    
        <div class="form-gropup mb-4">
            <label for="title">Category</label>
            <select v-model="form.category_id" class="form-control" name="category_id"
            :class="{'is-invalid': form.errors.has('category_id')}">
                <option v-for="category in categories" :value="category.id">{{category.name}}</option>
            </select>
            <has-error :form="form" field="category_id"></has-error>
        </div>
        <div class="form-group"> 
                                  
                    <input 
                     v-model="form.dificulty" type="range" step="0.01" name ="dificulty" min="1" max="10" value="5" class="form-control" id="dificulty">
                   <span >{{form.dificulty | round }}</span>
               </div> 
        <div class="form-group"> 
                                  
                    <input 
                     v-model="form.servings" type="range" step="0.01" name ="servings" min="1" max="100" value="5" class="form-control" id="servings">
                   <span >{{form.servings | round}}</span>
               </div> 
        <div class="form-group">                                   
                    <input 
                     v-model="form.time" type="range" step="0.01" name ="time" min="1" max="240" value="5" class="form-control" id="time">
                   <span >{{form.time | round}}</span>
               </div> 
         <div class="form-group">
              <label>Ingredients</label>
          <div class="tags-input" >
              <div class="selected-tag" v-for="(selectedTag, key) in tagsArray.tags">
                <span class="font-weight-bold">Ingredient </span>{{ selectedTag }}
                 / <span class="font-weight-bold">Amount</span> {{ tagsArray.amount[key] }} 
                 <span class="remove-tag" v-on:click="removeTag( key )">&times;</span>
             
               </div>
               
                <input ref="tag" type="text"  class="new-tag-input" v-model="currentTag" v-on:keyup="searchTags" v-on:keyup.enter="addNewTag" v-on:keydown.up="changeIndex( 'up' )" v-on:keydown.delete="handleDelete" v-on:keydown.down="changeIndex( 'down' )" v-bind:class="{ 'duplicate-warning' : duplicateFlag }" placeholder="Add a tag"/>
                 <input v-model="currentAmount" type="text" v-on:keyup.enter="addAmount" :class="{'is-invalid': form.errors.has('tag')}">
                  </div>
                 <has-error :form="form" field="tag"></has-error>
              <div class="tag-autocomplete" v-show="showAutocomplete">
                <div class="tag-search-result" v-for="(tag, key) in tagSearchResults" v-bind:class="{ 'selected-search-index' : searchSelectedIndex == key }" v-on:click="selectTag( tag.name )">{{ tag.name }}</div>
          </div>
        </div>       
        <div class="form-gropup mb-4">    
            <ckeditor :editor="editor" v-model="form.content" :config="editorConfig" :class="{'is-invalid': form.errors.has('content')}"></ckeditor>
             <has-error :form="form" field="content"></has-error>
        </div>
           <button class="btn btn-primary mb-4" @click="uploadRecipe">Save</button>
        

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
               currentAmount: '',
               tagsArray: {
                  tags:[],
                  amount:[]
                },
               tagSearchResults: [],
               duplicateFlag: false,
               searchSelectedIndex: -1,
               pauseSearch: false,
                form: new Form({
                 content: '',
                 title: '',                 
                 category_id: '',
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
               }),
            
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
                            
            loadCategories(){
                axios.get('/api/category')
                     .then(({data}) => {
                        this.categories = data.data;
                       
                     })
            },
          
            uploadRecipe(){

                 this.form.image = this.items[0].image;
                 this.form.name = this.items[0].name;
                 this.form.gallery = this.items;
                 this.form.tags = this.tagsArray.tags;
                 this.form.amount = this.tagsArray.amount; 

                this.form.post('/recipe'            
                )
                .then(({data}) => {                     
                     let recipe_id = data.id;

                })
                 .catch(errors => console.log(errors));
            },
            addAmount(){
               this.tagsArray.amount.push(this.currentAmount);
               this.currentAmount = "";
               this.$refs.tag.focus();
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
      filters: {
         round: function(value){
           return Math.round(value);
         }
        },
       created() {
            
            this.loadCategories();
        
          
          
        }
    }
</script>
