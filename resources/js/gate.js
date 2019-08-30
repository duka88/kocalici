 export default class Gate{


      constructor(user){
        this.user = user;
    }
    
    getAuth(){
    	 return this.user;
    }

    getName(){
         return this.user.name;
    }

    isAdmin(){

      if(this.user){ 
        if(this.user.role === 'admin'){
            return true;
        }
         else{
             return false; 
        }}else{
             return false; 
        }
       
    }

    isUser(){
      if(this.user){ 
        if(this.user.role === 'writer'){
            return true;
        }
         else{
             return false; 
        }}else{
             return false; 
        }
    }

	idUser(){
		return this.user.id;
	}
}

