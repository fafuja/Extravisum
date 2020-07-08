
<?php 
	$__path = $_SERVER['DOCUMENT_ROOT'];
	$db_path =$__path."/inc/db.php";
	
	include_once($db_path);
?>
<?php session_start(); ?>

<?php
$checksession_path = $__path."/checksession.php";
//include "checksession.php";
include_once($checksession_path);
//Get the status and decode the JSON
$status = json_decode(file_get_contents('https://api.mcsrvstat.us/2/extravisum.com'));
?>
<!DOCTYPE html>
<html>
<head>
	<title>Extravisum</title>
	<meta name="description" content="MyServer is a revolutionary Minecraft server. You can join with the IP 'play.myserver.net'.">
	<meta name="keywords" content="MyServer, MyServer.com, Minecraft Server, Minecraft, Fun, Play, Portal, Website, Official">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://www.extravisum.com/dist/jquery.mb.YTPlayer.min.js"></script>
	<script src="https://www.extravisum.com/dist/jquery.mb.YTPlayer.js"></script>
	
    
	
	

	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://extravisum.com/css/stylesheet.css">
	<script src="https://use.fontawesome.com/30155533f0.js"></script>
	<script src="https://kit.fontawesome.com/2db7c2f8b5.js" crossorigin="anonymous"></script>
    
	<script type="text/javascript">
		function mobile() {
			var bars = document.getElementById("mnav");
			if(bars.className === "mnav") {
				bars.className += " responsive";
			} else {
				bars.className = "mnav";
			}
		}
	</script>
</head>
<script type="text/javascript">

        function onYouTubePlayerAPIReady() {
        if(ytp.YTAPIReady)
          return;
        ytp.YTAPIReady=true;
        jQuery(document).trigger("YTAPIReady");
      }

    jQuery(function(){
      	
      	setTimeout(function(){
            
            jQuery("#indexvideo").YTPlayer();	
            },0)
      });

    </script>
<body>

	<header>
	
	<div class="nav">
		<?php 
			$passinvalid = isset($_GET['invalidpass'])?$_GET['invalidpass']: "no";
			$userinvalid = isset($_GET['invaliduser'])?$_GET['invaliduser']: "no";
			if($passinvalid == "yes"){
				echo '<div style="text-align:center;max-width:100%;background-color:red;color:white;">Senha inválida.</div>';
			}
			if($userinvalid == "yes"){
				echo '<div style="text-align:center;max-width:100%;background-color:red;color:white;">Usuário inválido.</div>';
			}
		?>
		
			<div class="menu">
		<a href="#main"><div class="log"><img alt="Extravisum Logo" class="logo" src="https://extravisum.com/img/logo.png"></a><?php if(isset($_SESSION["user"])):?><div class="playercoin"><i class="fas fa-coins"></i> 0</div><? endif; ?></div>
			<ul class="nav-items" id="nav-items">
				<a><li onclick="mobile()" class="icon fa fa-bars fa-2x"></li></a>
				<a href="https://extravisum.com/"><li class="h">
					<div class="overlay"></div>
					<i class="fas fa-home"></i>
					<small>Início</small>
				</li></a>
				<a href="https://extravisum.com/news"><li class="h">
				
					<div class="overlay"></div>
					<i class="fas fa-newspaper"></i>
					<small>Notícias</small>
				</li></a>
				<a href="https://extravisum.com/forum"><li class="h">
					<div class="overlay"></div>
					<i class="far fa-comment-dots"></i>
					<small>Forum</small>
				</li></a>
				
				
				
				<a href="https://extravisum.com/loja"><li class="h">
					<div class="overlay"></div>
					<i class="fas fa-shopping-bag"></i>
					<small>Loja</small>
                </li></a>
				<?php 
				if(isset($_SESSION["user"])){
					$header_con = new ExtravisumDB();
					$header_user_id = $header_con->getUserId($_SESSION["user"]);
					$header_products = $header_con->getTotalProductsCheckout($header_user_id);
				}
				?>
				<?php if(isset($_SESSION["user"])):?>
				<a href="https://extravisum.com/checkout"><li class="h"><!--cart-->
					<div style="background-color:#ffcc00;" class="overlay"></div>
					<i style="color:#ffcc00;" class="fas fa-shopping-cart"></i>
					<small>(<?php echo count($header_products);?>) Meu carrinho</small>
				</li></a>
				<?php endif; ?>
				
                <?php if(!isset($_SESSION["user"])):?>
					<div id="profilelink">
					
					<a href="#"><li class="h">
						<div class="overlay">
						<div class="dropdown-content">
						<a onclick="document.getElementById('loginform').style.display='block'" href="#">Logar</a>
						<a onclick="document.getElementById('registerform').style.display='block'" href="#">Registrar-se</a>    
						</div>
						</div>
						<i><img style="max-width:30px;" src="https://i.pinimg.com/originals/85/78/bf/8578bfd439ef6ee41e103ae82b561986.png"/><!--<img src="https://crafatar.com/avatars/853c80ef3c3749fdaa49938b674adae6?size=30"/>--></i>
						<small>Olá!<i class="fas fa-chevron-down"></i></small>
					</li>
					</a>
					</div>
				<? else: ?>
					<div id="profilelink">
					<a href="#"><li class="h">
						<div class="overlay">
						<div class="dropdown-content">
						<a href="https://extravisum.com/user/<?echo $_SESSION['user']?>">Meu Perfil</a>
						<a href="https://extravisum.com/logout.php?site=<?php echo "https://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]."" ?>">Sair</a>    
					</div>
						</div>
						<?php $userid = json_decode(file_get_contents('https://playerdb.co/api/player/minecraft/'.$_SESSION["user"])); ?>
						<i><img src="https://crafatar.com/avatars/<?php echo $userid->data->player->id?>?size=30"/></i>
						<small>Olá <?php echo $_SESSION["user"]; ?>.<i class="fas fa-chevron-down"></i></small>
					</li>
					</a>
					</div>
				<?php endif; ?>
				

				
			</ul>
			
			<div class="mnav" id="mnav">
				<a href="https://extravisum.com/"><li class="i">
					Início
				</li></a>
				<a href="https://extravisum.com/forum"><li class="i">
					Forums
				</li></a>
				<a href="https://extravisum.com/news"><li class="i">
					Notícias
				</li></a>
				<a href="https://extravisum.com/loja"><li class="i">
					Loja
				</li></a>
			</div>
			</div>
			
		</div>

		


<div id="loginform" class="modal">


  <!-- Modal Content -->
  <form class="modal-content animate" action="">

  <span onclick="document.getElementById('loginform').style.display='none'"
class="close" title="Close Modal">&times;</span>

    <div class="container">  
</br>
      <label style="padding-bottom:-20px; margin-bottom:-20px;" for="uname"><b>Usuário</b></label></br>
      <input id="mineuserl" type="text" placeholder="Minecraft username" name="uname" required></br></br>

      <label for="psw"><b>Senha</b></label></br>
      <input id="senhauserl" type="password" placeholder="Sua senha" name="psw" required></br></br>

      <button type="submit"><i class="fas fa-sign-in-alt"></i></button></br></br>
      <label>
        <input id="checkbox" type="checkbox" checked="checked" name="remember"> Remember me
      </label>
    </div>
    </br>
    <div class="container" style="background-color:transparent">  
      <span style="background-color:#74D4F7;text-transform: uppercase;">Forgot <a style="color:#23272b;font-weight:bold;" href="#">password?</a></span>
    </div>
  </form>
</div>

<div id="registerform" class="modal">


  <!-- Modal Content -->
  <form class="modal-content animate" action="#">
  <span onclick="document.getElementById('registerform').style.display='none'"
class="close" title="Close Modal">&times;</span>
   

    <div class="container"></br>
      <label style="padding-bottom:-20px; margin-bottom:-20px;" for="uname"><b>Usuário</b></label></br>
      <small style="color:red">*NOME DA SUA CONTA MINECRAFT*</small>
      <div><input id="mineuser" type="text" placeholder="Minecraft username" name="uname" required><div id="nameerror" class="inputerror"></div></br></br>

      <label for="psw"><b>Email</b></label></br>
      <input id="emailuser" type="email" placeholder="exemplo@exemplo.com" name="psw" required></br></br>
	  
      <label for="psw"><b>Senha</b></label></br>
      <input id="senhauser" type="password" placeholder="Sua senha" name="psw" required></br></br>

      <button type="submit"><i class="fas fa-sign-in-alt"></i></button></br></br>
    </div>
    </br>
    <div class="container" style="background-color:transparent">  
	<div id="alerterror" class="inputerror"></div>
    <span id="loadinggif" style="display:none;"><img style="max-width:50px;" src="https://neotropical.pensoft.net/i/simple_loading.gif"/></span>
      <span id="alert" style="color:red;text-transform: uppercase;"></span>
    </div>
  </form>
</div>
    </div>
