var nameerror = false;
var alerterror = false;
$(document).ready(function(){
  $("#registerform").submit(function(event){
	$("#nameerror").empty();
	$("#alerterror").empty();
    event.preventDefault();
	$("#loadinggif").css("display", "block");

	var user = $("#mineuser").val();
	var pass = $("#senhauser").val();
	var email = $("#emailuser").val();
	$.getJSON("https://extravisum.com/check.php?user="+user+"&pass="+pass+"&email="+email, function(result){
		if(result.id != "nouserfound"){
			if(nameerror == true || alerterror == true){
				$("#nameerror").css("display", "none");
				$("#alerterror").css("display", "none");
			}
			
			$("#loadinggif").css("display", "none");

			if(result.id == "invaliduser"){
				nameerror = true;
				$("#nameerror").css("display", "block");
				$("#nameerror").append("<small>Usuário já cadastrado!</small>");
				$("#loadinggif").css("display", "none");
			}
			if(result.id == "ipused"){
				alerterror = true;
				$("#alerterror").css("display", "block");
				$("#alerterror").append("<small>Você já se cadastrou no server!</small>");
				$("#loadinggif").css("display", "none");
			}
			if(result.id == "registered"){
				window.location.replace("https://extravisum.com/login.php?user="+user+"&pass="+pass);
			}
			

		}else{
			nameerror = true;
			$("#nameerror").css("display", "block");
			$("#nameerror").append("<small>Conta Minecraft não encontrada!</small>");
			$("#loadinggif").css("display", "none");
		}
	});
    
  });
});
$(document).ready(function(){
  $("#loginform").submit(function(event){
    event.preventDefault();
	$("#loadinggif").css("display", "block");

	var user = $("#mineuserl").val();
	var pass = $("#senhauserl").val();
	var remembered = "yes";
	if($("#checkbox").is(":checked") == true){
		remembered = "yes";
	}else{
		if($("#checkbox").is(":checked") == false){
			remembered = "no";
		}
	}
	
	window.location.replace("https://extravisum.com/login.php?user="+user+"&pass="+pass+"&remember="+remembered);
    
  });
});

