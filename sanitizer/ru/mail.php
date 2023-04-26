<?php
$method = $_SERVER['REQUEST_METHOD'];

$token = $_POST["token"];
$action = $_POST["action"];

$curlData = array(
	'secret' => "6Lc-WM0ZAAAAACRl7Zbx9CDupn7DW2GISlFKn-Zm",
	'response'  => $token
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($curlData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$curlResponse = curl_exec($ch);

$captchaResponse = json_decode($curlResponse, true);

$c = true;
if ( $method === 'POST' ) {
	$project_name = "Gocsanitizer";
	$admin_email  = "info@gocsanitizer.com.ua";
	$form_subject = "Оптова закупівля";
	foreach ( $_POST as $key => $value ) {
		if ( $value != "" && $key!="token" && $key!="action") {
			$message .= "
			" . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
				<td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
				<td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
			</tr>
			";
		}
	}
}
$message = "<table style='width: 100%;'>$message</table>";
function adopt($text) {
	return '=?UTF-8?B?'.Base64_encode($text).'?=';
}
$headers = "MIME-Version: 1.0" . PHP_EOL .
"Content-Type: text/html; charset=utf-8" . PHP_EOL .
'From: '.adopt($project_name).' <'.$admin_email.'>' . PHP_EOL .
'Reply-To: '.$admin_email.'' . PHP_EOL;

$response = array(
	"ru" => "Спасибо! Ваше сообщение отправлено.",
	"uk" => "Спасибі! Ваше повідомлення було відправлене."
);
$err = array(
	"ru"=> "Не удалось подать заявку. Повторите попытку.",
	"uk"=> "Не вдалося надіслати заявку. Повторіть спробу."
);
$captcha = array(
	"ru"=> "Вы не человек!",
	"uk"=> "Ви не людина!"
);

if($captchaResponse["success"] == '1'
		&& $captchaResponse['action'] == $action
		&& $captchaResponse['score'] >= 0.5
		&& $captchaResponse['hostname'] == $_SERVER['SERVER_NAME'])
{
	if (mail($admin_email, adopt($form_subject), $message, $headers )) {
		http_response_code(200);
		echo json_encode($response);
	} else {
		http_response_code(500);
		echo json_encode($err);
	}
}
else{
	echo json_encode($captcha);
}
