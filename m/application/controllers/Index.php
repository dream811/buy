<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__.'/../../../vendor/autoload.php';
class Index extends BaseController {

	function __construct()
	{
		parent::__construct();
		if( strpos(current_self(), base_url()) !==false ){
		
		}

		else
		{
			// echo "<script>alert('이상한 경로 감지');</script>";
			if( strpos(current_self(), "121.254.254.216") !== false )
			{
				insertStrange(current_self());
				echo "Direct IP access not allowed";
				die(0);
			}
			redirect(base_url());
		}
		$this->load->library('encryption');
		$this->encryption->initialize(cRYPT);	
		$this->encryption->initialize(array('driver' => 'mycript'));
		$this->load->model('base_model');
		$this->global['pageTitle'] = getSiteName();
		$this->global['headerr'] = getPages("header"); 
		$this->global['footer'] = getPages("footer");
		$this->global['bmenu'] = get_board();
		$this->global['accrate_default'] = $this->base_model->getSelect("tbl_accurrate",null,array(array("record"=>"created_date","value"=>"DESC")));
		$this->load->helper('form');
		if($this->session->userdata('fuser') > 0)
			$this->global['user'] = $this->base_model->getUserInfo($this->session->userdata('fuser'));
		$this->global['caan'] = getBanners(13);
		$this->global['inan'] = getBanners(14);
		
		$this->global['cateogory_1'] = $this->base_model->getSelect("tbl_leftcategory",array(	array("record"=>"parent","value"=>0),
																								array("record"=>"use","value"=>1)),
																						array(	array("record"=>"order","value"=>"ASC")));

		$this->global['basket_count'] = $this->base_model->getBasketCount();
		calVisit();
		getLogSite();
	}

	public function index()
	{	
		// $data['s_banner'] = $this->base_model->getSelect("banner",				array(	array("record"=>"use","value"=>1)
		// 																				,array("record"=>"type","value"=>18)));
		$data['footer_menus'] = $this->base_model->getSelect("banner",				array(	array("record"=>"use","value"=>1)
																						,array("record"=>"type","value"=>19)));

		$data['ques'] = $this->base_model->getMail(9,-1,0,0,NULL,NULL,5);

		$data['banner'] = $this->base_model->getSelect("banner",				array(	array("record"=>"use","value"=>1),
																						array("record"=>"type","value"=>1),
																						array("record"=>"mobile","value"=>1)),
																				array(array("record"=>"order","value"=>"ASC")));
		// $data['event'] = $this->base_model->getSelect("tbl_event",	array(array("record"=>"use","value"=>1)),
		// 															null,
		// 															null,
		// 															array(array("record"=>"2","value"=>0)));
		$data['event_home'] = $this->base_model->getSelect("tbl_eventhome",				array(	array("record"=>"use","value"=>1)
																						,array("record"=>"id","value"=>1)));

		$data['shops'] = $this->base_model->getProductsBySh(5,0);

		$data['accuringRate'] = $this->base_model->getSelect("tbl_accurrate",null,array(array("record"=>"created_date","value"=>"DESC")))[0];

		$data['sizes'] = sizeof($this->base_model->getProductsBySh());

		$this->loadViews('index', $this->global, $data , NULL);

	}

	public function UserPage(){
				
	}

	public function delivery(){
		$this->isLoggedIn();
		$delivery_address  = $this->base_model->getSelect("delivery_address",array(array("record"=>"use","value"=>1)));
		$type = $this->input->get('option');
		$tracking_header = $this->base_model->getSelect("tracking_header");
		if($type ==null){
			$type = 'delivery';
		}
		$data = array(
			'options'=>$type,
			'delivery_address' =>$delivery_address,
			'tracking_header' =>$tracking_header
		);
		$data['category']  = $this->base_model->getSelect("tbl_category",	array(	array("record"=>"parent","value"=>0)),
																					array(array("record"=>"orders","value"=>"ASC")));
		$data['fees'] = sizeof($this->base_model->getSelect("tbl_shipping_fee")) > 0 ? $this->base_model->getSelect("tbl_shipping_fee")[0]:"";
		$data['contacts'] = $this->base_model->getSelect("tbl_mycontact",array(array("record"=>"userId","value"=>$this->session->userdata('fuser'))));
		$data['sends'] = $this->base_model->getSelect("tbl_sendmethod");
		$services = $this->base_model->getServices();
		$data['service_header'] = $this->base_model->getSelect("tbl_service_header",array(array("record"=>"use","value"=>1)),
																			array(array("record"=>"id","value"=>"ASC")));
		foreach ($services as $key => $value) {
			if (!isset($aa[$value->part])) {
				$aa[$value->part] = array();
			}
			array_push($aa[$value->part], array("name"=>$value->name,"price"=>$value->price,"id"=>$value->id,"description"=>$value->description));
		}
		$data['aa'] = $aa;
			
		if($type =='buy') {

			$data["pp"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'5')));
			$data['page_label'] = '구매';
			$this->global['pageTitle'] = '구매대행 신청';
			$data['type'] =2;
		}
		else {
			$data["pp"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'4')));
			$data['page_label'] = '배송';
			$this->global['pageTitle'] = '배송대행 신청';
			$data['type'] =1;
			
		}

		$this->loadViews('delivery', $this->global, $data , NULL);
	}

	public function nodata(){
		$data['nodata'] = $this->base_model->getSelect("tbl_purchasedproduct", 	array(array("record"=>"step","value"=>103)),
																				array(array("record"=>"created_date","value"=>"DESC")));
		$this->loadViews('nodata', $this->global, $data , NULL);
	}

	public function shopping(){

		$this->load->library('pagination');
		$config['reuse_query_string'] = true;
        $this->pagination->initialize($config); 
		$selected_item = "";
		$product_name = "";
		$favor=  "";
		$categories = array();
		$data["breads_name"] = array();
		$data["cates"] = NULL;
		if(!in_array($this->input->get("txt-category"), FAVOR_URL))
		{	

			$categories = $this->getChildCateogriesFromParentID($this->input->get("txt-category"));
			if(!empty($this->input->get("txt-category"))){
				if($this->input->get("inc") !="none")
					$this->base_model->plusValue("tbl_leftcategory","view",1,array(array("category_code",$this->input->get("txt-category"))),"+");
				$self_category = $this->base_model->getSelect("tbl_leftcategory",array(array("record"=>"category_code","value"=>$this->input->get("txt-category"))));
				$parent_category = $child_category = $self3_category =  NULL;
				if(!empty($self_category))
				{
					$parent_category  = $this->base_model->getSelect("tbl_leftcategory",array(array("record"=>"id","value"=>$self_category[0]->parent)));
					$child_category = $this->base_model->getSelect("tbl_leftcategory",array(array("record"=>"parent","value"=>$self_category[0]->id)));

					if(!empty($parent_category) && $self_category[0]->step==3)
						$self3_category = $this->base_model->getSelect("tbl_leftcategory",array(array("record"=>"parent","value"=>$parent_category[0]->id)));
				}

				$data["cates"] = array(	"self_category"		=> $self_category	, 
										"parent_category"	=> $parent_category	, 
										"child_category"	=> $child_category	, 
										"self3_category"	=> $self3_category
										);


			}
		}
		else
		{
			$categories["category"] = array();
			$oo="";
			if($this->input->get("txt-category") =="best")
				$oo="베스트상품";
			if($this->input->get("txt-category") =="rec")
				$oo="추천상품";
			if($this->input->get("txt-category") =="new")
				$oo="신상품";
			if($this->input->get("txt-category") =="low")
				$oo="싸다";
			if($this->input->get("txt-category") =="wow")
				$oo="멋지다";
			$categories["name"] = $oo;
		}
		$records_count = sizeof($this->base_model->getProdcutsWithNames(NULL,NULL,$categories["category"],
			$this->input->get("txt-search"),$this->input->get("txt-category")));
		$returns = $this->paginationCompress ( "shopping/", $records_count, 20);
		$data["limit1"] = $returns["page"];
		$data["limit2"] = $returns["segment"];
		$data["records_count"] = $records_count;
		$this->global["selected_name"] = $categories["name"];
		$this->loadViews('shopping', $this->global, $data , NULL);
	}

	public function contact(){
		$shCol="";
		$shKey = "";
		if(!empty($_GET['shCol'])) $shCol = $_GET['shCol'];
		if(!empty($_GET['shKey'])) $shKey = $_GET['shKey'];
		$data['ques'] = $this->base_model->getMail(4,-1,"",0,$shCol,$shKey);
		$this->loadViews('public', $this->global, $data , NULL);
	}

	public function viewdeliveryState(){
		$this->isLoggedIn();
		$this->load->library('pagination');
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config); 
		$step_array=array();
		$category = $this->base_model->getSelect("tbl_step_title",NULL,
														array(array("record"=>"step","value"=>"ASC")));
		$delivery = $this->base_model->getStepDelivery();
		$step = $this->input->get("step");
		$today  = "";
		$process = 1;
		$from = "";
		$to = "";
		$search_ptracking = "";
		$search_tracking_number = "";
		$search_receiver = "";
		$search_porder = "";

		if(empty($this->input->get("today")) || $this->input->get("today")== "" ){
			$from = $this->input->get("from");
			$to = $this->input->get("to");
		}
		$from = $this->input->get("from");
		$to = $this->input->get("to");
		// else if($this->input->get("today") =="D1"){
		// 	$from = date("Y-m-d");
		// 	$to =  date("Y-m-d");
		// }
		// else if($this->input->get("today") =="D7"){
		// 	$from = date("Y-m-d",strtotime("-7 day"));
		// 	$to =  date("Y-m-d");
		// }
		// else if($this->input->get("today") =="M1"){
		// 	$from = date("Y-m-d", strtotime("-1 months"));
		// 	$to =  date("Y-m-d");
		// }
		// else if($this->input->get("today") =="M3"){
		// 	$from = date("Y-m-d", strtotime("-3 months"));
		// 	$to =  date("Y-m-d");
		// }
		if($this->input->get("process") == "" || $this->input->get("process") ==1){
			$process ="updated_date";
		}
		else $process ="created_date";

		$stateCount = $this->base_model->getStateByUserId();
		foreach ($stateCount as $key => $value) {
			$step_array[$value->state] = $value->stateCount;
		}
		if(isset($step) && $step!=null){
			$records_count = sizeof($this->base_model->getDeliverContent(null,0,null,$step,$this->session->userdata('fuser'),$from,$to,$process,$this->input->get("type"),$this->input->get("content")));
			$returns = $this->paginationCompress ( "viewdeliveryState/", $records_count, 10);
			$delivery_content = $this->base_model->getDeliverContent($returns["page"] ,$returns["segment"],null,$step,$this->session->userdata('fuser'),$from,$to,$process,$this->input->get("type"),$this->input->get("content"));
			
		}
		else {
			$records_count = sizeof($this->base_model->getDeliverContent(null,0,null,null,$this->session->userdata('fuser'),$from,$to,$process,$this->input->get("type"),$this->input->get("content")));
			$returns = $this->paginationCompress ( "viewdeliveryState/", $records_count, 10);
			$delivery_content = $this->base_model->getDeliverContent($returns["page"] ,$returns["segment"],null,null,$this->session->userdata('fuser'),$from,$to,$process,$this->input->get("type"),$this->input->get("content"));
			
		}

		$data = array(
			'delivery' =>$delivery,
			'category'  =>$category,
			'deliver_content' =>$delivery_content,
			"step_array" =>$step_array,
			'step' => $step
		);
		$data['errorCoutr']  = $this->base_model->getErrorProductsCount();
		$this->loadViews('mypage', $this->global, $data , NULL);
	}

	public function offten_question(){
		$shCol="";
		$shKey = "";
		if(!empty($_GET['shCol'])) $shCol = $_GET['shCol'];
		if(!empty($_GET['shKey'])) $shKey = $_GET['shKey'];
		if(!empty($this->input->get("category"))){
			$data['ques'] = $this->base_model->getMail(3,$this->input->get("category"),"",0,$shCol,$shKey);
		}
		else{
			$data['ques'] = $this->base_model->getMail(3,-1,"",0,$shCol,$shKey);
		}
		
		$this->loadViews('offten_question', $this->global, $data , NULL);
	}

	public function after_use(){
		$shCol="";
		$shKey = "";
		if(!empty($_GET['shCol'])) $shCol = $_GET['shCol'];
		if(!empty($_GET['shKey'])) $shKey = $_GET['shKey'];
		if(!empty($this->input->get("category"))){
			$data['after_use'] = $this->base_model->getMail(2,$this->input->get("category"),"",0,$shCol,$shKey);
		}
		else{
			$data['after_use'] = $this->base_model->getMail(2,-1,"",0,$shCol,$shKey);
		}
		
		$this->loadViews('after_use', $this->global, $data , NULL);
	}

	public function private_discuss(){
		$this->load->library('pagination');
    	$config['reuse_query_string'] = true;
    	$this->pagination->initialize($config); 
    	$data['panel'] = $this->base_model->getSelect("tbl_board",array(array("record"=>"title","value"=>"1:1맞춤문의")));
    	if(empty($data['panel'])){
    		echo "1:1 게시판이 존재하지 않습니다.";
    		return;
    	}
    	$id = $data['panel'][0]->iden;
    	$shCol="";
		$shKey = "";
		$category = "";
		if(!empty($_GET['shCol'])) $shCol = $_GET['shCol'];
		if(!empty($_GET['shKey'])) $shKey = $_GET['shKey'];
		if(!empty($_GET['category'])) $category = $_GET['category'];
    	$records_count = sizeof($this->base_model->getReq($data['panel'][0]->id,null,0,$category,$shCol,$shKey));
  		$returns = $this->paginationCompress ( "private/", $records_count, 10,"inline-block");
  		$data['content'] = $this->base_model->getReq($data['panel'][0]->id,$returns["page"] ,$returns["segment"],$category,$shCol,$shKey);
  		$data['ac'] = $records_count;
    	$data['cc'] = $returns["segment"];
	  	$this->loadViews("public",$this->global,$data,null);
	}
	public function event(){
		$data['event'] = $this->base_model->getSelect("tbl_event",array(array("record"=>"use","value"=>1)));
		$this->loadViews('event', $this->global, $data , NULL);
	}

	public function member(){
		$this->isLoggedIn();
		$this->loadViews('member', $this->global, NULL , NULL);
	}
	public function mailbox(){
		$this->isLoggedIn();
		$shCol="";
		$shKey = "";

		$this->load->library('pagination');
	    $config['reuse_query_string'] = true;
	    $this->pagination->initialize($config); 
		$from = $this->input->get("from");
		$to = $this->input->get("to");
		$records_count= sizeof($this->base_model->getMail(0,-1,"",$this->session->userdata('fuser'),$shCol,$shKey,"",$from,$to));
		$returns = $this->paginationCompress ( "mailbox/", $records_count, 20);
		$data['ques'] = $this->base_model->getMail(0,-1,$returns["page"] ,$this->session->userdata('fuser'),$shCol,$shKey,$returns['segment'],$from,$to);
		$data['ac'] = $records_count;
    	$data['cc'] = $returns["segment"];	
		$this->loadViews('mailbox', $this->global, $data , NULL);
	}
	public function coupon(){
		$this->isLoggedIn();
		$data['coupon'] = $this->base_model->getCouponLists(0,1);
		$this->loadViews('coupon', $this->global, $data , NULL);
	}

	public function quesanw(){
		if(!empty($this->input->get("category"))){
			$data['ques'] = $this->base_model->getMail(1,$this->input->get("category"));
		}
		else{
			$data['ques'] = $this->base_model->getMail(1);
		}
		
		$this->loadViews('quesanw', $this->global, $data , NULL);
	}
	public function deposit(){
		$this->isLoggedIn();
		$current_deposit = $this->global['user'][0];
		$this->session->set_userdata('fdeposit', $current_deposit->deposit);
		$this->session->set_userdata('fpoint', $current_deposit->point);
		$data['bank'] = $this->base_model->getSelect("tbl_bank");
		$data['deposits'] =  $this->base_model->getSelect("tbl_request_deposit",array(
										array("record"=>"userId","value"=>$this->session->userdata('fuser')),
										array("record"=>"updated","value"=>0)),
									array(array("record"=>"update_date","value"=>"DESC")));
		$this->loadViews('deposit', $this->global, $data , NULL);
	}
	public function mypay(){
		$this->isLoggedIn();
		$data['content'] = $this->base_model->getDeliverWaitingPay(20,0);
		$current_deposit = $this->global['user'][0]->deposit;
		$this->session->set_userdata('fdeposit', $current_deposit);
		$data['bank'] = $this->base_model->getSelect("tbl_bank");
		$this->loadViews('mypay', $this->global, $data , NULL);
	}

	public function insertDeliver(){
		if(empty($this->session->userdata('fuser'))){
			echo 0;
			return;
		}
		$theader = json_decode($this->input->post("theader")); /// products
		$aa = array();
		$vv = $this->base_model->getSelect("tbl_services");
		$CTR_SEQ = $this->input->post("CTR_SEQ");
		$baskets = $this->input->post("baskets");
		$REG_TY_CD = $this->input->post("REG_TY_CD");
		$ADRS_KR = $this->input->post("ADRS_KR");
		$ADRS_EN = $this->input->post("ADRS_EN");
		$RRN_CD = $this->input->post("RRN_CD");
		$RRN_NO = $this->input->post("RRN_NO");
		$MOB_NO1 = $this->input->post("MOB_NO1");
		$MOB_NO2 = $this->input->post("MOB_NO2");
		$MOB_NO3 = $this->input->post("MOB_NO3");
		$ZIP = $this->input->post("ZIP");
		$ADDR_1 = $this->input->post("ADDR_1");
		$ADDR_2 = $this->input->post("ADDR_2");
		$REQ_1 = $this->input->post("REQ_1");
		$REQ_2 = $this->input->post("REQ_2");
		$waiting = $this->input->post("waiting");
		$options =  $this->input->post("type_options");
		$shop =  $this->input->post("shop");
		$fees = explode(",", $this->input->post("fees"));
		foreach ($vv as $key => $value) {
			if(in_array($value->id, $fees)){
				$aa[$value->id] = $value->price;
			}
		}
		if($options =="buy"){
			$types = 2;
			$state = 4;
		}
		else{
			$types = 1;
			if($waiting ==1 ){
				$state = 1;
			}
			else{
				$state = 2;
			}
		}
		if(!empty($shop) && $shop ==1)
			$types = 3;
		
		$deliver = $this->input->post("deliver");
		$post_data=  array( "place" => $CTR_SEQ,
							"incoming_method" =>$REG_TY_CD,
							"billing_name"=> $ADRS_EN,
							"billing_krname"=>$ADRS_KR,
							"person_num" => $RRN_CD,
							"person_unique_content" => $RRN_NO,
							"phone_number" =>$MOB_NO1."-".$MOB_NO2."-".$MOB_NO3,
							"post_number"=> $ZIP,
							"address" => $ADDR_1,
							"detail_address" => $ADDR_2,
							"request_detail" => $REQ_1,
							"logistics_request" =>$REQ_2,
							"type" => $types,
							"state" =>$state,
							"get"=>$deliver,
							"userId"=>$this->session->userdata('fuser'),
							"created_date"=>date("Y-m-d H:i:s"),
							"rid"=>generateRandomString(15),
							"region"=>getRegion());
		if(!empty($this->input->post("ordersp")) && $this->input->post("ordersp") ==1){
			$post_data['shop'] = 1;
		}
		$insert_id = $this->base_model->insertArrayData("delivery",$post_data);
		$oo = date("y").date("m").date("d").str_pad($insert_id, 4, '0', STR_PAD_LEFT);
		if($insert_id > 0){
			$this->base_model->insertArrayData("tbl_service_delivery",array("content"=>json_encode($aa),"delivery_id"=>$insert_id));
			$this->base_model->updateDataById($insert_id,array("ordernum"=>$oo),"delivery","id");
			$this->base_model->insertPurchase($theader,$insert_id,$oo);
			if(!empty($this->input->post("ordersp")) && $this->input->post("ordersp") ==1){
				$this->base_model->deleteRecordsById("tbl_basket","userId",$this->session->userdata('fuser'));
			}
			if(!empty($baskets) && sizeof(json_decode($baskets)) >0){
				foreach (json_decode($baskets) as $key => $value) {
					$this->base_model->deleteRecordsById("tbl_basket","id",$value);
				}
			}
			echo $oo;
			return;
		}

		echo 0;
		
	}

	public function login(){
		if(!empty($this->session->userdata('fuser')))
			redirect("/");
		$data["f"] = "로그인";
		$this->loadViews('login', $this->global, $data , NULL);
	}

	public function register(){
		if(!empty($this->session->userdata('fuser')))
			redirect("/");
		$data["p"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'2')));
    	$data["p1"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'3')));
    	$data["f"] = "회원가입";
		$this->loadViews('register', $this->global, $data , NULL);

	}
	public function findpass(){
		$this->loadViews('findpass', $this->global, NULL , NULL);
		
	}
	public function usetext(){
		$data["p"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'2')));
		$data["f"] = "이용약관";
		$this->loadViews('usetext', $this->global, $data , NULL);
		
	}
	public function policy(){
		$data["p"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'3')));
		$data["f"] = "개인정보취급방침";
		$this->loadViews('usetext', $this->global, $data , NULL);
	}

	public function doLogin()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('sMemPw', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $memId = $this->input->post('sMemId');
            $password = $this->input->post('sMemPw');
            $result = $this->base_model->loginMe($memId, $password);   
            if(count($result) > 0)
            {
                foreach ($result as $res)
                {
                    $sessionArray = array('fuser'=>$res->userId,                    
                                            'frole'=>$res->roleId,
                                            'froleText'=>$res->role,
                                            'fname'=>$res->name,
                                            'fisLoggedIn' => TRUE,
                                            'fdeposit' =>$res->deposit,
                                            'fpoint' =>$res->point,
                                            'flevel' =>$res->level,
                                            'fsase' =>$res->sase,
                                            'fnickname' =>$res->nickname
                                    );
                                    
                    $this->session->set_userdata($sessionArray);
                    $this->base_model->updateDataById($res->userId, array( 
                    											"log_num"=>intval($res->log_num)+1,
                    											"log_date"=>date("Y-m-d"),
                    											"session_id"=>session_id()),"tbl_users","userId");
                    $this->base_model->insertArrayData("tbl_log",array(	"browser" => getBrowser(), 
                														"os" => getOS(), 
                														"userId" => $res->userId, 
                														"loginId" => $memId,
                														"platform" => 2,
                														"time"=>date("H"),
                														"created_date" => date("Y-m-d"),
                														"region"=>iptocountry(get_client_ip())));
                    if(!empty($this->input->post("redirect")))
                    	redirect(json_decode('"'.$this->input->post("redirect").'"'));
                    else
                    	redirect('/');
                    $this->session->set_userdata('actual_link', "");

                }

            }
            else
            {
                $this->session->set_flashdata(array("error"=>"로그인 정보가 정확하지 않습니다"));
                
                redirect('/login');
            }
        }
    }

    public function doRegister(){
    	$sMemId = $this->input->post('sMemId');
    	$sMemPw = $this->input->post("sMemPw");
    	$sMemPw1 = $this->input->post("sMemPw1");
    	$email = $this->input->post("email");

    	if($this->base_model->getIDUnique($sMemId)==1){
    		$this->session->set_flashdata(array("error"=>"같은 아이디가 존재합니다."));
    		redirect('/register');
    		return;
    	}

    	if($this->base_model->getEmailUnique($email)==1){
    		$this->session->set_flashdata(array("error"=>"같은 이메일이 존재합니다."));
    		redirect('/register');
    		return;
    	}

    	if($sMemPw != $sMemPw1){
    		$this->session->set_flashdata(array("error"=>"암호가 틀립니다."));
    		redirect('/register');
    		return;
    	}
    	$sNick = $this->input->post("sNick");
    	$sMemKrNm = $this->input->post("sMemKrNm");
    	$birthday = $this->input->post("birthday");
    	$mobile = $this->input->post("sMobNo1")."-".$this->input->post("sMobNo2")."-".$this->input->post("sMobNo3");
    	$telephone = $this->input->post("sTelNo1")."-".$this->input->post("sTelNo2")."-".$this->input->post("sTelNo3");
    	$ZIP = $this->input->post("ZIP");
    	$ADDR_1 = $this->input->post("ADDR_1");
    	$ADDR_2 = $this->input->post("ADDR_2");
    	$sEmailRcvYN = $this->input->post("sEmailRcvYN")=="Y"?"1":"0";
    	$sSmsRcvYN = $this->input->post("sSmsRcvYN")=="Y"?"1":"0";
    	$sAuthSeq  = $this->input->post('sAuthSeq');

    	$userInfo = array(	'email'=>$email,
    						'password'=>$this->encryption->encrypt($sMemPw), 
    						'roleId'=>3, 
    						'name'=> $sMemKrNm,
                            'mobile'=>$mobile,  
                            'createdDtm'=>date('Y-m-d H:i:s'),
                        	"nickname"=>$sNick,
                        	"birthday"=>$birthday,
                        	"postNum"=>$ZIP,
                        	"address"=>$ADDR_1,
                        	"detail_address"=>$ADDR_2,
                        	"telephone"=>$telephone,
                        	"smsRecevice"=>$sSmsRcvYN,
                        	"emailRecevice"=>$sEmailRcvYN,
                        	"phone_verification"=>$sAuthSeq,
                        	"loginId"=>$sMemId);
    	$insert_id = $this->base_model->addNewUser($userInfo);
    	if($insert_id > 0){

    		$sase = "AH".str_pad($insert_id, 4, '0', STR_PAD_LEFT);
    		$this->base_model->updateDataById($insert_id,array("sase"=>$sase),"tbl_users","userId");

    		$registerd_msg = $this->base_model->getSelect("tbl_registed_message");
    		if(!empty($registerd_msg) && $sEmailRcvYN ==1){
    			try {
    				$content = $registerd_msg[0]->content;
    				$content = str_replace("{ID}", $sMemId, $content);
    				$content = str_replace("{EMAIL}", $email, $content);
    				$content = str_replace("{MOBILE}", $mobile, $content);
    				$content = str_replace("{NICK}", $sNick, $content);
    				$content = str_replace("{POST_NO}", $sase, $content);
    				$ID = "insert_id";
    				$EMAIL = "email";
    				$MOBILE = "mobile";
    				$NICK = "sNick";
    				$POST_NO= "sase";
					$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
				    //서버설정
				    $mail->CharSet ="UTF-8";                     //언어셋설정                     
					$email_split = explode("@",$email); 
					$type_address = $email_split[1]; 
					$mail->Port = 587;                            // smtp 포트
					if(strpos(strtolower($type_address),"gmail.com") >=0){
						$mail->Host = 'smtp.gmail.com';
						$mail->Username = 'taodalin88@gmail.com';                // SMTP 메일사용자
				    	$mail->Password = 'putongba6688';
					}
					if(strpos(strtolower($type_address),"naver.com") >=0){
						$mail->Host = 'smtp.naver.com';
						$mail->Username = 'taodalin@naver.com';                // SMTP 메일사용자
				    	$mail->Password = 'putongba6688';
					}
					if(strpos(strtolower($type_address),"qq.com") >=0){
						$mail->Host = 'smtp.hanmail.net';
						$mail->Username = '2106472449@qq.com';                // SMTP 메일사용자
				    	$mail->Password = 'putongba6688';
					}

				    $mail->SMTPAuth = true;                      //  SMTP 인증사용
				    $mail->SMTPSecure = 'ssl';                    // ssl 사용
				    $mail->Port = 587;                            // smtp 포트
				    $mail->setFrom('kml5395@naver.com', '타오달인');  //발신자 메일주소 및 발신자 이름
				    $mail->addAddress($email, '고객님');  // 수신자 메일주소 
				    $mail->Subject = ($registerd_msg[0]->title);
					$mail->Body = $content;
				    $mail->AltBody = '클라이언트에서 html지원하지 않을 경우 표시';
					$mail->SMTPDebug = 4;
				    $mail->send();
				} catch (Exception $e) {
					
				    
				}
    		}
    		
    		$cc = $this->base_model->getSelect("tbl_coupon",array(	array("record"=>"use","value"=>1),
    																array("record"=>"SUBSTRING_INDEX(terms,\"|\",1) <=","value"=>date("Y-m-d")),
    																array("record"=>"SUBSTRING_INDEX(terms,\"|\",-1) >=","value"=>date("Y-m-d")),
    																array("record"=>"event_coupon","value"=>1)));
    		foreach($cc as $va){
    			$this->base_model->insertArrayData("tbl_coupon_user",array(	"userId"=>$insert_id,
							                                                "coupon_id"=>$va->id,
							                                                "by"=>1,
							                                                "use"=>1,
							                                                "code"=>$va->code,
							                                                "created_date"=>date("Y-m-d"),
    																		"byd"=>date('Y-m-d',strtotime('+'.$va->use_terms.' days',strtotime("now")))));
    		}
    		if(sizeof($cc) > 0 ){
    			$this->base_model->insertArrayData("tbl_mail",array("toId"=>$insert_id,
                                                        "fromId"=>1,
                                                        "title"=>"회원님에게 쿠폰이 발행되였습니다.",
                                                        "content"=>"회원님에게 쿠폰이 발행되였습니다.",
                                                        "type"=>0,
                                                        "view"=>0,
                                                        "updated_date"=>date("Y-m-d H:i:s")));
    		}
    		$cc = $this->base_model->getSelect("tbl_point",array(	array("record"=>"type","value"=>1)));
    		if(!empty($cc)){
    			$this->base_model->plusValue("tbl_users","point",$cc[0]->point,array(array("userId",$insert_id)),"+");
    			$this->base_model->insertArrayData("tbl_point_users",array( "userId"=>$insert_id,
	                                                                      				"point_id"=>$cc[0]->id,
	                                                                  					"point"=>"+".$cc[0]->point,
	                                                                  					"type"=>$cc[0]->type,
	                                                                  					"remain"=>$cc[0]->point));
    			$this->base_model->insertArrayData("tbl_mail",array("toId"=>$insert_id,
                                                        "fromId"=>1,
                                                        "title"=>"포인트 적용",
                                                        "content"=>"회원님에게 포인트가 적용되였습니다.\n 포인트 페이지에서 직접 확인하세요",
                                                        "type"=>0,
                                                        "view"=>0,
                                                        "updated_date"=>date("Y-m-d H:i:s")));
    		}
    	}
    	$data = array(
			'success_register'=>1
		);
		$this->loadViews('register', $this->global, $data , NULL);
    }
    public function processPay(){
    	$this->isLoggedIn();
    	$toValue=1;
    	$MemDpstMny = str_replace(',', '', $this->input->post("MemDpstMny"));
		$TotMny = $this->input->post("TotMny");
		$seqOrd = explode("|", $this->input->post("seqOrd"));
		$OlnPmtCd = $this->input->post("OlnPmtCd");
		$MemPntMny = !empty($this->input->post("MemPntMny")) ? str_replace(",","",$this->input->post("MemPntMny")) : 0;
		$security = date("ymd").generateRandomString(10);
		if($OlnPmtCd ==4) $pending =1;
		if($OlnPmtCd ==5) $pending	=0;
		$state = "";
		$type = "";
		$pp ="";
		$return_orders = "";
		$amount =0;
		$coupon = array();
		foreach ($seqOrd as $key => $value) {
			$ar=array();
			$dels= $this->base_model->getStateByDeliveryId($value);
			if(empty($dels)) return;
			$return_orders = $return_orders.$dels[0]->ordernum.",";
			if(!empty($dels[0]->content))
			{
				$ar = json_decode($dels[0]->content,true);
			}
			$state  = $dels[0]->state;
			if($state !=5 && $state!=14 && $state!=20){
				$type = 4;
				$pp = "add_check";
				$toValue =2;
			}

			if($state == 5){
				$state = 6;
				$type = 2;
				$pp = "payed_checked";
				if($dels[0]->type ==3)
				{	
					$type = 7;
				}
			}
			if($state == 14){
				$state = 15;
				$type = 1;
				$pp = "payed_send";
			}
			if($state == 20){
				$state = 21;
				$type = 3;
				$pp = "return_check";
			}
			for($i=1;$i<=7;$i++){
				if($i==1 || $i==7) $lr = "";
				if($i==2) $lr = 7;
				if($i==3) $lr = 8;
				if($i==4) $lr = 63;
				if($i==5) $lr = 47;
				if($i==6) $lr = 51;
				$code = explode("|", $this->input->post("CPN_".$i."_".$value))[0];
				$coo = $this->base_model->getSelect("tbl_coupon",array(array("record"=>"code","value"=>$code)));
				$tt=0;
				$gt = "";
				if($lr!="" && isset($ar[$lr]) && !empty($this->input->post("CPN_".$i."_".$value))){
					if($coo[0]->gold_type ==1)
					{
						$tt = $ar[$lr]-$coo[0]->gold;
						$gt = $coo[0]->gold;
						$ar[$lr] = $tt < 0 ? 0 : $tt;
						if($tt >=0){
							$this->base_model->updateDataById($code,array("used"=>1),"tbl_coupon_user","code");
						}
						else{
							$this->base_model->updateDataById($code,array("gold"=>(-1)*(int)$tt),"tbl_coupon","code");
						}
					}
					if($coo[0]->gold_type ==2){

						$tt = $ar[$lr]-$ar[$lr]*$coo[0]->gold/100;
						$gt = $ar[$lr]*$coo[0]->gold/100;
						$ar[$lr] = $tt < 0 ? 0: $tt;
						$this->base_model->updateDataById($code,array("used"=>1),"tbl_coupon_user","code");
					}
					$amount = $tt <= 0  ? $ar[$lr] : $gt;
					$coupon[$i] = $amount."|".$code;
					$this->base_model->insertArrayData(	"tbl_payhistory",array(
																			"all_amount"=>$amount,
																			"payed_date"=>date("Y-m-d H:i:s"),
																			"type"=>10,
																			"amount"=>$amount,
																			"payed_type"=>10,
																			"coupon"=>$coo[0]->id,
																			"userId"=>$this->session->userdata('fuser'),
																			"security"=>$security
																			));
				
				}
				if($lr=="" && !empty($this->input->post("CPN_".$i."_".$value))){
					$sending_price = str_replace(",", "", $dels[0]->sending_price);
					if($coo[0]->gold_type ==1)
					{
						$tt = $sending_price-$coo[0]->gold;
						$gt = $coo[0]->gold;
						if($tt >=0){
							$this->base_model->updateDataById($code,array("used"=>1),"tbl_coupon_user","code");
						}
						else{
							$this->base_model->updateDataById($code,array("gold"=>(-1)*(int)$tt),"tbl_coupon","code");
						}
					}
					if($coo[0]->gold_type ==2){
						$tt = $sending_price-$sending_price*$coo[0]->gold/100;
						$gt = $sending_price*$coo[0]->gold/100;
						$this->base_model->updateDataById($this->input->post("aCPN"),array("used"=>1),"tbl_coupon_user","code");
					}
					$this->base_model->updateDataById($code,array("used"=>1),"tbl_coupon_user","code");
					$amount = $tt <= 0  ? $dels[0]->sending_price : $gt;
					$coupon[$i] = $amount."|".$code;
					$this->base_model->insertArrayData(	"tbl_payhistory",array(
																			"all_amount"=>$amount,
																			"payed_date"=>date("Y-m-d H:i:s"),
																			"type"=>10,
																			"amount"=>$amount,
																			"payed_type"=>10,
																			"coupon"=>$coo[0]->id,
																			"userId"=>$this->session->userdata('fuser'),
																			"security"=>$security
																			));
				}
			}
			$this->base_model->updateDataById($value,array("content"=>json_encode($ar)),"tbl_service_delivery","delivery_id");
			if($pending == 1 && $state !=5 && $state!=14 && $state!=20){
				$this->base_model->updateDataById($value,array("add_check"=>2),"tbl_add_price","id");
			}
			if($pending == 0 && $pp!="add_check"){
				if($dels[0]->type !=3)	
					$this->base_model->updateDataById($value,array("state"=>$state,$pp=>1),"delivery","id");
				if($dels[0]->type ==3 && $pp =="payed_checked"){
					$this->base_model->updateDataById($value,array(	"state"=>$state,
																	"payed_checked"=>1,
																	"payed_send"=>1),"delivery","id");
				}
			}
			if($pending == 0  && $pp=="add_check"){
				$this->base_model->updateDataById($value,array($pp=>0),"tbl_add_price","id");
			}
			if($pending == 1 && $pp!="add_check"){
				$this->base_model->updateDataById($value,array("pays"=>1),"delivery","id");
			}
			$this->base_model->insertArrayData("tbl_payhistory",array(	"delivery_id"=>$value,
															"all_amount"=>$TotMny,
															"payed_date"=>date("Y-m-d H:i"),
															"type"=>$type,
															"amount"=>$MemDpstMny,
															"payed_type"=>$OlnPmtCd,
															"userId"=>$this->session->userdata('fuser'),
															"pending"=>$pending,
															"pamount"=>$this->input->post("OlnTotMny"),
															"security"=>$security,
															"point"=>$MemPntMny,
															"coupon_type"=>json_encode($coupon)));
		}
		if($MemPntMny > 0){
			$this->base_model->plusValue("tbl_users","point",$MemPntMny,array(array("userId",$this->session->userdata('fuser'))),"-");
			$ss = $this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$this->session->userdata('fuser'))));
			$this->base_model->insertArrayData("tbl_point_users",array( "userId"=>$this->session->userdata('fuser'),
                                                                  		"point"=>"-".$MemPntMny,
                                                                  		"s"=>1,
                                                                  		"s_type"=>$type,
                                                                  		"remain"=>$ss[0]->point));
		}
		if($MemDpstMny > 0 ){
			$this->base_model->plusValue("tbl_users","deposit",$MemDpstMny,array(array("userId",$this->session->userdata('fuser'))),"-");
			$this->session->set_userdata('fdeposit',  $this->session->userdata('fdeposit')-$MemDpstMny);
		}

		substr_replace($return_orders, "", -1);
		echo json_encode(array("p"=>$pending,"o"=>$return_orders));
    }

    public function payHistory(){
    	$this->isLoggedIn();
    	$this->load->library('pagination');
	    $config['reuse_query_string'] = true;
	    $this->pagination->initialize($config); 
    	$shCol= "";
    	$shBeginDay ="";
    	$shEndDay ="";
    	$shCol = empty($_GET['shCol']) ? "":$_GET['shCol'];
    	$shBeginDay = empty($_GET['shBeginDay']) ? "":$_GET['shBeginDay'];
    	$shEndDay = empty($_GET['shEndDay']) ? "":$_GET['shEndDay'];
    	$data['bank'] = $this->base_model->getSelect("tbl_bank");
    	$records_count = sizeof($this->base_model->getPayHistory($shCol,$shBeginDay,$shEndDay));
    	$returns = $this->paginationCompress ( "payHistory/", $records_count, 15);
    	$data['history'] = $this->base_model->getPayHistory($shCol,$shBeginDay,$shEndDay,$returns["page"] ,$returns["segment"]);
    	$data['ac'] = $records_count;
    	$data['cc'] = $returns["segment"];
    	$this->loadViews('pay_check', $this->global, $data , NULL);
    }

     public function sendRequestDeposit(){

    	$sKind = $this->input->post("sKind");
    	$bankId = $this->input->post("bankId");
    	$MNY = $this->input->post("MNY");
    	$PYN_NM = $this->input->post("PYN_NM");
    	$PYN_DT = $this->input->post("PYN_DT");
    	$data = array(	"name"=>$PYN_NM,
    					"payAccount"=>$bankId,
    					"userId"=>$this->session->userdata("fuser"),
    					"amount" =>$MNY,
    					"update_date" =>date("Y-m-d H:i:s"),
    					"process_date"=>$PYN_DT);

		$result = $this->base_model->insertDeposit($data);
		
		echo json_encode(array("status"=>1));
    }

    public function board_write(){
    	$this->isLoggedIn();
    	$data['bbc_code']= $this->input->get("bbc_code");
    	$data['panel'] = $this->base_model->getSelect("tbl_board",array(array("record"=>"id","value"=>$data['bbc_code'])));
    	$this->loadViews('board_write', $this->global, $data , NULL);
    }

    public function registerCoupon(){
        $this->load->view("registerCoupon",NULL);

    }

    public function processCoupon(){
    	echo "<script>self.close();</script>";
    }

    public function getCateogrys(){
    	$option = "<option value=''>2차 카테고리를 선택해주세요</option>";
    	$id= $this->input->get("CATE_SEQ");
    	$category = $this->base_model->getSelect("tbl_category",
																array(array("record"=>"parent","value"=>$id)),
																array(array("record"=>"updated_date","value"=>"DESC")));
    	foreach ($category as $key => $value) {
    		$option.="<option value='".$value->id."' EnChar='".$value->en_subject."' CnChar='".$value->chn_subject."'>".$value->name."</option>";
    	}
    	echo $option;
    }

    public function getCategoryById(){
    	$sArcSeq = $this->input->get("sArcSeq");
    	echo json_encode($this->base_model->getSelect("tbl_category",array(array("record"=>"id","value"=>$sArcSeq))));
    }

    public function bbSend(){

    	$id = $this->input->post("id");
    	$len = $this->input->post("len");
    	$sTIT = $this->input->post("sTIT");
    	$sCT = $this->input->post("sCT");
    	$content = $this->input->post("content");
    	$bbc_code = $this->input->post("bbc_code");
    	$state = $this->input->post("state");
    	$file1="";
    	$file2="";
    	$file3="";
    	$insert_id = 0;
    	$panel = $this->base_model->getSelect("tbl_board",array(array("record"=>"id","value"=>$bbc_code)));
    	if(empty($panel)){
    		echo json_encode(array("error"=>1,"message"=>"해당 게시판이 존재하지 않습니다."));
    		return;
    	}
    	
    	$security = 0;
    	if(!empty($this->input->post("security")) && $this->input->post("security")!="")
    		$security = $this->input->post("security");
    	if($panel[0]->security == 0 ){
    		$security = 0;
    	}
    	if($panel[0]->security == -1 ){
    		$security = 1;
    	}
    	$data = array("fromId"=>$this->session->userdata('fuser'),
	    														"title"=>$sTIT,
	    														"content"=>$content,
	    														"type"=>$bbc_code,
	    														"updated_date"=>date("Y-m-d H:i"),
	    														"security"=>$security);
	  	if(!empty($state) && $state!=""){
	  		$data['mode'] = $state;
	  	}
	  	if(!empty($sCT) && $sCT!=""){
	  		$data['category'] = $sCT;
	  	}

	  	if($id > 0)
	  	{
	  		$this->base_model->updateDataById($id,$data,"tbl_mail","id");
	  		$insert_id  = $id;
	  	}
	  	else
	  		$insert_id = $this->base_model->insertArrayData("tbl_mail",$data);

	  	if($insert_id > 0){
	  		if (!file_exists(__DIR__."/../../../upload/mail/".$insert_id))	
      		mkdir(__DIR__."/../../../upload/mail/".$insert_id, 0777);
		  	$this->load->library('upload',$this->set_upload_options(__DIR__."/../../../upload/mail/".$insert_id,$len*1024,'*',false));
		    $this->upload->initialize($this->set_upload_options(__DIR__."/../../../upload/mail/".$insert_id,$len*1024,'*',false));
		    if(!empty($_FILES['file1']['name']) && $_FILES['file1']['name'] !=""){
		      if ( ! $this->upload->do_upload('file1'))
		      {
		        $error = array('error' => $this->upload->display_errors()."<br>최대 업로드 파일크기는 ".$panel[0]->file_size."MB입니다.");
		        echo json_encode(array("error"=>1,"message"=>$this->upload->display_errors()."<br>최대 업로드 파일크기는 ".$panel[0]->file_size."MB입니다."));
		        return;
		      }
		      else
		      {
		        $img_data = $this->upload->data();
		        $file1=$img_data["file_name"];
		      }
		    }
		    if(!empty($_FILES['file2']['name']) && $_FILES['file2']['name'] !=""){
		      if ( ! $this->upload->do_upload('file2'))
		      {
		        $error = array('error' => $this->upload->display_errors()."<br>최대 업로드 파일크기는 ".$panel[0]->file_size."MB입니다.");
		        // $this->session->set_flashdata($error);
		        // redirect("/panel?id=".$panel[0]->iden);
		        echo json_encode(array("error"=>1,"message"=>$this->upload->display_errors()."<br>최대 업로드 파일크기는 ".$panel[0]->file_size."MB입니다."));
		        return;
		      }
		      else
		      {
		        $img_data = $this->upload->data();
		        $file2=$img_data["file_name"];
		      }
		    }
		    if(!empty($_FILES['file3']['name']) && $_FILES['file3']['name'] !=""){
		      if ( ! $this->upload->do_upload('file3'))
		      {
		        $error = array('error' => $this->upload->display_errors()."<br>최대 업로드 파일크기는 ".$panel[0]->file_size."MB입니다.");
		        echo json_encode(array("error"=>1,"message"=>$this->upload->display_errors()."<br>최대 업로드 파일크기는 ".$panel[0]->file_size."MB입니다."));
		        return;
		      }
		      else
		      {
		        $img_data = $this->upload->data();
		        $file3=$img_data["file_name"];
		      }
		    }

		    $img_data = array();
		    if(!empty($file1))
		    	$img_data['file1'] = $file1;
		    if(!empty($file2))
		    	$img_data['file2'] = $file2;
		    if(!empty($file3))
		    	$img_data['file3'] = $file3;
		    if(!empty($img_data))
		    	$this->base_model->updateDataById($insert_id,$img_data,"tbl_mail","id");
	  	}
		echo json_encode(array("error"=>0,"message"=>"/post/view/".$insert_id."?id=".$panel[0]->iden));
		return;

    }

    public function getMailById(){
    	$this->base_model->updateDataById($this->input->post("id"),	array("view"=>1),"tbl_mail","id");
    	echo json_encode($this->base_model->getSelect("tbl_mail",	array(array("record"=>"id","value"=>$this->input->post("id")))));
    }

    public function AfterView($id){
    	$data['afterview'] = $this->base_model->getReqById($id);
    	$data['comment'] = $this->base_model->getCommentsByPostId(5,0,$id);
    	$data['size'] = sizeof($this->base_model->getSelect("tbl_comment",array(array("record"=>"postId","value"=>$id))));
		if($data['afterview'][0]->security==1 && ($this->session->userdata('fuser') !=$data['afterview'][0]->fromId && $this->session->userdata('fuser') !=$data['afterview'][0]->toId) 
			|| empty($this->session->userdata('fuser')) ){

		}
		else{
			$this->base_model->plusValue("tbl_mail","view",1,array(array("id",$id)),"+");
		}
    	
		$this->loadViews('afterview', $this->global, $data , NULL);	
    }

    public function insertComment(){
    	$this->isLoggedIn();
    	$content = $this->input->post("content");
    	$postId = $this->input->post("postId");
    	$id=$this->input->post("id");
    	if(empty($id))
    	$insert_id =  $this->base_model->insertArrayData("tbl_comment",array( 	"postId"=>$postId,
    																			"userId"=>$this->session->userdata('fuser'),
    																			"content"=>$content));
    	else
    		$insert_id =  $this->base_model->updateDataById($id,array( "content"=>$content),"tbl_comment","id");
    	$gg= $this->base_model->getReqById($postId);

    	if($insert_id > 0 && !empty($gg)) 
    	{
    		echo json_encode(array(	"status"=>1,
    								"p"=>7,
    								"o"=>trim($gg[0]->title)."$!$".$gg[0]->bid."$!$".$postId,
    								"tt"=>$gg[0]->btitle,
    								"userId"=>$this->session->userdata('fuser'),
    								"userName"=>$this->session->userdata('fname')));
    		return;
    	}

    	echo json_encode(array("status"=>0));
    	return;
    }

    public function privateView($id){
    	$data['privateView'] = $this->base_model->getSelect("tbl_mail",array(array("record"=>"id","value"=>$id)));
    	if($data['privateView'][0]->fromId == 1 ) $this->base_model->updateDataById($id,array("view"=>1),"tbl_mail","id");
    	$data['comment'] = $this->base_model->getCommentsByPostId(5,0,$id);
		$this->loadViews('privateView', $this->global, $data , NULL);
    }

    public function couponSet(){

    	$aa = "[]";
    	$CHA_SEQ = $this->input->get("CHA_SEQ");
    	$ss= $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$CHA_SEQ)));
    	if(empty($ss)) return;
    	$fee= $this->base_model->getSelect("tbl_service_delivery",array(array("record"=>"delivery_id","value"=>$CHA_SEQ)));
    	if(!empty($fee)) $aa = $fee[0]->content;
    	$aCpnCode =  $this->input->get("aCpnCode");
    	$data['coupon'] = $this->base_model->getCouponLists(1,$this->session->userdata('fuser'),$aCpnCode,$aa,$ss[0]->shop);
    	$this->load->view('applyCoupon',$data);

    }
    private function set_upload_options($path,$max_size=300000,$allowed='gif|jpeg|png|jpg|xls',$enc = true)
    {   
        $config = array();
        $config['upload_path'] = $path;
        $config['allowed_types'] = $allowed;
        $config['max_size']      = $max_size;
        $config['overwrite']     = true;
        $config['encrypt_name'] = $enc;
        return $config;
    }

    public function InNot(){
		$data['content'] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>12)));
    	$this->loadViews('deliveryShow',$this->global,$data,NULL);	
    }
    public function gwanbu(){
    	$data['content'] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>13)));
    	$this->loadViews('deliveryShow',$this->global,$data,NULL);	
    }
    public function totalFee(){
    	$data['content'] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>10)));
    	$this->loadViews('deliveryShow',$this->global,$data,NULL);	
    }
    public function deliveryShow(){
    	$data['content'] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>8)));
    	$this->loadViews('deliveryShow',$this->global,$data,NULL);
    }
    public function buyShow(){
    	$data['content'] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>11)));
    	$this->loadViews('deliveryShow',$this->global,$data,NULL);	
    }

    public function registerImage(){
    	if($_FILES['FILE_NM']['name'] !=""){
    		$this->load->library('upload',$this->set_upload_options(__DIR__."/../../../upload/delivery"));
          	$this->upload->initialize($this->set_upload_options(__DIR__."/../../../upload/delivery"));
          	if ( ! $this->upload->do_upload('FILE_NM'))
	        {
	           $error = array('error' => $this->upload->display_errors());
	           echo json_encode(array("errorId"=>1,'message'=>$this->upload->display_errors()));
	        }
	         else
	        {
	            $img_data = $this->upload->data();
	            echo json_encode(array("errorId"=>0,'img'=>$img_data["file_name"]));
	        }
    	}
    }
    public function deliveryp(){
      $data['deliveryAddress'] = $this->base_model->getSelect("delivery_address",	array(array("record"=>"use","value"=>1)));
      $data['man'] = $this->base_model->getRoleByMember();
      if(!empty($this->input->get("option"))){
         $data['deliveryContents'] =  $this->base_model->getSelect("tbl_deliverytable",
         													array(array("record"=>"address","value"=>$this->input->get("option"))),
     														array(array("record"=>"startWeight","value"=>"ASC")));
         
      }
     else $data['deliveryContents'] =  $this->base_model->getSelect("tbl_deliverytable",	
         													array(array("record"=>"address","value"=>1)),
     														array(array("record"=>"startWeight","value"=>"ASC")));

      $this->loadViews("deliveryp",$this->global,$data,NULL);
    }

    function editUser()
    {                
        $userInfo = array();
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $mobile = $this->input->post('sMobNo1')."-".$this->input->post('sMobNo2')."-".$this->input->post('sMobNo3');
        $zip = $this->input->post('zip');
        $addr_1 = $this->input->post('addr_1');
        $telephone = $this->input->post('sTelNo1')."-".$this->input->post('sTelNo2')."-".$this->input->post('sTelNo3');
        $details = $this->input->post('details');
        $sEmailRcvYN= $this->input->post('sEmailRcvYN');
        $sSmsRcvYN= $this->input->post('sSmsRcvYN');
        if($this->global['user'][0]->email !=$email){
        	$user_other = sizeof($this->base_model->getSelect("tbl_users",array(array("record"=>"email","value"=>$email))));
        	if($user_other > 0)
        	{
        		$this->session->set_userdata(array("error"=>"같은 이메일이 존재합니다"));
        		redirect("member");
        		return;
        	}
        }
        if(empty($password))
        {
            $userInfo = array('email'=>$email,'mobile'=>$mobile, 'updatedDtm'=>date('Y-m-d H:i:s'),
                            'postNum'=>$zip,'address'=>$addr_1,'detail_address'=>$details,'telephone'=>$telephone,
                        	"smsRecevice"=>$sSmsRcvYN,"emailRecevice"=>$sEmailRcvYN);
        }
        else
        {
            $userInfo = array('email'=>$email, 'password'=>$this->encryption->encrypt($password),'mobile'=>$mobile, 
                'updatedDtm'=>date('Y-m-d H:i:s'),'postNum'=>$zip,'address'=>$addr_1,'detail_address'=>$details,'telephone'=>$telephone,"smsRecevice"=>$sSmsRcvYN,"emailRecevice"=>$sEmailRcvYN);
        }
        
        $result = $this->base_model->editUser($userInfo, $this->session->userdata('fuser'));
        
        if($result == true)
        {
            $this->session->set_flashdata('success', '성공적으로 변경되였습니다.');
        }
        else
        {
            $this->session->set_flashdata('error', '변경오류');
        }
        
        redirect('/');	
    }

    function ajaxGetUser(){
    	$data = $this->input->post();
    	$state = $this->base_model->getUser($data['loginId'],$data['nickname'],$data['email']);
    	if(sizeof($state) > 0){
            foreach ($state as $res)
            {
                $sessionArray = array(  'fuser'=>$res->userId,                    
                                        'frole'=>$res->roleId,
                                        'froleText'=>$res->role,
                                        'fname'=>$res->name == "" ? "KaKao":"",
                                        'fisLoggedIn' => TRUE,
                                        'fdeposit' =>$res->deposit,
                                        'fpoint' =>$res->point
                                );
                                
                $this->session->set_userdata($sessionArray);
            }
            echo 0;
            return;
    	}

    	else{

			$return_result =  $this->base_model->insertArrayData(	"tbl_users",array(   "loginId"=>$data['loginId'],
    																"nickname"=>$data['nickname'],
    																"email"=>$data['email'],
    																"roleId"=>3,
    																"createdDtm"=>date("Y-m-d H:i:s")));
			if($return_result > 0 ){
    			$sessionArray = array(	'fuser'=>$return_result,                    
                                        'frole'=>3,
                                        'froleText'=>"일반회원",
                                        'fname'=>$data['nickname'],
                                        'fisLoggedIn' => TRUE,
                                        'fdeposit' =>0,
                                        'fpoint' =>0
                                );
                                
                $this->session->set_userdata($sessionArray);
                echo 0; 
            	return;
			}
    	}
    	echo 1;
    	return;
    }

    public function popupView(){
    	$id = $this->input->get("pop");
    	$data['popup']  =$this->base_model->getPopup($id);
    	$this->load->view("popupView",$data);
    }

    public function multi(){
    	$this->isLoggedIn();
    	$this->loadViews("multi",$this->global,NULL,NULL);
    }
    public function getTimes(){
    	if(!empty($this->input->post("out")) && $this->input->post("out")==1){
    		echo $this->session->userdata("wat");
    		return;
    	}
    }
    public function multiupload(){
    	$this->load->library('PHPExcel');
    	$data = array();
    	$this->session->set_userdata(array("wat"=>1));
    	$this->load->library('upload',$this->set_upload_options("upload/excel",30000,"*",false));
        $this->upload->initialize($this->set_upload_options("upload/excel",30000,"*",false));
        $post_id = array();
        $insert_id  =0;
        $errors = array();
    	if(isset($_FILES["Multi_FL"]["name"]) && $_FILES["Multi_FL"]["name"]!=""){
    		if ( ! $this->upload->do_upload('Multi_FL'))
	        {
	           $error = array('error' => $this->upload->display_errors());
	           echo json_encode(array("errorId"=>$this->upload->display_errors()));
	        }
	         else
	        {
	            $img_data = $this->upload->data();
	            $inputFileType = PHPExcel_IOFactory::identify($img_data['full_path']);
		        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
		        $objPHPExcel = $objReader->load($img_data['full_path']);
		        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
		        if(sizeof($allDataInSheet) < 1 ) {echo "<script>alert('자료가 없습니다.');window.close();</script>";return;}
	    		foreach($allDataInSheet as $key=>$value)
			    {
				    
				    $id          = isset($value['A']) ? $value['A'] : "";
				    $des         = isset($value['B']) ? $value['B'] : "";
				    $name        = isset($value['C']) ? $value['C'] : "";
				    $eng         = isset($value['D']) ? $value['D'] : "";
				    $person_num  = isset($value['E']) ? $value['E'] : "";
				    $empty 		 = isset($value['F']) ? $value['F'] : "";
				    $phone       = isset($value['G']) ? $value['G'] : "";
				    $use_type    = isset($value['H']) ? trim($value['H']) : "";
				    $postcode    = isset($value['I']) ? $value['I'] : "";
				    $address     = isset($value['J']) ? $value['J'] : "";
				    $eng_address = isset($value['K']) ? $value['K'] : "";
				    $req 		 = isset($value['L']) ? $value['L'] : "";
				    $order_no 	 = isset($value['M']) ? $value['M'] : "";
				    $pro_eng 	 = isset($value['N']) ? $value['N'] : "";
				    $color 		 = isset($value['O']) ? $value['O'] : "";
				    $size 		 = isset($value['P']) ? $value['P'] : "";
				    $count 		 = isset($value['Q']) ? $value['Q'] : "";
				    $unit 		 = isset($value['R']) ? $value['R'] : "";
				    $image 		 = isset($value['S']) ? $value['S'] : "";
				    $pro_url 	 = isset($value['T']) ? $value['T'] : "";
				    $tracking 	 = isset($value['U']) ? $value['U'] : "";
				    $spec 		 = isset($value['V']) ? $value['V'] : "";
				    $name_no 	 = isset($value['W']) ? $value['W'] : "";
					if(!is_numeric($id) || $des==""|| $name=="" || $person_num=="" || $phone=="" || $use_type=="" || $postcode=="" || $address=="" 	|| $pro_eng =="" || $count =="" || $unit=="" || $name_no==""){
					 	continue;
					}
					$p_name = "NONE";
					$ss = $this->base_model->getSelect("tbl_category",array(array("record"=>"id","value"=>$name_no)));
					if(!empty($ss)){
						$category = $ss[0]->id;
						$parent_category = $ss[0]->parent;
					}
					else{
						$category = 65;
						$parent_category = 1;	
					}
					$delivery_address = $this->base_model->getSelect("delivery_address",array(
														array("record"=>"area_name","value"=>$des),
														array("record"=>"use","value"=>1)));
					if(empty($delivery_address)) 
						$des =  $this->base_model->getSelect("delivery_address",array(array("record"=>"use","value"=>1)))[0]->id;
					else{
						$des = $delivery_address[0]->id;
					}

					$send_method = $this->base_model->getSelect("tbl_sendmethod",array(
														array("record"=>"name","value"=>$use_type)));

					if(empty($send_method)) 
						$utype =  $this->base_model->getSelect("tbl_sendmethod")[0]->id;
					else{
						$utype = $send_method[0]->id;
					}										
					$temp= array(
				      'des'   => $des,
				      'name'    => $name,
				      'eng'  => $eng,
				      'person_num'   => $person_num,
				      'empty'  => $empty,
				      'phone'   => $phone,
				      'use_type'    => $utype,
				      'postcode'   => $postcode,
				      'address'  => $address,
				      'eng_address'   => $eng_address,
				      'req'    => $req,
				      'order_no'  => $order_no,
				      'pro_eng'   => $pro_eng,
				      'color'  => $color,
				      'size'   => $size,
				      'count'    => $count,
				      'unit'   => $unit,
				      'image'  => $image,
				      'pro_url'   => $pro_url,
				      'tracking'    => $tracking,
				      'spec'  => $spec,
				      'category'   => $category,
				      'parent_category'   => $parent_category
				    );
					$data[$id][] =$temp;
			    }
			    if($this->input->post("type") !=1){
					$types = 2;
					$state = 4;
				}
				else{
					$types = 1;
					$state = 1;
				}
			    foreach ($data as $key => $value) {
			    	try{
			    		$post_data=  array( "place" => $value[0]['des'],
								"incoming_method" =>$value[0]['use_type'],
								"billing_name"=> substr($value[0]['eng'],0 ,100),
								"billing_krname"=>substr($value[0]['name'], 0,100),
								"person_num" => 1,
								"person_unique_content" => $value[0]['person_num'],
								"phone_number" =>$value[0]['phone'],
								"post_number"=> $value[0]['postcode'],
								"address" => substr($value[0]['address'], 0,199),
								"detail_address" =>substr($value[0]['eng_address'], 0,199) ,
								"request_detail" => substr($value[0]['req'], 0,199),
								"logistics_request" =>substr($value[0]['spec'], 0,199),
								"type" => $types,
								"state" =>$state,
								"get"=>$this->input->post("type") !=1 ? "buy":"delivery",
								"userId"=>$this->session->userdata('fuser'),
								"created_date"=>date("Y-m-d H:i:s"),
								"updated_date"=>date("Y-m-d H:i:s"),
								"rid"=>generateRandomString(15));
						$insert_id = $this->base_model->insertArrayData("delivery",$post_data);
						if($insert_id > 0){
							$order = date("y").date("m").date("d").str_pad($insert_id, 4, '0', STR_PAD_LEFT);
							array_push($post_id, $order);
							$this->base_model->updateDataById($insert_id,array("ordernum"=>$order),"delivery","id");
							$this->base_model->insertArrayData("tbl_service_delivery",array("delivery_id"=>$insert_id,"content"=>"[]"));
							foreach ($value as $keyw => $valuew) {
								$new_key = $keyw +1;
								$pro_item = array( 			"delivery_id"=>$insert_id,
			                                                "trackingHeader"=>"기타",
			                                                "trackingNumber"=>$valuew["tracking"],
			                                                "order_number"=>$valuew["order_no"],
			                                                "parent_category"=>$valuew["parent_category"],
			                                                "category"=>$valuew["category"],
			                                                "productName"=>substr($valuew["pro_eng"], 0,199),
			                                                "unitPrice"=>$valuew["unit"],
			                                                "count"=>$valuew["count"],
			                                                "color"=>$valuew["color"],
			                                                "size"=>$valuew["size"],
			                                                "url"=>$valuew["pro_url"],
			                                                "image"=>$valuew["image"],
			                                                "step"=>0,
			                                                "created_date"=>date("Y-m-d H:i"),
			                                            	"serial"=>$order."-".$new_key);

								$this->base_model->insertArrayData("tbl_purchasedproduct",$pro_item);
							}
						}
						sleep(1);
						$this->session->set_userdata(array("wat"=>(float)($key+1)/sizeof($data)));
			    	}catch(Exception $e){
			    		if($insert_id > 0){
			    			$this->base_model->deleteRecordsById("delivery","id",$value);
    						$this->base_model->deleteRecordsById("tbl_purchasedproduct","delivery_id",$value);
			    		}
			    		$i = $key +1;
			    		array_push($erros, $value);
						echo json_encode(array("errorId"=>1,"message"=>$i."행에서 오류가 발생하였습니다.파일내용을 다시 확인해보세요"));
						return false;
			    	}
			    }
			    $this->session->set_userdata(array("wat"=>1));
			    echo json_encode(array("errorId"=>0,"post_id"=>implode(',', $post_id),"errors"=>$errors));
	        }	    
    	}
    	else{

    		echo json_encode(array("errorId"=>1,"message"=>"파일은 선택해주세요."));
    	}	
    }

    public function getPricesByRole(){
    	$this->isLoggedIn();

    	$data['delivery_address'] = $this->base_model->getSelect("delivery_address",	array(array("record"=>"use","value"=>1)));

    	if(!empty($this->input->get("option"))) 
    		$data['option']=$this->input->get("option");
    	
    	else
    		$data['option']=$data['delivery_address'][0]->id;
    	
    	$data['deli'] = $this->base_model->getSelect("tbl_deliverytable",	array(array("record"=>"address","value"=>$data['option'])),
    																		array(array("record"=>"startWeight","value"=>"ASC")));
    	$data['role'] = $this->base_model->getRoleByMember("yes",1);

    	$data['user'] = $this->base_model->getUserInfo($this->session->userdata('fuser'));
    	
    	$this->load->view("showDeli",$data);
    }

    public function registerContact(){
    	$del_id = $this->input->post("id");
	    	$data = array(	"postcode"=>$this->input->post("postcode"),
	    					"address"=>$this->input->post("address"),
	    					"details_address"=>$this->input->post("details"),
	    					"name"=>$this->input->post("name"),
	    					"eng_name"=>$this->input->post("eng_name"),
	    					"phone"=>$this->input->post("p1")."-".$this->input->post("p2")."-".$this->input->post("p3"),
	    					"type"=>$this->input->post("type"),
	    					"userId"=>$this->session->userdata('fuser'),
	    					"unique_info"=>$this->input->post("RRN_NO"));
    	if(!empty($del_id) && $del_id > 0 )  $result=$this->base_model->updateDataById($del_id,$data,"tbl_mycontact","id");
    	else{ $result =  $this->base_model->insertArrayData("tbl_mycontact",$data); }
    	echo '<script>self.close();</script>';
    }

    public function deleteContact(){
    	$this->isLoggedIn();
    	$id=  $this->input->post("id");
    	$this->base_model->deleteContactById($id);
    	echo 1;
    }

    public function getContact(){
    	$id = $this->input->post("id");
    	echo json_encode($this->base_model->getSelect("tbl_mycontact",	array(array("record"=>"id","value"=>$id))));
    }

    public function Pay_Sale(){
	    $aCpnCode = $this->input->get("aCpnCode");
	    $sCHA_SEQ = $this->input->get("sCHA_SEQ");
	    $price = $this->base_model->getPriceTotalByDel($sCHA_SEQ,$aCpnCode);
	   	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<input type="hidden" name="rPMT_MNY_'.$sCHA_SEQ.'" id="rPMT_MNY_'.$sCHA_SEQ.'" value="'.$price.'">';
	}

	public function exitMember(){

		if(empty($this->session->userdata('fuser')) || $this->session->userdata('fuser') == NULL){
			echo 101;
			return;
		}

		$this->base_model->updateDataById($this->session->userdata('fuser'),array("isDeleted"=>1),"tbl_users","userId");
		$this->session->sess_destroy ();
		echo 100;
		return;
	}

	public function User_MemAddr_S(){

		$contacts = $this->base_model->getSelect("tbl_mycontact",array(array("record"=>"userId","value"=>$this->session->userdata('fuser'))));
		$data['contacts'] = $contacts;
		$this->load->view("User_MemAddr_S",$data);
	}

	public function registerDeliveryAddr(){
		$this->load->view("registerDeliveryAddr",NULL);
	}

	public function editDeliveryAddr($id){
		$data['deliverys'] = $this->base_model->getSelect("tbl_mycontact",array(array("record"=>"id","value"=>$id)));
		$this->load->view("registerDeliveryAddr",$data);
	}

	public function viewDelivery($id){
		$this->isLoggedIn();
		$aa = array();
		$aa_value = array();
		$data['delivery'] = $this->base_model->getDeliveryS($id);
		if(empty($data['delivery']) || $data['delivery'][0]->id ==null){
			redirect("/");
			return;
		}
		$data['products'] = $this->base_model->getProductWithCategory($data['delivery'][0]->id);
		$data['fees'] = sizeof($this->base_model->getSelect("tbl_shipping_fee")) > 0 ? $this->base_model->getSelect("tbl_shipping_fee")[0]:"";
		$data['adding'] = $this->base_model->getSelect("tbl_add_price",array(array("record"=>"id","value"=>$data['delivery'][0]->id)));
		$services = $this->base_model->getServices(1);
		$data['service_header'] = $this->base_model->getSelect("tbl_service_header",array(array("record"=>"use","value"=>1)),
																			array(array("record"=>"id","value"=>"ASC")));
		foreach ($services as $key => $value) {
			if (!isset($aa[$value->part])) {
				$aa[$value->part] = array();
			}
			array_push($aa[$value->part], array("name"=>$value->name,"price"=>$value->price,"id"=>$value->id));
			$aa_value[$value->id] = $value->name;
		}
		$data['aa'] = $aa;
		$data['aa_value'] = $aa_value;
		$this->loadViews("viewDelivery",$this->global,$data,NULL);
	}

	public function getDproducts(){
		if($this->session->userdata("fuser") <=0) return;
		$delivery_id = $this->input->get("dp");
		$pds = $this->base_model->getProductWithType($delivery_id);
		$str="<td colspan='3'><table class='table table-bordered'>";
		if(sizeof($pds) > 0){
			foreach ($pds as $key => $value) {
				if($pds[0]->dtype ==3)
					$currency = "원";
				else
					$currency = "￥";
				$st= '';
				$tracks ='';
				if(trim($value->trackingNumber) != "" ) $tracks = $value->trackingHeader." ".$value->trackingNumber;
				if($value->step == 0 ) $st = '입고대기';
				if($value->step == 101 ) $st = '입고완료';
				if($value->step == 102 ) $st = '오류입고';
				if($value->step == 103 ) $st = '노데이타';
				$size = implode("<br>", explode(",", $value->size));
				$color = !empty($color) ?  "색상 : ".$color : "";
				if($key > 0):
				$str .="<tr>";
				$str .="<td colspan='2'></td>";
				$str .="</tr>";
				endif;
				$str.="<tr>";
				$str.="<th class='mid text-center' style='width:140px'>";
				$str.="번호";
				$str.="</th>";
				$str.="<td>";
				$str.=$value->serial;
				$str.="</td>";
				$str.="</tr>";
				$str.="<tr>";
				$str.="<th class='mid text-center' style='width:140px'>";
				$str.="상품이미지";
				$str.="</th>";
				$str.="<td>";
				$str.="<img src='".$value->image."' width='60' >";
				$str.="</td>";
				$str.="</tr>";
				$str.="<tr>";
				$str.="<th  class='mid text-center' style='width:140px'>";
				$str.="상품명(영문)";
				$str.="</th>";
				$str.="<td>";
				$str.=$value->productName;
				$str.="</td>";
				$str.="</tr>";
				$str.="<tr>";
				$str.="<th  class='mid text-center' style='width:140px'>";
				$str.="TrackingNumber<br>Order No";
				$str.="</th>";
				$str.="<td>";
				$str.=$tracks;
				$str.="<br>";
				$str.=$value->order_number;
				$str.= "<br>";
				$str.="<p >".$tracks."</p>";
				$str.="</td>";
				$str.="</tr>";

				$str.="<tr>";
				$str.="<th class='mid text-center' style='width:140px'>";
				$str.="상품입고";
				$str.="</th>";
				$str.="<td>";
				$str.=$st;
				$str.="</td>";
				$str.="</tr>";

				$str.="<tr>";
				$str.="<th class='mid  text-center' style='width:140px'>";
				$str.="옵션";
				$str.="</th>";
				$str.="<td>";
				$str.= $size.$color."<br>";
				$str.="</td>";
				$str.="</tr>";
				$str.="<tr>";
				$str.="<th class='mid  text-center' style='width:140px'>";
				$str.="단가(".$currency."),수량<br>합계";
				$str.="</th>";
				$str.="<td>";
				$str.=number_format($value->unitPrice,2)."*".$value->count."<br>".number_format($value->unitPrice*$value->count,2);
				$str.="</td>";
				$str.="</tr>";
			}
		}
		$str .="</table></td>";			
		echo $str;
	}

	function deletesO(){
		$did = explode("|", $this->input->post("did"));
		foreach ($did as $value) {
			if(is_numeric($did) || $did !=0){
				$step = $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$value)))[0]->state;
				if($step ==1 ||  $step ==2 | $step ==4){
					$this->base_model->deleteRecordsById("delivery","id",$value);
					$this->base_model->deleteRecordsById("tbl_purchasedproduct","delivery_id",$value);
				}
			}
		}
		redirect("/viewdeliveryState");
	}

	function editDelivery($id){
		$this->isLoggedIn();
		$aa = array();
		$aa_value = array();
		$delivery_address  = $this->base_model->getSelect("delivery_address",array(array("record"=>"use","value"=>1)));
		$tracking_header = $this->base_model->getSelect("tracking_header");
		$data = array(
			'delivery_address' =>$delivery_address,
			'tracking_header' =>$tracking_header
		);
		$data['fees'] = sizeof($this->base_model->getSelect("tbl_shipping_fee")) > 0 ? $this->base_model->getSelect("tbl_shipping_fee")[0]:"";
		$data['delivery']  = $this->base_model->getDeliveryByService($id);
		if(empty($data['delivery']))
		{
			redirect("/");
			return;
		}
		$data['products'] = $this->base_model->getSelect("tbl_purchasedproduct",array(array("record"=>"delivery_id","value"=>$data['delivery'][0]->id)),array(array("record"=>"updated_date","value"=>"ASC")));
		if(sizeof($data['products']))
		{
			$category = $this->base_model->getSelect("tbl_category",array(array("record"=>"parent","value"=>0)));
			foreach($data['products'] as  $key => $value) {
				$chca = $value->category;
				if(is_numeric($chca)){
					$pid = !empty($this->base_model->getSelect("tbl_category",array(array("record"=>"id","value"=>$chca)))) ? 
					$this->base_model->getSelect("tbl_category",array(array("record"=>"id","value"=>$chca)))[0]->parent:1;
					if(is_numeric($pid)){
						$category_ch = $this->base_model->getSelect("tbl_category",array(array("record"=>"parent","value"=>$pid)));
					}
					else{
						$category_ch = $this->base_model->getSelect("tbl_category",array(array("record"=>"parent","value"=>$category[0]->id)));
					}
				}
				$data['category_ch'.$value->id] = $category_ch;
				$data['pid'.$value->id] = $pid;
			}
		}
		$data['categorys'] = $category;
		$data['sum_price'] = $this->base_model->getPSum($data['delivery'][0]->id);
		$data['sends'] = $this->base_model->getSelect("tbl_sendmethod");
		$services = $this->base_model->getServices(1);
		$data['service_header'] = $this->base_model->getSelect("tbl_service_header",array(array("record"=>"use","value"=>1)),
																			array(array("record"=>"id","value"=>"ASC")));
		foreach ($services as $key => $value) {
			if (!isset($aa[$value->part])) {
				$aa[$value->part] = array();
			}
			array_push($aa[$value->part], array("name"=>$value->name,"price"=>$value->price,"id"=>$value->id,"description"=>$value->description));
			$aa_value[$value->id] = $value->name;
		}
		$data['aa'] = $aa;
		$data['aa_value'] = $aa_value;
		$type = $data['delivery'][0]->get;
		if($type != "buy")	
			$data["pp"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'4')));
		if($type == "buy")
			$data["pp"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'5')));
		$this->loadViews("editDelivery",$this->global,$data,NULL);
	}

	public function updateDeliver(){
		$this->isLoggedIn();
		$id= $this->input->post("id");
		$aa = array();
		$vv = $this->base_model->getSelect("tbl_services");
		$pid = explode(",", $this->input->post("pid"));
		$theader = json_decode($this->input->post("theader")); /// products
		$CTR_SEQ = $this->input->post("CTR_SEQ");
		$REG_TY_CD = $this->input->post("REG_TY_CD");
		$ADRS_KR = $this->input->post("ADRS_KR");
		$ADRS_EN = $this->input->post("ADRS_EN");
		$RRN_CD = $this->input->post("RRN_CD");
		$RRN_NO = $this->input->post("RRN_NO");
		$MOB_NO1 = $this->input->post("MOB_NO1");
		$MOB_NO2 = $this->input->post("MOB_NO2");
		$MOB_NO3 = $this->input->post("MOB_NO3");
		$ZIP = $this->input->post("ZIP");
		$ADDR_1 = $this->input->post("ADDR_1");
		$ADDR_2 = $this->input->post("ADDR_2");
		$REQ_1 = $this->input->post("REQ_1");
		$REQ_2 = $this->input->post("REQ_2");
		$waiting = $this->input->post("waiting");
		$options =  $this->input->post("type_options");
		$fees = explode(",", $this->input->post("fees"));
		foreach ($vv as $key => $value) {
			if(in_array($value->id, $fees)){
				$aa[$value->id] = $value->price;
			}
			
		}

		if($options =="buy"){
			$types = 2;
			$state = 4;
		}
		else{
			$types = 1;
			if($waiting ==1 ){
				$state = 1;
			}
			else{
				$state = 2;
			}
		}
		
		$deliver = $this->input->post("deliver");
		$delivery_content  = $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$id)));
		$post_data=  array( 
							"state" => $state,	
							"place" => $CTR_SEQ,
							"incoming_method" =>$REG_TY_CD,
							"billing_name"=> $ADRS_EN,
							"billing_krname"=>$ADRS_KR,
							"person_num" => $RRN_CD,
							"person_unique_content" => $RRN_NO,
							"phone_number" =>$MOB_NO1."-".$MOB_NO2."-".$MOB_NO3,
							"post_number"=> $ZIP,
							"address" => $ADDR_1,
							"detail_address" => $ADDR_2,
							"request_detail" => $REQ_1,
							"logistics_request" =>$REQ_2,
							"updated_date"=>date("Y-m-d H:i:s"));
		$adds  = $this->base_model->getSelect("tbl_delivery_addprice");
			foreach($adds as $adds_chd){
				if(strpos($ADDR_1,$adds_chd->address) !==false){
					$aa[54] = $adds_chd->price;
					break;
				}
			}
		$this->base_model->updateDataById($id,array("content"=>json_encode($aa)),
			"tbl_service_delivery","delivery_id");
		$this->base_model->updateDataById($id,$post_data,"delivery","id");
		// $this->base_model->deleteRecordsById("tbl_purchasedproduct","delivery_id",$id);
		$this->base_model->insertPurchase($theader,$id,$delivery_content[0]->ordernum,$pid);
		echo $id;
	}

	public function addBasket(){
		$this->isLoggedIn();
		$id = $this->input->post("id");
		$pp = $this->base_model->getSelect("tbl_sproducts",array(array("record"=>"id","value"=>$id)));
		if(sizeof($pp) ==0) {redirect("shopping");return;}
		$pp_options = $this->base_model->getSelect("tbl_options",array(array("record"=>"product_id","value"=>$id)));
		if(!empty($pp_options)  || !empty($pp_options)){
			echo 103;
			return;
		}		
		$bp = $this->base_model->getSelect("tbl_basket",array(	array("record"=>"userId","value"=>$this->session->userdata('fuser')),
																array("record"=>"productId","value"=>$id)));
		if(sizeof($bp) > 0){
			$this->base_model->incBasket($id);
		}
		else{
			$this->base_model->insertArrayData("tbl_basket",array("count"=>1,"userId"=>$this->session->userdata('fuser'),"productId"=>$id));
		}

		echo 102;
	}


	public function mybasket(){
		echo "<script>alert('업데이트중입니다.');location.href='/';</script>";
		return;
		$this->isLoggedIn();
		$address_rate = $this->base_model->getRoleByMember("yes",1);
		$weights_sky=array();
		$weights_sea=array();
		$sky = 1;
		$sea = 1;
		$data['mybasket_sea'] = sizeof($this->base_model->getBasket(null,"sea"));
		$data['mybasket_sky'] = sizeof($this->base_model->getBasket(null,"sky"));
		$data['by_delivery'] = getSiteInfo()->s_delprice_free;
		$data['s_delprice'] = getSiteInfo()->s_delprice;
		$s_ss = $this->base_model->getSelect("tbl_deliverytable",array( array("record"=>"address","value"=>"1")));
		$happened_adds = false;
		if(!empty($s_ss)){
			$startWeight=0;
	        $start1= 0;
	        $start2=0;
	        $startPrice = 0;
	        foreach($s_ss as $value):
	            $start1 = $value->startWeight;
	            $start2 = $value->endWeight;  
	            $startPrice = $value->startPrice;
	            while($start1<=$start2){    
	                array_push($weights_sea,array("weight"=>$start1,"price"=>$startPrice));
	                $start1 = $start1 + $value->weight;
	                $startPrice = $startPrice + $value->goldSpace;
	            } 
	        endforeach;
		}

		$s_ss = $this->base_model->getSelect("tbl_deliverytable",array( array("record"=>"address","value"=>"2")));
		if(!empty($s_ss)){
			$startWeight=0;
	        $start1= 0;
	        $start2=0;
	        $startPrice = 0;
	        foreach($s_ss as $value):
	            $start1 = $value->startWeight;
	            $start2 = $value->endWeight;  
	            $startPrice = $value->startPrice;
	            while($start1<=$start2){    
	                array_push($weights_sky,array("weight"=>$start1,"price"=>$startPrice));
	                $start1 = $start1 + $value->weight;
	                $startPrice = $startPrice + $value->goldSpace;
	            } 
	        endforeach;
		}

		if(!empty($address_rate)){
			$a_rate = json_decode($address_rate[0]->address_rate,true);
			if(!empty($a_rate))
			{
				if(!empty($a_rate[1]))
				{
					$sea = $a_rate[1];
				}
				if(!empty($a_rate[2]))
				{
					$sky = $a_rate[2];
				}
			}	
		}
		$data["weights_sea"] = json_encode($weights_sea);
		$data["weights_sky"] = json_encode($weights_sky);
		$data["sea"] = $sea;
		$data["sky"] = $sky;
		$this->loadViews("mybasket",$this->global,$data,NULL);
	}

	public function makeorder(){

		$data = $this->input->post();
		$t = array("sea","sky");
		$happened_adds = false;
		$post_id = array();
		if(empty($this->session->userdata("fuser"))){
			echo json_encode(array("status"=>"login_error","message"=>"로그인이후 이용하실수 있습니다."));
			return;
		}

		if(empty($data["basket_sea"]) && empty($data["basket_sky"])){
			echo json_encode(array("status"=>"error","message"=>"최소 한개이상의 상품을 선택해주세요."));
			return;
		}

		foreach($t as $key => $value){
			$weight = 0;
			$delivery_price = 0;
			$price = 0;
			$all_delivery = 0;
			$delivery_weight = 0;
			$free_price = 0;
			if(empty($data["basket_".$value])) continue;
			$aa = array();
			$baskets_data = $this->base_model->getBasket($data["basket_".$value]);
			$basket_id  = array();
			foreach($baskets_data as $key_bakset => $value_basket)
			{
				$weight +=$value_basket->weight;
				$price 	+=$value_basket->price * $value_basket->count;
				if($value_basket->p_shoppingpay_use ==0){
					$delivery_price +=$value_basket->delivery_price;
					$free_price +=$delivery_price;
				}				
			}

			$pw = $this->getPriceFromWeight($weight,1);

			if($value =="sea"){
				$delivery_weight = $pw[0]["weight"];
				$delivery_price += $pw[0]["price"];
			}

			if($value =="sky"){
				$delivery_weight = $pw[1]["weight"];
				$delivery_price += $pw[1]["price"];
			}

			$adds  = $this->base_model->getSelect("tbl_delivery_addprice");
			foreach($adds as $adds_chd){
				if(strpos($data["ADDR_1"],$adds_chd->address) !==false){
					$aa[54] = $adds_chd->price;
					$all_delivery = $adds_chd->price;
					$happened_adds = true;
					break;
				}
			}

			$all_delivery +=$delivery_price;
			
			$post_data=  array( "place" => $key + 1,
							"incoming_method" =>3,
							"billing_name"=> $data["ADRS_EN"],
							"billing_krname"=>$data["ADRS_KR"],
							"person_num" => 1,
							"person_unique_content" => $data["RRN_NO"],
							"phone_number" =>$data["MOB_NO1"]."-".$data["MOB_NO2"]."-".$data["MOB_NO3"],
							"post_number"=> $data["ZIP"],
							"address" => $data["ADDR_1"],
							"detail_address" => $data["ADDR_2"],
							"request_detail" => $data["REQ_1"],
							"type" => 3,
							"state" =>5,
							"get"=>"buy",
							"shop"=>1,
							"userId"=>$this->session->userdata('fuser'),
							"created_date"=>date("Y-m-d H:i:s"),
							"rid"=>generateRandomString(15),
							"sending_price"=>$all_delivery,
							"purchase_price"=>$price,
							"rid"=>generateRandomString(15),
							"real_weight"=>$weight,
							"pur_fee"=>"0|".$price."|1",
							"sends" =>$delivery_price,
							"mem_wt"=>$delivery_weight,
							"free_price" =>$free_price);

			$insert_id = $this->base_model->insertArrayData("delivery",$post_data);
			if($insert_id > 0){
				$this->base_model->insertArrayData("tbl_service_delivery",array("content"=>json_encode($aa),"delivery_id"=>$insert_id));
				$ordernum = date("y").date("m").date("d").str_pad($insert_id, 4, '0', STR_PAD_LEFT);
				array_push($post_id,$ordernum);
				$this->base_model->updateDataById($insert_id, array('ordernum' => $ordernum),"delivery","id");
				foreach($baskets_data as $key_bakset => $value_basket){
					$in_parent = 1;
					$in_ch = 65;
					$category_name = $value_basket->category;
					$category_child = $this->base_model->getSelect("tbl_category",array(	array("record"=>"name","value"=>$category_name),
																							array("record"=>"parent >","value"=>0)));
					if(!empty($category_child)){
						$in_ch = $category_child[0]->id;
						$in_parent = $category_child[0]->parent;
					}
					$key_bakset = $key_bakset+1;
					$pro_item = array( 	"delivery_id"=>$insert_id,
                                    "trackingHeader"=>"기타",
                                    "parent_category"=>$in_parent,
                                    "category"=>$in_ch,
                                    "productName"=>$value_basket->name,
                                    "unitPrice"=>$value_basket->price,
                                    "count"=>$value_basket->count,
                                    "color"=>$value_basket->color,
                                    "size"=>$value_basket->size,
                                    "url"=>"/view/shop_products/".$value_basket->rid,
                                    "image"=>"/upload/shoppingmal/".$value_basket->productId."/".$value_basket->image,
                                    "step"=>0,
                                    "created_date"=>date("Y-m-d H:i"),
                                	"serial"=>$ordernum."-".$key_bakset,
                                	"shop"=>$value_basket->productId,
                                	"add_options"=>$value_basket->add_options
                                	);
					$this->base_model->insertArrayData("tbl_purchasedproduct",$pro_item);
				}
			}
		}

		if(sizeof($post_id) > 0){
			if(!empty($data["basket_sea"]))
				$this->base_model->deleteRecordsById("tbl_basket","id",$data["basket_sea"]);
			if(!empty($data["basket_sky"]))
				$this->base_model->deleteRecordsById("tbl_basket","id",$data["basket_sky"]);	
			echo json_encode(array("status"=>"success","post_id"=>implode(",",$post_id),"message"=>"구매신청이 완료되였습니다.","happened_adds"=>$happened_adds));
		}
		else
		{
			echo json_encode(array("status"=>"error","message"=>"상품들이 추가되지 않았습니다.\n다시 시도하세요."));
		}
	}

	public function shop_products($id){
		$weights_sky=array();
		$weights_sea=array();
		$data["sea"]  = $data["sky"] = 0 ;
		$data["price_weights"] = NULL;
		$data['accuringRate'] = $this->base_model->getSelect("tbl_accurrate",null,array(array("record"=>"created_date","value"=>"DESC")))[0];
		$data['product'] = $this->base_model->getSelect("tbl_sproducts",array(array("record"=>"rid","value"=>$id)));
		if(empty($data['product'])) return;
		$add_options = $this->base_model->getSelect("tbl_product_option",	array(	array("record"=>"pcode","value"=>$id),
																			array("record"=>"view","value"=>"Y")),
																					array(array("record"=>"sort","value"=>"ASC")));
		$options_arr = array();
		$second_arr = array();
		foreach($add_options as $key=>$value){
			if($value->parent ==0){
				array_push($options_arr, $value);
			}
			else{
				if(!isset($second_arr[$value->parent]))
					$second_arr[$value->parent] = array();
				array_push($second_arr[$value->parent], $value);
			}
		}
		$data['siteInfo'] = getSiteInfo();
		$delivery_price = array();
		if($data['product'][0]->p_shoppingpay_use ==0 && $data['product'][0]->singo < $data['siteInfo']->s_delprice_free)
			$delivery_price[0] = $data['siteInfo']->s_delprice;
		if($data['product'][0]->p_shoppingpay_use ==2)
			$delivery_price[0] = 0;
		if($data['product'][0]->p_shoppingpay_use ==1)
		{
			$pw = $this->getPriceFromWeight($data['product'][0]->weight,1,true);
			$delivery_price[0] = $pw[0]["price"];
			$delivery_price[1] = $pw[1]["price"];
			$data["sea"] = $pw[0]["rate"];
			$data["sky"] = $pw[1]["rate"];
			if(!empty($pw[2])){
				$startWeight=0;
		        $start1= 0;
		        $start2=0;
		        $startPrice = 0;
		        foreach($pw[2] as $value):
		            $start1 = $value->startWeight;
		            $start2 = $value->endWeight;  
		            $startPrice = $value->startPrice;
		            while($start1<=$start2){    
		                array_push($weights_sea,array("weight"=>$start1,"price"=>$startPrice));
		                $start1 = $start1 + $value->weight;
		                $startPrice = $startPrice + $value->goldSpace;
		            } 
		        endforeach;
			}
			if(!empty($pw[3])){
				$startWeight=0;
		        $start1= 0;
		        $start2=0;
		        $startPrice = 0;
		        foreach($pw[3] as $value):
		            $start1 = $value->startWeight;
		            $start2 = $value->endWeight;  
		            $startPrice = $value->startPrice;
		            while($start1<=$start2){    
		                array_push($weights_sky,array("weight"=>$start1,"price"=>$startPrice));
		                $start1 = $start1 + $value->weight;
		                $startPrice = $startPrice + $value->goldSpace;
		            } 
		        endforeach;
			}
		}
		
		$data["delivery_price"] = $delivery_price;
		$data["weights_sea"] = json_encode($weights_sea);
		$data["weights_sky"] = json_encode($weights_sky);
		$data["add_options"] = $options_arr;
		$data["second_arr"] = $second_arr;
		$data['category'] = $this->base_model->getCategoryBySh();
		$data['recommentProducts'] = $this->base_model->getRecommendProducts($data['product'][0]->id,$data['product'][0]->category);
		$data["review"] = $this->base_model->getReivew($id);
		$data['qna'] = $this->base_model->getQna($id);
		$data['wish'] = sizeof($this->base_model->getSelect("tbl_product_wish",array(	array("record"=>"pcode","value"=>$data["product"][0]->rid),
																				array("record"=>"userId","value"=>$this->session->userdata('fuser')))));
		$this->global["fb_shared"] = 1;
		$this->global["og_url"] = base_url_home()."view/shop_products/".$data["product"][0]->rid;
		$this->global["og_type"] = "website";
		$this->global["og_title"] = $data["product"][0]->name;
		$this->global["og_image"] = base_url_home()."upload/shoppingmal/".$data["product"][0]->id."/".$data["product"][0]->image;
		$this->base_model->plusValue("tbl_sproducts","view",1,array(array("rid",$id)),"+");
		$this->loadViews('shop_products',$this->global,$data,NULL);
	}

	public function addCar(){
		$this->isLoggedIn();
		$bp = array();
		$id = $this->input->post("id");
		$color = $this->input->post("color");
		$size = $this->input->post("size");
		$pp = $this->base_model->getSelect("tbl_sproducts",array(array("record"=>"id","value"=>$id)));
		if(sizeof($pp) ==0) {echo 2;return;}
		$add_option = $this->base_model->getSelect("tbl_options",array(array("record"=>"product_id","value"=>$id)));
		$c = 0;
		$s = 0;
		if(!empty($add_option))
			foreach ($add_option as $key => $value) {
				if($value->name == "칼러" || $value->name == "칼라")
					$c =1;
				if($value->name =="크기" || $value->name =="사이즈")
					$s = 1;
			}
		if(!empty($add_option) && ( ( empty($color) && $c==1 ) || ( empty($size) && $s ==1 )  )  ){
			{echo 3;return;}
		}
		$bp = $this->base_model->getSelect("tbl_basket",array(	array("record"=>"userId","value"=>$this->session->userdata('fuser')),
																array("record"=>"productId","value"=>$id),
																array("record"=>"color","value"=>$color),
																array("record"=>"size","value"=>$size)));
		if(sizeof($bp) > 0){
			// $this->base_model->plusValue("tbl_basket","count",$this->input->post("count"),array(array("id",$bp[0]->id)),"+");
			echo 5;
			return;
		}
		else{
			$this->base_model->insertArrayData("tbl_basket",array("count"=>$this->input->post("count"),"userId"=>$this->session->userdata('fuser'),"productId"=>$id,"size"=>$size,"color"=>$color));
		}
		echo 1;
	}

	public function deleteDeposit(){
		if(empty($this->session->userdata('fuser')) || $this->session->userdata('fuser') <=0) echo json_encode(array("status"=>false));
		$id = $this->input->post("id");
		$this->base_model->deleteRecordsById("tbl_request_deposit","id",$id);
		echo json_encode(array("status"=>true));
	}

	public function deposit_history(){
		$this->isLoggedIn();
		$from =	$this->input->get("from");
		$to   =	$this->input->get("to");
		$this->load->library('pagination');
		$records_count = sizeof($this->base_model->getDepositHistory(null,null,$from,$to));
		$returns = $this->paginationCompress ( "deposit_history/", $records_count, 10);
		$data['history']= $this->base_model->getDepositHistory($returns["segment"],$returns["page"],$from,$to);
		$this->loadViews('deposit_history',$this->global,$data,NULL);
	}

	public function coupon_list(){
		$this->isLoggedIn();
		$this->load->library('pagination');
		$records_count = sizeof($this->base_model->getUsedCoupon());
		$returns = $this->paginationCompress ( "coupon_list/", $records_count, 10);
		$data['coupon_list'] = $this->base_model->getUsedCoupon($returns["page"] ,$returns["segment"]);
		$data['ac'] = $records_count;
    	$data['cc'] = $returns["segment"];
		$this->loadViews('coupon_list',$this->global,$data,NULL);
	}

	public function deposit_return(){
		$this->isLoggedIn();
		$data['deposits_return'] = $this->base_model->getSelect("tbl_deposit_return",array(array("record"=>"userId","value"=>$this->session->userdata('fuser'))),
																						array(array("record"=>"updated_date","value"=>"DESC")));
		$this->loadViews('deposit_return',$this->global,$data,NULL);	
	}

	public function returntDeposit(){
		$this->isLoggedIn();
		$user_deposit = $this->global['user'];
		if(sizeof($user_deposit) == 0){redirect("deposit_return");return;}
		$amount = $this->input->post("MNY");
		$owner = $this->input->post("OWNER");
		if($amount > $user_deposit[0]->deposit) {redirect("deposit_return");return;}
		$bank_name = $this->input->post("PYN_NM");
		$bank_number = $this->input->post("PYN_NUMBER");
		$this->base_model->insertArrayData("tbl_deposit_return", array(	"userId"=>$this->session->userdata('fuser'),
																		"amount"=>$amount,
																		"bank_name"=>$bank_name,
																		"bank_number"=>$bank_number,
																		"accept"=>0,
																		"owner"=>$owner,
																		"created_date"=>date("Y-m-d")));
		$this->base_model->plusValue("tbl_users","deposit",$amount,array(array("userId",$this->session->userdata('fuser'))),"-");
		$this->session->set_userdata('fdeposit',  $user_deposit[0]->deposit-$amount);
		redirect("deposit_return");
	}

	public function refuseDeposit(){
		$this->isLoggedIn();
		$deposit_id = $this->input->post("deposit_id");
		$deposit = $this->base_model->getSelect("tbl_deposit_return",array(array("record"=>"id","value"=>$deposit_id)));
		if(sizeof($deposit) == 0) {echo json_encode(array("status"=>0));return;}
		$accept = $deposit[0]->accept;
		if($accept == 0) {
			$this->base_model->plusValue("tbl_users","deposit",$deposit[0]->amount,array(array("userId",$this->session->userdata('fuser'))),"+");
			$this->session->set_userdata('fdeposit',  $this->session->userdata('fdeposit')+$deposit[0]->amount);
		}
		$this->base_model->deleteRecordsById("tbl_deposit_return","id",$deposit_id);
		echo json_encode(array("status"=>true));
	}

	public function getDelivery(){
		$str = "";
		$ar = array();
		$ff = array();
		$my = $this->input->post("my");
		$delivery_id = $this->input->post("delivery_id");
		$content = $this->base_model->getDeliverContent(10,0,$delivery_id);
		$str = "";
		$fee = $this->base_model->getSelect("tbl_services");
		foreach($fee as $v){
			$ff[$v->id] = $v->name;
		}
		if(sizeof($content) > 0){
			foreach ($content as $key => $value) {
				if(!empty($value->content))
				{
					$ar = json_decode($value->content,true);
				}
				$str.='<div class="box-body table-responsive">';
				$str.='<table class="table table-hover">';
				$weight =  "";
				if($value->addid ==3)
					$weight = "CBM";
				else $weight = "kg";
				if(!empty($value->state) && $value->state=="14" || $value->type==3):
					if($value->sending_price !=0 )
						$str.='<tr>
								<th class="breaken"><span class="bold red1">총 배송비용</span></th>
								<td class="tBg"><span class="bold text-danger">'.$value->sending_price.' 원</span></td>
							</tr>';
					if($value->real_weight > 0 || $value->vlm_wt > 0):
						$str.='<tr>
								<th class="breaken"><span class="bold">&nbsp;&nbsp;-실측무게</span></th>
								<td><span class="bold">'.$value->real_weight.'</span>'.$weight.'</td>
							</tr>';
						$str.='<tr>
								<th class="breaken"><span class="bold text-danger">&nbsp;&nbsp;-적용무게</span></th>
								<td><span class="bold text-danger">'.$value->mem_wt.'</span>'.$weight.'</td>
							</tr>';	
					endif;
					$str.='<tr>
							<th class="breaken">&nbsp;&nbsp;-배송비</th>
							<td>
							'.number_format($value->sends).'원
							</td>
						</tr>';
					if(!empty($ar)):
						foreach($ar as $key_ar=>$ar_ch):
							if(!isset($ff[$key_ar])) continue;
							$str.='<tr>
									<th class="breaken">&nbsp;&nbsp;-'.$ff[$key_ar].'</th>
									<td>
									'.number_format($ar_ch).'원
									</td>
								</tr>';
						endforeach;
					endif;	
					
				endif;
				if(!empty($value->state) && $value->state=="20"):
					$str.='<tr>
								<th class="breaken"><span class="bold red1">리턴비용</span></th>
								<td><span class="bold text-danger">'.$value->return_price.'원</span></td>
							</tr>';
					if(str_replace(",","",$value->rfee) > 0 ):
						$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-리턴 수수료</th>
								<td>
								'.$value->rfee.'원
								</td>
							</tr>';	
					endif;
					$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-리턴 금액</th>
								<td>
								'.number_format(((int)str_replace(",","",$value->return_price)-(int)str_replace(",","",$value->rfee))).'원
								</td>
							</tr>';
					
				endif;
				if(!empty($value->state) && $value->state=="5"):
					$str.='<tr>
								<th class="breaken"><span class="bold red1">구매비용</span></th>
								<td><span class="bold text-danger">'.number_format(str_replace(",", "", $value->purchase_price)).'원</span></td>
							</tr>';
					$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-구매비</th>
								<td>
								'.number_format(explode("|",$value->pur_fee)[1]).'원
								</td>
							</tr>';	
						$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-구매수수료</th>
								<td>
								'.number_format(explode("|",$value->pur_fee)[1]*((explode("|",$value->pur_fee)[0])/100)).'원
								</td>
							</tr>';		
					if(str_replace(",","",$value->cur_send) > 0 ):
						$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-현지배송비</th>
								<td>
								'.number_format(str_replace(",","", $value->cur_send)*explode("|",$value->pur_fee)[2]).'원
								</td>
							</tr>';	
					endif;
					
				endif;
				if(empty($value->state) ||  !empty($value->add_check) && $value->add_check==1):
					$str.='<tr>
								<th class="breaken">추가결제금액</th>
								<td class="bold text-danger">
								'.number_format($value->add_price).'원
								</td>
							</tr>';	
					if($value->agwan > 0 ):
						$str.='<tr>
								<th class="breaken">관부가세</th>
								<td>
								'.number_format($value->agwan).'원
								</td>
							</tr>';	
					endif;
					if($value->apegi > 0 ):
						$str.='<tr>
								<th class="breaken">페기수수료</th>
								<td>
								'.number_format($value->apegi).'원
								</td>
							</tr>';	
					endif;
					if($value->acart_bunhal > 0 ):
						$str.='<tr>
								<th class="breaken">카툰분할 수 신고/BL 분할</th>
								<td>
								'.number_format($value->acart_bunhal).'원
								</td>
							</tr>';	
					endif;
					if($value->acheck_custom > 0 ):
						$str.='<tr>
								<th class="breaken">검역수수료</th>
								<td>
								'.number_format($value->acheck_custom).'원
								</td>
							</tr>';	
					endif;
					if($value->agwatae > 0 ):
						$str.='<tr>
								<th class="breaken">과태료</th>
								<td>
								'.number_format($value->agwatae).'원
								</td>
							</tr>';	
					endif;
					if($value->v_weight > 0 ):
						$str.='<tr>
								<th class="breaken">부피무게</th>
								<td>
								'.number_format($value->v_weight).'원
								</td>
							</tr>';	
					endif;
					if($value->add_fee > 0 ):
						$str.='<tr>
								<th class="breaken">기타 추가비용</th>
								<td>
								'.number_format($value->add_fee).'원
								</td>
							</tr>';	
					endif;
				endif;
				$str.='</table>';
				$str.='</div>';
			}

		}
		echo $str;
	}

	public function getTotalDelivery(){
		$my = $this->input->post("my");
		$delivery_id = $this->input->post("delivery_id");
		$content = $this->base_model->getDeliverContent(10,0,$delivery_id);
		$fee = $this->base_model->getSelect("tbl_services");
		$ar = array();
		$ff = array();
		foreach($fee as $v){
			$ff[$v->id] = $v->name;
		}
		$str = "";
		if(sizeof($content) > 0){
			$str='<div class="box-body table-responsive no-padding">';
			$str.='<table class="table table-hover">';
			foreach ($content as $key => $value) {
				$weight =  "";
				if($value->addid ==3)
					$weight = "CBM";
				else $weight = "kg";
				if($value->sending_price > 0):
					if(!empty($value->content))
					{
						$ar = json_decode($value->content,true);
					}
					if($value->real_weight > 0 || $value->vlm_wt > 0):
						if($value->sending_price ==0) continue;

					$str.='<tr>
							<th class="breaken"><span class="bold red1">총 배송비용</span></th>
							<td class="tBg"><span class="bold text-danger">'.$value->sending_price.' 원</span></td>
						</tr>';
					$str.='<tr>
							<th class="breaken"><span class="bold">&nbsp;&nbsp;-실측무게</span></th>
							<td><span class="bold">'.$value->real_weight.'</span>'.$weight.'</td>
						</tr>';
					$str.='<tr>
								<th class="breaken"><span class="bold text-danger">&nbsp;&nbsp;-적용무게</span></th>
								<td><span class="bold text-danger">'.$value->mem_wt.'</span>'.$weight.'</td>
							</tr>';	
					endif;
					$str.='<tr>
							<th class="breaken">&nbsp;&nbsp;-배송비</th>
							<td>
							'.$value->sends.'원
							</td>
						</tr>';
					if(!empty($ar)):
						foreach($ar as $key_ar=>$ar_ch):
							if(!isset($ff[$key_ar])) continue;
							$str.='<tr>
									<th class="breaken">'.$ff[$key_ar].'</th>
									<td>
									'.number_format($ar_ch).'원
									</td>
								</tr>';
						endforeach;
					endif;
					
				endif;
				if(str_replace(",", "", $value->purchase_price)>0):
						$str.='<tr>
							<th class="breaken"><span class="bold red1">구매비용</span></th>
							<td><span class="bold text-danger">'.number_format(str_replace(",", "", $value->purchase_price)).'원</span></td>
						</tr>';
						$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-구매비</th>
								<td>
								'.number_format(explode("|",$value->pur_fee)[1]).'
								</td>
							</tr>';	
						$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-구매수수료</th>
								<td>
								'.explode("|",$value->pur_fee)[1]*((explode("|",$value->pur_fee)[0])/100).'원
								</td>
							</tr>';		
					if(str_replace(",","",$value->cur_send) > 0 ):
						$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-현지배송비</th>
								<td>
								'.str_replace(",","", $value->cur_send)*explode("|",$value->pur_fee)[2].'원
								</td>
							</tr>';	
					endif;
					
				endif;
				if($value->return_price > 0):
					$str.='<tr>
								<th class="breaken"><span class="bold red1">리턴비용</span></th>
								<td><span class="bold text-danger">'.$value->return_price.'원</span></td>
							</tr>';
					if(str_replace(",","",$value->rfee) > 0 ):
						$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-리턴 수수료</th>
								<td>
								'.$value->rfee.'원
								</td>
							</tr>';	
					endif;
					$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-리턴 금액</th>
								<td>
								'.((int)str_replace(",","",$value->return_price)-(int)str_replace(",","",$value->rfee)).'원
								</td>
							</tr>';
					
				endif;

				if($value->add_price > 0):
					$str.='<tr>
								<th class="breaken">추가결제금액</th>
								<td class="bold text-danger">
								'.number_format($value->add_price).'원
								</td>
							</tr>';	
					if($value->agwan > 0 ):
						$str.='<tr>
								<th class="breaken">관부가세</th>
								<td>
								'.number_format($value->agwan).'원
								</td>
							</tr>';	
					endif;
					if($value->apegi > 0 ):
						$str.='<tr>
								<th class="breaken">페기수수료</th>
								<td>
								'.number_format($value->apegi).'원
								</td>
							</tr>';	
					endif;
					if($value->acart_bunhal > 0 ):
						$str.='<tr>
								<th class="breaken">카툰분할 수 신고/BL 분할</th>
								<td>
								'.number_format($value->acart_bunhal).'원
								</td>
							</tr>';	
					endif;
					if($value->acheck_custom > 0 ):
						$str.='<tr>
								<th class="breaken">검역수수료</th>
								<td>
								'.number_format($value->acheck_custom).'원
								</td>
							</tr>';	
					endif;
					if($value->agwatae > 0 ):
						$str.='<tr>
								<th class="breaken">과태료</th>
								<td>
								'.number_format($value->agwatae).'원
								</td>
							</tr>';	
					endif;
					if($value->v_weight > 0 ):
						$str.='<tr>
								<th class="breaken">부피무게</th>
								<td>
								'.number_format($value->v_weight).'원
								</td>
							</tr>';	
					endif;

					if($value->add_fee > 0 ):
						$str.='<tr>
								<th class="breaken">기타 추가비용</th>
								<td>
								'.number_format($value->add_fee).'원
								</td>
							</tr>';	
					endif;
					
				endif;
				
			}

			$str.='</table>';
			$str.='</div>';

		}
		echo $str;
	}

	public function activeCombine(){
		$data['error'] = -1;
		$data['child'] = array();
		$mode = '';
		if(!empty($_GET['mode']) && $_GET['mode'] !="") $mode = $_GET['mode'];
		else $mode = "plus";
		$data['mode'] = $mode;
		$sOrdSeq = $this->input->get("sOrdSeq");
		if(empty($sOrdSeq)) return;
		$data['delivery'] = $this->base_model->getDeliveryAvailableCombine($sOrdSeq);
		if(sizeof($data['delivery'])==0) $data['error'] = "입고완료된 상품들이 없거나 수치인정보가 서로 다릅니다.";
		else if($mode!="minus") 
			$data['child'] = $this->base_model->getDeliveryAvailableCombine($sOrdSeq,$data['delivery'][0]->address,$data['delivery'][0]->place,2); 
		if(sizeof($data['child']) ==0) $data['error'] = "입고완료된 상품들이 없거나 수치인정보가 서로 다릅니다.";
		$this->load->view('activeCombine',$data);
	}

	public function ActingPlus_I(){
		$del_arr = array();
		$new_service = array();
		$delivery_id = $this->input->post("orders");
		$chkORD_SEQ = $this->input->post("chkORD_SEQ");
		if(sizeof($chkORD_SEQ) < 2 ) {echo "<script>alert('한개 상품은 불가합니다.나눔배송으로 해주세요');self.close()</script>";return;}
		if(empty($delivery_id)) {echo "<script>self.close()</script>";return;}
		$content = $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$delivery_id)));
		if(sizeof($content) ==0 ) {echo "<script>self.close()</script>";return;}
		$content = $content[0];
		$content->combine =1;
		unset($content->id);
		$ordernum = "";
		$content->region = getRegion();
		$content->rid = generateRandomString(15);
		$insert_id = $this->base_model->insertArrayData("delivery",$content);
		// $services = $this->base_model->getSelect("tbl_service_delivery",array(array("record"=>"delivery_id","value"=>$delivery_id)));

		if($insert_id > 0):

			$ordernum = date("y").date("m").date("d").str_pad($insert_id, 4, '0', STR_PAD_LEFT);
			foreach($chkORD_SEQ as $key=>$value):
				$value = explode("|", $value);
				if(!in_array($value[1], $del_arr))
				{
					array_push($del_arr, $value[1]);
					$services = $this->base_model->getSelect("tbl_service_delivery",array(array("record"=>"delivery_id","value"=>$value[1])));
				    $temp = json_decode($services[0]->content);
				    $temp_service = array();
				    if(!empty($temp) && $temp!=null)
					 {
					 	foreach ($temp as $key_t => $temp_value) {
					 		$temp_service[$key_t] = 0;
						    if(isset($new_service[$key_t]))
						    	$new_service[$key_t] = $new_service[$key_t] + $temp_value;
						    else 
						    	$new_service[$key_t]= $temp_value;
					    }

					    $this->base_model->updateDataById($value[1],array("content"=>json_encode($temp_service)),"tbl_service_delivery","delivery_id");
					}
					    
				}
				$product = $this->base_model->getSelect("tbl_purchasedproduct",array(array("record"=>"id","value"=>$value[0])));
				if(empty($product) || $product==null):echo "<script>alert('상품정보가 명확치 않습니다.관리자에게 문의하십시요.');self.close()</script>";  endif;
				$product = $product[0];
				$product->count = $product->count-$this->input->post("MNS_CNT")[$key];
				if($product->count == 0) {
					$this->base_model->updateDataById($value[0],array("delivery_id"=>$insert_id,"old_delivery_id"=>$value[1]),"tbl_purchasedproduct","id");
				}
				if($product->count > 0) {
					$this->base_model->updateDataById($value[0],array("count"=>$product->count),"tbl_purchasedproduct","id");
					$product->count = $this->input->post("MNS_CNT")[$key];
					$product->delivery_id = $insert_id;
					$product->old_delivery_id = $value[1];
					unset($product->id);
					$this->base_model->insertArrayData("tbl_purchasedproduct",$product);
				}
			sleep(1);		
			endforeach;
			$this->base_model->updateDataById($insert_id,array(  	"ordernum"=>$ordernum,
																	"state"=>40),"delivery","id");
			$this->base_model->insertArrayData("tbl_service_delivery",array("content"=>json_encode($new_service),"delivery_id"=>$insert_id));
		endif;
		echo json_encode(array("msg"=>'성공적으로 요청하였습니다',"ordernum"=>$ordernum,"option"=>"reqdelivery_plus"));
	}
	public function ActingMinus_I(){
		$delivery_id = $this->input->post("orders");
		$chkORD_SEQ = $this->input->post("chkORD_SEQ");
		if(empty($delivery_id)) {echo 1;return;}
		$content = $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$delivery_id)));
		if(sizeof($content) ==0 ) {echo "<script>self.close()</script>";return;}
		$content = $content[0];
		$content->combine =2;
		unset($content->id);
		$ordernum = "";
		$content->region = getRegion();
		$content->rid = generateRandomString(15);
		$insert_id = $this->base_model->insertArrayData("delivery",$content);
		if($insert_id > 0):
			$ordernum = date("y").date("m").date("d").str_pad($insert_id, 4, '0', STR_PAD_LEFT);
			$services = $this->base_model->getSelect("tbl_service_delivery",array(array("record"=>"delivery_id","value"=>$delivery_id)));
			if(!empty($services)){
				$temp_service = array();
				$temp = json_decode($services[0]->content);
				if(!empty($temp))
				{
					$this->base_model->insertArrayData("tbl_service_delivery",array("content"=>$services[0]->content,"delivery_id"=>$insert_id));
				 	foreach ($temp as $key_t => $temp_value) {
				 		$temp_service[$key_t] = 0;
				    }

				    $this->base_model->updateDataById($delivery_id,array("content"=>json_encode($temp_service)),"tbl_service_delivery","delivery_id");

				}	
				if(empty($temp))
					$this->base_model->insertArrayData("tbl_service_delivery",array("content"=>"[]","delivery_id"=>$insert_id));
			}
			else
				$this->base_model->insertArrayData("tbl_service_delivery",array("content"=>"[]","delivery_id"=>$insert_id));	

			
			
			foreach($chkORD_SEQ as $key=>$value):
				$product = $this->base_model->getSelect("tbl_purchasedproduct",array(array("record"=>"id","value"=>$value)));
				if(empty($product) || $product==null):echo "<script>alert('상품정보가 명확치 않습니다.관리자에게 문의하십시요.');self.close()</script>";  endif;
				$product = $product[0];
				$product->count = $product->count-$this->input->post("MNS_CNT")[$key];
				if($product->count == 0) {

					$this->base_model->updateDataById($value,array("delivery_id"=>$insert_id,"old_delivery_id"=>$delivery_id),"tbl_purchasedproduct","id");
				}
				if($product->count > 0) {
					$this->base_model->updateDataById($value,array("count"=>$product->count),"tbl_purchasedproduct","id");
					$product->delivery_id = $insert_id;
					$product->count = $this->input->post("MNS_CNT")[$key];
					$product->old_delivery_id = $delivery_id;
					unset($product->id);
					$this->base_model->insertArrayData("tbl_purchasedproduct",$product);
				}
			sleep(1);		
			endforeach;
			$this->base_model->updateDataById($insert_id,array(	"ordernum"=>$ordernum,
																"state"=>40),"delivery","id");
		endif;
		echo json_encode(array("msg"=>'성공적으로 요청하였습니다',"ordernum"=>$ordernum,"option"=>"reqdelivery_minus"));
	}


	public function requestDelivery(){

		$id = $this->input->post("id");
		$error_products = $this->base_model->getSelect("tbl_purchasedproduct",array(array("record"=>"delivery_id","value"=>$id),array("record"=>"step","value"=>102)));
		if(!empty($error_products)){
			echo json_encode(array("status"=>102));
			return;
		}
		if(empty($error_products) && !empty($id)):
			$this->base_model->updateDataById($id,array("state"=>40),"delivery","id");
			echo json_encode(array("status"=>100));
			return;
		endif;
		echo json_encode(array("status"=>101));
	}
	
	public function MemCtr_S(){
		$this->isLoggedIn();
		$data['contents'] = $this->base_model->getSelect("delivery_address",array(array("record"=>"use","value"=>1)));
		$data['user'] = $this->global['user'];
		$this->load->view("MemCtr_S",$data);
	}
	public function view_photo(){
    $id=$this->input->get("sOrdSeq");
    if(empty($id)) return;
    $data['delivery'] = $this->base_model->viewPhoto($id)[0];
    if(empty($data['delivery']) || $data['delivery']==null) return;
    $this->load->helper('directory');
    $data['map']= directory_map('../upload/silsa/'.$id, FALSE, TRUE);
    $this->load->view("view_photo",$data);
  }

  public function deleteBasket(){
  	$id = $this->input->post("id");
  	$this->base_model->deleteRecordsById("tbl_basket","id",$id);
  	echo 1;
  }

  public function Dlvr_Mny_Pop_W(){
  	$data["sMemLvl"] = !empty($this->input->post("sMemLvl")) ? $this->input->post("sMemLvl"):"";
  	$data["sCtrSeq"] = !empty($this->input->post("sCtrSeq")) ? $this->input->post("sCtrSeq"):"";
  	$data["sTotMny"] = !empty($this->input->post("sTotMny")) ? $this->input->post("sTotMny"):"0";

  	$data["sArcSeq"] = !empty($this->input->post("sArcSeq")) ? $this->input->post("sArcSeq"):"";
  	$data["sTax"] = !empty($this->input->post("sTax")) ? $this->input->post("sTax"):"0";
  	$data["sVal"] = !empty($this->input->post("sVal")) ? $this->input->post("sVal"):"0";


  	if($data["sCtrSeq"] !="" && $data["sMemLvl"] !=""){
  		$data['r'] = $this->base_model->getSelect("tbl_roles",array(array("record"=>"roleId","value"=>$data["sMemLvl"])));
  		$data['deliveryContents'] =  $this->base_model->getSelect("tbl_deliverytable",	
         													array(array("record"=>"address","value"=>$data["sCtrSeq"])),
     														array(array("record"=>"startWeight","value"=>"ASC")));
  	}
  	$data['role'] = $this->base_model->getRoleByMember("yes");
  	$data['category'] = $this->base_model->getSelect("tbl_category",array(array("record"=>"parent!=","value"=>0)));
  	$data['center'] = $this->base_model->getSelect("delivery_address",array(array("record"=>"use","value"=>1)));
  	$data['aa'] = $this->base_model->getSelect("tbl_accurrate",null,array(array("record"=>"created_date","value"=>"DESC")));
  	$data['services'] = $this->base_model->getSelect("tbl_services",array(array("record"=>"use","value"=>"1")));
  	$this->load->view("Dlvr_Mny_Pop_W",$data);
  }

  public function IdChk(){
  	$loginId = sizeof($this->base_model->getSelect("tbl_users",array(array("record"=>"loginId","value"=>$this->input->get("sMemId")))));
  	if($loginId == 0) echo 0;
  	else echo 1;
  }
  public function panel(){
  	$this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config); 
  	$shCol="";
	$shKey = "";
	$category = "";
	if(!empty($_GET['shCol'])) $shCol = $_GET['shCol'];
	if(!empty($_GET['shKey'])) $shKey = $_GET['shKey'];
	if(!empty($_GET['category'])) $category = $_GET['category'];
  	$id = $this->input->get("id");
  	$data['panel'] = $this->base_model->getSelect("tbl_board",array(array("record"=>"iden","value"=>$id)));
  	$records_count = sizeof($this->base_model->getReq($data['panel'][0]->id,null,0,$category,$shCol,$shKey));
  	$returns = $this->paginationCompress ( "panel/", $records_count, 10);
    $data['content'] = $this->base_model->getReq($data['panel'][0]->id,$returns["page"] ,$returns["segment"],$category,$shCol,$shKey);
    $data['ac'] = $records_count;
    $data['cc'] = $returns["segment"];
    $data['contacts'] = $this->base_model->getSelect("tbl_mycontact",array(array("record"=>"userId","value"=>$this->session->userdata('fuser'))));
  	$this->loadViews("public",$this->global,$data,null);
  }

  public function use(){
  	$data['content'] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>14)));
  	$this->loadViews('deliveryShow',$this->global,$data,NULL);
  }

  public function fnBbs_Dn(){
  	$this->load->helper('download');
  	$sFL_SEQ = $this->input->post("sFL_SEQ");
  	$id  = $this->input->post("id");
  	$re= $this->base_model->getSelect("tbl_mail",array(array("record"=>"id","value"=>$id)));
  	$record = "file".$sFL_SEQ;
  	if(!empty($re)){
  		$file_name = $re[0]->$record;
  		if(!empty($file_name)){
			force_download("upload/mail/".$id."/".$file_name,NULL);
  		}
  	}
  }

  public function view_board($id){
  	$data['content'] = $this->base_model->getSelect("tbl_board",array(array("record"=>"id","value"=>$id)));
  	$this->loadViews("view_board",$this->global,$data,null);
  }

  public function getCommentMore(){
    $id = $this->input->post("id");
    $comment_id = $this->input->post("comment_id");
    echo json_encode($this->base_model->getCommentsByPostId(5,$comment_id,$id));
  }

  public function deleteComment(){
  	$this->base_model->deleteRecordsById("tbl_comment","id",$this->input->post("id"));
    echo 1;
  }

  public function updateBilling(){
  	$this->isLoggedIn();
  	$addoptions  = array();
  	$id = $this->input->post("id");
  	$delivery_id = $this->base_model->getSelect("delivery",array(array("record"=>"rid","value"=>$id)));
  	if(!empty($id) || empty($delivery_id)){
		$ADRS_KR = $this->input->post("ADRS_KR");
		$ADRS_EN = $this->input->post("ADRS_EN");
		$RRN_CD = $this->input->post("RRN_CD");
		$RRN_NO = $this->input->post("RRN_NO");
		$MOB_NO1 = $this->input->post("MOB_NO1");
		$MOB_NO2 = $this->input->post("MOB_NO2");
		$MOB_NO3 = $this->input->post("MOB_NO3");
		$ZIP = $this->input->post("ZIP");
		$ADDR_1 = $this->input->post("ADDR_1");
		$ADDR_2 = $this->input->post("ADDR_2");
		$REQ_1 = $this->input->post("REQ_1");
		$post_data=  array( 
							"billing_name"=> $ADRS_EN,
							"billing_krname"=>$ADRS_KR,
							"person_num" => $RRN_CD,
							"person_unique_content" => $RRN_NO,
							"phone_number" =>$MOB_NO1."-".$MOB_NO2."-".$MOB_NO3,
							"post_number"=> $ZIP,
							"address" => $ADDR_1,
							"detail_address" => $ADDR_2,
							"request_detail" => $REQ_1);
		$this->base_model->updateDataById($id,$post_data,"delivery","rid");
		$aa = $this->base_model->getSelect("tbl_service_delivery",array(array("record"=>"delivery_id","value"=>$delivery_id[0]->id)));
		$addoptions = empty($aa[0]->content) ? array() : json_decode($aa[0]->content,true);
		$adds  = $this->base_model->getSelect("tbl_delivery_addprice");
		foreach($adds as $adds_chd){
			if(strpos($ADDR_1,$adds_chd->address) !==false){
				$addoptions[54] = $adds_chd->price;
				break;
			}
		}
		$this->base_model->updateDataById($delivery_id[0]->id,array("content"=>json_encode($addoptions)),"tbl_service_delivery","delivery_id");
		redirect("view/delivery/".$id);
  	}
  	else{
  		echo "<script>window.close();</script>";
  	}
  }

  public function point_history(){
  	$this->isLoggedIn();
    $starts_date   = empty($_GET['starts_date']) ?    NULL : $_GET['starts_date'];
    $ends_date  = empty($_GET['ends_date']) ?   NULL : $_GET['ends_date'];
    $s    = empty($_GET['s']) ?     NULL : $_GET['s'];
    $shType  = empty($_GET['shType']) ?   NULL : $_GET['shType'];
  	$this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config); 
 	$records_count = sizeof($this->base_model->getPointHistory());
  	$returns = $this->paginationCompress ( "point_history/", $records_count, 10,$starts_date,$ends_date,$s,$shType);
  	$data["history"] = $this->base_model->getPointHistory($returns["page"] ,$returns["segment"],$starts_date,$ends_date,$s,$shType);
  	$data['csc'] = $records_count;
    $data['seg'] = $returns["segment"];
	$this->loadViews('point_history',$this->global,$data,NULL);
  }
  public function getss(){
    //echo file_get_contents("https://www.tokopedia.com/pendaki-official/naturehike-kantong-tidur-sleeping-bag-lw180-ultralight-nh15s003-d?src=topads");
    //$c = curl_init('https://www.tokopedia.com/pendaki-official/naturehike-kantong-tidur-sleeping-bag-lw180-ultralight-nh15s003-d?src=topads');
	echo $this->get_dataa('https://www.tokopedia.com/pendaki-official/naturehike-kantong-tidur-sleeping-bag-lw180-ultralight-nh15s003-d?src=topads');
  }

  function get_dataa($url) {
	  $ch = curl_init();
	  $timeout = 5;
	  curl_setopt($ch, CURLOPT_URL, $url);
	  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
	  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
	  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	  $data = curl_exec($ch);
	  curl_close($ch);
	  return $data;
	}

	public function ipage(){
		$this->load->helper('directory');
		$id = $this->input->get("id");
		$data["content"] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>$id)));
		$data['map']= directory_map('../upload/banner/'.$id, FALSE, TRUE);
		$rate = array(array());
		$option = 0;
		if(isset($data['content'][0]) && $data['content'][0]->title=='배송비 안내'){
			$data['deliveryAddress'] = $this->base_model->getSelect("delivery_address",	array(array("record"=>"use","value"=>1)));
			if(empty($data['deliveryAddress'])){
				redirect("/");
				return;
			}
		    $data['man'] = $this->base_model->getRoleByMember();
		    if(!empty($this->input->get("option")))
		    {
		       	$option = $this->input->get("option");
		       	$data['deliveryContents'] =  $this->base_model->getSelect("tbl_deliverytable",
		         													array(array("record"=>"address","value"=>$option)),
		     														array(array("record"=>"startWeight","value"=>"ASC")));
		         
		    }
		    else{
		    	$option = $data['deliveryAddress'][0]->id;
		    	$data['deliveryContents'] =  $this->base_model->getSelect("tbl_deliverytable",	
		         													array(array("record"=>"address","value"=>$option)),
		     														array(array("record"=>"startWeight","value"=>"ASC")));
		    }
		    foreach ($data['man'] as $key => $value) {
		        $a_rate = json_decode($value->address_rate,true);
		        if(!empty($a_rate)){
		          if(isset($a_rate[$option]))
		            $rate[$value->roleId][$option] = $a_rate[$option];
		          else
		            $rate[$value->roleId][$option] = $value->sending_inul;
		        }
		        else
		          $rate[$value->roleId][$option] = $value->sending_inul;
		      }
		   $data['options'] = $option;
		   $data['rate'] = $rate;    
		}
		$this->loadViews('ipage',$this->global,$data,NULL);
	}

	public function getShopProducts(){
		$limit = $this->input->post("limit");
		if($this->input->post("type")==6)
			echo  json_encode($this->base_model->getProductsBySh(5,$limit));
		if($this->input->post("type")==4)
			echo  json_encode($this->base_model->getSelect("tbl_sproducts",	array(	array("record"=>"use","value"=>1),
																					array("record"=>"sold","value"=>1)),
																			array(array("record"=>"updated_date","value"=>"DESC")),
																			null,
																			array(array("record"=>5,"value"=>$limit))));
		if($this->input->post("type")==3)
			echo  json_encode($this->base_model->getDeCrea($limit));
		if($this->input->post("type")==2)
			echo  json_encode($this->base_model->getSelect("tbl_sproducts",	array(	array("record"=>"use","value"=>1),
																					array("record"=>"sold","value"=>1),
																					array("record"=>"hot","value"=>1)),
																			array(array("record"=>"updated_date","value"=>"DESC")),
																			null,
																			array(array("record"=>5,"value"=>$limit))));
		if($this->input->post("type")==1)
			echo  json_encode($this->base_model->getSelect("tbl_sproducts",	array(	array("record"=>"use","value"=>1),
																					array("record"=>"sold","value"=>1),
																					array("record"=>"new","value"=>1)),
																			array(array("record"=>"updated_date","value"=>"DESC")),
																			null,
																			array(array("record"=>5,"value"=>$limit))));
		if($this->input->post("type")==5)
			echo  json_encode($this->base_model->getSelect("tbl_sproducts",	array(	array("record"=>"use","value"=>1),
																					array("record"=>"sold","value"=>1),
																					array("record"=>"shop_category","value"=>$this->input->post("category"))),
																			array(array("record"=>"updated_date","value"=>"DESC")),
																			null,
																			array(array("record"=>5,"value"=>$limit))));

	}

	public function acceptO(){
		$did = explode("|", $this->input->post("did"));
		foreach ($did as $value) {
			$this->base_model->updateDataById($value,array("state"=>2),"delivery","id");
		}
		redirect("/viewdeliveryState?step=2");
	}

	public function board_edit(){
		$this->isLoggedIn();
		$data['afterview'] = $this->base_model->getReqById($this->input->get("board_id"));
    	$data['bbc_code']= $this->input->get("bbc_code");
    	$data['panel'] = $this->base_model->getSelect("tbl_board",array(array("record"=>"id","value"=>$data['bbc_code'])));
    	$this->loadViews('board_write', $this->global, $data , NULL);
	}

	public function deletepost(){
		$this->base_model->deleteRecordsById("tbl_mail","id",$this->input->post("postId"));
		echo 1;
	}

	public function returnRequest(){
		$product_et = $this->input->post("product_et");
		$return_id = 0;
		if(!empty($product_et)){
			$delivery_id = $this->base_model->getSelect("tbl_purchasedproduct",array(array("record"=>"id","value"=>$product_et[0])));
			if(empty($delivery_id)){
				echo json_encode(array("result"=>0));
				return;
			}
			$products = $this->base_model->getSelect("tbl_purchasedproduct",array(array("record"=>"delivery_id","value"=>$delivery_id[0]->delivery_id)));
			if(sizeof($products) == sizeof($product_et)){
				$this->base_model->updateDataById($delivery_id[0]->delivery_id,array("state"=>19),"delivery","id");
				$return_id = $delivery_id[0]->delivery_id;
			}
			else{
				$delivery =  $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$delivery_id[0]->delivery_id)));
				if(empty($delivery)){
					echo json_encode(array("result"=>2));
					return;
				}
				$delivery = $delivery[0];
				$delivery_id = $delivery->id;
				unset($delivery->id);
				$delivery->state =19;
				$delivery->return_check =0;
				$delivery->return_price =0;
				$delivery->type =4;
				$delivery->combine =3;
				$delivery->rid = generateRandomString(15);
				$insert_id = $this->base_model->insertArrayData("delivery",$delivery);
				if($insert_id >  0 ){
					$this->base_model->insertArrayData("tbl_service_delivery",array("content"=>"[]","delivery_id"=>$insert_id));
					$this->base_model->updateDataById($insert_id,array("ordernum"=>date("y").date("m").date("d").str_pad($insert_id, 4, '0', STR_PAD_LEFT)),"delivery","id");
					foreach ($product_et as $key => $value) {
						$this->base_model->updateDataById($value,array("delivery_id"=>$insert_id,"old_delivery_id"=>$delivery_id),"tbl_purchasedproduct","id");
					}
					$return_id  = $insert_id;
				}
				else{
					echo json_encode(array("result"=>3));
					return;
				} 
			}

			if($return_id > 0){
				if (!file_exists(__DIR__."/../../../upload/return/".$return_id))	
      			mkdir(__DIR__."/../../../upload/return/".$return_id, 0777);
				$this->load->library('upload',$this->set_upload_options(__DIR__."/../../../upload/return/".$return_id,5*1024,'*',false));
			    $this->upload->initialize($this->set_upload_options(__DIR__."/../../../upload/return/".$return_id,5*1024,'*',false));
			    if(!empty($_FILES['returns']['name']) && $_FILES['returns']['name'] !=""){
			      if ( ! $this->upload->do_upload('returns'))
			      {
			        $error = array('error' => $this->upload->display_errors());
			      }
			      else
			      {
			        $img_data = $this->upload->data();
			        $this->base_model->updateDataById($return_id,array("return_file"=>$img_data["file_name"]),"delivery","id");  
			      }
			    }
			}
			
		}
		echo json_encode(array("result"=>1));
	}

	public function submitError(){
		$ordernum = $this->input->post("ordernum");
		if(empty($ordernum)){
			echo json_encode(array("result"=>0));
				return;
		}

		else{
			$this->base_model->updateDataById($ordernum,array("state"=>13),"delivery","id");
			echo json_encode(array("result"=>1));
			return;
		}

		echo json_encode(array("result"=>-1));
	}
	public function EmailChk(){
	  	$loginId = sizeof($this->base_model->getSelect("tbl_users",array(array("record"=>"email","value"=>$this->input->get("sMemEmail")))));
	  	if($loginId == 0) echo 0;
	  	else echo 1;
	}

	public function deleteFile(){
		$url = $this->input->post("url");
		$id = $this->input->post("id");
		$type  = $this->input->post("type");
		if($id > 0 && !empty($url)){
			$this->base_model->updateDataById($id,array("file".$type=>""),"tbl_mail","id");
			$del = deleteFile($_SERVER['DOCUMENT_ROOT']."/../upload/mail/".$id."/".$url."");
			if($del ==1){
				echo 1;
			}
			else
				echo -1;
			return;
		}
		echo 0;
	}

	public function checkForget(){
		$type = $this->input->post("type");
		if($type ==1)
		{
			$recipient_name = $this->input->post("recipient-name");
			$recipient_email = $this->input->post("recipient-email");

			$user = $this->base_model->getSelect("tbl_users",array(		array(	"record"=>"name","value"=>$recipient_name) ,
																		array(	"record"=>"email","value"=>$recipient_email) 	));
			if(sizeof($user) > 0) echo json_encode(array("message"=>"아이디는 ".$user[0]->loginId."입니다.","status"=>1));
			else echo json_encode(array("status"=>0));
		}

		else{
			$this->load->library('encrypt');
			$name = $this->input->post("name");
			$email = $this->input->post("email");
			$loginId = $this->input->post("loginId");

			$user = $this->base_model->getSelect("tbl_users",array(		array(	"record"=>"name","value"=>$name) ,
																		array(	"record"=>"email","value"=>$email),
																		array(	"record"=>"loginId","value"=>$loginId)));

			if(empty($user)){
				echo json_encode(array("status"=>0));
				return;
			}

			$password = $this->encryption->decrypt($user[0]->password);

			try {
				$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
			    //서버설정
			    $mail->CharSet ="UTF-8";                     //언어셋설정                     
			    //$mail->isSMTP();                             // SMTP사용 (이것을 주석을 풀면 메일이 안갑니다. 원인은 알수가 없습니다.)
			    $mail->Host = 'smtp.naver.com';                // SMTP 중계서버 주소
			    $mail->SMTPAuth = true;                      //  SMTP 인증사용
			    $mail->Username = 'kml5395@naver.com';                // SMTP 메일사용자
			    $mail->Password = 'khy0615';             		// SMTP 메일비번
			    $mail->SMTPSecure = 'ssl';                    // ssl 사용
			    $mail->Port = 587;                            // smtp 포트
			    $mail->setFrom('kml5395@naver.com', '타오달인');  //발신자 메일주소 및 발신자 이름
			    $mail->addAddress($email, '고객님');  // 수신자 메일주소 

			    $mail->Subject = ('타오달인 - 회원 비밀번호 정보입니다');

				$mail->Body = "
				<html>
					<head>
					<title>타오달인</title>
					</head>
					<body>                
					".$name."님 안녕하세요</p>
												<p>비밀번호는 “ ".$password." “ 입니다</p>'
					</body>
					</html>";
			    $mail->AltBody = '클라이언트에서 html지원하지 않을 경우 표시';
				$mail->SMTPDebug = 4;

			    $mail->send();
		    	echo json_encode(array("message"=>"신청한 내용을 메일로 발송해드렸습니다.","status"=>1));
			} catch (Exception $e) {

			    echo json_encode(array("status"=>0));
			}
		}
	}
	public function deleteMails(){
		$ids= $this->input->post("id");
		foreach($ids as $value){
			$this->base_model->deleteRecordsById("tbl_mail","id",$value);
		}

		redirect("mailbox");
	}

	public function myPage(){
		$this->isLoggedIn();
		$data['contacts'] = $this->base_model->getSelect("tbl_mycontact",array(array("record"=>"userId","value"=>$this->session->userdata('fuser'))));
		$data['content'] = sizeof($this->base_model->getDeliverWaitingPay(-1,0));
		$data['coupon'] = sizeof($this->base_model->getCouponLists(0,1));
		$data['mail_count']= sizeof($this->base_model->getMail(0,-1,"",$this->session->userdata('fuser'),"","","","","","",1));
		$this->loadViews("myhome",$this->global, $data , NULL);
	}

	public function getpayC(){
		$id = $this->input->post("id");
		$content = $this->base_model->getSelect("tbl_payhistory",array(array("record"=>"id","value"=>$id)));
		if(empty($content)){
			echo "EMPTY";
			return;
		}

		$type = "";
		$order_string = "";
		$order_nums  = array();
		$rid  = array();

		$orders = $this->base_model->getOrdersFromSecurity($content[0]->security);

		foreach ($orders as $key => $value) {
			if(!empty($value->ordernum) && !in_array($value->ordernum, $order_nums))
				array_push($order_nums,$value->ordernum);
				array_push($rid,$value->rid);
		}

		if($content[0]->payed_type == 4)
			$type = "무통장 입금결제";
		if($content[0]->payed_type == 5)
			$type = "예치금 전액결제";

		foreach ($order_nums as $key => $value) {
			$order_string .="<a class='text-green' href='/view/delivery/".$rid[$key]."'>".$value."</a>";
			$order_string .="<br>";
		}
		$order_label = "";
		$pending_label = "";
		if($content[0]->pending==0): $order_label ="주문완료"; endif;
		if($content[0]->pending==1): $order_label="주문결제진행"; endif;
		if($content[0]->pending==2): $order_label="주문결제취소";$pending_label = "(관리자 결제취소)"; endif;
		$str = "";
		$str .= '<div class="box-body table-responsive no-padding"><table class="table table-hover">';
		$str .= '<table class="table">';

		$str .= "<tr>";
		$str .= "<th>";
		$str .= "결제구분";
		$str .= "</th>";
		$str .= "<td>";
		$str .= $type;
		$str .= "</td>";
		$str .= "</tr>";

		$str .= "<tr>";
		$str .= "<th>";
		$str .= "미결제금액";
		$str .= "</th>";
		$str .= "<td>";
		$str .= "<span class='text-danger'>".$content[0]->pamount."</span>"."원".$pending_label;
		$str .= "</td>";
		$str .= "</tr>";

		$str .= "<tr>";
		$str .= "<th>";
		$str .= "처리일자";
		$str .= "</th>";
		$str .= "<td>";
		$str .=  explode(" ",$content[0]->payed_date)[0];
		$str .= "</td>";
		$str .= "</tr>";

		$str .= "<tr>";
		$str .= "<th>";
		$str .= "결제내역";
		$str .= "</th>";
		$str .= "<td>";
		$str .= "<div class='mb-5 text-danger'>주문정보(".$order_label.")</div>"."<div>".$order_string."</div>";
		$str .= "</td>";
		$str .= "</tr>";

		$str .= '</table>';
		$str .= '</div>';
		echo $str;
	}

	public function taobao(){
		$this->load->view("taobao",NULL);
	}

	public function taoshopping(){
		echo "<script>alert('업데이트중입니다.');location.href='/';</script>";
		return;
		$p_icon = array();
		$p_i = $this->base_model->getSelect("tbl_proico",NULL,array(array("record"=>"order","value"=>"ASC")));

		foreach($p_i as $value){
			$p_icon[$value->id] = $value->icon;
		}
		$data['icons'] = $p_icon;
		$best_products = $this->base_model->getProductsWithReview("p_bestview","p_idx",2);
		$rec_products = $this->base_model->getProductsWithReview("p_saleview","p_idx");
		$new_products = $this->base_model->getProductsWithReview("p_newview","p_idx");
		$cheap_products = $this->base_model->getProductsWithReview("cheap","singo");
		$wow_products = $this->base_model->getProductsWithReview("p_wowview","p_idx");
		
		$data["best_products"] = $best_products;
		$data["rec_products"] = $rec_products;
		$data["new_products"] = $new_products;
		$data["cheap_products"] = $cheap_products;
		$data["wow_products"] = $wow_products;
		$this->loadViews('taoshopping', $this->global, $data , NULL);
	}

	private function getPriceFromWeight($weight,$count=1,$login_no=false){
		$return_value = array();
		$return_value[0] = array();
		$return_value[1] = array();
		$return_value[2] = array();
		$return_value[3] = array();
		$return_value[0]["weight"] = 0;
		$return_value[0]["price"] = 0;
		$return_value[0]["rate"] = 1;
		$return_value[1]["weight"] = 0;
		$return_value[1]["price"] = 0;
		$return_value[1]["rate"] = 1;
		$s_ss = array();
		if($login_no || !empty($this->session->userdata("fuser"))){

			if(!empty($this->session->userdata("fuser"))){
				$current_level = $this->session->userdata("frole");
				$address_rate = $this->base_model->getRoleByMember("yes",1);
			}

			else{
				$current_level = 3;
				$address_rate = $this->base_model->getRoleByMember("yes",1,3);
			}
			
			if(!empty($address_rate)){
				$a_rate = json_decode($address_rate[0]->address_rate,true);
				$t_weight = $weight * $count < 1 ? 1: $weight * $count;
				if(!empty($a_rate))
				{
					if(!empty($a_rate[1])){
						$s_ss = $this->base_model->getSelect("tbl_deliverytable",array( array("record"=>"address","value"=>"1"),
																						array("record"=>"startWeight <=","value"=>$t_weight),
																						array("record"=>"endWeight >=","value"=>$t_weight)));
						if(empty($s_ss))
						{
							$return_value[0]["weight"] = 0;
							$return_value[0]["price"] = 0;
						}
						else{
							$w = getDeliveryPrice($s_ss[0]->startWeight,$t_weight,$s_ss[0]->weight,$s_ss[0]->startPrice,$s_ss[0]->goldSpace,$a_rate[1],$s_ss[0]->endWeight);

							$return_value[0]["weight"] = $w["weight"];
							$return_value[0]["price"] = $w["price"];
							$return_value[0]["rate"] = $a_rate[1];
							$return_value[2] = $s_ss;
						}
					}
					if(!empty($a_rate[2])){
						$s_ss = $this->base_model->getSelect("tbl_deliverytable",array( array("record"=>"address","value"=>"2"),
																						array("record"=>"startWeight <=","value"=>$t_weight),
																						array("record"=>"endWeight >=","value"=>$t_weight)));
						if(empty($s_ss))
						{
							$return_value[1]["weight"] = 0;
							$return_value[1]["price"] = 0;
						}
						else{
							$w = getDeliveryPrice($s_ss[0]->startWeight,$t_weight,$s_ss[0]->weight,$s_ss[0]->startPrice,$s_ss[0]->goldSpace,$a_rate[2],$s_ss[0]->endWeight);
							$return_value[1]["weight"] = $w["weight"];
							$return_value[1]["price"] = $w["price"];
							$return_value[1]["rate"] = $a_rate[2];
							$return_value[3] = $s_ss;
						}
					}
				}	
			}
		}
		
		return $return_value;
	}

	public function update_bracket(){
		$aa = array();
		$happened_adds = false;
		$add_prices = array();
		$data = $this->input->post();
		$delivery_price = 0;
		$mem_wt = 0;
		$color = $data["color"];
		$size = $data["size"];
		$count = $data["option_select_cnt"];
		$getSiteInfo = getSiteInfo();
		$by_price = $getSiteInfo->s_delprice_free;
		$product_feature = array();
		$delivery_method = "sea";
		$all_delivery = 0;
		$free_price = 0;
		$t = empty($data["delivery_method"]) ?  $delivery_method : $data["delivery_method"];
		if(empty($this->session->userdata("fuser"))){
			echo json_encode(array("status"=>"login_error","message"=>"로그인후 가능합니다."));
			return;
		}

		$product = $this->base_model->getSelect("tbl_sproducts",array(array("record"=>"rid","value"=>$data["pcode"])));
		if(empty($product)){
			echo json_encode(array("status"=>"error","message"=>"상품이 존재하지 않습니다."));
			return;
		}

		if($data["delivery_type"] =="basket"){
			$checked_basket = $this->base_model->getSelect("tbl_basket",array(	array("record"=>"userId","value"=>$this->session->userdata("fuser")),
																			array("record"=>"size","value"=>$size),
																			array("record"=>"productId","value"=>$product[0]->id),
																			array("record"=>"delivery_method","value"=>$t)));
			if(!empty($checked_basket)){
				echo json_encode(array("status"=>"error","message"=>"장바구니에 이미 추가되였습니다."));
				return;
			}
		}
		
		$mem_wt = $product[0]->weight * $count;
		
		if($count <=0){
			echo json_encode(array("status"=>"error","message"=>"수량은 0보다 커야 합니다."));
			return;
		}

		$product_price = $product[0]->singo;

		$temp_price = 0;
		
		if(!empty($data["product_feature"])){
			$product_feature = $data["product_feature"];
			if(!empty($product_feature)){
				foreach ($product_feature as $key => $value) {
					$o = $this->base_model->getSelect("tbl_product_option",array(array("record"=>"id","value"=>$value)));
					if(!empty($o)){
						if($temp_price < $o[0]->supply)
						{
							if($count >$o[0]->count){
								echo json_encode(array("status"=>"error","message"=>"지정된 수량을 초과하였습니다."));
								return;
							}
							$temp_price = $o[0]->supply;
						}
					}
				}
			}
		}

		else{
			if($count > $product[0]->count){
				echo json_encode(array("status"=>"error","message"=>"지정된 수량을 초과하였습니다."));
				return;
			}
		}

		if($temp_price > 0 )
			$product_price = $temp_price;
		if($product[0]->p_shoppingpay_use ==0 && ($product_price * $count) < $by_price)
		{
			$delivery_price = $getSiteInfo->s_delprice * $count;
			$free_price = $delivery_price;
		}
		if($product[0]->p_shoppingpay_use ==1 )
		{
			if(empty($data["delivery_method"]))
			{
				echo json_encode(array("status"=>"error","message"=>"배송방식이 추가되지 않은 상품입니다.관리자에게 문의하세요."));
				return;
			}

			$pw = $this->getPriceFromWeight($product[0]->weight,$count);

			if($data["delivery_method"]=="sea"){
				$delivery_price= $pw[0]["price"];
				$mem_wt = $pw[0]["weight"];

			}
			if($data["delivery_method"]=="sky"){
				$delivery_price= $pw[1]["price"];
				$mem_wt = $pw[1]["weight"];
				$delivery_method = "sky";
			}
		}

		if($data["delivery_type"] =="basket"){
			$this->base_model->insertArrayData("tbl_basket",array(	"userId"=>$this->session->userdata("fuser"),
																"productId"=>$product[0]->id,
																"count"=>$count,
																"size"=>$size,
																"add_options"=>json_encode($product_feature),
																"delivery_price"=>$delivery_price,
																"price"=>$product_price,
																"delivery_method"=>$delivery_method));
			echo json_encode(array("status"=>"success","message"=>"장바구니에 추가되였습니다."));
			return;
		}

		if($data["delivery_type"] =="purchase"){
			$all_delivery = $delivery_price;
			$place = $delivery_method =="sea" ? 1 : 2;
			$adds  = $this->base_model->getSelect("tbl_delivery_addprice");
			foreach($adds as $adds_chd){
				if(strpos($data["ADDR_1"],$adds_chd->address) !==false){
					$aa[54] = $adds_chd->price;
					$all_delivery = $all_delivery + $adds_chd->price;
					$happened_adds = true;
					break;
				}
			}

			$free_delivery = 0;
			if($product_price * $count > $getSiteInfo->s_delprice_free)
				$free_delivery = 1;
			$return = $this->base_model->insertArrayData("delivery" ,array(	"place"=>$place,
																	"incoming_method"=>3,
																	"billing_krname"=>$data["ADRS_KR"],
																	"billing_name"=>$data["ADRS_EN"],
																	"phone_number"=>$data["MOB_NO1"]."-".$data["MOB_NO2"]."-".$data["MOB_NO3"],
																	"post_number"=>$data["ZIP"],
																	"address"=>$data["ADDR_1"],
																	"detail_address"=>$data["ADDR_2"],
																	"request_detail"=>$data["REQ_1"],
																	"userId"=>$this->session->userdata("fuser"),	
																	"shop"=>1,
																	"add_options"=>json_encode($product_feature),
																	"get"=>"delivery",
																	"type"=>3,
																	"state"=>5,
																	"person_num"=>1,
																	"person_unique_content"=>$data["RRN_NO"],
																	"sending_price"=>$all_delivery,
																	"purchase_price"=>$product_price * $count,
																	"rid"=>generateRandomString(15),
																	"real_weight"=>$product[0]->weight *$count,
																	"pur_fee"=>"0|".$product_price * $count."|1",
																	"sends" =>$delivery_price,
																	"free_delivery" => $free_delivery,
																	"mem_wt"=>$mem_wt,
																	"free_price" =>$free_price
																	)
														);
			if($return > 0){
				$oo = date("y").date("m").date("d").str_pad($return, 4, '0', STR_PAD_LEFT);
				$this->base_model->updateDataById($return,array("ordernum"=>$oo),"delivery","id");
				$this->base_model->insertArrayData("tbl_service_delivery",array("content"=>json_encode($aa),"delivery_id"=>$return));
				$in_parent = 1;
				$in_ch = 65;
				$category_name = $product[0]->category;
				$category_child = $this->base_model->getSelect("tbl_category",array(	array("record"=>"name","value"=>$category_name),
																						array("record"=>"parent >","value"=>0)));
				if(!empty($category_child)){
					$in_ch = $category_child[0]->id;
					$in_parent = $category_child[0]->parent;
				}
				$pro_item = array( 	"delivery_id"=>$return,
                                    "trackingHeader"=>1,
                                    "parent_category"=>$in_parent,
                                    "category"=>$in_ch,
                                    "productName"=>$product[0]->eg_name,
                                    "unitPrice"=>$product_price,
                                    "count"=>$count,
                                    "size"=>$size,
                                    "url"=>"/view/shop_products/".$product[0]->rid,
                                    "image"=>"/upload/shoppingmal/".$product[0]->id."/".$product[0]->image,
                                    "step"=>0,
                                    "created_date"=>date("Y-m-d H:i"),
                                	"serial"=>$oo."-1",
                                	"shop"=>$product[0]->id,
                                	"add_options"=>json_encode($product_feature)
                                	);
							$this->base_model->insertArrayData("tbl_purchasedproduct",$pro_item);
				echo json_encode(array("status"=>"success_purchase","message"=>"구매신청 완료.","happened_adds"=>$happened_adds,
				"post_id"=>$oo));
				return;

			}
			echo json_encode(array("status"=>"error","message"=>"처리중 오류가 발생하였습니다."));
			return;
		}	
		echo json_encode(array("result"=>1));
	}

	public function relatedProudct(){
		$pcode = $this->input->post("pcode");
		$category = "";
		$related_id = $this->base_model->getPCode($pcode);
		if(!empty($related_id)){
			foreach ($related_id as $key => $value) {
				$category .= implode(",", $this->getChildCateogriesFromParentID($value->category_code)["category"]);
			}
		}

        $rate = $this->base_model->getRelatedProducts($category,$pcode);
        echo json_encode($rate);
	}

	private function getChildCateogriesFromParentID($category_id){
		$returns = array();
		$category_name = "전체";
		if(!empty($category_id)){
			$selected_category = $this->base_model->getSelect("tbl_leftcategory",array(array("record"=>"category_code","value"=>$category_id)));
			if(!empty($selected_category))
			{
				$category_name = $selected_category[0]->name;
				$selected_item = $selected_category[0]->id;
				array_push($returns, $selected_item);
				$temp = $this->base_model->getSelect("tbl_leftcategory",array(array("record"=>"parent","value"=>$selected_item)));
				foreach ($temp as $key => $value) 
					array_push($returns, $value->id);
			}
			$return_temp = $returns;
			if(!empty($return_temp)){
				foreach ($return_temp as $key => $value) {
					$temp = $this->base_model->getSelect("tbl_leftcategory",array(array("record"=>"parent","value"=>$value)));
					foreach ($temp as $key => $ch_value) 
					{
						if(!in_array($ch_value->id, $returns))
							array_push($returns, $ch_value->id);
					}

				}
			}
		}

		return array("name"=>$category_name,"category"=>$returns);
	}

	public function getReivews(){
		$limit = $this->input->post("here");
		$pcode  =$this->input->post("pcode");
		$type  =$this->input->post("type");
		$returns = array();
		$ques = $this->base_model->reviewsArray($limit,$pcode,$type);
		foreach ($ques as $key => $value) {
			$ques[$key]->pc_url = base_url_home();
			if(!empty($value->img))
			{
				$ques[$key]->image_uploaded = True;
				$value->img = base_url_home()."upload/request/".$value->img;
			}
			else
				$ques[$key]->image_uploaded = False;

			if(date("Y-m-d") == date("Y-m-d",strtotime($ques[$key]->rdate)))
				$ques[$key]->new = True;
			else
				$ques[$key]->new = False;
			if($ques[$key]->userId ==$this->session->userdata("fuser"))
				$ques[$key]->permission = True;
			else
				$ques[$key]->permission = False;

			$ques[$key]->rdate = date("Y-m-d",strtotime($ques[$key]->rdate));
		}

		echo json_encode(array("status"=>"success","result"=>$ques,"type"=>$type));	
	}

	function eval_update(){
		$data = $this->input->post();

		if(empty($this->session->userdata("fuser"))){
			echo "login";
			return;
		}

		if(isset($data["_mode"]) && $data["_mode"] =="delete" && $data["uid"] > 0){
			$second = sizeof($this->base_model->getSelect("tbl_product_talk",array(array("record"=>"relation","value"=>$data["uid"]))));
			if($second > 0){
				echo "is reply";
				return;
			}

			$born = $this->base_model->getSelect("tbl_product_talk",array(array("record"=>"id","value"=>$data["uid"])));
			if(empty($born))
			{
				echo "none";
				return;
			}

			if($this->session->userdata("fuser") != $born[0]->userId){
				echo "no data";
				return;
			}
			if(!empty($born[0]->img))
				deleteFile($_SERVER['DOCUMENT_ROOT']."/../upload/request/".$born[0]->img);
			$this->base_model->deleteRecordsById("tbl_product_talk","id",$data["uid"]);
			echo "deleted";
			return;
		}
		if(!empty($data["pcode"])){
			if($data["type"] !="qna"){

				$checked_review = $this->base_model->getSelect("tbl_product_talk" ,array(	array("record" => "type" ,"value" => "eval"),
																							array("record" => "userId" ,"value" => $this->session->userdata("fuser")),
																							array("record" => "pcode" ,"value" => $data["pcode"]),
																							array("record"=>"intype","value"=>"normal")
																						) 
																);
				if(!empty($checked_review)){
					echo json_encode(array(	"status"=>"error",
											"result"=>"상품평가를 이미 하였습니다.")
									);
					return;
				}

				$checked_val = $this->base_model->getOutProductByUser($data["pcode"]);
				if(empty($checked_val)){
					echo json_encode(array(	"status"=>"error",
											"result"=>"구매내역 없습니다.구매내역 확인후 상품평가 등록해주세요.")
									);
					return;
				}
			}
		}
		else
		{
			echo json_encode(array(	"status"=>"error",
										"result"=>"상품코드가 비였습니다.")
								);
			return;
		}
		$id = $data["id"];
		$img_data = "";
		$image_uploaded = false;
		unset($data["id"]);
		$data["img"] = "";
		$return = 0;
		if(!empty($_FILES['img']) && $_FILES['img']['name'] !=""){
    		$this->load->library('upload',$this->set_upload_options("upload/request",600));
          	$this->upload->initialize($this->set_upload_options("upload/request",600));
          	if ( ! $this->upload->do_upload('img'))
	        {
	           $error = array('error' => $this->upload->display_errors());
	           echo json_encode(array(	"status"=>"error",
								"result"=>$this->upload->display_errors()));
	           return;
	        }
	         else
	        {
	            $img_data = $this->upload->data();
	        }
    	}

    	if(!empty($img_data))
    	{	
    		$data["img"] = $img_data["file_name"];
			$image_uploaded = true;
		}
		$data["userId"] = $this->session->userdata("fuser");
		if($id > 0){
			$this->base_model->updateDataById($id,$data,"tbl_product_talk","id");
			$return = $id;
		}
		else{
			$return = $this->base_model->insertArrayData("tbl_product_talk",$data);
		}

		$data["nickname"] = $this->session->userdata("fnickname");
		$data["image_uploaded"] = $image_uploaded;
		$data["id"] = $return;
		$data["rdate"] = date("Y-m-d");
		$data["new"] = true;
		$data["pc_url"] = base_url_home();
		$data["permission"] = true;
		echo json_encode(array(	"status"=>"success",
								"result"=>$data,
								"type"=>$data["type"]));

	}

	public function getProductsWithJson(){
		$limit1 = $this->input->post("limit1");
		$limit2 = $this->input->post("limit2");
		$category = $this->input->post("category");
		$categories = array();
		$name = $this->input->post("name");
		if(!in_array($category, FAVOR_URL))
			$categories = $this->getChildCateogriesFromParentID($category);
		else
			$categories['category'] = array();
		echo json_encode(array("product_list"=>($this->base_model->getProdcutsWithNames($limit1,$limit2,$categories["category"],$name,$category))));
	}

	public function getMoreBasket(){
		$here = $this->input->post("here");
		$type = $this->input->post("type");
		echo json_encode(array("status"=>"success","result"=>$this->base_model->getBasket(null,$type,$here)));
	}

	
	public function changeShopCount(){
		$this->isLoggedIn();
		$ids = array();
		$delivery_price = 0;
		$getSiteInfo = getSiteInfo();
		$by_price = $getSiteInfo->s_delprice_free;
		$ids[0] = $this->input->post("id");
		$item  = $this->base_model->getBasket($ids);
		if(empty($item)){
			echo json_encode(array("status"=>"error","message"=>"상품자료가 비였습니다"));
			return;
		}

		if($this->input->post("count") > $item[0]->pcount){
			echo json_encode(array("status"=>"error_count","message"=>"이 상품의 최대 수량은 ".$item[0]->pcount."입니다."));
			return;
		}

		if($item[0]->p_shoppingpay_use ==0 && $this->input->post("count") * $item[0]->price < $getSiteInfo->s_delprice_free)
		{
			$delivery_price = $this->input->post("count") * $getSiteInfo->s_delprice;
		}
		if($item[0]->p_shoppingpay_use ==1){
			$pw = $this->getPriceFromWeight($item[0]->weight,$this->input->post("count"));
			if($item[0]->delivery_method =="sea"){
				$delivery_price = $pw[0]["price"];
			}
			if($item[0]->delivery_method =="sky"){
				$delivery_price = $pw[1]["price"];
			}
		}
		$this->base_model->updateDataById(	$this->input->post("id"),array(	"count"=> $this->input->post("count"),
																			"delivery_price"=>$delivery_price),
											"tbl_basket","id");
		echo json_encode(array("status"=>"success","message"=>""));
		return;
	}

	public function updateBasketData(){
		$type_delete = $this->input->post("type_delete");
		$ids = $this->input->post("basket_".$type_delete);
		$mode = $this->input->post("mode");
		$type_delete = $this->input->post("type_delete");
		if($mode == "inv_delete")
			$ids = $this->input->post("inv");


		if($mode == "delete" || $mode == "inv_delete"){
			$idd = array();
			if(is_array($ids))
			{
				$t = $this->base_model->getSelect("tbl_basket" , array( array("record" =>"id" , "value" => $ids ) ));
				if(!empty($t)){
					foreach ($t as $key => $value) {
						$idd[$value->id] = $value->productId;
					}
				}
			}
			$this->base_model->deleteRecordsById("tbl_basket","id",$ids);
			echo json_encode(array("status"=>1,"ids"=>$ids,"idd"=>$idd));
			return;
		}

		if($mode == "all_delete"){
			$this->base_model->deleteAllBaset($type_delete);
			echo json_encode(array("status"=>2));
			return;
		}

		

		echo json_encode(array("status"=>0));
	}

	public function product_wish(){
		$code = $this->input->post("code");
		$mode = $this->input->post("mode");

		if(empty($this->session->userdata('fuser')))
		{
			echo json_encode(array("status"=>"1","result"=>"로그인후 이용하실수 있습니다."));
			return;
		}

		$wish = $this->base_model->getSelect("tbl_product_wish",array(	array("record"=>"pcode","value"=>"$code"),array("record"=>"userId","value"=>$this->session->userdata('fuser'))));

		if(!empty($wish)){
			$this->base_model->deleteWish($this->session->userdata("fuser"),$code);
			echo json_encode(array("status"=>"2","result"=>"상품 찜을 해제했습니다."));
			return;
		}

		if(empty($wish)){
			$this->base_model->insertArrayData("tbl_product_wish",array("pcode"=>$code,"userId"=>$this->session->userdata("fuser")));
			echo json_encode(array("status"=>"3","result"=>"상품을 찜했습니다."));
			return;
		}
	}

	public function wish_list(){
		$this->isLoggedIn();
		$data["records_count"] = $this->base_model->getWishedCount();
		$data['category'] = $this->base_model->getCategoryBySh();
		$this->loadViews("wish_list",$this->global,$data,NULL);
	}

	public function getWish(){
		$here = $this->input->post("here");
		$wishes  = $this->base_model->getWishes($here);
		foreach($wishes as $key => $value){
			$wishes[$key]->pc_url = base_url_home();
		}
		echo json_encode(array("status"=>"success","result"=>$wishes));
	}

	public function deleteWishes(){
		$checked_id = $this->input->post("checked_id");
		if(!empty($checked_id))
			$this->base_model->deleteRecordsById("tbl_product_wish","id",$checked_id);
		echo json_encode(array("status"=>"deleted"));
	}

}


