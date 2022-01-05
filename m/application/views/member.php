<?php if(!empty($this->session->userdata("error"))): ?>
<script>
	alert("<?=$this->session->userdata("error")?>");
</script>>
<?php endif; ?>
<?php $data['title']="회원정보" ?>
<?php $this->load->view("my_header",$data); ?>
<?php 
$mobile = explode("-",$user[0]->mobile);
$mobile1 = isset($mobile[0]) ? $mobile[0]:"";
$mobile2 = isset($mobile[1]) ? $mobile[1]:"";
$mobile3 = isset($mobile[2]) ? $mobile[2]:"";

$tele  = explode("-",$user[0]->telephone);
$tele1 = isset($tele[0]) ? $tele[0]:"";
$tele2 = isset($tele[1]) ? $tele[1]:"";
$tele3 = isset($tele[2]) ? $tele[2]:"";
?>
<div class="container">
	<div class="row">
		<div id="subRight">
			<div class="con">
				<div class="row">
					<div class="col-xs-12 p-5 pb-0">
						<form method="post"  id="frmMem" action="/editUser">
							<div class="t_board">
								<div class="row ml-15 mr-15">
									<div class="col-xs-12 border p-0">
										<div class="form-row m-side-0">
											<label for="sMemId" class="w-100 pt-5 pb-5 bg-gray p-left-5 border-b">아이디</label>
											<input type="text" id="sMemId" maxlength="20" class="border-none ml-5 mr-5 bg-white" 
											required onkeyup="fnRealIDChk();" style="width: 200px" aria-required="true" disabled value="<?=$user[0]->loginId?>">
										</div>
										<div class="form-row m-side-0">
											<label for="sMemKrNm" class="w-100 pt-5 pb-5 bg-gray p-left-5 border-t border-b">이름</label>
											<input type="text"  id="sMemKrNm" maxlength="30" class="border-none ml-5 mr-5 bg-white" required style="width: 200px" disabled 
											value="<?=$user[0]->name?>">
										</div>
										<div class="form-row m-side-0">
											<label for="sMemKrNm" class="w-100 pt-5 pb-5 bg-gray p-left-5 border-t border-b">가입일</label>
											<input type="text"  id="sMemKrNm"  class="border-none ml-5 mr-5 bg-white" required style="width: 200px" disabled 
											value="<?=$user[0]->createdDtm?>">
										</div>
										<div class="form-row m-side-0">
											<label for="sMemKrNm" class="w-100 pt-5 pb-5 bg-gray p-left-5 border-t border-b">마지막 접속일</label>
											<input type="text"  id="sMemKrNm"  class="border-none ml-5 mr-5 bg-white" required style="width: 200px" disabled 
											value="<?=$user[0]->log_date?>">
										</div>
										<div class="form-row m-side-0">
											<label for="sNick" class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">닉네임</label>
											<input type="text"  id="sNick" maxlength="20" class="border-none ml-5 bg-white" required style="width: 200px" disabled 
											value="<?=$user[0]->nickname?>">
										</div>
										<div class="form-row m-side-0">
											<label for="birthday" class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">생년월일</label>
											<input readonly class="border-none ml-5 mr-5 bg-white" type="text" id="date-group1-1"  style="width: 200px" 
											value="<?=$user[0]->birthday?>" disabled>
										</div>
										<div class="form-row m-side-0">
											<label for="sMemPw" class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">변경할 비밀번호</label>
											<input type="password" name="password" id="password" maxlength="20" class="form-control ml-5 mr-5" style="width: 200px">
										</div>
										<div class="form-row m-side-0">
											<label for="sMemPw1" class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">비밀번호 확인</label>
											<input type="password" id="cpassword" name="cpassword" maxlength="20" class="form-control ml-5 mr-5" required style="width: 200px" 
											aria-required="true">
										</div>
										<div class="form-row m-side-0">
											<label class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">주소</label>
											<ul class="addrTel">
							                    <li class="vm_box">
							                        <label style="width:55px;" class="ml-5">우편번호</label>
							                        <input type="text" name="ZIP" id="ZIP" maxlength="8" placeholder="우편번호" required="" style="width: 118px;height: 31px;  border: 1px solid #ccc;border-radius: 4px;" aria-required="true" value="<?=$user[0]->postNum?>" readonly>
							                        <a href="javascript:openDaumPostcode();" class="btn btn-warning btn-sm mb-5 btn-round">우편번호 검색</a>
							                    </li>
							                    <li class="vm_box mb-10 clearfix">
							                    	<div class="pull-left">
							                        	<label style="width:55px;" class="mt-10 ml-5">주소</label>
							                        </div>
							                        <div class="pull-left">
							                        	<input type="text" name="addr_1" id="addr_1" maxlength="100" class="form-control" placeholder="주소" required="" style="width: 229px;" aria-required="true" value="<?=$user[0]->address?>" readonly>
							                        </div>
							                    </li>
							                    <li class="vm_box lht_150 clearfix">
							                    	<div>
							                    		<div class="pull-left">
								                        	<label style="width:55px;" class="mt-10 ml-5">상세주소</label>
								                        </div>
								                        <div class="pull-left">
								                        	<input type="text" name="details" id="details" maxlength="100" class="form-control" placeholder="상세주소" 
								                        	style="width: 229px;" value="<?=$user[0]->detail_address?>">
								                    	</div>
							                    	</div>
							                        <div class="clearfix">
							                        	<br>
							                        	* 도로명 주소를 써주세요. 지번 주소 기재 시 통관/세관에서 오류로 분류시켜 통관지연이 될 수 있습니다
							                        </div>
							                    </li>
							                </ul>
										</div>
										<div class="form-row m-side-0">
											<label class="d-block w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">휴대폰</label>
											<div class="row" style="width: 260px">
							            		<div class="col-xs-4 p-3">
							            			<input type="text" name="sMobNo1" id="sMobNo1" maxlength="4" class="form-control" onchange="fnMobChkReset();" required="" aria-required="true" value="<?=$mobile1?>">
							            		</div>
							            		<div class="col-xs-4  p-3">
							            			<input type="text" name="sMobNo2" id="sMobNo2" maxlength="4" class="form-control" onchange="fnMobChkReset();" required="" aria-required="true" value="<?=$mobile2?>">
							            		</div>
							            		<div class="col-xs-4  p-3">
							            			<input type="text" name="sMobNo3" id="sMobNo3" maxlength="4" class="form-control" onchange="fnMobChkReset();" required="" aria-required="true" value="<?=$mobile3?>">
							            		</div>
							            	</div>
										</div>
										<div class="form-row m-side-0">
											<label class="d-block w-100 bg-gray p-left-5  border-t border-b  pt-5 pb-5 ">전화번호</label>
											<div class="row" style="width: 260px">
							            		<div class="col-xs-4 p-3">
							            			<select name="sTelNo1" id="sTelNo1" class="form-control">
														<option value="02" <?=$tele1=="02" ? "selected":""?>>02</option>
														<option value="031" <?=$tele1=="031" ? "selected":""?>>031</option>
														<option value="032" <?=$tele1=="032" ? "selected":""?>>032</option>
														<option value="033" <?=$tele1=="033" ? "selected":""?>>033</option>
														<option value="041" <?=$tele1=="041" ? "selected":""?>>041</option>
														<option value="042" <?=$tele1=="042" ? "selected":""?>>042</option>
														<option value="043" <?=$tele1=="043" ? "selected":""?>>043</option>
														<option value="050" <?=$tele1=="050" ? "selected":""?>>050</option>
														<option value="051" <?=$tele1=="051" ? "selected":""?>>051</option>
														<option value="052" <?=$tele1=="052" ? "selected":""?>>052</option>
														<option value="053" <?=$tele1=="053" ? "selected":""?>>053</option>
														<option value="054" <?=$tele1=="054" ? "selected":""?>>054</option>
														<option value="055" <?=$tele1=="055" ? "selected":""?>>055</option>
														<option value="061" <?=$tele1=="061" ? "selected":""?>>061</option>
														<option value="062" <?=$tele1=="062" ? "selected":""?>>062</option>
														<option value="063" <?=$tele1=="063" ? "selected":""?>>063</option>
														<option value="064" <?=$tele1=="064" ? "selected":""?>>064</option>
														<option value="070" <?=$tele1=="070" ? "selected":""?>>070</option>
													</select>
							            		</div>
							            		<div class="col-xs-4  p-3">
							            			<input type="text" name="sTelNo2" id="sTelNo2" maxlength="4" class="form-control"  value="<?=$tele2?>">
							            		</div>
							            		<div class="col-xs-4  p-3">
							            			<input type="text" name="sTelNo3" id="sTelNo3" maxlength="4" class="form-control"  value="<?=$tele3?>">
							            		</div>
							            	</div>
										</div>
										<div class="form-row m-side-0">
											<label for="email" class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">이메일</label>
											<div class="row p-0">
												<div class="col-xs-9 p-3">
													<input type="email" name="email" class="form-control" placeholder="중복확인을 하셔야됩니다" aria-required="true" 
													value="<?=$user[0]->email?>">
												</div>
												<div class="col-xs-3 p-3">
													<a href="javascript:fnRealEmail()" class="btn btn-sm btn-round btn-warning">중복확인</a>
												</div>
											</div>
											<label id="emailcheckresult" class="w-100 p-left-5">중복확인을 하셔야됩니다.</label>
										</div>
										<div class="form-row m-side-0">
											<label class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">이메일 수신</label>
											<input type="radio" name="sEmailRcvYN" id="sEmailRcvYN" class="input_chk2 ml-15" value="1" <?=$user[0]->emailRecevice==1 ? "checked":""?>>&nbsp;예 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" name="sEmailRcvYN" id="sEmailRcvYN" class="input_chk2" value="0" <?=$user[0]->emailRecevice!=1 ? "checked":""?>>&nbsp;아니오
										</div>
										<div class="form-row m-side-0">
											<label class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">이메일 수신</label>
											<input type="radio" name="sSmsRcvYN" id="sSmsRcvYN" class="input_chk2 ml-15" value="1" <?=$user[0]->smsRecevice==1 ? "checked":""?>>&nbsp;예 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" name="sSmsRcvYN" id="sSmsRcvYN" class="input_chk2" value="0" <?=$user[0]->smsRecevice!=1 ? "checked":""?>>&nbsp;아니오
										</div>
									</div>
								</div>
							</div>
						    <div class="con mt-10">
						        <div class="row">
						        	<div class="col-xs-3"></div>
						        	<div class="col-xs-6 p-left-1 p-right-1 text-center">
						        		<input type="submit" class="btn btn-danger btn-sm btn-round" value="등록"></input>
						        		<a  class="btn btn-warning btn-sm btn-round " href="<?=base_url()?>">취소</a>
						        	</div>
						        	<div class="col-xs-3 p-right-5 p-left-1 text-right">
						        		<a href="javascript:exitMember()" class="btn btn-default btn-sm btn-round">탈퇴하기</a>
						        	</div>
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
<link href="<?php echo site_url('/template/css/my.css'); ?>" rel="stylesheet">
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

    function fnRealEmail() {
		var sValId = $(frmObj + " input[name='email']").val();
		if($.trim(sValId).length <= 0){
			return;
		}
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

    function exitMember(){
    	var exit=confirm("정말 탈퇴하시겠습니까? 복귀시 관리자에게 문의해주세요");
    	if(exit){
    		DoCallbackCommonPost("exitMember","");
    	}
    }
</script>

<style type="text/css">
	.padgeName{
		border:none;
	}
</style>