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
         <div v-for="tag in tags" class="form-check">
            <input type="checkbox" class="form-check-input"  v-model="recipe.tags" :value="tag.id" name="tags">
            <label class="form-check-label" for="tags">{{tag.name}}</label>
        </div>
         <div class="form-gropup">
            <label for="title">Add Tags</label>
            <input name="tag"  type="text" v-model="tags" class="form-control">
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
               tags:{},
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
                   },
                   {
                     image: false,
                     name: ''
                   },
                   {
                     image: false,
                     name: ''
                   },
                ],
               photos: {},
               name: '',
               show: '',
               number: 0,
               id: '',
                recipe: {
                 content: '',
                 title: '',                 
                 category_id: '',
                 description: '',
                 tags:[]
               },
            
            }

        },
        props: ['user_id'],
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
            loadTags(){
                axios.get('api/fridge')
                      .then(({data}) =>{
                        this.tags = data.data
                      })
                      .catch(error => {
                        console.log(error);
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
                      gallery: this.items  
                })
                .then(({data}) => {                     
                     let recipe_id = data.id;

                });
            }       

        },

       created() {
            this.loadGallery();
            this.loadCategories();
            this.loadTags();
          
          
        }
    }
</script>
