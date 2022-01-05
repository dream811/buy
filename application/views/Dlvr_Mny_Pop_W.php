<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta http-equiv="content-language" content="es-ES" />
  	<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo site_url('/template/css/style.css');?>" rel="stylesheet">
	<link href="<?php echo site_url('/template/css/user.css');?>" rel="stylesheet">
	<link href="<?php echo site_url('/template/css/reset.css'); ?>" rel="stylesheet">
	<script>window.jQuery || document.write('<script src="<?php echo site_url('/template/js/jquery-v1.11.3.min.js') ?>"><\/script>')</script>
	<script src="<?php echo site_url('/template/js/common.js')?>" type="text/javascript"></script>
</head>
<style type="text/css">
	#footer, .container, .topInfo, header{
		min-width: unset;
	}
</style>
<body>
    <div class="container">
    	<div id="pop_wrap">
        <!-- 게시판 -->
	        <div class="t_board">
	            <form method="post" name="popfrmAddr" id="popfrmAddr" action="./Dlvr_Mny_Pop_W">
	                <table class="board_write" style="margin-top:5px;">
	                    <colgroup>
	                        <col width="26%">
	                            <col width="74%">
	                    </colgroup>
	                    <tbody>
	                        <tr>
	                            <th>회원등급</th>
	                            <td>
	                                <div class="row">
	                                	<div class="col-sm-6 col-xs-12">
	                                		<select name="sMemLvl" id="sMemLvl" onchange="document.popfrmAddr.submit();" class="form-control">
	                                			<?php if(!empty($role)): ?>
	                                				<?php foreach($role as $rvalue): ?>
	                                					<option value="<?=$rvalue->roleId?>" <?php if($sMemLvl == $rvalue->roleId)  echo "selected";?>>
	                                						<?=$rvalue->roleId?> : <?=$rvalue->role?>
	                                					</option>
	                                				<?php endforeach; ?>
	                                			<?php endif; ?>
			                                </select>
	                                	</div>
	                                </div>
	                            </td>
	                        </tr>
	                        <tr>
	                            <th>품목</th>
	                            <td>
	                                <div class="row">
	                                	<div class="col-sm-6 col-xs-12">
	                                		<select name="sArcSeq" id="sArcSeq" title="통관품목" class="form-control">
	                                			<option value="0|0|0|N">품목은 정확하게 선택해주세요(세관신고)</option>
	                                			<?php if(!empty($category)): ?>
	                                				<?php foreach($category as $cv): ?>
	                                					<?php $cv->tariff_rate = empty($cv->tariff_rate) ? "0": $cv->tariff_rate; ?>
	                                					<?php $cv->vat_rate = empty($cv->vat_rate) ? "0": $cv->vat_rate; ?>
	                                					<?php $caa = $cv->id."|".$cv->tariff_rate."|".$cv->vat_rate."|Y";  ?>
	                                					<option value="<?=$caa?>" 
	                                						<?php if($sArcSeq == $caa )  echo "selected"; ?>><?=$cv->name?></option>
	                                				<?php endforeach; ?>
	                                			<?php endif; ?>			                                    
			                                </select>
	                                	</div>
	                                </div>
	                            </td>
	                        </tr>
	                        <tr>
	                            <th>관세/부가세(%)</th>
	                            <td>
	                            	<div class="row">
	                            		<div class="col-md-3 col-xs-6">
	                            			<input type="hidden" name="TempCtmFee" id="TempCtmFee" value="3000">
	                                		<input type="text" name="sTax" id="sTax" value="<?=$sTax?>" class="form-control" placeholder="%">
	                            		</div>
	                            		<div class="col-md-3 col-xs-6">
	                            			<input type="text" name="sVal" id="sVal" value="<?=$sVal?>" class="form-control">
	                                		<input type="hidden" name="sCtmFee" id="sCtmFee" value="0"  placeholder="%">
	                            		</div>
	                            	</div>
	                                <!--div id="TextArc">품목 선택 시 표기.</div-->
	                            </td>
	                        </tr>
	                        <tr>
	                            <th>상품 및 총금액(￥)</th>
	                            <td>
	                                <div class="row">
	                                	<div class="col-sm-4 col-xs-12">
	                                		<input type="text" name="sTotMny" id="sTotMny" maxlength="20" onchange="fnNumChiper(this, '2');" class="form-control" value="<?=$sTotMny?>">
	                                	</div>
	                                	상품 구입 비용 + 현지세금 + 현지 운송비
	                                </div>
	                                 
	                            </td>
	                        </tr>
	                        <tr>
	                            <th>센터</th>
	                            <td>
	                                <div class="row">
	                                	<div class="col-sm-4 col-xs-12">
	                                		<select class="form-control" name="sCtrSeq" id="sCtrSeq" onchange="document.popfrmAddr.submit();">
			                                    <option value="0">= 선택</option>
			                                <?php if(!empty($center)): ?>
			                                	<?php foreach($center as $cvvs): ?>
			                                		<option value="<?=$cvvs->id?>" <?php if($sCtrSeq == $cvvs->id)  echo "selected";?>><?=$cvvs->area_name?></option>
			                                	<?php endforeach; ?>
			                                <?php endif; ?>
			                                </select>
	                                	</div>
	                                </div>
	                            </td>
	                        </tr>
	                        <tr>
	                            <th>무게(kg)</th>
	                            <td>
	                                <input type="hidden" name="sDlvrMny" id="sDlvrMny" value="0">
	                                <input type="hidden" name="sDlvrMnyDn" id="sDlvrMnyDn" value="0">
	                                <input type="hidden" name="sDlvrMnyUp" id="sDlvrMnyUp" value="0">
	                                <div id="TextWeight">
	                                	<div class="row">
	                                		<div class="col-sm-4 col-xs-12">
	                                			<select name="MEM_WT" id="MEM_WT" onchange="fnDlvrWeight(this.value);" class="form-control">
			                                        <option value="0|0|0">무게</option>
			                                        <option value="0|0|0">1Kg</option>
			                                        <?php if(!empty($deliveryContents) && !empty($r)): 
			                                        	$halin = $r[0]->sending_inul;
			                                        	if(!empty($sCtrSeq)){
			                                        		$address_rate = (array)json_decode($r[0]->address_rate);
			                                        		if($address_rate[$sCtrSeq])
			                                        			$halin = $address_rate[$sCtrSeq];
			                                        	}
			                                        	$startWeight=0;
									                    $start1= 0;
									                    $start2=0;
									                    $startPrice = 0;
									                      ?>
									                      <?php foreach($deliveryContents as $value): ?>
								                          <?php   $start1 = $value->startWeight;
								                                  $start2 = $value->endWeight;  
								                                  $startPrice = $value->startPrice;

								                                  while($start1<=$start2){ ?>
								                                  <option value="<?=$startPrice*$halin?>|0|0"><?=$start1?></option>
								                      <?php $start1 = $start1 + $value->weight;$startPrice = $startPrice + $value->goldSpace; } 
								                      endforeach;  ?>
			                                        <?php endif; ?>
			                                    </select>
	                                		</div>
	                                	</div>
	                                </div>
	                            </td>
	                        </tr>
	                        <tr>
	                            <th>고시환율</th>
	                            <td>
	                            	<div class="row">
	                                	<div class="col-sm-4 col-xs-12">
	                                		<select name="sExgRtMny" id="sExgRtMny" class="form-control">
	                                			
			                                <?php if(!empty($aa)): ?>
			                                	<option value="<?=$aa[0]->rate?>">구매환율:<?=$aa[0]->rate?></option>원
			                                <?php endif; ?>
			                                    
			                                </select>
	                                	</div>
	                                </div>
	                            </td>
	                        </tr>
	                        <tr>
	                            <th>기타 수수료</th>
	                            <td class="vm_box">
	                            	<?php if(!empty($services)): ?>
	                            	<?php foreach($services as $service_chd): ?>
	                            	<label>
	                                    <input type="checkbox" class="input_chk" name="EtcDlvr" id="EtcDlvr" value="<?=$service_chd->price?>">
	                                    <?=$service_chd->name?>(<?=number_format($service_chd->price)?>원)
	                                </label>&nbsp;&nbsp;	
	                            	<?php endforeach; ?>
	                            	<?php endif;?>
	                            </td>
	                        </tr>
	                        <tr>
	                            <th>상세 내역</th>
	                            <td>
	                                <table>
	                                    <tbody>
	                                        <tr>
	                                            <td class="nbd" width="130">선편요금</td>
	                                            <td class="nbd">: <span id="Tax1"></span></td>
	                                        </tr>
	                                        <tr>
	                                            <td class="nbd" width="130">관세</td>
	                                            <td class="nbd">: <span id="DetMny1"></span></td>
	                                        </tr>
	                                        <tr>
	                                            <td class="nbd">부가세</td>
	                                            <td class="nbd">: <span id="DetMny2"></span></td>
	                                        </tr>
	                                        <tr>
	                                            <td class="nbd">통관수수료</td>
	                                            <td class="nbd">: <span id="DetMny3"></span></td>
	                                        </tr>
	                                        <tr>
	                                            <td class="nbd">배송비용</td>
	                                            <td class="nbd">: <span id="DetMny4"></span></td>
	                                        </tr>
	                                        <tr>
	                                            <td class="nbd">기타수수료</td>
	                                            <td class="nbd">: <span id="DetMny5"></span></td>
	                                        </tr>
	                                    </tbody>
	                                </table>
	                            </td>
	                        </tr>
	                        <tr>
	                            <th>예상 비용</th>
	                            <td>
	                                <table>
	                                    <tbody>
	                                        <tr>
	                                            <td class="nbd" width="130">예상 관부가세</td>
	                                            <td class="nbd">: <span id="TtMny1" class="bold"></span></td>
	                                        </tr>
	                                        <tr>
	                                            <td class="nbd">예상 배송비용</td>
	                                            <td class="nbd">: <span id="TtMny2" class="bold"></span></td>
	                                        </tr>
	                                        <tr>
	                                            <td class="nbd">예상 구매비용</td>
	                                            <td class="nbd">: <span id="TtBuy1" class="bold"></span></td>
	                                        </tr>
	                                        <tr>
	                                            <td class="nbd">예상 총금액</td>
	                                            <td class="nbd">: <span id="TtMny3" class="bold clrRed1"></span></td>
	                                        </tr>
	                                    </tbody>
	                                </table>
	                            </td>
	                        </tr>
	                    </tbody>
	                </table>
	            </form>

	            <p style="color:#ff3300;padding:3px 0;">(상품구입비+현지배송비+국제배송비) = 15만원 미만은 관부과세 면제 입니다.)</p>

	            <div class="btn_wrap" style="margin-top:10px;text-align:center;margin-bottom: 10px">
	                <a href="javascript:fnDlvrMny();" class="btn btn-danger btn-sm btn-round"><span>배송금액 계산</span></a>
	                <a href="javascript:self.close();" class="btn btn-default btn-sm btn-round"><span>닫기</span></a>
	            </div>

	        </div>
	    </div>
    </div>
</html>
<script>

	$("#sArcSeq").change(function(){
		var rates = $(this).val();
		$("#sTax").val(rates.split("|")[1]);
		$("#sVal").val(rates.split("|")[2]);
	});
	function fnDlvrWeight(val){ 
		var sSplitVal = val.split("|"); 
		$("#sDlvrMny").val(sSplitVal[0]);
		$("#sDlvrMnyDn").val(sSplitVal[1]);
		$("#sDlvrMnyUp").val(sSplitVal[2]);
	}
	function fnDlvrMny() {
	var ChkBox = document.getElementsByName("EtcDlvr"); 
	var TotProMny = 0;
	var TaxShip = 0;
	var DutyMny = 0, DutyMny1 = 0;
	var ValMny = 0, ValMny1 = 0;
	var DlvrMny = 0;
	var sCtmFee = Number($("#sCtmFee").val()); //통관비
	var DetMny1 = 0, DetMny2 = 0, DetMny3 = 0, DetMny4 = 0, DetMny5 = 0, DetMny6 = 0;
	var TtMny1 = 0, TtMny2 = 0, TtMny3 = 0;
	var ExgRtMny = Number($("#sExgRtMny").val());
	var aArcItem = "";

	if ( $("#sArcSeq").val() == "0|0|0|N" || $("#sArcSeq").val() == "") {
		fnMsgFcs($("#sArcSeq"), '품목을 선택해 주세요.');
		return;
	}
 
	if ( $("#sTotMny").val() == "" || $("#sTotMny").val() == "0" ) {
		fnMsgFcs($("#sTotMny"), '상품 총금액을 입력해 주세요.');
		return;
	}

	if ( $("#sCtrSeq").val() == "0" || $("#sCtrSeq").val() == "") {
		fnMsgFcs($("#sArcSeq"), '센터를 선택해 주세요.');
		return;
	}

	if ( $("#MEM_WT").val() == "0|0|0" || $("#MEM_WT").val() == "" ) {
		fnMsgFcs($("#MEM_WT"), '무게를 선택해 주세요.');
		return;
	}   

	// 품목 정보
	aArcItem = $("#sArcSeq").val().split("|");
	DetMny4 = Number($("#sDlvrMny").val()).toFixed(2);
	//상품 가격 
	TotProMny = Number($("#sTotMny").val()) * ExgRtMny;
	TotProMny = Number(TotProMny) + Number(DetMny4);
	TotProMny = parseInt(TotProMny);
	TaxShip   = 0;


		// [선편요금] : 20만원 기준
		if (TotProMny > 200000){
			TaxShip = Number($("#sDlvrMnyUp").val());
		}else{
			TaxShip = Number($("#sDlvrMnyDn").val());
		}

		// 목록통관 : 150000원 이하 적용 안함
		if ( aArcItem[3] == "N" && Number(TotProMny) <= 150000 ) {
			TaxShip = 0;
		}

		// [과세표준가격] = ( [상품 총 금액] * [관세청 고시환율] ) + [과세운임]
		TotProMny += TaxShip;

	// 구매 비용
	DetMny6   = Number(TotProMny) -Number(DetMny4);

	$("#Tax1").html("￦" + fnCommaNum(TaxShip));

	//관세	[과세표준가격] * [품목 관세율(%)]
	DutyMny = TotProMny * Number($("#sTax").val()) / 100;
	//관세 반올림 
	DutyMny = parseInt(DutyMny+0.5);
 
	//부가세 ( [과세표준가격] + [관세] ) * 부가율%
	ValMny  = (TotProMny + DutyMny) * Number($("#sVal").val()) / 100
	ValMny  = parseInt(ValMny+0.5); 

	// 통관 수수료
	DetMny3 = sCtmFee.toFixed(0);

	// 일반통관/목록통관 관/부가세 여부
	if ( aArcItem[3] == "Y" ) {
		if ( TotProMny <= 150000 ) {
			DutyMny = 0;
			ValMny  = 0;
			DetMny3 = 0;
		}
	} else {
		if ( TotProMny <= 150000 ) {
			DutyMny = 0;
			ValMny  = 0;
			DetMny3 = 0;
		} else {
			DetMny3 = Number($("#TempCtmFee").val());
		}
	}

	//기타 금액
	if (ChkBox.length == undefined) {
			if (ChkBox.checked){
				DetMny5 = DetMny5 + Number(ChkBox.value);
			}
	}
	else { 
		for (var i = 0; i < (ChkBox.length); i++) {
			if (ChkBox[i].checked){
				DetMny5 = DetMny5 + Number(ChkBox[i].value); 
			} 
		}
	}
 
	// 상세내역
	DutyMny = Number(DutyMny);	// / Number(ExgRtMny);
	ValMny  = Number(ValMny);	// / Number(ExgRtMny);
	DetMny1 = DutyMny.toFixed(2);
	DetMny2 = ValMny.toFixed(2);

	//$("#DetMny1").html( "￥" + fnCommaNum(DetMny1) + " (" + $("#sTax").val() + "%" + ")" ); // 관세
	//$("#DetMny2").html( "￥" + fnCommaNum(DetMny2) + " (" + $("#sVal").val() + "%" + ")" ); // 부가세
	$("#DetMny1").html( "￦" + fnCommaNum( (DutyMny) ) + " (" + $("#sTax").val() + "%" + ")" ); // 관세
	$("#DetMny2").html( "￦" + fnCommaNum( (ValMny) )+ " (" + $("#sVal").val() + "%" + ")" ); // 부가세
	$("#DetMny3").html( "￦" + fnCommaNum(DetMny3) ); // 통관수수료
	$("#DetMny4").html( "￦" + fnCommaNum(DetMny4) ); // 배송비용
	$("#DetMny5").html( "￦" + fnCommaNum(DetMny5) ); // 기타수수료
	$("#TtBuy1").html( "￦" + fnCommaNum(DetMny6) ); // 구매비용
	DlvrMny = Number(DetMny5) + Number(DetMny4) + Number(DetMny3);
	DlvrMny = Number(DlvrMny);
	// 예상비용
	TtMny1 = parseInt( ( Number(DetMny1) ) + ( Number(DetMny2) ) );
	TtMny2 = parseInt( Number(DetMny3) + Number(DetMny4) + Number(DetMny5) );
	TtMny3 = Number(TtMny1) + Number(TtMny2) + Number(DetMny6);
	$("#TtMny1").html( "￦" + fnCommaNum(TtMny1) ); // 관세
	$("#TtMny2").html( "￦" + fnCommaNum(TtMny2) ); // 부가세
	$("#TtMny3").html( "￦" + fnCommaNum(TtMny3) ); // 통관수수료
}
 
</script>