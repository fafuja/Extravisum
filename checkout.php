<?php session_start(); ?>
<?php 

    include "./inc/db.php";
    $initial_user = isset($_SESSION["user"])?$_SESSION["user"]:"";
    
    if($initial_user != ""){
        $productid = isset($_POST['productid'])?$_POST['productid']:"";
        $delproducts = isset($_GET['delproducts'])?$_GET['delproducts']:"";
        $addproduct = isset($_GET['addproduct'])?$_GET['addproduct']:"";
        $removeproduct = isset($_GET['removeproduct'])?$_GET['removeproduct']:"";

        $conn = new ExtravisumDB();
        if($productid == ""){

            if($delproducts != ""){
                $conn->deleteSpecifiedProducts($initial_user, $delproducts);
                header('Location: https://extravisum.com/checkout');
            }else{
                if($addproduct != ""){
                    $conn->addProductsCheckout($initial_user, $addproduct);
                    header('Location: https://extravisum.com/checkout');
                }else{
                    if($removeproduct != ""){
                        $conn->deleteSpecifiedProduct($initial_user, $removeproduct);
                        header('Location: https://extravisum.com/checkout');
                    }
                }
            }

        }else{
            
            $conn->addProductsCheckout($initial_user, $productid);
            header('Location: https://extravisum.com/checkout');
        }
    }else{
        //header('Location: https://extravisum.com/loja');
    }
    
?>
<? include "header.php" ?>

</br>
</br>
</br>
<div class="hero" id="main">
<div class="checkout">

<div class="content">

<div class="main">
           
			
<?php
            if(isset($_SESSION["user"])){
            
                $user_id = $conn->getUserId($_SESSION["user"]);

                $products = $conn->getProductsCheckout($user_id);
                
                $totalprice = 0;
                
                if(count($products)>0){
                    echo "<h2>Checkout</h2>";
                    //echo '<form method="get" action="checkout/complete.php">';
                    $all_products = "";
                    for ($i=0; $i < count($products); $i++) { 

                        $productinfo = $conn->getProductInfo($products[$i]["product"]);
                        $thingys = '<span style="float:right;padding-top:6px;"> <a href="checkout.php?removeproduct='.$productinfo["id"].'"><i class="fas fa-minus"></i></a> '.count($conn->getProductTotalCheckout($user_id, $productinfo["id"])).' <a href="checkout.php?addproduct='.$productinfo["id"].'"><i class="fas fa-plus"></i></a> <a href="checkout.php?delproducts='.$productinfo["id"].'"><i style="background:rgba(244, 65, 65, .5);" class="fas fa-times"></i></a></span>';
                        if($productinfo["onlyone"] == "1"){
                            $thingys = '<span style="float:right;padding-top:6px;"> <a href="checkout.php?removeproduct='.$productinfo["id"].'"><i class="fas fa-minus"></i></a> '.count($conn->getProductTotalCheckout($user_id, $productinfo["id"])).' <i style="background:rgba(145, 145, 145, .3);" class="fas fa-plus"></i> <a href="checkout.php?delproducts='.$productinfo["id"].'"><i style="background:rgba(244, 65, 65, .5);" class="fas fa-times"></i></a></span>';   
                        }
                        if($productinfo["onlyone"] == "1"){
                            echo "<div style='width:80%;margin: 0 auto;'><small style='float:left;color:red;text-transform:uppercase;'>*ESTE ITEM SO PODE SER COMPRADO EM 1 QUANTIDADE POR VEZ.*</small></div>";
                        }
                        echo '<div class="checkoutitem">';
                        
                        echo '<img style="max-width:50px;float:left;" src="'.$productinfo["image"].'">';
                        echo "<h3>".$productinfo["name"]."</h3>";
                        
                        echo $thingys;
                        echo "<h3 style='float:right;padding-right:10px;'>R$ ".str_replace(".",",",str_replace(".",",",money_format('%.2n', floatval(floatval($productinfo["price"]*count($conn->getProductTotalCheckout($user_id, $productinfo["id"])))))))."</h3>";
                        echo '</div>';
                        $all_products .= $i.":".$productinfo["id"]."+";
                        $totalprice += floatval($productinfo["price"]*count($conn->getProductTotalCheckout($user_id, $productinfo["id"])));
                    }
                    
                    //echo '<input style="display:none;" type="text" name="products" value="'.$all_products.'">';
                    echo "</br></br>";
                    echo '<div class="finalcontent"><span style="float:left;"><a href="https://extravisum.com/checkout/complete"><button style="margin-top:7px;">Finalizar Pedido <i class="fas fa-shopping-cart"></i></button></a></span><span style="float:right;"><h3>TOTAL: R$ '.str_replace(".",",",$totalprice).'</h3></span></div></br></br></br></br>';
                    //echo $all_products;
                    //echo '</form>';
                }else{
                    echo "<h2>Carrinho Vazio.</h2>";
                }
            }else{
                echo "<h2>Você precisa estar logado para efetuar compras.</h2>";
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
	<div class="main">
		
		
	</div>
<? include "footer.php"?>

