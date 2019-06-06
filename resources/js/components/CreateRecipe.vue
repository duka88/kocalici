<template>
    <div class="container">
         <img :src="`/img/MD/${show}`" width="480px" height="300">
               <div v-for="(phots, index) in photos" :key="photos.id">
                 <img :src="`/img/XS/${phots.image}`"                 

                  type='button'
                  @click="show = phots.image"
                   width="60px" height="50px"> 
               <form  @change="uploadPicture" >
                <input  type="hidden"  :value="phots.id">
                <label class="custom-file-upload">
                    <input style="display: none" type="file" >
                    Custom Upload
                </label>
               </form>
             </div>
             <div v-if="photos.length <= 16"> 
                <label class="custom-file-upload">
                    <input style="display: none"  @change="uploadPicture" type="file">
                    Custom Upload
                </label>
             </div>   
      
    </div>
</template>

<script>
    export default {
        data(){
            return{
               photos: {}, 
               photo: '',
               name: '',
               show: '',
               number: 0,
              
            }

        },
        methods: {
            uploadPicture(e){
                let file = e.target.files[0];
                this.name = e.target.files[0].name; 
                let reader = new FileReader();
               console.log(e.target);
                if(file['size'] < 2097152){
                    reader.onloadend = (file) => {
                       this.photo =  reader.result;
                       this.uploadRecipes(reader.result, e.target.files[0].name );
                    } 
                    reader.readAsDataURL(file);
                }
                

            },
            uploadRecipes(photo, name, id){
                axios.post('/api/gallery',{
                    image: photo,
                    name: name,
                    id: id
                })
            },
            loadGallery(){
                axios.get('api/gallery')
                     .then(({data}) => {
                        this.photos = data.data;
                        this.show = data.data[0].image;
                     })
            },
            editGallery(photo, name){
                axios.put('api/gallery',{
                    image: photo,
                    name: name
                })
            }
        },
       created() {
            this.loadGallery();
          
        }
    }
</script>
