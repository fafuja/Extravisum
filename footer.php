<script>
// Get the modal
var login = document.getElementById('loginform');
var register = document.getElementById('registerform');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == login) {
    login.style.display = "none";
  }
  if(event.target == register){
	register.style.display = "none";
  }
}
</script>

<script src="https://extravisum.com/js/formhandler.js" type="text/javascript"></script>

<footer>
<div style="height:50px;max-width:1500px;margin:0 auto;">
		<img style="float:left" alt="Extravisum Logo" src="https://extravisum.com/img/logo.png">
		<p style="float:right" >Copyright &copy; Extravisum 2020</p>
		</div>
	</footer>


	<!--<script src="https://code.jquery.com/jquery-1.11.2.min.js" type="text/javascript"></script>-->
	<script src="https://extravisum.com/js/main.js" type="text/javascript"></script>
</body>
</html>