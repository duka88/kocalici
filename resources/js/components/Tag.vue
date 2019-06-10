<template>
  <div class="tags-input-container">
    <label>Tags</label>
    <div class="tags-input" v-on:click="focusTagInput()">
      <div class="selected-tag" v-for="(selectedTag, key) in tagsArray">{{ selectedTag }} <span class="remove-tag" v-on:click="removeTag( key )">&times;</span> </div>
      <input type="text" v-bind:id="unique" class="new-tag-input" v-model="currentTag" v-on:keyup="searchTags" v-on:keyup.enter="addNewTag" v-on:keydown.up="changeIndex( 'up' )" v-on:keydown.delete="handleDelete" v-on:keydown.down="changeIndex( 'down' )" v-bind:class="{ 'duplicate-warning' : duplicateFlag }" placeholder="Add a tag"/>
    </div>
    <div class="tag-autocomplete" v-show="showAutocomplete">
      <div class="tag-search-result" v-for="(tag, key) in tagSearchResults" v-bind:class="{ 'selected-search-index' : searchSelectedIndex == key }" v-on:click="selectTag( tag.tag )">{{ tag.tag }}</div>
    </div>
  </div>
</template>

<script>

  export default {
    props: ['unique'],

    /*
      Defines the data used by the component.
    */
    data(){
      return {
        currentTag: '',
        tagsArray: [],
        tagSearchResults: [],
        duplicateFlag: false,
        searchSelectedIndex: -1,
        pauseSearch: false
      }
    },

      /*
      Clear tags
    */
    mounted(){
      EventBus.$on('clear-tags', function( unique ){
        this.currentTag = '';
        this.tagsArray = [];
        this.tagSearchResults = [];
        this.duplicateFlag = false;
        this.searchSelectedIndex = -1;
        this.pauseSearch = false;
      }.bind(this));
    },

    /*
      Defines the computed data.
    */
    computed: {
      /*
        Determines if we should show the autocomplete or not.
      */
            showAutocomplete: function(){
                return this.tagSearchResults.length == 0 ? false : true;
            }
        },

    /*
      Defines the methods used by the component.
    */
    methods: {
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
          EventBus.$emit( 'tags-edited', { unique: this.unique, tags: this.tagsArray } );

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
          EventBus.$emit( 'tags-edited', { unique: this.unique, tags: this.tagsArray } );

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
        EventBus.$emit( 'tags-edited', { unique: this.unique, tags: this.tagsArray } );
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
                    this.currentTag = this.tagSearchResults[this.searchSelectedIndex].tag;
                }

        /*
          If the direction is down and we are not at the end of the tags array, we
          move the index down and set the current tag to that of the autocomplete.
        */
                if( direction == 'down' && ( this.searchSelectedIndex + 1 <= this.tagSearchResults.length - 1 ) ){
                    this.searchSelectedIndex = this.searchSelectedIndex + 1;
                    this.currentTag = this.tagSearchResults[this.searchSelectedIndex].tag;
                }
            },

      /*
        Searches the API route for tags with the autocomplete.
      */
      searchTags(){
        if( this.currentTag.length > 2 && !this.pauseSearch ){
          this.searchSelectedIndex = -1;
          axios.get( ROAST_CONFIG.API_URL + '/tags' , {
            params: {
              search: this.currentTag
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
        Focus on the tag input.
      */
      focusTagInput(){

                document.getElementById( this.unique ).focus();
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
          /*
            Emit that the tags have been edited.
          */
          EventBus.$emit( 'tags-edited', { unique: this.unique, tags: this.tagsArray } );               }
            }
    }
  }
</script>