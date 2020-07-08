<?php
ob_start(); // needs to be added here
date_default_timezone_set("America/Sao_Paulo");
$_time = str_replace("%","T",date("Y-m-d%H:i:s.uZ",time()));
session_start();
?>
<?php include "../header.php"; ?>
<div class="hero" id="main">
<div class="checkout">
<div class="content">
<div class="main">
<?php

//$products_id = isset($_GET['products'])?$_GET['products']:"";

//$products_id = explode("+", $products_id);

//echo $products_id[0]."</br>";

//print_r($products_id);

    require_once "../inc/db.php";
    include "../inc/refgenerator.php";
    include "../inc/credentials.php";
    

    if(isset($_SESSION["user"])){

        

        if(strpos($_SESSION['email'], '@') === false){
            echo "<h2>OOPS!</h2></br>";
            echo "<h3>Para completar sua compra é preciso você ter um email registrado na sua conta. Registre <a style='color:red;' href='https://extravisum.com/user/".$_SESSION['user']."/settings'>aqui</a>.</h3>";
        }else{
            $db = new ExtravisumDB();
            $user_id = $db->getUserId($_SESSION["user"]);
            $products = $db->getProductsCheckout($user_id);
            $totalprice = 0;
            
            if(count($products)>0){
                echo "<h2>Pagamento</h2>";
                
                echo "</br>";
                // ---------------
                $generator = new RandomStringGenerator;
                $tokenLength = 12;
                
                $token = $generator->generate($tokenLength);
                
                $token = "REF".$token;

                $credentials = new Credentials();
                $site_email = $credentials->email;
                $site_token = $credentials->token;

                $ch = curl_init();

                //curl_setopt($ch, CURLOPT_URL,"https://ws.pagseguro.uol.com.br/v2/sessions");
                curl_setopt($ch, CURLOPT_URL,"https://ws.pagseguro.uol.com.br/v2/checkout?email=".$site_email."&token=".$site_token);
                
                curl_setopt($ch, CURLOPT_POST, 1);
                

                $pay_info = "currency=BRL";

                for ($i=0; $i < count($products); $i++) { 

                    $productinfo = $db->getProductInfo($products[$i]["product"]);
                    
                    $addshopinfo = $db->addShoppingInfo($token, $user_id, $productinfo["id"], floatval($productinfo["price"]*count($db->getProductTotalCheckout($user_id, $productinfo["id"]))), count($db->getProductTotalCheckout($user_id, $productinfo["id"])), "PENDENTE", $_time, $_time);
                    $id_p = $i+1;
                    //echo money_format('%.2n', floatval($productinfo["price"]))."</br>";
                    $pay_info .= "&itemId".$id_p."=".$productinfo["id"]."&itemDescription".$id_p."=".$productinfo["name"]."&itemAmount".$id_p."=".money_format('%.2n', floatval($productinfo["price"]))."&itemQuantity".$id_p."=".count($db->getProductTotalCheckout($user_id, $productinfo["id"]));
                    $totalprice += floatval($productinfo["price"]*count($db->getProductTotalCheckout($user_id, $productinfo["id"])));
                }
                $db->deleteCheckoutProducts($_SESSION['user']);
                $pay_info.="&shippingAddressRequired=false&reference=".$token."&senderEmail=".$_SESSION['email']."&notificationURL=https://extravisum.com/checkout/update.php&redirectURL=https://extravisum.com/".$_SESSION['user']."/products";

                curl_setopt($ch, CURLOPT_POSTFIELDS,$pay_info);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                //echo $pay_info."</br>";
                curl_close ($ch);

                $server_output = new SimpleXMLElement($server_output);

                for ($i=0; $i < count($products); $i++) { 
                    $db->updateShipCode($token, $server_output->code);
                }
            
                //echo $server_output->code."</br>";
                
                echo '<div style="text-align:center;" class="finalcontent"><a target="_blank" href="https://pagseguro.uol.com.br/v2/checkout/payment.html?code='.$server_output->code.'"><button style="margin-top:7px;">Pagar Agora  <i class="fas fa-shopping-bag"></i></button></a></div></br></br>';
                echo '<center><img id="pagimage" src="//assets.pagseguro.com.br/ps-integration-assets/banners/pagamento/todos_estatico_550_100.gif" alt="Logotipos de meios de pagamento do PagSeguro" title="Este site aceita pagamentos com as principais bandeiras e bancos, saldo em conta PagSeguro e boleto."></center>';
                //echo "<a target='_blank' href='https://pagseguro.uol.com.br/v2/checkout/payment.html?code=".$server_output->code."'>aasdasd</a>";
                //echo "<a target='_blank' href='https://ws.pagseguro.uol.com.br/v2/transactions/".$server_output->code."?email=".$site_email."&token=".$site_token."'>aasdasd</a>";
                
                //echo "</br><a target='_blank' href='https://ws.pagseguro.uol.com.br/v2/transactions?email=".$site_email."&token=".$site_token."&reference=".$token."'>aasdasd</a>";
                echo "<h3>Veja o progresso da sua compra <a target='_blank' style='color:red;' href='https://extravisum.com/user/".$_SESSION['user']."/products'>aqui</a>.</h3>";

            }else{
                
                header('Location: https://extravisum.com/checkout');
            }
        }

    }else{
        
        header('Location: https://extravisum.com/checkout');
    }
?>
</div>
<div style="margin-top:0px;" class="main">

<div style="margin: 0px;" id="description">
			<div>
            <i style="color:white;" class="fa fa-credit-card fa-4x"></i>
				<span>
					<h3 style="color:white;">CARTÃO DE CRÉDITO</h3>
					<p style="color:white;">Pague com cartão o seu cartão de crédito em até 12x.</p>
				</span>
			</div>
			<div>
				<i style="color:white;" class="fa fa-money-check fa-4x"></i>
				<span>
					<h3 style="color:white;">BOLETO BANCÁRIO</h3>
					<p style="color:white;">Juntou dinheiro e não tem cartão de crédito disponível? Sem problemas, pague com boleto bancário!</p>
				</span>
			</div>
			<div>
				<i style="color:white;" class="fa fa-lock fa-4x"></i>
				<span>
					<h3 style="color:white;">100% SEGURO</h3>
					<p style="color:white;">Todo o processo da compra é feito pelo PagSeguro.</p>
				</span>
			</div>
		</div>

</div>
</div>
</div>
</header>
<div class="infopag">
<div  class="main">
		
	</div>
    </div>
<?php include "../footer.php" ?>
