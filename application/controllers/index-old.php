<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Index extends BaseController {

	function __construct()
	{
		parent::__construct();
		$this->load->model('base_model');
		$this->global['pageTitle'] = '구매대행';
		$this->load->helper('form');
		$this->load->helper('url');
		$this->global['headrh'] = getPages("header");
	}

	public function index()
	{
		echo 1;
		return;
		$data['ques'] = $this->base_model->getMail(9,-1,7);
		$data['privas'] = $this->base_model->getMail(4,-1,7);
		$pp = $this->base_model->getSelect("tbl_board",array(array("record"=>"title","value"=>"이용후기")));
    	if(!empty($pp)){
			$data['afters'] =$this->base_model->getReq($pp[0]->id,7,0);
    	}
		
		$data['banner'] = $this->base_model->getSelect("banner",				array(	array("record"=>"use","value"=>1),
																						array("record"=>"type","value"=>1),
																						array("record"=>"mobile","value"=>0)),
																				array(array("record"=>"order","value"=>"ASC")));
		
		$data['s_banner'] = $this->base_model->getSelect("banner",				array(	array("record"=>"use","value"=>1)
																						,array("record"=>"type","value"=>2)),
																				array(array("record"=>"order","value"=>"ASC")));
		
		$data['popups'] = $this->base_model->getPopup();
		
		
		$data['reProducts'] = $this->base_model->getSelect("tbl_recommend_products", 	array(array("record"=>"use","value"=>1)),
																						array(array("record"=>"updated_date","value"=>"DESC")));
		$data['jlca'] = getBanners(12);
		$data['blogs'] = getBanners(15);
		$data['inan'] = getBanners(14);
		$data['caan'] = getBanners(13);
		$data['cats'] = $this->base_model->getCategoryBySh();
		$data['event_home'] = $this->base_model->getSelect("tbl_eventhome",				array(	array("record"=>"use","value"=>1)
																						,array("record"=>"id","value"=>1)));
		$this->loadViews('index', $this->global, $data , NULL);

	}

	public function UserPage(){
				
	}

	public function delivery(){
		$this->isLoggedIn();
		$aa = array();
		$delivery_address  = $this->base_model->getSelect("delivery_address",array(array("record"=>"use","value"=>1)));
		$type = $this->input->get('options');
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
		$fee_t = sizeof($this->base_model->getSelect("tbl_shipping_fee")) > 0 ? $this->base_model->getSelect("tbl_shipping_fee"):null;
		$data['fees'] = is_null($fee_t) ? "":$fee_t[0];
		$data['contacts'] = $this->base_model->getSelect("tbl_mycontact",array(array("record"=>"userId","value"=>$this->session->userdata('fuser'))));
		$data["pp"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'4')));
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
		$fee_t = $this->base_model->getSelect("tbl_accurrate",null,array(array("record"=>"created_date","value"=>"DESC")));
		$data['accuringRate']  = $fee_t[0];
		$records_count = sizeof($this->base_model->getSelect("tbl_sproducts",	array(	array("record"=>"use","value"=>1),
																					array("record"=>"sold","value"=>1)),
																			array(array("record"=>"updated_date","value"=>"DESC"))));
		$returns = $this->paginationCompress ( "shopping/", $records_count, 10);

		$data['products'] = $this->base_model->getSelect("tbl_sproducts",	array(	array("record"=>"use","value"=>1),
																					array("record"=>"sold","value"=>1)),
																			array(array("record"=>"updated_date","value"=>"DESC")),
																			null,
																			array(array("record"=>$returns["page"] ,"value"=>$returns["segment"])));

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

	public function mypage(){
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

		if($this->input->get("today")== "" ){
			$from = $this->input->get("from");
			$to = $this->input->get("to");
		}
		else if($this->input->get("today") =="D1"){
			$from = date("Y-m-d");
			$to =  date("Y-m-d");
		}
		else if($this->input->get("today") =="D7"){
			$from = date("Y-m-d",strtotime("-7 day"));
			$to =  date("Y-m-d");
		}
		else if($this->input->get("today") =="M1"){
			$from = date("Y-m-d", strtotime("-1 months"));
			$to =  date("Y-m-d");
		}
		else if($this->input->get("today") =="M3"){
			$from = date("Y-m-d", strtotime("-3 months"));
			$to =  date("Y-m-d");
		}
		if($this->input->get("process") == "" || $this->input->get("process") ==1){
			$process ="updated_date";
		}
		else $process ="created_date";

		$stateCount = $this->base_model->getStateByUserId();
		foreach ($stateCount as $key => $value) {
			$step_array[$value->state] = $value->stateCount;
		}
		if(isset($step) && $step!=null){
			$records_count = sizeof($this->base_model->getDeliverContent(null,0,null,$step,$this->session->userdata('fuser'),$from,$to,$process,$this->input->get("search_ptracking"),$this->input->get("search_tracking_number"),$this->input->get("search_receiver"),$this->input->get("search_porder")));
			$returns = $this->paginationCompress ( "mypage/", $records_count, 10);
			$delivery_content = $this->base_model->getDeliverContent($returns["page"] ,$returns["segment"],null,$step,$this->session->userdata('fuser'),$from,$to,$process,$this->input->get("search_ptracking"),$this->input->get("search_tracking_number"),$this->input->get("search_receiver"),$this->input->get("search_porder"));
			
		}
		else {
			$records_count = sizeof($this->base_model->getDeliverContent(null,0,null,null,$this->session->userdata('fuser'),$from,$to,$process,$this->input->get("search_ptracking"),$this->input->get("search_tracking_number"),$this->input->get("search_receiver"),$this->input->get("search_porder")));
			$returns = $this->paginationCompress ( "mypage/", $records_count, 10);
			$delivery_content = $this->base_model->getDeliverContent($returns["page"] ,$returns["segment"],null,null,$this->session->userdata('fuser'),$from,$to,$process,$this->input->get("search_ptracking"),$this->input->get("search_tracking_number"),$this->input->get("search_receiver"),$this->input->get("search_porder"));
			
		}

		$data = array(
			'delivery' =>$delivery,
			'category'  =>$category,
			'deliver_content' =>$delivery_content,
			"step_array" =>$step_array,
			'step' => $step
		);
		$data['errorCoutr']  = $this->base_model->getErrorProductsCount();
		$data['contacts'] = $this->base_model->getSelect("tbl_mycontact",array(array("record"=>"userId","value"=>$this->session->userdata('fuser'))));
		$this->loadViews('mypage', $this->global, $data , NULL);
	}

	public function offten_question(){
		$shCol="";
		$shKey = "";
		if(!empty($_GET['shCol'])) $shCol = $_GET['shCol'];
		if(!empty($_GET['shKey'])) $shKey = $_GET['shKey'];
		if($this->input->get("category")!=""){
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
		if($this->input->get("category")!=""){
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
  		$returns = $this->paginationCompress ( "panel/", $records_count, 10);
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
		$data['user'] = $this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$this->session->userdata('fuser'))));
		$this->loadViews('member', $this->global, $data , NULL);
	}
	public function mailbox(){
		$this->isLoggedIn();
		$shCol="";
		$shKey = "";
		if(!empty($_GET['shCol'])) $shCol = $_GET['shCol'];
		if(!empty($_GET['shKey'])) $shKey = $_GET['shKey'];
		$data['ques'] = $this->base_model->getMail(0,-1,"",$this->session->userdata('fuser'),$shCol,$shKey);
		$this->loadViews('mailbox', $this->global, $data , NULL);
	}
	public function coupon(){
		$data['coupon'] = $this->base_model->getCouponLists(0,1);
		$this->loadViews('coupon', $this->global, $data , NULL);
	}

	public function quesanw(){
		if($this->input->get("category")!=""){
			$data['ques'] = $this->base_model->getMail(1,$this->input->get("category"));
		}
		else{
			$data['ques'] = $this->base_model->getMail(1);
		}
		
		$this->loadViews('quesanw', $this->global, $data , NULL);
	}
	public function deposit(){
		$this->isLoggedIn();
		$fee_t = $this->base_model->getSelect('tbl_users',array(array("record"=>"userId","value"=>$this->session->userdata("fuser"))));
		$current_deposit = $fee_t[0];
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
		$data['content'] = $this->base_model->getDeliverWaitingPay(10,0);
		$fee_t = $this->base_model->getSelect('tbl_users',array(array("record"=>"userId","value"=>$this->session->userdata("fuser"))));
		$current_deposit = $fee_t[0]->deposit;
		$this->session->set_userdata('fdeposit', $current_deposit);
		$data['bank'] = $this->base_model->getSelect("tbl_bank");
		$this->loadViews('mypay', $this->global, $data , NULL);
	}

	public function insertDeliver(){
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
							"created_date"=>date("Y-m-d H:i:s"));
		if($this->input->post("ordersp") ==1){
			$post_data['shop'] = 1;
		}
		$insert_id = $this->base_model->insertArrayData("delivery",$post_data);
		$oo = date("y").date("m").date("d").str_pad($insert_id, 4, '0', STR_PAD_LEFT);
		if($insert_id > 0){
			$this->base_model->insertArrayData("tbl_service_delivery",array("content"=>json_encode($aa),"delivery_id"=>$insert_id));
			$this->base_model->updateDataById($insert_id,array("ordernum"=>$oo),"delivery","id");
			$this->base_model->insertPurchase($theader,$insert_id);
			if($this->input->post("ordersp") ==1){
				$this->base_model->deleteRecordsById("tbl_basket","userId",$this->session->userdata('fuser'));
			}
			if(!empty($baskets) && sizeof(json_decode($baskets)) >0){
				foreach (json_decode($baskets) as $key => $value) {
					$this->base_model->deleteRecordsById("tbl_basket","id",$value);
				}
			}
		}
		echo $oo;
	}

	public function login(){
		$this->loadViews('login', $this->global, NULL , NULL);
	}

	public function register(){
		if(!is_empty($this->session->userdata('fuser')))
			redirect("/");
		$data["p"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'2')));
    	$data["p1"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'3')));
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
            echo "d";	
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
                                            'flevel' =>$res->level
                                    );
                                    
                    $this->session->set_userdata($sessionArray);
                    $this->base_model->updateDataById($res->userId,array("log_num"=>intval($res->log_num)+1,"log_date"=>date("Y-m-d")),"tbl_users","userId");
                    redirect('/');
                }

            }
            else
            {
                $this->session->set_flashdata('error', 'Email or password mismatch');
                
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
    						'password'=>getHashedPassword($sMemPw), 
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
    		$this->base_model->updateDataById($insert_id,array("sase"=>"AH".str_pad($insert_id, 4, '0', STR_PAD_LEFT)),"tbl_users","userId");
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
                                                        "title"=>"회원님에게 쿠폰이 발행되었습니다.",
                                                        "content"=>"회원님에게 쿠폰이 발행되었습니다.",
                                                        "type"=>0,
                                                        "view"=>0,
                                                        "updated_date"=>date("Y-m-d H:i:s")));
    		}
    		$cc = $this->base_model->getSelect("tbl_point",array(	array("record"=>"type","value"=>1)));
    		if(!empty($cc)){
    			$this->base_model->plusValue("tbl_users","point",$cc[0]->point,array(array("userId",$insert_id)),"+");
    			$this->base_model->insertArrayData("tbl_mail",array("toId"=>$insert_id,
                                                        "fromId"=>1,
                                                        "title"=>"포인트 적용",
                                                        "content"=>"회원님에게 포인트가 적용되었습니다.\n 포인트 페이지에서 직접 확인하세요",
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
		$MemPntMny = !is_empty($this->input->post("MemPntMny")) ? str_replace(",","",$this->input->post("MemPntMny")) : 0;
		$security = date("ymd").generateRandomString(10);
		if($OlnPmtCd ==4) $pending =1;
		if($OlnPmtCd ==5) $pending	=0;
		$state = "";
		$type = "";
		$pp ="";
		
		foreach ($seqOrd as $key => $value) {
			$ar=array();
			$dels= $this->base_model->getStateByDeliveryId($value);
			if(empty($dels)) return;
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
				if($i==4) $lr = 54;
				if($i==5) $lr = 47;
				if($i==6) $lr = 51;
				$fee_t = explode("|", $this->input->post("CPN_".$i."_".$value));
				$code = $fee_t[0];
				$coo = $this->base_model->getSelect("tbl_coupon",array(array("record"=>"code","value"=>$code)));
				$tt=0;
				$gt = "";
				if($lr!="" && isset($ar[$lr]) && !is_empty($this->input->post("CPN_".$i."_".$value))){
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
					$this->base_model->insertArrayData(	"tbl_payhistory",array(
																			"all_amount"=>$tt <= 0  ? $ar[$lr] : $gt,
																			"payed_date"=>date("Y-m-d H:i:s"),
																			"type"=>10,
																			"amount"=>$tt <= 0  ? $ar[$lr] : $gt,
																			"payed_type"=>10,
																			"coupon"=>$coo[0]->id,
																			"userId"=>$this->session->userdata('fuser'),
																			"security"=>$security));
				
				}
				if($lr=="" && !is_empty($this->input->post("CPN_".$i."_".$value))){
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
					$this->base_model->insertArrayData(	"tbl_payhistory",array(
																			"all_amount"=>$tt <= 0  ? $dels[0]->sending_price : $gt,
																			"payed_date"=>date("Y-m-d H:i:s"),
																			"type"=>10,
																			"amount"=>$tt <= 0  ? $dels[0]->sending_price : $gt,
																			"payed_type"=>10,
																			"coupon"=>$coo[0]->id,
																			"userId"=>$this->session->userdata('fuser'),
																			"security"=>$security));
				}
			}

			$this->base_model->updateDataById($value,array("content"=>json_encode($ar)),"tbl_service_delivery","delivery_id");
			
			if($pending == 1 && $state !=5 && $state!=14 && $state!=20){
				$this->base_model->updateDataById($value,array("add_check"=>2),"tbl_add_price","id");
			}
			if($pending == 0 && $pp!="add_check"){
				if($pp=="payed_checked"){
					$am = (int)($MemDpstMny/10000);
					$ed = $this->base_model->getSelect("tbl_point",	array(	array("record"=>"type","value"=>2),
																			array("record"=>"from_gold <=","value"=>$am )),
																	array(array("record"=>"from_gold","value"=>"DESC")));
					if(!empty($ed)){
						foreach ($ed as $key => $value_p) {
							$tt = $value_p->point_type;
							$tp = $value_p->point;
							if($tt==2)
								$tp = $MemDpstMny*$tp/100;
							$this->base_model->plusValue("tbl_users","point",$tp,array(array("userId",$this->session->userdata('fuser'))),"+");
							$ss = $this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$this->session->userdata('fuser'))));
							$this->base_model->insertArrayData("tbl_point_users",array( "userId"=>$this->session->userdata('fuser'),
	                                                                      				"point_id"=>$value_p->id,
	                                                                  					"point"=>"+".$tp,
	                                                                  					"type"=>$value_p->type,
	                                                                  					"remain"=>$ss[0]->point));
							$this->base_model->insertArrayData("tbl_mail",array("toId"=>$this->session->userdata('fuser'),
	                                                        "fromId"=>1,
	                                                        "title"=>"포인트 적립.",
	                                                        "content"=>"회원님에게 포인트가 적립되었습니다.\n 포인트 페이지에서 직접 확인하세요",
	                                                        "type"=>0,
	                                                        "view"=>0,
	                                                        "updated_date"=>date("Y-m-d H:i:s")));
							}
						
					}
					$ed = $this->base_model->getSelect("tbl_point",	array(	array("record"=>"type","value"=>3),
																			array(	"record"=>"SUBSTRING_INDEX(terms,\"|\",1) <=",
																							"value"=>date("Y-m-d") ),
																			array(	"record"=>"SUBSTRING_INDEX(terms,\"|\",-1) >=",
																							"value"=>date("Y-m-d") )));
					
					if(!empty($ed)){
						foreach ($ed as $key => $value_p) {
							$tt = $value_p->point_type;
							$tp = $value_p->point;
							if($tt==2)
								$tp = $MemDpstMny*$tp/100;
							$this->base_model->plusValue("tbl_users","point",$tp,array(array("userId",$this->session->userdata('fuser'))),"+");
							$ss = $this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$this->session->userdata('fuser'))));
							$this->base_model->insertArrayData("tbl_point_users",array( "userId"=>$this->session->userdata('fuser'),
	                                                                      				"point_id"=>$value_p->id,
	                                                                  					"point"=>"+".$tp,
	                                                                  					"type"=>$value_p->type,
	                                                                  					"remain"=>$ss[0]->point));
							$this->base_model->insertArrayData("tbl_mail",array("toId"=>$this->session->userdata('fuser'),
	                                                        "fromId"=>1,
	                                                        "title"=>"포인트 적립.",
	                                                        "content"=>"회원님에게 포인트가 적립되었습니다.\n 포인트 페이지에서 직접 확인하세요",
	                                                        "type"=>0,
	                                                        "view"=>0,
	                                                        "updated_date"=>date("Y-m-d H:i:s")));
							}
					}

					$pros =  $this->base_model->getProductShoppinmal($value);
					$points= 0;
					foreach($pros as $vals){
						$this->base_model->plusValue("tbl_sproducts","count",$vals->count,array(array("id",$vals->shop)),"+");	
						$points = $points+$vals->point*$vals->count;
					}
					if(!empty($pros) && $points > 0){
						$this->base_model->plusValue("tbl_users","point",$points,array(array("userId",$this->session->userdata('fuser'))),"+");
						$this->base_model->insertArrayData("tbl_mail",array("toId"=>$this->session->userdata('fuser'),
                                                        "fromId"=>1,
                                                        "title"=>"포인트 적립.",
                                                        "content"=>"회원님에게 포인트가 적립되었습니다.\n 포인트 페이지에서 직접 확인하세요",
                                                        "type"=>0,
                                                        "view"=>0,
                                                        "updated_date"=>date("Y-m-d H:i:s")));
						$ss = $this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$this->session->userdata('fuser'))));
						$this->base_model->insertArrayData("tbl_point_users",array( "userId"=>$this->session->userdata('fuser'),
                                                                  		"point"=>"+".$points,
                                                                  		"s"=>0,
                                                                  		"type"=>5,
                                                                  		"remain"=>$ss[0]->point));
					}
					

				}
				$this->base_model->updateDataById($value,array("state"=>$state,$pp=>1),"delivery","id");
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
															"point"=>$MemPntMny));
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

		echo json_encode(array("p"=>$pending,"o"=>$this->input->post("seqOrd")));
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
		redirect('/deposit');
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
    	$option = "";
    	$id= $this->input->get("CATE_SEQ");
    	$category = $this->base_model->getSelect("tbl_category",
																array(array("record"=>"parent","value"=>$id)),
																array(array("record"=>"updated_date","value"=>"DESC")));
    	$option.="<option value=''>품목은 정확하게 선택해주세요</option>";
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

    	$len = $this->input->post("len");
    	$sTIT = $this->input->post("sTIT");
    	$sCT = $this->input->post("sCT");
    	$content = $this->input->post("content");
    	$bbc_code = $this->input->post("bbc_code");
    	$state = $this->input->post("state");
    	$file1="";
    	$file2="";
    	$file3="";
    	$panel = $this->base_model->getSelect("tbl_board",array(array("record"=>"id","value"=>$bbc_code)));
    	if(empty($panel)){
    		echo json_encode(array("error"=>1,"message"=>"해당 게시판이 존재하지 않습니다."));
    		return;
    	}
    	if (!file_exists("upload/mail"))	
      		mkdir("upload/mail", 0777);
	  	$this->load->library('upload',$this->set_upload_options("upload/mail",$len*1024,'*',false));
	    $this->upload->initialize($this->set_upload_options("upload/mail",$len*1024,'*',false));
	    if(!empty($_FILES['file1']['name']) && $_FILES['file1']['name'] !=""){
	      if ( ! $this->upload->do_upload('file1'))
	      {
	        $error = array('error' => "최대 업로드 파일크기는 ".$panel[0]->file_size."MB입니다.");
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
	        $error = array('error' => "최대 업로드 파일크기는 ".$panel[0]->file_size."MB입니다.");
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
	        $error = array('error' => "최대 업로드 파일크기는 ".$panel[0]->file_size."MB입니다.");
	        echo json_encode(array("error"=>1,"message"=>$this->upload->display_errors()."<br>최대 업로드 파일크기는 ".$panel[0]->file_size."MB입니다."));
	        return;
	      }
	      else
	      {
	        $img_data = $this->upload->data();
	        $file3=$img_data["file_name"];
	      }
	    }
    	$security = 0;
    	if(!is_empty($this->input->post("security")) && $this->input->post("security")!="")
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
	    														"security"=>$security,
	    														"file1"=>$file1,
	    														"file2"=>$file2,
	    														"file3"=>$file3);
	  	if(!empty($state) && $state!=""){
	  		$data['mode'] = $state;
	  	}
	  	if(!empty($sCT) && $sCT!=""){
	  		$data['category'] = $sCT;
	  	}
	  	$insert_id = $this->base_model->insertArrayData("tbl_mail",$data);
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
			|| is_empty($this->session->userdata('fuser')) ){

		}
		else{
			$this->base_model->plusValue("tbl_mail","view",1,array(array("id",$id)),"+");
		}
    	
		$this->loadViews('afterview', $this->global, $data , NULL);	
    }

    public function insertComment(){
    	$content = $this->input->post("content");
    	$postId = $this->input->post("postId");
    	$id=$this->input->post("id");
    	if(empty($id))
    	$insert_id =  $this->base_model->insertArrayData("tbl_comment",array( 	"postId"=>$postId,
    																			"userId"=>$this->session->userdata('fuser'),
    																			"content"=>$content));
    	else
    		$insert_id =  $this->base_model->updateDataById($id,array( "content"=>$content),"tbl_comment","id");
    	if($insert_id > 0) {echo 1;return;}
    	echo 2;
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
    private function set_upload_options($path,$max_size=300000,$allowed='*',$enc = true)
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
    		$this->load->library('upload',$this->set_upload_options("upload/delivery"));
          	$this->upload->initialize($this->set_upload_options("upload/delivery"));
          	if ( ! $this->upload->do_upload('FILE_NM'))
	        {
	           $error = array('error' => $this->upload->display_errors());
	           echo json_encode(array("errorId"=>1));
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
      if(!is_empty($this->input->get("option"))){
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
        $telephone = $this->input->post('telephone');
        $details = $this->input->post('details');
        $sEmailRcvYN= $this->input->post('sEmailRcvYN');
        $sSmsRcvYN= $this->input->post('sSmsRcvYN');
        if(empty($password))
        {
            $userInfo = array('email'=>$email,'mobile'=>$mobile, 'updatedDtm'=>date('Y-m-d H:i:s'),
                            'postNum'=>$zip,'address'=>$addr_1,'detail_address'=>$details,'telephone'=>$telephone,
                        	"smsRecevice"=>$sSmsRcvYN,"emailRecevice"=>$sEmailRcvYN);
        }
        else
        {
            $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password),'mobile'=>$mobile, 
                'updatedDtm'=>date('Y-m-d H:i:s'),'postNum'=>$zip,'address'=>$addr_1,'detail_address'=>$details,'telephone'=>$telephone,"smsRecevice"=>$sSmsRcvYN,"emailRecevice"=>$sEmailRcvYN);
        }
        
        $result = $this->base_model->editUser($userInfo, $this->session->userdata('fuser'));
        
        if($result == true)
        {
            $this->session->set_flashdata('success', 'User updated successfully');
        }
        else
        {
            $this->session->set_flashdata('error', 'User updation failed');
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
    	if(!is_empty($this->input->post("out")) && $this->input->post("out")==1){
    		echo $this->session->userdata("wat");
    		if($this->session->userdata("wait")==1){
    			$this->session->set_userdata(array("wat"=>(float)0));
    		}
    		return;
    	}
    }
    public function multiupload(){
    	$this->load->library('PHPExcel');
    	$data = array();
    	$this->load->library('upload',$this->set_upload_options("upload/excel",30000,"*",false));
        $this->upload->initialize($this->set_upload_options("upload/excel",30000,"*",false));
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
				    
				    $id          = $value['A'];
				    $des         = $value['B'];
				    $name        = $value['C'];
				    $eng         = $value['D'];
				    $person_num  = $value['E'];
				    $empty 		 = $value['F'];
				    $phone       = $value['G'];
				    $use_type    = $value['H'];
				    $postcode    = $value['I'];
				    $address     = $value['J'];
				    $eng_address = $value['K'];
				    $req 		 = $value['L'];
				    $order_no 	 = $value['M'];
				    $pro_eng 	 = $value['N'];
				    $color 		 = $value['O'];
				    $size 		 = $value['P'];
				    $count 		 = $value['Q'];
				    $unit 		 = $value['R'];
				    $image 		 = $value['S'];
				    $pro_url 	 = $value['T'];
				    $tracking 	 = $value['U'];
				    $spec 		 = $value['V'];
				    $name_no 	 = $value['W'];
					if(!is_numeric($id) || $des==""|| $name=="" || $person_num=="" || $phone=="" || $use_type=="" || $postcode=="" || $address=="" 	|| $pro_eng =="" || $count =="" || $unit=="" || $name_no==""){
					 	continue;
					}
					$p_name = "NONE";
					$ss = $this->base_model->getSelect("tbl_category",array(array("record"=>"id","value"=>$name_no)));
					if(!empty($ss)) $p_name=$ss[0]->en_subject; 			
					$temp= array(
				      'des'   => 1,
				      'name'    => $name,
				      'eng'  => $eng,
				      'person_num'   => $person_num,
				      'empty'  => $empty,
				      'phone'   => $phone,
				      'use_type'    => $use_type,
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
				      'name_no'   => $name_no
				    );
					$data[$id][] =$temp;
			    }
			    if($this->input->post("type") !=1){
					$types = 2;
					$state = 4;
				}
				else{
					$types = 1;
					$state = 2;
				}
			    foreach ($data as $key => $value) {
			    	$post_data=  array( "place" => $value[0]['des'],
								"incoming_method" =>3,
								"billing_name"=> $value[0]['eng'],
								"billing_krname"=>$value[0]['name'],
								"person_num" => 1,
								"person_unique_content" => $value[0]['person_num'],
								"phone_number" =>$value[0]['phone'],
								"post_number"=> $value[0]['postcode'],
								"address" => $value[0]['address'],
								"detail_address" =>$value[0]['eng_address'] ,
								"request_detail" => $value[0]['req'],
								"logistics_request" =>$value[0]['spec'],
								"type" => $types,
								"state" =>$state,
								"get"=>$this->input->post("type") !=1 ? "buy":"delivery",
								"userId"=>$this->session->userdata('fuser'),
								"created_date"=>date("Y-m-d H:i:s"),
								"updated_date"=>date("Y-m-d H:i:s"));
					$insert_id = $this->base_model->insertArrayData("delivery",$post_data);
					if($insert_id > 0){
						$this->base_model->updateDataById($insert_id,array("ordernum"=>date("y").date("m").date("d").str_pad($insert_id, 4, '0', STR_PAD_LEFT)),"delivery","id");
						foreach ($value as $keyw => $valuew) {
							$pro_item = array( 			"delivery_id"=>$insert_id,
		                                                "trackingHeader"=>1,
		                                                "trackingNumber"=>$valuew["tracking"],
		                                                "order_number"=>$valuew["order_no"],
		                                                "parent_category"=>"",
		                                                "category"=>$valuew["name_no"],
		                                                "productName"=>$valuew["pro_eng"],
		                                                "unitPrice"=>$valuew["unit"],
		                                                "count"=>$valuew["count"],
		                                                "color"=>$valuew["color"],
		                                                "size"=>$valuew["size"],
		                                                "url"=>$valuew["pro_url"],
		                                                "image"=>$valuew["image"],
		                                                "step"=>11,
		                                                "created_date"=>date("Y-m-d H:i"));
							$this->base_model->insertArrayData("tbl_purchasedproduct",$pro_item);
						}
					}
					sleep(1);
					$this->session->set_userdata(array("wat"=>(float)($key+1)/sizeof($data)));
			    }
			    $this->session->set_userdata(array("wat"=>1));
			    echo json_encode(array("errorId"=>0));
	        }	    
    	}
    	else{
    		echo json_encode(array("errorId"=>1));
    	}	
    }

    public function getPricesByRole(){
    	$this->isLoggedIn();
    	if(!is_empty($this->input->get("option"))) $option=$this->input->get("option");
    	else $option = 1;
    	$data['delivery_address'] = $this->base_model->getSelect("delivery_address",	array(array("record"=>"use","value"=>1)));
    	
    	$data['deli'] = $this->base_model->getSelect("tbl_deliverytable",				array(array("record"=>"address","value"=>$option)),
    																					array(array("record"=>"startWeight","value"=>"ASC")));
    	$data['role'] = $this->base_model->getRoleByMember("yes",1);
    	
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
    	echo json_encode(array("result"=>100,"value"=>$result));
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

		if(is_empty($this->session->userdata('fuser')) || $this->session->userdata('fuser') == NULL){
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
		if(empty($data['delivery'])) {redirect("/");return;}
		$data['products'] = $this->base_model->getSelect("tbl_purchasedproduct",array(array("record"=>"delivery_id","value"=>$id)));
		$fee_t = sizeof($this->base_model->getSelect("tbl_shipping_fee")) > 0 ? $this->base_model->getSelect("tbl_shipping_fee"):"";
		$data['fees'] = $fee_t!="" ? $fee_t[0]:"";
		$data['adding'] = $this->base_model->getSelect("tbl_add_price",array(array("record"=>"id","value"=>$id)));
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
		$this->loadViews("viewDelivery",$this->global,$data,NULL);
	}

	public function getDproducts(){
		if($this->session->userdata("fuser") <=0) return;
		$delivery_id = $this->input->get("dp");
		$pds = $this->base_model->getSelect("tbl_purchasedproduct",array(array("record"=>"delivery_id","value"=>$delivery_id)),array(array("record"=>"updated_date","value"=>"ASC")));
		$str="<tr>
			<td colspan='7' class='proConList'>
				<table class='table table-dark'>
					<thead class='thead-dark'>
						<th class='txtLeft'>번호</th>
						<th class='txtLeft'>상품 이미지</th>
						<th class='txtLeft'>상품명(영문)</th>
						<th class='txtLeft'>Tracking Number<br/>Order No</th>
						<th class='txtLeft'>색상<br/>사이즈</th>
						<th class='txtLeft'>단가(￥), 수량<br/>합계</th>
					</thead>";
		if(sizeof($pds) > 0){
			foreach ($pds as $key => $value) {
				$st= '';
				$tracks ='';
				if(trim($value->trackingNumber) != "" ) $tracks = $value->trackingHeader." ".$value->trackingNumber;
				if($value->step == 0 ) $st = '입고대기';
				if($value->step == 101 ) $st = '입고완료';
				if($value->step == 102 ) $st = '오류입고';
				if($value->step == 103 ) $st = '노데이타';
				$str.="<tr>";
				$str.="<td>";
				$str.=$value->id;
				$str.="</td>";
				$str.="<td>";
				$str.="<img src='".$value->image."' width='60' >";
				$str.="</td>";
				$str.="<td>";
				$str.=$value->productName;
				$str.="</td>";
				$str.="<td>";
				$str.=$tracks;
				$str.="<br>";
				$str.=$value->order_number;
				$str.= "<br>";
				$str.="<p style='color:red'>".$st."</p>";
				$str.="</td>";
				$str.="<td>";
				$str.=$value->color."<br>".$value->size;
				$str.="</td>";
				$str.="<td>";
				$str.=$value->unitPrice.",".$value->count."<br>".$value->unitPrice*$value->count;
				$str.="</td>";
				$str.="</tr>";
			}
		}
		$str.="</table></td></tr>";					
		echo $str;
	}

	function deletesO(){
		$did = explode("|", $this->input->post("did"));
		foreach ($did as $value) {
			if(is_numeric($did) || $did !=0){
				$fee_t = $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$value)));
				$step = $fee_t[0]->state;
				if($step ==1 ||  $step ==2 | $step ==4){
					$this->base_model->deleteRecordsById("delivery","id",$value);
					$this->base_model->deleteRecordsById("tbl_purchasedproduct","delivery_id",$value);
				}
			}
		}
		redirect("/mypage");
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
		$fee_t = sizeof($this->base_model->getSelect("tbl_shipping_fee")) > 0 ? $this->base_model->getSelect("tbl_shipping_fee"):"";
		$data['fees'] = $fee_t!="" ? $fee_t[0]:"";
		$data['delivery']  = $this->base_model->getDeliveryByService($id);
		$data['products'] = $this->base_model->getSelect("tbl_purchasedproduct",array(array("record"=>"delivery_id","value"=>$id)),array(array("record"=>"updated_date","value"=>"ASC")));
		if(sizeof($data['products']))
		{
			$category = $this->base_model->getSelect("tbl_category",array(array("record"=>"parent","value"=>0)));
			foreach($data['products'] as  $key => $value) {
				$chca = $value->category;
				if(is_numeric($chca)){
					$fee_t = $this->base_model->getSelect("tbl_category",array(array("record"=>"id","value"=>$chca)));
					$pid = !is_empty($this->base_model->getSelect("tbl_category",array(array("record"=>"id","value"=>$chca)))) ? 
					$fee_t[0]->parent:1;

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
		$data['sum_price'] = $this->base_model->getPSum($id);
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
		$this->loadViews("editDelivery",$this->global,$data,NULL);
	}

	public function updateDeliver(){
		$id= $this->input->post("id");
		$aa = array();
		$vv = $this->base_model->getSelect("tbl_services");
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
							"main_check"=>$main,
							"detail_check"=>$detail,
							"shoemedical"=>$sh,
							"tackbae"=>$tack,
							"package_protect"=>$package,
							"special_package"=>$sp,
							"onebacs_package"=>$han,
							"cutoms_fee"=>$customs,
							"wonsanji"=>$wonsan,
							"multibacs"=>$multi,
							"volumn_weight"=>$volume,
							"mountain_fee"=>$moun,
							"updated_date"=>date("Y-m-d H:i:s"));
		$this->base_model->updateDataById($id,array("content"=>json_encode($aa)),"tbl_service_delivery","delivery_id");
		$this->base_model->updateDataById($id,$post_data,"delivery","id");
		$this->base_model->deleteRecordsById("tbl_purchasedproduct","delivery_id",$id);
		$this->base_model->insertPurchase($theader,$id);
		redirect("/mypage");
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
		$this->isLoggedIn();
		$data['mybasket'] = $this->base_model->getBasket();
		$this->loadViews("mybasket",$this->global,$data,NULL);
	}

	public function makeorder(){
		$this->isLoggedIn();
		$basket = $this->input->post("basket");
		if(empty($basket) || sizeof($basket) ==0) { 
			echo "<script>alert('최소한 한개이상의 상품이 필요합니다');window.location.href='/mybasket';</script>";return;
		}
		$data['delivery_address']  = $this->base_model->getSelect("delivery_address",array(array("record"=>"use","value"=>1)));
		$data['mybasket'] = $this->base_model->getBasket($basket);
		if(sizeof($data['mybasket']) ==0 ) {redirect("mybasket");return;}
		$delivery_address  = $this->base_model->getSelect("delivery_address",array(array("record"=>"use","value"=>1)));
		$tracking_header = $this->base_model->getSelect("tracking_header");
		$data['delivery_address'] =$delivery_address;
		$data['tracking_header'] =$tracking_header;
		$fee_t= sizeof($this->base_model->getSelect("tbl_shipping_fee")) > 0 ? $this->base_model->getSelect("tbl_shipping_fee"):"";
		$data['fees'] = $fee_t!="" ? $fee_t[0]:"";
		$data['basket'] = $basket;
		$data['sum_price'] = $this->base_model->getPBasket($basket);	
		$shop  ="";
		if(sizeof($data['mybasket']))
		{
			$category = $this->base_model->getSelect("tbl_category",array(array("record"=>"parent","value"=>0)));			
			foreach($data['mybasket'] as  $key => $value) {
				$shop.=$value->productId;
				$shop.="|";
				$chca = $value->category;
				if(!empty($chca)){
					$fee_t = $this->base_model->getSelect("tbl_category",array(array("record"=>"id","value"=>$chca)));
					$pid = $fee_t[0]->parent;
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
		$data['shop']=$shop;
		$data['categorys'] = $category;
		$data["pp"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'4')));
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
		$this->loadViews("makeorder",$this->global,$data,NULL);
	}

	public function changeShopCount(){
		$this->isLoggedIn();
		$this->base_model->updateDataById($this->input->get("id"),array("count"=>$this->input->get("count")),"tbl_basket","id");
	}
	public function shop_products($id){
		$fee_t = $this->base_model->getSelect("tbl_accurrate",null,array(array("record"=>"created_date","value"=>"DESC")));
		$data['accuringRate'] = $fee_t[0];
		$data['product'] = $this->base_model->getSelect("tbl_sproducts",array(array("record"=>"id","value"=>$id)));
		$data['options'] = $this->base_model->getSelect("tbl_options",array(array("record"=>"product_id","value"=>$id),array("record"=>"use","value"=>1)));
		$this->loadViews('shop_products',$this->global,$data,NULL);
	}

	public function addCar(){
		$this->isLoggedIn();
		$id = $this->input->post("id");
		$color = $this->input->post("color");
		$size = $this->input->post("size");
		$pp = $this->base_model->getSelect("tbl_sproducts",array(array("record"=>"id","value"=>$id)));
		if(sizeof($pp) ==0) {return;}
		$bp = $this->base_model->getSelect("tbl_basket",array(	array("record"=>"userId","value"=>$this->session->userdata('fuser')),
																array("record"=>"productId","value"=>$id),
																array("record"=>"color","value"=>$color),
																array("record"=>"size","value"=>$size)));
		if(sizeof($bp) > 0){
			$this->base_model->plusValue("tbl_basket","count",$this->input->post("count"),array(array("id",$bp[0]->id)),"+");
		}
		else{
			$this->base_model->insertArrayData("tbl_basket",array("count"=>$this->input->post("count"),"userId"=>$this->session->userdata('fuser'),"productId"=>$id,"size"=>$size,"color"=>$color));
		}
	}

	public function deleteDeposit(){
		if(is_empty($this->session->userdata('fuser')) || $this->session->userdata('fuser') <=0) echo json_encode(array("status"=>false));
		$id = $this->input->post("id");
		$this->base_model->deleteRecordsById("tbl_request_deposit","id",$id);
		echo json_encode(array("status"=>true));
	}

	public function deposit_history(){
		$this->isLoggedIn();
		$data['history']= $this->base_model->getDepositHistory();
		$this->loadViews('deposit_history',$this->global,$data,NULL);
	}

	public function coupon_list(){
		$this->isLoggedIn();
		$this->load->library('pagination');
		$records_count = sizeof($this->base_model->getUsedCoupon());
		$returns = $this->paginationCompress ( "coupon_list/", $records_count, 10);
		$data['coupon_list'] = $this->base_model->getUsedCoupon($returns["page"] ,$returns["segment"]);
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
		$user_deposit = $this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$this->session->userdata('fuser'))));
		if(sizeof($user_deposit) == 0){redirect("deposit_return");return;}
		$amount = $this->input->post("MNY");
		if($amount > $user_deposit[0]->deposit) {redirect("deposit_return");return;}
		$bank_name = $this->input->post("PYN_NM");
		$bank_number = $this->input->post("PYN_NUMBER");
		$this->base_model->insertArrayData("tbl_deposit_return", array(	"userId"=>$this->session->userdata('fuser'),
																		"amount"=>$amount,
																		"bank_name"=>$bank_name,
																		"bank_number"=>$bank_number,
																		"accept"=>0,
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
				$str.='<div class="box-body table-responsive no-padding">';
				$str.='<table class="table table-hover">';
				if(!empty($value->state) && $value->state=="14"):
					if($value->real_weight > 0):
						$num = floor($value->real_weight);
						$num1 = $value->real_weight-$num;
						if($num1 > 0   &&$num1 < 0.5)  $num = $num + 0.5;
						if($num1 > 0.5 && $num1 < 1  )  $num = $num + 1;
						if($value->sending_price ==0) continue;
						$str.='<tr>
								<th class=""><span class="bold red1">총 배송비용</span></th>
								<td class="tBg"></td>
								<td class="tBg"><span class="bold text-danger">'.$value->sending_price.' 원</span></td>
							</tr>';
						$str.='<tr>
								<th class=""><span class="bold">&nbsp;&nbsp;-실측무게</span></th>
								<td class="ct" style="text-align:left;"></td>
								<td><span class="bold">'.$value->real_weight.'kg</span></td>
							</tr>';
					endif;
					if($value->vlm_wt > 0):
						$str.='<tr>
								<th class=""><span class="bold text-danger">&nbsp;&nbsp;-적용무게</span></th>
								<td class="ct red1" style="text-align:left;"></td>
								<td><span class="bold text-danger">'.$num.'kg</span></td>
							</tr>';
					endif;
						$str.='<tr>
								<th class="">&nbsp;&nbsp;-배송비</th>
								<td></td>
								<td>
								'.number_format($value->sends).'원
								</td>
							</tr>';
					if(!empty($ar)):
					foreach($ar as $key_ar=>$ar_ch):
						if(empty($ar_ch)) continue;
						$str.='<tr>
								<th class="">&nbsp;&nbsp;-'.$ff[$key_ar].'</th>
								<td></td>
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
								<td class="ct red1" style="text-align:left;"></td>
								<td><span class="bold text-danger">'.$value->return_price.'원</span></td>
							</tr>';
					if(str_replace(",","",$value->rfee) > 0 ):
						$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-리턴 수수료</th>
								<td></td>
								<td>
								'.$value->rfee.'원
								</td>
							</tr>';	
					endif;
					$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-리턴 금액</th>
								<td></td>
								<td>
								'.((int)str_replace(",","",$value->return_price)-(int)str_replace(",","",$value->rfee)).'원
								</td>
							</tr>';
					
				endif;
				if(!empty($value->state) && $value->state=="5"):
					$value->purchase_price = str_replace(",", "", $value->purchase_price);
					$str.='<tr>
								<th class=""><span class="bold red1">구매비용</span></th>
								<td class="ct red1" style="text-align:left;"></td>
								<td><span class="bold text-danger">'.number_format($value->purchase_price).'원</span></td>
							</tr>';
					$pur_fee =  explode("|",$value->pur_fee);
					$str.='<tr>
								<th class="">&nbsp;&nbsp;-구매비</th>
								<td></td>
								<td>
								'.number_format($value->purchase_price-($pur_fee[1]*(($pur_fee[0])/100))-str_replace(",","", $value->cur_send)*$pur_fee[2]).'원
								</td>
							</tr>';
						$str.='<tr>
								<th class="">&nbsp;&nbsp;-구매수수료</th>
								<td></td>
								<td>
								'.number_format($pur_fee[1]*(($pur_fee[0])/100)).'원
								</td>
							</tr>';		
					if(str_replace(",","",$value->cur_send) > 0 ):
						$str.='<tr>
								<th class="">&nbsp;&nbsp;-현지배송비</th>
								<td></td>
								<td>
								'.number_format(str_replace(",","", $value->cur_send)*$pur_fee[2]).'원
								</td>
							</tr>';	
					endif;
					
				endif;
				if(empty($value->state) ||  !empty($value->add_check) && $value->add_check==1):
					if($value->agwan > 0 ):
						$str.='<tr>
								<th class="breaken">관부가세</th>
								<td></td>
								<td>
								'.$value->agwan.'원
								</td>
							</tr>';	
					endif;
					if($value->apegi > 0 ):
						$str.='<tr>
								<th class="breaken">페기수수료</th>
								<td></td>
								<td>
								'.$value->apegi.'원
								</td>
							</tr>';	
					endif;
					if($value->acart_bunhal > 0 ):
						$str.='<tr>
								<th class="breaken">카툰분할 수 신고/BL 분할</th>
								<td></td>
								<td>
								'.$value->acart_bunhal.'원
								</td>
							</tr>';	
					endif;
					if($value->acheck_custom > 0 ):
						$str.='<tr>
								<th class="breaken">검역수수료</th>
								<td></td>
								<td>
								'.$value->acheck_custom.'원
								</td>
							</tr>';	
					endif;
					if($value->agwatae > 0 ):
						$str.='<tr>
								<th class="breaken">과태료</th>
								<td></td>
								<td>
								'.$value->agwatae.'원
								</td>
							</tr>';	
					endif;
					$str.='<tr>
								<th class="breaken">추가결제금액</th>
								<td></td>
								<td class="bold text-danger">
								'.$value->add_price.'원
								</td>
							</tr>';	
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
		$aa = array();
		$fee = $this->base_model->getSelect("tbl_service_delivery",array(array("record"=>"delivery_id","value"=>$delivery_id)));
		$str = "";
		$ff = array();
		$fee = $this->base_model->getSelect("tbl_services");
		foreach($fee as $v){
			$ff[$v->id] = $v->name;
		}
		if(sizeof($content) > 0){
			$str='<div class="box-body table-responsive no-padding">';
				$str.='<table class="table table-hover">';
			foreach ($content as $key => $value) {
				
				if($value->sending_price > 0):
					if($value->real_weight > 0):
						$num = floor($value->real_weight);
						$num1 = $value->real_weight-$num;
						if($num1 > 0   &&$num1 < 0.5)  $num = $num + 0.5;
						if($num1 > 0.5 && $num1 < 1  )  $num = $num + 1;
						if($value->sending_price ==0) continue;
						$str.='<tr>
								<th class="breaken"><span class="bold red1">총 배송비용</span></th>
								<td class="tBg"></td>
								<td class="tBg"><span class="bold text-danger">'.$value->sending_price.' 원</span></td>
							</tr>';
						$str.='<tr>
								<th class="breaken"><span class="bold">&nbsp;&nbsp;-실측무게</span></th>
								<td class="ct" style="text-align:left;"></td>
								<td><span class="bold">'.$value->real_weight.'kg</span></td>
							</tr>';
					if($value->vlm_wt > 0):
						$str.='<tr>
								<th class="breaken"><span class="bold text-danger">&nbsp;&nbsp;-적용무게</span></th>
								<td class="ct red1" style="text-align:left;"></td>
								<td><span class="bold text-danger">'.$num.'kg</span></td>
							</tr>';
					endif;
						$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-배송비</th>
								<td></td>
								<td>
								'.number_format(str_replace(",","", $value->sends)).'원
								</td>
							</tr>';
					if(!empty($value->content))
						{
							$ar = json_decode($value->content,true);
						}
						if(!empty($ar)):
						foreach($ar as $key_ar=>$ar_ch):
							if(empty($ar_ch)) continue;
							$str.='<tr>
									<th class="breaken">&nbsp;&nbsp;-'.$ff[$key_ar].'</th>
									<td></td>
									<td>
									'.number_format($ar_ch).'원
									</td>
								</tr>';
						endforeach;
						endif;
					endif;		
					
				endif;		
					$value->purchase_price = str_replace(",", "", $value->purchase_price);
					$pur_fee =  explode("|",$value->pur_fee);
					if($value->purchase_price > 0):
						$str.='<tr>
							<th class="breaken"><span class="bold red1">구매비용</span></th>
							<td class="ct red1" style="text-align:left;"></td>
							<td><span class="bold text-danger">'.number_format($value->purchase_price).'원</span></td>
						</tr>';
						$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-구매비</th>
								<td></td>
								<td>
								'.number_format($pur_fee[1]).'원
								</td>
							</tr>';	
						$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-구매수수료</th>
								<td></td>
								<td>
								'.number_format($pur_fee[1]*(($pur_fee[0])/100)).'원
								</td>
							</tr>';	

						if(str_replace(",","",$value->cur_send) > 0 ):
							$str.='<tr>
									<th class="breaken">&nbsp;&nbsp;-현지배송비</th>
									<td></td>
									<td>
									'.number_format(str_replace(",","", $value->cur_send)*$pur_fee[2]).'원
									</td>
								</tr>';	
						endif;
					
					endif;
				if($value->return_price > 0):
					$str.='<tr>
								<th class="breaken"><span class="bold red1">리턴비용</span></th>
								<td class="ct red1" style="text-align:left;"></td>
								<td><span class="bold text-danger">'.$value->return_price.'원</span></td>
							</tr>';
					if(str_replace(",","",$value->rfee) > 0 ):
						$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-리턴 수수료</th>
								<td></td>
								<td>
								'.$value->rfee.'원
								</td>
							</tr>';	
					endif;
					$str.='<tr>
								<th class="breaken">&nbsp;&nbsp;-리턴 금액</th>
								<td></td>
								<td>
								'.((int)str_replace(",","",$value->return_price)-(int)str_replace(",","",$value->rfee)).'원
								</td>
							</tr>';
					
				endif;

				if($value->add_price > 0):
					$str.='<tr>
								<th class="breaken">추가결제금액</th>
								<td></td>
								<td class="bold text-danger">
								'.$value->add_price.'원
								</td>
							</tr>';	
					if($value->agwan > 0 ):
						$str.='<tr>
								<th class="breaken">관부가세</th>
								<td></td>
								<td>
								'.$value->agwan.'원
								</td>
							</tr>';	
					endif;
					if($value->apegi > 0 ):
						$str.='<tr>
								<th class="breaken">페기수수료</th>
								<td></td>
								<td>
								'.$value->apegi.'원
								</td>
							</tr>';	
					endif;
					if($value->acart_bunhal > 0 ):
						$str.='<tr>
								<th class="breaken">카툰분할 수 신고/BL 분할</th>
								<td></td>
								<td>
								'.$value->acart_bunhal.'원
								</td>
							</tr>';	
					endif;
					if($value->acheck_custom > 0 ):
						$str.='<tr>
								<th class="breaken">검역수수료</th>
								<td></td>
								<td>
								'.$value->acheck_custom.'원
								</td>
							</tr>';	
					endif;
					if($value->agwatae > 0 ):
						$str.='<tr>
								<th class="breaken">과태료</th>
								<td></td>
								<td>
								'.$value->agwatae.'원
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
		$this->isLoggedIn();
		$delivery_id = $this->input->post("orders");
		$chkORD_SEQ = $this->input->post("chkORD_SEQ");
		if(sizeof($chkORD_SEQ) < 2 ) {echo "<script>alert('한개 상품은 불가합니다.나눔배송으로 해주세요');self.close()</script>";return;}
		if(empty($delivery_id)) {echo "<script>self.close()</script>";return;}
		$content = $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$delivery_id)));
		if(sizeof($content) ==0 ) {echo "<script>self.close()</script>";return;}
		$content = $content[0];
		$content->combine =1;
		unset($content->id);
		$insert_id = $this->base_model->insertArrayData("delivery",$content);
		if($insert_id > 0):
			$this->base_model->updateDataById($insert_id,array("ordernum"=>date("y").date("m").date("d").str_pad($insert_id, 4, '0', STR_PAD_LEFT)),"delivery","id");
			foreach($chkORD_SEQ as $key=>$value):
				$value = explode("|", $value);
				$fee_t = $this->base_model->getSelect("tbl_purchasedproduct",array(array("record"=>"id","value"=>$value[0])));
				if(empty($fee_t) || $fee_t==null):echo "<script>alert('상품정보가 명확치 않습니다.관리자에게 문의하십시요.');self.close()</script>";  endif;
				$product = $fee_t[0];				
				$fee_t = $this->input->post("MNS_CNT");
				$product->count = $product->count-$fee_t[$key];

				if($product->count == 0) {
					$this->base_model->updateDataById($value[0],array("delivery_id"=>$insert_id),"tbl_purchasedproduct","id");
				}
				if($product->count > 0) {
					$this->base_model->updateDataById($value[0],array("count"=>$product->count),"tbl_purchasedproduct","id");
					$fee_t = $this->input->post("MNS_CNT");
					$product->count = $fee_t[$key];
					$product->delivery_id = $insert_id;
					unset($product->id);
					$this->base_model->insertArrayData("tbl_purchasedproduct",$product);
				}
				
			endforeach;
			$this->base_model->updateDataById($insert_id,array("state"=>40),"delivery","id");
		endif;
		echo "<script>alert('성공적으로 진행되였습니다.');self.close()</script>";
	}
	public function ActingMinus_I(){
		$this->isLoggedIn();
		$delivery_id = $this->input->post("orders");
		$chkORD_SEQ = $this->input->post("chkORD_SEQ");
		if(empty($delivery_id)) {echo "<script>alert('해당 주문이 존재하지 않습니다.');self.close()</script>";return;}
		$content = $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$delivery_id)));
		if(sizeof($content) ==0 ) {echo "<script>self.close()</script>";return;}
		$content = $content[0];
		$content->combine =2;
		unset($content->id);
		$insert_id = $this->base_model->insertArrayData("delivery",$content);
		if($insert_id > 0):
			$this->base_model->updateDataById($insert_id,array("ordernum"=>date("y").date("m").date("d").str_pad($insert_id, 4, '0', STR_PAD_LEFT)),"delivery","id");
			foreach($chkORD_SEQ as $key=>$value):
				$fee_t = $this->base_model->getSelect("tbl_purchasedproduct",array(array("record"=>"id","value"=>$value)));
				if(empty($fee_t) || $fee_t==null):echo "<script>alert('상품정보가 명확치 않습니다.관리자에게 문의하십시요.');self.close()</script>";  endif;
				$product = $fee_t[0];
				
				$fee_t =  $product->count-$this->input->post("MNS_CNT");
				$product->count = $product->count-$fee_t[$key];
				if($product->count == 0) {
					$this->base_model->updateDataById($value,array("delivery_id"=>$insert_id),"tbl_purchasedproduct","id");
				}
				if($product->count > 0) {
					$this->base_model->updateDataById($value,array("count"=>$product->count),"tbl_purchasedproduct","id");
					$product->delivery_id = $insert_id;
					$fee_t =  $product->count-$this->input->post("MNS_CNT");
					$product->count = $fee_t[$key];
					unset($product->id);
					$this->base_model->insertArrayData("tbl_purchasedproduct",$product);
				}
			endforeach;
			$this->base_model->updateDataById($insert_id,array("state"=>40),"delivery","id");
		endif;
		echo "<script>alert('성공적으로 진행되였습니다.');self.close()</script>";
	}

	public function requestDelivery(){

		$id = $this->input->post("id");
		if(!empty($id)):
			$this->base_model->updateDataById($id,array("state"=>40),"delivery","id");
			echo 100;
			return;
		endif;
		echo 101;
	}
	
	public function MemCtr_S(){
		$this->isLoggedIn();
		$data['contents'] = $this->base_model->getSelect("delivery_address",array(array("record"=>"use","value"=>1)));
		$data['user'] = $this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$this->session->userdata('fuser'))));
		$this->load->view("MemCtr_S",$data);
	}
	public function view_photo(){
    $id=$this->input->get("sOrdSeq");
    if(empty($id)) return;
    $fee_t = $this->base_model->viewPhoto($id);
    $data['delivery'] =  $fee_t[0];
    if(empty($data['delivery']) || $data['delivery']==null) return;
    $this->load->helper('directory');
    $data['map']= directory_map('./upload/silsa/'.$id, FALSE, TRUE);
    $this->load->view("view_photo",$data);
  }

  public function deleteBasket(){
  	$id = $this->input->post("id");
  	$this->base_model->deleteRecordsById("tbl_basket","id",$id);
  	echo 1;
  }

  public function Dlvr_Mny_Pop_W(){
  	$data["sMemLvl"] = !is_empty($this->input->post("sMemLvl")) ? $this->input->post("sMemLvl"):"";
  	$data["sCtrSeq"] = !is_empty($this->input->post("sCtrSeq")) ? $this->input->post("sCtrSeq"):"";
  	$data["sTotMny"] = !is_empty($this->input->post("sTotMny")) ? $this->input->post("sTotMny"):"0";
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
  	$this->loadViews("public",$this->global,$data,null);
  }

  public function use_1(){
  	$data['content'] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>14)));
  	$this->loadViews('deliveryShow',$this->global,$data,NULL);
  }

  public function com_profile(){
  	$data['content'] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>75)));
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
			force_download("upload/mail/".$file_name,NULL);
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
  	$id = $this->input->post("id");
  	if($id > 0 ){
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
		$this->base_model->updateDataById($id,$post_data,"delivery","id");
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
		$id = $this->input->get("id");
		$data["content"] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>$id)));
		$this->loadViews('ipage',$this->global,$data,NULL);
	}
}

