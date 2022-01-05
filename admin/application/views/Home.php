  <?php if(!defined('BASEPATH')) exit('No direct script access allowed');

  require APPPATH . '/libraries/BaseController.php';
  /**
   * Class : Login (LoginController)
   * Login class to control to authenticate user credentials and starts user's session.
   * @author : Kishor Mali
   * @version : 1.1
   * @since : 15 November 2016
   */
  class Home extends BaseController
  {
      /**
       * This is default constructor of the class
       */
      public function __construct()
      {
        parent::__construct();
        $this->load->library('encryption');
        $this->encryption->initialize(cRYPT);
        $this->encryption->initialize(array('driver' => 'mycript'));
        $this->load->model('base_model');
        $this->isLoggedIn();
        $this->load->helper('form');
        $this->global['pageTitle'] = '배송구매관리';
        $this->global['menu_list'] = array();
        $t_roles = get_roles($this->session->userdata('userId'));
        if(!empty($t_roles))
         $this->global['menu_list']  = json_decode($t_roles[0]->content);
      }

      public function dashboard(){

        $step_array = array();
        $services = array();
        $tbl_services  = $this->base_model->getSelect("tbl_services");
        foreach ($tbl_services as $key => $value) {
          $services[$value->id] = $value->name;
        }
        $data['services']  = $services;
        $shPageSize =  empty($this->input->get("shPageSize")) ? 10: $this->input->get("shPageSize");
        $this->load->library('pagination');
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);
        $data['step'] = $this->input->get("step")==NULL?"":$this->input->get("step");
        $data['category'] = $this->base_model->getStepDeliveryTop();
        $data['delivery'] = $this->base_model->getStepDelivery();
        $records_count  = sizeof($this->base_model->getDeliverContent (
          0,
          0,
          null,
          $data['step'],
          $this->input->get("stock_part"),
          $this->input->get("nodata_parts"),
          $this->input->get("coming_order"),
          $this->input->get("starts_date"),
          $this->input->get("ends_date"),
          $this->input->get("order_state"),
          $this->input->get("order_part"),
          $this->input->get("search_nickname"),
          $this->input->get("search_billing_name"),
          $this->input->get("search_pusername"),
          $this->input->get("search_puserId"),
          $this->input->get("search_peng"),
          $this->input->get("search_porder"),
          $this->input->get("search_id"),
          $this->input->get("search_tracking_number"),
          $this->input->get("search_ptracking")));
        $returns = $this->paginationCompress ( "dashboard/", $records_count, $shPageSize);
        $data['deliver_content'] = $this->base_model->getDeliverContent (
          $returns["page"],
          $returns["segment"],
          null,
          $data['step'],
          $this->input->get("stock_part"),
          $this->input->get("nodata_parts"),
          $this->input->get("coming_order"),
          $this->input->get("starts_date"),
          $this->input->get("ends_date"),
          $this->input->get("order_state"),
          $this->input->get("order_part"),
          $this->input->get("search_nickname"),
          $this->input->get("search_billing_name"),
          $this->input->get("search_pusername"),
          $this->input->get("search_puserId"),
          $this->input->get("search_peng"),
          $this->input->get("search_porder"),
          $this->input->get("search_id"),
          $this->input->get("search_tracking_number"),
          $this->input->get("search_ptracking"));
        $data['pState'] =  $this->base_model->getPState();
        $stateCount = $this->base_model->getStateCount();
        foreach ($stateCount as $key => $value) {
          $step_array[$value->state] = $value->stateCount;
        }
        $data['step_array'] = $step_array;
        $data['state_delivery'] = $this->base_model->getStepAll();
        $data['errorCoutr']  = $this->base_model->getErrorProductsCount();
        $this->loadViews("dashboard", $this->global, $data , NULL);
      }

      public function index(){
        $data['panel'] = $this->base_model->getSelect("tbl_board",array(array("record"=>"title","value"=>"1:1맞춤문의")));
        if(empty($data['panel'])){
          echo "1:1 게시판이 존재하지 않습니다.";
          return;
        }
        $id = $data['panel'][0]->iden;
        $data['private'] = $this->base_model->getReq($data['panel'][0]->id,5,0);
        $data['private_id'] = $data['panel'][0]->id;
        $data['private_count'] = $this->base_model->getPendingPrivateMessageCount($data['private_id']);
        $data['register_members'] = $this->base_model->getRegsitesCountByM();
        $data['del'] = $this->base_model->getOrdersType("delivery");
        $data['pur'] = $this->base_model->getOrdersType("buy");
        $data['ret'] = $this->base_model->getOrdersType("return");
        $this->loadViews("index", $this->global, $data , NULL);
      }

      public function productListing(){

         $content = "";
         $porder = $this->input->get("sOrdSeq");
         $pState =  $this->base_model->getPState();
         $products =  $this->base_model->getProdcuts($porder);
         $tracking_headers = $this->base_model->getSelect("tracking_header");

         foreach ($products as $key => $value) {
            $color = !empty($value->color) ? ",".$value->color:"";
             $content.= "<tr>";
             $content.="<td>";
             $content.='<input type="checkbox" name="chkPRO_'.$value->delivery_id.'" id="chkPRO_'.$value->delivery_id.'" value="'.$value->id.'">';
             $content.=!empty($value->old_delivery_id) ?
             "<a target='_blink' href='".base_url()."ShowDelivery?ORD_SEQ=".$value->old_delivery_id."' class='text-primary'>": "";
             $content.=$value->serial;
             $content.= !empty($value->old_delivery_id) ?  "</a>":"";
             $content.="</td>";
             $content.="<td>";
             $content.="</td>";
             $content.="<td>";
             $content.='<a href="'.$value->image.'" target="_blank"><img src="'.$value->image.'" width="50" height="50"></a>';
             $content.="</td>";
             $content.="<td>";
             $content.="<a target='_blink' href='".$value->url."'>".$value->productName."</a><br>";
             $content.="</td>";
             $content.="<td>";
             $content.="</td>";
             $content.="<td>";
             $content.=$value->hname;
             $content.="
             <select name='sFRG_DLVR_COM_".$value->id."_1' id='sFRG_DLVR_COM_".$value->id."_1'>";
             foreach($tracking_headers as $vap):
                if($value->trackingHeader==$vap->name) $dds="selected";
                else $dds="";
                $content.="<option value='".$vap->name."' " .$dds.">".$vap->name."</option>";
              endforeach;
             $content.="</select><br>
             <input type='text' name='sFRG_IVC_NO_".$value->id."_1' id='sFRG_IVC_NO_".$value->id."_1' value='".$value->trackingNumber."'>
                        <button type='button' class='txt btn btn-sm btn-primary' onclick=\"fnChgFrgIvc('$value->id','1');\">변경</button><br>";
             // $content.='<span class="whGraBtn ty2">';
             // $content.='<button type="button" class="txt" onclick="fnFrgImgView2("'.$value->id.'","0");">실사보기</button>';
             // $content.='</span>';
             $content.="<br><input type='text' name='sSHOP_ORD_NO_".$value->id."_1' id='sSHOP_ORD_NO_".$value->id."_1' value='".$value->order_number."'>
                            <button type='button' class='txt btn btn-sm btn-primary' onclick=\"fnChgFrgOrd('".$value->id."','1');\">변경</button> ";
             $content.="</td>";
             $content.="<td>";
             $content.=$value->size.$color;
             $content.="</td>";
             $content.="<td>";
             $content.=number_format($value->unitPrice,2)."*";
             $content.='<span class="bold red1">';
             $content.=$value->count.'</span>';
             $content.="</br>";
             $content.='<span class="bold">';
             $content.=number_format((float)$value->pprice,2);
             $content.='</span>';
             $content.="</td>";
             $content .="<td>";
             $content .='<span class="red1">'.$value->Sname.'</span>';
             $content .='</br>';
             if($value->Dstate !=19 && $value->Dstate !=20 && $value->Dstate !=21 && $value->Dstate !=14 && $value->Dstate !=17){
                $content .='<select name="sARV_STAT_'.$value->id.'" id="sARV_STAT_'.$value->id.'" onchange="fnProArvChg(\''.$value->id.'\',\'1\',this.value, \'4\');">';
                $content.='<option value="">=상태변경</option>';
                foreach ($pState as $key => $childP) {
                  $content.="<option value='".$childP->step."'>".$childP->name."</option>";
                }
                $content.="</select>";
              }
              $content .="</td>";
              $content .= "</tr>";
         }

         echo $content;
      }

      public function getPP(){
          echo '<p>example</p>';
      }

      public function activeProduct(){
        $sOrdSeq = $this->input->post('sOrdSeq');
        $sArvStatCd = $this->input->post('sArvStatCd');
        $this->base_model->updateProdcutStep($sOrdSeq,$sArvStatCd);
        echo "100";
      }

      public function changeProduct(){
        $productList = explode(",",$this->input->post('sProSeq'));
        $pstate = $this->input->post("sArvStatCd");
        $delivery_id = 0;
        if($pstate ==103)
        {
          $sOrdSeq = $this->input->post("sOrdSeq");
          $product_count  = sizeof($this->base_model->getSelect("tbl_purchasedproduct",array(array("record"=>"delivery_id","value"=>$sOrdSeq))));
          if(sizeof($productList) == $product_count){
            $delivery_id = $sOrdSeq;
            $this->base_model->updateDataById($delivery_id,array("state"=>18,"combine"=>4),"delivery","id");
            $this->base_model->updateDataById($delivery_id,array("step"=>103),"tbl_purchasedproduct","delivery_id");
          }
          else{
            $delivery = $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$sOrdSeq)));
            $post_data = $delivery[0];
            unset($post_data->id);
            $post_data->combine = 4;
            $post_data->state = 18;
            $post_data->updated_date = date("Y-m-d H:i:s");
            $post_data->created_date = date("Y-m-d H:i:s");
            $post_data->rid = generateRandomString(15);
            $insert_id = $this->base_model->insertArrayData("delivery",$post_data);
            if($insert_id > 0 )
            {
              $oo= date("y").date("m").date("d").str_pad($insert_id, 4, '0', STR_PAD_LEFT);
              $this->base_model->insertArrayData("tbl_service_delivery",array("content"=>"[]","delivery_id"=>$insert_id));
              $this->base_model->updateDataById($insert_id,array("ordernum"=>$oo),"delivery","id");
              foreach($productList as $value){
                $this->base_model->updateDataById($value,array("step"=>103,"delivery_id"=>$insert_id,"old_delivery_id"=>$sOrdSeq),"tbl_purchasedproduct","id");
              }
            }
          }
          redirect("/dashboard?step=18");
        }
        else
        {
          foreach($productList as $value){
            $this->base_model->updateProdcutStep($value,$pstate);
          }
          redirect('/dashboard');
        }

      }

      public function changeOrder(){
        $sKind = $this->input->post("sKind");
        $ORD_SEQ = $this->input->post("chkORD_SEQ");
        $arr_id = array();
        $arr_passed = array();
        $sMoveStatSeq1 = $this->input->post("sMoveStatSeq1");
        $stepp = $this->input->post("stepp");
        $type = 0;
        if($sKind=="E"){
          $alert="";
          $ss="";
          $ss_label = "";
          if($stepp ==5){
            $ss="purchase_price";
            $ss_label = "payed_checked";
            $type = 2;
          }
          if($stepp ==14){
            $ss="sending_price";
            $ss_label = "payed_send";
            $type = 1;
          }
          if($stepp ==20){
            $ss="return_price";
            $ss_label = "return_check";
            $type = 3;
          }
          foreach ($ORD_SEQ as $key => $value) {
            $deposit  = $this->base_model->getDepositByDeliveryId($value,$ss);
            if(empty($deposit)) continue;
            $pending = $this->base_model->getSelect("tbl_payhistory",array(array("record"=>"delivery_id","value"=>$value)));
            if(!empty($pending) && $pending[0]->pending ==1) continue;
            $r_des = number_format((float)$deposit[0]->deposit, 0, '.', '')-number_format((float)str_replace(",","",$deposit[0]->price), 0, '.', '');
            if($r_des < 0) {$alert.=$deposit[0]->name." ";continue;}
            $this->base_model->updateDataById($value,array("state"=>$stepp+1,$ss_label=>1),"delivery","id");
            $this->base_model->updateDataById($deposit[0]->userId,array("deposit"=>$r_des),"tbl_users","userId");
            $this->base_model->updateDataById($value,array("state"=>$stepp+1,$ss_label=>1),"delivery","id");
            $security = date("ymd").generateRandomString(10);
            $this->base_model->insertArrayData("tbl_payhistory",array(  "delivery_id"=>$value,
                            "all_amount"=>str_replace(",","",$deposit[0]->price),
                            "payed_date"=>date("Y-m-d H:i"),
                            "type"=>$type,
                            "amount"=>str_replace(",","",$deposit[0]->price),
                            "payed_type"=>5,
                            "userId"=>$deposit[0]->userId,
                            "pending"=>0,
                            "pamount"=>0,
                            "security"=>$security,
                            "by"=>1));
          }
          $rr = $stepp+1;
          if(trim($alert) !=""){
            echo "<script>alert('".$alert." 회원님의 예치금이 부족합니다');location.href='/admin/dashboard?step=".$stepp."'</script>";

          }
          else redirect('/dashboard?step='.$rr);
          return;
        }
        else{
          if($sMoveStatSeq1==14){
            if($this->base_model->checkSendingPay($ORD_SEQ) ==0){
              redirect("/alert?step=".$stepp);
              return;
            }
          }

          foreach ($ORD_SEQ as $key => $value) {
            $de = $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$value)));
            if(empty($de)) continue;
            if($sMoveStatSeq1==16){
              if($this->base_model->checkNotIn($value) > 0){
                array_push($arr_id, $de[0]->ordernum);
                continue;
              }
              if($de[0]->type == 3)
                array_push($arr_passed, $de[0]->ordernum);
            }


            $pcheck= 0;
            $category_ids= array();
            $this->base_model->updateDelivery($value,$sMoveStatSeq1);
            if($sMoveStatSeq1 ==23){
              if($de[0]->type == "2" || $de[0]->type == "3"){
                $this->base_model->plusValue("tbl_users","complete_orders",1,array(array("userId",$de[0]->userId)),"+");
                calcualteGrade($de[0]->userId);
                $pros =  $this->base_model->getProductShoppinmal($value);

                $points= 0;
                foreach($pros as $vals){
                  $this->base_model->plusValue("tbl_sproducts","count",$vals->count,array(array("id",$vals->shop)),"-");
                  $this->base_model->plusValue("tbl_sproducts","p_salecnt",$vals->count,array(array("id",$vals->shop)),"+");
                  $category_ids = $this->base_model->getCategoryP($vals->shop);

                  if(!empty($category_ids))
                    $this->base_model->plusValue("tbl_leftcategory","purchase",1,array(array("id",$category_ids)),"+",false);
                  $add_options = json_decode($vals->add_options,true);

                  if(!empty($add_options) && $add_options!=NULL && sizeof($add_options) > 0){
                    $this->base_model->plusValue("tbl_product_option","count",$vals->count,array(array("id",$add_options)),"-",false);
                    $this->base_model->plusValue("tbl_product_option","salecount",$vals->count,array(array("id",$add_options)),"+",false);
                    $parents = $this->base_model->getSelect("tbl_product_option",null,null,array(array("record"=>"parent")),null,null,array(array("record"=>"id","value"=>$add_options)));
                    if(!empty($parents)){
                      $pids = array();
                      foreach ($parents as $key => $p_value) {
                        array_push($pids, $p_value->parent);
                      }
                      $this->base_model->plusValue("tbl_product_option","count",$vals->count,array(array("id",$pids)),"-",false);
                      $this->base_model->plusValue("tbl_product_option","salecount",$vals->count,array(array("id",$pids)),"+",false);
                    }
                  }

                  $points = $points+$vals->point*$vals->count;
                }
                if(!empty($pros) && $points > 0){
                 $this->base_model->plusValue("tbl_users","point",$points,array(array("userId",$de[0]->userId)),"+");

                 $ss = $this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$de[0]->userId)));
                 $this->base_model->insertArrayData("tbl_point_users",array( "userId"=>$de[0]->userId,
                                                                           "point"=>"+".$points,
                                                                           "s"=>0,
                                                                           "type"=>5,
                                                                           "remain"=>$ss[0]->point));
                }

                $delvery_array = array();
                $delvery_array = $this->base_model->getproductOld($de[0]->id,$de[0]->combine);
                $pcheck= 0;
                $minusp = 0;
                if(!empty($delvery_array)){
                  foreach($delvery_array as $pid)
                  {

                    $temp = $this->base_model->ErrorProductValue($pid->did);

                    if(!empty($temp))
                    {
                      $aprice = isset($temp[0]->aprice) && $temp[0]->aprice > 0 ? $temp[0]->aprice : 0;
                      $fee = isset($temp[0]->fee) && $temp[0]->fee > 0 ? $temp[0]->fee : 0;
                        $minusp = $aprice + $fee;
                    }

                    $enable_p = sizeof($this->base_model->getSelect("delivery",array( array("record"=>"id","value"=>$pid->did),
                                                                                      array("record"=>"state!=","value"=>"23"),
                                                                                      array("record"=>"state!=","value"=>"19"),
                                                                                      array("record"=>"state!=","value"=>"20"),
                                                                                      array("record"=>"state!=","value"=>"21"),
                                                                                      array("record"=>"state!=","value"=>"24"),
                                                                                      array("record"=>"state!=","value"=>"18"))));
                    if($enable_p >0){
                      $pcheck =1;
                      break;
                    }
                  }
                }


                if($pcheck ==0){
                  if($de[0]->purchase_price > 0 )
                  {
                    $de[0]->purchase_price = $de[0]->purchase_price - $minusp;
                    $pur_fee = explode("|", $de[0]->pur_fee);
                    $pur_fee = empty($pur_fee[0]) ? 0: $pur_fee[0];
                    $am = (int)($de[0]->purchase_price/10000);
                    $ed = $this->base_model->getSelect("tbl_point",  array(  array("record"=>"type","value"=>2),
                                               array("record"=>"from_gold <=","value"=>$am )),
                                           array(array("record"=>"from_gold","value"=>"DESC")));
                    if(!empty($ed)){
                     foreach ($ed as $key => $value_p) {
                       $tt = $value_p->point_type;
                       $tp = $value_p->point;
                       if($tt==2)
                         $tp = $de[0]->purchase_price*$tp/100;
                       $this->base_model->plusValue("tbl_users","point",$tp,array(array("userId",$de[0]->userId)),"+");
                       $ss = $this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$de[0]->userId)));
                       $this->base_model->insertArrayData("tbl_point_users",array( "userId"=>$de[0]->userId,
                                                                                         "point_id"=>$value_p->id,
                                                                                       "point"=>"+".$tp,
                                                                                       "type"=>$value_p->type,
                                                                                       "remain"=>$ss[0]->point));

                       }

                    }
                    $ed = $this->base_model->getSelect("tbl_point",  array(  array("record"=>"type","value"=>3),
                                               array(  "record"=>"SUBSTRING_INDEX(terms,\"|\",1) <=",
                                                       "value"=>date("Y-m-d") ),
                                               array(  "record"=>"SUBSTRING_INDEX(terms,\"|\",-1) >=",
                                                       "value"=>date("Y-m-d") )));

                    if(!empty($ed)){
                     foreach ($ed as $key => $value_p) {
                       $tt = $value_p->point_type;
                       $tp = $value_p->point;
                       if($tt==2)
                         $tp = $de[0]->purchase_price*$tp/100;
                       $this->base_model->plusValue("tbl_users","point",$tp,array(array("userId",$de[0]->userId)),"+");
                       $ss = $this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$de[0]->userId)));
                       $this->base_model->insertArrayData("tbl_point_users",array( "userId"=>$de[0]->userId,
                                                                                         "point_id"=>$value_p->id,
                                                                                       "point"=>"+".$tp,
                                                                                       "type"=>$value_p->type,
                                                                                       "remain"=>$ss[0]->point));
                       }
                    }
                  }

                }
              }
            }
            if($sKind=="B"){
              if($de[0]->type == "2" || $de[0]->type == "3"){
                $this->base_model->plusValue("tbl_users","complete_orders",1,array(array("userId",$de[0]->userId)),"-");
                calcualteGrade($de[0]->userId);

              }
            }
          }
          if(sizeof($arr_id) > 0 || sizeof($arr_passed) > 0){

              if(sizeof($arr_id) > 0)
                alert("입고완료상태가 아닌 주문이 포함되여 있습니다.주문번호는 ".implode($arr_id)."입니다.");
              else
                $this->base_model->insertArrayData("tbl_notice" , array(  "type" => 30,
                                                                          "content" => implode(",",$arr_passed),
                                                                          "userId" => 0,
                                                                          "view" => 0,
                                                                          "tt" => "waiting-out"));
          }
          redirect('/dashboard?step='.$sMoveStatSeq1);
        }
      }

      public function alert(){
        $this->global['pageTitle'] = '경고';
        $data['step'] = $this->input->get('step');
        $this->loadViews("alert", $this->global, $data , NULL);
      }

      public function setSendingPay(){
        $data['a'] = $this->base_model->getServices(1);
        $data['ORD_SEQ'] = $this->input->get("ORD_SEQ");
        $ORD_TY_CD = $this->input->get("ORD_TY_CD");
        $dels = $this->base_model->getPayHistory(10,0,1,null,null,null,null,null,null,null,$ORD_TY_CD);
        if(!empty($dels)){
          $data['none'] = "무통장 또는 가상결제진행중에 있습니다.결제내역에서 확인해주세요";
          $this->load->view("setSendingmethod",$data);
          return;
        }
        $data['custom_fee'] = $this->base_model->getCustomFee();
        $data['notice_exchange']  = $this->base_model->getNoticeExchange();
        $data['accuringRate'] = $this->base_model->getSelect("tbl_accurrate",null,array(array("record"=>"created_date","value"=>"DESC")))[0];
        $data['bExtMny'] = $bExtMny = !empty($data['accuringRate']) ? $data['accuringRate']->rate:0;

        if($ORD_TY_CD ==4)
          $data['delivery'] = $this->base_model->getSelect("tbl_add_price",array(array("record"=>"id","value"=>$data['ORD_SEQ'])));

        if($ORD_TY_CD !=4){
          if($ORD_TY_CD !=2)
            $data['delivery'] = $this->base_model->getDeliverContent(10,0,$data['ORD_SEQ'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,$ORD_TY_CD);
          else
            $data['delivery'] = $this->base_model->getDeliverContent(10,0,$data['ORD_SEQ'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
          if(empty($data['delivery'])) {
            $data['deli'] = null;
          }
          else {

            $data['deli'] = $this->base_model->getSelect("tbl_deliverytable",       array(array("record"=>"address","value"=>$data['delivery'][0]->place)),
                                                array(array("record"=>"startWeight","value"=>"ASC")));
          }

          $dd = $this->base_model->getDepositByDeliveryId($data['ORD_SEQ'],"pur_fee");
          $data['deposits'] = empty($dd) ? 0:$dd[0]->deposit;
          $bMemRt = 10;
          $sBuyFee  = 0;
          $data["ddd"]=$dd[0]->buy_fee;
          $data['TotalBuyMny'] = number_format(str_replace(",", "", $data["delivery"][0]->purchase_price));
        }
        $this->load->view("setSendingmethod",$data);
      }

      public function ActiveMoney(){
        $ORD_SEQ = $this->input->post("ORD_SEQ");
        $CHA_CD = $this->input->post("CHA_CD");
        $aa = array();
        if($CHA_CD ==1){
          $fee_list = explode(",", $this->input->post("fee_list"));
          $ETC_FEE_MNY = explode(",", $this->input->post("ETC_FEE_MNY"));
          $delivery_array=array(  "cutoms_fee" =>  $this->input->post("CTM_FEE"),
                                  "real_weight" => $this->input->post("REAL_WT"),
                                  "width"=> $this->input->post("WIDTH_INCH"),
                                  "length"=> $this->input->post("VER_INCH"),
                                  "height"=> $this->input->post("HEIGHT_INCH"),
                                  "accept_rate" => $this->input->post("VLM_APPL_RT"),
                                  "sending_price" => $this->input->post("DLVR_MNY"),
                                  "vlm_wt" => $this->input->post("VLM_WT"),
                                  'mem_wt' =>$this->input->post("MEM_WT"),
                                  "updated_date_price"=>date('Y-m-d H:i:s'),
                                  "state"=>14,
                                  "sends"=>$this->input->post("ppp"),
                                  "pays"=>0);
         $xc=0;
         if(!empty($ETC_FEE_MNY)){
          foreach($fee_list as $fv){
            $aa[$fv] = $ETC_FEE_MNY[$xc];
            $xc++;
          }
          $s = $this->base_model->getSelect("tbl_service_delivery",array(array("record"=>"delivery_id","value"=>$ORD_SEQ)));
          if(!empty($s))
            $this->base_model->updateDataById($ORD_SEQ,array("content"=>json_encode($aa)),"tbl_service_delivery","delivery_id");
          else
            $this->base_model->insertArrayData("tbl_service_delivery",array("content"=>json_encode($aa),"delivery_id"=>$ORD_SEQ));
         }

          $this->base_model->updateDataById($ORD_SEQ,$delivery_array,"delivery","id");
          $sss = "14";

        }

        if($CHA_CD ==2){
          $delivery_array = array(  "purchase_price" =>trim(str_replace(",", "", $this->input->post("BUY_MNY"))),
                                    "state"=>5,
                                    "pur_fee"=> trim(str_replace(",","",$this->input->post("BUY_FEE_RT")))."|".
                                                $this->input->post("PRO_AMT")*$this->input->post("BUY_EXG_RT_MNY")."|".
                                                $this->input->post("BUY_EXG_RT_MNY"),
                                    "cur_send"=>trim(str_replace(",", "", $this->input->post("BUY_FEE"))),
                                    "pays"=>0);
          $this->base_model->updateDataById($ORD_SEQ,$delivery_array,"delivery","id");
          $sss = "5";
        }
        if($CHA_CD == 4){
            $delivery_array = array(  "return_price" =>trim(str_replace(",", "", $this->input->post("RTN_FREE_WON"))),
                                      "rfee" =>trim(str_replace(",", "", $this->input->post("RTN_FEE"))),
                                      "state"=>20,
                                      "pays"=>0);
            $sss = "20";
          $this->base_model->updateDataById($ORD_SEQ,$delivery_array,"delivery","id");
        }
        if($CHA_CD == 5){
            $delivery_array = array(  "add_check" =>1,
                                      "add_price" =>str_replace(",", "", rtrim($this->input->post("FIVE_MNY"),",")),
                                      "pegi" =>str_replace(",", "", rtrim($this->input->post("pegi"),",")),
                                      "cart_bunhal" =>str_replace(",", "", rtrim($this->input->post("cart_bunhal"),",")),
                                      "gwan" =>str_replace(",", "", rtrim($this->input->post("gwan"),",")),
                                      "check_custom" =>str_replace(",", "", rtrim($this->input->post("check_custom"),",")),
                                      "gwatae" =>str_replace(",", "", rtrim($this->input->post("gwatae"),",")),
                                      "add_fee" =>str_replace(",", "", rtrim($this->input->post("add_fee"),",")),
                                      "accurate"=>str_replace(",", "", rtrim($this->input->post("FIVE_EXG_RT"),",")),
                                      "v_weight"=>str_replace(",", "", rtrim($this->input->post("v_weight"),",")));
          if(trim($this->input->post("id")) =="")
          {
            $delivery_array['id'] = $ORD_SEQ;
            $this->base_model->insertArrayData("tbl_add_price",$delivery_array);
          }
          else{
            $this->base_model->updateDataById($ORD_SEQ,$delivery_array,"tbl_add_price","id");
          }
          echo "<script>window.close();opener.selfRedirect();</script>";
          return;
        }
      echo "<script>window.close();opener.goTo('/admin/dashboard?step=".$sss."')</script>";
    }

    public function OrderProduct(){
      $this->isLoggedIn();
      $data['trackheader'] = $this->base_model->getSelect('tracking_header');
      $this->global['pageTitle'] = '주문상품관리';
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $shPageSize =  empty($this->input->get("shPageSize")) ? 10: $this->input->get("shPageSize");
      $records_count = sizeof($this->base_model->getProductsAll(0,0,
                                                                    $this->input->get("starts_date"),
                                                                    $this->input->get("ends_date"),
                                                                    $this->input->get("shFrgEmptyCd"),
                                                                    $this->input->get("order_part"),
                                                                    $this->input->get("search_nickname"),
                                                                    $this->input->get("search_billing_name"),
                                                                    $this->input->get("search_pusername"),
                                                                    $this->input->get("search_puserId"),
                                                                    $this->input->get("search_peng"),
                                                                    $this->input->get("search_porder"),
                                                                    $this->input->get("search_id"),
                                                                    $this->input->get("search_ptracking")));
      $returns = $this->paginationCompress ( "orderProduct/", $records_count, $shPageSize);
      $data['products'] = $this->base_model->getProductsAll($returns["page"], $returns["segment"],
                                                                    $this->input->get("starts_date"),
                                                                    $this->input->get("ends_date"),
                                                                    $this->input->get("shFrgEmptyCd"),
                                                                    $this->input->get("order_part"),
                                                                    $this->input->get("search_nickname"),
                                                                    $this->input->get("search_billing_name"),
                                                                    $this->input->get("search_pusername"),
                                                                    $this->input->get("search_puserId"),
                                                                    $this->input->get("search_peng"),
                                                                    $this->input->get("search_porder"),
                                                                    $this->input->get("search_id"),
                                                                    $this->input->get("search_ptracking"));
      $data["sc"] = $records_count;
      $data["gy"] = $returns["segment"];
      $this->loadViews("OrderProduct", $this->global, $data , NULL);
    }

    public function changeOrderNUmber(){
      $sOrdSeq = $this->input->get("sOrdSeq");
      $sSHOP_ORD_NO = $this->input->get("sSHOP_ORD_NO");
      echo $this->base_model->updateDataById($sOrdSeq,array("order_number"=>$sSHOP_ORD_NO),"tbl_purchasedproduct","id");
    }

    public function changeTracks(){

      $sOrdSeq = $this->input->get("sOrdSeq");
      $sFRG_IVC_NO = $this->input->get("sFRG_IVC_NO");
      $sFRG_DLVR_COM = $this->input->get("sFRG_DLVR_COM");
      if(!empty($sFRG_DLVR_COM))
        echo $this->base_model->updateDataById($sOrdSeq,  array(
                                                                  "trackingNumber"=>$sFRG_IVC_NO,
                                                                  "trackingHeader"=>$sFRG_DLVR_COM,
                                                                  "tracking_time"=>date("Y-m-d H:i:s")),"tbl_purchasedproduct","id");
      else echo $this->base_model->updateDataById($sOrdSeq,array("trackingNumber"=>$sFRG_IVC_NO,"tracking_time"=>date("Y-m-d H:i:s")),"tbl_purchasedproduct","id");

    }

    public function payhistory(){
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $deposit_part = empty($_GET['deposit_part']) ?  NULL : $_GET['deposit_part'];
      $type_parts   = empty($_GET['type_parts']) ?    NULL : $_GET['type_parts'];
      $starts_date  = empty($_GET['starts_date']) ?   NULL : $_GET['starts_date'];
      $ends_date    = empty($_GET['ends_date']) ?     NULL : $_GET['ends_date'];
      $pay_parts    = empty($_GET['pay_parts']) ?     NULL : $_GET['pay_parts'];
      $member_part  = empty($_GET['member_part']) ?   NULL : $_GET['member_part'];
      $search_txt   = empty($_GET['search_txt']) ?    NULL : $_GET['search_txt'];
      $shPageSize   = empty($_GET['shPageSize']) ?    10 : $_GET['shPageSize'];
      $records_count = sizeof($this->base_model->getPayHistory(10000,0,0,$deposit_part,$type_parts,$starts_date,$ends_date,$pay_parts,$member_part,$search_txt));
      $returns = $this->paginationCompress ( "payhistory/", $records_count, $shPageSize);
      $pays = $this->base_model->getPayHistory($returns["page"],$returns["segment"],0,$deposit_part,$type_parts,$starts_date,$ends_date,$pay_parts,$member_part,$search_txt);
      $temp = '';
      $result = array();
      $orderr = array();
      $tamount = 0;
      $tdeposit = 0;
      $otarray = array();
      $count = 0;
      foreach ($pays as $key => $value) {
        if($value->type==1) {$amount=$value->sending_price;$label = "배송비용";};
        if($value->type==2) {$amount=$value->purchase_price;$label = "구매비용";}
        if($value->type==3) {$amount=$value->return_price;$label = "리턴비용";}
        if($value->type==4) {$amount=$value->add_price;$label = "추가결제비용";}
         if($value->type==60) {$amount=$value->sending_price + $value->purchase_price;$label = "쇼핑몰";}
        if($temp!=$value->security)
        {
          $tarray =array( "id"=>$value->id,
                          "name"=>$value->name,
                          "login"=>$value->loginId,
                          "all_amount"=>$value->all_amount,
                          "amount"=>$value->amount,
                          "type"=>$value->payed_type,
                          "update"=>$value->updated_date,
                          "security"=>$value->security,
                          "pamount"=>$value->pamount,
                          "point"=>$value->bpoint,
                          "by"=>$value->by);
          $temp = $value->security;
          array_push($result,$tarray);
          $count =0;
          $orderr[$value->security][$count]=array( "order"=>$value->OrdNum,
                                  "amount"=>$amount,
                                  "label"=>$label,
                                  "delivery_id"=>$value->delivery_id);
        }
        else{
          $count++;
          $orderr[$value->security][$count]=array( "order"=>$value->OrdNum,
                                  "amount"=>$amount,
                                  "label"=>$label,
                                  "delivery_id"=>$value->delivery_id);
        }

      }
      $data['orderr'] = $orderr;
      $data['data'] = $result;
      $data["uc"] = $records_count;
      $data["pf"] = $returns["segment"];
      $this->loadViews("payhistory", $this->global, $data , NULL);
    }

    public function nodata(){
      $data['nodata'] = $this->base_model->getNodata();
      $this->loadViews("nodata", $this->global, $data , NULL);
    }

    public function groupBuy(){
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getGroupProdcuts(0,0,$this->input->get("shPageSize"),
                                                                  $this->input->get("shUseYn"),
                                                                  $this->input->get("search_pname"),
                                                                  $this->input->get("brands")));
      $returns = $this->paginationCompress ( "groupbuy/", $records_count, $this->input->get("shPageSize"));
      $data['groupBuy'] = $this->base_model->getGroupProdcuts($returns["page"],
                                                              $returns["segment"],
                                                              $this->input->get("shUseYn"),
                                                              $this->input->get("search_pname"),
                                                              $this->input->get("brands"));
      $this->loadViews("groupbuy", $this->global, $data , NULL);
    }

    public function editProduct($id){
      $data['product'] = $this->base_model->getProdcutPublic($id);
      $this->loadViews("addProduct",$this->global,$data,NULL);
    }

    public function addProduct(){
      $this->loadViews("addProduct",$this->global,NULL,NULL);
    }

    private function set_upload_options($path,$max_size=300000,$encrypt_name = true,$file_name=null)
    {
        $config = array();
        $config['upload_path'] = $path;
        $config['allowed_types'] = '*';
        $config['max_size']      = $max_size;
        $config['overwrite']     = true;
        $config['encrypt_name'] = $encrypt_name;
        if($file_name !=null) $config['file_name'] = $file_name;
        return $config;
    }

    public function registerProduct(){
      $id=$this->input->post("id");
      $name  = $this->input->post("name");
      $brand = $this->input->post("brand");
      $oprice  = $this->input->post("oprice");
      $bsales  = $this->input->post("bsales");
      $pprice  = $this->input->post("pprice");
      $category  = $this->input->post("category");
      $st  = $this->input->post("terms1")."|".$this->input->post("terms2");
      $color  = $this->input->post("color");
      $size  = $this->input->post("size");
      $short  = $this->input->post("short");
      $use  = $this->input->post("use");
      $details  = $this->input->post("details");
      $return_id = $this->base_model->insertProductPublic($id,array(  "name"=>$name,
                                                                      "brand"=>$brand,
                                                                      "origin_price"=>$oprice,
                                                                      "color"=>$color,
                                                                      "short_description"=>$short,
                                                                      "bef_sales"=>$bsales,
                                                                      "product_price"=>$pprice,
                                                                      "sales_term"=>$st,
                                                                      "size"=>$size,
                                                                      "use"=>$use,
                                                                      "detailed_desctiption"=>$details,
                                                                      "created_date"=>date("Y-m-d H:i")));

      if($return_id > 0){
        if($_FILES['thumb']['name'] !=""){
          $this->load->library('upload',$this->set_upload_options("../upload/thumb"));
          $this->upload->initialize($this->set_upload_options("../upload/thumb"));

          if ( ! $this->upload->do_upload('thumb'))
          {
            $error = array('error' => $this->upload->display_errors());
          }
          else
          {
            $img_data = $this->upload->data();
            $this->base_model->insertProductPublic($return_id,array("thumbnail"=>$img_data["file_name"]));
          }
        }
        if($_FILES['image']['name'] !=""){
          $this->load->library('upload',$this->set_upload_options("../upload/image"));
          $this->upload->initialize($this->set_upload_options("../upload/image"));
          if ( ! $this->upload->do_upload('image'))
          {
            $error = array('error' => $this->upload->display_errors());
          }
          else
          {
            $img_data = $this->upload->data();
            $this->base_model->insertProductPublic($return_id,array("image"=>$img_data["file_name"]));
          }
        }
      }
      redirect("/groupbuy");
    }
    public function privateMes(){
      $data['type']  = 1;
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getReq(1,0,0,$this->input->get("shCt"),$this->input->get("shCol"),$this->input->get("seach_input")));
      $returns = $this->paginationCompress ( "private/", $records_count,15);
      $data['content'] = $this->base_model->getReq(1,$returns['page'],$returns['segment'],$this->input->get("shCt"),$this->input->get("shCol"),$this->input->get("seach_input"));
      $this->loadViews("mailView",$this->global,$data,NULL);
    }

    public function after_use(){
      $data['type']  = 2;
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getReq(2,0,0,$this->input->get("shCt"),$this->input->get("shCol"),$this->input->get("seach_input")));
      $returns = $this->paginationCompress ( "after_use/", $records_count,15);
      $data['content'] = $this->base_model->getReq(2,$returns['page'],$returns['segment'],$this->input->get("shCt"),$this->input->get("shCol"),$this->input->get("seach_input"));
      $this->loadViews("mailView",$this->global,$data,NULL);
    }

    public function offque(){
      $data['type']  = 3;
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getReq(3,0,0,$this->input->get("shCt"),$this->input->get("shCol"),$this->input->get("seach_input")));
      $returns = $this->paginationCompress ( "offque/", $records_count,15);
      $data['content'] = $this->base_model->getReq(3,$returns['page'],$returns['segment'],$this->input->get("shCt"),$this->input->get("shCol"),$this->input->get("seach_input"));
      $this->loadViews("mailView",$this->global,$data,NULL);
    }

    public function publicreq(){
      $data['type']  = 4;
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getReq(4,0,0,null,$this->input->get("shCol"),$this->input->get("seach_input")));
      $returns = $this->paginationCompress ( "publicreq/", $records_count,15);
      $data['content'] = $this->base_model->getReq(4,$returns['page'],$returns['segment'],null,$this->input->get("shCol"),$this->input->get("seach_input"));
      $this->loadViews("mailView",$this->global,$data,NULL);
    }

    public function viewMessage($id){
      if(!is_numeric($id))
        return;
      $data['content'] = $this->base_model->getReqById($id);
      if(empty($data['content']))
        return;
      $data['comment'] = $this->base_model->getCommentsByPostId(5,0,$id);
      $data['size'] = sizeof($this->base_model->getSelect("tbl_comment",array(array("record"=>"postId","value"=>$id))));
      $this->loadViews("viewMessage",$this->global,$data,NULL);
    }

    public function writeComment(){

      $comment = $this->input->post("sCONT");
      $postId= $this->input->post("postId");
      echo $this->base_model->insertArrayData("tbl_comment",array(  "postId"=>$postId,
                                                                    "userId"=>$this->session->userdata('userId'),
                                                                    "created_date"=>date("Y-m-d H:i"),
                                                                    "content"=>$comment));
    }

    public function writePost($id){
      $this->isLoggedIn();
      $data = $this->input->post();
      $data['fromId'] = $this->session->userdata('userId');
      $data['type'] = $id;
      $insert_id =  $this->base_model->insertArrayData("tbl_mail",$data);
      if($insert_id > 0){
        if (!file_exists("../upload/mail/".$insert_id))
          mkdir("../upload/mail/".$insert_id, 0777);
        $this->load->library('upload',$this->set_upload_options("../upload/mail/".$insert_id,$len*1024,false));
        $this->upload->initialize($this->set_upload_options("../upload/mail/".$insert_id,$len*1024,false));
        if(!empty($_FILES['file1']['name']) && $_FILES['file1']['name'] !=""){
          if ( ! $this->upload->do_upload('file1'))
          {
            $error = array('error' => $this->upload->display_errors());
          }
          else
          {
            $img_data = $this->upload->data();
            $this->base_model->updateDataById($insert_id,array("file1"=>$img_data["file_name"]),"tbl_mail","id");
          }
        }
        if(!empty($_FILES['file2']['name']) && $_FILES['file2']['name'] !=""){
          if ( ! $this->upload->do_upload('file2'))
          {
            $error = array('error' => $this->upload->display_errors());
          }
          else
          {
            $img_data = $this->upload->data();
            $this->base_model->updateDataById($insert_id,array("file2"=>$img_data["file_name"]),"tbl_mail","id");
          }
        }
        if(!empty($_FILES['file3']['name']) && $_FILES['file3']['name'] !=""){
          if ( ! $this->upload->do_upload('file3'))
          {
            $error = array('error' => $this->upload->display_errors());
          }
          else
          {
            $img_data = $this->upload->data();
            $this->base_model->updateDataById($insert_id,array("file3"=>$img_data["file_name"]),"tbl_mail","id");
          }
        }
      }
      redirect("panel?id=".$id);
    }

    public function bbs(){
      $data['btype'] = $this->input->get("btype");
      $data['panel'] = $this->base_model->getSelect("tbl_board",array(array("record"=>"id","value"=>$data['btype'])));
      $this->loadViews("bbs",$this->global,$data,NULL);
    }

    public function deliveryTable(){
      $data['deliveryAddress'] = $this->base_model->getDeliveryAddress();
      $data['man'] = $this->base_model->getRoleByMember();
      $options = 0;
      $rate = array(array());
      if(!empty($this->input->get("option"))){
        $data['deliveryContents'] =  $this->base_model->getDeliveryContents($this->input->get("option"));
        $data['options'] =$this->input->get("option");
      }
     else
      {

        $data['deliveryContents'] =  $this->base_model->getDeliveryContents($data['deliveryAddress'][0]->id);
        $data['options'] = $data['deliveryAddress'][0]->id;
      }
      $data['dtable'] = $this->base_model->getDtable();
      foreach ($data['man'] as $key => $value) {
        $a_rate = json_decode($value->address_rate,true);
        if(!empty($a_rate)){
          if(isset($a_rate[$data['options']]))
            $rate[$value->roleId][$data['options']] = $a_rate[$data['options']];
          else
            $rate[$value->roleId][$data['options']] = $value->sending_inul;
        }
        else
          $rate[$value->roleId][$data['options']] = $value->sending_inul;
      }
      $data['rate'] = $rate;
      $this->loadViews("deliveryTable",$this->global,$data,NULL);
    }

    public function deliverAddress(){
      $data['daddress'] = $this->base_model->getDeliveryAddress(2);
      $this->loadViews("deliveryAddress",$this->global,$data,NULL);
    }
    public function incomingBank(){
      $data['incomingBank'] = $this->base_model->getBank();
      $this->loadViews("incomingBank",$this->global,$data,NULL);
    }
    public function saveBank(){
      $count=$this->base_model->getBank();
      $data = array("name" =>$this->input->post("name"),
                    "bank" =>$this->input->post("bank"),
                    "number"=>$this->input->post("number"),
                    "updated_date"=>date("Y-m-d H:i"));
      if(sizeof($count) > 0){
        $this->base_model->updateBank($count[0]->id,$data);
      }else{
         $this->base_model->updateBank(0,$data);
      }
      redirect("incomingBank");
    }

    public function company(){
      $data['company'] = get_site_info();
      $this->loadViews("company",$this->global,$data,NULL);
    }
    public function saveCompany(){
      $data = $this->input->post();
      $count=$this->base_model->getCompany();
      if(sizeof($count) > 0){
        $this->base_model->updateCompany($count[0]->id,$data);
      }else{
         $this->base_model->updateCompany(0,$data);
      }
      redirect("company");
    }

    public function accuringRate(){
      $data['accuringRate'] = $this->base_model->getAccurRate();
      $this->loadViews("accuringRate",$this->global,$data,NULL);
    }
    public function saveAccurRate(){
      $title = $this->input->post("title");
      $rate =  $this->input->post("rate");
      $this->base_model->insertArrayData("tbl_accurrate",array("title"=>$title,
                                          "rate"=>$rate,
                                          "created_date"=>date("Y-m-d H:i")));
      redirect("accuringRate");
    }

    public function customexRate(){
      $data['customexRate'] = $this->base_model->getCustomExrate();
      $this->loadViews("customexRate",$this->global,$data,NULL);
    }
    public function saveCustomRate(){
      $title = $this->input->post("title");
      $rate =  $this->input->post("rate");
      $this->base_model->insertArrayData("tbl_custom_exchange_rate",array("title"=>$title,
                                          "rate"=>$rate,
                                          "created_date"=>date("Y-m-d H:i")));
      redirect("customexRate");
    }

    public function deliveryFee(){
      $data['deliveryFee'] = $this->base_model->getDeliveryFee();
      $this->loadViews("deliveryFee",$this->global,$data,NULL);
    }
    public function saveFee(){
      $this->base_model->updateDataById("1",$this->input->post(),"tbl_shipping_fee","id");
      redirect("deliveryFee");
    }

    public function topcat(){
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getCategory(0,10000,0));
      $returns = $this->paginationCompress ( "topcat/", $records_count,15);
      $data['topcat'] = $this->base_model->getCategory(0,$returns['page'],$returns['segment']);
      $data['tops'] = $this->base_model->getCategory(0,10000,0);
      $this->loadViews("topcat",$this->global,$data,NULL);
    }
    public function saveCategory(){
      $CATE_SEQ = $this->input->post("CATE_SEQ");
      $data = $this->input->post();
      $url = "topcat";
      if(!empty($this->input->post("url")))
      {
        $url = $this->input->post("url");
        unset($data['url']);
      }

      if($CATE_SEQ == 1 ){
        unset($data["id"]);
        unset($data["CATE_SEQ"]);
        $data['updated_date'] = date("Y-m-d H:i");
        $data['name'] = empty($data['kr_subject']) ? $data['name']:$data['kr_subject'];
        $ids =  $this->base_model->insertArrayData("tbl_category",$data);
        if(!file_exists("../upload/cat/".$ids))  mkdir("../upload/cat/" .$ids, 0777);
        $this->load->library('upload',$this->set_upload_options("../upload/cat/" .$ids,300000,false,"default"));
        if ( ! $this->upload->do_upload('image'))
        {
          $error = array('error' => $this->upload->display_errors());
        }
        else
        {
          $img_data = $this->upload->data();
          $this->base_model->updateDataById($ids,array("image"=>$img_data["file_name"]),"tbl_category","id");
        }
      }
      if($CATE_SEQ == 2){
        $id = $data["id"];
        unset($data["id"]);
        unset($data["CATE_SEQ"]);
        $data['updated_date'] = date("Y-m-d H:i");
        $data['name'] = empty($data['kr_subject']) ? $data['name']:$data['kr_subject'];
        $this->base_model->updateDataById($id,$data,"tbl_category","id");
        if(!file_exists("../upload/cat/".$id))  mkdir("../upload/cat/" .$id, 0777);
        $this->load->library('upload',$this->set_upload_options("../upload/cat/" .$id,300000,false,"default"));
        if ( ! $this->upload->do_upload('image'))
        {
          $error = array('error' => $this->upload->display_errors());
        }
        else
        {
          $img_data = $this->upload->data();
          $this->base_model->updateDataById($id,array("image"=>$img_data["file_name"]),"tbl_category","id");
        }
      }
      redirect($url);
    }

    public function childCat(){
      $this->load->library('pagination');
      if(!empty($this->input->get("category")) || $this->input->get("category") != "1")
        $c = $this->input->get("category");
      else $c = 0;
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $data['topcat'] = $this->base_model->getCategory(0,10000,0);
      if($this->input->get("category") > 0 && $this->input->get("category")!= 1)
      {
        $records_count = sizeof($this->base_model->getCategory($this->input->get("category"),10000,0));
        $returns = $this->paginationCompress ( "childCat/", $records_count,15);
        $data['childCat'] =$this->base_model->getCategory($this->input->get("category"),$returns['page'],$returns['segment']);
      }
      else{
        $records_count = sizeof($this->base_model->getChildCat(0,10000,0));
        $returns = $this->paginationCompress ( "childCat/", $records_count,15);
        $data['childCat'] =$this->base_model->getChildCat(0,$returns['page'],$returns['segment']);
      }
      $data["ss"] = sizeof($data['childCat']);
      $this->loadViews("childCat",$this->global,$data,NULL);
    }
    public function getCat(){
      $id = $this->input->post('id');
      echo json_encode($this->base_model->getChildCat($id));
    }

    public function saveDeliveryTable(){
      $this->base_model->insertArrayData('tbl_deliverytable',$this->input->post());
      redirect("deliveryTable");
    }

    public function memberLevel(){
      $data['man'] = $this->base_model->getRoleByMember("no","no");
      $data['deliveryAddress'] = $this->base_model->getSelect("delivery_address",array(array("record"=>"use","value"=>1)));
      $this->loadViews("memberLevel",$this->global,$data,NULL);
    }
    public function saveMemberLevel(){
      $address_rate = array();
      $data = $this->input->post();
      $data['type'] = 1;
      $roleId = $data['roleId'];
      unset($data['roleId']);
      $address = $this->base_model->getSelect("delivery_address",array(array("record"=>"use","value"=>1)));
      foreach($address as $key=>$add_v){
        $address_rate[$add_v->id] = $data['address_rate'][$key];
      }
      $data['address_rate'] = json_encode($address_rate);
      if($roleId ==0){
        $this->base_model->insertArrayData("tbl_roles",$data);
      }
      else{
        $this->base_model->updateDataById($roleId,$data,"tbl_roles","roleId");
      }

      redirect("memberLevel");
    }

    public function shoppingmal(){
      $data['shoppingmal'] = $this->base_model->getShoppingMal();
      $this->loadViews("shoppingmal",$this->global,$data,NULL);
    }

    public function saveShoppingMal(){
      $data = $this->input->post();
      $id  = $data['id'];
      unset($data['id']);
      if(!empty($id) && $id > 0 ){
        $data['updated_date'] = date("Y-m-d H:i");
        $this->base_model->updateDataById($id,$data,"tbl_shopping","id");
      }
      if(empty($id) || $id <=0){
        $data['created_date'] = date("Y-m-d H:i");
        $data['updated_date'] = date("Y-m-d H:i");
        $this->base_model->insertArrayData("tbl_shopping",$data);
      }
      redirect("shoppingmal");
    }

    public function coupon_register(){
      $data['member'] = array();
      if($this->input->get("page_type")!="level" && !empty($this->input->get("type"))){
        $data['member'] = $this->base_model->getMemberByType($this->input->get("type"),$this->input->get("content"));
      }
      if($this->input->get("page_type")=="level" && !empty($this->input->get("gender"))){
        $data['member'] = $this->base_model->getMemberByType($this->input->get("type"),$this->input->get("content"),$this->input->get("gender"));
      }
      $data['types'] = $this->base_model->getAll("tbl_coupon_type");
      $data['roles'] = $this->base_model->getSelect("tbl_roles",array(array("record"=>"level!=","value"=>"1"),array("record"=>"level!=","value"=>"2")));
      $this->loadViews("coupon_register",$this->global,$data,NULL);
    }

    public function saveCoupon(){
      $id = $this->input->post("id");
      $data = $this->input->post();
      unset($data["id"]);
      $terms = $data['terms1']."|".$data['terms2'];
      unset($data["terms1"]);
      unset($data["terms2"]);
      $data['terms'] = $terms;
      $data['created_date'] = date("Y-m-d H:i");
      if($data['event'] ==0){
        $chkMemCode = $data["chkMemCode"];
        unset($data["chkMemCode"]);
        $users = explode(",", $chkMemCode);
        foreach ($users as $key => $value) {
          $data["code"]=  "YE".date("y")."-".date("m").date("d")."-".generateRandomString(4,'n')."-".generateRandomString(4,'e');
          $result =  $this->base_model->insertArrayData("tbl_coupon",$data);
           if($result > 0)
              $this->base_model->insertArrayData("tbl_coupon_user",array( "coupon_id"=>$result,
                                                                          "userId"=>$value,
                                                                          "by"=>1,
                                                                          "created_date"=>date("Y-m-d H:i:s"),
                                                                          "code"=>$data["code"]));
            $this->base_model->insertArrayData("tbl_mail",array("toId"=>$value,
                                                          "fromId"=>1,
                                                          "title"=>"관리자 쿠폰 발급.",
                                                          "content"=>"회원님에게 쿠폰이 발급되었습니다.\n 쿠폰 페이지에서 직접 확인하세요",
                                                          "type"=>0,
                                                          "view"=>0,
                                                          "updated_date"=>date("Y-m-d H:i:s")));

        }
        redirect("coupon_register");
        return;
      }

      if(trim($id) !="" && $id > 0 )
      {
        $this->base_model->updateDataById($id,$data,"tbl_coupon","id");
      }
      else{
        $data["code"]=  "YE".date("y")."-".date("m").date("d")."-".generateRandomString(4,'n')."-".generateRandomString(4,'e');
        $result =  $this->base_model->insertArrayData("tbl_coupon",$data);
      }
      redirect("eventCoupon");
    }

    public function eventCoupon(){
      $data['coupon'] = $this->base_model->getCoupon(1);
      $data['types'] = $this->base_model->getAll("tbl_coupon_type");
      $this->loadViews("eventCoupon",$this->global,$data,NULL);
    }

    public function couponList(){
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $shPageSize =  empty($this->input->get("shPageSize")) ? 10: $this->input->get("shPageSize");
      $shUsedYn = empty($_GET['shUsedYn']) ?  NULL : $_GET['shUsedYn'];
      $shType   = empty($_GET['shType']) ?    NULL : $_GET['shType'];
      $seach_input   = empty($_GET['seach_input']) ?    NULL : $_GET['seach_input'];
      $starts_date  = empty($_GET['starts_date']) ?   NULL : $_GET['starts_date'];
      $ends_date    = empty($_GET['ends_date']) ?     NULL : date('Y-m-d', strtotime('+1 day', strtotime($_GET['ends_date'])));
      $records_count = sizeof($this->base_model->getCouponList(null,null,$starts_date,$ends_date ,$shUsedYn,$shType,$seach_input));
      $returns = $this->paginationCompress ( "couponList/", $records_count,$shPageSize);
      $data['couponList'] = $this->base_model->getCouponList($returns['page'],$returns['segment'],$starts_date,$ends_date ,$shUsedYn,$shType,$seach_input);
      $data["uc"] =$records_count;
      $data["pf"] = $returns["segment"];
      $this->loadViews("couponList",$this->global,$data,NULL);
    }

    public function deleteCoupon(){
      $chkMemCode = explode(",", $this->input->post('chkMemCode'));
      foreach ($chkMemCode as $key => $value) {
        $this->base_model->deleteCoupon($value);
      }
      redirect("couponList");
    }

    public function mail(){
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getMail(0,0,0,$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shType"),$this->input->get("content")));
      $returns = $this->paginationCompress ( "mail/", $records_count,15);
      $data['mail'] = $this->base_model->getMail(0,$returns['page'],$returns['segment'],$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shType"),$this->input->get("content"));
      $data["uc"] = $records_count;
      $data["pf"] = $returns["segment"];
      $this->loadViews("mail",$this->global,$data,NULL);
    }

    public function viewMail(){
      $id = $this->input->post("id");
      echo json_encode($this->base_model->getMessage($id));
    }

    public function editMail($id){
      $data['editMail'] = $this->base_model->getMessage($id);
      $this->loadViews("editMail",$this->global,$data,NULL);
    }

    public function SaveMail(){
      $data=$this->input->post();
      $id=$data["id"];
      unset($data["id"]);
      $this->base_model->updateDataById($id,$data,"tbl_mail","id");
      redirect("mail");
    }

    public function OrderHistory(){
      $data['OrderHistory1'] = $this->base_model->getPayMode(1);
      // $data['OrderHistory2'] = $this->base_model->getPayMode(2);
      // $data['OrderHistory3'] = $this->base_model->getPayMode(4);
      // $data['OrderHistory4'] = $this->base_model->getPayMode(3);
      $this->load->library('pagination');
      $shPageSize = !is_null($this->input->get("shPageSize")) ? $this->input->get("shPageSize"):10;
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getPay(0,0,$this->input->get("starts_date"),$this->input->get("ends_date")));
      $returns = $this->paginationCompress ( "pay_order/", $records_count, $shPageSize);
      $data['payHistory'] = $this->base_model->getPay($returns["page"],$returns["segment"],$this->input->get("starts_date"),$this->input->get("ends_date"));
      $data['csc'] = $records_count;
      $data['seg'] = $returns["segment"];
      $this->loadViews("OrderHistory",$this->global,$data,NULL);
    }

    public function memberpay(){
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getMemberPay(0,0,$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shType"),$this->input->get("content")));
      $returns = $this->paginationCompress ( "memberpay/", $records_count, $this->input->get("shPageSize"));
      $data['memberpay'] = $this->base_model->getMemberPay($returns["page"],$returns["segment"],$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shType"),$this->input->get("content"));
      $this->loadViews("memberpay",$this->global,$data,NULL);
    }

    public function registerPoint(){
      $data['member'] = array();
      $shPageSize = empty($_GET['shPageSize']) ?  10 : $_GET['shPageSize'];
      $starts_date   = empty($_GET['starts_date']) ?    NULL : $_GET['starts_date'];
      $ends_date  = empty($_GET['ends_date']) ?   NULL : $_GET['ends_date'];
      $s    = empty($_GET['s']) ?     NULL : $_GET['s'];
      $shType  = empty($_GET['shType']) ?   NULL : $_GET['shType'];
      if(!empty($this->input->get("types"))){
        $data['member'] = $this->base_model->getMemberByType($this->input->get("types"),$this->input->get("member"));
      }
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getPointHistory(null,null,$starts_date,$ends_date,$s,$shType));
      $returns = $this->paginationCompress ( "registerPoint/", $records_count, $shPageSize);
      $data["pointUser"] = $this->base_model->getPointHistory($returns["page"] ,$returns["segment"],$starts_date,$ends_date,$s,$shType);
      $data['csc'] = $records_count;
      $data['seg'] = $returns["segment"];
      $this->loadViews("registerPoint",$this->global,$data,NULL);
    }

    public function savePointUsers(){
      $users = $this->input->post("users");
      $users  = substr($users , 0, -1);
      $array_users = explode(",", $users);
      $terms1 = $this->input->post('terms1');
      $terms2  = $this->input->post('terms2');
      $plus = $this->input->post("plus");
      $point = $this->input->post("point");
      $use= 1;
      $return_result = $this->base_model->insertArrayData(  "tbl_point",array( "terms"=>$terms1."|".$terms2,
                                                            "point"=>$plus.$point,
                                                            "type"=>4,
                                                            "created_date"=>date("Y-m-d H:i")));
      if($return_result > 0){
        foreach ($array_users as $key => $value) {
          $this->base_model->plusValue("tbl_users","point",$point,array(array("userId",$value)),$plus);
          $ss = $this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$value)));
          $this->base_model->insertArrayData("tbl_point_users",array( "userId"=>$value,
                                                                      "point_id"=>$return_result,
                                                                      "point"=>$plus.$point,
                                                                      "type"=>4,
                                                                      "remain"=>$ss[0]->point));
          // $this->base_model->insertArrayData("tbl_mail",array("toId"=>$value,
          //                                               "fromId"=>1,
          //                                               "title"=>"포인트 적립.",
          //                                               "content"=>"회원님에게 포인트가 적립되였습니다.\n 포인트 페이지에서 직접 확인하세요",
          //                                               "type"=>0,
          //                                               "view"=>0,
          //                                               "updated_date"=>date("Y-m-d H:i:s")));

        }
      }
      redirect("registerPoint");
    }

    public function cancelPoint($id){
      $this->base_model->updateDataById($id,array("state"=>0),"tbl_point_users","id");
      $point = $this->base_model->getSelect("tbl_point_users",array(array("record"=>"id","value"=>$id)));
      if(!empty($point)){
        $this->base_model->plusValue("tbl_users","point",$point[0]->point,array(array("userId",$point[0]->userId)),"-");
        $ss = $this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$point[0]->userId)));
        $this->base_model->updateDataById($id,array("remain"=>$ss[0]->point),"tbl_point_users","id");
      }
      redirect("registerPoint");
    }

    public function deletePoint(){
      $id=$this->input->post("id");
      $this->base_model->deletePointUser($id);
      echo(json_encode(array('status'=>true)));
    }

    public function registerDepoit(){
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $shPageSize =  empty($this->input->get("shPageSize")) ? 10: $this->input->get("shPageSize");
      $state = $this->input->get("updated");
      $type   = empty($_GET['type']) ?    NULL : $_GET['type'];
      $start_date = empty($_GET['start_date']) ?  NULL : $_GET['start_date'];
      $end_date   = empty($_GET['end_date']) ?    NULL : $_GET['end_date'];
      $content   = empty($_GET['content']) ?    NULL : $_GET['content'];
      $records_count = sizeof($this->base_model->getDepositByUserId(null,0,$start_date,$end_date,$state,$type,$content));
      $returns = $this->paginationCompress ( "registerDeposit/", $records_count, $shPageSize);
      $data['deposit'] = $this->base_model->getDepositByUserId($returns["page"],$returns["segment"],$start_date,$end_date,$state,$type,$content);
      $data["uc"] =$records_count;
      $data["pf"] = $returns["segment"];
      $this->loadViews("registerDeposit",$this->global,$data,NULL);
    }

    public function updateDeposit(){
      $this->isLoggedIn();
      $sStat = $this->input->post("sStat");
      $userids = explode(",", $this->input->post("userids"));
      $chkReqSeq = $this->input->post("chkReqSeq");
      foreach ($chkReqSeq as $key => $value) {
        if($sStat ==1){
          $this->base_model->updateDeposit($value,$sStat);
          $results  =$this->base_model->getAmountD($value);
          $this->base_model->increaseAmount($results);
          $security = date("ymd").generateRandomString(10);
          $this->base_model->insertArrayData("tbl_payhistory",array(  "userId"=>$userids[$key],
                                                                      "payed_type"=>102,
                                                                      "amount"=>$results[0]->amount,
                                                                      "security"=>$security));
        }
        else{
          $this->base_model->updateDeposit($value,$sStat);
        }
     }
     redirect("registerDeposit");
    }

    public function ActDelivery(){
      $ORD_SEQ = $this->input->get("ORD_SEQ");
      $aa= array();
      $data['delivery']  = $this->base_model->getFDevliery($ORD_SEQ);
      if(empty($data['delivery'])) return;
      $data['products']  =$this->base_model->getProductByProductId($ORD_SEQ,1);
      if(sizeof($data['products']) > 0)
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
      $data['categorys'] = empty($category) ? 62 : $category;
      $data['address']  =$this->base_model->getSendAddress();
      $data['inMe'] = $this->base_model->getIncoMet();
      $data['trackings'] = $this->base_model->getTrackings();
      $data['category']  = $this->base_model->getSelect("tbl_category", array(array("record"=>"parent","value"=>0)),
                                      array(array("record"=>"updated_date","value"=>"DESC")));
      $data['service_header'] = $this->base_model->getSelect("tbl_service_header",array(array("record"=>"use","value"=>1)),
                                      array(array("record"=>"id","value"=>"ASC")));
      $services = $this->base_model->getServices();
      foreach ($services as $key => $value) {
        if (!isset($aa[$value->part])) {
          $aa[$value->part] = array();
        }
        array_push($aa[$value->part], array("name"=>$value->name,"price"=>$value->price,"id"=>$value->id));
      }
      $data['aa'] = $aa;
      $this->loadViews("acts",$this->global,$data,NULL);
    }

    function getProduct(){
      $category = $this->base_model->getSelect("tbl_category",
                                array(array("record"=>"parent","value"=>0)),
                                array(array("record"=>"updated_date","value"=>"DESC")));
    if(sizeof($category) > 0 ){
      $sub = $this->base_model->getSelect("tbl_category",array(array("record"=>"parent","value"=>$category[0]->id)));
    }
    $sShopNum = $this->input->get("sShopNum");
    $ORD_TY_CD = $this->input->get("ORD_TY_CD");
    $tracking_header= $this->base_model->getTrackingHeader();
    echo '
          <input type="hidden" name="ARV_STAT_CD" id="ARV_STAT_CD" value="1">
          <div class="order_table order_table_top">
            <table class="proBtn_write">
              <tbody>
                <tr>
                  <td width="30%">
                    <h4 class="s_tit vm_box" style="color:#ed7d31;">
                      <label style="font-size:14px;">상품#'.$sShopNum.'</label>
                      <input type="text" name="StockTxt" id="StockTxt" value="" class="stock-font" readonly="">
                      <input type="hidden" name="PRO_STOCK_SEQ" id="PRO_STOCK_SEQ" value="0">
                    </h4>
                  </td>
                  <td>
                    <div class="col-md-4 my-4">
                      <a href="javascript:fnPageCopy2('.$sShopNum.');" type="button" class="btn btn-warning btn-sm w-100">상품복사</a>
                    </div>
                    <div class="col-md-4 my-4">
                      <a href="javascript:fnProPlus('.$sShopNum.');" class="btn btn-success btn-sm w-100">+상품추가</a>
                    </div>
                    <div class="col-md-4 my-4">
                      <a href="javascript:fnStockTempDel('.$sShopNum.');" class="btn btn-danger btn-sm w-100">-상품삭제</a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="order_table">
            <table class="order_write">
              <colgroup>
                <col width="15%"><col width="35%">
                <col width="15%"><col width="35%">
              </colgroup>
              <tbody>';
                if($ORD_TY_CD !==1){
              echo '<tr id="DLVR_1">
                  <th>트래킹번호<br>Tracking No.</th>
                  <td colspan="3" class="vm_box">
                    <div class="row">
                      <div class="col-md-2 form-group tracks" style="padding-right: 15px">
                        <select name="FRG_DLVR_COM" class="form-control" id="FRG_DLVR_COM">';
                          foreach($tracking_header as $value):
                          echo '<option value="'.$value->name.'">'.$value->name.'</option>';
                          endforeach;
                    echo  '</select>
                      </div>
                      <div class="tracks" style="padding-right: 15px">
                        <input type="text" class="input_txt2" name="FRG_IVC_NO" id="FRG_IVC_NO" maxlength="40">
                        <label>
                          <input type="checkbox" name="TRACKING_NO_YN" id="TRACKING_NO_YN" onchange="fnTrkNoAfChk('.$sShopNum.');">트래킹 번호 나중에 입력
                        </label>
                      </div>

                    </div>
                  </td>
                </tr>;
                <tr id="ORD_1">
                  <th>오더번호</th>
                  <td colspan="3" class="vm_box">
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" class="input_txt2 per40" name="SHOP_ORD_NO" id="SHOP_ORD_NO" maxlength="40" value="">
                      </div>
                    </div>
                  </td>
                </tr>';
                }
              echo '<tr>
                  <th>
                    <p class="goods_img"><img src="/template/images/sample_img.jpg" width="109" height="128" id="sImgNo'.$sShopNum.'"></p>
                    <br><a href="javascript:openPopupImg('.$sShopNum.');" class="btn_small5 vm"><span>이미지등록</span></a>
                  </th>
                  <td colspan="3">
                    <div class="row" style="margin-top: 10px">
                      <label class="col-sm-1">* 통관품목</label>
                      <div class="col-md-2" style="padding-right: 15px;">
                        <select name="PARENT_CATE" class="form-control" onchange="fnArcAjax (this.value,\''.$sShopNum.'\');">';
                      foreach($category as $values):
                      echo '<option value="'.$values->id.'">'.$values->name.'</option>';
                      endforeach;
              echo    '</select>
                      </div>
                      <div class="col-md-2">
                        <select name="ARC_SEQ" class="form-control" id="TextArc_'.$sShopNum.'" onchange="fnArcChkYN(\''.$sShopNum.'\',this.value);">

                      </select>
                      </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                      <label class="col-sm-1">* 상품명(영문)</label>
                      <div class="col-md-2">
                        <input type="text" class="input_txt2 per40 form-control en_product_name" name="PRO_NM" id="PRO_NM" maxlength="200"  value="" title="상품명" required>
                      </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                      <label class="col-sm-1">* 단가</label>
                      <div class="col-md-2" style="padding-right: 15px;">
                        단가
                        <input type="text" class="input_txt2 per20 form-control COST" name="COST"  maxlength="10" value="0" title="단가" required
                        onblur="fnNumChiper(this, \'2\');fnTotalProPrice();">
                      </div>
                      <div class="col-md-2">
                        수량
                        <input type="text" class="input_txt2 per20 form-control QTY" name="QTY"  maxlength="5" value="1" title="수량" required
                        onblur="fnNumChiper(this, \'0\');fnTotalProPrice();">
                      </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                      <label class="col-sm-1">* 옵션</label>
                      <div class="col-md-2" style="padding-right: 15px;">
                        색상
                        <input type="text" class="input_txt2 per20 form-control" name="CLR" id="CLR" maxlength="100" value="" title="색상(영문)">
                      </div>
                      <div class="col-md-2">
                        사이즈
                        <input type="text" class="input_txt2 per20 form-control" name="SZ" id="SZ" maxlength="80" value="" title="사이즈">
                      </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                      <label class="col-sm-1">* 상품URL</label>
                      <div class="col-sm-5">
                        <input type="text" class="input_txt2 full form-control" name="PRO_URL" id="PRO_URL" maxlength="500" value="" title="상품URL">
                      </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                      <label class="col-sm-1">* 이미지URL  </label>
                      <div class="col-sm-5">
                        <input type="text" class="input_txt2 full form-control" name="IMG_URL" id="IMG_URL" maxlength="500" value="">
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="TextProduct'.(intval($sShopNum)+1).'"></div>';
    }


  public function ShowDelivery(){
      $ORD_SEQ = $this->input->get("ORD_SEQ");
      $aa = array();
      $data['delivery']  = $this->base_model->getFDevliery($ORD_SEQ);
      if(empty($data['delivery'])) return;
      $data['products']  =$this->base_model->getProductByProductId($ORD_SEQ,2);
      $data['service_header'] = $this->base_model->getSelect("tbl_service_header",array(array("record"=>"use","value"=>1)),
                                      array(array("record"=>"id","value"=>"ASC")));
      $services = $this->base_model->getServices();
      foreach ($services as $key => $value) {
        if (!isset($aa[$value->part])) {
          $aa[$value->part] = array();
        }
        array_push($aa[$value->part], array("name"=>$value->name,"price"=>$value->price,"id"=>$value->id));
      }
      $data['aa'] = $aa;
      $data['adding'] = $this->base_model->getSelect("tbl_add_price",array(array("record"=>"id","value"=>$data['delivery'][0]->id)));
      $this->loadViews("ShowDelivery",$this->global,$data,NULL);
  }

  public function setMemo(){
    $ORD_SEQ = $this->input->post("ORD_SEQ");
    $MngMemo = $this->input->post("MngMemo");
    $update = $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$ORD_SEQ)))[0]->updated_date;
    $this->base_model->updateDataById($ORD_SEQ,array("memo"=>$MngMemo,"updated_date"=>$update),'delivery',"id");
    echo "<script>window.history.back();</script>";
  }

  public function setTrackDelivery(){
    $data['sOrdSeq'] = $this->input->get("sOrdSeq");
    $data['track'] = $this->base_model->getTrackById($this->input->get("sOrdSeq"));
    $this->load->view("setTrackDelivery",$data);
  }

  public function updateTrackNumber(){
    $data= $this->input->post();
    $id = $data['ORD_SEQ'];
    unset($data['ORD_SEQ']);
    $this->base_model->updateDataById($id,$data,"delivery","id");
    echo "<script>window.close();</script>";
  }


    public function homePage(){
      $data['mobile'] = $this->input->get("mobile")==1 ? 1:0;
      $data['banner'] = $this->base_model->getSelect("banner",array(array("record"=>"type","value"=>1),
                                                                    array("record"=>"mobile","value"=>$data['mobile'])));
      $data["type"] = "homePage";
      $data['banner_type'] = 1;
      $this->loadViews('homePage', $this->global, $data , NULL);
    }

    public function saveBanner(){
      $data= $this->input->post();
      $id = $data['id'];
      $redirect_url = $data['redirect_url'];
      unset($data['id']);
      unset($data['redirect_url']);
      if(empty($id) || $id <=0){
        $return  =  $this->base_model->insertArrayData("banner",$data);
      }
      if(!empty($id) || $id  >0 ){
        $this->base_model->updateDataById($id,$data,"banner","id");
        $return = $id;
      }
      if($return > 0){
        if($_FILES['image']['name'] !=""){
          if($this->input->post("mobile") ==1){
            $this->load->library('upload',$this->set_upload_options("../m/upload/homepage/banner"));
            $this->upload->initialize($this->set_upload_options("../m/upload/homepage/banner"));
          }
          else{
            $this->load->library('upload',$this->set_upload_options("../upload/homepage/banner"));
            $this->upload->initialize($this->set_upload_options("../upload/homepage/banner"));
          }
          if ( ! $this->upload->do_upload('image'))
          {
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
            return;
          }
          else
          {
            $img_data = $this->upload->data();
            $this->base_model->updateDataById($return,array("image"=>$img_data["file_name"]),"banner","id");
          }
        }
        if($_FILES['image1']['name'] !=""){
          $this->load->library('upload',$this->set_upload_options("../upload/homepage/banner"));
          $this->upload->initialize($this->set_upload_options("../upload/homepage/banner"));
          if ( ! $this->upload->do_upload('image1'))
          {
            $error = array('error' => $this->upload->display_errors());

          }
          else
          {
            $img_data = $this->upload->data();
            $this->base_model->updateDataById($return,array("image1"=>$img_data["file_name"]),"banner","id");
          }
        }
      }
      redirect($redirect_url);
    }

    public function banner_s(){
      $type = $this->input->get("type");
      if(empty($type))
      {
        echo "오류";
        return;
      }
      $data['banner_s'] = $this->base_model->getSelect("banner",array(array("record"=>"type","value"=>$type)),
                                                                array(array("record"=>"order","value"=>"ASC")));
      $this->loadViews('banner_s', $this->global, $data , NULL);
    }

    public function saveBanner_S(){
      $data= $this->input->post();
      $id = $data['id'];
      unset($data['id']);
      if(!empty($id) && $id > 0 ){
        $this->base_model->updateDataById($id,$data,"banner","id");
        $return = $id;
      }
      if(empty($id) || $id <=0){
        $return  =  $this->base_model->insertArrayData("banner",$data);
      }
      if($return > 0){
        if($_FILES['image']['name'] !=""){
          $this->load->library('upload',$this->set_upload_options("../upload/homepage/banner_r"));
          $this->upload->initialize($this->set_upload_options("../upload/homepage/banner_r"));
          if ( ! $this->upload->do_upload('image'))
          {
            $error = array('error' => $this->upload->display_errors());

          }
          else
          {
            $img_data = $this->upload->data();
            $this->base_model->updateDataById($return,array("image"=>$img_data["file_name"]),"banner","id");
          }
        }
        if($_FILES['image1']['name'] !=""){
          $this->load->library('upload',$this->set_upload_options("../upload/homepage/banner_r"));
          $this->upload->initialize($this->set_upload_options("../upload/homepage/banner_r"));
          if ( ! $this->upload->do_upload('image1'))
          {
            $error = array('error' => $this->upload->display_errors());

          }
          else
          {
            $img_data = $this->upload->data();
            $this->base_model->updateDataById($return,array("image1"=>$img_data["file_name"]),"banner","id");
          }
        }
      }
      redirect("/banner_s?type=".$data['type']);
    }

    public function saveHeader(){
      if($_FILES['image']['name'] !=""){
        $this->load->library('upload',$this->set_upload_options("../template/images",30000,false,"top_logo"));
        $this->upload->initialize($this->set_upload_options("../template/images",30000,false,"top_logo"));
        if ( ! $this->upload->do_upload('image'))
        {
          $error = array('error' => $this->upload->display_errors());

        }
        else
        {
          $img_data = $this->upload->data();
          $this->base_model->updateDataById(76,array("image"=>$img_data["file_name"],"type"=>20),"banner","id");
        }
      }
      if($_FILES['image1']['name'] !=""){
        $this->load->library('upload',$this->set_upload_options("../template/images",30000,false,"top_logo_left"));
        $this->upload->initialize($this->set_upload_options("../template/images",30000,false,"top_logo_left"));
        if ( ! $this->upload->do_upload('image1'))
        {
          $error = array('error' => $this->upload->display_errors());

        }
        else
        {
          $img_data = $this->upload->data();
          $this->base_model->updateDataById(76,array("image1"=>$img_data["file_name"],"type"=>20),"banner","id");
        }
      }
       redirect("footer_management");
    }

    public function saveFooter(){
      $this->base_model->updateDataById(77,array("description"=>$this->input->post("content",false),"type"=>21),"banner","id");
      if($_FILES['image']['name'] !=""){
        $this->load->library('upload',$this->set_upload_options("../template/images",30000,false,"footer_logo"));
        $this->upload->initialize($this->set_upload_options("../template/images",30000,false,"footer_logo"));
        if ( ! $this->upload->do_upload('image'))
        {
          $error = array('error' => $this->upload->display_errors());

        }
        else
        {
          $img_data = $this->upload->data();
          $this->base_model->updateDataById(77,array("image"=>$img_data["file_name"],"type"=>21),"banner","id");
        }
      }
      if($_FILES['image1']['name'] !=""){
        $this->load->library('upload',$this->set_upload_options("../template/images",30000,false,"footer_logo_left"));
        $this->upload->initialize($this->set_upload_options("../template/images",30000,false,"footer_logo_left"));
        if ( ! $this->upload->do_upload('image1'))
        {
          $error = array('error' => $this->upload->display_errors());

        }
        else
        {
          $img_data = $this->upload->data();
          $this->base_model->updateDataById(77,array("image1"=>$img_data["file_name"],"type"=>21),"banner","id");
        }
      }
       redirect("footer_management");
    }

    public function event(){
      $data['event'] = $this->base_model->getEvent();
      $data['eventhome'] = $this->base_model->getSelect("tbl_eventhome");
      $this->loadViews('event', $this->global, $data , NULL);
    }

    public function saveEvent(){
      $data= $this->input->post();
      $id = $data['id'];
      $terms = $data['terms1']."|".$data['terms2'];
      unset($data['terms1']);
      unset($data['terms2']);
      $data['terms'] = $terms;
      if(!empty($id) && $id > 0 ){
        $this->base_model->updateDataById($id,$data,"tbl_event","id");
        $return = $id;
      }
      if(empty($id) || $id <= 0){
        $return  =  $this->base_model->insertArrayData("tbl_event",$data);
      }

      if($return > 0){
        if($_FILES['image']['name'] !=""){
          $this->load->library('upload',$this->set_upload_options("../upload/homepage/event"));
          $this->upload->initialize($this->set_upload_options("../upload/homepage/event"));
          if ( ! $this->upload->do_upload('image'))
          {
            $error = array('error' => $this->upload->display_errors());
          }
          else
          {
            $img_data = $this->upload->data();
            $this->base_model->updateDataById($return,array("image"=>$img_data["file_name"]),"tbl_event","id");
          }
        }
      }
      redirect("/event");
    }

  public function popup(){
    $data['popup'] = $this->base_model->getPopup();
    $this->loadViews("popup",$this->global,$data,NULL);
  }

  public function savePopup(){
    $data = $this->input->post();
    $data["content"] = $this->input->post("content",false);
    $id= $data['id'];
    unset($data['id']);
    $terms = $data['terms1']."|".$data['terms2'];
    unset($data['terms1']);
    unset($data['terms2']);
    $data['terms'] = $terms;
    if(!empty($id) && $id > 0 ){
      $this->base_model->updateDataById($id,$data,"tbl_popup","id");
    }
    if(empty($id) || $id <=0){
      $this->base_model->insertArrayData("tbl_popup",$data);
    }
    redirect("/popup");
  }

  public function recomment_site(){
    $data['recomment_site'] = $this->base_model->getReSite();
    $this->loadViews("recomment_site",$this->global,$data,NULL);
  }

  public function saveRecommend(){
    $data= $this->input->post();
    $id= $data['id'];
    unset($data['id']);
     if(!empty($id) && $id > 0 ){
      $this->base_model->updateDataById($id,$data,"tbl_recommend_sites","id");
      $return  = $id;
    }
    if(empty($id) || $id <=0){
       $return  =  $this->base_model->insertArrayData("tbl_recommend_sites",$data);
    }
    if($return > 0){
      if($_FILES['image']['name'] !=""){
        $this->load->library('upload',$this->set_upload_options("../upload/homepage/recommend"));
        $this->upload->initialize($this->set_upload_options("../upload/homepage/recommend"));

        if ( ! $this->upload->do_upload('image'))
        {
          $error = array('error' => $this->upload->display_errors());

        }
        else
        {
          $img_data = $this->upload->data();
          $this->base_model->updateDataById($return,array("image"=>$img_data["file_name"]),"tbl_recommend_sites","id");
        }
      }
    }
    redirect("/recomment_site");
  }

  public function recomment_products(){
    $data['recomment_products'] = $this->base_model->getProductSRecommend();
    $this->loadViews("recomment_products",$this->global,$data,NULL);
  }

  public function saveRecommentProduct(){
    $data= $this->input->post();
    $id= $data['id'];
    unset($data['id']);
    if(!empty($id) && $id > 0 ){
      $this->base_model->updateDataById($id,$data,"tbl_recommend_products","id");
      $return  = $id;
    }
    if(empty($id) || $id <=0){
       $return  =  $this->base_model->insertArrayData("tbl_recommend_products",$data);
    }
    if($return > 0){
      if($_FILES['image']['name'] !=""){
        $this->load->library('upload',$this->set_upload_options("../upload/homepage/recommendPro"));
        $this->upload->initialize($this->set_upload_options("../upload/homepage/recommendPro"));
        if ( ! $this->upload->do_upload('image'))
        {
          $error = array('error' => $this->upload->display_errors());

        }
        else
        {http://uriminzokkiri.com/index.php?ptype=search
          $img_data = $this->upload->data();
          $this->base_model->updateDataById($return,array("image"=>$img_data["file_name"]),"tbl_recommend_products","id");
        }
      }
    }
    redirect("/recomment_products");
  }

  public function sms_history(){
     $this->loadViews("sms_history",$this->global,null,NULL);
  }

  public function ActReturn(){
    $insert_id = 0;
    $returns = explode("|",$this->input->post("returns"));
    $ORD_SEQ = $this->input->post("ORD_SEQ");
    $plength = sizeof($this->base_model->getSelect("tbl_purchasedproduct",array(array("record"=>"delivery_id","value"=>$ORD_SEQ))));
    if($plength > sizeof($returns)){
      $delivery = $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$ORD_SEQ)));
      if(sizeof($delivery) > 0){
        $delivery = $delivery[0];
        $delivery->state = 19;
        $delivery->return_check =0;
        $delivery->return_price =0;
        $delivery->type =4;
        $delivery->get = "return";
        unset($delivery->id);
        $insert_id =  $this->base_model->insertArrayData("delivery",$delivery);
        $this->base_model->insertArrayData("tbl_service_delivery",array("content"=>"[]","delivery_id"=>$insert_id));
        foreach($returns as $value){
          $this->base_model->updateDataById($value,array("delivery_id"=>$insert_id),"tbl_purchasedproduct","id");
        }
      }
    }
    if($plength == sizeof($returns)){
      $insert_id = $ORD_SEQ;
      $this->base_model->updateDataById($ORD_SEQ,array("type"=>4,"state"=>19,"get"=>"return","updated_date"=>date("Y-m-d H:i:s")),"delivery","id");
    }

    if($insert_id > 0){
      if (!file_exists("upload/return/".$insert_id))
        mkdir("upload/return/".$insert_id, 0777);
      $this->load->library('upload',$this->set_upload_options("upload/return/".$insert_id,5*1024,'*',false));
      $this->upload->initialize($this->set_upload_options("upload/return/".$insert_id,5*1024,'*',false));
      if(!empty($_FILES['RTN_FL_'.$ORD_SEQ]['name']) && $_FILES['RTN_FL_'.$ORD_SEQ]['name'] !=""){
        if ( ! $this->upload->do_upload('RTN_FL_'.$ORD_SEQ))
        {
          $error = array('error' => $this->upload->display_errors());
        }
        else
        {
          $img_data = $this->upload->data();
          $this->base_model->updateDataById($insert_id,array("return_file"=>$img_data["file_name"]),"delivery","id");
        }
      }
    }
    redirect("/dashboard?step=19");
  }

  public function paying(){
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $deposit_part = empty($_GET['deposit_part']) ?  NULL : $_GET['deposit_part'];
    $type_parts   = empty($_GET['type_parts']) ?    NULL : $_GET['type_parts'];
    $starts_date  = empty($_GET['starts_date']) ?   NULL : $_GET['starts_date'];
    $ends_date    = empty($_GET['ends_date']) ?     NULL : $_GET['ends_date'];
    $pay_parts    = empty($_GET['pay_parts']) ?     NULL : $_GET['pay_parts'];
    $member_part  = empty($_GET['member_part']) ?   NULL : $_GET['member_part'];
    $search_txt   = empty($_GET['search_txt']) ?    NULL : $_GET['search_txt'];
    $shPageSize   = empty($_GET['shPageSize']) ?    10 : $_GET['shPageSize'];
    $records_count = $this->base_model->getPayedProducts(null,$deposit_part ,$type_parts ,$starts_date ,$ends_date ,$pay_parts ,
        $member_part ,$search_txt);
    $returns = $this->paginationCompress ( "paying/", $records_count, $shPageSize);
      $pays = $this->base_model->getPayHistory($returns["page"],$returns["segment"],null,$deposit_part,$type_parts,$starts_date,$ends_date,$pay_parts,$member_part,$search_txt);
    $temp = '';
    $result = array();
    $orderr = array();
    $tamount = 0;
    $tdeposit = 0;
    $otarray = array();
    $count = 0;
    foreach ($pays as $key => $value) {
      $amount=0;
      $label = "";
      if($value->type==1) {$amount=$value->sending_price;$label = "배송비용";};
      if($value->type==2) {$amount=$value->purchase_price;$label = "구매비용";}
      if($value->type==3) {$amount=$value->return_price;$label = "리턴비용";}
      if($value->type==4) {$amount=$value->add_price;$label = "추가결제비용";}
      if($value->type==60) {$amount=$value->purchase_price + $value->sending_price;$label = "쇼핑몰";}
      if($temp!=$value->security)
      {
        $tarray =array( "id"=>$value->id,
                        "userId"=>$value->userId,
                        "name"=>$value->name,
                        "login"=>$value->loginId,
                        "all_amount"=>$value->all_amount,
                        "amount"=>$value->amount,
                        "type"=>$value->payed_type,
                        "update"=>$value->updated_date,
                        "security"=>$value->security,
                        "pending"=>$value->pending,
                        "pamount"=>$value->pamount,
                        "state"=>$value->state,
                        "point"=>$value->bpoint,
                        "by"=>$value->by,
                        "payed_type"=>$value->payed_type,
                        "coupon_type"=>$value->coupon_type);
        $temp = $value->security;
        array_push($result,$tarray);
        $count =0;
        $orderr[$value->security][$count]=array( "order"=>$value->OrdNum,
                                "amount"=>$amount,
                                "label"=>$label,
                                "delivery_id"=>$value->delivery_id);
      }
      else{
        $count++;
        $orderr[$value->security][$count]=array( "order"=>$value->OrdNum,
                                "amount"=>$amount,
                                "label"=>$label,
                                "delivery_id"=>$value->delivery_id);
      }

    }
    $data['orderr'] = $orderr;
    $data['data'] = $result;
    $data["uc"] = $records_count;
    $data["pf"] = $returns["segment"];
    $this->loadViews("paying",$this->global,$data,NULL);
  }

  public function deletePd(){
    $pid = $this->input->post("pid");
    $this->isLoggedIn();
    if(!empty($pid)):
      $this->base_model->deleteRecordCustom("tbl_prodcucts","id",$pid);
      echo json_encode(array("status"=>true));
    endif;
    if(empty($pid)):
      echo json_encode(array("status"=>false));
    endif;
  }
  public function deleteDtable(){
    $dtid = $this->input->post("dtid");
    $this->isLoggedIn();
    if(!empty($dtid)):
      $this->base_model->deleteRecordCustom("tbl_deliverytable","id",$dtid);
      echo json_encode(array("status"=>true));
    endif;
    if(empty($dtid)):
      echo json_encode(array("status"=>false));
    endif;
  }

  public function editDeliverA($id){

  }

  public function getDelA(){
    $delA = $this->input->post("delA");
    $dt = $this->base_model->getSelect("delivery_address",array(array("record"=>"id","value"=>$delA)));
    echo json_encode($dt);
  }

  public function updateDelA(){

    $data = $this->input->post();
    $id = $data['id'];
    $ids = 0;
    unset($data['id']);
    if(empty($id) || $id <= 0 ):
      $ids = $this->base_model->insertArrayData("delivery_address",$data);
    endif;
    if(!empty($id) && $id > 0):
      $ids = $id;
      $this->base_model->updateDataById($id,$data,"delivery_address","id");
    endif;
    if($ids > 0){
      if($_FILES['image']['name'] !=""){
        $this->load->library('upload',$this->set_upload_options("../m/upload/deliveryAddress"));
        $this->upload->initialize($this->set_upload_options("../m/upload/deliveryAddress"));
        if ( $this->upload->do_upload('image'))
        {
            $img_data = $this->upload->data();
            $this->base_model->updateDataById($id,array("image"=>$img_data["file_name"]),"delivery_address","id");
        }
      }
    }
    redirect("/deliverAddress");
  }

  public function deleteDt(){
      $dela = $this->input->post("dela");
      $this->isLoggedIn();
      if(!empty($dela)):
        $this->base_model->deleteRecordCustom("delivery_address","id",$dela);
        echo json_encode(array("status"=>true));
      endif;
      if(empty($dela)):
        echo json_encode(array("status"=>false));
      endif;
  }

  public function getShopping(){
    $shopid = $this->input->post("shopid");
    $dt = $this->base_model->getSelect("tbl_shopping",array(array("record"=>"id","value"=>$shopid)));
    echo json_encode($dt);
  }

  public function deleteShop(){
    $shopid = $this->input->post("shopid");
    $this->isLoggedIn();
    if(!empty($shopid)):
      $this->base_model->deleteRecordCustom("tbl_shopping","id",$shopid);
      echo json_encode(array("status"=>true));
    endif;
    if(empty($shopid)):
      echo json_encode(array("status"=>false));
    endif;
  }

  public function getCats(){
    $cat = $this->input->post("cat");
    $dt = $this->base_model->getSelect("tbl_category",array(array("record"=>"id","value"=>$cat)));
    echo json_encode($dt);
  }

  public function deleteCat(){
    $cat = $this->input->post("cat");
      $this->isLoggedIn();
      if(!empty($cat)):
        $this->base_model->deleteRecordCustom("tbl_category","id",$cat);
        $this->base_model->deleteRecordCustom("tbl_category","parent",$cat);
        echo json_encode(array("status"=>true));
      endif;
      if(empty($cat)):
        echo json_encode(array("status"=>false));
      endif;
  }

  public function getHome(){
    $home = $this->input->post("home");
    $dt = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>$home)));
    echo json_encode($dt);
  }

  public function deleteHome(){
    $home = $this->input->post("home");
    $this->isLoggedIn();
    if(!empty($home)):
      $this->base_model->deleteRecordCustom("banner","id",$home);
      echo json_encode(array("status"=>true));
    endif;
    if(empty($home)):
      echo json_encode(array("status"=>false));
    endif;
  }

  public function getBanner(){
    $banner = $this->input->post("banner");
    $dt = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>$banner)));
    echo json_encode($dt);
  }

  public function deleteBanner(){
    $banner = $this->input->post("banner");
    $this->isLoggedIn();
    if(!empty($banner)):
      $this->base_model->deleteRecordCustom("banner","id",$banner);
      echo json_encode(array("status"=>true));
    endif;
    if(empty($banner)):
      echo json_encode(array("status"=>false));
    endif;
  }

  public function getEvent()
  {
    $event = $this->input->post("event");
    $dt = $this->base_model->getSelect("tbl_event",array(array("record"=>"id","value"=>$event)));
    echo json_encode($dt);
  }

  public function deleteEvent(){
    $event = $this->input->post("event");
    $this->isLoggedIn();
    if(!empty($event)):
      $this->base_model->deleteRecordCustom("tbl_event","id",$event);
      echo json_encode(array("status"=>true));
    endif;
    if(empty($event)):
      echo json_encode(array("status"=>false));
    endif;
  }

  public function editPopup(){
    $popup = $this->input->post("popup");
    $dt = $this->base_model->getSelect("tbl_popup",array(array("record"=>"id","value"=>$popup)));
    echo json_encode($dt);
  }

  public function deletePopup(){
    $popup = $this->input->post("popup");
    $this->isLoggedIn();
    if(!empty($popup)):
      $this->base_model->deleteRecordCustom("tbl_popup","id",$popup);
      echo json_encode(array("status"=>true));
    endif;
    if(empty($popup)):
      echo json_encode(array("status"=>false));
    endif;
  }

  public function editRecommend(){
    $recommend = $this->input->post("recommend");
    $dt = $this->base_model->getSelect("tbl_recommend_sites",array(array("record"=>"id","value"=>$recommend)));
    echo json_encode($dt);
  }
  public function deleteRecommend(){
    $recommend = $this->input->post("recommend");
    $this->isLoggedIn();
    if(!empty($recommend)):
      $this->base_model->deleteRecordCustom("tbl_recommend_sites","id",$recommend);
      echo json_encode(array("status"=>true));
    endif;
    if(empty($recommend)):
      echo json_encode(array("status"=>false));
    endif;
  }

  public function editRecomP(){
    $rep = $this->input->post("rep");
    $dt = $this->base_model->getSelect("tbl_recommend_products",array(array("record"=>"id","value"=>$rep)));
    echo json_encode($dt);
  }
  public function deleteRecomP(){
    $rep = $this->input->post("rep");
    $this->isLoggedIn();
    if(!empty($rep)):
      $this->base_model->deleteRecordCustom("tbl_recommend_products","id",$rep);
      echo json_encode(array("status"=>true));
    endif;
    if(empty($rep)):
      echo json_encode(array("status"=>false));
    endif;
  }

  public function shopProducts(){
    $category = 0;
    $cate_sea = array();
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $where = array();
    $shPageSize =  empty($this->input->get("shPageSize")) ? 10: $this->input->get("shPageSize");
    $data['left_category'] = $this->base_model->getSelect("tbl_leftcategory", array( array("record"=>"use","value"=>1),
                                                                                array("record"=>"parent","value"=>0)),
                                                                          array(array("record"=>"order","value"=>"ASC")));

    if(!empty($this->input->get("left1")))
    {


        $category = $this->input->get("left1");
        $data["left1_cates"] = $this->base_model->getSelect("tbl_leftcategory", array( array("record"=>"use","value"=>1),
                                                                                array("record"=>"parent","value"=>$this->input->get("left1"))),
                                                                          array(array("record"=>"order","value"=>"ASC")));

    }

    if(!empty($this->input->get("left2")))
    {


        $category = $this->input->get("left2");
        $data["left2_cates"] = $this->base_model->getSelect("tbl_leftcategory", array( array("record"=>"use","value"=>1),
                                                                                array("record"=>"parent","value"=>$this->input->get("left2"))),
                                                                          array(array("record"=>"order","value"=>"ASC")));

    }

    if(!empty($this->input->get("left3"))){
      $category = $this->input->get("left3");
    }

    if(!empty($category) && $category > 0){
      $productid = array();
      $temp = $this->getChildCateogriesFromParentID($category);
      if(!empty($temp["category"]))
        $cate_sea = $temp["category"];
    }

    if($this->input->get("shUseYn") !=null && trim($this->input->get("shUseYn")) !="")
    {
      $temp = array();
      $temp["record"] = "use";
      $temp["value"] = $this->input->get("shUseYn");
      array_push($where, $temp);
    }
    if(!empty($this->input->get("brands")))
    {
      $temp = array();
      $temp["record"] = "brand";
      $temp["value"] = $this->input->get("brands");
      array_push($where,$temp);
    }
    if(!empty($this->input->get("search_pname")))
    {
      $temp = array();
      $temp["record"] = "name";
      $temp["value"] = $this->input->get("search_pname");
      array_push($where,$temp);
    }

    if(trim($this->input->get("search_best")) != "")
    {
      $temp = array();
      $temp["record"] = "p_bestview";
      $temp["value"] = $this->input->get("search_best");
      array_push($where,$temp);
    }

    if(trim($this->input->get("search_new")) != "")
    {
      $temp = array();
      $temp["record"] = "p_newview";
      $temp["value"] = $this->input->get("search_new");
      array_push($where,$temp);
    }

    if(trim($this->input->get("search_wow")) != "")
    {
      $temp = array();
      $temp["record"] = "p_saleview";
      $temp["value"] = $this->input->get("search_wow");
      array_push($where,$temp);
    }



    $records_count = sizeof($this->base_model->getProductsOrder(-1,-1,$where,$cate_sea));
    $returns = $this->paginationCompress ( "shopProducts/", $records_count, $shPageSize);
    $data['products'] = $this->base_model->getProductsOrder($returns["page"],$returns["segment"],$where,$cate_sea);


    $data['ac'] = $records_count;
    $data['cc'] = $returns["segment"];

    $this->loadViews("shopProducts",$this->global,$data,NULL);
  }

  public function addshop(){

    $data['category'] = $this->base_model->getSelect("tbl_category",array(array("record"=>"parent","value"=>'0'),
                                                                          array("record"=>"use","value"=>1)));
    $data['categorys'] = $this->base_model->getSelect("tbl_category",array( array("record"=>"parent","value"=>$data['category'][0]->id),
                                                                            array("record"=>"use","value"=>1)));

    $data['shop_category'] = $this->base_model->getSelect("tbl_shop_category",array(array("record"=>"use","value"=>1)),
                                                                              array(array("record"=>"order","value"=>"ASC")));

    $data['left_category'] = $this->base_model->getSelect("tbl_leftcategory", array( array("record"=>"use","value"=>1),
                                                                                array("record"=>"parent","value"=>0)),
                                                                          array(array("record"=>"order","value"=>"ASC")));
    $data['p_icons'] = $this->base_model->getSelect("tbl_proico",NULL,array(array("record"=>"order","value"=>"ASC")));
    $data['selected_name'] = "";
    $data['selected_id'] = "";
    $this->loadViews("addshop",$this->global,$data,NULL);
  }
  public function registerShop(){
    $data = $this->input->post();
    $data["best_big"] = $this->input->post("best_big",true);
    $data["best_small"] = $this->input->post("best_small",true);
    $data["description"] = $this->input->post("description",false);
    $name = isset($data['names']) ? $data['names'] : "";
    $keys = isset($data['keys']) ? $data['keys'] : "";
    $use= isset($data['uses']) ? : "";
    $need = isset($data['needs']) ? $data['needs'] : "";
    $selected_cateogry = $data['selected_cateogry'];
    unset($data['selected_cateogry']);
    unset($data['needs']);
    unset($data['uses']);
    unset($data['names']);
    unset($data['keys']);
    unset($data['p_category1']);
    unset($data['p_category2']);
    unset($data['p_category3']);
    $id= $data['id'];
    unset($data['id']);
    if(!empty($data['p_icon']))
      $data['p_icon'] = implode(",", $data['p_icon']);
    else
      $data['p_icon'] = "";

    if($selected_cateogry > 0)
    {
      $checked_selected  = $this->base_model->getSelect("tbl_related_product",array(array("record"=>"pcode","value"=>$data['rid'])));
      if(sizeof($checked_selected) > 0)
        $this->base_model->updateDataById($data['rid'],array("category_id"=>$selected_cateogry),"tbl_related_product","pcode");
      else
        $this->base_model->insertArrayData("tbl_related_product",array("pcode"=>$data['rid'],"category_id"=>$selected_cateogry));
    }

    if($selected_cateogry ==-1 ){
      $this->base_model->deleteRecordCustom("tbl_related_product","pcode",$data['rid']);
    }

    if(!empty($id) && $id > 0){
      $data['updated_date'] = date("Y-m-d H:i");
      $this->base_model->updateDataById($id,$data,"tbl_sproducts","id");
      $return = $id;
    }
    else{
      $data['updated_date'] = date("Y-m-d H:i");
      $return = $this->base_model->insertArrayData("tbl_sproducts",$data);
      if($return > 0 && !empty($name)){
        foreach($name as $key=>$n){
          $this->base_model->insertArrayData("tbl_options",array( "name"=>$n,
                                                                  "key"=>$keys[$key],
                                                                  "use"=>$use[$key],
                                                                  "need"=>$need[$key],
                                                                  "product_id"=>$return));

        }
      }
    }

    if($return  > 0){
      if(!file_exists("../upload/shoppingmal/".$return))  mkdir("../upload/shoppingmal/" .$return, 0777);
      $this->load->library('upload',$this->set_upload_options("../upload/shoppingmal/" .$return));
      if ( ! $this->upload->do_upload('i1'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($return,array("i1"=>$img_data["file_name"]),"tbl_sproducts","id");
      }
      if ( ! $this->upload->do_upload('i2'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($return,array("i2"=>$img_data["file_name"]),"tbl_sproducts","id");
      }
      if ( ! $this->upload->do_upload('i3'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($return,array("i3"=>$img_data["file_name"]),"tbl_sproducts","id");
      }
      if ( ! $this->upload->do_upload('i4'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($return,array("i4"=>$img_data["file_name"]),"tbl_sproducts","id");
      }
      if ( ! $this->upload->do_upload('i5'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($return,array("i5"=>$img_data["file_name"]),"tbl_sproducts","id");
      }

      if ( ! $this->upload->do_upload('image'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($return,array("image"=>$img_data["file_name"]),"tbl_sproducts","id");
      }



      if ( ! $this->upload->do_upload('details1'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($return,array("details1"=>$img_data["file_name"]),"tbl_sproducts","id");
      }

      if ( ! $this->upload->do_upload('details2'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($return,array("details2"=>$img_data["file_name"]),"tbl_sproducts","id");
      }

      if ( ! $this->upload->do_upload('details3'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($return,array("details3"=>$img_data["file_name"]),"tbl_sproducts","id");
      }

      if ( ! $this->upload->do_upload('details4'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($return,array("details4"=>$img_data["file_name"]),"tbl_sproducts","id");
      }

      if ( ! $this->upload->do_upload('details5'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($return,array("details5"=>$img_data["file_name"]),"tbl_sproducts","id");
      }

    }
    redirect("shopProducts");
  }

  public function editsproduct($id){
    $data['selected_name'] = "";
    $data['selected_id'] = "";
    $data['product'] = $this->base_model->getSelect("tbl_sproducts",array(array("record"=>"id","value"=>$id)));
    if(empty($data['product'])) return;
    $data['category'] = $this->base_model->getSelect("tbl_category",array(array("record"=>"parent","value"=>'0')));
    $ca = $data['product'][0]->category;
    $ids = $this->base_model->getSelect("tbl_category",array(array("record"=>"name","value"=>$ca)));
    $pa = !empty($ids) ? $ids[0]->parent:0;
    $data['categorys'] = $this->base_model->getSelect("tbl_category",array(array("record"=>"parent","value"=>$pa)));
    $data['options'] = $this->base_model->getSelect("tbl_options",array(array("record"=>"product_id","value"=>$id)));
    $data['ch'] = $pa;
    $data['shop_category'] = $this->base_model->getSelect("tbl_shop_category",array(array("record"=>"use","value"=>1)),
                                                                              array(array("record"=>"order","value"=>"ASC")));
    $data['left_category'] = $this->base_model->getSelect("tbl_leftcategory", array( array("record"=>"use","value"=>1),
                                                                                array("record"=>"parent","value"=>0)),
                                                                          array(array("record"=>"order","value"=>"ASC")));

    $data['p_icons'] = $this->base_model->getSelect("tbl_proico",NULL,array(array("record"=>"order","value"=>"ASC")));
    $t_sel = $this->base_model->getSelectedCateogires($data['product'][0]->rid);
    if(!empty($t_sel))
    {
      $data['selected_name'] = $t_sel[0]->name;
      $data['selected_id'] = $t_sel[0]->id;
    }
    $this->loadViews("addshop",$this->global,$data,NULL);
  }

  public function deletesproduct(){
    $spid = $this->input->post("spid");
    $this->isLoggedIn();
    if(!empty($spid)):
      $this->base_model->deleteRecordCustom("tbl_sproducts","id",$spid);
      echo json_encode(array("status"=>true));
    endif;
    if(empty($spid)):
      echo json_encode(array("status"=>false));
    endif;
  }
  public function getCateogrys(){
      $option = "";
      $id= $this->input->get("CATE_SEQ");
      $category = $this->base_model->getSelect("tbl_category",
                                array(array("record"=>"parent","value"=>$id)),
                                array(array("record"=>"updated_date","value"=>"DESC")));
      foreach ($category as $key => $value) {
        $option.="<option value='".$value->id."' EnChar='".$value->en_subject."' CnChar='".$value->chn_subject."'>".$value->name."</option>";
      }
      echo $option;
    }
    public function registerImage(){
      if($_FILES['FILE_NM']['name'] !=""){
        $this->load->library('upload',$this->set_upload_options("../upload/delivery"));
            $this->upload->initialize($this->set_upload_options("../upload/delivery"));
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

  public function updateDeliver(){
    $id= $this->input->post("id");
    $aa= array();
    $vv = $this->base_model->getSelect("tbl_services");
    $theader = json_decode($this->input->post("theader")); /// products
    $pid = explode(",", $this->input->post("pid"));
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
              "logistics_request" =>$REQ_2);
    $this->base_model->updateDataById($id,$post_data,"delivery","id");
    $sds= $this->base_model->getSelect("tbl_service_delivery",array(array("record"=>"delivery_id","value"=>$id)));
    if(!empty($sds)) $this->base_model->updateDataById($id,array("content"=>json_encode($aa)),"tbl_service_delivery","delivery_id");
    else $this->base_model->insertArrayData("tbl_service_delivery",array("content"=>json_encode($aa),"delivery_id"=>$id));
    $this->base_model->insertPurchase($theader,$id,$delivery_content[0]->ordernum,$pid);
    redirect("/ShowDelivery?ORD_SEQ=".$id);
  }

  public function ActingPro_W(){
    $this->isLoggedIn();
    $data['tracking_headers'] = $this->base_model->getSelect("tracking_header");
    $sOrdSeq = $this->input->get("sOrdSeq");
    $category = $this->base_model->getSelect("tbl_category",array(array("record"=>"parent","value"=>0)));
    $data['pinfo'] = $this->base_model->getSelect("tbl_purchasedproduct",array(array("record"=>"id","value"=>$sOrdSeq)));
    if(sizeof($category) > 0 ){
      $chca = $data['pinfo'][0]->category;
      if(is_numeric($chca)){
        $pid = $this->base_model->getSelect("tbl_category",array(array("record"=>"id","value"=>$chca)))[0]->parent;
        if(is_numeric($pid)){
          $category_ch = $this->base_model->getSelect("tbl_category",array(array("record"=>"parent","value"=>$pid)));
        }
        else{
          $category_ch = $this->base_model->getSelect("tbl_category",array(array("record"=>"parent","value"=>$category[0]->id)));
        }
      }
      $data['category_ch'] = $category_ch;
      $data['pid'] = $pid;
      $data['categorys'] = $category;
    }
    $this->load->view("ActingPro_W",$data);
  }
  public function updateProduct(){
    $data = $this->input->post();
    $id = $data['id'];
    unset($data['id']);
    $this->base_model->updateDataById($id,$data,"tbl_purchasedproduct","id");
    echo "<script>window.close();</script>";
  }

  public function returnDeposit(){
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $shPageSize =  empty($this->input->get("shPageSize")) ? 10: $this->input->get("shPageSize");
    $state = $this->input->get("state");
    $type   = empty($_GET['type']) ?    NULL : $_GET['type'];
    $start_date = empty($_GET['start_date']) ?  NULL : $_GET['start_date'];
    $end_date   = empty($_GET['end_date']) ?    NULL : $_GET['end_date'];
    $content   = empty($_GET['content']) ?    NULL : $_GET['content'];
    $records_count = sizeof($this->base_model->getReturnDeposits(null,0,$start_date,$end_date,$state,$type,$content));
    $returns = $this->paginationCompress ( "returnDeposit/", $records_count, $shPageSize);
    $data['deposit'] = $this->base_model->getReturnDeposits($returns["page"],$returns["segment"],$start_date,$end_date,$state,$type,$content);
    $data["uc"] =$records_count;
    $data["pf"] = $returns["segment"];
    $this->loadViews("returnDeposit", $this->global, $data , NULL);
  }
  public function updateReturnDeposit(){
    $chkReqSeq =  $this->input->post("chkReqSeq");
    $sStat = $this->input->post("sStat");
    foreach ($chkReqSeq as $value) {
      $details = $this->base_model->getSelect("tbl_deposit_return",array(array("record"=>"id","value"=>$value)))[0];
      $userId = $details->userId;
      $amount = $details->amount;
      $security = date("ymd").generateRandomString(10);
      $pending = 0;
      if($sStat == 2){
       $this->base_model->plusValue("tbl_users","deposit",$amount,array(array("userId",$userId)),"+");
       $pending =2;
      }
      $this->base_model->updateDataById($value,array("updated"=>1,"accept"=>$sStat),"tbl_deposit_return","id");

      $this->base_model->insertArrayData("tbl_payhistory",array(  "userId"=>$userId,
                                                                  "payed_type"=>101,
                                                                  "amount"=>$amount,
                                                                  "security"=>$security,
                                                                  "pending"=>$pending));
      $this->base_model->insertArrayData("tbl_mail",array("fromId"=>1,
                                                          "toId"=>$userId,
                                                          "title"=>"예치금 환금신청확인",
                                                          "content"=>$sStat ==2 ? "예치금 환금 거절":"예치금 환금 승인",
                                                          "type"=>0));
    }
    redirect("returnDeposit");
  }

  public function Comment_W(){
    $this->load->helper('directory');
    $delivery_ids = $map = $comments = $ordernum = array();
    $sOrdSeq = $this->input->get("sOrdSeq");
    array_push($delivery_ids, $sOrdSeq);
    array_push($ordernum, $this->input->get("ordernum"));
    array_push($map, directory_map('../upload/silsa/'.$sOrdSeq, FALSE, TRUE));
    $current_comment = $this->base_model->getCommentAndMemo($sOrdSeq);
    $current_comment = !empty($current_comment) ? array($current_comment[0]->id,$current_comment[0]->use,$current_comment[0]->comment,$current_comment[0]->memo):array("","","","");
    array_push($comments, $current_comment);
    $olds = $this->base_model->getOldDelieryIds($sOrdSeq);
    if(!empty($olds)){
      foreach ($olds as $key => $value) {
        if(!empty($value->old_delivery_id))
        {
          array_push($delivery_ids, $value->old_delivery_id);
          array_push($ordernum, $value->ordernum);
          array_push($map, directory_map('../upload/silsa/'.$value->old_delivery_id, FALSE, TRUE));
          array_push($comments, array($value->cid,$value->cuse,$value->ccomment,$value->memo));
        }
      }
    }

    $data['map'] = $map;
    $data['comments'] = $comments;
    $data["delivery_id"] = $delivery_ids;
    $data["ordernum"] = $ordernum;
    $this->load->view("Comment_W",$data);
  }

  public function deliveryComment(){
    $data = $this->input->post();
    $delivery_id = $this->input->post("delivery_id");
    $id = $data['id'];
    unset($data['id']);
    if(!empty($id) && $id!=""){
      $this->base_model->updateDataById($id,$data,"tbl_delivery_comment","id");
      $return = $id;
    }
    else{
      $return = $this->base_model->insertArrayData("tbl_delivery_comment",$data);
    }
    if($return > 0){
      if(!file_exists("../upload/silsa/".$delivery_id))  mkdir("../upload/silsa/".$delivery_id, 0777);
      $this->load->library('upload',$this->set_upload_options("../upload/silsa/".$delivery_id));
      $this->upload->initialize($this->set_upload_options("../upload/silsa/".$delivery_id));
       $count = count($_FILES['image']['name']);
       for($i=0;$i<$count;$i++){
          if(!empty($_FILES['image']['name'][$i])){
            $_FILES['file']['name'] = $_FILES['image']['name'][$i];
            $_FILES['file']['type'] = $_FILES['image']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'][$i];
            $_FILES['file']['error'] = $_FILES['image']['error'][$i];
            $_FILES['file']['size'] = $_FILES['image']['size'][$i];
            $this->upload->do_upload('file');
          }
       }
    }
    echo '<script>self.close();</script>';
  }

  public function verifyDeposit(){
    $security = $this->input->post("security");
    $userId = $this->input->post("userId");
    $history = $this->base_model->getpayHistyBySecurity($security,1);
    $this->base_model->updateDataById($security,array("pending"=>0),"tbl_payhistory","security");
    foreach($history as $value) {
      if($value->type ==4){
        $this->base_model->updateDataById($value->delivery_id,array("add_check"=>0),"tbl_add_price","id");
      }
      else{
        $ins = array();
        if($value->type == 1) {$state = 15;$p="payed_send";$ins = array("state"=>$state,$p=>1,"pays"=>0);}
        if($value->type == 2) {$state = 6;$p="payed_checked";$ins = array("state"=>$state,$p=>1,"pays"=>0);}
        if($value->type == 3) {$state = 21;$p="return_check";$ins = array("state"=>$state,$p=>1,"pays"=>0);}
        if($value->type == 7)
        {
          $state = 6;$ins = array("state"=>$state,"payed_send"=>1,"payed_checked"=>1,"pays"=>0);
        }
        $this->base_model->updateDataById($value->delivery_id,$ins,"delivery","id");
      }
    }

    echo "true";
    return;
  }

  public function cancelDeposit(){
    $security = $this->input->post("security");
    $type = $this->input->post("type");
    $this->base_model->updateDataById($security,array("pending"=>2),"tbl_payhistory","security");
    $history = $this->base_model->getpayHistyBySecurity($security,1);
    if($type ==4) $pending=2;
    else $pending =1;
    if(!empty($history)){
      foreach($history as $value) {
        if(!empty($value->coupon_type)){
          $coupon_type = json_decode($value->coupon_type);
          if(!empty($coupon_type) && sizeof($coupon_type) > 0)
              foreach($coupon_type as $val_coupon){
                $temp = explode("|", $val_coupon);
                if(sizeof($temp) > 1)
                  $this->base_model->updateDataById($temp[1],array("used"=>0),"tbl_coupon_user","code");
            }
        }

        if($value->amount > 0)
        {
          $security = date("ymd").generateRandomString(10);
          $this->base_model->plusValue("tbl_users","deposit",$value->amount,array(array("userId",$value->userId)),"+");
          $this->base_model->insertArrayData("tbl_payhistory",array(
                              "all_amount"=>$value->amount,
                              "payed_date"=>date("Y-m-d H:i"),
                              "amount"=>$value->amount,
                              "payed_type"=>120,
                              "userId"=>$value->userId,
                              "pending"=>0,
                              "pamount"=>0,
                              "security"=>$security,
                              "by"=>1));
        }

        if($value->type!=4) {
          if($value->type ==1) $ss=array("state"=>40,"payed_send"=>0,"pays"=>0);
          if($value->type ==2){

            $ss=array("state"=>4,"payed_checked"=>0,"pays"=>0,"purchase_price" => 0);
            $temp = explode("|", $value->pur_fee);
            if(!empty($value->pur_fee) && !empty($temp[1]))
            {
              $temp[1] = 0;
              $ss["pur_fee"] = implode("|", $temp);
            }
          }
          if($value->type ==3) $ss=array("state"=>19,"return_check"=>0,"pays"=>0);
          if($value->type ==7) $ss=array("state"=>4,"payed_checked"=>0,"payed_send"=>0,"pays"=>0);
          $this->base_model->updateDataById($value->delivery_id,$ss,"delivery","id");
        }
        else
        {
          $this->base_model->updateDataById($value->delivery_id,array("add_check"=>3),"tbl_add_price","id");
          $this->base_model->updateDataById($value->delivery_id,array("pays"=>0),"delivery","id");
        }
      }
    }
    echo "true";
    return;
  }

  public function getDeliveryBySecurity(){
    $security = $this->input->post("security");
    $history = $this->base_model->getpayHistyBySecurity($security,1);
    $ordernum = array();
    foreach ($history as $key => $value) {
      array_push($ordernum,$value->ordernum);
    }
    echo implode(',', $ordernum);
  }

  public function sendMail(){
    $userId = $this->input->get("userid");
    $user = $this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$userId)));
    if(sizeof($user) ==0 ) return;
    $data['user'] = $user[0];
    $this->load->view("sendMail",$data);

  }

  function PopNote_I(){
    $this->base_model->insertArrayData("tbl_mail",array("toId"=>$this->input->post("chkMemCode"),
                                            "fromId"=>1,
                                            "title"=>$this->input->post("sTit"),
                                            "content"=>$this->input->post("description",false),
                                            "type"=>0,
                                            "view"=>0,
                                            "updated_date"=>date("Y-m-d H:i:s")));
    echo "<script>alert('발송되였습니다');self.close();</script>";
  }

  function deposithistory(){
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $data['member'] = array();
    if(!empty($this->input->get("type"))){
      $data['member'] = $this->base_model->getMemberByType($this->input->get("type"),$this->input->get("content"));
    }
    $data['types'] = $this->base_model->getAll("tbl_coupon_type");
    $shPageSize =  empty($this->input->get("shPageSize")) ? 10: $this->input->get("shPageSize");
    $state = empty($_GET['state']) ?  NULL : $_GET['state'];
    $mem   = empty($_GET['mem']) ?    NULL : $_GET['mem'];
    $seach_input   = empty($_GET['seach_input']) ?    NULL : $_GET['seach_input'];
    $starts_date  = empty($_GET['starts_date']) ?   NULL : $_GET['starts_date'];
    $ends_date    = empty($_GET['ends_date']) ?     NULL : $_GET['ends_date'];
    $records_count = sizeof($this->base_model->getDeposites(null,0,$starts_date,$ends_date,$state,$mem,$seach_input));
    $returns = $this->paginationCompress ( "deposithistory/", $records_count, $shPageSize);
    $data['deposites'] = $this->base_model->getDeposites($returns["page"],$returns["segment"],$starts_date,$ends_date,$state,$mem,$seach_input);
    $data['csc'] = $records_count;
    $data['seg'] = $returns["segment"];
    $this->loadViews("deposithistory",$this->global,$data,NULL);
  }

  function saveDeposit(){
    $type  = 16;
    if($this->input->post("gold_type") =="-")
      $type= 17;
    $chkMemCode = explode(",", $this->input->post("chkMemCode"));
    foreach ($chkMemCode as $key => $value)
      $this->base_model->plusValue("tbl_users","deposit",$this->input->post("gold"),array(array("userId",$value)),$this->input->post("gold_type"));
      $security = date("ymd").generateRandomString(10);

      $this->base_model->insertArrayData("tbl_payhistory",array(  "delivery_id"=>$value,
                            "all_amount"=>$this->input->post("gold"),
                            "payed_date"=>date("Y-m-d H:i"),
                            "payed_type"=>$type,
                            "type"=>$type,
                            "amount"=>$this->input->post("gold"),
                            "userId"=>$value,
                            "pending"=>0,
                            "pamount"=>0,
                            "security"=>$security,
                            "by"=>1));
    redirect("deposithistory");
  }

  function DpstUseDet_M(){
    $DPST_USE_SEQ = $this->input->post("DPST_USE_SEQ");
    $sKind = $this->input->post("sKind");
    $deposit = $this->base_model->getSelect("tbl_payhistory",array(array("record"=>"id","value"=>$DPST_USE_SEQ)));
    $mul="";
    if(sizeof($deposit) > 0):
      if($sKind =='D'):
        $this->base_model->deleteRecordCustom("tbl_payhistory","security",$deposit[0]->security);
        echo 102;
      endif;
      if($sKind !="D"):
        $amount = $deposit[0]->amount;
        if($amount ==0 ) {echo '101';return;}
        $userId = $deposit[0]->userId;
        if($deposit[0]->payed_type==102):
          if($sKind ==1):$mul="+";endif;
          if($sKind ==2):$mul="-";endif;
        endif;
        if($deposit[0]->payed_type==101 || $deposit[0]->payed_type==4 || $deposit[0]->payed_type==5):
          if($sKind ==1):
            $mul="-";
          endif;
          if($sKind ==2):
            $mul="+";
          endif;
        endif;
        $this->base_model->plusValue("tbl_users","deposit",$amount,array(array("userId",$userId)),$mul);
        $this->base_model->updateDataById($DPST_USE_SEQ,array("tt"=>$sKind),"tbl_payhistory","id");
        echo "100";
      endif;
    endif;
  }
  public function Box_Cnt_M(){
    if(!empty($this->input->post("sOrdSeq"))):
      $this->base_model->updateDataById($this->input->post("sOrdSeq"),array("backs"=>$this->input->post("state")),"delivery","id");
      echo 100;
      return;
    endif;
    echo 101;
  }

  public function getDelivery(){
    $delivery_id = $this->input->post("delivery_id");
    $content = $this->base_model->getDeliverContent(10,0,$delivery_id);
    $aa = array();
    $fee = $this->base_model->getSelect("tbl_services");
    $ff = array();
    $ar = array();
    foreach($fee as $v){
      $ff[$v->id] = $v->name;
    }
    $str = "";
    $weight = "";
    if(sizeof($content) > 0){
      foreach ($content as $key => $value) {
        if($value->addid ==3)
          $weight = "CBM";
        else $weight = "kg";
        $str.='<div class="box-body table-responsive no-padding">';
        $str.='<table class="table table-hover">';
        if($value->sending_price > 0):
          $send_label = "";
          if($value->payed_send==0) $send_label = "(미입금)";
          if($value->payed_send==1) $send_label = "(입금)";
          if(!empty($value->content))
          {
            $ar = json_decode($value->content,true);
          }
          if($value->real_weight > 0):
            $num = floor($value->real_weight);
            $num1 = $value->real_weight-$num;
            if($num1 > 0   &&$num1 < 0.5)  $num = $num + 0.5;
            if($num1 > 0.5 && $num1 < 1  )  $num = $num + 1;
            $str.='<tr>
                <th class="breaken"><span class="bold red1">총 배송비용'.$send_label.'</span></th>
                <td class="tBg"></td>
                <td class="tBg"><span class="bold text-danger">'.number_format(str_replace(",","",$value->sending_price)).'원</span></td>
              </tr>';
            $str.='<tr>
                <th class="breaken"><span class="bold">&nbsp;&nbsp;-실측무게</span></th>
                <td class="ct" style="text-align:left;"></td>
                <td><span class="bold">'.$value->real_weight.$weight.'</span></td>
              </tr>';
          endif;
          if($value->vlm_wt > 0):
            $str.='<tr>
                <th class="breaken"><span class="bold red1">적용무게</span></th>
                <td class="ct red1" style="text-align:left;"></td>
                <td><span class="bold">'.$value->vlm_wt.'kg</span></td>
              </tr>';
          endif;
         if(!empty($ar)):
          foreach($ar as $key_ar=>$ar_ch):

            if(!isset($ff[$key_ar])) continue;
            $str.='<tr>
                <th class="breaken">&nbsp;&nbsp;-'.$ff[$key_ar].'</th>
                <td></td>
                <td>
                '.number_format($ar_ch).'원
                </td>
              </tr>';
          endforeach;
          endif;
          $str.='<tr>
                <th class="breaken">&nbsp;&nbsp;-배송비</th>
                <td></td>
                <td>
                '.number_format($value->sends).'원
                </td>
              </tr>';
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
        if($value->purchase_price>0):
          $pur_label = "";
          if($value->payed_checked==0) $pur_label = "(미입금)";
          if($value->payed_checked==1) $pur_label = "(입금)";
          $pur_split = explode("|",$value->pur_fee);
          $pur_1 =$pur_split[1];
          $pur_2 = $pur_split[2];
          $pur_0 = $pur_split[0];
          $str.='<tr>
              <th class="breaken"><span class="bold red1">구매비용'.$pur_label.'</span></th>
              <td class="ct red1" style="text-align:left;"></td>
              <td><span class="bold text-danger">'.number_format(str_replace(",", "", $value->purchase_price)).'원</span></td>
            </tr>';
            $str.='<tr>
                <th class="breaken">&nbsp;&nbsp;-구매비</th>
                <td></td>
                <td>
                '.number_format($pur_1).'원
                </td>
              </tr>';
            $str.='<tr>
                <th class="breaken">&nbsp;&nbsp;-구매수수료</th>
                <td></td>
                <td>
                '.number_format(($pur_1+$value->cur_send*$pur_2)*$pur_0/100).'원
                </td>
              </tr>';
          if($value->cur_send > 0 ):
            $str.='<tr>
                <th class="breaken">&nbsp;&nbsp;-현지배송비</th>
                <td></td>
                <td>
                '.number_format($value->cur_send*$pur_2).'원
                </td>
              </tr>';
          endif;
        endif;
        if($value->add_price > 0):
          if($value->add_check == 1 ) $add_label = "미입금";
          else $add_label = "입금";
          $str.='<tr>
                <th class="breaken">추가결제금액('.$add_label.')</th>
                <td></td>
                <td class="bold text-danger">
                '.number_format($value->add_price).'원
                </td>
              </tr>';
          if($value->agwan > 0 ):
            $str.='<tr>
                <th class="breaken">관부가세</th>
                <td></td>
                <td>
                '.number_format($value->agwan).'원
                </td>
              </tr>';
          endif;
          if($value->apegi > 0 ):
            $str.='<tr>
                <th class="breaken">페기수수료</th>
                <td></td>
                <td>
                '.number_format($value->apegi).'원
                </td>
              </tr>';
          endif;
          if($value->acart_bunhal > 0 ):
            $str.='<tr>
                <th class="breaken">카툰분할 수 신고/BL 분할</th>
                <td></td>
                <td>
                '.number_format($value->acart_bunhal).'원
                </td>
              </tr>';
          endif;
          if($value->acheck_custom > 0 ):
            $str.='<tr>
                <th class="breaken">검역수수료</th>
                <td></td>
                <td>
                '.number_format($value->acheck_custom).'원
                </td>
              </tr>';
          endif;
          if($value->agwatae > 0 ):
            $str.='<tr>
                <th class="breaken">과태료</th>
                <td></td>
                <td>
                '.number_format($value->agwatae).'원
                </td>
              </tr>';
          endif;
          if($value->v_weight > 0 ):
            $str.='<tr>
                <th class="breaken">부피무게</th>
                <td></td>
                <td>
                '.number_format($value->v_weight).'원
                </td>
              </tr>';
          endif;
          if($value->add_fee > 0 ):
            $str.='<tr>
                <th class="breaken">기타 추가비용</th>
                <td></td>
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

  public function editBoard($id){
    $data['board'] = $this->base_model->getReqById($id);
    $this->loadViews("editBoard",$this->global,$data,NULL);
  }

  public function deleteBoard(){
    $id = $this->input->post("id");
    if(!empty($id))
    {
      $this->base_model->deleteRecordCustom("tbl_board","id",$id);
      echo 100;
      return;
    }
    else echo 101;
  }

  public function updateBoard(){
    $data = $this->input->post();
    $data["content"] = $this->input->post("content",false);
    $board_type = $data["board_type"];
    unset($data["board_type"]);
    $id = $data['id'];
    unset($data['id']);
    unset($data['sKind']);
    unset($data['sFL_SEQ']);
    $data['letter_l'] = !empty($this->input->post("letter_l")) ? $this->input->post("letter_l"):0;
    $len = $this->input->post("len");
    unset($data['len']);
    $updated_id=$this->base_model->updateDataById($id,$data,"tbl_mail","id");
    if (!file_exists("../upload/mail/".$id))
      mkdir("../upload/mail/".$id, 0777);
    $this->load->library('upload',$this->set_upload_options("../upload/mail/".$id,$len*1024,false));
    $this->upload->initialize($this->set_upload_options("../upload/mail/".$id,$len*1024,false));
    if(!empty($_FILES['file1']['name']) && $_FILES['file1']['name'] !=""){
      if ( ! $this->upload->do_upload('file1'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($id,array("file1"=>$img_data["file_name"]),"tbl_mail","id");
      }
    }
    if(!empty($_FILES['file2']['name']) && $_FILES['file2']['name'] !=""){
      if ( ! $this->upload->do_upload('file2'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($id,array("file2"=>$img_data["file_name"]),"tbl_mail","id");
      }
    }
    if(!empty($_FILES['file3']['name']) && $_FILES['file3']['name'] !=""){
      if ( ! $this->upload->do_upload('file3'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($id,array("file3"=>$img_data["file_name"]),"tbl_mail","id");
      }
    }
    redirect("viewReq/".$id."?board_type=".$board_type);
  }

  public function deleteF(){
    echo delteFile($this->input->post("url"));
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

  public function Acting_D(){
    $sOrdSeq = $this->input->get("sOrdSeq");
    $state = $this->input->get("state");
    $previous = 11;
    if(empty($sOrdSeq)) return;
    $del = $this->base_model->getPayHistory(10,0,1,null,null,null,null,null,null,null,$sOrdSeq);
    if(!empty($del)) {
      echo "<script>
              alert('이 주문은 회원결제단계에 있습니다.결제주문페지에서 확인해주세요.');
              window.history.back();
            </script>";
    }
    if($state == 14 )
    {
        $this->base_model->updateDataById($sOrdSeq,array("payed_send"=>0,"sending_price"=>0,"state"=>11),"delivery","id");
    }
    else{
        $ss=array("state"=>4,"payed_checked"=>0,"pays"=>0,"purchase_price" => 0);
        $value = $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$sOrdSeq)));
        if(!empty($value[0]->pur_fee)){
            $temp = explode("|", $value[0]->pur_fee);
            if(!empty($temp[1]))
            {
                $temp[1] = 0;
                $ss["pur_fee"] = implode("|", $temp);
            }
            $this->base_model->updateDataById($sOrdSeq,$ss,"delivery","id");
        }

        $previous = 4;
    }
    echo "<script>
              window.location.href='/admin/dashboard?step=".$previous."';
            </script>";
  }

  public function ActingAdrs_W(){
    $sOrdSeq = $this->input->get("sOrdSeq");
    $data['delivery'] = $this->base_model->getSelect("delivery",array(array("record"=>"id","value"=>$sOrdSeq)));
    if(empty($data['delivery'])) { echo '해당 주문이 존재하지 않습니다.'; return;}
    $this->load->view("ActingAdrs_W",$data);
  }

  public function ActingAdrs_M(){
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
    $ORD_SEQ = $this->input->post('ORD_SEQ');
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
   $this->base_model->updateDataById($ORD_SEQ,$post_data,"delivery","id");
   echo "<script>self.close();opener.selfRedirect();</script>";
  }

  public function User_MemAddr_S(){
    $sMemCode = $this->input->get("sMemCode");
    $contacts = $this->base_model->getSelect("tbl_mycontact",array(array("record"=>"userId","value"=>$sMemCode)));
    $data['contacts'] = $contacts;
    $this->load->view("User_MemAddr_S",$data);
  }
  public function Acting_Del(){
    $sOrdSeq = $this->input->post("chkORD_SEQ");
    if(empty($sOrdSeq)) {echo "<script>alert('선택된 주문이 없습니다.');window.history.back();</script>";return;}
    foreach ($sOrdSeq as $key => $value){
      $this->base_model->deleteRecordCustom("delivery","id",$value);
      $this->base_model->deleteRecordCustom("tbl_add_price","id",$value);
      $this->base_model->deleteRecordCustom("tbl_payhistory","delivery_id",$value);
      $this->base_model->deleteRecordCustom("tbl_purchasedproduct","delivery_id",$value);
    }
    echo "<script>alert('변경되였습니다.');window.history.back();</script>";
  }

  public function getOT(){
    $sOrdSeq = $this->input->get("sOrdSeq");
    $type = $this->input->get("type");
    $data = "";
    $del = $this->base_model->getExtD($sOrdSeq,$type);
    if($type =="trackingNumber"):
    if(!empty($del)):
      foreach($del as $value):
        $data.="<p>";
        // $data.=$value->order_number." : ";
        $data.=$value->header;
        $data.=" : ";
        $data.=$value->data;
        $data.=" ".date("Y-m-d H:i",strtotime($value->tracking_time));
        $data.="</p>";
      endforeach;
    endif;
    endif;
    if($type =="order_number"):
      if(!empty($del)):
        foreach($del as $value):
          $data.="<p>";
          $data.=$value->ord." : ";
          $data.=$value->data;
          $data.="</p>";
        endforeach;
      endif;
    endif;
    echo $data;
  }

  public function trackPaper(){
    $data['delivery'] = $this->base_model->getDeliverContent(10,0,$this->input->get("sOrdSeq"));
    $data['company']=   $this->base_model->getSelect("tbl_company");
    $this->load->view("trackPaper",$data);
  }

  public function ActingExcel_W(){
    $this->load->view("ActingExcel_W",NULL);
  }

  public function Bbs_SetUp_W(){
    $data['role'] = $this->base_model->getSelect("tbl_roles");
    $this->loadViews("Bbs_SetUp_W",$this->global,$data,NULL);
  }

  public function addBoard(){
    $id = $this->input->post("id");
    $data = $this->input->post();
    unset($data['id']);
    if($id ==0 )
    {
      $data['iden'] = generateRandomString(5);
      $d = $this->base_model->insertArrayData("tbl_board",$data);
    }
    if($id > 0 )
      {
        $this->base_model->updateDataById($id,$data,"tbl_board","id");
      }

    redirect("board_settings");
  }
  public function board_settings(){
    $data['board'] = $this->base_model->getSelect("tbl_board",null,array(array("record"=>"grade","value"=>"ASC")));
    $this->loadViews("board_settings",$this->global,$data,NULL);
  }
  public function editboards($id){
    $data['role'] = $this->base_model->getSelect("tbl_roles");
    $data['board'] = $this->base_model->getSelect("tbl_board",array(array("record"=>"id","value"=>$id)));
    $this->loadViews("Bbs_SetUp_W",$this->global,$data,NULL);
  }

  public function panel(){
    $id = $_GET['id'];
    $data['panel'] = $this->base_model->getSelect("tbl_board",array(array("record"=>"id","value"=>$id)));
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $category = !empty($this->input->get("category")) ? $this->input->get("category"):"";
    $mode = !empty($this->input->get("mode")) ? $this->input->get("mode"):"";
    $shCol = !empty($this->input->get("shCol")) ? $this->input->get("shCol"):"";
    $seach_input = !empty($this->input->get("seach_input")) ? $this->input->get("seach_input"):"";
    $records_count = sizeof($this->base_model->getReq($id,100000,0,$category,$shCol,$seach_input,$mode));
    $returns = $this->paginationCompress ( "/panel", $records_count, 20);
    $data['content'] = $this->base_model->getReq($id,$returns['page'],$returns['segment'],$category,$shCol,$seach_input,$mode);
    $data["uc"] =$records_count;
    $data["pf"] = $returns["segment"];
    $this->loadViews("mailView",$this->global,$data,NULL);
  }

  public function actionUsers(){
    $sKind = $this->input->post("sKind");
    $chkMemCode = $this->input->post("chkMemCode");
    if($sKind =="E"){
      foreach($chkMemCode as $value){
        $this->base_model->deleteRecordCustom("tbl_users","userId",$value);
      }
      redirect("exitMember");
    }
    if($sKind =="C"){
      foreach($chkMemCode as $value){
        $this->base_model->updateDataById($value,array("isDeleted"=>0),"tbl_users","userId");
      }
      redirect("exitMember");
    }
    if($sKind =="A"){
      $this->load->library('PHPExcel');
      $fileName = 'Exited User data-'.time().'.xlsx';
      $objPHPExcel = new PHPExcel();
      $objPHPExcel->setActiveSheetIndex(0);
      $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'userId');
      $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Email');
      $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Name');
      $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Mobile');
      $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'NickName');
      $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'loginId');
      $rowCount = 2;
      foreach ($chkMemCode as $key => $value) {
        $user = $this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$value)));
        if(!empty($user))
        {
          $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $user[0]->userId);
          $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $user[0]->email);
          $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $user[0]->name);
          $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $user[0]->mobile);
          $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $user[0]->nickname);
          $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $user[0]->loginId);
        }
      }
      $filename = "ExitedUsers_". date("Y-m-d-H-i-s").".csv";
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      header('Cache-Control: max-age=0');
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
      $objWriter->save('php://output');
    }
  }

  public function registered_mail(){
    $data['mail'] = $this->base_model->getSelect("tbl_registed_message");
    $this->loadViews("registered_mail",$this->global,$data,NULL);
  }

  public function addRegisteredMail(){
    $data= $this->input->post();
    $data["content"] = $this->input->post("content",false);
    $this->base_model->updateDataById(1,$data,"tbl_registed_message","id");
    redirect("registered_mail");
  }

  public function pages(){
    $data['pages'] = $this->base_model->getSelect("banner", array(array("record"=>"type","value"=>3)),
                                                            array(array("record"=>"order","value"=>"ASC")));
    $this->loadViews("pages",$this->global,$data,NULL);
  }

  public function pages_edit($id){
    $this->load->helper('directory');

    $data['pages'] = $this->base_model->getSelect("banner",array(array("record"=>"type","value"=>3)));
    $data['content'] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>$id)));
    $data['map']= directory_map('../upload/banner/'.$id, FALSE, TRUE);
    $this->loadViews("pages",$this->global,$data,NULL);
  }

  public function addPage(){
    $data = $this->input->post();
    $data["content"] = $this->input->post("content",false);
    $data['header'] = (!isset($data['header']) || $data['header']=="")? 0: $data['header'];
    $data['my'] = (!isset($data['my']) || $data['my']=="") ? 0: $data['my'];
    $data['footer'] = (!isset($data['footer']) || $data['footer']=="") ? 0: $data['footer'];
    $id = $data['id'];
    if(!empty($id) && $id > 0)
    {
      unset($data['id']);
      $this->base_model->updateDataById($id,$data,"banner","id");
      $return = $id;
    }
    else{
      $data['type']=3;
      $return = $this->base_model->insertArrayData("banner",$data);
    }

   redirect("pages_edit/".$return);
  }

  public function NtDet_W(){
    $users = "";
    if(!empty($this->input->get("chkMemCode"))):
      $d = explode(",", $this->input->get("chkMemCode"));
      foreach ($d as $key => $value) {
        if(!empty($this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$value)))))
          $users.=$this->base_model->getSelect("tbl_users",array(array("record"=>"userId","value"=>$value)))[0]->name.",";
      }
    endif;
    $data['users'] = $users;
    $data['role'] = $this->base_model->getSelect("tbl_roles",array(array("record"=>"roleId!=","value"=>1),array("record"=>"roleId!=","value"=>2)));
    $this->load->view("NtDet_W",$data);
  }

  public function multisend(){
    $receman = $this->input->post("receman");
    $title = $this->input->post("title");
    $content  =$this->input->post("content");
    $ids = $this->input->post("ids");
    if(empty($ids)){
      if($receman ==0)
        $users = $this->base_model->getSelect("tbl_users",array(array("record"=>"isDeleted","value"=>0)));
      if($receman > 0 )
        $users = $this->base_model->getSelect("tbl_users",array(array("record"=>"isDeleted","value"=>0),array("record"=>"roleId","value"=>$receman)));
      foreach($users as $value)
        $this->base_model->insertArrayData("tbl_mail",array( "type"=>0,
                                                              "content"=>$content,
                                                              "title"=>$title,
                                                              "fromId"=>1,
                                                              "toId"=>$value->userId));
    }
    else{
      $ids = explode(",", $ids);
      foreach ($ids as $key => $value) {
        $this->base_model->insertArrayData("tbl_mail",array( "type"=>0,
                                                              "content"=>$content,
                                                              "title"=>$title,
                                                              "fromId"=>1,
                                                              "toId"=>$value));
      }
    }
    echo "<script>window.close();</script>";
  }

  public function NtDet_D(){
    $chkNtSeq = $this->input->post("chkNtSeq");
    foreach($chkNtSeq as $value)
    {
      $this->base_model->deleteRecordCustom("tbl_mail","id",$value);
    }
    redirect("mail");
  }
  public function IdChk(){
    $this->isLoggedIn();
    $loginId = sizeof($this->base_model->getSelect("tbl_users",array(array("record"=>"loginId","value"=>$this->input->get("sMemId")))));
    if($loginId == 0) echo '0';
    else echo '1';
  }

  public function Mem_U(){
    $sKind = $this->input->post("sKind");
    $chkMemCode = $this->input->post("chkMemCode");
    $sMemLvlChk =  $this->input->post("level");
    if($sKind =="U"){
      session_start();
      $my_session_id = session_id();
      session_write_close();
      $this->base_model->updateDataById($chkMemCode,array("roleId"=>$sMemLvlChk),"tbl_users","userId");
    }
    if($sKind =="D"){
      foreach($chkMemCode as $value){

        $this->base_model->updateDataById($value,array("isDeleted"=>1),"tbl_users","userId");
      }
    }

    redirect("userListing");
  }

  public function Mem_X(){
    $this->load->library('PHPExcel');
    $fileName = 'Exited User data-'.time().'.xlsx';
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'userId');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Email');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Mobile');
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'NickName');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'loginId');
    $rowCount = 2;
    $user = $this->base_model->getSelect("tbl_users",array(array("record"=>"isDeleted","value"=>0)));
    foreach ($user as $key => $value) {
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->userId);
      $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->email);
      $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value->name);
      $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value->mobile);
      $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->nickname);
      $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value->loginId);
      $rowCount++;
    }
    $filename = "Users_". date("Y-m-d-H-i-s").".csv";
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
    $objWriter->save('php://output');
  }

  public function bbs_fl_D(){
    $sFL_SEQ = $this->input->post("sFL_SEQ");
    $id = $this->input->post("id");
    $file_name = "";
    $re = "file".$sFL_SEQ;
    $record = $this->base_model->getSelect("tbl_mail",array(array("record"=>"id","value"=>$id)));
    if(!empty($record)){
      $file_name = $record[0]->$re;
      if(!empty($file_name)){
        delteFile($_SERVER['DOCUMENT_ROOT']."/upload/mail/".$id."/".$file_name);
        $this->base_model->updateDataById($id,array($re=>""),"tbl_mail","id");
      }
    }
    redirect("editBoard/".$id);
  }

  public function editmemberL($id){
    $data['role'] = $this->base_model->getSelect("tbl_roles",array(array("record"=>"roleId","value"=>$id)));
     $data['deliveryAddress'] = $this->base_model->getSelect("delivery_address",array(array("record"=>"use","value"=>1)));
    if(empty($data['role']))
      return;
    $this->loadViews("editmemberL",$this->global,$data,NULL);
  }

  public function seporders(){
    $data = $this->input->post("cat");
    $data = json_decode($data);
    if($data ==null || sizeof($data) ==0) { echo 0;return;}
    foreach($data as $key=>$value){
      $this->base_model->updateDataById($value,array("orders"=>$key+1),"tbl_category","id");
    }
    echo 1;
  }

  public function Mem_Grade_S(){
    $data['levels'] = $this->base_model->getSelect("tbl_roles",array(  array("record"=>"roleId !=","value"=>1),
                                                                      array("record"=>"roleId !=","value"=>2),
                                                                      array("record"=>"use","value"=>1)));
    $data['members'] = $this->base_model->getUpgradedLevel();
    $this->loadViews("Mem_Grade_S",$this->global,$data,NULL);
  }

  public function getCommentMore(){
    $id = $this->input->post("id");
    $comment_id = $this->input->post("comment_id");
    echo json_encode($this->base_model->getCommentsByPostId(5,$comment_id,$id));
  }

  public function deleteComment(){
    $this->base_model->deleteRecordCustom("tbl_comment","id",$this->input->post("id"));
    echo 1;
  }

  public function ActingExcel_I(){
    $this->load->library('PHPExcel');
    $data = array();
    $this->load->library('upload',$this->set_upload_options("../upload/excel",30000,false));
    $this->upload->initialize($this->set_upload_options("../upload/excel",30000,false));
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
        $temp_id=0;
        foreach($allDataInSheet as $key=>$value)
        {
          $id   = $value['A'];
          $des  = $value['B'];
          if($id=="" || $des==""){
            continue;
          }
          $this->base_model->updateDataById($id,array("tracking_number"=>$des),"delivery","ordernum");
        }
      }
    }
    echo "<script>window.close();</script>";
  }
   public function downloadI(){
    $this->load->helper('download');
    $sFL_SEQ = $this->input->post("sFL_SEQ");
    $id  = $this->input->post("id");
    $re= $this->base_model->getSelect("tbl_mail",array(array("record"=>"id","value"=>$id)));
    $record = "file".$sFL_SEQ;
    if(!empty($re)){
      $file_name = $re[0]->$record;
      if(!empty($file_name)){
      force_download("../upload/mail/".$id."/".$file_name,NULL);
      }
    }
  }

  public function changeLevel(){
    var_dump($this->base_model->getWillLevel());
  }

  public function addOption(){
    $data = $this->input->post();
    if(!empty($data['product_id']) && $data['product_id'] > 0){
      $this->base_model->insertArrayData("tbl_options",$data);
      echo 1;
    }
  }
  public function editOption(){
    $data = $this->input->post();
    if(!empty($data['id']) && $data['id'] > 0){
      $id = $data['id'];
      unset($data['id']);
      $this->base_model->updateDataById($id,$data,"tbl_options","id");
      echo 1;
      return;
    }
    echo 0;
  }

  public function addItem(){
    $data = $this->input->post();
    if(!empty($data['id']) && $data['id'] > 0){
      $id = $data['id'];
      unset($data['id']);
      $result = $this->base_model->getSelect("tbl_options",array(array("record"=>"id","value"=>$id)));
      if(empty($result)) {echo 0;return;}
      $data["key"] = $result[0]->key.$data["key"]."|";
      $this->base_model->updateDataById($id,$data,"tbl_options","id");
      echo 1;
      return;
    }
    echo 0;
  }

  public function deleteOption(){
    $data = $this->input->post();
    $id = $data["id"];
    if($id > 0 ){
      $this->base_model->deleteRecordCustom("tbl_options","id",$id);
      echo 1;
      return;
    }
    echo 0;
  }

  public function updateItem(){
    $data= $this->input->post();
    $id = $data['id'];
    if(empty($id)) {echo 0;return;}
    unset($data["id"]);
    $this->base_model->updateDataById($id,$data,"tbl_options","id");
    echo 1;
  }

  public function deleteAcc(){
    $data = $this->input->post();
    $id = $data["id"];
    if($id > 0 ){
      $this->base_model->deleteRecordCustom("tbl_accurrate","id",$id);
      echo 1;
      return;
    }
    echo 0;
  }

  public function setting_point(){
    $data['s'] = $this->base_model->getSelect("tbl_shipping_fee");
    $this->loadViews("setting_point",$this->global,$data,NULL);
  }

  public function savepointRegister(){
    $this->base_model->updateDataById("1",$this->input->post(),"tbl_shipping_fee","id");
    redirect("setting_point");
  }

  public function add_points(){
    $data["p"] = $this->base_model->getSelect("tbl_point",array(array("record"=>"type","value"=>1)));
    $data["p1"] = $this->base_model->getSelect("tbl_point",array(array("record"=>"type","value"=>2)));
    $data["p2"] = $this->base_model->getSelect("tbl_point",array(array("record"=>"type","value"=>3)));
    $this->loadViews("add_points",$this->global,$data,NULL);
  }

  public function savePointByRegister(){
    $data = $this->input->post();
    if($data["type"]==1)
      $p = $this->base_model->getSelect("tbl_point",array(array("record"=>"type","value"=>1)));
    if($data["type"]==2)
      $p = $this->base_model->getSelect("tbl_point",array(array("record"=>"from_gold","value"=>$data["from_gold"])));
    $data["terms"] = $data["from_s"]."|".$data["end_s"];
    unset($data["from_s"]);
    unset($data["end_s"]);
    if(!empty($p)){
      if($data["type"]==2){
        $from_gold = $data["from_gold"];
        unset($data["from_gold"]);
        $this->base_model->updateDataById($from_gold,$data,"tbl_point","from_gold");
      }
      if($data["type"]==1){
        $type = $data["type"];
        unset($data["type"]);
        $this->base_model->updateDataById($type,$data,"tbl_point","type");
      }
    }
    else{
      $this->base_model->insertArrayData("tbl_point",$data);
    }
    redirect("add_points");
  }

  public function deletePointR(){
    $id = $this->input->post("id");
    $this->base_model->deleteRecordCustom("tbl_point","id",$id);
    echo 1;
  }

  public function eventPoint(){
    $data["p"] = $this->base_model->getSelect("tbl_point",array(array("record"=>"type","value"=>'1')));
    $data["p1"] = $this->base_model->getSelect("tbl_point",array(array("record"=>"type","value"=>'2')));
    $data["p2"] = $this->base_model->getSelect("tbl_point",array(array("record"=>"type","value"=>'3')));
    $this->loadViews("add_points",$this->global,$data,NULL);
  }
  public function note(){
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $records_count = get_note(1);
    $returns = $this->paginationCompress ( "note/", $records_count, 15);
    $data["note"] = $this->base_model->getNote($returns["page"], $returns["segment"]);
    $this->loadViews("note",$this->global,$data,NULL);
  }

  public function deleteNotes(){
    $notes = $this->input->post("notes");
    foreach($notes as $value){
      $this->base_model->deleteRecordCustom("tbl_notice","id",$value);
    }
    redirect("note");
  }

  public function saveEventHomepage(){

    if (!file_exists("../upload/event/"))
      mkdir("../upload/event/", 0777);
    $this->load->library('upload',$this->set_upload_options("../upload/event/",30000,false));
    $this->upload->initialize($this->set_upload_options("../upload/event/",30000,false));
    if(!empty($_FILES['image_event']['name']) && $_FILES['image_event']['name'] !=""){
      if ( ! $this->upload->do_upload('image_event'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById(1,array("image"=>$img_data["file_name"],
          "use"=>$this->input->post("use"),"link"=>$this->input->post("link")),"tbl_eventhome","id");
      }
    }
    else{
      $this->base_model->updateDataById(1,array("use"=>$this->input->post("use"),"link"=>$this->input->post("link")),"tbl_eventhome","id");
    }
    redirect("event");
  }

  public function notsbyregister(){
    $data["p"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'2')));
    $data["p1"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'3')));
    $data["p2"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'4')));
    $data["p3"] = $this->base_model->getSelect("tbl_eventhome",array(array("record"=>"id","value"=>'5')));
    $this->loadViews("notsbyregister",$this->global,$data,NULL);
  }

  public function saveregisternots(){
    $id = !empty($this->input->post("ids")) ? $this->input->post("ids"): $this->input->post("id");
    $this->base_model->updateDataById($id,array("use"=>$this->input->post("use"),"link"=>$this->input->post("link")),"tbl_eventhome","id");
    redirect("notsbyregister");
  }

  public function updateOrderBanner(){
    $stack = array();
    $ids= $this->input->post("ids");
    foreach($ids as $key=>$value){
      $sql = "UPDATE banner SET banner.order = ".$key."  WHERE id =".$value.";";
      $stack[] = $sql;
    }
    $this->db->trans_start();
    foreach($stack as $value){
      $this->base_model->runSQL($value);
    }
    $this->db->trans_complete();
  }

  public function footer_management(){
    $data["p"] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>'76')));
    $data["p1"] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>'77')));
    $data["p2"] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>'78')));
    $this->loadViews("footer_management",$this->global,$data,NULL);
  }

  public function saveMobileHeader(){
    if($_FILES['image']['name'] !=""){
      $this->load->library('upload',$this->set_upload_options(__DIR__."/../../../m/template/images",30000,false,"top_logo"));
      $this->upload->initialize($this->set_upload_options(__DIR__."/../../../m/template/images",30000,false,"top_logo"));
      if ( ! $this->upload->do_upload('image'))
      {
        $error = array('error' => $this->upload->display_errors());
        var_dump($error);

      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById(78,array("image"=>$img_data["file_name"],"type"=>22),"banner","id");
      }
    }
    if($_FILES['image1']['name'] !=""){
     $this->load->library('upload',$this->set_upload_options(__DIR__."/../../../m/template/images",30000,false,"kor_kor"));
      $this->upload->initialize($this->set_upload_options(__DIR__."/../../../m/template/images",30000,false,"kor_kor"));
      if ( ! $this->upload->do_upload('image1'))
      {
        $error = array('error' => $this->upload->display_errors());
         var_dump($error);
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById(78,array("image1"=>$img_data["file_name"],"type"=>22),"banner","id");
      }
    }
    redirect("footer_management");
  }
  public function tackbae(){
    $data['tackbae'] = $this->base_model->getSelect("tracking_header");
    $this->loadViews("tackbae",$this->global,$data,NULL);
  }
  public function addTackBae(){
    $this->base_model->insertArrayData("tracking_header",$this->input->post());
    redirect("tackbae");
  }

  public function deleteTack(){
    $id = $this->input->post("id");
    if($id > 0 ){
      $this->base_model->deleteRecordCustom("tracking_header","id",$id);
      echo 1;
      return;
    }
    echo 0;
  }

  public function send_management(){
    $data['send_management'] = $this->base_model->getSelect("tbl_sendmethod");
    $this->loadViews("send_management",$this->global,$data,NULL);
  }

  public function deleteSend(){
    $id = $this->input->post("id");
    if($id > 0 ){
      $this->base_model->deleteRecordCustom("tbl_sendmethod","id",$id);
      echo 1;
      return;
    }
    echo 0;
  }
  public function addSends(){
    $return  = 0;

    if($this->input->post("id") <= 0 || empty($this->input->post("id")))
    {
      $data = $this->input->post();
      unset($data["id"]);
      $return =  $this->base_model->insertArrayData("tbl_sendmethod",$data);
    }
    else{
      $this->base_model->updateDataById($this->input->post("id"),array("name"=>$this->input->post("name")),"tbl_sendmethod","id");
      $return = $this->input->post("id");
    }

    if($return > 0 ){
      if($_FILES['image']['name'] !=""){
        $this->load->library('upload',$this->set_upload_options("../m/upload/income"));
        $this->upload->initialize($this->set_upload_options("../m/upload/income"));
        if ( ! $this->upload->do_upload('image'))
        {
          $error = array('error' => $this->upload->display_errors());

        }
        else
        {
          $img_data = $this->upload->data();
          $this->base_model->updateDataById($return,array("image"=>$img_data["file_name"]),"tbl_sendmethod","id");
        }
      }
    }
    redirect("send_management");
  }

  public function service_management(){
    $data['services'] = $this->base_model->getServices();
    $data['service_type'] = $this->base_model->getSelect("tbl_service_header",array(array("record"=>"use","value"=>1)));
    $this->loadViews("service_management",$this->global,$data,NULL);
  }

  public function service_type(){
    $data['services'] = $this->base_model->getSelect("tbl_service_header");
    $this->loadViews("service_type",$this->global,$data,NULL);
  }

  public function editServiceType(){
    $id = $this->input->post("id");
    echo json_encode($this->base_model->getSelect("tbl_service_header",array(array("record"=>"id","value"=>$id))));
  }

  public function deleteServiceType(){
    $id = $this->input->post("id");
    if($id > 0 ){
      $this->base_model->deleteRecordCustom("tbl_service_header","id",$id);
      echo 1;
      return;
    }
    echo 0;
  }

  public function saveServiceType(){
    $data = $this->input->post();
    $id  = $data['id'];
    unset($data['id']);
    if(!empty($id) && $id > 0 ){
      $this->base_model->updateDataById($id,$data,"tbl_service_header","id");
    }
    if(empty($id) || $id <=0){
      $this->base_model->insertArrayData("tbl_service_header",$data);
    }
    redirect("service_type");
  }

  public function editService(){
    $id = $this->input->post("id");
    echo json_encode($this->base_model->getSelect("tbl_services",array( array("record"=>"id","value"=>$id)
                                                                        )));
  }

  public function saveService(){
    $data = $this->input->post();
    $id  = $data['id'];
    unset($data['id']);
    if(!empty($id) && $id > 0 ){
      $this->base_model->updateDataById($id,$data,"tbl_services","id");
    }
    if(empty($id) || $id <=0){
      $this->base_model->insertArrayData("tbl_services",$data);
    }
    redirect("service_management");
  }

  public function getCateogory(){
    $id= $this->input->post("id");
    echo  json_encode($this->base_model->getSelect("tbl_category",array(array("record"=>"parent","value"=>$id))));
  }

  public function editAddress(){
    echo json_encode($this->base_model->getSelect("tbl_sendmethod",array(array("record"=>"id","value"=>$this->input->post("id")))));
  }

  public function deletePost(){
    $id = $this->input->post("id");
    if(empty($id)) {echo 101;return;}
    $this->base_model->deleteRecordCustom("tbl_mail","id",$id);
    echo 100;
  }

  public function deleteCustomX(){
    $data = $this->input->post();
    $id = $data["id"];
    if($id > 0 ){
      $this->base_model->deleteRecordCustom("tbl_custom_exchange_rate","id",$id);
      echo 1;
      return;
    }
    echo 0;
  }


  public function categoryProducts(){
    $where = array();

    if($this->input->get("shUseYn") !=null && trim($this->input->get("shUseYn")) !="")
    {
      $temp = array();
      $temp["record"] = "use";
      $temp["value"] = $this->input->get("shUseYn");
      array_push($where, $temp);
    }
    if(!empty($this->input->get("name")))
    {
      $temp = array();
      $temp["record"] = "name";
      $temp["value"] = $this->input->get("name");
      array_push($where,$temp);
    }
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);

    $records_count = sizeof($this->base_model->getSelect("tbl_shop_category",$where));
    $returns = $this->paginationCompress ( "categoryProducts/", $records_count, 15);
    $data['categories'] = $this->base_model->getSelect("tbl_shop_category",
                                                                          $where,
                                                                          array(array("record"=>"order","value"=>"ASC")),
                                                                          null,
                                                                          array(array("record"=>$returns["page"],"value"=>$returns["segment"])));
    $this->loadViews("categoryProducts",$this->global,$data,NULL);
  }

  public function editCategory(){
    $this->loadViews("editCategory",$this->global,NULL,NULL);
  }

  public function edit_category($id){
    $data['category'] = $this->base_model->getSelect("tbl_shop_category",array(array("record"=>"id","value"=>$id)));
    $this->loadViews("editCategory",$this->global,$data,NULL);
  }


  public function registerCategory(){
    $data = $this->input->post();
    $id = $data["id"];
    unset($data["id"]);
    $return=  0;
    if($id > 0){
      $this->base_model->updateDataById($id,$data,"tbl_shop_category","id");
      $return  = $id;
    }

    else{
      $return =  $this->base_model->insertArrayData("tbl_shop_category",$data);
    }

    if($return > 0  && $_FILES['image']['name'] !=""){
      $this->load->library('upload',$this->set_upload_options("../upload/image"));
      $this->upload->initialize($this->set_upload_options("../upload/image"));

      if ( ! $this->upload->do_upload('image'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById($return,array("image"=>$img_data["file_name"]),"tbl_shop_category","id");
      }
    }
    redirect("categoryProducts");
  }

  public function del_cats(){
    $id = $this->input->post("spid");
    $this->base_model->deleteRecordCustom("tbl_shop_category","id",$id);
    echo json_encode(array("status"=>true));
  }

  public function deleteProductImage(){
    $url = $this->input->post("url");
    $id = $this->input->post("id");
    $type = $this->input->post("type");
    if(empty($url) || empty($id))
    {
      echo json_encode(array("status"=>0));
      return;
    }

    $this->base_model->updateDataById($id,array($type=>""),"tbl_sproducts","id");
    echo json_encode(array("status"=>delteFile($_SERVER['DOCUMENT_ROOT']."/upload/shoppingmal/".$id."/".$url)));
  }

  public function changeGrade(){
    $grade = $this->input->post("grade");
    $id = $this->input->post("id");
    $this->base_model->updateDataById($id,array("grade"=>$grade),"tbl_board","id");
    echo 1;
  }

  public function viewNote(){
    $id = $this->input->post("id");
    $this->base_model->updateDataById($id,array("view"=>1),"tbl_notice","id");
    echo 1;
  }

  public function deleteFooterImg(){
    $type = $this->input->post("type");
    $img = $this->input->post("img");
    delteFile($_SERVER['DOCUMENT_ROOT']."/template/images/".$img);
    $this->base_model->updateDataById("77",array($type=>""),"banner","id");
    echo 1;
  }

  public function edtCoupon(){
    $id = $this->input->post("id");
    if($id > 0 ){
      $data = $this->base_model->getSelect("tbl_coupon",array(array("record"=>"id","value"=>$id)));
      echo json_encode($data);
      return;
    }
    echo json_encode(array());
  }

  public function delCoupon(){
    $id = $this->input->post("id");
    if($id > 0){
      $this->base_model->updateDataById($id,array("is_deleted"=>1,"use"=>"0"),"tbl_coupon","id");
      echo json_encode(array("result"=>"success"));
      return;
    }
    echo json_encode(array("result"=>"error"));
  }

  public function shopcategory(){
    $data['first_category'] = $this->base_model->getCategoriesFromParentsArray(array(0));
    $this->loadViews("shopcategory", $this->global, $data , NULL);
  }

  public function category_pro(){
    $c_depth = $this->input->get("depth");
    $mode = $this->input->get("mode");
    if($mode =="update"){
      $c_uid = $this->input->get("c_uid");
      $data["c_uid"] =  $c_uid;
      $data["uid_content"] = strval(json_encode($this->base_model->getSelect("tbl_leftcategory",array(array("record"=>"id","value"=> $c_uid)))));
    }
    if($c_depth >=0){
      $data['depth'] = $c_depth;
      $data['mode'] = $mode;
      $data['category'] =  $this->base_model->getSelect("tbl_leftcategory",array(array("record"=>"parent",'value'=>$c_depth)));
      $this->load->view("category.pro.php",$data);
    }
  }

  public function addShopCategory(){

    $data = $this->input->post();
    $_mode = $data["_mode"];
    $c_depth = $data["parent"];
    $return = $c_uid = $data["c_uid"];
    $step = $data["step"];
    $update = $_mode;

    if($_mode !="delete"){
      unset($data["c_uid"]);
      unset($data['_mode']);
      // unset($data['step']);
      $banner = "";
      $mobile_banner = "";
      $icon = "";
      if($data['banner_use'] == 1 ){
        if($_FILES['banner']['name'] !=""){
          $this->load->library('upload',$this->set_upload_options("../upload/thumb"));
          $this->upload->initialize($this->set_upload_options("../upload/thumb"));

          if ( ! $this->upload->do_upload('banner'))
          {
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
            return;
          }
          else
          {
            $img_data = $this->upload->data();
            $banner = $img_data["file_name"];
          }
        }

        if($_FILES['mobile_banner']['name'] !=""){
          $this->load->library('upload',$this->set_upload_options("../upload/thumb"));
          $this->upload->initialize($this->set_upload_options("../upload/thumb"));

          if ( ! $this->upload->do_upload('mobile_banner'))
          {
            $error = array('error' => $this->upload->display_errors());
          }
          else
          {
            $img_data = $this->upload->data();
            $mobile_banner = $img_data["file_name"];
          }
        }
        if($_FILES['icon']['name'] !=""){
          $this->load->library('upload',$this->set_upload_options("../upload/thumb"));
          $this->upload->initialize($this->set_upload_options("../upload/thumb"));

          if ( ! $this->upload->do_upload('icon'))
          {
            $error = array('error' => $this->upload->display_errors());
          }
          else
          {
            $img_data = $this->upload->data();
            $icon = $img_data["file_name"];
          }
        }
      }

      if($banner !="")
        $data["banner"] = $banner;
      if($mobile_banner !="")
        $data["mobile_banner"] = $mobile_banner;
      if($icon !="")
        $data["icon"] = $icon;

      if($c_uid > 0){
        $return =  $c_uid;
        $update = "update";
        $this->base_model->updateDataById($c_uid,$data,"tbl_leftcategory","id");
      }
      else{
        $data["category_code"] = generateRandomString(10);
        $return = $this->base_model->insertArrayData("tbl_leftcategory",$data);
      }
    }
    else{
     $this->base_model->deleteRecordCustom("tbl_leftcategory","id",$c_uid);
    }

    echo "<script>self.close();opener.redirect(".$return.",'".$data["name"]."','".$data["use"]."',".$step.",'".$update."');</script>";
  }

  public function getshopcategory(){
    $type  = $this->input->post("type");
    $id  = $this->input->post("id");
    $depth  = $this->input->post("depth");

    if($type =="content"){
      $c = $this->base_model->getSelect("tbl_leftcategory",array(array("record"=>"id","value"=>$id)),array(array("record"=>"order","value"=>"ASC")));
      if(empty($c))
        echo json_encode(array("success"=>0));
      else
        echo json_encode(array("success"=>1,"result"=>$c[0]));
    }

    if($type =="list")
    {
      $c = $this->base_model->getCategoriesFromParentsArray(array($id));
      echo json_encode(array("result"=>$c));
    }
  }

  public function deleteShopBanner(){

    $url = $this->input->post("url");
    $id = $this->input->post("id");
    $type = $this->input->post("type");
    if(empty($url) || empty($id))
    {
      echo json_encode(array("status"=>0));
      return;
    }
    $this->base_model->updateDataById($id,array($type=>""),"tbl_leftcategory","id");
    echo json_encode(array("status"=>delteFile($_SERVER['DOCUMENT_ROOT']."/upload/thumb/".$url)));
  }

  public function ico(){
    $data["icons"] = $this->base_model->getSelect("tbl_proico",NULL,array(array("record"=>"order","value"=>"ASC")));
    echo $this->loadViews("ico",$this->global,$data,NULL);
  }

  public function addIcon(){
    $id = $this->input->get('id');
    $data['icon']  = NULL;
    if($id > 0)
      $data['icons'] = $this->base_model->getSelect("tbl_proico",array(array("record"=>"id","value"=>$id)));
    echo $this->loadViews("addIcon",$this->global,$data,NULL);
  }

  public function CreateIcon(){
    $data = $this->input->post();
    $id = $data["id"];
    unset($data["id"]);
    if(empty($data['order']))
      $data['order'] =1;
    $mg = "";
    if($_FILES['icon']['name'] !=""){
      $this->load->library('upload',$this->set_upload_options("../upload/Products/icon"));
      $this->upload->initialize($this->set_upload_options("../upload/Products/icon"));

      if ( ! $this->upload->do_upload('icon'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $data['icon'] = $img_data["file_name"];
      }
    }

    if($id > 0)
      $this->base_model->updateDataById($id,$data,"tbl_proico","id");
    else
      $this->base_model->insertArrayData("tbl_proico",$data);
    redirect("ico");
  }

  public function deleteIconImage(){

    $id = $this->input->post("id");
    $file_name = $this->input->post("url");
    if(empty($id))
    {
      echo json_encode(array("status"=>null));
      return;
    }

    echo json_encode(array("status"=>delteFile($_SERVER['DOCUMENT_ROOT'].$file_name)));
    $this->base_model->updateDataById($id,array("icon"=>""),"tbl_proico","id");
  }

  public function product_wish(){
    $cate_sea = array();
    $p_saleview = $this->input->get("p_saleview");
    $p_newview = $this->input->get("p_newview");
    $p_bestview = $this->input->get("p_bestview");
    $p_name = $this->input->get("p_name");
    $p_code = $this->input->get("p_code");
    $p_category = $this->input->get("p_category");
    $this->global['pageTitle'] = '상품찜관리';
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);

    if(!empty($p_category) && $p_category > 0){
      $productid = array();
      $temp = $this->getChildCateogriesFromParentID($p_category);
      if(!empty($temp["category"]))
        $cate_sea = $temp["category"];
    }

    $records_count = sizeof($this->base_model->getProuctWishs(
                                                        0,
                                                        0,
                                                        $p_saleview,
                                                        $p_newview,
                                                        $p_bestview,
                                                        $p_code,
                                                        $cate_sea,
                                                        $p_name));
    $returns = $this->paginationCompress ( "product_wish/", $records_count, 10);

    $data['wishes']  = $this->base_model->getProuctWishs(
                                                  $returns['page'],
                                                  $returns['segment'],
                                                  $p_saleview,
                                                  $p_newview,
                                                  $p_bestview,
                                                  $p_code,
                                                  $cate_sea,
                                                  $p_name);
    $data['category'] = $this->base_model->getSelect("tbl_leftcategory", array( array("record"=>"use","value"=>1),
                                                                                array("record"=>"parent","value"=>0)),
                                                                          array(array("record"=>"order","value"=>"ASC")));

    if($this->input->get("step2") > 0)
      $data['category2'] = $this->base_model->getSelect("tbl_leftcategory", array( array("record"=>"use","value"=>1),
                                                                                array("record"=>"parent","value"=>$this->input->get("step2"))),
                                                                          array(array("record"=>"order","value"=>"ASC")));
    if($this->input->get("step3") > 0)
      $data['category3'] = $this->base_model->getSelect("tbl_leftcategory", array( array("record"=>"use","value"=>1),
                                                                                array("record"=>"parent","value"=>$this->input->get("step3"))),
                                                                          array(array("record"=>"order","value"=>"ASC")));

    $data["sc"] = $records_count;
    $data["gy"] = $returns["segment"];
    echo $this->loadViews("product_wish",$this->global,$data,NULL);

  }

  public function shop_banner(){
    $data['mobile'] = $this->input->get("mobile")==1 ? 1:0;
    $data['banner_type'] = $this->input->get("type") > 0 ? $this->input->get("type") : 23;
    $data['banner'] = $this->base_model->getSelect("banner",array(array("record"=>"type","value"=>$data['banner_type']),
                                                                    array("record"=>"mobile","value"=>$data['mobile'])),
                                                            array(array("record"=>"order","value"=>"ASC")));
    $data["type"] = "shop_banner";
    $this->loadViews('homePage', $this->global, $data , NULL);
  }

  public function setCategoryShop(){
    $pcode = $this->input->post("pcode");
    $category = $this->input->post("category");
    $type = $this->input->post("type");
    if($type =="add"){
      $this->base_model->insertArrayData("tbl_product_category",array("pcode"=>$pcode,"category_id"=>$category));
      echo json_encode(array("status"=>"success"));
      return;
    }

    if($type =="delete"){
      $this->base_model->deleteCategoryShop($pcode,$category);
      echo json_encode(array("status"=>"success"));
      return;
    }
    echo json_encode(array("status"=>"fail"));
  }

  public function config_delivery(){
    $data['config_delivery'] = get_site_info();
    $this->loadViews("config_delivery",$this->global,$data,null);
  }

  public function product_option(){
    $second = array();
    $pass_mode = $this->input->get("pass_mode");
    $pcode = $this->input->get("pcode");
    if($pass_mode =='second')
      $depth =2;

    $data['add_options'] = $this->base_model->getSelect("tbl_product_option",array(  array("record"=>"pcode","value"=>$pcode),
                                                                                      array("record"=>"parent","value"=>0)) ,
                                                                        array(array("record"=>"sort","value"=>"ASC")));

    if(!empty($data['add_options'])){
      foreach ($data['add_options'] as $key => $value) {
        $second[$value->id] = $this->base_model->getSelect("tbl_product_option",array(
                                                                                      array("record"=>"parent","value"=>$value->id)) ,
                                                                        array(array("record"=>"sort","value"=>"ASC")));
      }
    }

    $data["second"] = $second;
    $this->load->view("product_option",$data);
  }

  public function product_option_save(){
    $name = $this->input->post('name');
    $count = $this->input->post('count');
    $parent = $this->input->post('parent');
    $optionprice = $this->input->post('optionprice');
    $supply = $this->input->post('supply');
    $pcode = $this->input->post('pcode');
    $id = $this->input->post("id");
    $mode = $this->input->post("mode");
    $view = $this->input->post("view");

    if($mode =="delete"){
      $this->base_model->deleteOptionCategories($id);
      echo json_encode(array("status"=>"success"));
      return;
    }

    $data = array(  "supply"=>$supply,
                    "pcode"=>$pcode,
                    "name"=>$name,
                    "count"=>$count,
                    "optionprice"=>$optionprice,
                    "parent"=>$parent,
                    "pcode"=>$pcode,
                    "view"=>$view);
    if($mode =="update"){
      $this->base_model->updateDataById($id,$data,"tbl_product_option","id");
    }
    if($mode =="add"){
      $this->base_model->insertArrayData("tbl_product_option",$data);
    }
    echo json_encode(array("status"=>"success"));
  }

  public function saveOrderOptions(){
    $ids = $this->input->post("ids");
    $first = 1;
    if(sizeof($ids) > 0){
      foreach($ids as $value){
        $this->base_model->updateDataById($value,array("sort"=>$first),"tbl_product_option","id");
        $first = $first + 1;
      }
    }

    echo json_encode(array("status"=>"success"));
  }

  public function multi_categories(){
    $second = array();
    $three = array();
    $sels = array();
    $data['sels'] = 0;
    $data['categories1'] = $this->base_model->getSelect("tbl_leftcategory",array(array("record"=>"parent","value"=>0)),array(array("record"=>"order","value"=>"ASC")));
    if(!empty($data['categories1']))
      foreach($data['categories1'] as $value)
        array_push($second, $value->id);
    $data['categories2'] = $this->base_model->getCategoriesFromParentsArray($second);
    if(!empty($data['categories2']))
      foreach($data['categories2'] as $value)
        array_push($three, $value->id);
    $data['categories3'] = $this->base_model->getCategoriesFromParentsArray($three);

    $selectedcates = $this->base_model->getSelect("tbl_related_product",array(array("record"=>"pcode","value"=>$this->input->get("pcode"))));
    foreach($selectedcates as $value)
      array_push($sels, $value->category_id);
    if(!empty($sels))
      $data['sels']=$sels[0];
    $this->load->view("multi_categories",$data);
  }

  public function config_delivery_pro(){
    $this->base_model->updateDataById(1,$this->input->post(),"tbl_smart_setup","id");
    redirect("config_delivery");
  }

  public function delivery_addprice_list(){
    $type = $this->input->get("type");
    $post = "";
    $address = "";
    $$type = $this->input->get("content");
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $records_count = sizeof($this->base_model->getAddDelviery(0,0,$post,$address));
    $returns = $this->paginationCompress ( "delivery_addprice_list/", $records_count,20);
    $data["list"] = $this->base_model->getAddDelviery($returns["page"],$returns["segment"],$post,$address);
    $data["uc"] = $records_count;
    $data["pf"] = $returns["segment"];
    $this->loadViews("delivery_addprice_list",$this->global,$data,NULL);
  }

  public function addDeliveryPrice(){
    $id = $this->input->get("id");
    $data["add"] = array();
    if($id > 0)
      $data["add"] = $this->base_model->getSelect("tbl_delivery_addprice",array(array("record"=>"id","value"=>$id)));
    $this->loadViews("addDeliveryPrice",$this->global,$data,NULL);
  }

  public function updateAddDeliveryAddress(){
    $data = $this->input->post();
    $id = $data['id'];
    unset($data["id"]);
    if($id > 0 )
      $this->base_model->updateDataById($id,$data,"tbl_delivery_addprice","id");
    else
      $this->base_model->insertArrayData("tbl_delivery_addprice",$data);
    redirect("delivery_addprice_list");
  }

  public function deleteAddDelvieryAddress(){
    $spid = $this->input->post("spid");
    $this->isLoggedIn();
    if(!empty($spid)):
      $this->base_model->deleteRecordCustom("tbl_delivery_addprice","id",$spid);
      echo json_encode(array("status"=>true));
    endif;
    if(empty($spid)):
      echo json_encode(array("status"=>false));
    endif;
  }

  public function product_talk(){
    $type = $this->input->get("type");
    $name = $this->input->get("name");
    $pcode = $this->input->get("pcode");
    $writter = $this->input->get("writter");
    $comment = $this->input->get("comment");
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $records_count = sizeof($this->base_model->getReviews(0,0,$type,$name,$pcode,$writter,$comment));
    $returns = $this->paginationCompress ( "product_talk/", $records_count,10);
    $data["list"] = $this->base_model->getReviews($returns["page"],$returns["segment"],$type,$name,$pcode,$writter,$comment);
    $data["uc"] =$records_count;
    $data["pf"] = $returns["segment"];
    $this->loadViews("product_talk",$this->global,$data,NULL);
  }

  public function deleteEval(){
    $spid = $this->input->post("spid");
    $item = $this->base_model->getSelect("tbl_product_talk",array(array("record"=>"id","value"=>$spid)));
    if(!empty($item[0]->img))
      delteFile($_SERVER['DOCUMENT_ROOT']."/upload/request/".$item[0]->img);
    $this->base_model->deleteRecordCustom("tbl_product_talk","id",$spid);
    echo json_encode(array("status"=>true));
  }

  public function product_talk_modify(){
    $id = $this->input->get("id");
    $type = $this->input->get("type");
    $data['parent'] =  array();
    if(!empty($id)){
      $data['parent'] = $this->base_model->getParentRequest($id);
    }
    $this->loadViews("product_talk_modify",$this->global,$data,NULL);
  }

  public function deleteRequestImage(){
    $id = $this->input->post("id");
    $img = $this->input->post("img");
    delteFile($_SERVER['DOCUMENT_ROOT']."/upload/request/".$img);
    $this->base_model->updateDataById($id,array("img"=>""),"tbl_product_talk","id");
    echo 1;
  }

  public function updateProductTalk(){
    $data = $this->input->post();
    $id = $data["id"];
    $type = $data["type"];
    $mode = isset($data["mode"]) ? $data["mode"] : "";
    $status = !empty($data["status"]) ? $data["status"] : "";
    unset($data["id"]);
    unset($data["mode"]);
    unset($data["status"]);
    $return = 0;
    $image = "";

    if(!empty($_FILES['img']['name']) && $_FILES['img']['name'] !=""){
      $this->load->library('upload',$this->set_upload_options("../upload/request"));
      $this->upload->initialize($this->set_upload_options("../upload/request"));

      if ( ! $this->upload->do_upload('img'))
      {
        $error = array('error' => $this->upload->display_errors());
      }
      else
      {
        $img_data = $this->upload->data();
        $image = $img_data["file_name"];
      }
    }
    if(!empty($image)){
      $data["img"] = $image;
    }
    if($id > 0)
    {
      $return  = $id;
      $this->base_model->updateDataById($id,$data,"tbl_product_talk","id");
    }
    else
      $return = $this->base_model->insertArrayData("tbl_product_talk",$data);

    if($status =="reply")
      $return = $data["relation"];
    redirect("product_talk?type=".$type);
  }

  public function updateOrderCategory(){
    $ids = $this->input->post("ids");
    foreach($ids as $key=>$value)
      $this->base_model->updateDataById($value,array("order"=>$key+1),"tbl_leftcategory","id");

  }

  public function deleteIconItem(){
    $id = $this->input->post("id");
    $data  = $this->base_model->getSelect("tbl_proico",array(array("record"=>"id","value"=>$id)));
    if(empty($data))
    {
      echo json_encode(array("status"=>false));
      return;
    }

    $img = $data[0]->icon;
    if(!empty($img))
    {
      delteFile($_SERVER['DOCUMENT_ROOT']."/upload/Products/icon/".$img);
    }
    $this->base_model->deleteRecordCustom("tbl_proico","id",$id);
    echo json_encode(array("status"=>true));
  }

  public function deleteWishes(){
    $checkedp = $this->input->post("checkedp");
    $this->base_model->deleteRecordCustom("tbl_product_wish","id",$checkedp,true);
    redirect("/product_wish");
  }

  private function getChildCateogriesFromParentID($category_id){
    $returns = array();
    $category_name = "전체";
    if(!empty($category_id)){
      $selected_category = $this->base_model->getSelect("tbl_leftcategory",array(array("record"=>"id","value"=>$category_id)));
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

  public function loginlog(){

    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $month =  empty($this->input->get("month")) ? date("m") : $this->input->get("month");

    $data["year"] = $year;
    $data["month"] = $month;

    $data["result"] = $this->base_model->getDayAccess($year,$month);
    $this->loadViews("loginlog",$this->global,$data,NULL);
  }

  public function monthloginlog(){
    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $data["year"] = $year;
    $data["result"] = $this->base_model->getMonthAccess($year);

    $this->loadViews("monthloginlog",$this->global,$data,NULL);
  }

  public function yearloginlog(){
    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $month =  empty($this->input->get("month")) ? date("m") : $this->input->get("month");

    $data["year"] = $year;
    $data["month"] = $month;
    $data["result"] = $this->base_model->getYearAccess($year,$month);
    $this->loadViews("yearloginlog",$this->global,$data,NULL);
  }

  public function timeloginlog(){
    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $month =  empty($this->input->get("month")) ? date("m") : $this->input->get("month");
    $date =  empty($this->input->get("date")) ? date("d") : $this->input->get("date");
    $data["year"] = $year;
    $data["month"] = $month;
    $data["date"] = $date;
    $data["result"] = $this->base_model->getTimeAccess($year,$month,$date);
    $this->loadViews("timeloginlog",$this->global,$data,NULL);
  }

  public function visitlog(){
    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $month =  empty($this->input->get("month")) ? date("m") : $this->input->get("month");

    $data["year"] = $year;
    $data["month"] = $month;

    $data["result"] = $this->base_model->getDayVisit($year,$month);
    $this->loadViews("visitlog",$this->global,$data,NULL);
  }

  public function monthvisitlog(){
    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $data["year"] = $year;
    $data["result"] = $this->base_model->getMonthVisit($year);

    $this->loadViews("monthvisitlog",$this->global,$data,NULL);
  }

  public function yearvisitlog(){
    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $month =  empty($this->input->get("month")) ? date("m") : $this->input->get("month");

    $data["year"] = $year;
    $data["month"] = $month;
    $data["result"] = $this->base_model->getYearVisit($year,$month);
    $this->loadViews("yearvisitlog",$this->global,$data,NULL);
  }

  public function timevisitlog(){
    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $month =  empty($this->input->get("month")) ? date("m") : $this->input->get("month");
    $date =  empty($this->input->get("date")) ? date("d") : $this->input->get("date");
    $data["year"] = $year;
    $data["month"] = $month;
    $data["date"] = $date;
    $data["result"] = $this->base_model->getTimevisit($year,$month,$date);
    $this->loadViews("timevisitlog",$this->global,$data,NULL);
  }

  public function  gradeLogin()
  {

    $this->load->library('pagination');
    $count = sizeof($this->base_model->userListing());

    $returns = $this->paginationCompress ( "gradeLogin/", $count, 30);
    $this->load->model('base_model');
    $data['userRecords'] = $this->base_model->userListing($returns["page"], $returns["segment"]);

    $this->global['pageTitle'] = '회원리스트';
    $data["uc"] = $count;
    $data["pf"] = $returns["segment"];

    $this->loadViews("gradeLogin", $this->global, $data, NULL);
  }

  public function  depositLogin()
  {

    $this->load->library('pagination');
    $count = sizeof($this->base_model->userListingGrade());

    $returns = $this->paginationCompress ( "depositLogin/", $count, 30);
    $this->load->model('base_model');
    $data['userRecords'] = $this->base_model->userListingGrade($returns["page"], $returns["segment"]);

    $data["uc"] = $count;
    $data["pf"] = $returns["segment"];

    $this->loadViews("depositLogin", $this->global, $data, NULL);
  }

  public function dayRegister(){
    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $month =  empty($this->input->get("month")) ? date("m") : $this->input->get("month");
    $data["year"] = $year;
    $data["month"] = $month;
    $data["result"] = $this->base_model->getDayRegister($year,$month);
    $this->loadViews("dayRegister",$this->global,$data,NULL);
  }

  public function weekRegister(){
    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $month =  empty($this->input->get("month")) ? date("m") : $this->input->get("month");
    $data["year"] = $year;
    $data["month"] = $month;
    $data["result"] = $this->base_model->getWeekRegister($year,$month);
    $this->loadViews("weekRegister",$this->global,$data,NULL);
  }

  public function MonthRegister(){
    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $data["year"] = $year;
    $data["result"] = $this->base_model->getMonthRegister($year);

    $this->loadViews("monthRegister",$this->global,$data,NULL);
  }

  public function RegionRegister(){
    $data["result"] = $this->base_model->getRegionRegister();
    $this->loadViews("regionRegister",$this->global,$data,NULL);
  }

  public function purchasedProducts(){
    $records_count = sizeof($this->base_model->getPurchasedProudctsOrder(0,0));
    $returns = $this->paginationCompress ( "purchasedProducts/", $records_count, 30);
    $data["ac"] = $records_count;
    $data["cc"] = $returns["segment"];
    $data["products"] = $this->base_model->getPurchasedProudctsOrder($returns["page"],$returns["segment"]);
    $this->loadViews("purchasedProducts",$this->global,$data,NULL);
  }

  public function viewedProducts(){
    $records_count = sizeof($this->base_model->getViewedProductsOrder(0,0));
    $returns = $this->paginationCompress ( "viewedProducts/", $records_count, 30);
    $data["ac"] = $records_count;
    $data["cc"] = $returns["segment"];
    $data["products"] = $this->base_model->getViewedProductsOrder($returns["page"],$returns["segment"]);
    $this->loadViews("viewedProducts",$this->global,$data,NULL);
  }

  public function viewedCategory(){
    $data["products"] = $this->base_model->getViewedCategoryOrder();
    $this->loadViews("viewedCategory",$this->global,$data,NULL);
  }

  public function purchasedCategory(){
    $data["products"] = $this->base_model->getPurchasedCategoryOrder();
    $this->loadViews("purchasedCategory",$this->global,$data,NULL);
  }

  public function searchProducts(){
    $records_count = sizeof($this->base_model->getSearchproductsOrder(0,0));
    $returns = $this->paginationCompress ( "searchProducts/", $records_count, 30);
    $data["products"] = $this->base_model->getSearchproductsOrder($returns["page"],$returns["segment"]);
    $data["ac"] = $records_count;
    $data["cc"] = $returns["segment"];
    $this->loadViews("searchProducts",$this->global,$data,NULL);
  }

  public function membershopping(){
    $this->load->library('pagination');
    $count = sizeof($this->base_model->getMemberShopping(1));

    $returns = $this->paginationCompress ( "membershopping/", $count, 30);
    $this->load->model('base_model');
    $data['userRecords'] = $this->base_model->getMemberShopping(1,$returns["page"], $returns["segment"]);

    $data["uc"] = $count;
    $data["pf"] = $returns["segment"];

    $this->loadViews("membershopping", $this->global, $data, NULL);
  }


  public function memberBuy(){
    $this->load->library('pagination');
    $count = sizeof($this->base_model->getMemberShopping(2));

    $returns = $this->paginationCompress ( "memberBuy/", $count, 30);
    $this->load->model('base_model');
    $data['userRecords'] = $this->base_model->getMemberShopping(2,$returns["page"], $returns["segment"]);

    $data["uc"] = $count;
    $data["pf"] = $returns["segment"];

    $this->loadViews("memberBuy", $this->global, $data, NULL);
  }

  public function daySite(){
    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $month =  empty($this->input->get("month")) ? date("m") : $this->input->get("month");

    $data["year"] = $year;
    $data["month"] = $month;

    $data["result"] = $this->base_model->getDaySites($year,$month,$this->input->get("domain"));
    $this->loadViews("daySite",$this->global,$data,NULL);
  }

  public function monthSite(){
    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $data["year"] = $year;
    $data["result"] = $this->base_model->getMonthSites($year,$this->input->get("domain"));
    $this->loadViews("monthSite",$this->global,$data,NULL);
  }

  public function weekSite(){
    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $month =  empty($this->input->get("month")) ? date("m") : $this->input->get("month");

    $data["year"] = $year;
    $data["month"] = $month;
    $data["result"] = $this->base_model->getWeekSites($year,$month,$this->input->get("domain"));
    $this->loadViews("weekSite",$this->global,$data,NULL);
  }

  public function regionvisitlog(){
    $records_count = sizeof($this->base_model->getregionVisit(0,0));
    $returns = $this->paginationCompress ( "regionvisitlog/", $records_count, 30);
    $data["ac"] = $records_count;
    $data["cc"] = $returns["segment"];
    $data["region"] = $this->base_model->getregionVisit($returns["page"],$returns["segment"]);
    $this->loadViews("regionvisitlog",$this->global,$data,NULL);
  }


  public function getStrange(){
    $records_count = sizeof($this->base_model->getStrange(0,0));
    $returns = $this->paginationCompress ( "getStrange/", $records_count, 30);
    $data["ac"] = $records_count;
    $data["cc"] = $returns["segment"];
    $data["result"] = $this->base_model->getStrange($returns["page"],$returns["segment"]);
    $this->loadViews("getStrange",$this->global,$data,NULL);
  }

}
?>
