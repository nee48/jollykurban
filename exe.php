<?php
date_default_timezone_set("Asia/Jakarta");

Class Jolly {

	public function sendC($url, $page, $params) {

        $ch = curl_init(); 
        curl_setopt ($ch, CURLOPT_URL, $url.$page); 
        curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; Android 7.0; SM-G935P Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.111 Mobile Safari/537.36"); 
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 

        if(!empty($params)) {
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt ($ch, CURLOPT_POST, 1); 
        }

        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt ($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);

        $headers  = array();
        $headers[] = "User-Agent: Dalvik/2.1.0 (Linux; U; Android 5.1.1; SM-G925F Build/JLS36C)";
    	$headers[] = "Content-Type: application/json; charset=UTF-8";
        $headers[] = "Accept-Encoding: gzip";

        curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);    
        //curl_setopt ($ch, CURLOPT_HEADER, 1);
        $result = curl_exec ($ch);
        curl_close($ch);
        return $result;

    }


    private function getStr($start, $end, $string) {
        if (!empty($string)) {
        $setring = explode($start,$string);
        $setring = explode($end,$setring[1]);
        return $setring[0];
        }
    }

    public function read ($length='255') 
		{ 
		   if (!isset ($GLOBALS['StdinPointer'])) 
		   { 
		      $GLOBALS['StdinPointer'] = fopen ("php://stdin","r"); 
		   } 
		   $line = fgets ($GLOBALS['StdinPointer'],$length); 
		   return trim ($line); 
		} 


    public function suntik($id,$token)
    {
        $url = "http://h5server.jollychic.com/active/sheepFeed/getFood.do?appTypeId=0&lang=12&countryCode=ID&appVersion=7.1.1&currency=IDR&terminalType=1&timestamp=".mt_rand(1533846604092,1933846604092)."&cookieId=&userId=$id&userToken=$token&token=&type=".mt_rand(1133846604092,1933846604092)."&edtionCatId=90394&_=";
        $data = '';
        $send = $this->sendC($url, null, null);
        $json = json_decode($send);
        echo $json->message." - Total Pakan : $json->foodQuantity \n";

    }

    public function kasihmakan($id,$token)
    {
        $url = "http://h5server.jollychic.com/active/sheepFeed/feed.do?appTypeId=0&lang=12&countryCode=ID&appVersion=7.1.1&currency=IDR&terminalType=1&timestamp=&cookieId=8&userId=$id&userToken=$token&token=&_=1533932460467";
        $data = '';
        $send = $this->sendC($url, null, null);
        $json = json_decode($send);
        echo $json->message." - Sisa Pakan : $json->leftFoodQuantity \n";

    }

    
}



error_reporting(0);
$init = new Jolly();

echo "Auto Get Feed & Auto Feed Game Kurban Jollychic \n\n";
echo 'UserID : ';
$userId = $init->read();
echo 'UserToken : ';
$userToken = $init->read();

echo "Pilih Mode : \n";
echo "1. Get Feed \n";
echo "2. Feed Sheep \n";
$mode = $init->read();

if ($mode == 1) {
	echo "Masukan Jumlah : ";
	$loop = $init->read();
	for ($i=0; $i < $loop; $i++) { 
		$init->suntik($userId,$userToken);
	}
}elseif ($mode == 2) {
	echo "Masukan Jumlah : ";
	$loop = $init->read();
	for ($i=0; $i < $loop; $i++) { 
		$init->kasihmakan($userId,$userToken);
	}
}else{
	echo "Masukin Yang Bener Goblok";
}
// while(true){
// $init->kasihmakan($userId,$userToken);
// }

