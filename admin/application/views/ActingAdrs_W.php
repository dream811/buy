<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/admin.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/user.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/table.min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script src='<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js'></script>
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
    <script charset="UTF-8" type="text/javascript" src="http://t1.daumcdn.net/postcode/api/core/191007/1570443254160/191007.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/head.js"></script>
</head>
<body>
    <div class="pop-title">
        <h3>주문번호 : <?=$delivery[0]->ordernum?> - 수취인정보 수정</h3>
    </div>
    <div id="pop_wrap">
        <form method="post" name="frmPageInfo" id="frmPageInfo">
            <input type="hidden" name="ORD_SEQ" id="ORD_SEQ" value="<?=$delivery[0]->id?>">
            <div id="stepOrd-EtcTt">
                <div class="step_box">

                    <p class="clrBoth" id="TextBlankTab1"></p>

                    <div class="orderStepTit">
                        <p>
                            <span class="stepTxt">STEP</span>
                            <span class="stepNo">01</span>
                        </p>
                        <h4>받는 사람 정보를 입력해주세요.</h4>
                    </div>

                    <div class="order_table">
                        <table class="order_write" summary="주소검색, 우편번호, 주소, 상세주소, 수취인 이름(한글), 수취인 이름(영문), 전화번호, 핸드폰번호, 용도, 주민번호, 통관번호 셀로 구성">
                            <colgroup>
                                <col width="15%">
                                    <col width="35%">
                                        <col width="15%">
                                            <col width="35%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>받는 사람</th>
                                    <td colspan="3">
                                        <div class="addrRcvKr">
                                            <ul class="RcvKrBox">
                                                <li>한글
                                                    <input type="text" name="ADRS_KR" id="ADRS_KR" maxlength="60" class="input_txt2 ipt_type1" 
                                                    onkeyup="fnHanEng(this.value, frmPageInfo.ADRS_EN);" onblur="fnHanEng(this.value, frmPageInfo.ADRS_EN);" 
                                                    value="<?=$delivery[0]->billing_krname?>">
                                                </li>
                                                <li>
                                                    <a href="javascript:fnPopMemAddr('<?=$delivery[0]->userId?>');" class="btn btn-sm btn-primary"><span>주소록 가져오기</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <p class="clrBoth pHt10"></p>
                                        <div class="addrRcvEn">
                                            영문
                                            <input type="text" name="ADRS_EN" id="ADRS_EN" maxlength="60" class="input_txt2 ipt_type1" 
                                            value="<?=$delivery[0]->billing_name?>">
                                            *사업자 영문명은 반드시 고쳐주세요 (한글발음나는대로 입력시 통관지연)
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>받는 사람 정보</th>
                                    <td colspan="3">
                                        <div class="addrRcvKr">
                                            <ul class="RcvKrBox">
                                                <li class="ckBox">
                                                    <label>
                                                        <input type="radio" class="input_chk vm" name="RRN_CD" id="RRN_CD" value="1"
                                                        <?php if($delivery[0]->person_num ==1) echo  " checked"; ?>	> 개인통관고유부호 (추천)</label>
                                                </li>
                                                <li class="ckBox">
                                                    <label>
                                                        <input type="radio" class="input_chk vm" name="RRN_CD" id="RRN_CD" value="3"
                                                        <?php if($delivery[0]->person_num ==3) echo  " checked"; ?>	> 사업자등록번호</label>
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="addrRcvEn">
                                            <ul>
                                                <li>
                                                    <input type="text" name="RRN_NO" id="RRN_NO" maxlength="20" class="input_txt2 m_num" value="<?=$delivery[0]->person_unique_content?>" onfocus="fnFocusInExp( 'RRN_NO', aRrnCdNm[$('input[name=RRN_CD]:radio:checked').val()] );" onblur="fnFocusOutReg( 'RRN_NO', aRrnCdNm[$('input[name=RRN_CD]:radio:checked').val()], /[^a-zA-Z0-9]/g );">
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th>주소 및 연락처</th>
                                    <td colspan="3">
                                        <ul class="addrTel2">
                                            <li class="vm_box">
                                                <label>연락처</label>
                                                <input type="text" name="MOB_NO1" id="MOB_NO1" maxlength="4" class="input_txt2 hp" onkeypress="fnChkNumeric();" value="<?=!empty(explode("-",$delivery[0]->phone_number)[0]) ? explode("-",$delivery[0]->phone_number)[0]:""?>" title="전화번호 첫자리"> -
                                                <input type="text" name="MOB_NO2" id="MOB_NO2" maxlength="4" class="input_txt2 hp" onkeypress="fnChkNumeric();" value="<?=!empty(explode("-",$delivery[0]->phone_number)[1]) ? explode("-",$delivery[0]->phone_number)[1]:""?>" title="전화번호 중간자리"> -
                                                <input type="text" name="MOB_NO3" id="MOB_NO3" maxlength="4" class="input_txt2 hp" onkeypress="fnChkNumeric();" value="<?=!empty(explode("-",$delivery[0]->phone_number)[2]) ? explode("-",$delivery[0]->phone_number)[2]:""?>" title="전화번호 마지막자리">
                                            </li>
                                            <li class="vm_box">
                                                <label>우편번호</label>
                                                <input type="text" name="ZIP" id="ZIP" maxlength="8" class="input_txt2" value="<?=$delivery[0]->post_number?>" readonly="">
                                                <a href="javascript:openDaumPostcode();" class="btn btn-sm btn-primary"><span>우편번호 검색</span></a>
                                            </li>
                                            <li class="vm_box">
                                                <label>주소</label>
                                                <input type="text" name="ADDR_1" id="ADDR_1" maxlength="100" 
                                                class="input_txt2 adr" value="<?=$delivery[0]->address?>" readonly="" style="width:70%">
                                            </li>
                                            <li class="vm_box">
                                                <label>상세주소</label>
                                                <input type="text" name="ADDR_2" id="ADDR_2" maxlength="100" class="input_txt2 adr" value="<?=$delivery[0]->detail_address?>" onkeyup="fnHanEng(this.value, frmPageInfo.ADDR_2_EN);fnAddrChk(this);" onblur="fnHanEng(this.value, frmPageInfo.ADDR_2_EN);" style="width:70%">
                                                <br>
                                                <div style="padding-top:5px">
                                                    <label></label>* 도로명 주소를 써주세요. 지번 주소 기재 시 통관/세관에서 오류로 분류시켜 통관지연이 될 수 있습니다</div>
                                            </li>
                                            <input type="hidden" name="ADDR_1_EN" id="ADDR_1_EN" value="">
                                            <input type="hidden" name="ADDR_2_EN" id="ADDR_2_EN" value="">
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <th>배송 요청사항</th>
                                    <td colspan="3">
                                        <select style="width:94%;" class="form-control" id="sSelReq" onchange="fnReqValGet(this.value);">
                                            <option value="">직접기재</option>
                                            <option value="배송 전 연락 바랍니다">배송 전 연락 바랍니다</option>
                                            <option value="부재시 경비실에 맡겨주세요">부재시 경비실에 맡겨주세요</option>
                                            <option value="부재시 집앞에 놔주세요">부재시 집앞에 놔주세요</option>
                                            <option value="택배함에  맡겨주세요">택배함에 맡겨주세요</option>
                                        </select>
                                        <div style="line-height:150%;padding-top:5px;">
                                            <input type="text" name="REQ_1" id="REQ_1" maxlength="100" class="input_txt2 full" 
                                            value="<?=$delivery[0]->request_detail?>">
                                            <br>
                                            <div style="padding-top:8px;">
                                                * 국내 배송기사 분께 전달하고자 하는 요청사항을 남겨주세요(예: 부재 시 휴대폰으로 연락주세요.)
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="btn-area" style="text-align:center">
                <span class="whGraBtn_bg ty2">
					<button type="button" class="btn btn-primary" onclick="javascript:fnAdrsSave();">수정</button>
				</span>
                <span class="whGraBtn ty2">
					<button type="button" class="btn btn-default" onclick="javascript:self.close();">닫기</button>
				</span>
            </div>
        </form>
    </div>
</body>

</html>

<script>
	var aRrnCdNm = new Array(3);
	aRrnCdNm[1] = "媛쒖씤�듦�怨좎쑀踰덊샇瑜� �낅젰�� 二쇱꽭��.";
	aRrnCdNm[2] = "'-'개인통괍부호 글수는 13글자이여야 합니다.";
	aRrnCdNm[3] = "사용자등록번호는 10글자이여야 합니다..";

    function openDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
				if ( data.userSelectedType == "R" ) {
					document.getElementById('ZIP').value = data.zonecode;
					document.getElementById('ADDR_1').value = data.roadAddress;
					document.getElementById('ADDR_2').focus();
					document.getElementById('ADDR_1_EN').value = data.addressEnglish;
				} else {
					alert("지번주소가 아닌 도로명주소를 선택하십시오.");
				}
            }
        }).open();
    }
</script>
<script type="text/javascript">

var gFrmNm = "#frmPageInfo";
$(document).ready( function() {
	$(".orderStepTit .stepNo").text("01");
});

function fnAdrsSave(){

	//등록 체크 
	if ( !fnIptChk($("#ZIP")) ) {
		fnMsgFcs($("#ZIP"), '주소검색으로 주소를 찾아 주세요.');
		return;
	}  
 
	if ( !fnIptChk($("#ADRS_KR")) ) {
		fnMsgFcs($("#ADRS_KR"), '수취인 이름을 입력해 주세요.');
		return;
	}  
	if ( !fnIptChk($("#ADRS_EN")) ) {
		fnMsgFcs($("#ADRS_EN"), '수취인 영문 이름을 입력해 주세요.');
		return;
	}  
	
	if ( !fnIptChk($("#MOB_NO2"), 3, 4) ) {
		fnMsgFcs($("#MOB_NO2"), '연락처를 입력해 주세요.');
		return;
	}  

	if ( !fnIptChk($("#MOB_NO3"), 3, 4) ) {
		fnMsgFcs($("#MOB_NO3"), '연락처를 입력해 주세요.');
		return;
	}  	
  
	if ( !$('input[name=RRN_CD]:radio:checked').val() ) {
		alert("받는 사람 정보 중 하나를 선택해 주세요.");
		return;
	}

	switch ( $("input[name='RRN_CD']:radio:checked").val() ) {
	case "1":
		if ( $("input[name='RRN_NO']").val().length < 8 || $("input[name='RRN_NO']").val() == aRrnCdNm[1] ) {
			fnMsgFcs($("#RRN_NO"), aRrnCdNm[1]);
			return;
		} break;
	case "2":
		var fReg = /^[0-9]{13}/;
		var fRegNo = $("input[name='RRN_NO']").val();
		if ( fRegNo.length != 13 ) {
			fnMsgFcs($("#RRN_NO"), aRrnCdNm[2]);
			return false;
		}

		if ( !fReg.test(fRegNo) ) {
			fnMsgFcs($("#RRN_NO"), aRrnCdNm[2]);
			return false;
		} break;
	case "3":
		var fReg = /^[0-9]{10}/;
		var fRegNo = $("input[name='RRN_NO']").val();
		if ( fRegNo.length != 10 ) {
			fnMsgFcs($("#RRN_NO"), aRrnCdNm[3]);
			return false;
		}

		if ( !fReg.test(fRegNo) ) {
			fnMsgFcs($("#RRN_NO"), aRrnCdNm[3]);
			return false;
		} break;
	
	}

	$(gFrmNm).attr("action", "./ActingAdrs_M");
	$(gFrmNm).submit();
}

function fnReqValGet(sVal) {
	$(gFrmNm + " input[name='REQ_1']").val( sVal );
}
function fnHanEng(pVal, pTarget) {	
	var sCho, sJung, sChong;

	sCho		= ["G","Gg","N","D","Tt","R","M","B","Pp","S","Ss","O","J","Jj","Ch","K","T","P","H"];
	sJung		= ["a","ae","ya","yae","eo","e","yeo","ye","o","wa","wae","oe","yo","u","wo","we","wi","yu","eu","ui","i"];
	sChong	= ["","g","gg","gs","n","nz","nh","d","l","lg","lm","lb","ls","lt","lp","lh","m","b","bs","s","ss","ng","z","ch","k","t","p","h"];

	var sVal = pVal;
	var sTarget = pTarget;

	var t = "";
	var tmp = "";
	var n, n1, n2, n3;
	var c, d;
	var PHAN = "";
	var PENG = "";
	var j;
	var o = sTarget;
    for (i = 0; i < sVal.length; i++) {
		c = sVal.charAt(i);
		n = parseInt(escape(c).replace(/%u/g, ''), 16); 
        if (n >= 0xAC00 && n <= 0xD7A3) {
			n = n - 0xAC00;
            n1 = Math.floor(n / (21 * 28));
            n = n % (21 * 28);
            n2 = Math.floor(n / 28);
            n3 = Math.floor(n % 28);
            tmp = sCho[n1] + sJung[n2] + sChong[n3];
            if (tmp.length > 1 && tmp.charAt(0) == 'O')
				tmp = ("" + tmp.charAt(1)).toUpperCase() + tmp.substring(2);
				if (i == 0)	{
				//	tmp ="KWON" ;
					if(c == "권"){
						tmp = "KWON";					
					}else if(c == "김"){ 
						tmp = "KIM";
					}else if(c == "이"){
						tmp ="LEE";
					}else if(c == "류"){
						tmp ="RYU";
					}else if(c == "박"){
						tmp ="PARK";
					}else if(c == "최"){
						tmp ="CHOI";
					}else if(c == "오"){
						tmp ="OH";
					}else if(c == "우"){
						tmp ="WOO";
					}else if(c == "주"){
						tmp ="JOO";
					}
				}
                t += tmp;				
				}
				else
					t += c;
		
        }
		t = t.toUpperCase();
		o.value = t;
        return t;
    }

  function fnPopMemAddr(sMemCode){ 
	var Rtn_val;
	Rtn_val = "?rtnFunNm=fnMemAddrCfm";
	fnPopWinCT("/admin/User_MemAddr_S?sMemCode="+sMemCode, "My_Addr", 800, 500, "N")
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
</script>