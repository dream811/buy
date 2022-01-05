<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
	<link href="<?php echo site_url('/template/css/user.css'); ?>" rel="stylesheet">
	<link href="<?php echo site_url('/template/css/reset.css'); ?>" rel="stylesheet">
	<script>window.jQuery || document.write('<script src="<?php echo site_url('/template/js/jquery-v1.11.3.min.js') ?>"><\/script>')
	</script>
	<script src="<?php echo site_url('/template/js/common.js') ?>"></script>
</head>
<body>
	<div id="pop_wrap3">
		<form name="frmCpn" id="frmCpn" method="post" action="processCoupon">
			<div class="cp_box">
				<h1 style="margin-top: 42px;"></h1>
				<div class="row">
					<div class="col-xs-4 text-center" style="margin-top: 10px">쿠폰번호</div>
					<div class="col-xs-2 p-1">
						<input type="text" class="form-control" name="sCpnNum1" id="sCpnNum1" maxlength="4">
					</div>
					<div class="col-xs-2 p-1">
						<input type="text" class="form-control" name="sCpnNum2" id="sCpnNum2" maxlength="4">
					</div>
					<div class="col-xs-2 p-1">
						<input type="text" class="form-control" name="sCpnNum3" id="sCpnNum3" maxlength="4">
					</div>
					<div class="col-xs-2 p-1">
						<input type="text" class="form-control" name="sCpnNum4" id="sCpnNum4" maxlength="4">
					</div>
				</div>
			</div>
			<ul class="cp_txt text-center">
				<li>1. 쿠폰번호 입력 후 "쿠폰등록" 버튼을 눌러 등록이 가능한 쿠폰인지 확인합니다.</li>
				<li>2. "쿠폰등록" 버튼을 클릭하면 바로 사용가능한 쿠폰으로 등록됩니다.</li>
				<li>3. 이지솔루션 할인쿠폰에는 배송요금 할인, 정밀검수쿠폰, 통관수수료쿠폰 등 다양한 종류가 있습니다. </li>
				<li>4. 1회 등록된 쿠폰은 재동륵이 불가능하며, 양도가 가능한 쿠폰의 경우 쿠폰 등록 후 타인에게 양도가 가능합니다.</li>
			</ul>
			<div class="text-center">
				<a href="javascript:fnCpnAcc();" class="btn btn-danger">쿠폰등록</a>
				<a href="javascript:self.close();" class="btn btn-secondary">취소</a>
			</div>
		</form>	
	</div>
</body>
</html>
<script type="text/javascript">
  
//------------------------------------------------------------------------------
// 등록,수정 체크
//------------------------------------------------------------------------------
function fnCpnAcc() { 
	var frmObj = "#frmCpn";

	if ( !fnIptChk($("#sCpnNum1")) ) {
		fnMsgFcs($("#sCpnNum1"), '첫번째 쿠폰번호를 입력하세요.');
		return;
	}
	if ( !fnIptChk($("#sCpnNum2")) ) {
		fnMsgFcs($("#sCpnNum2"), '두번째 쿠폰번호를 입력하세요.');
		return;
	}
	if ( !fnIptChk($("#sCpnNum3")) ) {
		fnMsgFcs($("#sCpnNum3"), '세번째 쿠폰번호를 입력하세요.');
		return;
	}
	if ( !fnIptChk($("#sCpnNum4")) ) {
		fnMsgFcs($("#sCpnNum4"), '네번째 쿠폰번호를 입력하세요.');
		return;
	}
 
	$(frmObj).attr("action", "./processCoupon").attr("target", "");
	$(frmObj).submit(); 
}
 
</script>