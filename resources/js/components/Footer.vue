<template>
    <div>
     <div class="container py-3">
        <div class="row">

            <div class="col-lg-4 col-md-12 d-flex justify-content-center">
             <div class="row justify-content-center w-75">              
                <h3 class="my-3 text-center font-weight-bold">Folow us</h3>
                <p class="text-center">Keep up to date on the latest news and share with us how you use your BusyB products.</p>
                <p class="d-flex">
                    <a class="social" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="social" href=""><i class="fab fa-twitter"></i></a>
                    <a class="social" href=""><i class="fab fa-instagram"></i></a>
                    <a class="social" href=""><i class="fab fa-pinterest-p"></i></a>
                </p>
              </div>    
            </div>

            <div class="col-lg-4 col-md-12 d-flex justify-content-center">
             <div class="row justify-content-center w-75 ">             
                <h3 class="my-3 text-center font-weight-bold">Sing up for Newsletter</h3>
                <p class="text-center">For latest updates on great new BusyB products competitions & offers, sign up for our newsletter.</p>
                  <form @submit.prevent="newsletterSend" class="d-flex justify-content-center newsletter">                  
                      <input v-model="formNewsletter.newsletter" type="email" name="user_email" placeholder="email" >
                    
                   
                    <button type="submit" class="news-button">Submit</button>
                </form>
              </div>    
            </div>

            <div class="col-lg-4 col-md-12 d-flex justify-content-center">
             <div class="row justify-content-center w-75 flex-column">              
                <h3 class="my-3 text-center font-weight-bold">Contact US</h3>               
                  <form @submit.prevent="contactFormSend" class="d-flex justify-content-center flex-column contact" >                     

                      <input v-model='formContact.email' type="email" name="email" placeholder="email" :class="{'is-invalid': formContact.errors.has('email')}">
                       <has-error :form="formContact" field="email"></has-error>

                      <textarea cols="30" rows="5" v-model='formContact.massege' type="text" name="massege" placeholder="massege" :class="{'is-invalid': formContact.errors.has('massege')}"></textarea>
                       <has-error :form="formContact" field="massege"></has-error>
                    
                   
                    <button type="submit" class="news-button">Submit</button>
                </form>
              </div>    
            </div>

        </div>
     </div>
     <div class="container-fluid px-4 py-2 ">
        <div class="col-lg-8 offset-lg-2 d-flex justify-content-center">
            <p class="text-center p-0 m-0 " style="color: #355D60;">site created by <a class="groovy" href="">groovy</a></p>
        </div>
     </div>
    </div> 
</template>

<script>
    export default {
        data(){
           return{
             formNewsletter: new Form({
               newsletter: ''
               }),
             formContact: new Form({
               massege: '',
               email: ''
               })
           }     
        },
        methods:{
           newsletterSend(){
              this.formNewsletter.post('/newslleter')
                   .then(({data})=>{
                     if(data == 'Already Subscribed'){
                           console.log(data)
                            toast.fire({
                            type: 'info',
                            title: data
                        })}else{
                         console.log(data)
                              toast.fire({
                              type: 'success',
                              title: data                        
                        })
                      }
                 })
            },
         contactFormSend(){
            this.formContact.post('/contact_us')
                     .then(({data})=>{                  
                     
                        toast.fire({
                            type: 'success',
                            title: 'Message sent successfully'
                        })
                        this.formContact.reset();
                     })
                     .catch((error) => {
                               if (error.response) {
                              toast.fire({
                              type: 'error',
                              title: error.response.data.message
                            })               
                           } 
                        } );
         }  
      }
    }
</script>
