<template>
    <div class="container">
        
          <div class="card-tools">
                    <button v-if="!user_id" @click="newModal" class="btn btn-success" data-toggle="modal" >Login</button>
                   
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
                            <input v-model="form.email" type="text" name="email" id="email" placeholder="email" 
                              class="form-control" :class="{'is-invalid': form.errors.has('email')}">
                              <has-error :form="form" field="email"></has-error>
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
                    email: '',                   
                    password: ''                   
                }), 
               token: localStorage.getItem('token') || null,
               register: false
            }
        },
        props: ['user_id'],
        methods: {
             loginUser(){
              this.form.post('/login')
                         .then(({data})=>{
                            window.location.replace("/home");
                             $('#addNew').modal('hide');
                         })
             },
             logOut(){
                 axios.post('/logout')
                       .then(()=>{
                      
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

             },
             newModal(){
                this.edit = false;
                this.form.reset();
                $('#addNew').modal('show');
            }
        },
       
    }
</script>
