<template>
    <div class="container">
          <form @submit.prevent="uploadRecipes">
               
                <input type="file" @change="uploadPicture" >
               
             
                <button type="submit"  class="btn btn-success btn-block btn-sm col-1">Save</button>
            </form>
    </div>
</template>

<script>
    export default {
        data(){
            return{
               photo: '',
            }

        },
        methods: {
            uploadPicture(e){
                let file = e.target.files[0];
                let reader = new FileReader();
     
                if(file['size'] < 2097152){
                    reader.onloadend = (file) => {
                       this.photo =  reader.result;
                    } 
                    reader.readAsDataURL(file);
                }
            },
            uploadRecipes(){

            }

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
https://www.google.com/search?biw=1920&bih=937&ei=ZO33XPbWA4aP6AStoYugDw&q=show+picture+that+you+are+uploading+vue&oq=show+picture+that+you+are+uploading+vue&gs_l=psy-ab.3...694.3058..3345...0.0..0.181.684.0j4......0....1..gws-wiz.......0i71j33i22i29i30j33i160.bSvC7h-FtqA#kpvalbx=1


https://www.youtube.com/watch?v=ikQbjRcV9W0&list=PLB4AdipoHpxaHDLIaMdtro1eXnQtl_UvE&index=31