<template>
    <div class="container">
        
          <div class="card-tools d-flex justify-content-start">
                    <a v-if="!$gate.getAuth()" @click="newModal" 
                      class="filter_search" data-toggle="modal" >Login / Register</a>
                   
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
                  <form >                  
                      <div class="modal-body">
                       <div class="form-group" v-if="register">
                            <input v-model="form.name" type="text" name="name" id="name" placeholder="name" 
                              class="form-control" :class="{'is-invalid': form.errors.has('name')}">
                              <has-error :form="form" field="name"></has-error>
                      </div> 
                         <div class="form-group">
                            <input v-model="form.email" type="text" name="email" id="email" placeholder="email" 
                              class="form-control" :class="{'is-invalid': form.errors.has('email')}">
                              <has-error :form="form" field="email"></has-error>
                        </div>         
                        <div class="form-group">
                            <input v-model="form.password" type="password" name="password" id="password"
                              class="form-control" placeholder="password" :class="{'is-invalid': form.errors.has('password')}">
                              <has-error :form="form" field="password"></has-error>
                        </div>
                         <div class="form-group" v-if="register">
                            <input v-model="form.password_confirmation" type="password" name="password_confirmation" id="password_confirmation"
                              class="form-control" placeholder="password_confirmation" :class="{'is-invalid': form.errors.has('password_confirmation')}">
                              <has-error :form="form" field="password_confirmation"></has-error>
                        </div>
                      </div>
                       </form>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-if="!register" @click='register = true' class="btn btn-primary">Register</button>
                        <button v-if="!register" @click="loginUser()" class="btn btn-primary">
                        Login</button>
                        <button v-else @click='registerUser()' class="btn btn-primary">Register</button>
                      </div>
                
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
                    email: '',                   
                    password: '',
                    password_confirmation: '',
                    name: ''                   
                }), 
               token: localStorage.getItem('token') || null,
               register: false
            }
        },
       
        methods: {
             loginUser(){

              this.form.post('/login')
                         .then(()=>{
                            window.location = "/home";
                             $('#addNew').modal('hide');
                         })

             },
            
             logOutApi(){
            axios.defaults.headers.post['Authorization'] = `Bearer ${this.token}` // 
            console.log(axios.defaults.headers.post['Authorization']);
                axios.post('/api/logout')
                .then(data =>{
                    localStorage.removeItem('token')
                    this.token = null;
                })
             },
             registerUser(){
                this.form.post('/register')
                         .then(()=>{
                            window.location = "/home";
                             $('#addNew').modal('hide');
                         })
             },
             newModal(){
                this.edit = false;
                this.form.reset();
                $('#addNew').modal('show');
            }
        },
       
    }
</script>
