<div class="container">
	<div class="row">
		<div id="subLeft" class="col-md-3">
			<div class="LeftTitle">
				마이페이지
			</div>
			<ul class="leftMenu">
				<li class="on"><a href="/register">회원가입</a></li>
				<li ><a href="/login">로그인</a></li>
				<li ><a href="/findpass">아이디/비밀번호 찾기</a></li>
				<li ><a href="/usetext">이용약관</a></li>
				<li ><a href="/policy">개인정보취급방침</a></li>
			</ul>
		</div>
		<div id="subRight" class="col-md-9">
			<div class="padgeName">
				<h2>회원가입</h2>
			</div>
			<div class="con">
				<div class="row">
					<div class="col-md-4">

				    <?php
				    $this->load->helper('form');
				    $error = $this->session->flashdata('error');
				    if($error)
				    {
				        ?>
				        <script type="text/javascript">
				           	alert("<?php echo $this->session->flashdata('error'); ?>");
				        </script> 
				    <?php } ?>
				        <?php  
				            $success = $this->session->flashdata('success');
				            if($success)
				            {
				        ?>
				        <div class="alert alert-success alert-dismissable">
				            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				            <?php echo $this->session->flashdata('success'); ?>
				        </div>
				        <?php } ?>
				        
				        <div class="row">
				            <div class="col-md-12">
				                <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
				            </div>
				        </div>
				    </div>
				</div>
				<?php if(!isset($success_register)): ?>
					<div class="agree_part">
						<p class="step_txt">회원가입은 무료로 별도의 가입비 없이 회원가입을 하실 수 있습니다.<br>이용약관에 동의하셔야 가입이 가능니다. 고객님의 정보는 절대 다른 용도로 이용되지 않습니다.</p>
						<p class="agree_tit">이용약관</p>
						<div class="agree_box">
							<?php if(!empty($p) && $p[0]->use==1): ?>
								<?=$p[0]->link?>
							<?php endif; ?>
						</div>
						<p class="agree_radio">
							<label for="agree_1"><input type="checkbox" class="input_chk" id="agree_1" name="agree_1">&nbsp;동의함</label> 
						</p>
						<p class="agree_tit">개인정보 수집, 제공 및 활용 동의</p>
						<div class="agree_box">
							<?php if(!empty($p1) && $p1[0]->use==1): ?>
								<?=$p1[0]->link?>
							<?php endif; ?>
						</div>
						<p class="agree_radio">
							<label for="agree_2"><input type="checkbox" class="input_chk" id="agree_2" name="agree_2">&nbsp;동의함</label> 
						</p>
						<p class="btn_wrap style_top_2">
							<a onclick="fnPageStep();" class="btn_write btn-danger btn btn-sm btn-round">약관동의</a>
							<a href="/login" class="btn_list btn btn-default btn-sm btn-round">취소</a>
						</p>
					</div>
					<div class="register_form">
						<form method="post" name="frmMem" id="frmMem" action="/doRegister">
							<input type="hidden" name="sAuthSeq" id="sAuthSeq" value="0">
							<div class="t_board"> 
								<div>
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
							                            <input type="text" name="sMemId" id="sMemId" maxlength="20" class="input_txt2"  placeholder="중복확인을 하셔야됩니다."
							                             required onkeyup="initCheck()" style="width: 39%">
							                            <a href="javascript:fnRealIDChk()" class="btn btn-sm btn-warning btn-round">중복확인</a>
														<label id="idcheckresult" class="mt-4" style="display: block;">중복확인을 하셔야됩니다.</label>
														<input type="hidden" name="IDCheck" id="IDCheck" value="">
							                        </td>
							                    </tr>
							                    <tr>
							                        <th>닉네임</th>
							                        <td>
							                           <input type="text" name="sNick" id="sNick" maxlength="20" class="form-control" value="" required>

							                        </td>
							                        <th>생년월일</th>
							                        <td><input class="form-control" size="16" type="date" name="birthday"></td>
							                    </tr>

							                    <tr>
							                        <th>이름</th>
							                        <td colspan="3">
							                            <input type="text" name="sMemKrNm" id="sMemKrNm" maxlength="30" class="form-control" value="" required>
							                        </td>
							                    </tr>

							                    <tr>
							                        <th>비밀번호</th>
							                        <td>
							                            <input type="password" name="sMemPw" id="sMemPw" maxlength="20" class="form-control">
							                        </td>
							                        <th>비밀번호 확인</th>
							                        <td>
							                           <input type="password" name="sMemPw1" id="sMemPw1" maxlength="20" class="form-control" >
							                        </td>
							                    </tr>
							                    <tr>
							                        <th>주소</th>
							                        <td colspan="3">
							                            <ul class="addrTel">
							                                <li class="vm_box">
							                                    <label >우편번호</label>
							                                    <input type="text" name="ZIP" id="ZIP" maxlength="8" class="input_txt2"   placeholder="우편번호" required>
																<a href="javascript:openDaumPostcode();" class="btn btn-warning btn-sm btn-round">우편번호 검색</a>
							                                </li>
							                                <li class="vm_box">
							                                    <label >주소</label>
							                                    <input type="text" name="ADDR_1" id="ADDR_1" maxlength="100" class="input_txt2 adr form-control"  placeholder="주소" required readonly>
							                                </li>
							                                <li class="vm_box lht_150">
							                                    <label>상세주소</label>
							                                    <input type="text" name="ADDR_2" id="ADDR_2" maxlength="100" class="input_txt2 adr form-control"  placeholder="상세주소">
																도로명 주소를 써주세요. 지번 주소 기재 시 통관/세관에서 오류로 분류시켜 통관지연이 될 수 있습니다
							                                </li>
							                            </ul>
							                        </td>
							                    </tr>
							                    <tr>
							                        <th>휴대폰</th>
							                        <td>
							                           <input type="text" name="sMobNo1" id="sMobNo1" maxlength="4" class="input_txt2 hp" 
							                           onchange="fnMobChkReset();" required onkeypress="fnChkNumeric();">-
														<input type="text" name="sMobNo2" id="sMobNo2" maxlength="4" class="input_txt2 hp" 
														onchange="fnMobChkReset();" required onkeypress="fnChkNumeric();">-
														<input type="text" name="sMobNo3" id="sMobNo3" maxlength="4" class="input_txt2 hp" 
														onchange="fnMobChkReset();" required onkeypress="fnChkNumeric();">
							                        </td>
							                        <th>전화번호</th>
							                        <td>
							                            <select name="sTelNo1" id="sTelNo1" class="vm">
															<option value="02">02</option>
															<option value="031">031</option>
															<option value="032">032</option>
															<option value="033">033</option>
															<option value="041">041</option>
															<option value="042">042</option>
															<option value="043">043</option>
															<option value="050">050</option>
															<option value="051">051</option>
															<option value="052">052</option>
															<option value="053">053</option>
															<option value="054">054</option>
															<option value="055">055</option>
															<option value="061">061</option>
															<option value="062">062</option>
															<option value="063">063</option>
															<option value="064">064</option>
															<option value="070">070</option>
														</select>
														-
														<input type="text" name="sTelNo2" id="sTelNo2" maxlength="4" class="input_txt2 hp" onkeypress="fnChkNumeric();" value="">
														-
														<input type="text" name="sTelNo3" id="sTelNo3" maxlength="4" class="input_txt2 hp" onkeypress="fnChkNumeric();" value="">
							                        </td>
							                    </tr>

							                    <tr>
							                        <th>이메일</th>
							                        <td colspan="3">
							                           <input type="email" name="email"  required class="input_txt2" id="email" style="width: 39%">
							                           <a href="javascript:fnRealEmail()" class="btn btn-sm btn-warning btn-round">중복확인</a>
							                           <label id="emailcheckresult" class="mt-4" style="display: block;">중복확인을 하셔야됩니다.</label>
							                        </td>
							                    </tr>

							                    <tr>
							                        <th>이메일 수신</th>
							                        <td>
							                           <label><input type="radio" name="sEmailRcvYN" id="sEmailRcvYN" class="input_chk2" value="Y" checked> 예</label>&nbsp;&nbsp;
														<label><input type="radio" name="sEmailRcvYN" id="sEmailRcvYN" class="input_chk2" value="N"> 아니오</label>
							                        </td>
							                        <th>SMS 수신</th>
							                        <td>
							                           	<label><input type="radio" name="sSmsRcvYN" id="sSmsRcvYN" class="input_chk2" value="Y" checked=""> 예</label>&nbsp;&nbsp;
														<label><input type="radio" name="sSmsRcvYN" id="sSmsRcvYN" class="input_chk2" value="N"> 아니오</label>
							                        </td>
							                    </tr>
							                </tbody>
							            </table>
							        </div>
								</div>
								<div class="row my-4">
									<div class="col-xs-12 text-center">
										<input type="submit" class="btn btn-danger btn-sm btn-round" value="등록">
										<a href="/login" class="btn btn-default btn-sm btn-round">취소</a>
									</div>
								</div>
							</div>
						</form>	
					</div>
				<?php endif; ?>
				<?php if(isset($success_register) && $success_register==1): ?>
				<div class="text-center">
				 	<p class="delivery-info">
				        타오달인 회원가입이 완료되었습니다.                    
				    </p>
				    <img src="/assets/images/welcome.png" style="display: block;margin:auto;">
				    <p class="welcome-mid">회원가입을 진심으로 환영합니다.</p>
					<a href="/login" class="btn btn-zin-blue text-white login_btn"><span>로그인하기</span></a>
				 </div>
				<?php endif; ?>		
			</div>
		</div>
	</div>
</div>

<script src="<?php echo site_url('/assets/js/jquery.validate.js') ?>"></script>
<link href="<?php echo site_url('/template/css/user.css'); ?>?<?=time()?>" rel="stylesheet">
<script>
	var frmObj = "#frmMem";
	function initCheck(){
		$(frmObj + " input[name='IDCheck']").val("0"); 
	}

	function fnPageStep(){
		var frmObj  = "#frmPageInfo";  
		if ($("#agree_1").is(":checked")!=true){ 
			fnMsgFcs($("#agree_1"), '이용약관에 동의를 하셔야됩니다.');
			return;
		}
		if ($("#agree_2").is(":checked")!=true){ 
			fnMsgFcs($("#agree_2"), '개인정보 수집, 제공 및 활용 동의를 하셔야됩니다.');
			return;
		}
		$(".agree_part").hide();
		$(".register_form").show();
		$(".step img").attr('src',baseURL+'template/images/step_2.gif');
	}
	function mailChange() { 
		document.getElementById("sEmail2").value = document.getElementById("sSelMail").value; 
	}

    function fnMobChkReset() {
		$(frmObj + " input[name='sAuthSeq']").val(0);
		$("#MobAuthNm").text("인증");
	}
	function openDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
				if ( data.userSelectedType == "R" ) {
					document.getElementById('ZIP').value = data.zonecode;
					document.getElementById('ADDR_1').value = data.roadAddress;
					document.getElementById('ADDR_2').focus();
					//document.getElementById('ADDR_1_EN').value = data.addressEnglish;
				} else {
					alert("지번주소가 아닌 도로명주소를 선택하십시오.");
				}
            }
        }).open();
    }
    function fnRealIDChk() {
		var sValId = $(frmObj + " input[name='sMemId']").val();
		var url = "/IdChk?"
			+ "sMemId="+ sValId;
		var returnvalue="";
		if($.trim(sValId).length < 5 || $.trim(sValId).length > 20){
			$(frmObj + " input[name='IDCheck']").val("0"); 
			document.getElementById("idcheckresult").innerHTML = "<span class=\"active\">5~20자의 영문 소문자와 숫자만 입력하세요.</span>"; 
		}else{ 
			var IDReg = /^[A-z]+[A-z0-9]{4,19}$/g;
			if (!IDReg.test($.trim(sValId))){
				$(frmObj + " input[name='IDCheck']").val("0"); 
				document.getElementById("idcheckresult").innerHTML = "<span class=\"active\">사용할 수 없는 아이디 입니다.</span>";
			}else{
				returnvalue = DoCallbackCommon(url).trim();

				if (returnvalue=="0"){
					$(frmObj + " input[name='IDCheck']").val("1");
					document.getElementById("idcheckresult").innerHTML = "<span class=\"active\">사용할 수 있는 아이디 입니다.</span>";
				}else{
					$(frmObj + " input[name='IDCheck']").val("0");
					document.getElementById("idcheckresult").innerHTML = "<span class=\"active\">사용할 수 없는 아이디 입니다.</span>"; 
				}
			}
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

	$(document).ready(function() {
		$(frmObj).validate({
			rules:{
				sMemPw: {
					required: true,
				},
				sMemPw1: {
					required: true,
					equalTo: "#sMemPw"
				},
				ZIP: {
					required: true
				},
				ADDR_1: {
					required: true,
				},
			},
			messages: {
				sMobNo1 :  "이 필드는 반드시 입력해야 합니다.",
				sMobNo2 :  "이 필드는 반드시 입력해야 합니다.",
				sMobNo3 :  "이 필드는 반드시 입력해야 합니다.",
				sMemId: "이 필드는 반드시 입력해야 합니다.",
				sNick: "이 필드는 반드시 입력해야 합니다.",
				sMemKrNm: "이 필드는 반드시 입력해야 합니다.",
				ZIP: "이 필드는 반드시 입력해야 합니다.",
				ADDR_1: "이 필드는 반드시 입력해야 합니다.",
				sMemPw: {
					required: "이 필드는 반드시 입력해야 합니다.",
				},
				sMemPw1: {
					required: "이 필드는 반드시 입력해야 합니다.",
					equalTo: "비밀번호 확인이 일치하지 않습니다."
				},
				email: "메일 형식이 올바르지 않습니다.",
			},
			submitHandler: function(form) {
			    if($("#ADDR_1").val().trim() == ""){
			    	$("#ADDR_1").focus();
			    	return;
			    }
			    else
			    {
			    	form.submit();
			    }
			}
		})
});
</script>
<style type="text/css">
	select {
    clear: both;
    height: 23px;
    border: 1px solid #d0d2d7;
    padding: 0px 3px;
}
</style>