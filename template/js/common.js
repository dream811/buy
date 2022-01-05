var aRrnCdNm = new Array(3);
var xmlRequest;
aRrnCdNm[1] = "개인통관고유번호를 입력해 주세요.";
aRrnCdNm[2] = "'-'을 제외한 주민번호 13자리를 입력해 주세요.";
aRrnCdNm[3] = "'-'을 제외한 사업자번호 10자리를 입력해 주세요.";
var lastItemIndex = 5;
function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};
function gotoTop(){
	$("html, body").animate({ scrollTop: 0 }, "slow");
}
function fnCommaNum(num) {

	if (num < 0) { num *= -1; var minus = true}
	else var minus = false

	var dotPos = (num+"").split(".")
	var dotU = dotPos[0]
	var dotD = dotPos[1]
	var commaFlag = dotU.length%3

	if(commaFlag) {
			var out = dotU.substring(0, commaFlag)
			if (dotU.length > 3) out += ","
	}
	else var out = ""

	for (var i=commaFlag; i < dotU.length; i+=3) {
			out += dotU.substring(i, i+3)
			if( i < dotU.length-3) out += ","
	}

	if(minus) out = "-" + out
	if(dotD) return out + "." + dotD
	else return out
}
function fnFrgImgView2(sOrdSeq) {
	var $iframe = $('#ifrm');
	$iframe.attr('src','/view-photo?sOrdSeq='+sOrdSeq);
	$("#silsa_modal").modal();
}
function fnValKeyRep( pPatt, pObj ) {
	pObj.value = pObj.value.replace( pPatt, '' );
}
function fnPopMemAddr(){ 
	var Rtn_val;
	Rtn_val = "?rtnFunNm=fnMemAddrCfm";
	fnPopWinCT("/User_MemAddr_S", "My_Addr", 420, 500, "N");
}
function fnPopPlus(val){ 
	var	reVal = "";
	reVal = "?sOrdSeq="+val+"&mode=plus";
	fnPopWinCT("/activeCombine"+reVal, "OrdJoin", 420, 500, "Y");
}

function fnPopMinus(val){
	var	reVal = "";
	reVal = "?sOrdSeq="+val+"&mode=minus";
	fnPopWinCT("/activeCombine"+reVal, "OrdJoin", 420, 500, "Y");
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

 function fnFocusInExp( pNm, pExp ) {
	var fNm = $("input[name='" + pNm + "']");
	var fVal = pExp;

	if ( fNm.val() == pExp ) {
		$("#RRN_NO").val("");
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

function fnPageCopy2(TempNum,opt=null){
	var gMaxProCnt = "<%=gMaxProCnt%>";
	var sShopNum = Number($("#sProNum").val())+1;
 
	if (sShopNum > 100)
	{
		alert('상품 종류는 100개를 넘길 수 없습니다.');
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
			fnProductAjax(sShopNum,opt); 
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
			// fnArcAjax($("select[name='PARENT_CATE']").eq(TempNum-1).val(),sShopNum);
			$("select[name='ARC_SEQ']").eq(sShopNum-1).html($("select[name='ARC_SEQ']").eq(TempNum-1).html());
			$("select[name='ARC_SEQ']").eq(sShopNum-1).val($("select[name='ARC_SEQ']").eq(TempNum-1).val());		
			fnImgChg(sShopNum);
			// if ( $("select[name='ARC_SEQ']").eq(TempNum-1).val() )
			// 	fnArcChkYN(sShopNum,$("select[name='ARC_SEQ']").eq(TempNum-1).val());
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
	fnGetChgHtmlAjax("TextProduct"+sShopNum, "/getProduct", url);
	// var dd  =$("#TextProduct"+sShopNum);
	// jQuery.ajax({
	// type : "GET",
	// url : baseURL+"getProduct",
	// data : { ORD_TY_CD : ord,sShopNum:sShopNum } 
	// }).done(function(data){
	// 	dd.html(data.trim());
	// });
}


function fnGetChgHtmlAjax(parm, combUrl, TailVal) {    
	var strv = DoCallbackCommon(combUrl+TailVal);
	$("#"+parm).html(strv);
	//document.getElementById(parm).innerHTML = strv;
}

function DoCallbackCommon(url){
	var tmpData = " ";
	CreateXMLHttpRequest();
	xmlRequest.open("GET", url, false);
	xmlRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
	xmlRequest.send(tmpData);
	return xmlRequest.responseText;
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

function fnProPlus(TempNum,opt=null){
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
		fnProductAjax(sShopNum,opt);
	}
	fnTotalProPrice();
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
	if (Number($("input[name='ARV_STAT_CD']").eq(TempNum-1).val()) != 1 ){
		alert("입고대기가 아닌것은 삭제 할 수 없습니다..");
		return;
	}
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


function fnArcChkYN(val1,val2){
	$("#TempShopNum").val(val1); 
	var val = "sArcSeq=" + val2;  
	fnCtmArcProNmGet(val1);
}

function fnCtmArcProNmGet(ShopNum) {
	var fProNmEn = "", fProNmCn = "";

	fProNmEn = $(gFrmNm + " select[name='ARC_SEQ'] option:selected").eq(ShopNum-1).attr("EnChar");
	fProNmCn = $(gFrmNm + " select[name='ARC_SEQ'] option:selected").eq(ShopNum-1).attr("CnChar");
	//alert(fProNmCn);
	
	$(gFrmNm + " input[name='PRO_NM']").eq(ShopNum-1).val( fProNmEn );
	$(gFrmNm + " input[name='PRO_NM_CH']").eq(ShopNum-1).val( fProNmCn );
}

function fnMsgFcs(pObj, pMsg) {
	alert(pMsg);
	pObj.focus();
}

function fnIptChk( pObj ) {

	var fObj = pObj;
	var fTf = false;

	if ( $.trim(fObj.val()) == "" ) fTf = false;
	else fTf = true;

	return fTf;
}

function CallBackPost(xmlRequest) {
	if (xmlRequest.readyState == 4) {

		if (xmlRequest.status == 200) {
			var val = xmlRequest.responseText;
			if (val == "-1"){
				alert('자료가 잘못되었습니다.');
			}else{  
				val = parseInt(val);
				switch ( val ) {
					case 100  : window.location.reload();return;
					case 101 : alert("현재 유저정보는 이미 존재하지 않습니다.");return; 
					case -3 : fnOrdStep('12'); return;
					case 102 : alert("장바구니에 추가되였습니다"); return;
					case 103 : alert("옵션을 선택해주세요"); return;
					default: fnOrdProVw(val); return;
				}
			}
		} else {
			alert('실패!');
		}
	}
}

function DoCallbackCommonPost(combUrl,TailVal){
	var pageUrl = combUrl;
	CreateXMLHttpRequest();
	xmlRequest.open("POST", pageUrl, true);
	xmlRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); 
	xmlRequest.onreadystatechange = function() {CallBackPost(xmlRequest)};
	xmlRequest.send(TailVal);  
}

function fnChkBoxTotal(sObj, sObjSel) {
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


function fnNumComma(str) {

   var str = "" + str;
   var objRegExp = new RegExp("(-?[0-9]+)([0-9]{3})");
   while (objRegExp.test(str)) {
      str = str.replace(objRegExp, "$1,$2");
   }

   return str;
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
function fnNumChiperCom(sObj, sChiper) {
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
	sObj.value = sPm + "" + fnNumComma(sNum);
}

function fnImgUrlAdd(TempNum) {
	fnPopWinCT("/registerImage", "ProImgUrl", 400, 250, "N")
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

	//var iLeft, iTop;
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


function insertComment(id,comment_id=0){
	var hitURL = baseURL + "insertComment";
	if($("#content").val().trim() =='') return;
	var content = $("#content").val();
	jQuery.ajax({
	type : "POST",
	dataType : "json",
	url : hitURL,
	data : { postId : id,content:content,id:comment_id } 
	}).done(function(data){
		if(data.status ==1)
			socket.emit("chat message",data.p,data.o,data.userId,data.tt,data.userName);
		window.location.reload();
	});
}

function fnDlvrMnyPop(){
	fnPopWinCT("/Dlvr_Mny_Pop_W", "DlvrMnyPop", 420, 670, "Y");
}



function selectAddrs(id){
	$("#CTR_SEQ"+id).prop("checked", true);
	$("input[name=CTR_SEQ]").each(function(index,item){
		var addr_id = $(this).data("addrsid");
		if($(this).is(':checked')) 
			$("#add_img_"+addr_id).attr("src","/template/images/add_selected.png");
		else
			$("#add_img_"+addr_id).attr("src","/template/images/add_unselected.png");
	});
}

function selectIncome(id){
	$("#REG_TY_CD"+id).prop("checked", true);
	$("input[name=REG_TY_CD]").each(function(index,item){
		var addr_id = $(this).val();
		if($(this).is(':checked')) 
			$("#income_img_"+addr_id).attr("src","/template/images/add_selected.png");
		else
			$("#income_img_"+addr_id).attr("src","/template/images/add_unselected.png");
	});
}

function deletepost(id,type=""){
	var ok = confirm("정말 삭제하시겠습니까?");
	if(ok == true){
		var hitURL = baseURL + "deletepost";
		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { postId : id} 
		}).done(function(data){
			if(type !=""){
				location.href = "/panel?id=" + type;
				return;
			}
			window.history.back();
		});
	}
}



function clickMore(obj){
	var data = { limit : lastItemIndex,type:o_type,category:category};
    if(lastItemIndex < lp){
    	loadMore(lastItemIndex,data,rate,obj);
    	lastItemIndex = lastItemIndex+5;
    }
    else{
    	$(".clickmore").addClass("disabled");
    }
}

function fnMemAddrCfm(aAddr) {
    var aMemAddr = aAddr.split("|");
    var aMobNo = "";
    aMobNo = aMemAddr[5].split("-");

    $("input[name='ADRS_KR']").val( aMemAddr[0] );
    $("input[name='ADRS_EN']").val( aMemAddr[1] );
    $("input[name='ZIP']").val( aMemAddr[2] );
    $("input[name='ADDR_1']").val( aMemAddr[3] );
    $("input[name='ADDR_2']").val( aMemAddr[4] );
    $("input[name='MOB_NO1']").val( aMobNo[0] );
    $("input[name='MOB_NO2']").val( aMobNo[1] );
    $("input[name='MOB_NO3']").val( aMobNo[2] );
    $("input[name='RRN_CD']:radio[value='" + aMemAddr[6] + "']").prop("checked", true);
    $("input[name='RRN_NO']").val( aMemAddr[7]);
    $("input[name='ADDR_1_EN']").val( aMemAddr[8] );
    $("input[name='ADDR_2_EN']").val( aMemAddr[9] );
}

function ConvertStringToHex(str) {
    var arr = [];
    for (var i = 0; i < str.length; i++) {
        arr[i] = ("00" + str.charCodeAt(i).toString(16)).slice(-4);
    }
    return "\\u" + arr.join("\\u");
}

function ConvertHexToString(str) {
    return unescape(str.replace(/\\/g, "%"));
}