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

if(!function_exists('active_link')) {
  function activate_menu($controller) {
    $route_obj = new CI_Router;
    $get_page = $route_obj->method;    
    if(strpos(strtolower($controller),"/".strtolower($get_page)."/") !==false ) {
       return "active";
    }
  }
}

if(!function_exists('delteFile'))
{
    function delteFile($url)
    {
        
        if(!file_exists($url)){
            return 0;
        }

        if(unlink($url)) return 1;
        else return 0;
    }
}   

if(!function_exists('generateRandomString'))
{
    function generateRandomString($length = 10,$t=null) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($t=="n") $characters = '0123456789';
        if($t=="e") $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
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
        return  $CI->base_model->getSelect("tbl_board");
    }
}

if(!function_exists('get_note'))
{
    function get_note($view = 0)
    {
        if($view == 0)
           $arr = array(array("record"=>"view","value"=>0));
        else 
            $arr = NULL; 
        $CI = &get_instance();
        $CI->load->model('base_model');
        return  sizeof($CI->base_model->getSelect("tbl_notice",$arr));
    }
}

if(!function_exists('get_roles'))
{
    function get_roles($userId)
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        return $CI->base_model->getSelect("tbl_role_management",array(array("record"=>"userId","value"=>$userId)));
    }
}

if(!function_exists('getCountProcessing'))
{
    function getCountProcessing($type)
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        return  $CI->base_model->getCountProcessing($type);
    }
}

if(!function_exists('getPendingCount'))
{
    function getPendingCount()
    {
        $CI = &get_instance();
        $CI->load->model('base_model'); 
        $panel= $CI->base_model->getSelect("tbl_board",array(array("record"=>"title","value"=>"1:1맞춤문의")));
        if(empty($panel)){
          return 0;
        }
        return sizeof($CI->base_model->getSelect("tbl_mail",array(   array("record"=>"type","value"=>$panel[0]->id),                                                        array("record"=>"mode","value"=>"문의중"))));
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

if(!function_exists('calcualteGrade'))
{
    function calcualteGrade($userId)
    {
        $CI = &get_instance();
        $CI->load->model('base_model');
        $users= $CI->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$userId)));
        if(empty($users)) return;
        $roleu= $CI->base_model->getSelect("tbl_roles",array(array("record"=>"roleId","value"=>$users[0]->roleId)));
        if(empty($roleu)) return;
        $order_num=$users[0]->complete_orders;
        $level=$roleu[0]->level;
        $role= $CI->base_model->getSelect("tbl_roles",array(array("record"=>"level !=","value"=>1),array("record"=>"level !=","value"=>2)));
        foreach($role as $value){
            if($order_num <=$value->sending_times1 && $order_num >=$value->sending_times){
                if($level !=$value->level){
                    $CI->base_model->updateDataById($userId,array("roleId"=>$value->roleId),"tbl_users","userId");
                    $CI->base_model->insertArrayData("tbl_mail",array("fromId"=>1,
                                                          "toId"=>$userId,
                                                          "title"=>"회원등급알림",
                                                          "content"=>"회원님의 등급이 ".$value->role."으로 되였습니다.",
                                                          "type"=>0));
                }
            }
        }
    }
}

if(!function_exists('base_url_home'))
{
    function base_url_home()
    {
        return "http://m.taodalin.com/";
    }
}


if(!function_exists('base_url_source'))
{
    function base_url_source()
    {
        return "http://taodalin.com/";
    }
}

if(!function_exists('getShopAllagories'))
{
    function getShopAllagories($pcode="",$category="",$type)
    {
        $return = array();
        $parent = "";
        $CI = &get_instance();
        $CI->load->model('base_model');
        if($type =="pcode"){
            $categories = $CI->base_model->getCategoryiesFromPcode($pcode);
            foreach($categories as $value){
                $temp_return = array(0=>"",1=>"",2=>"");
                $parent = $value->parent;
                $cates = $value->id;
                $index = 0;
                while (true) {
                    $temp = $CI->base_model->getSelect("tbl_leftcategory",array(array("record"=>"id","value"=>$cates)));
                    if(empty($temp))
                    {
                        if(empty($temp_return[$index]))
                            unset($temp_return[$index]);
                        break;
                    }  
                    $parent = $temp[0]->parent;
                    $temp_return[$index] = $temp[0]->name;
                    $cates = $temp[0]->parent;
                    $index++;
                }

                $return[$value->id] = $temp_return;
            }

            return $return;
        }

    }
}

if(!function_exists('get_site_info')){
    function get_site_info() {
        $CI = &get_instance();
        $CI->load->model('base_model');
        $r = $CI->base_model->getSelect("tbl_smart_setup",array(array("record"=>"id","value"=>1)));
        return $r;
    }
}

function escapeString($val) {
    $db = get_instance()->db->conn_id;
    $val = mysqli_real_escape_string($db, $val);
    return $val;
}

function weekOfMonth($strDate) {
  $dateArray = explode("-", $strDate);
  $date = new DateTime();
  $date->setDate($dateArray[0], $dateArray[1], $dateArray[2]);
  return floor((date_format($date, 'j') - 1) / 7) + 1;  
}

function get_first( $year_number, $week_number ) {
    $week = $week_number;
    $year =  $year_number;

    $timestamp = mktime( 0, 0, 0, 1, 1,  $year ) + ( $week * 7 * 24 * 60 * 60 );
    $timestamp_for_monday = $timestamp - 86400 * ( date( 'N', $timestamp ) - 1 );
    $date_for_monday = date( 'Y-m-d', $timestamp_for_monday );
    return $date_for_monday;
}

function get_7first($date){
    $date = new DateTime($date);
    $date->modify('+6 day');
    return $date->format('Y-m-d');
}

?>