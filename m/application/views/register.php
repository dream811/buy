<?php $data['title'] = "회원가입"; ?>
<div class="container">
	<?php $this->load->view("nologin.php",$data); ?>
	<div id="subRight" class="pt-10">
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
					<p class="agree_tit">이용약관</p>
					<div class="agree_box">
						<div class="p-5 border" style="height: 230px;overflow-y: scroll;">
							<?php if(!empty($p) && $p[0]->use==1): ?>
								<?=$p[0]->link?>
							<?php endif; ?>
						</div>
					</div>
					<p class="agree_radio p-left-10">
						<label for="agree_1"><input type="checkbox" class="input_chk" id="agree_1" name="agree_1">&nbsp;동의함</label> 
					</p>
					<p class="agree_tit">개인정보 수집, 제공 및 활용 동의</p>
					<div class="agree_box">
						<div class="p-5 border" style="height: 230px;overflow-y: scroll;">
							<?php if(!empty($p1) && $p1[0]->use==1): ?>
								<?=$p1[0]->link?>
							<?php endif; ?>
						</div>	
					</div>
					<p class="agree_radio p-left-10">
						<label for="agree_2"><input type="checkbox" class="input_chk" id="agree_2" name="agree_2">&nbsp;동의함</label> 
					</p>
					<p class="btn_wrap style_top_2 pb-10 p-left-10 mt-10">
						<a onclick="fnPageStep();" class="btn_write btn-round btn-danger btn">약관동의</a>
						<a href="/login" class="btn_list btn btn-round btn-default">취소</a>
					</p>
				</div>
				<div class="register_form">
					<form method="post" name="frmMem" id="frmMem" action="/doRegister">
						<input type="hidden" name="sAuthSeq" id="sAuthSeq" value="0">
						<div class="t_board"> 
							<div class="row ml-15 mr-5">
								<div class="col-xs-12 border p-0">
									<div class="form-row m-side-0">
										<label for="sMemId" class="w-100 pt-5 pb-5 bg-gray p-left-5 border-b">아이디</label>
										<input type="text" name="sMemId" id="sMemId" maxlength="20" class="form-control ml-5 mr-5" placeholder="중복확인을 하셔야됩니다." required onkeyup="fnRealIDChk();" 
										style="width: 200px">
						                <label id="idcheckresult" class="ml-5">중복확인을 하셔야됩니다.</label>
										<input type="hidden" name="IDCheck" id="IDCheck">
									</div>
									<div class="form-row m-side-0">
										<label for="sMemKrNm" class="w-100 pt-5 pb-5 bg-gray p-left-5 border-t border-b">이름</label>
										<input type="text" name="sMemKrNm" id="sMemKrNm" maxlength="30" class="form-control ml-5 mr-5" required style="width: 200px">
									</div>
									<div class="form-row m-side-0">
										<label for="sNick" class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">닉네임</label>
										<input type="text" name="sNick" id="sNick" maxlength="20" class="form-control ml-5"  required style="width: 200px">
									</div>
									<div class="form-row m-side-0">
										<label for="birthday" class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">생년월일</label>
										<input readonly class="form-control ml-5 mr-5" type="text" id="date-group1-1" placeholder="YY-MM-DD" name="birthday" style="width: 200px"></td>
									</div>
									<div class="form-row m-side-0">
										<label for="sMemPw" class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">비밀번호</label>
										<input type="password" name="sMemPw" id="sMemPw" maxlength="20" class="form-control ml-5 mr-5" style="width: 200px">
									</div>
									<div class="form-row m-side-0">
										<label for="sMemPw1" class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">비밀번호 확인</label>
										<input type="password" name="sMemPw1" id="sMemPw1" maxlength="20" class="form-control ml-5 mr-5"  required style="width: 200px">
									</div>
									<div class="form-row m-side-0">
										<label class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">주소</label>
										<ul class="addrTel">
						                    <li class="vm_box">
						                        <label style="width:55px;" class="ml-5">우편번호</label>
						                        <input type="text" name="ZIP" id="ZIP" maxlength="8"  placeholder="우편번호" required 
						                        style="width: 118px;height: 31px;  border: 1px solid #ccc;border-radius: 4px;" >
						                        <a href="javascript:openDaumPostcode();" class="btn btn-warning btn-sm mb-5 btn-round">우편번호 검색</a>
						                    </li>
						                    <li class="vm_box mb-10 clearfix">
						                    	<div class="pull-left">
						                        	<label style="width:55px;" class="mt-10 ml-5">주소</label>
						                        </div>
						                        <div class="pull-left">
						                        	<input type="text" name="ADDR_1" id="ADDR_1" maxlength="100" class="form-control" placeholder="주소" required style="width: 229px;" readonly>
						                        </div>
						                    </li>
						                    <li class="vm_box lht_150 clearfix">
						                    	<div>
						                    		<div class="pull-left">
							                        	<label style="width:55px;" class="mt-10 ml-5">상세주소</label>
							                        </div>
							                        <div class="pull-left">
							                        	<input type="text" name="ADDR_2" id="ADDR_2" maxlength="100" class="form-control" placeholder="상세주소" style="width: 229px;">
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
						            			<input type="text" name="sMobNo1" id="sMobNo1" maxlength="4" class="form-control"  
						            			onchange="fnMobChkReset();" required>
						            		</div>
						            		<div class="col-xs-4  p-3">
						            			<input type="text" name="sMobNo2" id="sMobNo2" maxlength="4" class="form-control"  
						            			onchange="fnMobChkReset();" required>
						            		</div>
						            		<div class="col-xs-4  p-3">
						            			<input type="text" name="sMobNo3" id="sMobNo3" maxlength="4" class="form-control"  
						            			onchange="fnMobChkReset();" required>
						            		</div>
						            	</div>
									</div>
									<div class="form-row m-side-0">
										<label class="d-block w-100 bg-gray p-left-5  border-t border-b  pt-5 pb-5 ">전화번호</label>
										<div class="row" style="width: 260px">
						            		<div class="col-xs-4 p-3">
						            			<select name="sTelNo1" id="sTelNo1" class="form-control">
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
						            		</div>
						            		<div class="col-xs-4  p-3">
						            			<input type="text" name="sTelNo2" id="sTelNo2" maxlength="4" class="form-control" onkeypress="fnChkNumeric();" >
						            		</div>
						            		<div class="col-xs-4  p-3">
						            			<input type="text" name="sTelNo3" id="sTelNo3" maxlength="4" class="form-control" onkeypress="fnChkNumeric();" >
						            		</div>
						            	</div>
									</div>
									<div class="form-row m-side-0">
										<label for="email" class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">이메일</label>
										<div class="row p-0">
											<div class="col-xs-9 p-3">
												<input type="email" name="email"  required class="form-control" placeholder="중복확인을 하셔야됩니다">
											</div>
											<div class="col-xs-3 p-3">
												<a href="javascript:fnRealEmail()" class="btn btn-sm btn-round btn-warning">중복확인</a>
											</div>
										</div>
										<label id="emailcheckresult" class="w-100 p-left-5">중복확인을 하셔야됩니다.</label>
									</div>
									<div class="form-row m-side-0">
										<label class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">이메일 수신</label>
										<input type="radio" name="sEmailRcvYN" id="sEmailRcvYN" class="input_chk2 ml-15" value="Y" checked>&nbsp;예 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="radio" name="sEmailRcvYN" id="sEmailRcvYN" class="input_chk2" value="N">&nbsp;아니오
									</div>
									<div class="form-row m-side-0">
										<label class="w-100 pt-5 pb-5 bg-gray p-left-5  border-t border-b">SMS 수신</label>
										<input type="radio" name="sSmsRcvYN" id="sSmsRcvYN" class="input_chk2 ml-15" value="Y" checked>&nbsp;예&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="radio" name="sSmsRcvYN" id="sSmsRcvYN" class="input_chk2" value="N">&nbsp;아니오
									</div>
								</div>
							</div>
							<div class="row mt-10 pb-10">
								<div class="col-xs-12 text-center">
									<input type="submit" class="btn btn-round btn-sm btn-danger" value="등록">
									<a href="/login" class="btn btn-default btn-round btn-sm">취소</a>
								</div>
							</div>
						</div>
					</form>	
				</div>
			<?php endif; ?>
			<?php if(isset($success_register) && $success_register ==1): ?>
				<div class="text-center pb-10">
				 	<p class="delivery-info">
				        타오달인 회원가입이 완료되었습니다.                    
				    </p>
				    <img src="<?=base_url_home()?>assets/images/welcome.png" style="display: block;margin:auto;">
				    <p class="welcome-mid">회원가입을 진심으로 환영합니다.</p>
					<a href="/login" class="btn btn-green btn-round text-white login_btn" style="border-radius: 20px"><span>로그인하기</span></a>
				 </div>
			<?php endif; ?>	
		</div>
	</div>

</div>
<link href="<?php echo site_url('/template/css/user.css'); ?>" rel="stylesheet">
<link href="<?php echo site_url('/template/css/my.css'); ?>" rel="stylesheet">
<script src="<?php echo site_url('/assets/js/jquery.validate.js') ?>"></script>
<script>
	var frmObj = "#frmMem";
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
	}
	function mailChange() { 
		document.getElementById("sEmail2").value = document.getElementById("sSelMail").value; 
	}
	$('.form_date').datetimepicker({
        language:  'kr',
        weekStart: 1,
		autoclose: 1,
		startView: 2,
		forceParse: 0
    });
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
	new Rolldate({
		el: '#date-group1-1',
		format: 'YYYY-MM-DD',
		beginYear: 1970,
		endYear: <?=date("Y")?>,
		lang: lang_date
	});
	$().ready(function() {
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
			    	form.submit();
			}
		})
	});
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
</script>
<style type="text/css">
	select {
    clear: both;
    height: 23px;
    border: 1px solid #d0d2d7;
    padding: 0px 3px;
}
</style>