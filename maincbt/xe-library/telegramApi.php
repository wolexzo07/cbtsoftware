<?php
// personal telegram bot details
	//$id = 1087418627;
	//$token = "5581262856:AAH-g_y7R01kfXjokBmCxZ0wkhmlBoy4WpE";
	//$alert_status = 1;
function x_send_telegram($id , $token ,$mess ,$alert_status){ // send text to telegram
    if(x_justvalidate($id) && x_justvalidate($token)){		
       	$msg = urlencode($mess);
		$url = "https://api.telegram.org/bot$token/sendmessage?chat_id=$id&text=".$msg;
		$result = x_curlPost($url, $data=NULL, $headers = NULL);
		$decode = json_decode($result,true);
		$finalize = $decode["ok"];
		$opt = array(0,1);
		
		if($finalize == "true"){
			if(in_array($alert_status,$opt)){
				if($alert_status == "1"){
					return "Telegram message sent!";
				}
				return true;
			}else{
				return "Invalid option";
			}
		}
		
	}
}


function x_sendDocument($botToken, $chatId, $documentPath, $caption = '')
{ // send attachment to telegram
    $url = "https://api.telegram.org/bot$botToken/sendDocument";

    $document = new CURLFile($documentPath);

    $data = [
        'chat_id' => $chatId,
        'document' => $document,
        'caption' => $caption,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
?>