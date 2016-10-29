function checkForm(){
    var valida = true;
    
    if(document.getElementById('mySelect1').value == 0){
        document.getElementById('mySelect1-E').innerHTML = "Campo obligatorio";
        valida = false;
    }else{
        document.getElementById('mySelect1-E').innerHTML = "";
    }
    
    if(document.getElementById('tema').value == "" || document.getElementById('tema').value == "Ingrese el tema correspondiente a su archivo"){
        document.getElementById('tema-E').innerHTML = "Campo obligatorio";
        valida = false;
    }else{
        document.getElementById('tema-E').innerHTML = "";
    }
    
    
    if(document.getElementById('desc').value == "" || document.getElementById('desc').value == "Ingrese la descripicion del archivo que va a compartir."){
        document.getElementById('desc-E').innerHTML = "Campo obligatorio";
        valida = false;
    }else{
        document.getElementById('desc-E').innerHTML = "";
    }
    
    if(document.getElementById('mySelect2').value == 0){
        document.getElementById('mySelect2-E').innerHTML = "Campo obligatorio";
        valida = false;
    }else{
        document.getElementById('mySelect2-E').innerHTML = "";
    }
    /*
	// PREVIEW
    if(document.getElementById('my-input-file2').value == ""){
        document.getElementById('my-input-file2-E').innerHTML = "Campo obligatorio";
        valida = false;
    }else{
        document.getElementById('my-input-file2-E').innerHTML = "";
    }
    */
    if(document.getElementById('ftp_check').checked){
        document.getElementById('my-input-file-E').innerHTML = "";
        if(document.getElementById('ftp_file_selected').value == ''){
            document.getElementById('ftp_file_selected-E').innerHTML = "Campo obligatorio";
            valida = false;
        }else{
            document.getElementById('ftp_file_selected-E').innerHTML = "";
        }
    }else{
        document.getElementById('ftp_file_selected-E').innerHTML = "";
        if(document.getElementById('my-input-file').value == ""){
            document.getElementById('my-input-file-E').innerHTML = "Campo obligatorio";
            valida = false;
        }else{
            document.getElementById('my-input-file-E').innerHTML = "";
        }
    }
    
    
    
    return valida;
}

function cambiarTipoUpload(){
	if(document.getElementById('ftp_check').checked){
		document.getElementById('upload1').style.display = 'none'; 
		document.getElementById('seleccionar-archivo-ftp').style.display = 'block' ;
	}else{
		document.getElementById('upload1').style.display = 'block'; 
		document.getElementById('seleccionar-archivo-ftp').style.display = 'none' ;
	}
}

function mostrarFtp(){
	var w = window.screen.width;	
	var h = window.screen.height;
	var popW = 550, popH = 450;
	var leftPos = (w-popW)/2, topPos = (h-popH)/2;
	window.open('popup.php','popup','width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos+',scrollbars=yes');

}

/*
if you need to display the path to user, you need to write some JavaScript like these.
*/


 var FileUploadUI =  function(dUploadButtonEl){
     this.init.apply(this,arguments);
 }

 FileUploadUI.prototype = {
     
     init:function(dUploadButtonEl){

             var dEl = this.getEl(dUploadButtonEl);
             if( !dEl.type || dEl.type!='file' || !dEl.form ) return null;

             this._uploadButtonEl = dEl;
             this._uploadPathEl =   dEl.form.elements.namedItem(this.pathElementName);
             
             if( this._uploadPathEl ){
                 this._eventListeners = [];
                 this.addEvent(dEl,'change',this.syncFilePath);
                 this.addEvent(dBtn.form,'submit',this.destruct);
                 this.makeAccessible();
             }
     },
     
     pathElementName:'my-input-file-path',
     
     
     getEl:function(el){
           if( typeof(el) === 'string') el = document.getElementById(el);
           return el;
     },
     
     //simple addEvent, buggy and better replace it with your own Event Library
     addEvent:function(el,type,fn){
            
            el = this.getEl(el);
            
            var sOn = el.attachEvent ? 'on' : '';
            var oThis = this ;

            //let scope always be this (FileUploadUI)
            var wfn =  function(e){
                fn.call(oThis  ,e || window.event , el );
            };
            this._eventListeners.push( [el,type,wfn ]   );
            
            if(sOn){
               el.attachEvent( sOn + type , wfn  );
            }else if(el.addEventListener){
               el.addEventListener(type , wfn , false);
            };
            
            return wfn;
      },

      removeEvent:function(el,type,wfn){
            el = this.getEl(el);
            
            var sOn = el.attachEvent ? 'on' : '';           
            if(sOn){
               el.dettachEvent( sOn + type , wfn  );
            }else if(el.addEventListener){
               el.removeEventListener(type , wfn , false);
            };
      },

    //you need to sync the value when user select a new file path;
    syncFilePath:function(){
         var dPath = this._uploadPathEl;
         var dBtn =  this._uploadButtonEl;   
         dPath.value = dBtn.value.split('/').pop().split('\\').pop();
         if(  typeof(this.onChange) === 'function' ){
              this.onChange.call( this, dPath.value );
         }
    },

    onChange:function(){
    },

    makeAccessible:function(){
            var dPath = this._uploadPathEl;
            var dBtn =  this._uploadButtonEl;     
            dPath.tabIndex = -1;
            this.addEvent( dPath ,'focus' , this._onPathFocus );
            this.addEvent( dBtn  ,'focus' , this._onBtnFocus );
            this.addEvent( dBtn  ,'blur' , this._onBtnBlur );
            this.addEvent( dBtn ,'keydown' , this._onBtnKeyDown );
            this.makeAccessible = function(){};
    },

    _onPathFocus:function(){
            var dBtn =  this._uploadButtonEl;
            dBtn.focus();
            return false;
    },

    _onBtnFocus:function(){
            var dPath = this._uploadPathEl;
                dPath.style.backgroundColor = '#ccc';
           
    },

    _onBtnKeyDown:function(e){
        
        if(e.keyCode != 13) return ;
        var dBtn =  this._uploadButtonEl;
        if( dBtn.click ) dBtn.click();
    },

    _onBtnBlur:function(e){
        var dPath = this._uploadPathEl;
        dPath.style.backgroundColor = '#ccc';
    },

    destruct : function (){
          var dPath = this._uploadPathEl;
          var dBtn =  this._uploadButtonEl;
              dPath.disabled = true ;
              dBtn.style.display = 'none';//focus-not-allowed

          for( var i,arg;arg=this._eventListeners[i];i++){
               this.removeEvent.call(this,arg);  
          }
          this._eventListeners = null;
          
    }      
}    



//instantiate all UI
var aUploadFileBtns = document.getElementsByName('my-input-file');
for(var i=0,dBtn;dBtn = aUploadFileBtns[i];i++){
    new FileUploadUI(dBtn);
};
        
     

/*
if you need to display the path to user, you need to write some JavaScript like these.
*/


 var FileUploadUI =  function(dUploadButtonEl){
     this.init.apply(this,arguments);
 }

 FileUploadUI.prototype = {
     
     init:function(dUploadButtonEl){

             var dEl = this.getEl(dUploadButtonEl);
             if( !dEl.type || dEl.type!='file' || !dEl.form ) return null;

             this._uploadButtonEl = dEl;
             this._uploadPathEl =   dEl.form.elements.namedItem(this.pathElementName);
             
             if( this._uploadPathEl ){
                 this._eventListeners = [];
                 this.addEvent(dEl,'change',this.syncFilePath);
                 this.addEvent(dBtn.form,'submit',this.destruct);
                 this.makeAccessible();
             }
     },
     
     pathElementName:'my-input-file-path2',

     
     
     getEl:function(el){
           if( typeof(el) === 'string') el = document.getElementById(el);
           return el;
     },
     
     //simple addEvent, buggy and better replace it with your own Event Library
     addEvent:function(el,type,fn){
            
            el = this.getEl(el);
            
            var sOn = el.attachEvent ? 'on' : '';
            var oThis = this ;

            //let scope always be this (FileUploadUI)
            var wfn =  function(e){
                fn.call(oThis  ,e || window.event , el );
            };
            this._eventListeners.push( [el,type,wfn ]   );
            
            if(sOn){
               el.attachEvent( sOn + type , wfn  );
            }else if(el.addEventListener){
               el.addEventListener(type , wfn , false);
            };
            
            return wfn;
      },

      removeEvent:function(el,type,wfn){
            el = this.getEl(el);
            
            var sOn = el.attachEvent ? 'on' : '';           
            if(sOn){
               el.dettachEvent( sOn + type , wfn  );
            }else if(el.addEventListener){
               el.removeEventListener(type , wfn , false);
            };
      },

    //you need to sync the value when user select a new file path;
    syncFilePath:function(){
         var dPath = this._uploadPathEl;
         var dBtn =  this._uploadButtonEl;   
         dPath.value = dBtn.value.split('/').pop().split('\\').pop();
         if(  typeof(this.onChange) === 'function' ){
              this.onChange.call( this, dPath.value );
         }
    },

    onChange:function(){
    },

    makeAccessible:function(){
            var dPath = this._uploadPathEl;
            var dBtn =  this._uploadButtonEl;     
            dPath.tabIndex = -1;
            this.addEvent( dPath ,'focus' , this._onPathFocus );
            this.addEvent( dBtn  ,'focus' , this._onBtnFocus );
            this.addEvent( dBtn  ,'blur' , this._onBtnBlur );
            this.addEvent( dBtn ,'keydown' , this._onBtnKeyDown );
            this.makeAccessible = function(){};
    },

    _onPathFocus:function(){
            var dBtn =  this._uploadButtonEl;
            dBtn.focus();
            return false;
    },

    _onBtnFocus:function(){
            var dPath = this._uploadPathEl;
                dPath.style.backgroundColor = '#ccc';
           
    },

    _onBtnKeyDown:function(e){
        
        if(e.keyCode != 13) return ;
        var dBtn =  this._uploadButtonEl;
        if( dBtn.click ) dBtn.click();
    },

    _onBtnBlur:function(e){
        var dPath = this._uploadPathEl;
        dPath.style.backgroundColor = '#ccc';
    },

    destruct : function (){
          var dPath = this._uploadPathEl;
          var dBtn =  this._uploadButtonEl;
              dPath.disabled = true ;
              dBtn.style.display = 'none';//focus-not-allowed

          for( var i,arg;arg=this._eventListeners[i];i++){
               this.removeEvent.call(this,arg);  
          }
          this._eventListeners = null;
          
    }      
}    



//instantiate all UI
var aUploadFileBtns = document.getElementsByName('my-input-file2');
for(var i=0,dBtn;dBtn = aUploadFileBtns[i];i++){
    new FileUploadUI(dBtn);
};
        
     

