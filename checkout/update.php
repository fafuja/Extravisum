<?php 

require_once "../inc/db.php";
require_once "../inc/credentials.php";
$db = new ExtravisumDB();
$notification = isset($_POST["notificationCode"])?$_POST["notificationCode"]:"";
$notification_type = isset($_POST["notificationType"])?$_POST["notificationType"]:"";


//$check = $db->checkProduct($shoptoken);

    if($notification != ""){
        $credentials = new Credentials();
        $site_email = $credentials->email;
        $site_token = $credentials->token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://ws.pagseguro.uol.com.br/v3/transactions/notifications/".$notification."?email=".$site_email."&token=".$site_token);   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);
        
        if(strpos($server_output->error[0]->message, "invalid") === false){
            $server_output = new SimpleXMLElement($server_output);
            $status = $server_output->status;
            $reference = $server_output->reference;
            $user_lp = $db->getUserByReference($reference);
            $db2 = new mysqli("", "", "", "");
            # Insert your Minecraft database in here.
            
            $date = $server_output->date;
            if($status == "1"){
                $db->updateShipInfo($reference, "Aguardando pagamento", $date);
            }else{
                if($status == "2"){
                    $db->updateShipInfo($reference, "Em análise", $date);
                }
                if($status == "3"){
                    foreach ($server_output->items->item->description as $desc) {
                        if($desc == "VIP"){
                            $sql = "UPDATE luckperms_players SET primary_group='supreme' WHERE username='{$user_lp}'";
                            $db2->query($sql);
                        }
                     }
                    $db->updateShipInfo($reference, "Paga", $date);
                }
                if($status == "4"){
                    $db->updateShipInfo($reference, "Disponível", $date);
                }
                if($status == "5"){
                    $db->updateShipInfo($reference, "Em disputa", $date);
                }
                if($status == "6"){
                    $db->updateShipInfo($reference, "Devolvida", $date);
                }
                if($status == "7"){
                    $db->updateShipInfo($reference, "Cancelada", $date);
                }
                if($status == "8"){
                    $db->updateShipInfo($reference, "Debitado", $date);
                }
                if($status == "9"){
                    $db->updateShipInfo($reference, "Retenção temporária", $date);
                }
            }
        }else{
            header("Location: https://extravisum.com/");
        }
        
    }else{
        header("Location: https://extravisum.com/");
    }


?>