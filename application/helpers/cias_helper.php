<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * This function is used to print the content of any data
 */
function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/**
 * This function used to get the CI instance
 */
if(!function_exists('get_instance'))
{
    function get_instance()
    {
        $CI = &get_instance();
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('getHashedPassword'))
{
    function getHashedPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('verifyHashedPassword'))
{
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}

/**
 * This method used to get current browser agent
 */
if(!function_exists('getBrowserAgent'))
{
    function getBrowserAgent()
    {
        $CI = get_instance();
        $CI->load->library('user_agent');

        $agent = '';

        if ($CI->agent->is_browser())
        {
            $agent = $CI->agent->browser().' '.$CI->agent->version();
        }
        else if ($CI->agent->is_robot())
        {
            $agent = $CI->agent->robot();
        }
        else if ($CI->agent->is_mobile())
        {
            $agent = $CI->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }

        return $agent;
    }
}

if(!function_exists('setProtocol'))
{
    function setProtocol()
    {
        $CI = &get_instance();
                    
        $CI->load->library('email');
        
        $config['protocol'] = PROTOCOL;
        $config['mailpath'] = MAIL_PATH;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['smtp_user'] = SMTP_USER;
        $config['smtp_pass'] = SMTP_PASS;
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        
        $CI->email->initialize($config);
        
        return $CI;
    }
}

if(!function_exists('emailConfig'))
{
    function emailConfig()
    {
        $CI->load->library('email');
        $config['protocol'] = PROTOCOL;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['mailpath'] = MAIL_PATH;
        $config['charset'] = 'UTF-8';
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
    }
}

if(!function_exists('resetPasswordEmail'))
{
    function resetPasswordEmail($detail)
    {
        $data["data"] = $detail;
        // pre($detail);
        // die;
        
        $CI = setProtocol();        
        
        $CI->email->from(EMAIL_FROM, FROM_NAME);
        $CI->email->subject("Reset Password");
        $CI->email->message($CI->load->view('email/resetPassword', $data, TRUE));
        $CI->email->to($detail["email"]);
        $status = $CI->email->send();
        
        return $status;
    }
}

if(!function_exists('setFlashData'))
{
    function setFlashData($status, $flashMsg)
    {
        $CI = get_instance();
        $CI->session->set_flashdata($status, $flashMsg);
    }
}

if(!function_exists('setFeeList'))
{
    function setFeeList($data)
    {
        $temp = FEE_LIST;
        foreach ($data as $key => $value) {
            unset($temp[$value]);
        }

        return $temp;
    }
}

if(!function_exists('calculateTime'))
{
    function calculateTime($data)
    {
        $seconds = strtotime(date("Y-m-d H:i:s")) - strtotime($data);
        $days    = floor($seconds / 86400);
        $hours   = floor(($seconds - ($days * 86400)) / 3600);
        $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
        $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
        if($days > 0) { return $days."일";}
        if($hours > 0) { return $hours."시간";}
        if($minutes > 0) { return $minutes."분";}
        if($seconds > 0) { return "방금";}
    }
}
if(!function_exists('getMailCount'))
{
    function getMailCount()
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        return  $CI->base_model->getMailCount();
    }
}

if(!function_exists('generateRandomString'))
{
    function generateRandomString($length = 10,$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if(!function_exists('get_board'))
{
    function get_board()
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        return  $CI->base_model->getSelect("tbl_board",null,array(array("record"=>"grade","value"=>"ASC")));
    }
}

if(!function_exists('getBanners'))
{
    function getBanners($type,$mobile=-1)
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        if($mobile ==-1)
            $where = array( array("record"=>"use","value"=>1),
                        array("record"=>"type","value"=>$type));
        if($mobile !=-1){
            $where = array( array("record"=>"use","value"=>1),
                            array("record"=>"type","value"=>$type),
                            array("record"=>"mobile","value"=>$mobile)   
                        );
        }
        return  $CI->base_model->getSelect("banner",$where,array(array("record"=>"order","value"=>"ASC")));
    }
}

if(!function_exists('getRate'))
{
    function getRate()
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        $rate = $CI->base_model->getSelect("tbl_accurrate",null,array(array("record"=>"created_date","value"=>"DESC")))[0]->rate;
        return !empty($rate) ? $rate:0;
    }
}

if(!function_exists('getProducts'))
{
    function getProducts($id)
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        $rate = $CI->base_model->getProductFromShopCategory($id);
        return $rate;
    }
}


if(!function_exists('getFooterContent'))
{
    function getFooterContent()
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        $rate = $CI->base_model->getSelect("banner",array(array("record"=>"id","value"=>"77")));
        return $rate;
    }
}
if(!function_exists('getSiteName'))
{
    function getSiteName()
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        $ss =  $CI->base_model->getSelect("tbl_smart_setup");
        if(!empty($ss))
            return $ss[0]->s_adshop;
        return "";
    }
}
if(!function_exists('getPages'))
{
    function getPages($type)
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        $rate = $CI->base_model->getSelect("banner",    array(array("record"=>$type,"value"=>1)),
                                                        array(array("record"=>"order","value"=>"ASC")));
        return $rate;
    }
}


function get_client_ip() {
    $ipaddress = '';

    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP']))
        $ipaddress = $_SERVER['HTTP_CF_CONNECTING_IP'];
    return $ipaddress;
}

if(!function_exists('deleteFile'))
{
    function deleteFile($url)
    {
        
        if(!file_exists($url)){
            return 0;
        }
        if(unlink($url)) return 1;
        else return 0;
    }
}  

if(!function_exists('multi_categories'))
{
    function multi_categories()
    {
        $second = array();
        $three = array();
        $second_category = array();
        $three_category = array();
        $returns = array();
        $CI = &get_instance();
        $CI->load->model('base_model');
        $categories1 = $CI->base_model->getCategoriesFromParentsArray(array(0));
        if(!empty($categories1))
          foreach($categories1 as $value)
            array_push($second, $value->id); 
        $categories2 = $CI->base_model->getCategoriesFromParentsArray($second);
        if(!empty($categories2))
          foreach($categories2 as $value)
            array_push($three, $value->id); 
        $categories3 = $CI->base_model->getCategoriesFromParentsArray($three);

        foreach($categories2 as $value)
            if(in_array($value->parent, $second))
            {
                if(!isset($second_category[$value->parent]))
                    $second_category[$value->parent] = array();
                    array_push($second_category[$value->parent],$value);
            }
            else
                $second_category[$value->parent] = array();
        foreach($categories3 as $value)
            if(in_array($value->parent, $three))
            {
                if(!isset($three_category[$value->parent]))
                    $three_category[$value->parent] = array();
                array_push($three_category[$value->parent],$value);
            }
            else
                $three_category[$value->parent] = array();
        return array(   "categories1" => $categories1,
                        "categories2" => $second_category,
                        "categories3" => $three_category);
    }

}

if(!function_exists('getSiteInfo'))
{
    function getSiteInfo()
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        return  $CI->base_model->getSelect("tbl_smart_setup")[0];
    }
}

if(!function_exists('getDeliveryPrice'))
{
    function getDeliveryPrice($first_weight,$weight,$weight_gap,$first_price,$gap,$rate,$end_weight)
    {
       
        $i = $first_weight;
        $correct_weight = 0;

        if($weight <=$first_weight){
            $correct_weight = $first_weight;
        }

        else{
            while($i < $end_weight){
                if($weight > $i && $weight <=$i+$weight_gap){
                    $correct_weight = $i+$weight_gap;
                    break;
                }
                $i += $weight_gap;
            }
        }



        $diff = ($correct_weight-$first_weight) / $weight_gap;
        $total = $first_price + $gap*$diff;
        return array("price"=>$total * $rate,"weight"=>$correct_weight);
    }
}

if(!function_exists("current_self")){

    function current_self(){
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}

function escapeString($val) {
    $db = get_instance()->db->conn_id;
    $val = mysqli_real_escape_string($db, $val);
    return $val;
}

function getOS() { 

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
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
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser() {

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $browser        = "Unknown Browser";

    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}

function iptocountry($ip)
{
  $numbers = explode( ".", $ip);    
  include("ip_files/".$numbers[0].".php");
  $code=($numbers[0] * 16777216) + ($numbers[1] * 65536) + ($numbers[2] * 256) + ($numbers[3]);    

  foreach($ranges as $key => $value)
  {
    if($key<=$code)
    {
      if($ranges[$key][0]>=$code)
      {
        $country=$ranges[$key][1];break;
      }
    }
  }

  if ($country=="")
  {
    $country="unknown";
  }

  return $country;
}


function calVisit(){
    $CI = &get_instance();
    $CI->load->model('base_model');
    $ip = get_client_ip();

    $t = $CI->base_model->getSelect("tbl_visit", array( array("record"=>"ip","value"=>$ip) ,
                                                        array("record"=>"time","value"=>date("H")),
                                                        array("record"=>"created_date","value"=>date("Y-m-d"))  ));

    if(empty($t))
    {
        $details = json_decode(file_get_contents("http://ipinfo.io/".$ip ."/json"));

        $region = iptocountry($ip);
        $details->region = empty($details->city) ?  $region : $details->city."(".$details->country.")";
        $CI->base_model->insertArrayData("tbl_visit",array( "ip"=>$ip,
                                                                    "created_date"=>date("Y-m-d"),
                                                                    "time"=>date("H"),
                                                                    "os"=>getOS(),
                                                                    "browser"=>getBrowser(),
                                                                    "platform"=>1,
                                                                    "latitude"=>$details->region,
                                                                    "region"=>$region));
    }

}

function getLogSite(){
    $CI = &get_instance();
    $CI->load->model('base_model');
    $ip = get_client_ip();
    $pref = empty($_SERVER['HTTP_REFERER']) ? "" : $_SERVER['HTTP_REFERER'];
    if(strpos($pref, "taodalin.com") ==true)
        $pref = base_url();
    if(empty($pref))
        $pref = base_url();
    $t = $CI->base_model->getSelect("tbl_log_site", array(  array("record"=>"ip","value"=>$ip) ,
                                                                array("record"=>"time","value"=>date("H")),
                                                                array("record"=>"site","value"=>$pref) ));

    if(empty($t))
        $CI->base_model->insertArrayData("tbl_log_site",array( "ip"=>$ip,
                                                                "created_date"=>date("Y-m-d"),
                                                                "region"=>iptocountry($ip),
                                                                "time"=>date("H"),
                                                                "site"=>$pref
                                                                ));

    
}


function insertStrange($site){
    $CI = &get_instance();
    $CI->load->model('base_model');
    $ip = get_client_ip();
    $CI->base_model->insertArrayData("tbl_strange",array( "ip"=>$ip,
                                                                "ip"=>$ip,
                                                                "time"=>date("H"),
                                                                "strange"=>$site
                                                                ));
}

function getRegion(){
    $ip = get_client_ip();
    return iptocountry($ip);
}

function get_geolocation($apiKey = "78d9571d14cf49d69a61524bed62b1a5", $ip, $lang = "en", $fields = "*", $excludes = "") {
        $apiKey = "78d9571d14cf49d69a61524bed62b1a5";
        $url = "https://api.ipgeolocation.io/ipgeo?apiKey=".$apiKey."&ip=".$ip."&lang=".$lang."&fields=".$fields."&excludes=".$excludes;
        $cURL = curl_init();

        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: '.$_SERVER['HTTP_USER_AGENT']
        ));

        return curl_exec($cURL);
    }

?>