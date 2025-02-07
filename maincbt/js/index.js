
function currentConnection(){ // always check this
	
	return appState("p");
	
}

function appState(switchState){
	
	const opt = switchState;
	
	let allowed ;
	
	let urlPlay ;
	
	allowed = ["l","p"];
	
	if(allowed.includes(opt)){
		
		if(opt == "p"){
			
			urlPlay = "cbt.xelowgc.com";
			
		}

		if(opt == "l"){
			
			urlPlay = "localhost/fromhp/cbt/cbt/maincbt";
			
		}
		
		return urlPlay;
		
	}
	
}


function readClicks(readClick , paneLoader){

	$(readClick).click(function(){
	
		$(paneLoader).toggle(300);
		
	});
}

function closeClicks(readClick , paneLoader){

	$(readClick).click(function(){
	
		$(paneLoader).hide(300);
		
	});
}

function showalert(msg){
	Toastify({
	  text: msg,
	  duration: 3000,
	  //destination: "https://github.com/apvarun/toastify-js",
	  newWindow: true,
	  close: true,
	  gravity: "top", // `top` or `bottom`
	  position: "center", // `left`, `center` or `right`
	  stopOnFocus: true, // Prevents dismissing of toast on hover
	  style: {
		//background: "linear-gradient(to right, #00b09b, #96c93d)",
		background: "white",
		color:"green",
	  },
	  onClick: function(){} // Callback after click
	}).showToast();
}

function cloader(page,pageid){
	$(pageid).show(300);
	//topFunction();
		$.ajax({
			type	: 'GET',
			url		: page,
			success	: function(data) {
				try {
					$(pageid).html(data);
					
				} catch (err) {
					alert(err);
				}
			}
		});
}

function topFunction() {
	  document.body.scrollTop = 0; // For Safari
	  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

 function formProcessor(formid,resultid,cmdvalue,hasher){
	 
	  $(formid).submit(function(e){
			e.preventDefault();
			let cmd = cmdvalue;
			let urlMan = currentConnection();
			$(resultid).html("<center><img src='img/ajax-loader.gif' style='width:20px;margin:20px;'/></center>");
			$.ajax({
				crossOrigin: true,
				method:"POST",
				url:"https://"+urlMan+"/appController?hasher="+hasher+"&cmd="+cmd,
				data:new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success:function(response){
				
					if(cmd == "pw-transfer"){
						
						$(resultid).html(response);
						
					}
			
				},
				
				error:function(){}
			});
		});
    }
	
 function contentViewer(result,cmd,hasher){

		let urlMan = currentConnection();
		
		const allowlist = ["convert_crypto_usdbuys"];
		
		if(allowlist.includes(cmd)){}
		else{
			$(result).html("<center><img src='img/ajax-loader.gif' style='width:20px;margin:20px;'/></center>");
		}
		
		$.ajax({
				crossOrigin: true,
				url:"https://"+urlMan+"/appController?hasher="+hasher+"&cmd="+cmd,
				method:"GET",
				success:function(response){
					
					$(result).html(response);
					
				},
				error:function(){}
			});
	}
	

function x_getValues(str , index){
	
	if(str != null){
		
		const parts = str.split("---");
	
		let response;

		if(parts.length > 0 && index >= 0){
			
			response = parts[index];
			
		}else{
			
			response = "invalid";
			
		}
		
		return response;
	}
	
}

function x_getNamex(str , index){
	
	if(str != null){
		
		const parts = str.split(" ");
	
		let response;

		if(parts.length > 0 && index >= 0){
			
			response = parts[index];
			
		}else{
			
			response = "invalid";
			
		}
		
		return response;
	}
	
}

function logoutApp(){
	
	if((getSession("user-id-yungopay") != undefined) && (getSession("user-token-yungopay") != undefined)){
		
		removeSession("user-id-yungopay");
		
		removeSession("user-token-yungopay");
		
		removeSession("user-name-yungopay");
		
		removeSession("user-email-yungopay");

		showalert("You are logged out!");
		
		window.location = "registerApp.html";
		
	}
	
}


function setSession(key, value) { // Set session data

    localStorage.setItem(key, value);
	
}


function getSession(key) { // Get session data

    return localStorage.getItem(key);
	
}


function removeSession(key) { // Remove session data

    localStorage.removeItem(key);
	
}


function checkuserlogin(){ // checking if user is logged on
	
	if((getSession("user-id-yungopay") == undefined) && (getSession("user-token-yungopay") == undefined)){
		
		//cloader("appLogin",".c-fluid"); // load loginpage if session expired
		
		showalert("Inactive session! Please login");
		
		window.location = "registerApp.html";
		
	}
}


function checkifSessionActive(){ // If session action active
	
	if((getSession("user-id-yungopay") == undefined) && (getSession("user-token-yungopay") == undefined)){

	}else{
		
		window.location = "dashboard.html";
		
	}
}

