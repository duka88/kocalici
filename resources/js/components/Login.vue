<template>
    <div class="container">
         <div class="card-tools">
                    <button v-if="token" @click="logOut" class="btn btn-success">Logout</button>
                </div>
          <div class="card-tools">
                    <button @click="newModal" class="btn btn-success" data-toggle="modal" >Add New</button>
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
                  <form @submit.prevent="loginUser">
                      <div class="modal-body">
                         <div class="form-group">
                            <input v-model="form.username" type="text" name="username" id="username" placeholder="username" 
                              class="form-control" :class="{'is-invalid': form.errors.has('username')}">
                              <has-error :form="form" field="username"></has-error>
                        </div>         
                        <div class="form-group">
                            <input v-model="form.password" type="password" name="password" id="password"
                              class="form-control" placeholder="password" :class="{'is-invalid': form.errors.has('password')}">
                              <has-error :form="form" field="password"></has-error>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-if="register" type="submit" class="btn btn-primary">Register</button>
                        <button v-if="!register" type="submit" class="btn btn-primary">Login</button>
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
            return {
               form: new Form({                  
                    username: '',                   
                    password: ''                   
                }), 
               token: localStorage.getItem('token') || null,
               register: false
            }
        },
        methods: {
             loginUser(){
              this.form.post('/api/login')
                         .then(({data})=>{
                            localStorage.setItem('token', data.access_token);
                            this.token = localStorage.getItem('token');
                             $('#addNew').modal('hide');
                         })
             },
             logOut(){
            axios.defaults.headers.post['Authorization'] = `Bearer ${this.token}` // 
            console.log(axios.defaults.headers.post['Authorization']);
                axios.post('/api/logout')
                .then(data =>{
                    localStorage.removeItem('token')
                    this.token = null;
                })
             },
             registerUser(){

             },
             newModal(){
                this.edit = false;
                this.form.reset();
                $('#addNew').modal('show');
            }
        },
       
    }
</script>
