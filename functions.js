function deleteCart (Ith,val) {                                                                       
                                                                      
    //alert(val);                    
    var xmlhttp = new XMLHttpRequest();                                                                   
    xmlhttp.open("GET", "deleteCart.php?d=" + val , true);                                                
    xmlhttp.send();                                                                                       
                                                                                                            
    window.location.replace('optionFrame.php');                                                          
                                                                                                            
}          

function addCart (Ith,val) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "html/optionFrame.php?c=" + val , true);
	//alert(Ith+","+val);
	xmlhttp.send();

	var oiframe = document.getElementById("oFrame");
	//alert(Ith+","+val);
	oiframe.contentWindow.location.reload(true);
}

function checkValidUser() {
	var flag = true;
	var nameRegex = /^[a-zA-Z\-]+$/;
	var idRegex = /^[A-Z]{2}[0-9]{5}$/;
	var emailRegex = /^[a-zA-Z0-9]+@umbc.edu$/;
	var errno = "User Input Error!\n";
	//Check input validation

	var fName = document.getElementById("fName").value;
	var lName = document.getElementById("lName").value;
	var email = document.getElementById("studentEmail").value;
	var cid  = document.getElementById("studentID").value;

	if ( (fName.length == 0)||(lName.length == 0)||(email.length == 0)||(cid.length == 0) ){
		alert("Input cannot be empty!\n Try again!");
		return;
	};


	if( !nameRegex.test(fName) )
	{
		flag = false;
		errno += "\t\"First name: "+fName+" is invalid!\"\n";
	}

	if( !nameRegex.test(lName) )
	{
		flag = false;
		errno += "\t\"Last name: "+lName+" is invalid!\"\n";
	}

	if( !emailRegex.test(email) )
	{
		flag = false;
		errno += "\t\"Student Email: "+email+" is invalid!\"\n";
	}

	if( !idRegex.test(cid) )
	{
		flag = false;
		errno += "\t\"Student ID: "+cid+" is invalid!\"\n";
	}

	if(!flag) {
		alert(errno);
		return;
	}
	else
	{
		//VALID USER
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", "signUp.php?i="+cid+"&f="+fName+"&l="+lName+"&e="+email , true);
		xmlhttp.send();
		//document.getElementById("userForm").submit();
		//     	alert("AJAX3!");
		window.location.replace('index.php');

	}

}

function logOut () {
	if (confirm("Log out?") ){
	    window.location.replace('index.php?logFlag=true');
	}
	else{
		return;
	}
}

function submitCart () {
	var flagSubmit = false;
	var uid = document.getElementById("userUID").value;
	//alert(uid);
	flagSubmit = confirm("Are you sure?");

	if (flagSubmit) {
		//document.getElementById("deleteHidden").innerHTML = ">>> PROCESSING SUBMIT >>><br>";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", "submitCart.php?flagCart=true&uid="+uid , true);
		xmlhttp.send();
		//alert(uid);
		window.location.replace('optionFrame.php');
		//alert(uid);
		window.location.reload();
	}else{
		return;
	}

	//window.top.location.reload();
}
