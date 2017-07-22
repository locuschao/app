EZ.localStorage = {
    isLocalStorage:localStorage && typeof JSON !== 'undefined'?true:false,
    dataDom:localStorage,
    initDom:function(){
        if(!this.dataDom){
            try{
                this.dataDom.expires = EZ.exDate.toUTCString();
            }catch(ex){
                return false;
            }
        }
        return true;
    },
    set:function(key,value){
        if(this.isLocalStorage){
            this.dataDom.setItem(key,value);
        }
    },
    get:function(key){
        if(this.isLocalStorage){
            return this.dataDom.getItem(key);
        }
    },
    remove:function(key){
        if(this.isLocalStorage){
            this.dataDom.removeItem(key);
        }
    },
    getJSON:function(key){
        if(this.isLocalStorage && this.get(key)){
            return JSON.parse(this.get(key));
        }
    },
    setJSON:function(key){
        if(this.isLocalStorage && this.get(key)){
            return stringify.parse(this.setItem(key));
        }
    }
}