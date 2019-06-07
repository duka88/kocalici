<template>
    <div class="container">
         <input type="text" v-model="recipe.description">

         <label class="custom-file-upload" v-model="recipe.image"
                 @click="id = 'a'">
                 <input style="display: none" type="file" @change="uploadPicture">
                        Custom Upload
                    </label>
        <input v-model="recipe.title" type="text">
        <select v-model="recipe.category_id" >
            <option v-for="category in categories" :value="category.id">{{category.name}}</option>
        </select>
        <ckeditor :editor="editor" v-model="recipe.content" :config="editorConfig"></ckeditor>
     <button @click="uploadRecipe">test</button>
        <img :src="`/img/MD/${show}`" width="480px" height="300">
               <div v-for="(phots, index) in photos" :key="photos.id">
                     <img :src="`/img/XS/${phots.image}`"     
                      type='button'
                      @click="show = phots.image"
                      width="60px" height="50px"> 
                    <form  @change="uploadPicture" >
                    <input  type="hidden"  :value="phots.id">
                    <label class="custom-file-upload" @click="id = phots.id">
                        <input style="display: none" type="file"  @click="id = phots.id" >
                        Custom Upload
                    </label>
                   </form>
             </div>
             <div v-if="photos.length <= 6"> 
                <label class="custom-file-upload">
                    <input style="display: none"  @change="uploadPicture" type="file">
                    Custom Upload
                </label>
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
               categories: {}, 
               photos: {}, 
               photo: '',
               name: '',
               show: '',
               number: 0,
               id: '',
                recipe: {
                 content: '',
                 title: '',                 
                 category_id: '',
                 description: ''
               },
              
            }

        },
        props: ['user_id'],
        methods: {
            uploadPicture(e){
                console.log(e.target.files);
                let file = e.target.files[0];
                this.name = e.target.files[0].name; 
                let reader = new FileReader();
               console.log(e.target);
                if(file['size'] < 2097152){
                    reader.onloadend = (file) => {
                       this.photo =  reader.result;
                  if(this.id != 'a'){      
                    if(this.id == ''){ 
                       this.uploadGallery();
                       this.loadGallery();
                      }else{
                        this.editGallery();
                        this.loadGallery();
                      }
                     }
                    } 
                    reader.readAsDataURL(file);
                }
                

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
                     console.log(this.photos)
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
                axios.post('api/recipe',{
                      title: this.recipe.title,
                      description: this.recipe.description,
                      content: this.recipe.content,
                      image: this.photo,
                      name: this.name,
                      user_id: this.user_id,                      
                      category_id: this.recipe.category_id  
                })
                .then(({data}) => {
                     let recipe_id = data.id;
                });
            }       

        },

       created() {
            this.loadGallery();
            this.loadCategories();
          
          
        }
    }
</script>
