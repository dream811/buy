<?php  
$steps_array = array();
switch ($step) {
  case "1":
    $steps_array[] = array( "step"=>'2',"name"=>"접수신청");
    $steps_array[] = array( "step"=>'18',"name"=>"신청취소");
    break;
  case "2":
    $steps_array[] = array( "step"=>'11',"name"=>"입고완료");
    $steps_array[] = array( "step"=>'17',"name"=>"출고보류");
    $steps_array[] = array( "step"=>'18',"name"=>"신청취소");
    $steps_array[] = array( "step"=>'1',"name"=>"접수대기");
    break;
  case "4":
    $steps_array[] = array( "step"=>'5',"name"=>"결제대기");
    $steps_array[] = array( "step"=>'18',"name"=>"신청취소");
    break;
  case "5":
    $steps_array[] = array( "step"=>'6',"name"=>"결제완료");
    $steps_array[] = array( "step"=>'7',"name"=>"구매완료");
    $steps_array[] = array( "step"=>'18',"name"=>"신청취소");
    $steps_array[] = array( "step"=>'4',"name"=>"구매견적");
    break;
  case "6":
    $steps_array[] = array( "step"=>'7',"name"=>"구매완료");
    $steps_array[] = array( "step"=>'4',"name"=>"구매견적");
    $steps_array[] = array( "step"=>'5',"name"=>"결제대기");
    break;
  case "7":
    $steps_array[] = array( "step"=>'11',"name"=>"입고완료");
    $steps_array[] = array( "step"=>'5',"name"=>"결제대기");
    $steps_array[] = array( "step"=>'6',"name"=>"결제완료");
    $steps_array[] = array( "step"=>'16',"name"=>"출고대기");
    break;
  case "19":
    $steps_array[] = array( "step"=>'11',"name"=>"입고완료");
    $steps_array[] = array( "step"=>'20',"name"=>"결제대기");
    $steps_array[] = array( "step"=>'18',"name"=>"신청취소");
    break;
  case "20":
    $steps_array[] = array( "step"=>'20',"name"=>"결제대기");
    $steps_array[] = array( "step"=>'18',"name"=>"신청취소");
    $steps_array[] = array( "step"=>'19',"name"=>"리턴신청");
    break;
  case "21":
    $steps_array[] = array( "step"=>'24',"name"=>"리턴완료");
    $steps_array[] = array( "step"=>'20',"name"=>"결제대기");
    break;
  case "24":
    $steps_array[] = array( "step"=>'21',"name"=>"결제완료");
    break;
  case "30":
    $steps_array[] = array( "step"=>"31","name"=>"재고입고");
    break;    
  case "31":
    $steps_array[] = array( "step"=>"33","name"=>"재고등록");
    break; 
  case "33":
    $steps_array[] = array( "step"=>"31","name"=>"재고입고");
    break; 
  case "11":
    $steps_array[] = array( "step"=>'7',"name"=>"구매완료");
    $steps_array[] = array( "step"=>"40","name"=>"배송요청");
    $steps_array[] = array( "step"=>'18',"name"=>"신청취소");
    $steps_array[] = array( "step"=>'2',"name"=>"접수신청");
    break;
  case "14":
    $steps_array[] = array( "step"=>"40","name"=>"배송요청");
    $steps_array[] = array( "step"=>"15","name"=>"결제완료");
    $steps_array[] = array( "step"=>'11',"name"=>"입고완료");
    break;
  case "15":
    $steps_array[] = array( "step"=>"16","name"=>"출고대기");
    $steps_array[] = array( "step"=>"17","name"=>"출고보류");
    $steps_array[] = array( "step"=>"14","name"=>"결제대기");
    break;
  case "16":
    $steps_array[] = array( "step"=>"23","name"=>"출고완료");
    $steps_array[] = array( "step"=>"17","name"=>"출고보류");
    $steps_array[] = array( "step"=>"15","name"=>"결제완료");
    break;
  case "12":
    $steps_array[] = array( "step"=>"13","name"=>"오류무시");
    $steps_array[] = array( "step"=>'11',"name"=>"입고완료");
    break;
  case "13":
    $steps_array[] = array( "step"=>'11',"name"=>"입고완료");
    $steps_array[] = array( "step"=>'2',"name"=>"접수신청");
    $steps_array[] = array( "step"=>'7',"name"=>"구매완료");
    break;
  case "23":
    $steps_array[] = array( "step"=>"16","name"=>"출고취소");
    break;  
  case "17":
    $steps_array[] = array( "step"=>"16","name"=>"출고대기");
    $steps_array[] = array( "step"=>"15","name"=>"결제완료");
    break;
  case "18":
    $steps_array[] = array( "step"=>"1","name"=>"접수대기");
    $steps_array[] = array( "step"=>"4","name"=>"구매견적");
    break; 
  
  case "40":
    $steps_array[] = array( "step"=>"14","name"=>"결제대기");
    $steps_array[] = array( "step"=>"17","name"=>"출고보류");
    $steps_array[] = array( "step"=>'18',"name"=>"신청취소");
    $steps_array[] = array( "step"=>'2', "name"=>"접수신청");
    $steps_array[] = array( "step"=>"11","name"=>"입고완료");
    break;
  default:  
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        대행종합관리
      </h1>
    </section>
    <section class="content">
      <form name="frmList" id="frmList" method="get" action="<?=base_url()?>dashboard"> 
        <input type="hidden" name="gMnu1" id="gMnu1" value="101">   
        <input type="hidden" name="gMnu2" id="gMnu2" value="10101">
        <input type="hidden" name="shGo" id="shGo" value="1">   
        <input type="hidden" name="sKind" id="sKind" value="C"> 
        <input type="hidden" name="sKind1" id="sKind1">   
        <input type="hidden" name="ORD_SEQ" id="ORD_SEQ">
        <input type="hidden" name="MngMemo" id="MngMemo">
        <input type="hidden" name="BoxCnt" id="BoxCnt">
        <input type="hidden" name="returns" id="returns">
        <input type="hidden" name="stepp" id="stepp" value="<?=$step?>">
        <div class="row myPageTab2">
          <?php foreach($category as $value): ?>
            <div class="col-md-5 col-sm-4 col-xs-6  myPageTab2_child bg-gray">
              <!-- small box -->
              <div class="small-box">
                <div class="inner">
                  <h3><?=$value->title?></h3>
                </div>
                  <ul class="step_ul">
                    <?php foreach($delivery[$value->step] as $child): ?>
                      <li>
                        <a href="<?=base_url()?>dashboard?step=<?=$child->step?>" class="<?=$step==$child->step?"selected":""?>">
                          <span ><?=$child->name?></span><span class="fr">
                            <?php if(isset($step_array[$child->step]) && $step_array[$child->step] > 0) echo $step_array[$child->step]; ?>
                            <?php if($child->step!=12 && !isset($step_array[$child->step])) echo 0;
                                  if($child->step==12) echo $errorCoutr;  ?>
                          </span>
                        </a>
                      </li>
                    <?php endforeach; ?>            
                  </ul>
              </div>
            </div><!-- ./col -->
          <?php endforeach; ?>
        </div>
        <div class="row my-4 my-3">
          <div class="col-xs-12">
            <?php if($step !=1): ?>
              
              <a href="javascript:fnPageExlUp();" class="btn btn-sm btn-primary">운송장대량등록</a>
            <?php endif; ?>
          </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box-tools">
                <div class="input-group">
                  <div class="pull-right">
                     <label style="display: block;">주문구분</label>
                     <select class="form-control"  name="order_part">
                       <option value="">== 구분</option>                
                        <option value="1" 
                        <?=empty($_GET['order_part']) == 0 && $_GET['order_part'] ==1 ? "selected":"" ?>>배송대행</option>                      
                        <option value="2" 
                        <?=empty($_GET['order_part']) == 0 && $_GET['order_part'] ==2 ? "selected":"" ?>>구매대행</option>                      
                        <option value="3" 
                        <?=empty($_GET['order_part']) == 0 && $_GET['order_part'] ==3 ? "selected":"" ?>>쇼핑몰</option>                     
                        <option value="4" 
                        <?=empty($_GET['order_part']) == 0 && $_GET['order_part'] ==4 ? "selected":"" ?>>리턴대행</option>                     
                     </select>
                   </div>
                   <div class="pull-right">
                     <label style="display: block;">주문상태</label>
                     <select class="form-control" name="order_state">
                      <option value="">선택</option>
                      <?php if(!empty($state_delivery)): ?>
                        <?php foreach($state_delivery as $value): ?>
                          <?php if($value->type !=0): ?>
                        <option value="<?=$value->step?>" <?=empty($_GET['order_state']) == 0 && $_GET['order_state'] ==$value->step ? "selected":"" ?>><?=$value->name?>[<?=$value->title?>]</option>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      <?php endif; ?>
                     </select>
                   </div>
                   <div class="pull-right">
                     <label style="display: block;">종료일</label>
                     <input type="date" name="ends_date" class="form-control" 
                     value="<?=empty($_GET['ends_date']) == 0 ? $_GET['ends_date']:"" ?>">
                   </div>
                   <div class="pull-right">
                     <label style="display: block;">시작일</label>
                     <input type="date" name="starts_date" class="form-control" 
                     value="<?=empty($_GET['starts_date']) == 0 ? $_GET['starts_date']:"" ?>" >
                   </div>
                   <?php //echo $allRecords; ?>
                   <input type="hidden" name="coming_order">
                   <div class="pull-right">
                     <label style="display: block;">노데이타구분</label>
                     <select class="form-control"  name="nodata_parts">
                       <option value="">== 구분</option>                
                        <option value="103" <?=empty($_GET['nodata_parts']) == 0 && $_GET['nodata_parts']==103 ? "selected":"" ?>>노데이타</option>                      
                     </select>
                   </div>
                   <div class="pull-right">
                     <label style="display: block;">재고구분</label>
                     <select class="form-control"  name="stock_part">
                       <option value="">== 구분</option>                
                        <option value="6" <?=empty($_GET['stock_part']) == 0 && $_GET['stock_part']==6 ? "selected":"" ?>>재고주문</option>
                     </select>
                   </div>
                   <div class="pull-right">
                     <label style="display: block;">Page</label>
                     <select name="shPageSize" id="shPageSize" class="form-control">
                        <?php for($ii = 10 ;$ii<=100;$ii+=5){ ?>
                          <option value="<?=$ii?>" <?=empty($_GET['shPageSize'])==0 && $_GET['shPageSize']==$ii ? "selected":"" ?>><?=$ii?></option>
                        <?php }  ?>
                      </select>
                   </div>
                </div>   
                <div class="input-group" style="margin-top: 15px;margin-bottom: 10px">
                  <div class="pull-right">
                    <label style="display:block; ">&nbsp;</label>
                    <input class="btn btn-primary btn-sm" value="검색" type="submit">
                 </div> 
                 <div class="pull-right">
                    <label style="display:block; ">트래킹번호</label>
                    <input type="text" name="search_ptracking" class="form-control input-sm" 
                     value="<?=empty($_GET['search_ptracking']) == 0 ? $_GET['search_ptracking']:"" ?>" >
                 </div> 
                 <div class="pull-right">
                   <label style="display:block; ">운송장번호</label>
                    <input type="text" name="search_tracking_number"  class="form-control input-sm" 
                     value="<?=empty($_GET['search_tracking_number']) == 0 ? $_GET['search_tracking_number']:"" ?>">
                 </div> 
                 <div class="pull-right">
                   <label style="display:block; ">주문번호</label>
                    <input type="text" name="search_id"  class="form-control input-sm" 
                    value="<?=empty($_GET['search_id']) == 0 ? $_GET['search_id']:""?>">
                 </div> 
                 <div class="pull-right">
                   <label style="display:block; ">오더넘버</label>
                    <input type="text" name="search_porder" class="form-control input-sm"  
                    value="<?=empty($_GET['search_porder']) == 0 ? $_GET['search_porder']:"" ?>">
                 </div> 
                 <div class="pull-right">
                   <label style="display:block; ">영문상품</label>
                    <input type="text" name="search_peng"  class="form-control input-sm"  
                    value="<?=empty($_GET['search_peng']) == 0 ? $_GET['search_peng']:"" ?>">
                 </div> 
                 <div class="pull-right">
                   <label style="display:block; ">아이디</label>
                    <input type="text" name="search_puserId"  class="form-control input-sm"  
                    value="<?=empty($_GET['search_puserId']) ==0 ? $_GET['search_puserId']:""?>" >
                 </div> 
                 <div class="pull-right">
                   <label style="display:block; ">이름</label>
                    <input type="text" name="search_pusername"  class="form-control input-sm"  
                    value="<?=empty($_GET['search_pusername']) == 0 ? $_GET['search_pusername']:"" ?>" >
                 </div> 
                 <div class="pull-right">
                   <label style="display:block; ">수취인명</label>
                    <input type="text" name="search_billing_name"  class="form-control input-sm"  
                    value="<?=empty($_GET['search_billing_name']) == 0 ? $_GET['search_billing_name']:"" ?>">
                 </div> 
                 <div class="pull-right">
                   <label style="display:block; ">사서함번호</label>
                    <input type="text" name="search_nickname"  class="form-control input-sm"  
                    value="<?=empty($_GET['search_nickname']) == 0 ? $_GET['search_nickname']:"" ?>">
                 </div> 
                </div>
              </div>
              <div class="row my-3">
                <div class="col-xs-12">
                  <div class="btnLsitGrp" style="padding-top:5px;"> 
                    <?php if($step !="" && $step !='23'): ?>
                      <select name="sMoveStatSeq1" id="sMoveStatSeq1" onchange="fnSelChasMove(this.value);">
                        <?php foreach($steps_array as $stepValue): ?>
                          <option value="<?=$stepValue['step']?>"><?=$stepValue["name"]?></option>
                        <?php endforeach; ?>
                      </select>
                      <select name="sSMSSendChk1" id="sSMSSendChk1" class="vm" onchange="fnSelChasMove1(this.value);">
                        <option value="">SMS발송안함</option>
                        <option value="1">SMS회원발송</option>
                        <option value="2">SMS수취인발송</option>
                      </select>
                      <button type="button" class="txt btn btn-primary btn-sm" 
                      onclick="fnOrdStatStep('C');">주문상태변경</button>
                    <?php endif; ?>
                    <?php if($step ==5 || $step ==14 || $step ==20): ?>
                      <button type="button" class="btn btn-primary btn-sm" onclick="fnOrdStatStep('E');">예치금결제</button>
                    <?php  endif; ?>
                    <?php if($step =='1' || $step =='2' || $step =='4' || $step =='5' || $step =='19' || $step =='20' || $step =='11' || $step =='18'): ?>
                      <a href="javascript:fnOrdDel();" class="btn btn-sm btn-danger">삭제</a>
                    <?php endif; ?>
                    <?php if($step =='23'): ?>
                      <input type="hidden" name="sMoveStatSeq1" value="16">
                      <a href="javascript:fnOrdStatStep('B');" class="btn btn-sm btn-primary">출고취소</a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col width="80">
                  </colgroup>
                  <thead class="thead-dark">
                    <tr > 
                      <th style="padding-top:10px;"><input type="checkbox" name="chkORD_SEQAll" id="chkORD_SEQAll" value="Y" onclick="fnCkBoxAllSel( 'frmList', 'chkORD_SEQAll', 'chkORD_SEQ[]' );"><br>No
                      </th> 
                      <th>주문번호<br>센터</th>
                      <th>주문구분<br>배송방식</th> 
                      <th>사서함<br>회원명 | 수취인</th>
                      <th>오더넘버<br>트래킹번호</th>  
                      <th>수량<br>총액</th>  
                      <th>결제구분<br>결제금액</th> 
                      <th>운송장번호<br>보관함번호</th> 
                      <th>상품입고<br>주문상태</th> 
                      <th>등록일<br>수정일</th> 
                      <th> </th>  
                    </tr>
                  </thead>
                  <tbody class="table-light">  
                  <?php foreach($deliver_content as $value): ?>
                    <tr>
                      <td class="seq" rowspan="2" style="padding:10px 7px 4px 7px; ">
                        <label class=""><input type="checkbox" name="chkORD_SEQ[]" value="<?=$value->id?>"><br><?=$value->id?></label><br>
                        <span style="color:red; font-weight: bold;"></span>
                        <span class="whChaBtn_bg">
                          <button type="button" class="txt" onclick="fnProView('<?=$value->id?>','','');" title="상품보기"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                        </span>
                      </td>
                      <td class="mid">
                        <span class="black1 bold"><?=$value->ordernum?></span>
                        <span class="red1" style="font-weight:bold;"></span></br>
                        <?=$value->area_name?>
                        <?php if($value->state==1 || $value->state==2 || $value->state==4 || $value->state==5 || $value->state==11 || $value->state==12 || $value->state==19 || $value->state==30 || $value->state==40): ?>
                        <span class="whGraBtn ty2">
                          <button type="button" class="txt  btn " onclick="fnOrdEdit('<?=$value->id?>');">수정</button>
                        </span>
                      <?php endif; ?>
                        <span class="whGraBtn ty2">
                          <a href="<?=base_url()?>ShowDelivery?ORD_SEQ=<?=$value->id?>" class="txt  btn">보기</a>
                        </span>
                      </td>
                      <td class="mid">
                        <span class="bold"><span style="">
                          <?php 

                          if($value->get=="buy" && $value->type!=3) echo '구매대행';
                          if($value->get=="delivery" && $value->type!=3) echo '배송대행';
                          if($value->type==3) echo '쇼핑몰';
                          ?></span></span> | <span style="color:#ff6600;font-kerningweight:bold;"> <?php  
                                      if($value->pcount >1) echo '합배송';else echo '단독배송';
                                      if($value->combine ==1) echo '|묶음배송';
                                      if($value->combine ==2) echo '|나눔배송'; ?></span> | <font color="red"><strong></strong></font><br>
                        <span class="bold red1"><?=$value->method?></span>
                        <span class="whGraBtn ty2">
                            <button type="button" class="txt" onclick="fnOrdComment('<?=$value->id?>','<?=$value->ordernum?>');" >고객메모</button>
                          <?php if(trim($value->Dcomment)!="" && $value->Duse==1): ?>
                            <button type="button" class="txt" onclick="fnFrgImgView2('<?=$value->id?>');" >실사보기</button>
                          <?php endif; ?>
                          <?php if(!empty($value->return_file)): ?>
                            <a class="txt" href="<?=base_url_source()?>upload/return/<?=$value->id?>/<?=$value->return_file?>" >리턴파일 확인</a>
                          <?php endif; ?>
                        </span>
                      </td>

                      <td class="mid">
                        <span class="en10"><?=$value->sase?></span>
                        <br>
                        <a title='sdfs' data-html="true" data-toggle="tooltip" class="hastip"  data-uname="<?=$value->Uname?>" data-userid="<?=$value->userId?>" data-deposit="<?=$value->deposit?>"><?=$value->Uname?></a> | <?=$value->billing_krname?>
                      </td>
                      <td class="mid">
                        O:<?php if(!empty($value->order_number)): ?>
                        <a href="javascript:void();" class="showtracks" data-type='order_number' data-toggle='tooltip' data-deposit='<?=$value->id?>'><?=explode(",",$value->order_number)[0]?></a>
                        <?php endif; ?>
                        <br>
                        T:<?=trim($value->trackingNumber)!="" ? "<a href=\"javascript:\" class=\"tipTrack tooltip-f\">".explode(",",$value->trackingNumber)[0]."</a>"."<a data-toggle='tooltip' data-type='trackingNumber' data-deposit='".$value->id."' class='showtracks'><img src='".base_url()."assets/images/ext_txt.gif'></a>":""?>
                          
                      </td>
                      <td class="mid"><span><?=$value->pcount?></span><br>
                        <?=number_format((float)$value->pprice,2)?>(<?=$value->type ==3 ? "원":"￥"?>)
                        <!---->
                      </td>
                      <td class="mid">
                        <a href="javascript:fnChaView(<?=$value->id?>);" class="modalPop" wd="600" ht="300" rel="/Admin/Acting/OrdCha_A.asp?sOrdSeq=264" ordtit="결제상세내역(주문번호: <?=$value->ordernum?>)">
                          <?php if($value->sending_price > 0): ?>
                            <strong><?php if($value->payed_send==0) echo '배송비용(미입금)';else echo '배송비용(완료)'; ?></strong>
                            <?=number_format(str_replace(",","",$value->sending_price))?>원</a>
                          <?php endif; ?>
                          <?php if($value->purchase_price > 0): ?>
                            <br><strong><?php if($value->payed_checked==0) echo '구매비용(미입금)';else echo '구매비용(완료)'; ?></strong>
                            <?=number_format(str_replace(",","",$value->purchase_price))?>원</a>
                          <?php endif; ?>
                          <?php if($value->return_price > 0): ?>
                            <br><strong><?php if($value->return_check==0) echo '리턴비용(미입금)';else echo '리턴비용(완료)'; ?></strong>
                            <?=number_format(str_replace(",","",$value->return_price))?>원</a>
                          <?php endif; ?>
                          <?php if($value->add_check == 1): ?>
                            <br>
                            추가결제비용(미입금)<?=number_format(str_replace(",","",$value->add_price),2)?>원
                          <?php endif; ?>
                          <?php if($value->add_check == 0 && $value->add_check !=NULL ): ?>
                            <br>
                            추가결제비용(입금완료)<?=number_format(str_replace(",","",$value->add_price),2)?>원
                          <?php endif; ?>
                          <?php if($value->add_check == 2): ?>
                            <br>
                            추가결제비용(무통장 입금대기)<?=number_format(str_replace(",","",$value->add_price),2)?>원
                          <?php endif; ?>
                          <?php if($value->add_check == 3): ?>
                            <br>
                            추가결제비용(관리자 결제취소)<?=number_format(str_replace(",","",$value->add_price),2)?>원
                          <?php endif; ?>
                      </td>
                      <td class="mid">운송장:<?=$value->tracking_number?></td>
                      <td class="mid"><span class="ft11">
                        <span class="red1 bold">입고완료</span></span><br>
                        <span class="bold"><?=$value->sname?></span>
                      </td>
                      <td class="mid"><?=$value->created_date?><br><?=$value->updated_date?></td>
                      <td class="mid">
                        <?php if($value->get=='delivery'): ?>
                        <?php endif; ?>
                        <?php if($value->state==15 || $value->state==23 || $value->state==16): ?>
                          <button type="button" class="btn btn-sm btn-primary btn-block" 
                            onclick="fnInvoiceReg('<?=$value->id?>');">운송장번호등록</button>
                            <?php if($value->add_check==NULL || ($value->add_check != 0 && $value->add_check!=2)): ?>
                          <button type="button" class="btn btn-sm btn-primary btn-block my-10" 
                            onclick="fnMoneyIn('<?=$value->id?>','4','1');">추가결제비용</button>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if($value->state==16): ?>
                          <div class="mt-5">
                            <button type="button" class="btn btn-sm btn-primary btn-block" 
                            onclick="fnIvcNoPrt('<?=$value->id?>');">운송장출력</button>
                          </div>
                        <?php endif; ?>
                        <?php if($value->state==23): ?>
                          <div class="mt-5">
                            <?php if(!empty($value->tracking_number)): ?>
                            <button type="button" class="btn btn-sm btn-primary btn-block" 
                            onclick="fnIvcNoPrt('<?=$value->id?>');">운송장출력</button>
                            <button type="button" class="btn btn-sm btn-primary btn-block" 
                            onclick="fnCstmSearch('<?=$value->tracking_number?>');">통관조회</button>
                          <?php endif; ?>
                          </div>
                        <?php endif; ?>
                         
                            <?php 
                              if($value->state == 40 || $value->state == 14){
                                if($value->payed_send ==0): ?>
                                   <button type="button" class="btn btn-sm brn-secondary" onclick="fnMoneyIn('<?=$value->id?>','1','1');">배송비용</button>
                                <?php   endif;
                              }
                              if( $value->state == 4 || $value->state == 5){ ?>
                                <button type="button" class="btn btn-sm brn-secondary" onclick="fnMoneyIn('<?=$value->id?>','2','1');">구매비용</button>
                            <?php   }
                              if( $value->state == 19 || $value->state == 20 || $value->state == 21 || $value->state == 24){ ?>
                                <button type="button" class="btn btn-sm brn-secondary" onclick="fnMoneyIn('<?=$value->id?>','3','1');">리턴비용</button>
                            <?php   }
                            ?>
                        <?php  if($value->state ==14 || $value->state == 5): ?>
                          <button type="button" class="btn btn-sm brn-secondary" 
                          onclick="fnMoneyReset('<?=$value->id?>',<?=$value->state?>);">비용리셋</button>
                        <?php endif;  ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="9">
                        <ul class="tInBox">
                          <li>
                            <label>부가서비스</label> : &nbsp;&nbsp;
                            <?php $content = json_decode($value->content);
                            $str_services = "";
                             ?>

                            <?php foreach($content as $key_services => $services_content): ?>
                              <?php if(isset($services[$key_services])): ?>
                              <span class='<?=$services_content==0 ? "text-danger" : ""?>'><?=
                              isset($services[$key_services]) ? trim($services[$key_services]).",": ""?></span>
                              <?php endif; ?>
                            <?php endforeach; ?>
                            <?=$str_services?></li>
                          <li><label>물류센터요청사항</label> : <input type="text" name="" id="" maxlength="1200" class="bBox" value="<?=$value->logistics_request?>" readonly=""></li>
                          <li><label>관리자메모</label> : 
                            <input  placeholder="최대글자수 200" type="text" name="MngMemo<?=$value->id?>" id="MngMemo<?=$value->id?>" class="red1 bBox" value="<?=$value->memo?>">
                            <span class="whGraBtn ty2"><button type="button" class="txt" onclick="fnMngMemo('<?=$value->id?>');">등록</button></span>
                          </li>
                        </ul>
                        <div id="order-pro<?=$value->id?>" style="display: none;">
                          <table class="table table-hover">
                            <thead class="thead-gray">
                              <tr> 
                                <th>
                                  <label><input type="checkbox" name="chkPROAll_<?=$value->id?>" id="chkPROAll_<?=$value->id?>" value="Y" onclick="fnCkBoxAllSel( 'frmList', 'chkPROAll_<?=$value->id?>', 'chkPRO_<?=$value->id?>' );">
                                  번호</label>
                                </th>
                                <th>노데이타</th> 
                                <th>상품이미지</th>
                                <th>통관품목<br>상품명(영문/중문)</th> 
                                <th>구매자이름</th> 
                                <th>
                                  Tracking Number<br>
                                  Order No
                                </th> 
                                <th>옵션</th> 
                                <th>단가(<?=$value->type ==3 ? "원":"￥"?>),수량<br>합계</th>
                                <th>포인트</th>
                                <th></th>  
                              </tr>
                            </thead>
                            <tbody class="buyproduct" id="buyproduct<?=$value->id?>"></tbody>
                          </table>
                          <div class="row" style="padding-top:10px;">
                              <div class="col-xs-12">
                                <select name="sARV_STAT_All_<?=$value->id?>" id="sARV_STAT_All_<?=$value->id?>" class="vm_t">
                                  <option value="" selected>=상태변경</option>
                                  <?php foreach($pState as $pvalue): ?>
                                    <?php $pvalue->name =  strpos($pvalue->name,"노데이타") !==FALSE ? "신청취소":$pvalue->name; ?>
                                    <option value="<?=$pvalue->step?>"><?=$pvalue->name?></option>
                                  <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-sm" 
                                onclick="fnProArvChgAll('<?=$value->id?>', 'chkPRO_<?=$value->id?>', 'sARV_STAT_All_<?=$value->id?>', '2');">상태변경</button>
                                &nbsp;&nbsp;리턴파일:&nbsp;<input type="file" name="RTN_FL_<?=$value->id?>" id="RTN_FL_<?=$value->id?>" maxlength="100" value="" style="display: inline-block;">
                                <button type="button" class="btn btn-sm btn-primary" onclick="fnProReturn('<?=$value->id?>');">리턴신청</button>
                              </div>             
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="bold">박스 
                          <select name="BoxCnt<?=$value->id?>" id="BoxCnt<?=$value->id?>" onchange="fnBoxCnt('<?=$value->id?>',$(this).val());">
                            <option value="1" <?php if($value->backs==1) echo 'selected'; ?>>1</option>
                            <option value="2" <?php if($value->backs==2) echo 'selected'; ?>>2</option>
                            <option value="3" <?php if($value->backs==3) echo 'selected'; ?>>3</option>
                            <option value="4" <?php if($value->backs==4) echo 'selected'; ?>>4</option>
                            <option value="5" <?php if($value->backs==5) echo 'selected'; ?>>5</option>
                          </select> 개
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div><!-- /.box-body -->
              <div class="box-footer clearfix">
                <?php echo $this->pagination->create_links(); ?>
              </div>
            </div>
        </div>
      </form> 
    </section>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="details_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">결제내역상세</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<form name="frmProArv" id="frmProArv" method="post">
  <input type="hidden" name="gMnu1" id="gMnu1" value="101">   
  <input type="hidden" name="gMnu2" id="gMnu2" value="10101">
  <input type="hidden" name="sOrdSeq" id="sOrdSeq">
  <input type="hidden" name="sProSeq" id="sProSeq">
  <input type="hidden" name="sArvStatCd" id="sArvStatCd">
  <input type="hidden" name="shStatSeq" id="shStatSeq" value="0"> 
  <input type="hidden" name="sStatSeq" id="sStatSeq" value="">
  <input type="hidden" name="shType" id="shType" value="">   
  <input type="hidden" name="shValue" id="shValue" value="">   
  <input type="hidden" name="shGo" id="shGo" value="1">   
  <input type="hidden" name="shPageSize" id="shPageSize" value="10">   
</form>
<form name="frmHid" id="frmHid" method="get" action="./Acting_W.asp" target="_blank">
  <input type="hidden" name="ORD_SEQ" id="ORD_SEQ">
</form>
<link href="<?php echo base_url(); ?>assets/dist/css/dashboard.css" rel="stylesheet" type="text/css" />
<script>

  $('.hastip').tooltipsy({
     content: function ($el, $tip) {
        return '<table width="130" cellspacing="5" style="margin-left:10px;"><tbody><tr><td><span class="bold">'+$el.data("uname")+'</span> ('+$el.data("deposit")+'원)</td></tr><tr>      <td>· <a href="/admin/editOld/'+$el.data("userid")+'" target="_blank" class="popMem">회원정보보기</a></td></tr><tr>      <td>· <a href="javascript:fnPopWinCT(\'/admin/sendMail?userid='+$el.data("userid")+'\', \'MemNote\', 700, 510, \'N\');" class="popMem">쪽지보내기</a></td> </tr> <tr>      <td>· <a href="#" class="popMem">SMS 발송</a></td>    </tr>    <tr>      <td>· <a href="javascript:fnPopWinCT(\'/admin/payhistory?member_part=userId&search_txt='+$el.data("userid")+'\', \'ActingMem\', 1200, 700, \'Y\');" class="popMem">주문내역</a></td>    </tr>    <tr>      <td>· <a href="/admin/deposithistory?mem=name&seach_input='+$el.data("uname")+'" target="_blank" class="popMem">예치금 사용내역</a></td>    </tr>    <tr>      <td>· <a href="/admin/paying/?member_part=userId&search_txt='+$el.data("userid")+'" target="_blank" class="popMem">결제내역</a></td>    </tr>    <tr>      <td>· <a href="/admin/couponList/?shType=name&seach_input='+$el.data("uname")+'" target="_blank" class="popMem">쿠폰발급내역</a></td>    </tr>    <tr>      <td>· <a href="/admin/coupon_register?type=name&content='+$el.data("uname")+'" target="_blank" class="popMem">쿠폰발급</a></td>    </tr>    </tbody></table>';
    },
    show: function (e, $el) {
        var cur_top = parseInt($el[0].style.top.replace(/[a-z]/g, ''))-20; 
        $el.css({
            'top': cur_top + 'px',
            'display': 'block'
        })
    },
    offset: [0, 1],
    css: {
        'padding': '15px',
        'color': '#303030',
        'background-color': '#f5f5b5',
        'border': '1px solid #deca7e',
        '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'text-shadow': 'none',
        'cursor':'pointer',
    }
});
  $('.showtracks').tooltipsy({
     content: function ($el, $tip) {
        $.get('/admin/getOT?sOrdSeq='+$el.data('deposit')+"&type="+$el.data("type"), function (data) {
            $tip.html(data);
        });
    },
    offset: [1, 0],
    css: {
        'padding': '5px',
        'color': '#303030',
        'background-color': '#FFF',
        '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'text-shadow': 'none'
    }
});
  function fnProView(val,val1, val2) {
  if ( $("#buyproduct"+val).html() == "" ) {
    $("#order-pro"+val).show();
    var url = "?sViewYN=Y&sOrdSeq="+val; 
    fnGetChgHtmlAjax("buyproduct"+val, "<?=base_url()?>productListing", url);
  } else {
    $("#order-pro"+val).hide();
    fnProClose(val);
    $("#buyproduct"+val).text("");
  }
}

function fnProClose(val) {
  // var url = "?sViewYN=N&sOrdSeq="+val; 
  // fnGetChgHtmlAjax("TextPro"+val, "/Library/Html/Acting/ProListMng_L.asp", url);
}
function fnProArvChg(val1,val2,val3,val4) {
  if (confirm("상태를 변경하시겠습니까?")) {
    jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : "<?=base_url()?>activeProduct",
      data : { sOrdSeq : val1 ,sArvStatCd:val3} 
      }).done(function(data){
        alert("변경되였습니다.");
      });
  }
}



//ajax 상품전체 상태변경
function fnProArvChgAll(val1,val2,val3,val4) {
  var fVal3 = $("#frmList select[name='" + val3 + "']").val();

  if ( fnCkBoxVal( "frmList", val2 ) == "" ) {
    alert("입고상태를 변경할 상품을 선택하십시오.");
    return;
  }

  if ( fVal3 == "" ) {
    alert("입고상태를 선택하십시오.");
    return;
  }

  if (confirm("상태를 변경하시겠습니까?")) {
    $("#frmProArv input[name='sOrdSeq']").val(val1);
    $("#frmProArv input[name='sProSeq']").val(fnCkBoxVal( "frmList", val2 ));
    $("#frmProArv input[name='sArvStatCd']").val(fVal3);
    $("#frmProArv input[name='sStatSeq']").val(val4);

    if ( (fVal3 == "3" || fVal3 == "4") && $("#frmProArv input[name='shStatSeq']").val() == "11" ) {
      $("#frmProArv input[name='shStatSeq']").val("12");
    }

    $("#frmProArv").attr("action", "<?=base_url()?>changeProduct").submit();
  }
}

function fnMoneyIn(val1,val2,val3){
  var Rtn_val;
  Rtn_val = "?ORD_SEQ="+val1+"&ORD_TY_CD="+val2+"&MStep="+val3;
  fnPopWinCT("/admin/setSendingPay"+Rtn_val, "ActingMoney_W_" + val1, 1024, 880, "Y")
 
}

function fnOrdEdit(val) {
  var frmObj = "#frmHid";

  $(frmObj + " input[name='ORD_SEQ']").val(val);
  $(frmObj).attr("method", "get").attr("action", "/admin/ActDelivery").attr("target", "_blank");
  $(frmObj).submit();
}

function fnMngMemo(val1,val2="") {
  var frmObj = "#frmList";  
  var memo_content = val2=="" ? $("#MngMemo"+val1).val():val2;
  if (memo_content == "") {
    alert('메모를 입력하세요.');
    return;
  }

  $("#MngMemo").val(memo_content);
  $(frmObj + " input[name='ORD_SEQ']").val(val1);

  $(frmObj).attr("method", "post").attr("action", "/admin/setMemo");
  $(frmObj).submit();
}

function fnInvoiceReg(sOrdSeq) {
  fnPopWinCT("/admin/setTrackDelivery?sOrdSeq=" + sOrdSeq, "IvcNoReg", 500, 300, "Y");
}

function fnProReturn(sProOrdSeq){
  var frmObj = "#frmList";
  var returns = "";
  $("#sKind").val("R");
  $(frmObj + " input[name='ORD_SEQ']").val(sProOrdSeq);

  if (fnSelBoxCnt($(frmObj + " input[name='chkPRO_"+sProOrdSeq+"']")) <= 0) {
    alert('리턴할 상품을 선택하십시오.');
    return;
  }

  for(var i = 0;i< $(frmObj + " input[name='chkPRO_"+sProOrdSeq+"']").length;i++){
    if($(frmObj + " input[name='chkPRO_"+sProOrdSeq+"']").eq(i)[0].checked){
      returns = returns+ $(frmObj + " input[name='chkPRO_"+sProOrdSeq+"']").eq(i).val();
      returns += "|";
    }
    
  }

  returns = returns.substr(0, returns.length-1);
  $("#returns").val(returns);
  if (confirm("상품을 리턴 하시겠습니까?\n리턴시 복구가 불가능합니다.")) { 
    document.frmList.encoding = "multipart/form-data";
    $(frmObj).attr("method", "post").attr("action", "/admin/ActReturn").attr("target", "prcFrm");
    $(frmObj).submit();
  }
}

function fnOrdComment(val,val1){
  fnPopWinCT("<?=base_url()?>Comment_W?sOrdSeq="+val+"&ordernum="+val1, "Comment_W", 700, $(window).height(), "Y")
}
  function fnChgFrgOrd(val1,val2){

    if ($("#sSHOP_ORD_NO_"+val1+"_"+val2).val()==""){
      alert('샵 주문번호 정보를 넣으세요!');
    }else{ 
      var url = "changeOrderNUmber?"
        + "sKind=T&sOrdSeq="+ val1 + "&sProSeq="+val2 + "&sSHOP_ORD_NO="+$("#sSHOP_ORD_NO_"+val1+"_"+val2).val();
      //  alert(url);
      var returnvalue="";
    
      returnvalue = DoCallbackCommon(url);
   
      if (returnvalue > 0)
      {
        alert("정상적으로 등록되었습니다.");
      }else{
        alert("등록에 실패했습니다.");
      }
    }
  }


  function fnChgFrgIvc(val1,val2){
  if ($("#sFRG_DLVR_COM_"+val1+"_"+val2).val()=="" || $("#sFRG_IVC_NO_"+val1+"_"+val2).val()==""){
    alert('등록할 트래킹 정보를 넣으세요!');
  }else{
    var url = "<?=base_url()?>changeTracks?"
      + "sKind=T&sOrdSeq="+ val1 + "&sProSeq="+val2 + "&sFRG_DLVR_COM="+$("#sFRG_DLVR_COM_"+val1+"_"+val2).val() + "&sFRG_IVC_NO="+$("#sFRG_IVC_NO_"+val1+"_"+val2).val();
    //  alert(url);
    var returnvalue="";
  
    returnvalue = DoCallbackCommon(url);
 
    if (returnvalue)
    {
      alert("정상적으로 등록되었습니다.");
    }else{
      alert("등록에 실패했습니다.");
    }

  }
}
function fnBoxCnt(val1,val2) {
  jQuery.ajax({
    type : "POST",
    url : "<?=base_url()?>Box_Cnt_M",
    data : { sOrdSeq : val1 ,state:val2} 
    }).done(function(data){
      if(data=100) alert("변경되였습니다.");
      else alert("변경실패");
  });
}
function fnChaView(id){

    jQuery.ajax({
      type : "POST",
      url : baseURL+"getDelivery",
      data : { delivery_id : id } 
      }).done(function(data){
        $("#details_modal").modal("show");
        $("#details_modal .modal-body").html(data);
    });
  }

  function goTo(url){
    window.location.href = url;
  }
  
  function fnMoneyReset(pSeq,state) {
    if (confirm("해당 주문 건의 비용을 리셋하시겠습니까?\n리셋을 하시면 전상태로 이동됩니다.")) {
      window.location.href = "/admin/Acting_D?sOrdSeq=" + pSeq+"&state="+state;
    }
  }
  function fnOrdDel() {
    var frmObj = "#frmList";
    if (fnSelBoxCnt($(frmObj + " input[name='chkORD_SEQ[]']")) <= 0) {
      alert('삭제할 주문을 선택하십시오.');
      return;
    }

    if (confirm("주문을 삭제 하시겠습니까?\n삭제시 복구가 불가능합니다.")) {
      document.frmList.encoding = "application/x-www-form-urlencoded"; 
      $("#frmList").attr("method", "post").attr("action", "/admin/Acting_Del");
      $("#frmList").submit();
    }
  }
  function fnIvcNoPrt(sOrdSeq) {
    fnPopWinCT("/admin/trackPaper?sOrdSeq=" + sOrdSeq, "IvcNoPrt", 752, 608, "Y");
  }
  function fnCstmSearch(IvcNo) {
    fnPopWinCT("http://portal.customs.go.kr/kcsipt/portal_link.jsp?portalGoToLink=inform_5&iFrameGoToLink=/StaPt/StaInfoOfferAction_3.do?method=viewImpCargoProgInfoEach", "CustomsSearch", 1000, 600, "Y");
  }
  function fnPageExlUp(){ 
    fnPopWinCT("/admin/ActingExcel_W", "엑셀 업로드", 520, 150, "Y")
  }
</script>