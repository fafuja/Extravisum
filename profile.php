<?php ob_start(); // needs to be added here
 session_start(); ?>

<?php 
    /*$initial_user = isset($_SESSION["user"])?$_SESSION["user"]:"";
    if($initial_user != ""){

    }else{
        header('Location: https://extravisum.com/');
    }*/
?>
<? include "header.php" ?>

</br>
</br>
</br>
<div class="hero" id="main">
<div class="checkout">
<div class="content">
<div style="padding:0px;" class="main">
<?php 
    if(isset($_GET['u'])){
        $str = $_GET['u'];
        $res = explode("/", $str);
        //$fitem = count($res);

        //$finalitem = $res[$fitem-1];
        $_user_ = str_replace('.php', '', $res[0]);
        $page = $res[1];

        $page = str_replace('.php', '', $page);
        //echo($page." ".$_user_);      
        $db = new ExtravisumDB();
        $isregistered = $db->checkUser($_user_);  
        
        if($isregistered){
            $player = json_decode(file_get_contents('https://playerdb.co/api/player/minecraft/'.$_user_));
            if($page == ""){
                if($_user_ == $_SESSION['user']){
                    //$player =  $player->data->player->id;
                    echo '<p style="margin-top:0px;margin-bottom:0px;"  class="an-t">
                    <b style="font-size:40px;float:left;">'.$_user_.'<small style="font-size:15px;"> / Home</small></b><a href="https://minecraft.extravisum.com/logout.php"><i style="background:rgba(244, 65, 65, .9);float:right;border-radius:10px;padding:10px;" class="fas fa-sign-out-alt"></i></a></br></p>
                    <div style="/*background-color:#57a0ba;*/width:20%;border-right:0px solid #57a0ba;" class="left-content">
                    <img  style="clear:bottom;max-width:100px;opacity:1;padding:10px;" src="https://crafatar.com/renders/body/'.$player->data->player->id.'?overlay=true">
                    <div class="vertical-menu">
                    <a href="https://extravisum.com/user/'.$_user_.'" class="active">Home</a>
                    <a href="https://extravisum.com/user/'.$_user_.'/settings">Configurações</a>
                    <a href="https://extravisum.com/user/'.$_user_.'/products">Meus Produtos</a>
                    </div>
                    </div>
                    <div style="width:80%;" class="left-content">
                    </div>
                    ';
                }else{
                    //$player =  $player->data->player->id;
                    echo '<p style="margin-top:0px;margin-bottom:0px;"  class="an-t">
                    <b style="font-size:40px;float:left;">'.$_user_.'<small style="font-size:15px;"> / Home</small></b><a href="https://minecraft.extravisum.com/logout.php"><i style="background:rgba(244, 65, 65, .9);float:right;border-radius:10px;padding:10px;" class="fas fa-sign-out-alt"></i></a></br></p>
                    <div style="/*background-color:#57a0ba;*/ width:20%;border-right:0px solid #57a0ba;" class="left-content">
                    <img  style="clear:bottom;max-width:100px;opacity:1;padding:10px;" src="https://crafatar.com/renders/body/'.$player->data->player->id.'?overlay=true">
                    <div class="vertical-menu">
                    <a href="https://extravisum.com/user/'.$_user_.'" class="active">Home</a>
                    </div>
                    </div>
                    <div style="width:80%;" class="left-content">
                    </div>
                    ';
                }
            }else{
                
                if($page == "settings"){
                    if($_user_ == $_SESSION['user']){
                        echo '<p style="margin-top:0px;margin-bottom:0px;"  class="an-t">
                        <b style="font-size:40px;float:left;">'.$_user_.'<small style="font-size:15px;"> / Configurações da conta</small></b><a href="https://minecraft.extravisum.com/logout.php"><i style="background:rgba(244, 65, 65, .9);float:right;border-radius:10px;padding:10px;" class="fas fa-sign-out-alt"></i></a></br></p>
                        <div style="/*background-color:#57a0ba;*/width:20%;border-right:0px solid #57a0ba;" class="left-content">
                        <img  style="clear:bottom;max-width:100px;opacity:1;padding:10px;" src="https://crafatar.com/renders/body/'.$player->data->player->id.'?overlay=true">
                        <div class="vertical-menu">
                        <a href="https://extravisum.com/user/'.$_user_.'">Home</a>
                        <a href="https://extravisum.com/user/'.$_user_.'/settings" class="active">Configurações</a>
                        <a href="https://extravisum.com/user/'.$_user_.'/products">Meus Produtos</a>
                        </div>
                        </div>
                        <div style="width:80%;" class="left-content">
                        
                        <form method="get" action="https://extravisum.com/profile/editemail">
                        <div style=" text-align:left;" class="finalcontent"><h2 style=" text-align:left;">Email</h2><input type="email" placeholder="'.$db->getEmail($_SESSION["user"]).'" name="editemail" id="editemail" required></br></br><button style="margin:0px;">Editar Email</button></div>
                        </form>

                        </div>
                        ';
                    }else{
                        header("Location: https://extravisum.com/user/".$_user_);
                    }
                }
                if($page == "products"){
                    if($_user_ == $_SESSION['user']){

                        $user_id = $db->getUserId($_SESSION["user"]);
                        $products = $db->getProductsShip($user_id);
                        
                        echo '<p style="margin-top:0px;margin-bottom:0px;"  class="an-t">
                        <b style="font-size:40px;float:left;">'.$_user_.'<small style="font-size:15px;"> / Meus Produtos</small></b><a href="https://minecraft.extravisum.com/logout.php"><i style="background:rgba(244, 65, 65, .9);float:right;border-radius:10px;padding:10px;" class="fas fa-sign-out-alt"></i></a></br></p>
                        <div style="/*background-color:#57a0ba;*/width:20%;border-right:0px solid #57a0ba;" class="left-content">
                        <img  style="clear:bottom;max-width:100px;opacity:1;padding:10px;" src="https://crafatar.com/renders/body/'.$player->data->player->id.'?overlay=true">
                        <div class="vertical-menu">
                        <a href="https://extravisum.com/user/'.$_user_.'">Home</a>
                        <a href="https://extravisum.com/user/'.$_user_.'/settings">Configurações</a>
                        <a href="https://extravisum.com/user/'.$_user_.'/products" class="active">Meus Produtos</a>
                        </div>
                        </div>
                        <div style="width:80%" class="left-content">';
                        if(count($products)>0){
                            for ($i=0; $i < count($products); $i++) { 
                                if($products[$i]["status"] == "PENDENTE"){
                                    $_code = '/ <a target="_blank" href="https://pagseguro.uol.com.br/v2/checkout/payment.html?code='.$products[$i]["code"].'"><i class="fas fa-shopping-cart"> <span id="checkouttext">Pagar Agora</span></i></a>';
                                }else{
                                    $_code = '';
                                }
                                $productinfo = $db->getProductInfo($products[$i]["product"]);
                                echo '
                                
                                <div style="width:100%;margin: 0 auto;"><span style="float:left;margin-bottom:5px;"><i class="fas fa-clock"></i> Última atualização: '.explode(".",str_replace("T"," ",$products[$i]["updatedate"]))[0].'</span></div>
                                <div style="width:100%;font-size:12px;" class="checkoutitem">
                                
                                <h3 style="float:none;"><i alt="Nome do produto" class="fas fa-asterisk"> <span id="checkouttext">'.$productinfo["name"].'</span></i> / <i alt="Status da compra" class="far fa-question-circle"> <span id="checkouttext">'.$products[$i]["status"].'</span></i> / <i alt="Codigo de referencia da compra" class="far fa-file-alt"> <span id="checkouttext">'.$products[$i]["ref"].'</span></i> / <i alt="Quanto custou" class="fas fa-dollar-sign"> <span id="checkouttext">R$'.$products[$i]["price"].'</span></i> / <i alt="Quantidade comprada" class="fas fa-search-plus"> <span id="checkouttext">'.$products[$i]["quantity"].'</span></i> '.$_code.'</h3>
                                
                                </div>
                                </br>
                                ';
                            }
                        }else{
                            echo "<center><h3>Nenhum produto encontrado.</h3></center>";
                        }
                        echo "</div>";
                    }else{
                        header("Location: https://extravisum.com/user/".$_user_);
                    }
                }
                
            }
            
            
        }else{
            echo '<h1>Usuario não encontrado.</h1>';
        }
    }else{
        header("Location: https://extravisum.com/");
    }
?>

</div>
</div>
</div>

    </header>

<? include "footer.php"?>

