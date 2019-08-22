<template>
      <div class="container" v-if="$gate.isAdmin()">
        <div class="row mt-5">
          <div class="col-12">
            <div class="card"  >
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>
                <div class="card-tools">
                    <button @click="newModal" class="btn btn-success" data-toggle="modal" >Add New</button>
                </div>
            
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Registred At</th>
                    <th>Modify</th>
                  </tr>
                  <tr v-for="user in users.data" :key="user.id">
                    <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.role}}</td>
                    <td>{{user.created_at }}</td>
                    <td >
                        <a @click="editModal(user)">
                            <i class="fa fa-edit text-blue"></i>
                        </a>
                        /
                        <a @click="deleteUser(user.id)" >
                            <i class="fa fa-trash text-red"></i>
                        </a>
                       </td>
                  </tr>
                  
                </tbody></table>
              </div>
              
             <div class="card-footer">
               <pagination :data="users"  @pagination-change-page="getResults"></pagination>
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
                  <form @submit.prevent="edit ? updateUser() : createUser()">
                      <div class="modal-body">
                         <div class="form-group">
                            <input v-model="form.name" type="text" name="name" id="name" placeholder="name" 
                              class="form-control" :class="{'is-invalid': form.errors.has('name')}">
                              <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.email" type="email" name="email" id="email" placeholder="email" 
                              class="form-control" :class="{'is-invalid': form.errors.has('email')}">
                              <has-error :form="form" field="email"></has-error>
                        </div>                     
                    
                        <div class="form-group">
                            <select v-model="form.role" name="type" id="type" 
                              class="form-control" :class="{'is-invalid': form.errors.has('type')}">
                             <option value="writer">Writer</option>              
                              <option value="admin">Admin</option>                            
                            </select> 
                              <has-error :form="form" field="type"></has-error>
                        </div> 
                        <div class="form-group">
                            <input v-model="form.password" type="password" name="password" id="password"
                              class="form-control" placeholder="password" :class="{'is-invalid': form.errors.has('password')}">
                              <has-error :form="form" field="password"></has-error>
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
                users: {},
                edit: false,
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    role: 'writer'
                })
            }
        },
        methods: {
            loadUsers(){
                axios.get('/api/users')
                     .then(({data})=>{

                        this.users = data;
                     })
            },
              getResults(page = 1) {
                     axios.get('/api/users?page=' + page)
                           .then(data => {
                             this.users = data.data;
                      });
              },
            createUser(){
                let vm = this;
                this.form.post('/api/users')
                     .then(()=>{
                       toast.fire({
                            type: 'success',
                            title: 'User created successfully'
                           })
                       $('#addNew').modal('hide');
                        vm.loadUsers();
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
            updateUser(){
                let vm = this;
                this.form.put(`/api/users/${this.form.id}`)
                         .then(() =>{
                          toast.fire({
                            type: 'success',
                            title: 'User updated successfully'
                           })
                           $('#addNew').modal('hide'); 
                            vm.loadUsers();
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
            deleteUser(id){
              let vm = this;               
                     
                swal.fire({
                      title: 'Are you sure?',
                      text: "User will be deleted",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                     if (result.value) {

                     axios.delete(`/api/users/${id}`)
                       .then(()=>{
                         toast.fire(
                              'Deleted!',
                              'User has been deleted.',
                              'success'
                              );
                         vm.loadUsers();                               
                       }) 
                          
                    }
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
            editModal(user){
                this.edit = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
            },
            newModal(){
                this.edit = false;
                this.form.reset();
                $('#addNew').modal('show');
            }

        },
        created(){
            this.loadUsers();
        }
    }
</script>
