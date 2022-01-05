<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Base_model extends CI_Model
{


    
    function plusValue($database,$field,$value,$val_array,$type,$filter=true){
        $this->db->set($field, $field.$type.$value, FALSE);
        foreach($val_array as $v):
            if($filter ==true)
                $this->db->where($v[0],$v[1]);
            else
                $this->db->where_in($v[0],$v[1]);
        endforeach;
        $this->db->update($database);
    }

    function updateDataById($id,$data,$database,$record){
        if(is_array($id))
            $this->db->where_in($record, $id);
        else
            $this->db->where($record, $id);
        $this->db->update($database, $data);
        return $this->db->affected_rows();
    }

    function deleteRecordsById($database,$id){
        $this->db->where('delivery_id', $id);
        $this->db->delete($database);
    }

    function deleteRecordCustom($database,$record,$id,$type = false){
        if($type ==false)
            $this->db->where($record, $id);
        else
          $this->db->where_in($record, $id);
        $this->db->delete($database);
    }

    function updatePostMail($id,$content){
        $this->db->where("type", $id);
        $this->db->where("anyone", 1);
        $this->db->update("tbl_mail", array("content"=>$content,"updated_date"=>date('H:i:s', strtotime("2010-01-01"))));
        return $this->db->affected_rows();
    }

    function getSelect($database,$array1=null,$array2=null,$array3=null,$array4=null,$array5=null,$array6=null){
        $this->db->select('*');
        $this->db->from($database);
        if($array1 !=null)
            foreach($array1 as $value){
                if(is_array($value["value"]))
                    $this->db->where_in($value['record'], $value['value'][0],"both");
                else
                    $this->db->where($value['record'], $value['value']);

            }
        if($array2 !=null)
            foreach($array2 as $value1){
                if($value1['record']!="") $this->db->order_by($value1['record'], $value1['value']);
            }
        if($array3 !=null)
            foreach($array3 as $value2){
                if($value2['record']!="") $this->db->group_by($value2['record']);
            }
        if($array4 !=null)
            foreach($array4 as $value3){
                if($value3['record']!="") $this->db->limit($value3['record'], $value3['value']);
            }
        if($array5 !=null)
            foreach($array5 as $value){
                $this->db->like($value['record'], $value['value'],"both");
            }
        if($array6 !=null)
            foreach($array6 as $value){
                $this->db->where_in($value['record'], $value['value'],"both");
            }
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function insertArrayData($database,$data){
        $this->db->insert($database,$data);
        return $this->db->insert_id();
    }

    public function getAll($database){
        $this->db->select('*');
        $this->db->from($database);
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    function getStepDeliveryTop()
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_step_title as BaseTbl');
        $this->db->order_by('BaseTbl.step','asc');
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }
    function getdelivery($id)
    {
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_steps as BaseTbl');
        $this->db->where('type',$id);
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    function getStepDelivery(){
        $topCategory = $this->getStepDeliveryTop();
        $details_category = array();
        foreach ($topCategory as $key => $value) {
            $details_category[$value->step] = $this->getdelivery($value->step);
        }
        return $details_category;
    }

    function getDeliveryAddress($no=1){
        $this->db->select('BaseTbl.*');
        $this->db->from('delivery_address as BaseTbl');
        if($no==1) $this->db->where('use',1);
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    function getTrackingHeader(){
        $this->db->select('BaseTbl.*');
        $this->db->from('tracking_header as BaseTbl');
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    function insertPurchase($post,$id,$ordernum=null,$pid = null){

        $serial = 0;
        foreach ($post as $key => $value) {
            $post_data = array( "delivery_id"=>$id,
                                "trackingHeader"=>$value[0],
                                "trackingNumber"=>$value[1],
                                "order_number"=>$value[2],
                                "parent_category"=>$value[3],
                                "category"=>$value[4],
                                "productName"=>$value[5],
                                "unitPrice"=>$value[6],
                                "count"=>$value[7],
                                "color"=>$value[8],
                                "size"=>$value[9],
                                "url"=>$value[10],
                                "image"=>$value[11],
                                "step"=>!empty($value[12]) ? $value[12]:0,
                                "created_date"=>date("Y-m-d H:i:s"));
            if(!empty($value[13]) &&  $value[13] > 0){
                $this->updateDataById($value[13],$post_data,"tbl_purchasedproduct","id");
                if($pid !=null && sizeof($pid) > 0){
                    if (($key = array_search($value[13], $pid)) !== false) {
                        unset($pid[$key]);
                    }
                }

            }
            else
            {
                $serial = $serial + 1;
                $post_data["serial"] = $ordernum."-".$serial;
                $this->db->insert('tbl_purchasedproduct',$post_data);
            }

        }

        if(sizeof($pid) > 0){
            $this->deleteRecordCustom('tbl_purchasedproduct',"id",$pid,false);
        }
    }


    function getDeliverContent( $limit1=0,
                                $limit2=0,
                                $delivery_id=null,
                                $step=null,
                                $step1=null,
                                $step2=null,
                                $step3=null,
                                $step4=null,
                                $step5=null,
                                $step6=null,
                                $step7=null,
                                $step8=null,
                                $step9=null,
                                $step10=null,
                                $step11=null,
                                $step12=null,
                                $step13=null,
                                $step14=null,
                                $step15=null,
                                $step16=null,
                                $in = null){

        $this->db->select(  'BaseTbl.*,
                            count(Pproduct.id) as pcount,
                            DeliverAddress.area_name,
                            Method.name as method,
                            DeliverAddress.phoneNum,
                            DeliverAddress.address as Daddress,
                            DeliverAddress.id as addid,
                            GROUP_CONCAT(Pproduct.order_number ORDER BY Pproduct.order_number DESC SEPARATOR ",") as order_number,
                            Pproduct.trackingHeader,
                            GROUP_CONCAT( DISTINCT CONCAT(Pproduct.trackingHeader," | ",Pproduct.trackingNumber)  ORDER BY Pproduct.trackingNumber  DESC SEPARATOR ",") as  trackingNumber,
                            Step.name as sname,
                            SUM(Pproduct.unitPrice*Pproduct.count) as pprice,
                            Role.buy_fee,
                            Role.address_rate,
                            Role.sending_inul,
                            User.name as Uname,
                            User.deposit,
                            User.sase,
                            User.userId,
                            DC.comment as Dcomment,
                            DC.use as Duse,
                            SD.content,
                            AP.add_check,
                            AP.add_price,
                            AP.gwan as agwan,
                            AP.pegi as apegi,
                            AP.cart_bunhal as acart_bunhal,
                            AP.check_custom as acheck_custom,
                            AP.gwatae as agwatae,
                            AP.accurate as aaccurate,
                            AP.v_weight,
                            AP.add_fee');
        $this->db->from('delivery as BaseTbl');
        if($delivery_id!=null){
            $this->db->where('BaseTbl.id',$delivery_id);
        }
        if($step!=null && $step!="" && $step !=12){
            $this->db->where('BaseTbl.state',$step);

        }
        if($step ==12) {
            $this->db->where("Pproduct.step",102);
            $this->db->where("BaseTbl.state !=",13);
            $this->db->where("BaseTbl.state !=",17);
            $this->db->where("BaseTbl.state !=",18);
            $this->db->where("BaseTbl.state !=",19);
            $this->db->where("BaseTbl.state !=",20);
            $this->db->where("BaseTbl.state !=",21);
            $this->db->where("BaseTbl.state !=",24);
        }
        $this->db->join('delivery_address as DeliverAddress', 'DeliverAddress.id = BaseTbl.place','left');
        $this->db->join('tbl_sendmethod as Method', 'Method.id = BaseTbl.incoming_method','left');
        $this->db->join('tbl_purchasedproduct as Pproduct', 'Pproduct.delivery_id = BaseTbl.id');
        $this->db->join('tbl_steps as Step', 'Step.step = BaseTbl.state');
        $this->db->join('tbl_users as User', 'User.userId = BaseTbl.userId');
        $this->db->join('tbl_roles as Role', 'Role.roleId = User.roleId');
        $this->db->join('tbl_delivery_comment as DC', 'DC.delivery_id = BaseTbl.id','left');
        $this->db->join('tbl_add_price as AP', 'AP.id = BaseTbl.id','left');
        $this->db->join('tbl_service_delivery as SD', 'SD.delivery_id = BaseTbl.id','left');
        if($step9 !=null &&  $step9 !="") $this->db->like('BaseTbl.billing_krname',$step9,'both');
        if($step6 !=null && $step6 !="" && $step6 !=12) $this->db->where('Step.step',$step6);
        if($step6 ==12) $this->db->where("Pproduct.step",102);
        if($step4 !=null && $step4 !="") $this->db->where('BaseTbl.created_date >=', $step4);
        if($step5 !=null && $step5 !="") $this->db->where('BaseTbl.created_date <',
        date('Y-m-d', strtotime('+1 day', strtotime($step5))));
        if($step2 !=null && $step2 !="") $this->db->where('Pproduct.step',103);
        if($step1 !=null && $step1 !="") $this->db->where('Pproduct.step',30);
        if($step7 !=null && $step7 !="") $this->db->where('BaseTbl.type',$step7);
        if($step8 !=null && $step8 !="") $this->db->like('User.sase',$step8,'both');
        if($step10 !=null && $step10 !="") $this->db->like('User.name',$step10,'both');
        if($step11 !=null && $step11 !="") $this->db->where('User.loginId',$step11);
        if($step14 !=null && $step14 !=""){
            $this->db->group_start();
            $step14 = explode(",",$step14);
            $likeorder = "";
            foreach ($step14 as $key => $chd_ss) {
                if(trim($chd_ss) == "") continue;
                $this->db->or_like('BaseTbl.ordernum',trim($chd_ss),"both");
            }
            $this->db->group_end();
        }
        if($step12 !=null && $step12 !="") $this->db->like('Pproduct.productName',$step12);
        if($step13 !=null && $step13 !="") $this->db->like('Pproduct.order_number',$step13);
        if($step15 !=null && $step15 !="") $this->db->where('BaseTbl.tracking_number',$step15);
        if($step16 !=null && $step16 !="") $this->db->where('Pproduct.trackingNumber',$step16);
        if($in !=null && $in!=3){
            $this->db->where('Pproduct.step',101);
        }
        if($in !=null && $in==3){
            $this->db->where('Pproduct.step = 101 OR Pproduct.step = 102');
        }
        $this->db->order_by("BaseTbl.updated_date","DESC");
        $this->db->group_by("BaseTbl.id");
        if($limit1 ==0 && $limit2==0){}
        else{$this->db->limit($limit1,$limit2);}
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    function getProdcuts($id){

        $this->db->select(' BaseTbl.*,
                            BaseTbl.trackingHeader as hname,
                            (BaseTbl.unitPrice*BaseTbl.count) as pprice,
                            Steps.name as Sname,
                            Delivery.state as Dstate,
                            SUBSTRING_INDEX(BaseTbl.serial,"-",1) as ind_head,
                            SUBSTRING_INDEX(BaseTbl.serial,"-",-1) as ind');
        $this->db->from('tbl_purchasedproduct as BaseTbl');
        $this->db->join('tbl_steps as Steps', 'Steps.step = BaseTbl.step');
        $this->db->join('delivery as Delivery', 'Delivery.id = BaseTbl.delivery_id');
        $this->db->where('delivery_id',$id);
        $this->db->order_by('CAST(ind_head AS UNSIGNED)',"ASC");
        $this->db->order_by('CAST(ind AS UNSIGNED)',"ASC");
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    function getPState(){

        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_steps as BaseTbl');
        $this->db->where('BaseTbl.type',0);
        $this->db->order_by('BaseTbl.step','ASC');
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    function updateProdcutStep($id,$step){

        $this->db->where('id', $id);
        $this->db->update('tbl_purchasedproduct', array("step"=>intval($step)));
    }

    function updateDelivery($id,$deliver){
        $this->db->where('id', $id);
        $this->db->update('delivery', array("state"=>intval($deliver),"updated_date"=>date('Y-m-d H:i:s')));
    }

    function checkSendingPay($ids){

        $this->db->select('BaseTbl.*');
        $this->db->from('delivery as BaseTbl');
        $this->db->where('BaseTbl.id IN ',"(".implode(",",$ids).")",false);
        $query = $this->db->get();
        $results = $query->result();
        if(empty($results))
            return 0;
        foreach($results as $value){
            if($value->sending_price <=0)
                return 0;
        }

        return 1;
    }

    function getCustomFee(){

        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_shipping_fee as BaseTbl');
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    function getNoticeExchange(){
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_notice_exchange_rate as BaseTbl');
        $this->db->order_by('updated_date',"DESC");
        $this->db->limit(1,0);
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getStateCount(){
        $query=$this->db->query("SELECT
                                  A.state,
                                  COUNT(A.id) AS stateCount
                                FROM
                                  (SELECT
                                    delivery.*
                                  FROM
                                    `delivery`
                                    JOIN tbl_purchasedproduct
                                      ON tbl_purchasedproduct.`delivery_id` = delivery.`id`
                                    JOIN tbl_users
                                      ON tbl_users.`userId` = delivery.`userId`
                                  GROUP BY tbl_purchasedproduct.`delivery_id`) A
                                GROUP BY A.state ");
        $results = $query->result();
        return $results;
    }
    public function getErrorProductsCount(){
        $this->db->select("Delivery.id");
        $this->db->from("delivery as Delivery");
        $this->db->join("tbl_purchasedproduct as Product","Product.delivery_id=Delivery.id");
        $this->db->where("Product.step",102);
        $this->db->where("Delivery.state !=",13);
        $this->db->where("Delivery.state !=",17);
        $this->db->where("Delivery.state !=",18);
        $this->db->where("Delivery.state !=",19);
        $this->db->where("Delivery.state !=",20);
        $this->db->where("Delivery.state !=",21);
        $this->db->where("Delivery.state !=",24);
        $this->db->group_by("Product.delivery_id");
        $query = $this->db->get();
        $results = $query->result();
        return sizeof($results);
    }

    public function getStepAll(){
        $this->db->select("BaseTbl.*,Title.title");
        $this->db->from("tbl_steps as BaseTbl");
        $this->db->join("tbl_step_title as Title","Title.step=BaseTbl.type","Right");
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getProductsAll(
                                    $limit1=0,
                                    $limit2=0,
                                    $step1=null,
                                    $step2=null,
                                    $step3=null,
                                    $step4=null,
                                    $step5=null,
                                    $step6=null,
                                    $step7=null,
                                    $step8=null,
                                    $step9=null,
                                    $step10=null,
                                    $step11=null,
                                    $step12=null){
        $this->db->select('BaseTbl.*,User.name,Delivery.get,Step.name as sName,Step1.name as InS,Delivery.ordernum,User.deposit,User.userId');
        $this->db->from('tbl_purchasedproduct as BaseTbl');
        $this->db->join('delivery as Delivery','Delivery.id=BaseTbl.delivery_id');
        $this->db->join('tbl_users as User','User.userId=Delivery.userId');
        $this->db->join('tbl_steps as Step','Step.step=Delivery.state');
        $this->db->join('tbl_steps as Step1','Step1.step=BaseTbl.step');
        if($step1 !=null && $step1 !="") $this->db->where('BaseTbl.created_date >=',$step1);
        if($step2 !=null && $step2 !="") $this->db->where('BaseTbl.created_date <=',$step2);
        if($step3 !=null && $step3 =="1") $this->db->where('BaseTbl.trackingNumber',"");
        if($step3 !=null && $step3 =="2") $this->db->where('BaseTbl.trackingNumber !=',"");
        if($step4 !=null && $step4 !="") $this->db->where('Delivery.get',$step4);
        if($step5 !=null && $step5 !="") $this->db->where('User.nickname',$step5);
        if($step6 !=null && $step6 !="") $this->db->like('Delivery.billing_name',$step6,'both');
        if($step7 !=null && $step7 !="") $this->db->like('User.name',$step7,'both');
        if($step8 !=null && $step8 !="") $this->db->where('User.loginId',$step8);
        if($step9 !=null && $step9 !="") $this->db->where('BaseTbl.productName',$step9);
        if($step10 !=null && $step10 !="") $this->db->where('BaseTbl.order_number',$step10);
        if($step11 !=null && $step11 !="") $this->db->where('Delivery.id',$step11);
        if($step12 !=null && $step12 !="") $this->db->where('BaseTbl.trackingNumber',$step12);
        $this->db->order_by('BaseTbl.created_date','desc');
        if($limit1 ==0 && $limit2 ==0){}
        else{$this->db->limit($limit1,$limit2);}
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getPayHistory($limit1=10,$limit2=0,$accept=null,$v1=null,$v2=null,$v3=null,$v4=null,$v5=null,$v6=null,$v7=null,$id=null){
        $con = "";
        $con1="";
        $con2="";
        $con3="";
        $con4="";
        $con5="";
        $con6="";
        $ids ="";

        if($accept !=null) $con = "and BaseTbl.pending=".$accept;
        if($v5 !=null) $con = "and BaseTbl.pending=".$v5;
        if($id !=null) $ids = "and BaseTbl.delivery_id=".$id;
        if($v1 !=null) $con1 = "and BaseTbl.payed_type=".$v1;
        if($v2 !=null) $con2 = "and Delivery.get='".$v2."'";
        if($v3 !=null) $con3 = "and BaseTbl.updated_date >='".$v3."'";
        if($v4 !=null) $con4 = "and BaseTbl.updated_date <='".$v4."'";
        if($v7 !=null) $con6 = "and Users.".$v6."='".$v7."'";

        if($limit2==null) $limit2=0;
        $query = $this->db->query("
                                    SELECT
                                        Users.userId,
                                        BaseTbl.*,
                                        Users.name,
                                        Users.loginId,
                                        Delivery.ordernum AS OrdNum,
                                        Delivery.sending_price,
                                        Users.deposit,
                                        Users.point,
                                        Delivery.sending_price,
                                        Delivery.return_price,
                                        Delivery.purchase_price,
                                        Delivery.get,
                                        Delivery.state,
                                        AP.add_price,
                                        BaseTbl.point AS bpoint
                                    FROM
                                        tbl_payhistory AS BaseTbl
                                        LEFT JOIN delivery AS Delivery
                                            ON Delivery.id = BaseTbl.delivery_id
                                        LEFT JOIN tbl_add_price AS AP
                                            ON AP.id = Delivery.id
                                        JOIN tbl_users AS Users
                                            ON Users.userId = Delivery.userId
                                    WHERE BaseTbl.security IN
                                        (SELECT A.*
                                        FROM
                                        (SELECT BaseTbl.security
                                        FROM
                                            tbl_payhistory AS BaseTbl
                                            JOIN tbl_users AS Users
                                                ON Users.userId = BaseTbl.userId
                                            LEFT JOIN delivery AS Delivery
                                                ON Delivery.id = BaseTbl.delivery_id
                                        WHERE TRUE " .$ids." " .$con. " " .$con1. " " .$con2. " " .$con3. " " .$con4. " " .$con6. "
                                        GROUP BY BaseTbl.security
                                        ORDER BY BaseTbl.updated_date DESC) AS A)
                                    ORDER BY BaseTbl.updated_date DESC,
                                        BaseTbl.security DESC
                                    LIMIT ".$limit2.", ".$limit1);
        return $query->result();
    }

    public function getPayedProducts($accept=null,$v1=null,$v2=null,$v3=null,$v4=null,$v5=null,$v6=null,$v7=null){
         $con = "";
        if($accept !=null) $con = "and pending=".$accept;
        $con1="";
        $con2="";
        $con3="";
        $con4="";
        $con5="";
        $con6="";
        if($v1 !=null) $con1 = "and BaseTbl.payed_type=".$v1;
        if($v2 !=null) $con2 = "and Delivery.get='".$v2."'";
        if($v3 !=null) $con3 = "and BaseTbl.updated_date >='".$v3."'";
        if($v4 !=null) $con4 = "and BaseTbl.updated_date <='".$v4."'";
        if($v5 !=null) $con5 = "and BaseTbl.pending=".$v5;
        if($v7 !=null) $con6 = "and Users.".$v6."='".$v7."'";
        $query = $this->db->query("SELECT A.* from (SELECT BaseTbl.security FROM tbl_payhistory as BaseTbl JOIN tbl_users as Users ON Users.userId=BaseTbl.userId JOIN delivery as Delivery ON Delivery.id=BaseTbl.delivery_id WHERE TRUE" .$con. " " .$con1. " " .$con2. " " .$con3. " " .$con4. " " .$con5. " " .$con6. "  group by BaseTbl.security ORDER BY BaseTbl.payed_date DESC) as A");
        return sizeof($query->result());
    }

    public function getNodata($limit = ""){
        $this->db->select("BaseTbl.*");
        $this->db->from("tbl_purchasedproduct as BaseTbl");
        $this->db->where("BaseTbl.step",103);
        $this->db->order_by("created_date","DESC");
        if($limit !="") $this->db->limit($limit,0);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getGroupProdcuts($limit1=0,$limit2=2,$step1,$step2,$step3){
        $this->db->select("BaseTbl.*");
        $this->db->from("tbl_prodcucts as BaseTbl");
        $this->db->where("BaseTbl.use",1);
        if($step1 !=null && $step1 !="") $this->db->where('BaseTbl.use',$step1);
        if($step2 !=null && $step2 !="") $this->db->like('BaseTbl.name',$step2);
        if($step3 !=null && $step3 !="") $this->db->like('BaseTbl.brand',$step3);
        $this->db->order_by("BaseTbl.updated_date","DESC");
        if($limit1 ==0 && $limit2==0){}
        else {$this->db->limit($limit1,$limit2);}
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getProdcutPublic($id){
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_prodcucts as BaseTbl');
        $this->db->where('id',$id);
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function insertProductPublic($id,$data){
        if($id !=''){
            $this->db->where("id", $id);
            $this->db->update("tbl_prodcucts", $data);
            return $this->db->affected_rows();
        }
        else{
            $this->db->insert('tbl_prodcucts',$data);
            return $this->db->insert_id();
        }
    }

    public function getReq($id,$limit1=10,$limit2=0,$category=null,$item=null,$content=null,$mode=null){
        $this->db->select('BaseTbl.*,User.name as UserName,COUNT(Comment.id) as comment_count,User.deposit,User.userId');
        $this->db->from('tbl_mail as BaseTbl');
        $this->db->join("tbl_users as User","User.userId=BaseTbl.fromId");
        $this->db->join("tbl_comment as Comment","Comment.postId=BaseTbl.id","left");
        $this->db->where('BaseTbl.type',$id);
        if($mode !=null && $mode !="" && $mode!="total") $this->db->where('BaseTbl.mode',$mode);
        if($category !=null && $category !="" && $category!="total") $this->db->where('BaseTbl.category',$category);
        if($content !=null && $content !=""){
            if($item == "username")
                $this->db->like('User.name',$content,"both");
            else
                $this->db->like('BaseTbl.'.$item,$content,"both");
        }
        $this->db->order_by('BaseTbl.updated_date','DESC');
        if($limit1 ==null)  $this->db->limit(20,0);
        else $this->db->limit($limit1,$limit2);
        $this->db->group_by("BaseTbl.id");
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getPendingPrivateMessageCount($id){
        $this->db->where('type', $id);
        $this->db->where("mode","답변중");
        $this->db->from('tbl_mail');
        return $this->db->count_all_results();
    }

    public function getReqById($id){
        $this->db->select(' BaseTbl.*,
                            User.name as UserName,
                            Board.category_use,
                            Board.category as bcategory,
                            Board.state_use as bstate_use,
                            Board.state as bstate,
                            Board.title as btitle,
                            Board.file_size,
                            Board.download_use,
                            Board.id as bid');
        $this->db->from('tbl_mail as BaseTbl');
        $this->db->join("tbl_users as User","User.userId=BaseTbl.fromId","left");
        $this->db->join("tbl_board as Board","Board.id=BaseTbl.type");
        $this->db->where('BaseTbl.id',$id);
        $this->db->order_by('BaseTbl.updated_date','DESC');
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getBank(){
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_bank as BaseTbl');
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function updateBank($id,$data){
        if($id > 0) {
            $this->db->where("id", $id);
            $this->db->update("tbl_bank", $data);
            return $this->db->affected_rows();
        }
        else{
           $this->db->insert('tbl_bank',$data);
            return $this->db->insert_id();
        }
    }

    public function getCompany(){
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_smart_setup as BaseTbl');
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function updateCompany($id,$data){
        if($id > 0) {
            $this->db->where("id", $id);
            $this->db->update("tbl_smart_setup", $data);
            return $this->db->affected_rows();
        }
        else{
           $this->db->insert('tbl_smart_setup',$data);
            return $this->db->insert_id();
        }
    }

    public function getAccurRate(){
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_accurrate as BaseTbl');
        $this->db->order_by('created_date',"DESC");
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getCustomExrate(){
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_custom_exchange_rate as BaseTbl');
        $this->db->order_by('created_date',"DESC");
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getDeliveryFee(){

        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_shipping_fee as BaseTbl');
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getCategory($id,$limit1=10,$limit2=0){
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_category as BaseTbl');
        $this->db->where("BaseTbl.parent",$id);
        $this->db->order_by("BaseTbl.orders","ASC");
        if($limit1 !=null) $this->db->limit($limit1,$limit2);
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getChildCat($id=0,$limit1=10,$limit2=0){
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_category as BaseTbl');
        if($id !=0) $this->db->where("BaseTbl.id",$id);
        else{
            $this->db->where("BaseTbl.parent !=",0);
            $this->db->where("BaseTbl.use",1);
        }
        if($limit1 !=null) $this->db->limit($limit1,$limit2);
        $this->db->order_by("BaseTbl.orders","ASC");
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getDeliveryContents($id){
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_deliverytable as BaseTbl');
        $this->db->where("BaseTbl.address",$id);
        $this->db->order_by("BaseTbl.startWeight","ASC");
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getDtable(){

        $this->db->select('BaseTbl.*,Delivery.area_name');
        $this->db->from('tbl_deliverytable as BaseTbl');
        $this->db->join("delivery_address as Delivery","Delivery.id=BaseTbl.address");
         $this->db->order_by("BaseTbl.address","ASC");
        $this->db->order_by("BaseTbl.startWeight","ASC");
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getRoleByMember($c="yes",$admin="yes"){
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_roles as BaseTbl');
        if($admin =="yes") $this->db->where("BaseTbl.type !=",0);
        if($c=="yes")  $this->db->where("BaseTbl.use",1);
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getShoppingMal(){
        $this->db->trans_start();
        $this->db->select("*");
        $this->db->from("tbl_shopping");
        $this->db->order_by("updated_date","DESC");
        $query = $this->db->get();
        $this->db->trans_complete();
        $results = $query->result();
        return $results;
    }

    public function getMemberByType($type,$data,$le=null){

        $this->db->select(' tbl_users.email,
                            tbl_users.name,
                            tbl_users.loginId,
                            tbl_users.userId,
                            tbl_users.nickname,
                            tbl_roles.role,
                            tbl_users.mobile,
                            tbl_users.deposit');
        $this->db->from('tbl_users');
        $this->db->join('tbl_roles','tbl_roles.roleId=tbl_users.roleId');
        if($le==null){
            $this->db->like("tbl_users.".$type,$data);
            $this->db->where('tbl_users.roleId!=',1);
            $this->db->where('tbl_users.roleId!=',2);
        }
        else $this->db->where("tbl_users.roleId",$le);
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getCoupon($id){
        $this->db->select("BaseTbl.*,Type.content as tcontent");
        $this->db->from('tbl_coupon as BaseTbl');
        $this->db->join('tbl_coupon_type as Type','Type.id=BaseTbl.coupon_type');
        $this->db->where("BaseTbl.event",$id);
         $this->db->where("BaseTbl.is_deleted",0);
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getCouponList($limit1=10,$limit2=0,$v1=null,$v2=null,$v3=null,$v4=null,$v5=null){
        if($limit2 ==null) $limit2=0;
        $this->db->select("BaseTbl.*,User.nickname,User.loginId,Coupon.gold,Coupon.gold_type,Coupon.terms,Coupon.event,Coupon.send,Coupon.event_coupon,Coupon.use_terms,Type.content");
        $this->db->from('tbl_coupon_user as BaseTbl');
        $this->db->join('tbl_users as User','User.userId = BaseTbl.userId');
        $this->db->join("tbl_coupon as Coupon","Coupon.id=BaseTbl.coupon_id");
        $this->db->join("tbl_coupon_type as Type","Type.id=Coupon.coupon_type");
        if($v1 !=null) $this->db->where("Coupon.created_date >=",$v1);
        if($v2 !=null) $this->db->where("Coupon.created_date <",$v2);
        if($v4 !=null)
        {
            if($v4 =="code") $this->db->where("Coupon.code",$v5);
            if($v4 =="name") $this->db->like("User.name",$v5);
        }
        if($v3=="N"){
              $this->db->where("BaseTbl.used",0);
        }
        if($v3=="Y"){
              $this->db->where("BaseTbl.used",1);
        }
        if($limit1 !=null) $this->db->limit($limit1,$limit2);
        $this->db->order_by("BaseTbl.created_date","DESC");
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function deleteCoupon($value){
        $this->db->where('id', $value);
        $this->db->delete('tbl_coupon_user');
    }

    public function getMail($type,$limit1=0,$limit2=0,$st=null,$et=null,$shType=null,$content=null){
        $this->db->select("BaseTbl.*,User.name,User.loginId");
        $this->db->from('tbl_mail as BaseTbl');
        $this->db->join('tbl_users as User','BaseTbl.toId = User.userId');
        $this->db->where("BaseTbl.type",$type);
        if($st !=null) $this->db->where('BaseTbl.updated_date >=',$st);
        if($et !=null) $this->db->where('BaseTbl.updated_date <=',$et);
        if($content !=null) {

            switch ($shType) {
                case 'B':
                    # code...
                    $this->db->like("User.name",$content,"both");
                    break;
                case 'E':
                    # code...
                    $this->db->like("BaseTbl.title",$content,"both");
                    break;
                case 'A':
                    # code...
                    $this->db->like("User.loginId",$content,"both");
                    break;
                case 'D':
                    # code...
                    $this->db->like("User.nickname",$content,"both");
                    break;

                default:
                    # code...
                    break;
            }
        }
        if($limit1 ==0 && $limit2 ==0) {}
        else {$this->db->limit($limit1,$limit2);}
        $this->db->order_by("BaseTbl.updated_date","DESC");
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getMessage($id){
        $this->db->select('BaseTbl.*');
        $this->db->from('tbl_mail as BaseTbl');
        $this->db->where('BaseTbl.id',$id);
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getPayMode($id){
        $query  = $this->db->query("SELECT Q1.A,Q2.B,Q3.C,Q4.D,Q6.F, Q5.E as Count,Q1.AA,Q2.BB,Q3.CC,Q4.DD,Q6.FF FROM
                                    (SELECT SUM(REPLACE(Delivery.`sending_price`,\",\",\"\"))  A,COUNT(Delivery.id) as AA FROM delivery AS Delivery WHERE Delivery.`payed_send` > 0 AND Delivery.`type`=1 ) Q1 ,
                                    (SELECT SUM(Delivery.`purchase_price`)  B,COUNT(Delivery.id) as BB FROM delivery AS Delivery WHERE Delivery.`payed_checked` > 0  AND Delivery.`type`=2 ) Q2,
                                    (SELECT SUM(Delivery.`return_price`)  C,COUNT(Delivery.id) as CC FROM delivery AS Delivery WHERE Delivery.`return_check` > 0  AND Delivery.`type`=4 ) Q3 ,
                                    (SELECT SUM(Delivery.`purchase_price`)  F,COUNT(Delivery.id) as FF FROM delivery AS Delivery WHERE Delivery.`payed_checked` > 0  AND Delivery.`type`=3 ) Q6 ,
                                    (SELECT SUM(AP.`add_price`)  D,COUNT(Delivery.id) as DD FROM `delivery` AS `Delivery` LEFT JOIN `tbl_add_price` AS `AP` ON `AP`.`id`=`Delivery`.`id` WHERE AP.`add_check` > 0  AND Delivery.`type`=".$id.") Q4,(SELECT COUNT(Delivery.`id`)  E FROM delivery AS Delivery  WHERE  Delivery.`type`=".$id.") Q5 ");
        $results = $query->result();
        return  $results;
    }

    public function getPay($limit1=0,$limit2=0,$st=null,$et=null){
        $this->db->select(' BaseTbl.*,
                            Delivery.billing_krname,
                            User.name,
                            SUM(BaseTbl.all_amount) as Amount,
                            SUM(Product.unitPrice*Product.count) as PSum,
                            COUNT(Product.id) as Pcount,
                            Delivery.updated_date as Udate,
                            Delivery.ordernum,
                            Delivery.tracking_number,
                            Delivery.combine,
                            Delivery.id as did,
                            Delivery.sending_price,
                            Delivery.payed_send,
                            Delivery.purchase_price,
                            Delivery.payed_checked,
                            Delivery.return_price,
                            Delivery.return_check,
                            AP.add_price,
                            AP.add_check,
                            Delivery.type as dtype');
        $this->db->from('tbl_payhistory as BaseTbl');
        $this->db->join('delivery as Delivery','Delivery.id=BaseTbl.delivery_id');
        $this->db->join('tbl_users as User','User.userId=Delivery.userId');
        $this->db->join('tbl_add_price as AP','AP.id=Delivery.id',"left");
        $this->db->join('tbl_purchasedproduct as Product','Product.delivery_id=Delivery.id');
        $this->db->where('BaseTbl.pending',0);
        if($st !=null) $this->db->where('BaseTbl.payed_date >=',$st);
        if($et !=null){
            $et = date('Y-m-d', strtotime('+1 day', strtotime($et)));
            $this->db->where('BaseTbl.payed_date <',$et);
        }
        $this->db->order_by('BaseTbl.payed_date',"DESC");
        $this->db->group_by("BaseTbl.delivery_id");
        if($limit1 ==0  && $limit2==0){}
        else{$this->db->limit($limit1,$limit2);}
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getMemberPay($limit1=0,$limit2=0,$st=null,$et=null,$item=null,$content=null){
        $limit="";
        $where = "";
        if($limit1!=null && $limit2!=null && $limit2!="" && $limit1!="") $limit="limit ".$limit2.",".$limit1;
        if($st !=null) $where.=" and BaseTbl.payed_date >='".$st."'";
        if($et !=null) $where.=" and BaseTbl.payed_date <='".$et."'";
        if($content !=null) $where.=" and User.".$item."='".$content."'";
        $query = $this->db->query("
            SELECT a.userId,a.deposit,a.name,COUNT(a.SUM11) as count1,COUNT(a.SUM22) as count2,COUNT(a.SUM33) as count3,COUNT(a.SUM44) as count4,SUM(a.SUM11) as SUM1,SUM(a.SUM22) as SUM2,SUM(a.SUM33) as SUM3,SUM(a.SUM44) as SUM4 from (SELECT `User`.`userId`, `User`.`deposit`, `User`.`name` ,CASE WHEN Delivery.type=1 THEN BaseTbl.all_amount END AS SUM11, CASE WHEN Delivery.type=2 THEN BaseTbl.all_amount END AS SUM22, CASE WHEN Delivery.type=4 THEN BaseTbl.all_amount END AS SUM33, CASE WHEN Delivery.type=3 THEN BaseTbl.all_amount END AS SUM44 FROM `tbl_payhistory` as `BaseTbl` JOIN `delivery` as `Delivery` ON `Delivery`.`id`=`BaseTbl`.`delivery_id` JOIN `tbl_users` as `User` ON `User`.`userId`=`Delivery`.`userId` WHERE `BaseTbl`.`pending` =0 ".$where." GROUP BY `BaseTbl`.`security`) a group by a.userId ".$limit);
        $results = $query->result();
        return  $results;
    }

    public function getPointUsers(){
        $this->db->select('BaseTbl.*,Point.terms,Point.point,Point.type as Pstate,User.name,User.loginId');
        $this->db->from('tbl_point_users as BaseTbl');
        $this->db->join('tbl_point as Point','Point.id=BaseTbl.point_id');
        $this->db->join('tbl_users as User','User.userId=BaseTbl.userId');
        $this->db->order_by("BaseTbl.created_date","DESC");
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }
    public function deletePointUser($id){
        $this->db->where('id', $id);
        $this->db->delete('tbl_point_users');
    }

    public function getDepositByUserId($limit1=10,$limit2=0,$v1=null,$v2=null,$v3=null,$v4=null,$v5=null){
        $this->db->select(' BaseTbl.*,
                            User.name as Uname,
                            User.loginId,
                            User.nickname,
                            PayC.name as Bname,
                            PayC.bank ,
                            PayC.number,
                            User.userId');
        $this->db->from('tbl_request_deposit as BaseTbl');
        $this->db->join('tbl_users as User','User.userId=BaseTbl.userId');
        $this->db->join('tbl_bank as PayC','PayC.id=BaseTbl.payAccount');
        if($v1!=null) $this->db->where("BaseTbl.update_date >=",$v1);
        if($v2!=null) $this->db->where("BaseTbl.update_date <=",$v2);
        if($v3!=null) $this->db->where("BaseTbl.updated",$v3);
        if($v5!=null && $v4!=null && $v4!="loginId1") $this->db->like("User.".$v4,$v5,"both");
        if($v5!=null && $v4!=null && $v4=="loginId") $this->db->where("User.".$v4,$v5);
        $this->db->order_by("BaseTbl.update_date","DESC");
        if($limit1!=null) $this->db->limit($limit1,$limit2);
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function updateDeposit($id,$state){
        $this->db->where("id", $id);
        $this->db->update("tbl_request_deposit", array("updated"=>$state));
        return $this->db->affected_rows();
    }

    public function getAmountD($id){
        $this->db->select('*');
        $this->db->from('tbl_request_deposit');
        $this->db->where('id',$id);
        $query = $this->db->get();
        $results = $query->result();
        return$results;
    }

    public function increaseAmount($results){
        $this->db->where('userId',$results[0]->userId);
        $this->db->set('deposit', 'deposit+'.$results[0]->amount, FALSE);
        $this->db->update('tbl_users');
    }

    public function getFDevliery($id){
        $this->db->select('BaseTbl.*,DliveryAddress.id as Did,Sends.id as Sid,SUM(Product.count) as ProCount,SUM(Product.unitPrice*Product.count) as ProSum,DliveryAddress.area_name,Sends.name as Sname,Part.content');
        $this->db->from('delivery as BaseTbl');
        $this->db->join("delivery_address as DliveryAddress","DliveryAddress.id=BaseTbl.place",'left');
        $this->db->join("tbl_sendmethod as Sends ","Sends.id=BaseTbl.incoming_method",'left');
        $this->db->join("tbl_purchasedproduct as Product","Product.delivery_id=BaseTbl.id","left");
        $this->db->join("tbl_service_delivery as Part","Part.delivery_id=BaseTbl.id","left");
        $this->db->group_by('BaseTbl.id');
        $this->db->where('BaseTbl.id',$id);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getProductByProductId($id,$r=1){
        $this->db->select(' BaseTbl.*,
                            BaseTbl.trackingHeader as Tname,
                            (BaseTbl.unitPrice*BaseTbl.count) as pp,
                            Category.en_subject,Category.kr_subject,
                            Category.chn_subject,
                            Delivery.ordernum,
                            Delivery1.combine,
                            Delivery.rid,
                            Delivery1.ordernum AS new_order,
                            Delivery1.rid as drid,
                            Delivery.combine as dcombine,
                            Delivery.id as did,Delivery1.id as did1,
                            Delivery1.type,
                            Delivery.type as dtype');
        $this->db->from('tbl_purchasedproduct as BaseTbl');
         $this->db->join('tbl_category as Category','Category.id=BaseTbl.category','left');
        $this->db->join('delivery as Delivery','Delivery.id=BaseTbl.old_delivery_id','left');
        $this->db->join('delivery as Delivery1','Delivery1.id=BaseTbl.delivery_id','left');
        $this->db->where("BaseTbl.delivery_id",$id);
        if($r !=1)
            $this->db->or_where("BaseTbl.old_delivery_id",$id);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }
    public function getSendAddress(){
        $this->db->select('*');
        $this->db->from('delivery_address');
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }
    public function getIncoMet(){
        $this->db->select('*');
        $this->db->from('tbl_sendmethod');
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getTrackings(){
       $this->db->select('*');
        $this->db->from('tracking_header');
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getTrackById($id){
        $this->db->select('*');
        $this->db->from('delivery');
        $this->db->where("id",$id);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getBanner(){
        $this->db->select('*');
        $this->db->from('banner');
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getbanner_s(){
        $this->db->select('*');
        $this->db->from('tbl_banner_s');
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getEvent(){
       $this->db->select('*');
        $this->db->from('tbl_event');
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getPopup(){
       $this->db->select('*');
        $this->db->from('tbl_popup');
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getReSite(){
       $this->db->select('*');
        $this->db->from('tbl_recommend_sites');
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getProductSRecommend(){
        $this->db->select('*');
        $this->db->from('tbl_recommend_products');
        $this->db->order_by('updated_date',"DESC");
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getSProducts(){
        $this->db->select('BaseTbl.*,Category.name as cname');
        $this->db->from('tbl_sproducts as BaseTbl');
        $this->db->join("tbl_category as Category","Category.id=BaseTbl.category");
        $this->db->order_by('updated_date',"DESC");
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getReturnDeposits($limit1=10,$limit2=0,$v1=null,$v2=null,$v3=null,$v4=null,$v5=null){
        $this->db->select('BaseTbl.*,User.name as Uname');
        $this->db->from('tbl_deposit_return as BaseTbl');
        $this->db->join("tbl_users as User","User.userId=BaseTbl.userId");
        if($v1!=null) $this->db->where("BaseTbl.updated_date >=",$v1);
        if($v2!=null) $this->db->where("BaseTbl.updated_date <=",$v2);
        if($v3!=null) $this->db->where("BaseTbl.accept",$v3);
        if($v5!=null && $v4!=null && $v4!="loginId") $this->db->like("User.".$v4,$v5,"both");
        if($v5!=null && $v4!=null && $v4=="loginId") $this->db->where("User.".$v4,$v5);
        $this->db->order_by('BaseTbl.updated_date',"DESC");
        $this->db->order_by('BaseTbl.updated',"ASC");
        if($limit1!=null) $this->db->limit($limit1,$limit2);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }
    public function getPayHistoryS(){
        $this->db->select(" BaseTbl.*,
                            Delivery.ordernum,
                            Users.loginId,
                            Users.name as Uname,
                            Delivery.billing_krname");
        $this->db->from("tbl_payhistory as BaseTbl");
        $this->db->join('delivery as Delivery','Delivery.id=BaseTbl.delivery_id');
        $this->db->join('tbl_users as Users','Users.userId=BaseTbl.userId');
        $this->db->order_by("BaseTbl.updated_date","DESC");
        $this->db->group_by("BaseTbl.security");
        $query =  $this->db->get();
        return $query->result();
    }

    public function getpayHistyBySecurity($security,$only = 0){
        $this->db->select("BaseTbl.*,Delivery.state,Delivery.ordernum,Delivery.purchase_price,Delivery.pur_fee");
        $this->db->from("tbl_payhistory as BaseTbl");
        $this->db->join('delivery as Delivery','Delivery.id=BaseTbl.delivery_id');
        $this->db->where("BaseTbl.security",$security);
        if($only ==1)
        {
            $this->db->group_start();
            $this->db->where("BaseTbl.type =1 OR BaseTbl.type =2 OR BaseTbl.type =3 OR BaseTbl.type =4 OR BaseTbl.type =60 OR BaseTbl.type =7");
            $this->db->group_end();
        }
        $query =  $this->db->get();
        return $query->result();
    }
    public function getDepositHistory(){
            $query = $this->db->query("SELECT A.* FROM (SELECT  amount,updated_date,tbl_payhistory.payed_type AS typess,all_amount AS plus FROM tbl_payhistory WHERE amount > 0 and payed_type!=10) AS A ORDER BY updated_date DESC ");
        return $query->result_array();
    }

    public function getDeposites($limit1=10,$limit2=0,$v1=null,$v2=null,$v3=null,$v4=null,$v5=null){
        if($limit2==null) $limit2=0;
        if($limit1==null) $m="";
        else $m = " LIMIT ".$limit2.",".$limit1;
        $con1="";
        $con2="";
        $con3="";
        $con4="";
        if($v1 !=null) $con1 = "and tbl_payhistory.updated_date >='".$v1."'";
        if($v2 !=null) $con2 =  "and tbl_payhistory.updated_date <='".$v2."'";
        if($v3 !=null) $con3 = "and tbl_payhistory.tt=".$v3."";
        if($v4 !="" &&  $v4 !=null && $v4=="loginId") $con4 = "and tbl_users.".$v4."='".$v5."'";
        if($v4 !="" && $v4 !=null && $v4!="loginId") $con4 = "and tbl_users.".$v4." LIKE '%".$v5."%'";
        $con5 = " and tbl_payhistory.type !=10";
        $query = $this->db->query("SELECT A.* FROM (SELECT tbl_payhistory.id,tbl_payhistory.by,tbl_payhistory.pending, tbl_users.name,tbl_users.loginId, tbl_payhistory.security,tbl_payhistory.amount,tbl_payhistory.updated_date,tbl_payhistory.payed_type AS typess,tbl_payhistory.amount AS plus,tbl_payhistory.tt FROM tbl_payhistory  join tbl_users on tbl_users.userId=tbl_payhistory.userId where  tbl_payhistory.amount > 0 and  tbl_users.roleId!=1 and tbl_users.roleId!=2 " .$con1. " " .$con2. " " .$con3. " " .$con4." ".$con5.  " GROUP BY tbl_payhistory.security ) AS A ORDER BY A.updated_date DESC " .$m);
         return $query->result();
    }

    public function viewPhoto($id){
        $this->db->select("BaseTbl.*,Delivery.ordernum,Delivery.billing_krname");
        $this->db->from("tbl_delivery_comment as BaseTbl");
        $this->db->join('delivery as Delivery','Delivery.id=BaseTbl.delivery_id');
        $this->db->where("BaseTbl.delivery_id",$id);
        $query =  $this->db->get();
        return $query->result();
    }

    public function getExtD($id,$type){
        $this->db->select(" tbl_purchasedproduct.".$type." as data,
                            tbl_purchasedproduct.trackingHeader as header,
                            Delivery.ordernum as ord,
                            tbl_purchasedproduct.order_number,
                            tbl_purchasedproduct.tracking_time");
        $this->db->from("tbl_purchasedproduct");
        $this->db->join('delivery as Delivery','Delivery.id=tbl_purchasedproduct.delivery_id');
        $this->db->where("delivery_id",$id);
        $this->db->where($type." !=",NULL);
        $this->db->order_by("tbl_purchasedproduct.created_date","ASC");
        $query =  $this->db->get();
        return $query->result();
    }

    public function getDepositByDeliveryId($id,$type){
        $this->db->select("Role.buy_fee,User.deposit,BaseTbl.".$type." as price,User.userId,User.name");
        $this->db->from("delivery as BaseTbl");
        $this->db->join('tbl_users as User','User.userId=BaseTbl.userId');
        $this->db->join('tbl_roles as Role','User.roleId=Role.roleId','left');
        $this->db->where("BaseTbl.id",$id);
        $query =  $this->db->get();
        return $query->result();
    }

    public function getPanelBoard($id){
        $this->db->select("BaseTbl.*,Mail.title as mtitle,Mail.mode,Mail.updated_date as mupdated,User.name as uname");
        $this->db->from("tbl_board as BaseTbl");
        $this->db->join('tbl_mail as Mail','Mail.type=BaseTbl.id');
        $this->db->join('tbl_users as User','User.userId=Mail.fromId');
        $this->db->where("BaseTbl.id",$id);
        $query =  $this->db->get();
        return $query->result();
    }

    public function getRegsitesCountByM(){
        $query = $this->db->query("SELECT  SUBSTRING_INDEX(createdDtm,\"-\",2) AS cdate,COUNT(*) AS c FROM tbl_users  where roleId!=1  GROUP BY cdate order by cdate ASC");
        return $query->result();
    }

    public function getOrdersType($type){
        $this->db->select(" SUBSTRING_INDEX(delivery.created_date,\"-\",2) as cdate,
                            YEAR(delivery.created_date) as yyear,
                            MONTH(delivery.created_date) as ddate,
                            COUNT(*) AS c");
        $this->db->from("delivery");
        $this->db->where("delivery.type",$type);
        $this->db->where("YEAR(delivery.created_date)",date("Y"));
       
        $this->db->group_by("cdate");
        $this->db->order_by("CAST(ddate AS UNSIGNED)","ASC");
        $query =  $this->db->get();
        return $query->result();
    }

    public function getCountProcessing($type){
        $this->db->select("BaseTbl.*");
        $this->db->from('delivery as BaseTbl');
        $this->db->join("tbl_purchasedproduct as Product","Product.delivery_id=BaseTbl.id");
        $this->db->join("tbl_users as User","User.userId=BaseTbl.userId");
        if($type!="shop"){
            $this->db->where('BaseTbl.get', $type);
            $this->db->where('BaseTbl.shop is NULL', NULL, FALSE);
        }
        else{
             $this->db->where('BaseTbl.shop',1);
        }
        $this->db->group_by("BaseTbl.id");
        $query =  $this->db->get();
        return sizeof($query->result());
    }

    public function getUpgradedLevel(){
        $this->db->select("BaseTbl.*");
        $this->db->from("tbl_roles as BaseTbl");
        $this->db->where("BaseTbl.user",1);
        $this->db->where("BaseTbl.roleId!=",1);
        $this->db->where("BaseTbl.roleId!=",2);
        $query =  $this->db->get();
        return $query->result();
    }
    public function getCommentsByPostId($limit1=5,$limit2=0,$id){
        $this->db->select("BaseTbl.*,User.name");
        $this->db->from("tbl_comment as BaseTbl");
        $this->db->join("tbl_users as User","User.userId=BaseTbl.userId");
        $this->db->where("BaseTbl.postId",$id);
        $this->db->order_by("BaseTbl.created_date","DESC");
        $this->db->limit($limit1,$limit2);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getWillLevel(){
        $query=$this->db->query("select * from tbl_users");
        return $query->result();
    }
    public function getProductShoppinmal($delivery_id){
        $this->db->select("BaseTbl.*,Po.point,Po.rid");
        $this->db->from("tbl_purchasedproduct as BaseTbl");
        $this->db->join('tbl_sproducts as Po','Po.id=BaseTbl.shop');
        $this->db->where("BaseTbl.delivery_id",$delivery_id);
        $query =  $this->db->get();
        return $query->result();
    }

    public function getPointHistory($limit1=null,$limit2=null,$sd=null,$ed=null,$s=null,$shType=null){
        $this->db->select(" tbl_point_users.*,
                            Usrs.name,Usrs.loginId,
                            Usrs.point as upoint");
        $this->db->from("tbl_point_users");
        $this->db->join('tbl_users as Usrs','Usrs.userId=tbl_point_users.userId');
        if($sd !=null)
            $this->db->where("tbl_point_users.created_date >=",$sd );
        if($ed !=null)
            $this->db->where("tbl_point_users.created_date <=",$ed );
        if($s !=null){
            if($s =="Y") $this->db->where("tbl_point_users.s",0 );
            if($s =="N") $this->db->where("tbl_point_users.s",1 );
        }
        if($shType !=null){
            if($shType =="A") $this->db->where("tbl_point_users.type",1 );
            if($shType =="B") $this->db->where("tbl_point_users.type",2 );
            if($shType =="C") $this->db->where("tbl_point_users.type",3 );
            if($shType =="D") $this->db->where("tbl_point_users.type",5 );
            if($shType =="E") $this->db->where("tbl_point_users.type",4 );
        }

        $this->db->order_by("tbl_point_users.created_date","DESC");
        if($limit1 !=null) $this->db->limit($limit1,$limit2);
        $query =  $this->db->get();
        return $query->result();
    }

    public function getNote($li1=null,$li2=null){
        $this->db->select("BaseTbl.*,Users.name,Users.userId");
        $this->db->from("tbl_notice as BaseTbl");
        $this->db->join('tbl_users as Users','Users.userId=BaseTbl.userId',"LEFT");
        $this->db->order_by("BaseTbl.created_date","DESC");
        if($li1 !=null) $this->db->limit($li1,$li2);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function runSQL($sql){
        $this->db->query($sql);
    }

    public function getServices($use=null){
        $this->db->select("BaseTbl.*,Part.name as ppart");
        $this->db->from("tbl_services as BaseTbl");
        $this->db->join('tbl_service_header as Part','Part.id=BaseTbl.part');
        if($use !=null) {
            $this->db->where("BaseTbl.use",1 );
            $this->db->where("Part.use",1 );
        }
        $this->db->order_by("BaseTbl.part","ASC");
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function pointCheck($id){
        $this->db->select('BaseTbl.*');
        $this->db->from("tbl_purchasedproduct as BaseTbl");
        $this->db->join("delivery as Delivery","Delivery.id=BaseTbl.delivery_id");
        $this->db->where("BaseTbl.old_delivery_id",$id);
        $this->db->where("Delivery.state","!=23");
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getproductOld($id,$combine,$type =1){

        if($combine ==-1)
        {
            $select = "BaseTbl.delivery_id as did";
            $group = "BaseTbl.delivery_id";
        }
        else{
            $select = "BaseTbl.old_delivery_id as did";
            $group = "BaseTbl.old_delivery_id";
        }


        $this->db->select($select);
        $this->db->from("tbl_purchasedproduct as BaseTbl");
        $this->db->where("BaseTbl.old_delivery_id",$id);
        $this->db->or_where("BaseTbl.delivery_id",$id);
        $this->db->group_by($group);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function ErrorProductValue($id){


        $query = $this->db->query(" SELECT A.aprice,A.aprice *(A.pur_fee/100) as fee from (SELECT
                                          SUM(
                                            BaseTbl.unitPrice * BaseTbl.count * SUBSTRING_INDEX(pur_fee, \"|\", - 1)
                                          ) AS aprice,
                                          SUBSTRING_INDEX(pur_fee, \"|\", 1) AS pur_fee
                                        FROM
                                          `tbl_purchasedproduct` AS `BaseTbl`
                                          JOIN `delivery` AS `Delivery`
                                            ON `Delivery`.`id` = `BaseTbl`.`delivery_id`
                                        WHERE (Delivery.purchase_price > 0)
                                          AND (Delivery.get = \"buy\")
                                          AND (
                                            BaseTbl.old_delivery_id = ".$id."
                                            OR BaseTbl.delivery_id = ".$id."
                                          )
                                          AND (
                                            BaseTbl.step = 102
                                            OR BaseTbl.step = 103
                                            OR Delivery.state = 18
                                            OR Delivery.state = 19
                                            OR Delivery.state = 20
                                            OR Delivery.state = 21
                                            OR Delivery.state = 24
                                          )) A ");
        $results = $query->result();
        return $results;
    }

    public function getProuctWishs($limit1=10,$limit2=0,$p_saleview="",$p_newview="",$p_bestview="",$pcode="",$catgory = array(),$name=""){
        $this->db->select(' BaseTbl.*,
                            Users.name as uname,
                            Wish.rdate,
                            Users.nickname,
                            Wish.id as wid');
        $this->db->from("tbl_sproducts as BaseTbl");
        $this->db->join("tbl_product_category as Category","Category.pcode=BaseTbl.rid","left");
        $this->db->join("tbl_product_wish as Wish","Wish.pcode=BaseTbl.rid");
        $this->db->join("tbl_users as Users","Users.userId=Wish.userId");
        if($p_saleview !="")
            $this->db->where("BaseTbl.p_saleview",$p_saleview);
        if($p_newview !="")
            $this->db->where("BaseTbl.p_newview",$p_newview);
        if($p_bestview !="")
            $this->db->where("BaseTbl.p_bestview",$p_bestview);
        if(!empty($catgory))
            $this->db->where_in("Category.category_id",$catgory);
        if(!empty($pcode))
            $this->db->where("BaseTbl.rid",$pcode);
        if(!empty($name))
            $this->db->like("BaseTbl.name",$name,"both");
        if($limit1 ==0 && $limit2==0){}
        else{$this->db->limit($limit1,$limit2);}
        $this->db->order_by("Wish.rdate","DESC");
        $this->db->group_by("Wish.id");
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function deleteCategoryShop($pcode,$cateogry){
        $this->db->where("pcode", $pcode);
        $this->db->where("category_id", $cateogry);
        $this->db->delete("tbl_product_category");
    }

    public function getCategoryiesFromPcode($pcode){
        $this->db->select('Category.*');
        $this->db->from("tbl_product_category as BaseTbl");
        $this->db->join("tbl_leftcategory as Category","Category.id=BaseTbl.category_id");
        $this->db->where("BaseTbl.pcode",$pcode);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }


    public function deleteOptionCategories($id){
        $this->db->where("id", $id);
        $this->db->or_where("parent", $id);
        $this->db->delete("tbl_product_option");
    }

    public function getCategoriesFromParentsArray($cates){
        if(!empty($cates)){
            $this->db->select("BaseTbl.*");
            $this->db->from("tbl_leftcategory as BaseTbl");
            $this->db->where("BaseTbl.id","!=0");
            foreach ($cates as $value) {
                $this->db->or_where("BaseTbl.parent",$value);
            }
            $this->db->order_by("BaseTbl.order ASC,BaseTbl.updated_date DESC");
            $query = $this->db->get();
            $results = $query->result();
            return $results;
        }
        else
            return array();
    }

    public function getSelectedCateogires($pcode){
        $this->db->select('Category.name,Category.id');
        $this->db->from("tbl_related_product as BaseTbl");
        $this->db->join("tbl_leftcategory as Category","Category.id=BaseTbl.category_id");
        $this->db->where("BaseTbl.pcode",$pcode);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getAddDelviery($limit1=0,$limit2=0,$post ="",$address=""){
        $this->db->select("*");
        $this->db->from("tbl_delivery_addprice");
        if(trim($post) !="")
            $this->db->like("post",$post,"both");
        if(trim($address) !="")
            $this->db->like("address",$address,"both");
        $this->db->order_by("updated_date","DESC");
        if($limit1 ==0 && $limit2==0){}
        else {$this->db->limit($limit1,$limit2);}
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }


    public function getReviews($limit1=0,$limit2=0,$type,$name="",$pcode="",$writter="",$comment=""){

        $this->db->select(" BaseTbl.*,
                            Product.image,
                            User.nickname,
                            User.name as uname,
                            Product.id as pid,
                            Product.name as pname");
        $this->db->from("tbl_product_talk as BaseTbl");
        $this->db->join("tbl_users as User","User.userId=BaseTbl.userId","LEFT");
        $this->db->join("tbl_sproducts as Product","Product.rid=BaseTbl.pcode");
        $this->db->where("BaseTbl.type",$type);
        if(!empty($pcode))
            $this->db->where("BaseTbl.pcode",$pcode);

        if(!empty($name))
            $this->db->like("Product.name",$name,"both");

        if(!empty($comment))
            $this->db->like("BaseTbl.content",$content,"both");

        if(!empty($writter))
            $this->db->like("User.name",$writter,"both");

        $this->db->where("BaseTbl.depth",1);
        $this->db->order_by("BaseTbl.rdate","DESC");
        if($limit1 ==0 && $limit2==0){}
        else {$this->db->limit($limit1,$limit2);}
        $query =  $this->db->get();
        $result = $query->result();

       foreach($result as $key => $value){
            $this->db->select("BaseTbl.*,User.name");
            $this->db->from("tbl_product_talk as BaseTbl");
            $this->db->join("tbl_users as User","User.userId=BaseTbl.userId","LEFT");
            $this->db->where("BaseTbl.relation",$value->id);
            $query =  $this->db->get();
            $result[$key]->reply = $query->result();
       }
       return $result;
    }

    public function getParentRequest($id){
        $this->db->select(" BaseTbl.*,
                            Product.image,User.nickname,
                            User.name as uname,
                            Product.id as pid,
                            Product.name as pname");
        $this->db->from("tbl_product_talk as BaseTbl");
        $this->db->join("tbl_users as User","User.userId=BaseTbl.userId","LEFT");
        $this->db->join("tbl_sproducts as Product","Product.rid=BaseTbl.pcode");
        $this->db->where("BaseTbl.relation",$id);
        $this->db->or_where("BaseTbl.id",$id);
        $query =  $this->db->get();
        return $query->result();
    }


    public function getOldDelieryIds($old){
        $this->db->select(" BaseTbl.old_delivery_id,
                            Comment.id as cid,Comment.use as cuse,
                            Comment.comment as ccomment,
                            Delivery.ordernum,
                            Delivery.memo");
        $this->db->from("tbl_purchasedproduct as BaseTbl");
        $this->db->join("tbl_delivery_comment as Comment","Comment.delivery_id=BaseTbl.old_delivery_id","left");
        $this->db->join("delivery as Delivery","Delivery.id=BaseTbl.old_delivery_id");
        $this->db->where("BaseTbl.delivery_id",$old);
        $this->db->group_by("BaseTbl.old_delivery_id");
        $query = $this->db->get();
        return $query->result();
    }

    public function getCommentAndMemo($old){
        $this->db->select(" BaseTbl.memo,
                            Comment.comment,
                            Comment.use,
                            Comment.id");
        $this->db->from("delivery as BaseTbl");
        $this->db->join("tbl_delivery_comment as Comment","Comment.delivery_id=BaseTbl.id","left");
        $this->db->where("BaseTbl.id",$old);
        $query = $this->db->get();
        return $query->result();
    }

    public function getProductsOrder($limit1,$limit2,$where,$cates = array()){

        $this->db->select("tbl_sproducts.*");
        $this->db->from("tbl_sproducts");
        if(!empty($where)){
            foreach ($where as $key => $value) {
                $this->db->like($value["record"],$value["value"],"both");
            }
        }
        if(!empty($cates)){
            $this->db->join("tbl_product_category","tbl_product_category.pcode = tbl_sproducts.rid");
            $this->db->where_in("tbl_product_category.category_id",$cates);
        }
        $this->db->order_by("tbl_sproducts.p_idx ASC ,tbl_sproducts.updated_date DESC");
        if($limit2 == -1 && $limit1 ==-1){

        }
        else{
            $this->db->limit($limit1,$limit2);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function checkNotIn($ord){
        $this->db->where('delivery_id', $ord);
        $this->db->where("step !=",101);
        $this->db->from('tbl_purchasedproduct');
        return $this->db->count_all_results();
    }

    public function getDayAccess($year,$month){
        $total = array();
        $this->db->select("COUNT(id) as total,created_date");
        $this->db->from("tbl_log_site");
        $this->db->like("created_date" , $year."-".$month,"RIGHT");
        $this->db->group_by("created_date");
        $this->db->order_by("created_date","ASC");
        $query = $this->db->get();
        $result = $query->result();

        if(!empty($result)){
            foreach ($result as $key => $value) {
                $orgDate = $value->created_date;
                $newDate = date("Ymd", strtotime($orgDate));
                $total[$newDate] = $value->total;
            }
        }

        return $total;
    }

    public function getMonthAccess($year){
        $total = array();
        $this->db->select("COUNT(id) as total,Month(created_date) AS created_date");
        $this->db->from("tbl_log_site");
        $this->db->like("created_date" , $year,"RIGHT");
        $this->db->group_by("Month(created_date)");

        $this->db->order_by("created_date","ASC");
        $query = $this->db->get();
        $result = $query->result();

        if(!empty($result)){
            foreach ($result as $key => $value) {
                // $orgDate = $value->created_date;
                // $newDate = date("Ymd", strtotime($orgDate));
                $total[$year.$value->created_date] = $value->total;
            }
        }

        return $total;
    }

    public function getYearAccess($year,$month){
        $total = array();
        $this->db->select("COUNT(id) as total,WEEK(created_date) AS year");
        $this->db->from("tbl_log_site");
        $this->db->like("created_date" , $year."-".$month,"RIGHT");
        $this->db->group_by("WEEK(created_date)");
        $this->db->order_by("WEEK(created_date)","ASC");
        $query = $this->db->get();
        $result = $query->result();

        if(!empty($result)){
            foreach ($result as $key => $value) {
                // $orgDate = $value->created_date;
                // $newDate = date("Ymd", strtotime($orgDate));
                $total[$value->year] = $value->total;
            }
        }

        return $total;
    }


    public function getTimeAccess($year,$month,$date){
        $total = array();
        $this->db->select("COUNT(id) as total,time");
        $this->db->from("tbl_log_site");
        $this->db->where("created_date",$year."-".$month."-".$date);
        $this->db->group_by("time");
        $this->db->order_by("time","ASC");
        $query = $this->db->get();
        $result = $query->result();

        if(!empty($result)){
            foreach ($result as $key => $value) {
                $total[$value->time] = $value->total;
            }
        }

        return $total;
    }


    public function getDayVisit($year,$month){
        $total = array();
        $this->db->select("COUNT(id) as total,created_date");
        $this->db->from("tbl_visit");
        $this->db->like("created_date" , $year."-".$month,"RIGHT");
        $this->db->group_by("created_date");
        $this->db->order_by("created_date","ASC");
        $query = $this->db->get();
        $result = $query->result();

        if(!empty($result)){
            foreach ($result as $key => $value) {
                $orgDate = $value->created_date;
                $newDate = date("Ymd", strtotime($orgDate));
                $total[$newDate] = $value->total;
            }
        }

        return $total;
    }

    public function getMonthVisit($year){
        $total = array();
        $this->db->select("COUNT(id) as total,Month(created_date) AS created_date");
        $this->db->from("tbl_visit");
        $this->db->like("created_date" , $year,"RIGHT");
        $this->db->group_by("Month(created_date)");

        $this->db->order_by("created_date","ASC");
        $query = $this->db->get();
        $result = $query->result();

        if(!empty($result)){
            foreach ($result as $key => $value) {
                $total[$year.$value->created_date] = $value->total;
            }
        }

        return $total;
    }

    public function getYearVisit($year,$month){
        $total = array();
        $this->db->select("COUNT(id) as total,Week(created_date) AS year");
        $this->db->from("tbl_visit");
        $this->db->like("created_date" , $year."-".$month,"RIGHT");
        $this->db->group_by("Week(created_date)");
        $this->db->order_by("Week(created_date)","ASC");
        $query = $this->db->get();
        $result = $query->result();

        if(!empty($result)){
            foreach ($result as $key => $value) {
                $total[$value->year] = $value->total;
            }
        }

        return $total;
    }

    public function getTimevisit($year,$month,$date){
        $total = array();
        $this->db->select("COUNT(id) as total,time");
        $this->db->from("tbl_visit");
        $this->db->where("created_date",$year."-".$month."-".$date);
        $this->db->group_by("time");
        $this->db->order_by("time","ASC");
        $query = $this->db->get();
        $result = $query->result();

        if(!empty($result)){
            foreach ($result as $key => $value) {
                $total[$value->time] = $value->total;
            }
        }

        return $total;
    }

    public function userListing($limit1 = 0,$limit2 = 0){
        $this->db->select("BaseTbl.*");
        $this->db->from("tbl_users as BaseTbl");
        $this->db->where("BaseTbl.roleId !=" ,1);
        $this->db->where("BaseTbl.log_num >" ,0);
        $this->db->order_by("BaseTbl.log_num","DESC");
        if($limit1 ==0  && $limit2 ==0){

        }
        else
            $this->db->limit($limit1, $limit2);
        $query = $this->db->get();
        return $query->result();
    }

    public function userListingGrade($limit1 = 0,$limit2 = 0){
        $this->db->select("BaseTbl.*");
        $this->db->from("tbl_users as BaseTbl");
        $this->db->where("BaseTbl.roleId !=" ,2);
        $this->db->where("BaseTbl.roleId !=" ,1);
        $this->db->where("BaseTbl.deposit >" ,0);
        $this->db->order_by("BaseTbl.deposit","DESC");
        if($limit1 ==0  && $limit2 ==0){

        }
        else
            $this->db->limit($limit1, $limit2);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDayRegister($year,$month){
        $total = array();
        $this->db->select("COUNT(userId) as total,createdDtm");
        $this->db->from("tbl_users");
        $this->db->like("createdDtm" , $year."-".$month,"RIGHT");
        $this->db->group_by("createdDtm");
        $this->db->order_by("createdDtm","ASC");
        $query = $this->db->get();
        $result = $query->result();

        if(!empty($result)){
            foreach ($result as $key => $value) {
                $orgDate = $value->createdDtm;
                $newDate = date("Ymd", strtotime($orgDate));
                $total[$newDate] = $value->total;
            }
        }

        return $total;
    }

    public function getWeekRegister($year,$month){
        $total = array();
        $this->db->select("COUNT(userId) as total,Week(createdDtm) as createdDtm");
        $this->db->from("tbl_users");
        $this->db->like("createdDtm" , $year."-".$month,"RIGHT");
        $this->db->group_by("Week(createdDtm)");
        $this->db->order_by("Week(createdDtm)","ASC");
        $query = $this->db->get();
        $result = $query->result();

        if(!empty($result)){
            foreach ($result as $key => $value) {
                $total[$value->createdDtm] = $value->total;
            }
        }

        return $total;
    }

    public function getMonthRegister($year){
        $total = array();
        $this->db->select("COUNT(userId) as total,Month(createdDtm) AS createdDtm");
        $this->db->from("tbl_users");
        $this->db->like("createdDtm" , $year,"RIGHT");
        $this->db->group_by("Month(createdDtm)");

        $this->db->order_by("createdDtm","ASC");
        $query = $this->db->get();
        $result = $query->result();

        if(!empty($result)){
            foreach ($result as $key => $value) {
                $total[$year.$value->createdDtm] = $value->total;
            }
        }

        return $total;
    }

    public function getRegionRegister(){
        $total = array();
        $this->db->select("COUNT(userId) as total,SUBSTRING_INDEX(address,' ',1) AS addresses");
        $this->db->from("tbl_users");
        $this->db->where("roleId !=" ,1);
        $this->db->group_by("addresses");
        $query = $this->db->get();
        $result = $query->result();

        if(!empty($result)){
            foreach ($result as $key => $value) {
                $total[$value->addresses] = $value->total;
            }
        }

        return $total;
    }

    public function getPurchasedProudctsOrder($limit1=0 , $limit2=0){
        $this->db->select("*");
        $this->db->from("tbl_sproducts");
        $this->db->where("use",1);
        $this->db->where("count >",0);
        $this->db->where("p_salecnt >",0);
        $this->db->order_by("p_salecnt" , "DESC");
        if($limit1 ==0 && $limit2==0){}
        else{$this->db->limit($limit1,$limit2);}
        $query = $this->db->get();
        return $query->result();
    }

    public function getViewedProductsOrder($limit1=0 , $limit2=0){
        $this->db->select("*");
        $this->db->from("tbl_sproducts");
        $this->db->where("use",1);
        $this->db->where("count >",0);
        $this->db->where("view >",0);
        $this->db->order_by("view" , "DESC");
        if($limit1 ==0 && $limit2==0){}
        else{$this->db->limit($limit1,$limit2);}
        $query = $this->db->get();
        return $query->result();
    }

    public function getViewedCategoryOrder(){
        $this->db->select("*");
        $this->db->from("tbl_leftcategory");
        $this->db->where("use",1);
        $this->db->where("view >",0);
        $this->db->order_by("view" , "DESC");
        $query = $this->db->get();
        return $query->result();
    }

    public function getPurchasedCategoryOrder(){
        $this->db->select("*");
        $this->db->from("tbl_leftcategory");
        $this->db->where("use",1);
        $this->db->where("purchase >",0);
        $this->db->order_by("purchase" , "DESC");
        $this->db->order_by("updated_date" , "DESC");
        $query = $this->db->get();
        return $query->result();
    }

    public function getCategoryP($productId){
        $this->db->select("Category.category_id");
        $this->db->from("tbl_sproducts as BaseTbl");
        $this->db->join("tbl_product_category as Category","Category.pcode=BaseTbl.rid");
        $this->db->where("BaseTbl.id",$productId);
        $query = $this->db->get();
        $return = $query->result();
        $result = array();
        if(!empty($return)){
            foreach($return as $value){
                array_push($result, $value->category_id);
            }
        }

        return $result;
    }

    public function getSearchProductsOrder($limit1=0 , $limit2=0){
        $this->db->select("*");
        $this->db->from("tbl_sproducts");
        $this->db->where("use",1);
        $this->db->where("search >",0);
        $this->db->order_by("search" , "DESC");
        if($limit1 ==0 && $limit2==0){}
        else{$this->db->limit($limit1,$limit2);}
        $query = $this->db->get();
        return $query->result();
    }

    public function getMemberShopping($type,$limit1 = 0, $limit2 = 0){
        $this->db->select("COUNT(BaseTbl.id) as total,User.nickname,User.userId,User.name,User.loginId");
        $this->db->from("delivery as BaseTbl");
        $this->db->join("tbl_users as User","User.userId=BaseTbl.userId");
        $this->db->where("BaseTbl.state" , 23);
        if($type ==1 )
            $this->db->where("BaseTbl.type" , 3);
        else
            $this->db->where("BaseTbl.type" , 2);
        $this->db->order_by("total", 'DESC');
        $this->db->group_by("BaseTbl.userId");
        if($limit1 ==0 && $limit2==0){}
        else{$this->db->limit($limit1,$limit2);}
        $query = $this->db->get();
        return $query->result();
    }

    public function getDaySites($year,$month,$domain = ""){
        $total = array();
        $this->db->select("COUNT(BaseTbl.id) as total,BaseTbl.site,BaseTbl.created_date");
        $this->db->from("tbl_log_site as BaseTbl");
        $this->db->like("BaseTbl.created_date",$year."-".$month,"RIGHT");
        if(!empty($domain))
            $this->db->like("BaseTbl.site",$domain,"BOTH");
        $this->db->group_by("BaseTbl.site");
        $this->db->group_by("DATE(BaseTbl.created_date)");
        $this->db->order_by("total", 'DESC');
        $query = $this->db->get();
        $result =  $query->result();
        $result = $query->result();
        return $result;
    }

    public function getMonthSites($year,$domain = ""){
        $this->db->select("COUNT(BaseTbl.id) as total,BaseTbl.site,MONTH(BaseTbl.created_date) as month");
        $this->db->from("tbl_log_site as BaseTbl");
        $this->db->like("BaseTbl.created_date",$year,"RIGHT");
        if(!empty($domain))
            $this->db->like("BaseTbl.site",$domain,"BOTH");
        $this->db->order_by("total" , "DESC");
        $this->db->group_by("BaseTbl.site");
        $query = $this->db->get();
        return $query->result();
    }

    public function getWeekSites($year,$month,$domain = ""){
        $this->db->select("COUNT(BaseTbl.id) as total,Week(BaseTbl.created_date) as week,BaseTbl.site");
        $this->db->from("tbl_log_site as BaseTbl");
        $this->db->like("BaseTbl.created_date",$year."-".$month,"RIGHT");
        if(!empty($domain))
            $this->db->like("BaseTbl.site",$domain,"BOTH");
        $this->db->order_by("total", 'DESC');
        $this->db->group_by("Week(BaseTbl.created_date)");
        $this->db->group_by("BaseTbl.site");
        $query = $this->db->get();
        return $query->result();
    }


    public function getregionVisit($limit1 = 0 , $limit2 = 0){
        $total = array();
        $this->db->select("COUNT(id) as total,latitude");
        $this->db->from("tbl_visit");
        $this->db->group_by("latitude");
        $this->db->order_by("total","DESC");
        $this->db->order_by("region","ASC");
        if($limit1 ==0 && $limit2==0){}
        else{$this->db->limit($limit1,$limit2);}
        $query = $this->db->get();
        $result = $query->result();
        if(!empty($result)){
            foreach ($result as $key => $value) {
                $value->latitude = empty($value->latitude) ? "NONE" : $value->latitude;
                $total[$value->latitude] = $value->total;
            }
        }

        return $total;
    }

    public function getStrange($limit1 = 0 , $limit2 = 0){

        $this->db->select("COUNT(id) as total,ip,strange,created_date,time");
        $this->db->from("tbl_strange");
        $this->db->group_by("DATE(created_date)");
        $this->db->group_by("ip");
        $this->db->group_by("strange");
        $this->db->order_by("created_date","DESC");
        if($limit1 ==0 && $limit2==0){}
        else{$this->db->limit($limit1,$limit2);}
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

}
?>
