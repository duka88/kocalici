 export default class Gate{


      constructor(user){
        this.user = user;
    }
    
    getAuth(){
    	 return this.user;
    }

    isAdmin(){
        return this.user.role === 'admin';
    }

    isUser(){
        return this.user.role === 'writer';
    }

	idUser(){
		return this.user.id;
	}
}

