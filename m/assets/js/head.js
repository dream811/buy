var xmlRequest;

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

	if ($("#sMoveStatSeq").val() == "" && (val == "C" || val == "E")) {
		alertify.error('변경할 주문 상태를 선택하십시오.');
		return;
	}
	if (fnSelBoxCnt($(frmObj + " input[name='chkORD_SEQ']")) <= 0) {
		alertify.error('주문을 선택하십시오.');
		return;
	}

	$("#ORD_SEQ").val(fnCkBoxVal( "frmList", "chkORD_SEQ"))

	if (confirm(aTit)) {
		document.frmList.encoding = "application/x-www-form-urlencoded"; 
		$("#frmList").attr("method", "post").attr("action", "./changeOrder").attr("target", "prcFrm");
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
