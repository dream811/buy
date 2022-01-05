<?php 
    error_reporting(E_ERROR | E_PARSE);
    
    if($_GET['ORD_TY_CD']!=4 && empty($delivery)) {$pprice = 0;echo '입고완료된 상품이 없습니다.';return;}
    $pprice =0;
    $per = empty($ddd) ? 10:$ddd;
    $currency = "0";
    $pur_fee = "0"; 
    $pur_fee= $fee_by = empty($delivery[0]->buy_fee) ? 0 : $delivery[0]->buy_fee; 
    if($_GET['ORD_TY_CD']==4 && empty($delivery)) {
        $delivery[0]->id="";
        $delivery[0]->gwan = 0;
        $delivery[0]->add_price =0;
        $delivery[0]->gwan =0;
        $delivery[0]->pegi =0;
        $delivery[0]->cart_bunhal = 0;
        $delivery[0]->check_custom = 0;
        $delivery[0]->gwatae = 0;
        $delivery[0]->v_weight = 0;
    }
    if($_GET['ORD_TY_CD']!=4 && !empty($delivery)) {$pprice = $delivery[0]->pprice;}
    if($_GET['ORD_TY_CD']==2 && !empty($delivery)) {
        $tt = explode("|", $delivery[0]->pur_fee);
        $currency = !empty($tt[2]) ? $tt[2]:$accuringRate->rate;
        $pprice = !empty($tt[1]) && $tt[2] > 0 ? $tt[1]/$tt[2]:$pprice;
        $pur_fee = $tt[0];
    }
    if(!empty($none)):
        echo "<script>alert('".$none."');self.close();</script>";
        return;
    endif;
    $weights=array();
    if(!empty($deli)): 
        $halin = $delivery[0]->sending_inul;
        $address_rate = json_decode($delivery[0]->address_rate,true);
        if(isset($address_rate[$delivery[0]->place]))
            $halin = $address_rate[$delivery[0]->place];
        $startWeight=0;
        $start1= 0;
        $start2=0;
        $startPrice = 0;
        foreach($deli as $value):
            $start1 = $value->startWeight;
            $start2 = $value->endWeight;  
            $startPrice = $value->startPrice;
            while($start1<=$start2){    
                array_push($weights,array("weight"=>$start1,"price"=>$startPrice*$halin));
                $start1 = $start1 + $value->weight;
                $startPrice = $startPrice + $value->goldSpace;
            } 
        endforeach;
    endif;

    $service= json_decode($delivery[0]->content,true);
    $symbol = "￥";
    if($delivery[0]->type ==3){
        $symbol = "원";
    }
?>
<?php $weight = ""; ?>
<?php if($delivery[0]->addid ==3) $weight="CBM";else $weight = "kg"; ?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/dist/css/sendingPopup.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
</head>
<body style="background: none;">
    <div class="pop-title">
        <p>금액 측정</p>
    </div>

    <div id="pop_wrap">
        <form action="" method="post" class="boardSearchForm" name="PayInf" id="PayInf">
            <input type="hidden" name="ORD_SEQ" id="ORD_SEQ" value="<?=$ORD_SEQ?>">
            <input type="hidden" name="PRO_AMT" id="PRO_AMT" value="<?=$pprice?>">
            <input type="hidden" name="CHA_CD" id="CHA_CD" value="">
            <input type="hidden" name="DAL_BUY_MNY" id="DAL_BUY_MNY" value="">
            <input type="hidden" name="ETC_FEE_MNY" id="ETC_FEE_MNY" value="0">
            <input type="hidden" name="REG_TY_CD" id="REG_TY_CD" value="3">
            <input type="hidden" name="DLVR_PMT_MNY" id="DLVR_PMT_MNY" value="0">
            <input type="hidden" name="fee_list" id="fee_list" value="">
            <input type="hidden" name="ppp" id="ppp" value="">
            <input type="hidden" id="delviery_type" value="<?=$delivery[0]->type?>">
        <?php  if($_GET['ORD_TY_CD'] ==1): ?>
            <div>

                <div class="orderStepTit">
                    <h4>배송비용</h4>
                </div>

                <table cellpadding="0" cellspacing="0" border="0" class="order_write">
                    <colgroup>
                        <col width="18%">
                            <col width="32%">
                                <col width="18%">
                                    <col width="32%">
                    </colgroup>
                    <input type="hidden" name="CTR_FEE" id="CTR_FEE" maxlength="10" style="width: 74%;" onblur="fnNumChiperCom(this, '0');fnDlvrPrice();" class="input_txt2" value="0">
                    <tbody>
                        <tr>
                            <th>배송구분</th>
                            <td colspan="3"><span class="bold red1">개인전자상거래</span></td>
                        </tr>
                        <tr>
                            <th>상품 총 금액</th>
                            <td><span class="bold red1"><?=number_format($pprice)?><?=$symbol?></span></td>
                            <th>통관수수료</th>
                            <td>
                                <input type="text" name="CTM_FEE" id="CTM_FEE" maxlength="10" style="width: 30%;" onblur="fnNumChiperCom(this, '0');fnDlvrPrice();" class="input_txt2" value="0"> 개인통관 수수료 부과원
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p class="clrBoth pHt20"></p>

                <div class="orderStepTit">
                    <h4>부가서비스</h4>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="order_write">
                    <colgroup>
                        <col width="18%">
                            <col width="32%">
                                <col width="18%">
                                    <col width="32%">
                    </colgroup>
                    <tbody>
                        
                            <?php if(!empty($a)): ?>
                            <?php $aa=array_chunk($a, 2); ?>
                            <?php foreach($aa as $ca): ?>
                        <tr>
                            <?php foreach($ca as $ak): ?>
                            <th>
                                <label>
                                    <input type="checkbox" name="EtcDlvr" id="EtcDlvr" onclick="fnDlvrPrice();" value="<?=$ak->id?>" 
                                    <?php if(isset($service[$ak->id]) && $service[$ak->id]>=0) echo 'checked'; ?>><span 
                                    class="<?php if(isset($service[$ak->id]) && $service[$ak->id]>=0):?>text-danger <?php  endif; ?>"><?=$ak->name?></span>
                                </label>
                            </th>
                            <td>
                                <input type="text" name="ETC_FEE" id="ETC_FEE" tycd="29" mny="0" maxlength="10" style="width: 30%;" onblur="fnNumChiperCom(this, '0');fnDlvrPrice();" class="input_txt2" 
                                value="<?=isset($service[$ak->id]) && $service[$ak->id] >=0 ? $service[$ak->id] : $ak->price ?>">
                                <input type="hidden" name="COST_LBL" id="COST_LBL" value="3"> 원
                            </td>
                            <?php endforeach; ?>
                        </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                    </tbody>
                </table>

                <p class="clrBoth pHt20"></p>

                <div class="orderStepTit">
                    <h4>무게정보</h4>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="order_write">
                    <colgroup>
                        <col width="18%">
                            <col width="32%">
                                <col width="18%">
                                    <col width="32%">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>실무게</th>
                            <td colspan="3">
                                <div id="SelMemWt">
                                    <input type="hidden" name="LVL_MNY" id="LVL_MNY" value="<?=$delivery[0]->real_weight?>">
                                    <input type="type" name="REAL_WT" id="REAL_WT" class="input_txt2" onblur="fnDlvrPrice();fnNumChiperCom(this, '2');" value="<?=$delivery[0]->real_weight?>">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>부피무게</th>
                            <td colspan="3">
                                가로
                                <input type="text" name="WIDTH_INCH" id="WIDTH_INCH" maxlength="6" size="4" onblur="fnNumChiperCom(this, '0');fnDlvrPrice();" class="input_txt2" value="<?=$delivery[0]->width?>">&nbsp;&nbsp; 세로
                                <input type="text" name="VER_INCH" id="VER_INCH" maxlength="6" size="4" onblur="fnNumChiperCom(this, '0');fnDlvrPrice();" class="input_txt2" value="<?=$delivery[0]->length?>">&nbsp;&nbsp; 높이
                                <input type="text" name="HEIGHT_INCH" id="HEIGHT_INCH" maxlength="6" size="4" onblur="fnNumChiperCom(this, '0');fnDlvrPrice();" class="input_txt2" value="<?=$delivery[0]->height?>">&nbsp;&nbsp; 적용율
                                <input type="text" name="VLM_APPL_RT" id="VLM_APPL_RT" maxlength="6" size="4" onblur="fnNumChiperCom(this, '0');fnDlvrPrice();" class="input_txt2"  value="<?=$delivery[0]->accept_rate?>">%&nbsp;&nbsp; 무게
                                <input type="text" name="VLM_WT" id="VLM_WT" maxlength="6" size="4" readonly="" class="input_txt2" value="0">kg

                                <input type="hidden" name="VLM_WT_FEE" id="VLM_WT_FEE" class="input_txt2" value="0">
                            </td>
                        </tr>
                        <tr>
                            <th>최종 무게</th>
                            <td>
                                <div id="SelMemWt">
                                    <select name="MEM_WT" id="MEM_WT" onchange="fnDlvrPrice();">
                                        <option value="0" mny="0">0<?=$weight?> : 0</option>
                                        <?php for($ii=0;$ii<sizeof($weights);$ii++){ ?>
                                            <?php if(empty($weights[$ii])) continue; ?>
                                            <option value="<?=$weights[$ii]['weight']?>" mny="<?=$weights[$ii]['price']?>"><?=$weights[$ii]['weight']?><?=$weight?> : <?=$weights[$ii]['price']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </td>
                            <th>환율비율</th>
                            <td>
                                <input type="hidden" name="LVL_SAEL_MNY" id="LVL_SAEL_MNY" maxlength="10" style="width: 74%;" value="0">
                                <input type="text" name="EXG_RT" id="EXG_RT" maxlength="10" style="width: 74%;" onblur="fnNumChiperCom(this, '0');fnDlvrPrice();" class="input_txt2" value="<?=$bExtMny?>"> 원
                            </td>
                        </tr>
                        <tr>
                            <th>배송비금액</th>
                            <td colspan="3">
                                <input type="text" name="DLVR_MNY" id="DLVR_MNY" maxlength="10" style="width: 25%;" onblur="fnNumChiperCom(this, '0');" class="input_txt2" value="0" readonly=""> 원&nbsp;&nbsp;&nbsp;
                                <input type="hidden" name="DLVR_SALE_MNY" id="DLVR_SALE_MNY" maxlength="10" style="width: 25%;" onblur="fnNumChiperCom(this, '0');" class="input_txt2" value="16,000" readonly="">
                            </td>
                        </tr>
                        <tr>
                            <th>현재예치금</th>
                            <td colspan="3">
                                <span class="bold red1"><?=$deposits?>원</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="btn-area" style="text-align:center;">
                    <select name="sSMS_SEND_YN" id="sSMS_SEND_YN" class="vm">
                        <option value="">SMS 발송안함</option>
                        <option value="1">SMS 회원발송</option>
                        <option value="2">SMS 수취인발송</option>
                    </select>
                    <span class="whGraBtn_bg ty2">
				<button type="button" class="txt" onclick="fnActingfMny1();">배송금액저장</button>
			</span>&nbsp;
                    <span class="whGraBtn ty2">
				<button type="button" class="txt" onclick="self.close();">닫기</button>
			</span>
                </div>

            </div>
            
        <?php endif; ?>
        <?php  if($_GET['ORD_TY_CD'] ==2): ?>
            <div>
                <div class="orderStepTit">
                    <h4>구매비용</h4>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table cellpadding="0" cellspacing="0" border="0" class="order_write" style="width: 100%">
                        <colgroup>
                            <col width="18%">
                            <col width="32%">
                            <col width="18%">
                            <col width="32%">
                        </colgroup>
                        <input type="hidden" name="CTR_FEE" id="CTR_FEE" maxlength="10" style="width: 74%;" onblur="fnNumChiperCom(this, '0');fnDlvrPrice();" class="input_txt2" value="0">
                        <tbody>
                            <tr>
                                <th>구매금액</th>
                                <td colspan="3"><span class="bold red1"><?=number_format((float)$pprice)?><?=$symbol?></span></td>
                            </tr>
                            <tr>
                                <th>회원구매 수수료</th>
                                <td><input type="text" name="BUY_FEE_RT" id="BUY_FEE_RT" maxlength="10"  onblur="fnNumChiperCom(this, '0');fnBuyPrice();" class="input_txt2" value="<?=empty($pur_fee) ? $fee_by : $pur_fee?>"> %</td>
                                <th>현지 배송비  </th>
                                <td>
                                    <input type="text" name="BUY_FEE" id="BUY_FEE" maxlength="10" onblur="fnNumChiperCom(this, '2');fnBuyPrice();"  class="input_txt2" value="<?=!empty($delivery[0]->cur_send) ? $delivery[0]->cur_send:0?>">
                                </td>
                            </tr>
                            <tr>
                                <th>환율비율</th>
                                <td>
                                    <input type="text" name="BUY_EXG_RT_MNY" id="BUY_EXG_RT_MNY" maxlength="10"  onblur="fnNumChiperCom(this, '0');fnBuyPrice();" class="input_txt2" value="<?=$currency?>">
                                </td>
                                <th>구매금액</th>
                                <td>
                                    <input type="text" name="BUY_MNY" id="BUY_MNY" maxlength="10"  class="input_txt2" value="<?=$TotalBuyMny?>" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>    
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-12 text-center">
                        <a href="javascript:fnActingfMny2();" class="btn btn-primary btn-sm">구매금액저장</a>
                        <a href="#" class="btn btn-secondary btn-sm" onclick="self.close();">닫기</a>
                    </div>
                </div>
            </div>    
        <?php endif; ?>
        <?php  if($_GET['ORD_TY_CD'] ==3): ?>
            <div>
                <div class="orderStepTit">
                    <h4>리턴비용</h4>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table cellpadding="0" cellspacing="0" border="0" class="order_write" style="width: 100%">
                        <colgroup>
                            <col width="18%">
                                <col width="32%">
                                    <col width="18%">
                                        <col width="32%">
                        </colgroup>
                        <input type="hidden" name="CTR_FEE" id="CTR_FEE" maxlength="10" style="width: 74%;" onblur="fnNumChiperCom(this, '0');fnDlvrPrice();" class="input_txt2" value="0">
                        <tbody>
                            <tr>
                                <th>환율비율</th>
                                <td><input type="text" name="BUY_EXG_RT_MNY" id="BUY_EXG_RT_MNY" maxlength="10"  onblur="fnNumChiperCom(this, '0');fnRtnPrice();" class="input_txt2" value="<?=$bExtMny?>"></td>
                                <th>리턴금액(원) </th>
                                <td>
                                    <input type="text" name="RTN_FREE" id="RTN_FREE" maxlength="10"  class="input_txt2" 
                                    value="0" onblur="fnNumChiperCom(this, '0');fnRtnPrice();">
                                </td>
                            </tr>
                            <tr>
                                <th>리턴 수수료</th>
                                <td><input type="text" name="RTN_FEE" id="RTN_FEE" maxlength="10" onblur="fnNumChiperCom(this, '0');fnRtnPrice();" class="input_txt2"    
                                    value="<?=!empty($delivery[0]->rfee) ? $delivery[0]->rfee : $custom_fee[0]->return_fee ?>"> 
                                    <button type="button" class="txt" id="btnRtnFee" onClick="fnRtnFeeAppl('<?=$custom_fee[0]->return_fee?>');">미적용</button></td>
                                <th>리턴금액(원)</th>
                                <td><input type="text" name="RTN_FREE_WON" id="RTN_FREE_WON" maxlength="10"  class="input_txt2" 
                                    value="<?=!empty($delivery[0]->return_price) ? $delivery[0]->return_price : 0 ?>" readonly=""></td>
                            </tr>
                        </tbody>
                    </table>
                </div>    
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-12 text-center">
                        <a href="javascript:fnActingfMny4();" class="btn btn-primary btn-sm">리턴금액저장</a>
                        <a href="#" class="btn btn-secondary btn-sm" onclick="self.close();">닫기</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php  if($_GET['ORD_TY_CD'] ==4): ?>
            <div>
                <div class="orderStepTit">
                    <h4>추가결제비용</h4>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table cellpadding="0" cellspacing="0" border="0" class="order_write" style="width: 100%">
                        <colgroup>
                            <col width="18%">
                            <col width="32%">
                            <col width="18%">
                            <col width="32%">
                        </colgroup>
                        <input type="hidden" name="id" value="<?=$delivery[0]->id?>">
                        <input type="hidden" name="CTR_FEE" id="CTR_FEE" maxlength="10" style="width: 74%;" onblur="fnNumChiperCom(this, '0');fnDlvrPrice();" class="input_txt2" value="0">
                        <tbody>
                            <tr>
                                <th>관/부가세</th>
                                <td>
                                    <input type="hidden" name="FIVE_FEE_TY"  value="19">
                                    <input type="hidden" name="FIVE_FEE_CRR_TY"  value="3">
                                    <input type="text" name="gwan"  mny="19|0" maxlength="10" style="width: 40%;" onblur="fnNumChiperCom(this, '0');fnFivePrice();" class="FIVE_FEE" 
                                    value="<?=!empty($delivery[0]->gwan) ? $delivery[0]->gwan : $custom_fee[0]->tax_fee ?>">원
                                </td>
                                <th>폐기수수료</th>
                                <td>
                                    <input type="hidden" name="FIVE_FEE_TY" value="14">
                                    <input type="hidden" name="FIVE_FEE_CRR_TY"  value="3">
                                    <input type="text" name="pegi" mny="14|3000" maxlength="10" style="width: 40%;" onblur="fnNumChiperCom(this, '0');fnFivePrice();" class="FIVE_FEE" 
                                    value="<?=!empty($delivery[0]->pegi) ? $delivery[0]->pegi : $custom_fee[0]->throw_price?>">원
                                </td>
                            </tr>
                            <tr>
                                <th>검역수수료</th>
                                <td>
                                    <input type="hidden" name="FIVE_FEE_TY" value="16">
                                    <input type="hidden" name="FIVE_FEE_CRR_TY"  value="3">
                                    <input type="text" name="check_custom"  mny="16|0" maxlength="10" style="width: 40%;" onblur="fnNumChiperCom(this, '0');fnFivePrice();" class="FIVE_FEE" 
                                    value="<?=!empty($delivery[0]->check_custom) ? $delivery[0]->check_custom:$custom_fee[0]->quarantine?>">원
                                </td>
                                <th>카툰분할 수 신고/BL 분할</th>
                                <td>
                                    <input type="hidden" name="FIVE_FEE_TY"  value="15">
                                    <input type="hidden" name="FIVE_FEE_CRR_TY"  value="3">
                                    <input type="text" name="cart_bunhal"  mny="15|5500" maxlength="10" style="width: 40%;" onblur="fnNumChiperCom(this, '0');fnFivePrice();" class="FIVE_FEE" 
                                    value="<?=!empty($delivery[0]->cart_bunhal) ? $delivery[0]->cart_bunhal:$custom_fee[0]->carton_price?>">원
                                </td>
                            </tr>
                            <tr>
                                <th>과태료</th>
                                <td>
                                    <input type="hidden" name="FIVE_FEE_TY"  value="18">
                                    <input type="hidden" name="FIVE_FEE_CRR_TY"  value="3">
                                    <input type="text" name="gwatae"  mny="18|0" maxlength="10" style="width: 40%;" onblur="fnNumChiperCom(this, '0');fnFivePrice();" class="FIVE_FEE" 
                                    value="<?=!empty($delivery[0]->gwatae) ? $delivery[0]->gwatae :$custom_fee[0]->gate_fee?>">원</td>
                                <th>부피무게</th>
                                <td>
                                    <input type="hidden" name="FIVE_FEE_TY"  value="17">
                                    <input type="hidden" name="FIVE_FEE_CRR_TY"  value="3">
                                    <input type="text" name="v_weight"  mny="18|0" maxlength="10" style="width: 40%;" 
                                    onblur="fnNumChiperCom(this, '0');fnFivePrice();" 
                                    class="FIVE_FEE" 
                                    value="<?=!empty($delivery[0]->v_weight) ? $delivery[0]->v_weight:$custom_fee[0]->volumn_price?>">원
                                </td>
                            </tr>
                            <tr>
                                <th>환율비율</th>
                                <td><input type="text" name="FIVE_EXG_RT" id="FIVE_EXG_RT" maxlength="10" style="width: 74%;" onblur="fnNumChiperCom(this, '0');fnFivePrice();" class="input_txt2" 
                                    value="<?=!empty($delivery[0]->accurate) ? $delivery[0]->accurate:$bExtMny?>">
                                </td>
                                <th>기타 추가비용</th>
                                <td>
                                    <input type="hidden" name="FIVE_FEE_TY"  value="27">
                                    <input type="hidden" name="FIVE_FEE_CRR_TY"  value="3">
                                    <input type="text" name="add_fee"  mny="27|0" maxlength="10" style="width: 40%;" onblur="fnNumChiperCom(this, '0');fnFivePrice();" class="FIVE_FEE" 
                                    value="<?=!empty($delivery[0]->add_fee) ? $delivery[0]->add_fee :$custom_fee[0]->add_fee?>">원
                                </td>
                            </tr>
                            <tr>
                                
                                <th>추가결제금액</th>
                                <td>
                                    <input type="text" name="FIVE_MNY" id="FIVE_MNY" maxlength="10" style="width: 74%;" onblur="fnNumChiperCom(this, '0');fnFivePrice();" class="input_txt2" value="<?=$delivery[0]->add_price?>" readonly="">원
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>    
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-12 text-center">
                        <select name="sSMS_SEND_YN" id="sSMS_SEND_YN" class="vm btn">
                            <option value="">SMS 발송안함</option>
                            <option value="1">SMS 회원발송</option>
                            <option value="2">SMS 수취인발송</option>
                        </select>
                        <a href="javascript:fnActingfMny5();" class="btn btn-primary btn-sm">추가결제금액</a>
                        <a href="#" class="btn btn-default btn-sm" onclick="self.close();">닫기</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        </form>
    </div>
<script src="<?php echo base_url(); ?>assets/js/head.js"></script>
<script>
    var weight = [];
    <?php if(!empty($weights)): ?>
    <?php foreach($weights as $ch): ?>
    weight.push(<?=$ch['weight']?>);    
    <?php endforeach; ?>
    <?php endif; ?>
     <?php if($this->input->get("ORD_TY_CD") ==1): ?>
    fnDlvrPrice();
    <?php endif; ?>
    <?php if($this->input->get("ORD_TY_CD") ==2): ?>
    fnBuyPrice();
    <?php endif; ?>
    <?php if($this->input->get("ORD_TY_CD") ==4): ?>
    fnFivePrice();
    <?php endif; ?>
    function fnNumChiperCom(sObj, sChiper) {
        var sNum = sObj.value;
        var sDot = 0, sPm = "";

        sNum = sNum.replace(/,/g, "");
        sNum = isNaN(sNum) == true ? sDot : sNum;

        if ( sNum < 0 ) {
            sPm = "-";
        }

        sNum = Math.abs(sNum);
        //sNum = Math.round(sNum);
        sNum = sNum.toFixed(sChiper);
        sObj.value = sPm + "" + fnNumComma(sNum);
    }

    function fnDlvrPrice(){
        var frmObj  = "#PayInf";
        var sExgRt = $("#EXG_RT").val().replace(/,/g, "");
            sExgRt = Number( sExgRt);
        var sCtrFee = $("#CTR_FEE").val().replace(/,/g, "");
            sCtrFee = Number( sCtrFee);
        var sCtmFee = $("#CTM_FEE").val().replace(/,/g, ""); 
            sCtmFee = Number( sCtmFee);
        var sFeeAdd = $("#LVL_SAEL_MNY").val().replace(/,/g, ""); 
            sFeeAdd = Number( sFeeAdd);
        var sRealWt = Number( $("#REAL_WT").val() );
        var sMemWtMny  = $("#MEM_WT option:selected").attr("mny");
        var sLvlSaelMny = $("#LVL_SAEL_MNY").val(); 
            sLvlSaelMny = Number( sLvlSaelMny);
        var aVlm = "";
        var sVlmWt = Number($("#VLM_WT").val()); 
        var sVlmWtReal = 0;
        var sVlmMny = 0; 
        var sMemWt = 0;
        var sWidthInch = Number($("#WIDTH_INCH").val());
        var sVerInch = Number($("#VER_INCH").val());
        var sHeightInch = Number($("#HEIGHT_INCH").val()); 
        var sNowWtMny = 0, sSaleWtMny = 0;
        var sVlmApplRt = Number( $("#VLM_APPL_RT").val() );
        var TotalDlvrMny = 0, TotalDlvrSaleMny = 0;
        var sHalfLimit = 20; // 반값배송인 경우 20lb 제한
        var sCifFee = 0, sCifProAmt = 1500; // 보험가입 시 5%, 1500위안 이상
        var ETC_FEE_MNY = "";
        var sProAmt = Number( $(frmObj + " input[name='PRO_AMT']").val() );

        //부피 무게
        //sVlmWt = (sWidthInch*sVerInch*sHeightInch)/166;
        sVlmWt = (sWidthInch.toFixed(2)*sVerInch.toFixed(2)*sHeightInch.toFixed(2))/6000;
        //sVlmWt = Math.ceil(sVlmWt);
        
        sRealWt = weight.find(element => element >= sRealWt);

        sVlmWtReal = fnUnitKgWt( ( sVlmApplRt / 100 ) * sVlmWt );

        $("#VLM_WT").val( sVlmWt.toFixed(2) );

        //선택 무게보다 크면 체크
        if (sVlmWtReal > sRealWt){
            $("#MEM_WT").val(sVlmWtReal);
            //sNowWtMny = sVlmMny;
        }else{  
            $("#MEM_WT").val(sRealWt);
            //sNowWtMny = sRealFee;
        }

        sMemWtMny = $("#MEM_WT option:selected").attr("mny");
        TotalDlvrMny     = (Number(sCtrFee) + Number(sCtmFee) + Number(sMemWtMny) + Number(sLvlSaelMny)) + Number(sFeeAdd);
        // 기타 부가 수수료
        $(frmObj + " input[name='EtcDlvr']").each( function(idx) {
            if ( $(this).prop("checked") == true ) {

                // 보험가입(tyCd='28') 일때
                if ( $(frmObj + " input[name='ETC_FEE']").eq(idx).attr("tyCd") == "28" ) {
                    var fPer = $(frmObj + " input[name='ETC_FEE']").eq(idx).attr("mny"), fMny = 0;

                    // 보험가입 가능
                    if ( Number(sProAmt) >= Number(sCifProAmt) ) {
                        fMny = Number(sProAmt) * ( Number(fPer)/100 ); // 제품 금액 * 보험가입(%)
                        fMny = Number(fMny) * Number(sExgRt);
                        fMny = fnNumRound(fMny, 10);
                        $(frmObj + " input[name='ETC_FEE']").eq(idx).val(fMny);

                        ETC_FEE_MNY = ETC_FEE_MNY == "" ? fMny : ETC_FEE_MNY + "," + fMny;
                        TotalDlvrMny += Number(fMny);
                    } else {
                        // 체크 해제
                        $(this).prop("checked", false);
                        $(frmObj + " input[name='ETC_FEE']").eq(idx).val("0");
                    }
                } else {
                    // 보험가입 외 수수료
                    var COST_LBL = $("input[name='COST_LBL']").eq(idx).val();
                    //alert(COST_LBL);
                    

                    ETC_FEE_MNY = ETC_FEE_MNY == "" ? $(frmObj + " input[name='ETC_FEE']").eq(idx).val().replace(/,/g, "") : ETC_FEE_MNY + "," + $(frmObj + " input[name='ETC_FEE']").eq(idx).val().replace(/,/g, "");

                    //  배송비용 측정시 위안 일경우 환율 적용 하여 계산 
                    if (COST_LBL == "3"){
                        TotalDlvrMny += $(frmObj + " input[name='ETC_FEE']").eq(idx).val().replace(/,/g, "") * 1
                    }else if(COST_LBL == "1"){
                        TotalDlvrMny += $(frmObj + " input[name='ETC_FEE']").eq(idx).val().replace(/,/g, "") * 1* sExgRt;   
                    }
                    // alert(TotalDlvrMny);
                }
            }
        });
        $(frmObj + " input[name='ETC_FEE_MNY']").val(ETC_FEE_MNY);

        TotalDlvrMny = TotalDlvrMny/10;
        TotalDlvrMny = (TotalDlvrMny.toFixed(0))*10;
        TotalDlvrSaleMny = TotalDlvrMny;
        $("#LVL_MNY").val( fnNumComma(sMemWtMny) );
        $("#DLVR_MNY").val( fnNumComma(TotalDlvrMny) );
        $("#DLVR_PMT_MNY").val( fnNumComma(sSaleWtMny) );
        $("#DLVR_SALE_MNY").val( fnNumComma(TotalDlvrSaleMny) );
    }

    function fnUnitKgWt(Num) {
       return weight.find(element => element >= Num);
    }

    function fnNumComma(str) {

       var str = "" + str;
       var objRegExp = new RegExp("(-?[0-9]+)([0-9]{3})");
       while (objRegExp.test(str)) {
          str = str.replace(objRegExp, "$1,$2");
       }
       return str;
    }

    function fnActingfMny1(){
        var feeList ="";
        var frmObj  = "#PayInf";
        if ( $("#MEM_WT").val() == "0" || $("#DLVR_MNY").val() == "NaN"  ) {
            alert("무게가 입력되지 않았습니다.");
            return;
        }

        if ( !fnIptChk($("#DLVR_MNY")) || $("#DLVR_MNY").val() =="0" ) {
            fnMsgFcs($("#DLVR_MNY"), '배송금액을 입력해 주세요.');
            return;
        }
        $("#CHA_CD").val('1');
        $(frmObj + " input[name='EtcDlvr']").each( function(idx) {
            if ( $(this).prop("checked") == true ) {
                feeList = feeList+$(this).val()+",";
            }
        });    
        feeList = remove_character(feeList,feeList.length-1);
        $("#fee_list").val(feeList);
        $("#ppp").val($("#MEM_WT option:selected").attr("mny"));
        $(frmObj).attr("action", "./ActiveMoney").attr("target", "");
        $(frmObj).submit();
    }
    function fnIptChk( pObj ) {
        var fObj = pObj;
        var fTf = false;
        if ( $.trim(fObj.val()) == "" ) fTf = false;
        else fTf = true;
        return fTf;
    }

    function remove_character(str, char_pos) 
    {
        part1 = str.substring(0, char_pos);
        part2 = str.substring(char_pos + 1, str.length);
        return (part1 + part2);
    }

    function fnBuyPrice(){
        var sAmt = $("#PRO_AMT").val().replace(/,/g, "");
            sAmt = Number(sAmt);
        var bExtMny = $("#BUY_EXG_RT_MNY").val().replace(/,/g, "");
            bExtMny = Number(bExtMny);
        var bMemRt = $("#BUY_FEE_RT").val().replace(/,/g, "");
            bMemRt = Number(bMemRt);
        var sBuyFee  = $("#BUY_FEE").val().replace(/,/g, "");
            sBuyFee = Number(sBuyFee);
        var TotalBuyMny = 0;    
        debugger;
        TotalBuyMny = ((sAmt+sBuyFee)*bExtMny + ( (sAmt+sBuyFee)*bExtMny*bMemRt)/100)/10;
        TotalBuyMny = parseInt(TotalBuyMny*10);
        $("#BUY_MNY").val(fnNumComma(TotalBuyMny));
    } 

    function fnActingfMny2(){
        var d  =<?=$pprice?>;
        if(d <=0 ) {
            alert("입고완료된 상품이 한개도 없습니다.");
            return;
        }
        var frmObj  = "#PayInf";
        if ( !fnIptChk($("#BUY_MNY")) || $("#BUY_MNY").val() =="0" ) {
            fnMsgFcs($("#BUY_MNY"), '구매금액을 입력해 주세요.');
            return;
        }  
        $("#CHA_CD").val('2');
        $(frmObj).attr("action", "/admin/ActiveMoney").attr("target", "");
        $(frmObj).submit();
    }

    function fnActingfMny4(){
        var frmObj  = "#PayInf";
        $("#CHA_CD").val('4');
        $(frmObj).attr("action", "/admin/ActiveMoney").attr("target", "");
        $(frmObj).submit();
    }

    function fnRtnPrice(){

        var bExtMny = $("#BUY_EXG_RT_MNY").val().replace(/,/g, "");
            bExtMny = Number( bExtMny);
        var sRtnMny = $("#RTN_FREE").val().replace(/,/g, "");;
            sRtnMny = Number( sRtnMny);
        var sRtnFee = $("#RTN_FEE").val().replace(/,/g, "");
            sRtnFee = Number( sRtnFee);
        var TotalRtnMny = 0;

        TotalRtnMny = ( (sRtnMny + sRtnFee) * 1)/10; // 원화는 1
        TotalRtnMny = (TotalRtnMny.toFixed(0))*10;
        $("#RTN_FREE_WON").val( fnNumComma(TotalRtnMny));
    }

    function fnRtnFeeAppl(pMny) {
        // 적용
        if ( $("#btnRtnFee").text() == "적용" ) {
            $("#RTN_FEE").val( fnNumComma(pMny) );
            $("#btnRtnFee").text("미적용");
        } else {
            $("#RTN_FEE").val("0");
            $("#btnRtnFee").text("적용");
        }
        fnRtnPrice();
    }

    function fnFivePrice(){
        var sAmtUsd = 0, sAmtKRw = 0, sSeq = "";

        $("#PayInf input[name='FIVE_FEE_TY']").each( function(idx) {
            if ( $("#PayInf input[name='FIVE_FEE_CRR_TY']").eq(idx).val() == "3" ) {
                sAmtKRw += Number( $("#PayInf input[class='FIVE_FEE']").eq(idx).val().replace(/,/g, "") );
            } else {
                sAmtUsd += Number( $("#PayInf input[class='FIVE_FEE']").eq(idx).val().replace(/,/g, "") );
            }
        });

        var bExtMny = $("#FIVE_EXG_RT").val().replace(/,/g, "");
        var TotalFiveMny = 0;
        TotalFiveMny = ( Number(sAmtUsd) * 1 ); // 원화는 1
        TotalFiveMny = TotalFiveMny + Number(sAmtKRw);
        TotalFiveMny = TotalFiveMny / 10;
        TotalFiveMny = TotalFiveMny.toFixed(0);
        TotalFiveMny = TotalFiveMny * 10;
        $("#FIVE_MNY").val( fnNumComma(TotalFiveMny) );
    } 
    function fnActingfMny5(){
        var frmObj  = "#PayInf";
        if ( !fnIptChk($("#FIVE_MNY")) || $("#FIVE_MNY").val() =="0" ) {
            alert('추가결제금액을 입력해 주세요.');
            return;
        }  
        $("#CHA_CD").val('5');
        $(frmObj).attr("action", "/admin/ActiveMoney");
        $(frmObj).submit();
    }
</script>
</body>
</html>