var xmlRequest;
function selfRedirect(){
	window.location.reload();
}
function CreateXMLHttpRequest()    {
    try {
        xmlRequest = new XMLHttpRequest();
    } catch(tryMS) {
        try {
            xmlRequest = new ActiveXObject("Microsoft.XMLHTTP");
        } catch(otherMS) {
            try {
                xmlRequest = new ActiveXObject("Msxml2.XLHTTP");
            } catch(failed) {
                xmlRequest = null;
            }
        }
    }
}

function fnCkBoxAllSel( pFrmNm, pColAllNm, pColNm ) {
 
  var fColAllNm = $("#" + pFrmNm + " input[name='"+pColAllNm+"']");
  var fColNm = $("#" + pFrmNm + " input[name='"+pColNm+"']");
  var fChkVal = "";

  if ( fColNm ) {
    fColNm.prop("checked", fColAllNm.prop("checked"));
  }

}
function fnChkNumeric() {
	if(event.keyCode < 48 || event.keyCode > 57) {
		if (event.keycode == 13) return true;
		event.returnValue = false;
	} 
}
function fnFrgImgView2(sOrdSeq,sMemCode) {
	fnPopWinCT("/admin/view-photo?sOrdSeq=" + sOrdSeq,"", 1000, 800, "Y");
}
function fnOrdPopV(val1){
	var	reVal = ""; 
		reVal = "?ORD_SEQ="+val1; 
	fnPopWinCT("/admin/ShowDelivery"+reVal, "주문내역보기", 1000, 600, "Y")
}

function fnGetChgHtmlAjax(parm, combUrl, TailVal) {
	var strv = DoCallbackCommon(combUrl+TailVal);
	document.getElementById(parm).innerHTML = strv;
}
function fnNumChiper(sObj, sChiper) {
	var sNum = sObj.value;
	var sDot = 0, sPm = "";
	sNum = sNum.replace(/,/g, "");
	sNum = isNaN(sNum) ? sDot : sNum;

	if ( sNum < 0 ) {
		sPm = "-";
	}

	sNum = Math.abs(sNum);
	//sNum = Math.round(sNum);
	sNum = sNum.toFixed(sChiper);
	sObj.value = sPm + "" + sNum;
}

function DoCallbackCommonMPost(combUrl,TailVal){
	var pageUrl = combUrl;
	CreateXMLHttpRequest()
	xmlRequest.open("POST", pageUrl, true);
	xmlRequest.setRequestHeader('Content-Type', 'MULTIPART/FORM-DATA'); 
	xmlRequest.onreadystatechange = function() {CallBackPost(xmlRequest)};
	xmlRequest.send(TailVal);  
}
function DoCallbackCommon(url){
	var tmpData = " ";
	CreateXMLHttpRequest();
	xmlRequest.open("GET", url, false);
	xmlRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
	xmlRequest.send(tmpData);

	//alert(xmlRequest.responseText);
	return xmlRequest.responseText;
}
function CallBackPost(xmlRequest) {
	if (xmlRequest.readyState == 4) {

		if (xmlRequest.status == 200) {
			var val = xmlRequest.responseText;
			if (val == "-1"){
				alert('자료가 잘못되었습니다.');
			}else{  
				switch ( val ) {
					case "-3" : fnOrdStep('12'); return;
					default:  return;
				}
			}
		} else {
			alert('실패!');
		}
	}
}

function fnCkBoxVal( pFrmNm, pColNm ) {
	var fColNm = pColNm;
	var fChkVal = "";

	$("#" + pFrmNm + " input[name='"+fColNm+"']").each( function() {
		if ( $(this).is(":checked") ) {
			fChkVal += "," + $(this).val();
		}
	});

	if ( fChkVal != "" ) {
		fChkVal = fChkVal.substring( 1, fChkVal.length );
	}

	return fChkVal;
}

function fnSelChasMove(sval1){	

	$("select[name=sMoveStatSeq] option[value="+sval1+"]").attr("selected",true); 
}
function fnOrdStatStep(val) {
	var frmObj = "#frmList";
	var aTit = "";
	if (val == "C"){
		aTit = "선택된 주문을 변경하시겠습니까?";
	}else if (val == "R"){
		aTit = "입금요청 메세지를 보내시겠습니까?";
	}else if (val == "E"){
		aTit = "예치금을 이용하여 변경하시겠습니까?"; 
	}else if (val == "B"){
		aTit = "출고완료를 취소 시키겠습니까?\n포인트가 발급이 되었으면 반환됩니다.";
	}else if (val == "F"){
		aTit = "출고보류 체크 및 해지를 하시겠습니까?";
	}

	$("#sKind").val(val);
	$("#sKind1").val($('#sMoveStatSeq1').val());
	if ($("#sMoveStatSeq").val() == "" && (val == "C" || val == "E")) {
		alert('변경할 주문 상태를 선택하십시요.');
		return;
	}
	if (fnSelBoxCnt($(frmObj + " input[name='chkORD_SEQ[]']")) <= 0) {
		alert('주문을 선택하십시요.');
		return;
	}

	if (confirm(aTit)) {
		document.frmList.encoding = "application/x-www-form-urlencoded"; 
		$("#frmList").attr("method", "post").attr("action", "/admin/changeOrder");
		$("#frmList").submit();
	}
}

function fnSelBoxCnt(chkTarget) {

	if(chkTarget == null) return 0;

	var size = chkTarget.length;
	if(size == undefined) {
		if(chkTarget.checked == false) return 0;
		return 1;
	}

	var selected_group_count = 0;
	for(var u=0; u<size; u++) {
		if(chkTarget[u].checked == true) selected_group_count++;
	}
	return selected_group_count;

}

function fnPopWinCT(sUrl, sTitle, iWidth, iHeight, sScrollYN)
{
	var lsWinOption;
	var sSYN;
	iLeft = (screen.width - iWidth)/2;
	iTop = (screen.height - iHeight)/2;
	sSYN = sScrollYN;
	switch (sScrollYN) {
	case 'Y' : sSYN = 'yes'; break;
	case 'N' : sSYN = 'no'; break;
	default : sSYN = 'auto'; break;
	}

	sTitle = sTitle.replace(" ", "_");
	lsWinOption = "width=" + iWidth + ", height=" + iHeight;
	lsWinOption += " toolbar=no, directories=no, status=no, menubar=no, location=no, resizable=yes, left=" + iLeft + ", top=" + iTop + ", scrollbars="+sSYN;
	var loNewWin = window.open(sUrl, sTitle, lsWinOption).focus();
}
function fnAddrChk(obj) {

	var pattern_spc = /[\+[\\\]\?\#&]/g; // 특정 특수문자 체크

	if( pattern_spc.test(obj.value) ) {
		alert("특수문자 ? # & + \\ 를 입력 할 수 없습니다.");
		obj.value = obj.value.replace( pattern_spc, '' );
		return;
	}
}

function fnFocusOutReg( pNm, pExp, pFatt ) {
	var fNm = $("input[name='" + pNm + "']");

	if ( fNm.val() == "" || fNm.val() == pExp ) {
		$(fNm).val(pExp);
	} else {
		$(fNm).val( $(fNm).val().replace(pFatt, "") );
	}
}
function fnFocusInExp( pNm, pExp ) {
	var fNm = $("input[name='" + pNm + "']");
	var fVal = pExp;

	if ( fNm.val() == pExp ) {
		$("#RRN_NO").val("");
	}
}

function fnIptChk( pObj ) {

	var fObj = pObj;
	var fTf = false;

	if ( $.trim(fObj.val()) == "" ) fTf = false;
	else fTf = true;

	return fTf;
}
function fnMsgFcs(pObj, pMsg) {
	alert(pMsg);
	pObj.focus();
}

function fnChkBoxTotal(sObj, sObjSel) {
	// sObj -> 체크박스 객체(this)
	// sObjSel -> 체크해야할 체크박스 이름

	var ChkBox = document.getElementsByName(sObjSel); 
	if (!ChkBox)
	{
		alert("선택할 항목이 없습니다.");
		return;
	}

	if (ChkBox.length == undefined) {
			ChkBox.checked = sObj.checked
	}
	else {
		for (var i = 0; i < (ChkBox.length); i++) {
			ChkBox[i].checked = sObj.checked;
		}
	}
}
function fnGetChkboxValue(oCheckbox)
{
    var lsCheckedValue = "";

		if (oCheckbox.length == undefined) {
			if (oCheckbox.checked) {
				lsCheckedValue = oCheckbox.value;
			}
		}
		else {
			for(var i=0; i<oCheckbox.length; i++) 
				if(oCheckbox[i].checked) lsCheckedValue += oCheckbox[i].value +",";

			lsCheckedValue = lsCheckedValue.substring(0, lsCheckedValue.length-1)
		}
    return lsCheckedValue;
}

function fnModalPop(pTitle, pUrl, pW, pH) {
	var modalNm = "#PopModal";
	var ifrNm   = "ifrModal";
	var frmModal = "#frmModal";
	var iLeft, iTop;

	iLeft = ( $(window).width() / 2 ) - ( pW / 2 );
	iTop  = $(document).scrollTop() + ( $(window).height() / 2 ) - ( pH / 2 );

	$("#frmModal").attr("target", "ifrModal").attr("action", pUrl).submit();
	$(modalNm).window({
		title:pTitle,
		left:iLeft + "px",
		top:iTop + "px",
		width:pW,
		height:pH
	});
	$(modalNm).window("open");
}

function fnPageCopy2(TempNum){
	var gMaxProCnt = "<%=gMaxProCnt%>";
	var sShopNum = Number($("#sProNum").val())+1;
 
	if (sShopNum > 30)
	{
		alert('상품 종류는 30개를 넘길 수 없습니다.');
		return;
	}

	if (sShopNum > gMaxProCnt){
		alert(gMaxProCnt+"개 이상은 추가 할수 없습니다.");
	}else{
		if ($("input[name='PRO_STOCK_SEQ']").eq(TempNum-1).val() != "0")
		{
			alert("재고 불러오기로 등록한 상품은 복사가 불가능합니다.");
		}else{
			$("#sProNum").val(sShopNum);
			fnProductAjax(sShopNum); 
			//복사 하기 
			$("input[name='ORD_SITE']").eq(sShopNum-1).val($("input[name='ORD_SITE']").eq(TempNum-1).val()); 
			$("input[name='SHOP_ORD_NO']").eq(sShopNum-1).val($("input[name='SHOP_ORD_NO']").eq(TempNum-1).val()); 
			$("input[name='SHIP_NM']").eq(sShopNum-1).val($("input[name='SHIP_NM']").eq(TempNum-1).val()); 
			$("select[name='FRG_DLVR_COM']").eq(sShopNum-1).val($("select[name='FRG_DLVR_COM']").eq(TempNum-1).val()); 
			$("input[name='FRG_IVC_NO']").eq(sShopNum-1).val($("input[name='FRG_IVC_NO']").eq(TempNum-1).val()); 
			$("input[name='PRO_NM']").eq(sShopNum-1).val($("input[name='PRO_NM']").eq(TempNum-1).val()); 
			$("input[name='PRO_NM_CH']").eq(sShopNum-1).val($("input[name='PRO_NM_CH']").eq(TempNum-1).val()); 
			$("input[name='BRD']").eq(sShopNum-1).val($("input[name='BRD']").eq(TempNum-1).val()); 
			$("input[name='CLR']").eq(sShopNum-1).val($("input[name='CLR']").eq(TempNum-1).val()); 
			$("input[name='SZ']").eq(sShopNum-1).val($("input[name='SZ']").eq(TempNum-1).val()); 
			$("input[name='COST']").eq(sShopNum-1).val($("input[name='COST']").eq(TempNum-1).val()); 
			$("input[name='QTY']").eq(sShopNum-1).val($("input[name='QTY']").eq(TempNum-1).val()); 
			$("input[name='AMT']").eq(sShopNum-1).val($("input[name='AMT']").eq(TempNum-1).val()); 
			$("input[name='PRO_URL']").eq(sShopNum-1).val($("input[name='PRO_URL']").eq(TempNum-1).val()); 
			$("input[name='IMG_URL']").eq(sShopNum-1).val($("input[name='IMG_URL']").eq(TempNum-1).val());  
			$("select[name='PARENT_CATE']").eq(sShopNum-1).val($("select[name='PARENT_CATE']").eq(TempNum-1).val()); 
			// $("select[name='ARC_SEQ']").eq(sShopNum-1).val($("select[name='ARC_SEQ']").eq(TempNum-1).val());
			$("select[name='ARC_SEQ']").eq(sShopNum-1).html($("select[name='ARC_SEQ']").eq(TempNum-1).html());		
			fnImgChg(sShopNum);
		}
	}
	fnTotalProPrice();
}
function fnProductAjax(sShopNum,options=null) {
	var ord;
	if(options =="buy") ord= 1;
	else ord =2;
	var url = "?ORD_TY_CD="+ord+"&sShopNum="+sShopNum;
	$("#sProNum").val(sShopNum); 
	$("#TempProNum").val(sShopNum);  
	fnGetChgHtmlAjax("TextProduct"+sShopNum, "/admin/getProduct", url);
}

function fnTotalProPrice() {
		var sAmt = 0, sSaleAmt = 0; sFrgShipMny = 0; sTaxAmt = 0;
		var sTotalProCnt = 0, sTtCtmsCnt = 0;
		var sTotalAmt = 0;

		// 상품 Loop
		for(var i=1; i<=$("#TempProNum").val(); i++) {
			sAmt         = Number($("input[name='COST']").eq(i-1).val()) * Number($("input[name='QTY']").eq(i-1).val());
			sAmt         = sAmt.toFixed(2);
			$("input[name='AMT']").eq(i-1).val(sAmt);
			sTotalProCnt = Number(sTotalProCnt) + Number($("input[name='QTY']").eq(i-1).val());
			sTotalAmt    = Number(sTotalAmt) + Number(sAmt);
			// 목록/일반통관 체크(일반통관:Y)
			if ( $("select[name='ARC_SEQ'] option:selected").eq(i-1).attr("rel") == "Y" ) {
				sTtCtmsCnt += 1;
			}
		}

		sSaleAmt    = 0;//$("input[name='SALE_AMT']").val();
		sTaxAmt     = 0;//$("input[name='TAX_AMT']").val();
		sFrgShipMny = $("input[name='SHIP_AMT']").val();

		sTotalAmt = Number(sTotalAmt) + Number(sTaxAmt) - Number(sSaleAmt) + Number(sFrgShipMny);
		sTotalAmt = sTotalAmt.toFixed(2);

		$("#PRO_AMT").val(sTotalAmt);
		$("#PRO_QTY").val(sTotalProCnt);

		// 보헙옵션 체크(￥1500미만)
		if ( Number(sTotalAmt) < 1500 ) {
			$("input[name='EtcDlvr']").each( function(idx) {
				if ( $(this).val() == "28" ) {
					$(this).prop("checked", false);
					$(this).attr("disabled", true);
				}
			});
		} else {
			$("input[name='EtcDlvr']").each( function(idx) {
				if ( $(this).val() == "28" ) {
					$(this).attr("disabled", false);
					// 보험 가입 체크 시
					if ( $(this).prop("checked") == true ) {
						var fCifMny = 0, fCifKrwMny = 0;
						fCifMny = Number(sTotalAmt) * ( Number($(this).attr("mny")) / 100 );
						fCifKrwMny = fnNumRound(fCifKrwMny, 10);
					}
				}
			});
		}

		fnTrkNoChk();

		document.getElementById("TextTotalProCNT").innerHTML = sTotalProCnt;
		document.getElementById("TextTotalAmt").innerHTML    = sTotalAmt;
		// fnToolTipInit();
	}

function fnImgChg(TempNum) {
	var sLen = $("input[name='ROW_NUM']").length;

	var sImgUrl = $("input[name='IMG_URL']").eq(Number(TempNum)-1).val(); 
 
	if (sImgUrl != "") {
		$("#sImgNo"+TempNum).attr('src',sImgUrl);
	}
	else {
		$("#sImgNo"+TempNum).attr('src','/template/images/sample_img.jpg'); 
	}
}
function fnTrkNoChk() {
	var aTrkNo = [], sBfTrk = null, sTrkNoNum = 0;
	// 상품 Loop
	for(var i = 1; i <= Number($("#TempProNum").val()); i++) {
		aTrkNo.push( $("input[name='FRG_IVC_NO']").eq(i-1).val() );
	}
	// 오름차순 정렬
	aTrkNo.sort();
	for ( var i=0; i < aTrkNo.length; i++) {
		if ( sBfTrk != aTrkNo[i] ) sTrkNoNum += 1;
		sBfTrk = aTrkNo[i];
	}

	$("#TempCtmsNum").val( sTrkNoNum );
	$("#htTrkNoNum").text( sTrkNoNum );
	if ( sTrkNoNum > 1 ) { 
		$("#htDlvrTyNm").text( "합배송" );
		$("#htDlvrTyNm").removeClass("boxTy1");
		$("#htDlvrTyNm").addClass("boxTy2");
		$("#DLVR_TY_CD").val("2");
	} else { 
		$("#htDlvrTyNm").text( "단독배송" );
		$("#htDlvrTyNm").removeClass("boxTy2");
		$("#htDlvrTyNm").addClass("boxTy1");
		$("#DLVR_TY_CD").val("1");
	}
}

function fnStockTempDel(val1){
	$("#TempShopNum").val(val1); 
	var seq = $("input[name='PRO_STOCK_SEQ']").eq(val1-1).val();
	fnPageDel(val1);
}

function fnPageDel(TempNum){ 
	var EndNum = $("#sProNum").val();

	if ( EndNum == "1" ) {
		alert("한개의 상품은 삭제할 수 없습니다.");
		return;
	}  
	// if (Number($("input[name='ARV_STAT_CD']").eq(TempNum-1).val()) != 1 ){
	// 	alert("입고대기가 아닌것은 삭제 할 수 없습니다..");
	// 	return;
	// }
	if ( TempNum != Number($("#sProNum").val()) ){  
 		//TempNum = 3
		//이전으로 한칸씩 댕기기  5개중 3번을 지우면 3번에 4번이 4번에 5번이 5번 삭제
		for(var i = TempNum; i <= Number($("#TempProNum").val()); i++) {
			if( $("select[name='ARC_SEQ']").eq(i).val() != undefined){
				var Aurl = "?CATE_SEQ="+$("select[name='PARENT_CATE']").eq(i).val()+"&ShopNum="+i; 
				//fnGetChgHtmlAjax("TextArc_"+i , "/Library/Html/Acting/CtmArc_A.asp", Aurl);
			}
			$("input[name='ARV_STAT_CD']").eq(i-1).val($("input[name='ARV_STAT_CD']").eq(i).val());   //상태
			$("input[name='PRO_SEQ']").eq(i-1).val($("input[name='PRO_SEQ']").eq(i).val()); 
			$("input[name='ROW_NUM']").eq(i-1).val($("input[name='ROW_NUM']").eq(i).val()); 
			$("input[name='ORD_SITE']").eq(i-1).val($("input[name='ORD_SITE']").eq(i).val()); 
			$("input[name='SHOP_ORD_NO']").eq(i-1).val($("input[name='SHOP_ORD_NO']").eq(i).val()); 
			$("input[name='SHIP_NM']").eq(i-1).val($("input[name='SHIP_NM']").eq(i).val()); 
			$("select[name='FRG_DLVR_COM']").eq(i-1).val($("select[name='FRG_DLVR_COM']").eq(i).val()); 
			$("input[name='FRG_IVC_NO']").eq(i-1).val($("input[name='FRG_IVC_NO']").eq(i).val()); 
			$("input[name='PRO_NM']").eq(i-1).val($("input[name='PRO_NM']").eq(i).val()); 
			$("input[name='PRO_NM_CH']").eq(i-1).val($("input[name='PRO_NM_CH']").eq(i).val());
			//alert($("input[name='PRO_NM_CH']").eq(i).val());
			$("input[name='BRD']").eq(i-1).val($("input[name='BRD']").eq(i).val()); 
			$("input[name='CLR']").eq(i-1).val($("input[name='CLR']").eq(i).val()); 
			$("input[name='SZ']").eq(i-1).val($("input[name='SZ']").eq(i).val()); 
			$("input[name='COST']").eq(i-1).val($("input[name='COST']").eq(i).val()); 
			$("input[name='QTY']").eq(i-1).val($("input[name='QTY']").eq(i).val()); 
			$("input[name='AMT']").eq(i-1).val($("input[name='AMT']").eq(i).val()); 
			$("select[name='ARC_SEQ']").eq(i-1).val($("select[name='ARC_SEQ']").eq(i).val()); 
			$("input[name='PRO_URL']").eq(i-1).val($("input[name='PRO_URL']").eq(i).val()); 
			$("input[name='IMG_URL']").eq(i-1).val($("input[name='IMG_URL']").eq(i).val());
			$("select[name='PARENT_CATE']").eq(i-1).val($("select[name='PARENT_CATE']").eq(i).val()); 
			$("select[name='ARC_SEQ']").eq(i-1).val($("select[name='ARC_SEQ']").eq(i).val()); 
			$("input[name='StockTxt']").eq(i-1).val($("input[name='StockTxt']").eq(i).val());
			$("input[name='PRO_STOCK_SEQ']").eq(i-1).val($("input[name='PRO_STOCK_SEQ']").eq(i).val()); 
			fnImgChg(i);


			if ($("input[name='PRO_STOCK_SEQ']").eq(i).val() > 0)
			{
				$("#DLVR_"+i).css("display","none");
				$("#ORD_"+i).css("display","none");
			}else{
				$("#DLVR_"+i).css("display","");
				$("#ORD_"+i).css("display","");
			}

			// 입고대기 아니면 수정불가
			if (Number($("input[name='ARV_STAT_CD']").eq(i-1).val()) == 1 ){ 
				$("input[name='ORD_SITE']").eq(i-1).attr("readonly",false);
				$("input[name='PRO_NM']").eq(i-1).attr("readonly",false);
				$("input[name='PRO_NM_CH']").eq(i-1).attr("readonly",false);
				$("input[name='BRD']").eq(i-1).attr("readonly",false);
				$("input[name='COST']").eq(i-1).attr("readonly",false);
				$("input[name='QTY']").eq(i-1).attr("readonly",false);
				$("input[name='AMT']").eq(i-1).attr("readonly",false);
				$("input[name='PRO_URL']").eq(i-1).attr("readonly",false);

			}else{
				$("input[name='ORD_SITE']").eq(i-1).attr("readonly",true);
				$("input[name='PRO_NM']").eq(i-1).attr("readonly",true);
				$("input[name='PRO_NM_CH']").eq(i-1).attr("readonly",true);
				$("input[name='BRD']").eq(i-1).attr("readonly",true);
				$("input[name='COST']").eq(i-1).attr("readonly",true);
				$("input[name='QTY']").eq(i-1).attr("readonly",true);
				$("input[name='AMT']").eq(i-1).attr("readonly",true);
				$("input[name='PRO_URL']").eq(i-1).attr("readonly",true);
			}

			if ( $("select[name='ARC_SEQ']").eq(i-1).val() ){
				fnArcChkYN(i,$("select[name='ARC_SEQ']").eq(i-1).val());
			}
		}
	}

	$("#TextProduct"+EndNum).html("");
	$("#TempProNum").val(Number(EndNum)-1);
	$("#sProNum").val(Number(EndNum)-1); 

	fnTotalProPrice();
}

function fnProPlus(TempNum){
	var gMaxProCnt = "<%=gMaxProCnt%>";

	var sShopNum = Number($("#sProNum").val())+1;

	if (sShopNum > 30)
	{
		alert('상품 종류는 30개를 넘길 수 없습니다.');
		return;
	}
 
	if (sShopNum > gMaxProCnt){
		alert(gMaxProCnt+"개 이상은 추가 할수 없습니다.");
	}else{
		$("#sProNum").val(sShopNum);
		fnProductAjax(sShopNum);
	}
	fnTotalProPrice();
}

function fnValKeyRep( pPatt, pObj ) {
	pObj.value = pObj.value.replace( pPatt, '' );
}