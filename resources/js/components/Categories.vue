<template>
      <div class="container">
        <div class="row mt-5">
          <div class="col-12">
            <div class="card"  >
              <div class="card-header">
                <h3 class="card-title">Comments</h3>
                <div class="card-tools">
                    <p @click="newModal" class="text-success" data-toggle="modal" >Add Category</p>
                </div>
            
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Recipe Count</th>
                    <th>Modify</th>                    
                  </tr>
                  <tr v-for="category in categorise.data" :key="category.id">
                    <td>{{category.id}}</td>
                    <td><img :src="`/img/XS/${category.image}`"></td>
                    <td>{{category.name}}</td>
                    <td>{{category.recipe}}</td>                   
                    <td >
                        <a @click="editModal(category)">
                            <i class="fa fa-edit text-primary"></i>
                        </a>
                        /
                        <a @click="deleteCategory(category.id)" >
                            <i class="fa fa-trash text-danger"></i>
                        </a>
                       </td>
                  </tr>
                  
                </tbody></table>
              </div>
              
             <div class="card-footer">
              
             </div>  
            </div>
         
          </div>
        </div>
            <div   class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog " role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5  class="modal-title" id="exampleModalLabel">Add New</h5>
                    <h5  class="modal-title" id="exampleModalLabel">Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form @submit.prevent="edit ? updateCaregory() : createCaregory()">
                      <div class="modal-body">
                         <div class="form-group">
                            <input v-model="form.name" type="text" name="name" id="name" placeholder="name" 
                              class="form-control" :class="{'is-invalid': form.errors.has('name')}">
                              <has-error :form="form" field="name"></has-error>
                        
                        <img v-if="item['image']" :src="item['image']" class="w-100">
                         <img v-else :src="`/img/S/${form.image}`" alt="">
                
                          <label class="custom-file-upload d-flex mt-2 mb-4"> 
                            <input  style="display: none" type="file" @change="onFileChange(item, $event)"><span v-if="edit">Change Image </span><span v-else>Add Image</span>
                         </label>
                        
                       </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-if="!edit" type="submit" class="btn btn-primary">Create</button>
                        <button v-if="edit" type="submit" class="btn btn-primary">Update</button>
                      </div>
                 </form>
                </div>
              </div>
            </div>

    </div>
</template>

<script>
    export default {
        data(){
            return{ 
                item: {                   
                     image: false,
                     name: ''
                   },              
                categorise: {},
                
                edit: false,
                form: new Form({
                    id: '',
                    name: '',
                    image: '',
                   
                })
            }
        },
        methods: {
            onFileChange(item, e) {
               
              let files = e.target.files || e.dataTransfer.files;
              let name = e.target.files[0].name;
              let vm = this;
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
            loadCategories(){
                axios.get('/category')
                     .then(({data})=>{

                        this.categorise = data;
                     })
            },          
            createCaregory(){
                let vm = this;
                this.form.image = this.item;
                this.form.post('/category')
                     .then(()=>{
                       toast.fire({
                          type: 'success',
                          title: 'Category created successfully'
                        })
                       $('#addNew').modal('hide');
                         vm.loadCategories();
                      
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
            updateCaregory(){
                let vm = this;
                this.form.image = this.item;
                this.form.put(`/category`)
                         .then(() =>{
                          toast.fire({
                            type: 'success',
                            title: 'Category updated successfully'
                           })
                           $('#addNew').modal('hide'); 
                            vm.loadCategories();
                          
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
            deleteCategory(id){
              let vm = this;
               
                 swal.fire({
                      title: 'Are you sure?',
                      text: "Category will be deleted!",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                     if (result.value) {

                     axios.delete(`/category/${id}`)
                           .then(()=>{
                              toast.fire(
                              'Deleted!',
                              'Caregory has been removed.',
                              'success'
                              )
                              vm.loadCategories();
                           })
                         .catch((error) => {
                             if (error.response) {
                            console.log(error.response.data);
                                toast.fire({
                                  type: 'error',
                                  title: error.response.data
                                }) 
                 
                           } 
                        })
                    }
                 })
               },
            editModal(user){
                this.edit = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
                this.item['image'] = false;
                this.item['name'] = '';
            },
            newModal(){
                this.edit = false;
                this.form.reset();
                this.item['image'] = false;
                this.item['name'] = '';
                $('#addNew').modal('show');
            }

        },
        created(){
            this.loadCategories();
        }
    }
</script>
