<?php
class WhatsappAPI{

  private $id = '1971'; //Please change it with your ID
  private $key = "5aad5935731ff73882b11cacfc219ce5c2e115a3";

  public function send($send_to, $message_body){
    
    $data = array('to' => $send_to, 'msg' => $message_body);

    $url = "https://onyxberry.com/services/wapi/Client/sendMessage";
    $url = $url.'/'.$this->id.'/'.$this->key;
    $ch = curl_init( $url );
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec( $ch );
    return $response;
  }
}

?>
