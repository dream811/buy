<!DOCTYPE html>
<html>
<head>
	<title></title>
	  <script>
    window.jQuery || document.write('<script src="<?php
    echo site_url('/template/js/jquery-v1.11.3.min.js') ?>"><\/script>')
  </script>
  <script src="<?php echo site_url('/template/js/common.js')?>"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo site_url('/template/css/user.css'); ?>" rel="stylesheet">
</head>
<body style="background: none;">
	<div id="pop_wrap">
		<h1>쿠폰목록</h1>
		<!-- 게시판 -->
		<div class="t_board">
			<form name="frmSearch" id="frmSearch" method="get" action="">
				<input type="hidden" name="CHA_SEQ" id="CHA_SEQ" value="<?=$_GET['CHA_SEQ']?>">
				<input type="hidden" name="shGo" id="shGo" value="1">
				<input type="hidden" name="sKind" id="sKind">
				<table class="board_list" summary="쿠폰내역">
					<caption>결제</caption>
					<colgroup>
						<col width="6%">
						<col width="15%">
						<col width="12%">
						<col width="30%">
					</colgroup>
					<thead>
						<tr>
							<th>No</th>
							<th>쿠폰종류</th>
							<th>할인</th>
							<th>유효기간</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($coupon)): ?>
							<?php foreach($coupon as $value): ?>
								<tr>
									<td>
										<input type="checkbox" name="chkCpnCode" id="chkCpnCode" onclick="fnCpnChoice($(this));" value="<?=$value->code?>|<?=$value->coupon_type?>|(<?=number_format($value->gold)?> <?=$value->gold_type==1 ? "원":"%"?>)|<?=$value->content?>"> 

									</td>
									<td><?=$value->content?></td>
									<td><span class="bold"><?=number_format($value->gold)?><?=$value->gold_type==1 ? "원":"%"?></span></td>
									<td><?=$value->event==0 ? $value->terms: date("Y-m-d")."|".date("Y-m-d", strtotime($value->byd))?></td>
									
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>	
			</form>
		</div>
		<div class="btn_wrap style_top_3"> 
			<a href="javascript:fnCpnIn();" class="btn btn-warning btn-sm btn-round">적용</a>
			<a href="javascript:self.close();" class="btn-danger btn btn-sm btn-round">취소</a>
		</div>
	</div>
	<script type="text/javascript">
	$(document).ready(function() {});
	//------------------------------------------------------------------------------
	// 쿠폰 선택
	//------------------------------------------------------------------------------
	function fnCpnChoice(pObj) {
		var fCpnInf = pObj.val().split("|");
		if(pObj.val() != "" && pObj.prop("checked")) {
			$("#frmSearch input[name='chkCpnCode']").each(function(idx) {
				var fCpnInf2 = $(this).val().split("|");
				if(fCpnInf2[1] == fCpnInf[1]) {
					$(this).prop("checked", false);
				}
			});
			pObj.prop("checked", true);
		}
	}
	//------------------------------------------------------------------------------
	// 쿠폰 있는거 제거
	//------------------------------------------------------------------------------
	function fnCpnDel() {
		var fCpnAll = opener.$("#aCPN");
		var fCpnCha = opener.$("#CPN_" + 182);
		var aCpnCha = fCpnCha.val().split(",");
		for(var i = 0; i < aCpnCha.length; i++) {
			if(aCpnCha[i] != "") {
				fCpnAll.val(fCpnAll.val().replace(aCpnCha[i] + ",", ""));
				fCpnAll.val(fCpnAll.val().replace("," + aCpnCha[i], ""));
				fCpnAll.val(fCpnAll.val().replace(aCpnCha[i], ""));
			}
		}
	}
	//------------------------------------------------------------------------------
	// 쿠폰 선택시 금액 변경//타입이 중복인것은 불가
	//------------------------------------------------------------------------------
	function fnCpnIn() {
		var frmObj = "#frmSearch";
		var opCpn = "";
		var CHA_SEQ = "<?=$_GET['CHA_SEQ']?>";
		var ChkValue = "",
			aChkValue = "",
			sTextVal = "";
		var fCpnAll = "",
			fCpnCha = "";
		var fArrNm = "",
			fArrList = "";
		fCpnAll = opener.$("#aCPN");
		fCpnCha = opener.$("#CPN_" + CHA_SEQ);
		if(fnSelBoxCnt($(frmObj + " input[name='chkCpnCode']")) == "0") {
			alert('적용할 쿠폰을 선택해 주세요.');
			return;
		}
		// 단일
		if($(frmObj + " input[name='chkCpnCode']").length == undefined) {
			if($(frmObj + " input[name='chkCpnCode']").checked) {
				ChkValue = $(frmObj + " input[name='chkCpnCode']").value.split("|");
				opener.$("#CPN_" + ChkValue[1] + "_" + CHA_SEQ).val($(frmObj + " input[name='chkCpnCode']").value);
				fnCpnDel(); //쿠폰 제거
				aChkValue = ChkValue[0];
				sTextVal = ChkValue[3] + " : " + ChkValue[0] + " &nbsp;&nbsp; " + ChkValue[2] + " [<a href=\"javascript:fnCpnCnl('" + ChkValue[1] + "','" + CHA_SEQ + "');\" style='color:#ff3300'>취소</a>]<br />";
			}
		}
		// 다중
		else {
			for(var i = 0; i < $(frmObj + " input[name='chkCpnCode']").length; i++) {
				if($(frmObj + " input[name='chkCpnCode']")[i].checked) {
					ChkValue = $(frmObj + " input[name='chkCpnCode']")[i].value.split("|");
					var fCpnChaTy = opener.$("#CPN_" + ChkValue[1] + "_" + CHA_SEQ);
					// 쿠폰 등록
					fCpnChaTy.val($(frmObj + " input[name='chkCpnCode']")[i].value);
					if(fArrNm.indexOf("#CPN_" + ChkValue[1] + "_" + CHA_SEQ) < 0) {
						fArrNm = fArrNm == "" ? "#CPN_" + ChkValue[1] + "_" + CHA_SEQ : fArrNm + "," + "#CPN_" + ChkValue[1] + "_" + CHA_SEQ;
					}
				}
			}
			// 적용된 쿠폰 정보
			aChkValue = "";
			fArrList = fArrNm.split(",");
			for(var i = 0; i < fArrList.length; i++) {
				var fCpnArr2 = opener.$(fArrList[i]).val().split("|");
				aChkValue = aChkValue == "" ? fCpnArr2[0] : aChkValue + "," + fCpnArr2[0];
				// 쿠폰 적용 목록
				sTextVal += fCpnArr2[3] + " : " + fCpnArr2[0] + " &nbsp;&nbsp; " + fCpnArr2[2] + " &nbsp;&nbsp; [<a href=\"javascript:fnCpnCnl('" + fCpnArr2[1] + "','" + CHA_SEQ + "');\" style='color:#ff3300'>취소</a>]<br />";
			}
		}
		// 전체 쿠폰 업데이트
		fnCpnDel();
		fCpnAll.val(fCpnAll.val() == "" ? aChkValue : fCpnAll.val() + "," + aChkValue);
		// 선택 주문 건 쿠폰 업데이트
		fCpnCha.val(aChkValue);
		opener.fnReSaleMnyAjax(aChkValue, CHA_SEQ);
		opener.$("#sCpnDtl_" + CHA_SEQ).html(sTextVal);
		self.close();
	}
	// 페이지 이동
	function fnPageMv(sObj, sGo) {
		var frmObj = "#" + sObj;
		$("#sKind").val("");
		$(frmObj + " input[name='shGo']").val(sGo);
		$(frmObj).attr("method", "get").attr("action", "./CPN_Tran_W.asp").attr("target", "");
		$(frmObj).submit();
	}
	// 페이지 이동
	function fnCpnInfRe() {
		$("#sKind").val("");
		$("#frmSearch").attr("method", "get").attr("action", "./CPN_Tran_W.asp").attr("target", "");
		$("#frmSearch").submit();
	}
	function fnCpnDel(){
		var fCpnAll = opener.$("#aCPN");
		var fCpnCha = opener.$("#CPN_" + <?=$_GET['CHA_SEQ']?>);
		var aCpnCha = fCpnCha.val().split(",");

		for ( var i = 0; i < aCpnCha.length; i++ ) {
			if ( aCpnCha[i] != "" ) {
				fCpnAll.val(fCpnAll.val().replace( aCpnCha[i] + ",", "" ));
				fCpnAll.val(fCpnAll.val().replace( "," + aCpnCha[i], "" ));
				fCpnAll.val(fCpnAll.val().replace( aCpnCha[i], ""));
			}
		}
	}
	</script>
</body>
</html>