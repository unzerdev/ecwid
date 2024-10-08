<?php
    include("../config/db_connection.php");

    if(isset($_REQUEST) && !empty($_REQUEST) && $_REQUEST['action'] === "register"){
        $eStorId = $_REQUEST['storeId'];
        $eAccessToken = $_REQUEST['storeAccessToken'];
        $uPublicKey = $_REQUEST['u_public_key'];
        $uPrivateKey = $_REQUEST['u_private_key'];
        $uAuthStatus = $_REQUEST['u_authorized_status'];
        $uCaptureStatus = $_REQUEST['u_captured_status'];
        $uChargedStatus = $_REQUEST['u_charged_status'];
        $uAutoCaptureStatus = $_REQUEST['u_autocapture'];

        $qCheckRecordExists = mysqli_query($conn, "SELECT * FROM configurations WHERE e_storeId = '".$eStorId."'");
        $countNumOfStore = mysqli_num_rows($qCheckRecordExists);
        if($countNumOfStore <= 0){
            $qForInsertStoreDetails = mysqli_query($conn, "INSERT INTO configurations(e_storeId, e_accessToken, u_publicKey, u_privateKey, u_authStatus, u_captureStatus, u_chargeStatus, u_autocapture) VALUES ('".$eStorId."','".$eAccessToken."','".$uPublicKey."','".$uPrivateKey."','".$uAuthStatus."','".$uCaptureStatus."','".$uChargedStatus."','".$uAutoCaptureStatus."')");
        }else{
            $uDate = date("Y-m-d H:i:s");
            $qForUpdateStoreDetails = mysqli_query($conn, "UPDATE configurations SET e_accessToken='".$eAccessToken."',u_publicKey='".$uPublicKey."',u_privateKey='".$uPrivateKey."',u_authStatus='".$uAuthStatus."',u_captureStatus='".$uCaptureStatus."',u_chargeStatus='".$uChargedStatus."',u_autocapture='".$uAutoCaptureStatus."',updatedAt='".$uDate."' WHERE  e_storeId='".$eStorId."'");
        }
        echo 1;
    }
    
    
    if(isset($_REQUEST) && !empty($_REQUEST) && $_REQUEST['action'] === "get_webhooks"){
        $eStorId = $_REQUEST['storeId'];
        $qForGetWebhooks = mysqli_query($conn, "SELECT * FROM webhook_urls WHERE store_id = '".$eStorId."'");
        $countNumOfStore = mysqli_num_rows($qForGetWebhooks);
        if($countNumOfStore > 0){
            $rForGetWebhooks = mysqli_fetch_all($rForGetWebhooks);
            echo json_encode($rForGetWebhooks);
        }else{
            echo json_encode(['error' => 'No records found.']);
        }
        
    }

    if(isset($_REQUEST) && !empty($_REQUEST) && $_REQUEST['action'] === "webhook_add"){
        $eStorId = $_REQUEST['storeId'];
        $eWebhookURL = $_REQUEST['webhookURL'];
        $qCheckRecordExists = mysqli_query($conn, "SELECT * FROM webhook_urls WHERE store_id = '".$eStorId."' AND unzer_webhook_url = '".$eWebhookURL."'");
        $countNumOfStore = mysqli_num_rows($qCheckRecordExists);
        if($countNumOfStore == 0){
            $qForInsertWebhook = mysqli_query($conn, "INSERT INTO webhook_urls(store_id, unzer_webhook_url) VALUES ('".$eStorId."','".$eWebhookURL."')");
        }
        echo 1;
    }
    
    if(isset($_REQUEST) && !empty($_REQUEST) && $_REQUEST['action'] === "webhook_delete"){
        $rowId = $_REQUEST['id'];
        $qForInsertWebhook = mysqli_query($conn, "DELETE FROM webhook_urls WHERE id = '".$rowId."'");
        echo 1;
    }
?>