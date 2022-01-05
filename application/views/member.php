<?php if(!empty($this->session->userdata("error"))): ?>
<script>
	alert("<?=$this->session->userdata("error")?>");
</script>>
<?php endif; ?>
<div class="container">
	<div class="row">
		<?php $this->load->view("left_menu",array("left"=>"my")); ?>
		<div id="subRight" class="col-md-9">
			<div class="row">
				<div class="col-md-12">
					<div class="padgeName">
						<h2>회원정보</h2>
					</div>
				</div>
			</div>
			<div class="con">
				<div class="row">
					<div class="col-xs-12">
						<form method="post"  id="frmMem" action="/editUser">
						    <div class="con">
						        <div class="t_board">
						            <table class="board_write">
						                <caption>회원정보입력</caption>
						                <colgroup>
						                    <col width="15%">
						                    <col width="35%">
						                    <col width="15%">
						                    <col width="35%">
						                </colgroup>
						                <tbody>
						                    <tr>
						                        <th>아이디</th>
						                        <td colspan="3">
						                            <span class="bold"><?=$user[0]->loginId?></span>
						                        </td>
						                    </tr>
						                    <tr>
						                        <th>가입일</th>
						                        <td><?=$user[0]->createdDtm?></td>
						                        <th>마지막 접속일</th>
						                        <td><?=$user[0]->log_date?></td>
						                    </tr>
						                    <tr>
						                        <td colspan="4" style="height:2px;"></td>
						                    </tr>

						                    <tr>
						                        <th>닉네임</th>
						                        <td>
						                            <?=$user[0]->nickname?>
						                            <input type="hidden" name="sNick" id="sNick" maxlength="20" class="input_txt2 ipt_type1" value="elen" readonly="">

						                        </td>
						                        <th>생년월일</th>
						                        <td><?=$user[0]->birthday?></td>
						                    </tr>

						                    <tr>
						                        <th>이름</th>
						                        <td colspan="3">
						                            <?=$user[0]->name?>
						                            <input type="hidden" name="sMemEnNm" id="sMemEnNm" maxlength="30" class="input_txt2 ipt_type1" value="">
						                        </td>
						                    </tr>

						                    <tr>
						                        <th>변경할 비밀번호</th>
						                        <td>
						                            <input type="password" name="password" id="password" maxlength="20" class="input_txt2 ipt_type1" >
						                        </td>
						                        <th>비밀번호 확인</th>
						                        <td>
						                            <input type="password" name="cpassword" id="cpassword" maxlength="20" class="input_txt2 ipt_type1" value="">
						                        </td>
						                    </tr>
						                    <tr>
						                        <th>주소</th>
						                        <td colspan="3">
						                            <ul class="addrTel">
						                                <li class="vm_box">
						                                    <label>우편번호</label>
						                                    <input type="text" name="zip" id="zip" maxlength="8" class="input_txt2" value="<?=$user[0]->postNum?>" readonly="">
						                                    <a href="javascript:openDaumPostcode();" class="vm btn btn-warning text-white btn-sm btn-round"><span>우편번호 검색</span></a>
						                                </li>
						                                <li class="vm_box">
						                                    <label style="width: 55px">주소</label>
						                                    <input type="text" name="addr_1" id="addr_1" maxlength="100" class="input_txt2 adr" value="<?=$user[0]->address?>" readonly required>
						                                </li>
						                                <li class="vm_box lht_150">
						                                    <label>상세주소</label>
						                                    <input type="text" name="details" id="details" maxlength="100" class="input_txt2 adr" value="<?=$user[0]->detail_address?>">
						                                    <br>
						                                    <label></label>* 도로명 주소를 써주세요. 지번 주소 기재 시 통관/세관에서 오류로 분류시켜 통관지연이 될 수 있습니다
						                                </li>
						                            </ul>
						                        </td>
						                    </tr>
						                    <tr>
						                        <th>휴대폰</th>
						                        <td>
						                            <input type="text" name="sMobNo1" id="sMobNo1" maxlength="4" class="input_txt2 hp" value="<?=explode("-",$user[0]->mobile)[0]?>" onchange="fnMobChkReset();"> -
						                            <input type="text" name="sMobNo2" id="sMobNo2" maxlength="4" class="input_txt2 hp" value="<?=explode("-",$user[0]->mobile)[1]?>" onchange="fnMobChkReset();"> -
						                            <input type="text" name="sMobNo3" id="sMobNo3" maxlength="4" class="input_txt2 hp" value="<?=explode("-",$user[0]->mobile)[2]?>" onchange="fnMobChkReset();">
						                        </td>
						                        <th>전화번호</th>
						                        <td>
						                        	<input type="text" name="sMobTe1" id="sMobTe1"  class="input_txt2 hp" 
						                        	value="<?=empty(explode("-",$user[0]->telephone)[0]) ? "" : explode("-",$user[0]->telephone)[0]?>" 
						                        	onchange="fnMobChkReset();"> -
						                            <input type="text" name="sMobTe2" id="sMobTe2"  class="input_txt2 hp" 
						                            value="<?=empty(explode("-",$user[0]->telephone)[1]) ? "" : explode("-",$user[0]->telephone)[1]?>" 
						                            onchange="fnMobChkReset();"> -
						                            <input type="text" name="sMobTe3" id="sMobTe3" class="input_txt2 hp" 
						                            value="<?=empty(explode("-",$user[0]->telephone)[2]) ? "" : explode("-",$user[0]->telephone)[2]?>" 
						                            onchange="fnMobChkReset();">

						                        </td>
						                    </tr>

						                    <tr>
						                        <th>이메일</th>
						                        <td colspan="3">
						                            <input type="text" id="email" name="email" maxlength="30" class="input_txt2 email_1" value="<?=$user[0]->email?>">
						                            <a href="javascript:fnRealEmail()" class="btn btn-sm btn-warning btn-round">중복확인</a>
							                        <label id="emailcheckresult" class="mt-4" style="display: block;">중복확인을 하셔야됩니다.</label>
						                        </td>
						                    </tr>

						                    <tr>
						                        <th>이메일 수신</th>
						                        <td>
						                            <label>
						                                <input type="radio" name="sEmailRcvYN" id="sEmailRcvYN" class="input_chk2" 
						                                value="1" <?=$user[0]->emailRecevice==1 ? "checked":""?>> 예</label> &nbsp;
						                            <label>
						                                <input type="radio" name="sEmailRcvYN" id="sEmailRcvYN" class="input_chk2" 
						                                value="0" <?=$user[0]->emailRecevice!=1 ? "checked":""?>> 아니오</label>
						                        </td>
						                        <th>SMS 수신</th>
						                        <td>
						                            <label>
						                                <input type="radio" name="sSmsRcvYN" id="sSmsRcvYN" class="input_chk2" 
						                                value="1" <?=$user[0]->smsRecevice==1 ? "checked":""?>> 예</label> &nbsp;
						                            <label>
						                                <input type="radio" name="sSmsRcvYN" id="sSmsRcvYN" class="input_chk2" 
						                                value="0" <?=$user[0]->smsRecevice!=1 ? "checked":""?>> 아니오</label>
						                        </td>
						                    </tr>
						                </tbody>
						            </table>
						        </div>
						        <div class="btn_wrap style_top_2" style="margin-top: 10px">
						            <ul>
						                <li style="width:55%;float:left;text-align:right;">
						                    <input type="submit" class="btn btn-danger text-white btn-round btn-sm" value="등록"></input>
						                    <a  class="btn btn-jin btn-round btn-sm  text-white" href="<?=base_url()?>">취소</a>
						                </li>
						                <li style="float:right;text-align:right;"><a href="javascript:exitMember()" class="btn btn-jin btn-round btn-sm text-white"><span>탈퇴하기</span></a></li>
						            </ul>
						        </div>
						    </div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<link href="<?php echo site_url('/template/css/user.css'); ?>" rel="stylesheet">

<script>
	var frmObj = "#frmMem";
	function openDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
				if ( data.userSelectedType == "R" ) {
					document.getElementById('zip').value = data.zonecode;
					document.getElementById('addr_1').value = data.roadAddress;
					document.getElementById('details').focus();
					//document.getElementById('ADDR_1_EN').value = data.addressEnglish;
				} else {
					alert("지번주소가 아닌 도로명주소를 선택하십시오.");
				}
            }
        }).open();
    }

    function exitMember(){
    	var exit=confirm("정말 탈퇴하시겠습니까? 복귀시 관리자에게 문의해주세요");
    	if(exit){
    		DoCallbackCommonPost("exitMember","");
    	}
    }
    function fnRealEmail() {
		var sValId = $(frmObj + " input[name='email']").val();
		var url = "/EmailChk?"
			+ "sMemEmail="+ sValId;
		var returnvalue="";

		returnvalue = DoCallbackCommon(url).trim();

		if (returnvalue=="0"){
			document.getElementById("emailcheckresult").innerHTML = "<span class=\"active\">사용할 수 있는 이메일입니다.</span>";
		}else{
			document.getElementById("emailcheckresult").innerHTML = "<span class=\"active\">같은 이메일이 존재합니다.</span>"; 
		}
	} 
</script>