<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class RestController extends Controller
{
	function beforeFilter(Event $event) {
	    // parent::beforeFilter($event);
         // $this->getEventManager()->off($this->Csrf);
	    $this->viewBuilder()->setLayout(false);
	    // $this->request->withData('data',array_map('trim',$this->request->getData()));
	}
    
	
  public function authenticatShyplite() {
		$email =  "sam.sourabh@gmail.com";
		$password = "12345678";

		$timestamp = time();
		$appID = 2383;
		$key = 'WWu9nhly2i0=';
		$secret = 'G8zu5XIDJyqBNcZEOpnq7b6XbCXPYABWG3yR+JvOkXS67P3I6zruusw4Z7f2Qt5wbncrhuCIKNqPZzqnIk84rw==';

		$sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
		$authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
		$ch = curl_init();

		$header = array(
			"x-appid: $appID",
			"x-timestamp: $timestamp",
			"Authorization: $authtoken"
		);

		curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/login');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "emailID=$email&password=$password");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		var_dump($server_output);
		exit;
		curl_close($ch);
	}
}