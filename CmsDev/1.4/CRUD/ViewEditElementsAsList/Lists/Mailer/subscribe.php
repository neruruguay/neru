<?php
$apiKey = '1fef605a18c573130f79fd72d7a59610'; // your mailchimp API KEY here
$listId = '875e54b946'; // your mailchimp LIST ID here
$double_optin=false;
$send_welcome=false;
$email_type = 'html';
$email = $_POST['newsletter_email'];
//$merge1 = isset($_POST['newsletter_name']) ? $_POST['newsletter_name'] : 'Nombre';
//$merge2 = isset($_POST['newsletter_surname']) ? $_POST['newsletter_surname'] : 'Apellido';
//replace us2 with your actual datacenter
$submit_url = "http://us9.api.mailchimp.com/1.3/?method=listSubscribe";
$data = array(
    'email_address'=>$email,
    //'name'=>$merge1,
    //'surname'=>$merge2,
    'apikey'=>$apiKey,
    'id' => $listId,
    'double_optin' => $double_optin,
    'send_welcome' => $send_welcome,
    'email_type' => $email_type
);
$payload = json_encode($data);
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $submit_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
 
$result = curl_exec($ch);
curl_close ($ch);
$data = json_decode($result);
if ($data->error){
    echo str_replace('is already subscribed to list', 'ya se encuentra en nuestra lista', $data->error);
} else {
    echo 'Ha sido a&ntilde;adido a nuestra lista de correo electr&oacute;nico.';
}
?>