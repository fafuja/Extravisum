
<? include "header.php" ?>
</br>
</br>
</br>
<div class="hero" id="main">
<br/><br/>
<h2>Loja</h2>
</div>
    </header>
	<div class="main">
		
		<div style="" id="staff">
			<div class="staff">
                <?php 
                   
                    $conn = new ExtravisumDB();
                    $result = $conn->getProducts();
                    if(count($result) == 0){
                        echo "<h2>Sem produtor no momento.</h2>";
                    }
                ?>
				<div class="shop-item">
                <?php
                    if(count($result) > 0){
                        for ($i=0; $i < count($result); $i++) { 
                            

                            echo "<div class='itemdiv'>";
                            echo '<div class="owner"><h3>'.$result[$i]["name"].'</h3></div></br>';
                            echo '<img style="max-width:128px;" src="'.$result[$i]["image"].'"></br>';
                            echo  '<div class="itemdesc">'.$result[$i]["desc"].'</div></br></br>';
							//echo  '<div class="itemdesc"><h3>R$ '.str_replace(".",",",$result[$i]["price"]).'</h3></div></br>';
							echo  '<div class="itemdesc"><h3>R$ '.str_replace(".",",",money_format('%.2n', floatval($result[$i]["price"]))).'</h3></div></br>';
							
							echo '<form method="post" action="checkout.php">';
                            echo '<input style="display:none;" type="text" id="productid" name="productid" value="'.$result[$i]["id"].'">';
                            echo '<button>Comprar <i class="fas fa-shopping-cart"></i></button></br></br>';
                            echo '</form>';
                            echo "</div>";
                            
                        }
                    }
                    
                ?>
					
					
				</div>
			</div>
            
		</div>
	
		
	</div>
<? include "footer.php"?>

