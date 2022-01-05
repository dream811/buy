<div class="container">
	<div class="row">
		<div id="subLeft" class="col-md-3">
			<div class="LeftTitle">
				마이페이지.
			</div>
			<ul class="leftMenu">
				<li ><a href="/register">회원가입</a></li>
				<li class="on"><a href="/login">로그인</a></li>
				<li ><a href="/usetext">이용약관</a></li>
				<li ><a href="/policy">개인정보취급방침</a></li>
			</ul>
		</div>
		<div id="subRight" class="col-md-9" style="min-height: 600px;margin-top: 5px">
		<?php	
		$error = $this->session->flashdata('error');
	    if($error)
	    {
	        ?>
	        <script type="text/javascript">
	           	alert("<?php echo $this->session->flashdata('error'); ?>");
	        </script> 
	    <?php } ?>
			<form action="/doLogin" method="post">
				<input type="hidden" name="redirect" value="<?=$this->input->get("redirect")?>" id="redirect">
				<div class="padgeName">
					<h1>로그인</h1>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="loginBox">
							<p style="font-family: s-core-dream-regula;font-size: 16px;">Login</p>
							<div class="form-group" style="margin-bottom: 30px;">
								<input type="text" name="sMemId" id="sMemId" value="" maxlength="20" title="아이디" class="form-control form-control-lg" placeholder="아이디" required>
							</div>
							<div class="form-group" style="margin-bottom: 30px;">
								<input type="password" name="sMemPw" id="sMemPw" value="" maxlength="20"  class="form-control form-control-lg" placeholder="비밀번호" required>
							</div>
							<div class="form-group">
								<input type="checkbox" class="inp_chk form-check-input">
	                            <label class="labelChk">아이디 저장</label>
							</div>
							<input type="submit" class="btn btn-yonpu text-white btn-lg btn-block" value="로그인" style="background-color: #2083a5">
							<div class="col-xs-6 p-0 pt-3 p-right-3">
								<a class="btn btn-default w-100" data-toggle="modal" data-target="#findpass">아이디/비밀번호 찾기</a>
							</div>
							<div class="col-xs-6 p-0 pt-3">
								<a href="/register" class="btn btn-default w-100">회원가입</a>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="findpass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">아이디/비밀번호 찾기</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        	<p class="font-weight-bold">아이디 찾기</p>
        	<hr>
          	<div class="form-group row">
	            <div class="col-md-2">
	            	<label for="recipient-name" class="col-form-label">이름:</label>
	            </div>
	            <div class="col-md-10">
	            	<input type="text" class="form-control" id="recipient-name" name="recipient-name">
	            </div>
          	</div>
          	<div class="form-group row">
	            <div class="col-md-2">
	            	<label for="recipient-email" class="col-form-label">메일:</label>
	            </div>
	            <div class="col-md-10">
	            	<input type="email" class="form-control" id="recipient-email" name="recipient-email">
	            </div>
          	</div>
	        <div class="row form-group">
	          	<div class="col-md-12 text-right">
	          		<a href="javascript:void(0)" class="btn btn-danger btn-round" onclick="find(1,this)" 
	          		data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중" style="padding-left: 24px; padding-right: 24px">찾기</a>
	          	</div>
	        </div>
	        <p class="font-weight-bold">비밀번호 찾기</p>
	        <hr>
	        <div class="form-group row">
	            <div class="col-md-2">
	            	<label for="name" class="col-form-label">이름:</label>
	            </div>
	            <div class="col-md-10">
	            	<input type="text" class="form-control" id="name" name="name">
	            </div>
          	</div>
          	<div class="form-group row">
	            <div class="col-md-2">
	            	<label for="loginId" class="col-form-label">아이디:</label>
	            </div>
	            <div class="col-md-10">
	            	<input type="text" class="form-control" id="loginId" name="loginId">
	            </div>
          	</div>
          	<div class="form-group row">
	            <div class="col-md-2">
	            	<label for="email" class="col-form-label">메일:</label>
	            </div>
	            <div class="col-md-10">
	            	<input type="email" class="form-control" id="email" name="email">
	            </div>
          	</div>
          	<div class="row form-group">
	          	<div class="col-md-12 text-right">
	          		<a href="javascript:void(0)" class=" btn btn-danger btn-round" onclick="find(2,this)" 
	          		data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중" style="padding-left: 24px; padding-right: 24px">찾기</a>
	          	</div>
	        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-round" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>
<link href="<?php echo site_url('/template/css/user.css'); ?>?<?=time()?>" rel="stylesheet">
<script>
	var message = "입력하신 정보가 정확한 정보가 아닙니다.";
	function fnLoginM() {

		if (document.getElementById("sMemId").value == '') {
			alert('아이디를 입력해 주세요');
			document.getElementById("sMemId").focus();
			return false;
		} else if (document.getElementById("sMemPw").value == '') {
			alert('암호를 입력해 주세요');
			document.getElementById("sMemPw").focus();
			return false;
		} else {

			/*
			var rememberID = "N";
			
            if (document.getElementById("rememberID").checked) {
                rememberID = "Y";
            }*/

			var val = "sMemId=" + document.getElementById("sMemId").value
			+ "&sMemPw=" + escape(document.getElementById("sMemPw").value);
			//+ "&rememberID=" + rememberID;
 
            DoCallbackCommonPost("/Front/Join/Login_Ajax.asp", val);
			return false;
		}
	}


	function find(id,obj){
		var ids = [];
		var $this = $(obj);
		var data = {};
		if(id ==1)
		{
			ids["recipient-name"] = "이름을 입력하세요.";
			ids["recipient-email"] = "메일을 입력하세요.";
		}
		else{
			ids["name"] = "이름을 입력하세요.";
			ids["loginId"] = "아이디를 입력하세요.";
			ids["email"] = "메일을 입력하세요.";
		}

		for (var key in ids) {
	  		if (document.getElementById(key).value == '') {
				alert(ids[key]);
				document.getElementById(key).focus();
				return false;
			}
			if((key =="email" || key=="recipient-email") && !validateEmail(document.getElementById(key).value)){
				alert("이메일 형식이 정확치 않습니다.");
				return false;
			}
			data[key] = document.getElementById(key).value;
		}
		data["type"] = id;
		$.ajax({
			url: baseURL + "checkForget",
		    data: data,
		   	dataType:"json",
		   	type:'POST',
		    beforeSend: function() {
		      	$this.button('loading');
		    },
		    success: function (data) {
		    	$this.button('reset');
		    	if(data.status ==1){
		    		alert(data.message);
		    	}
		    	else
		    		alert(message);
		    	
		    },
		    error: function(XMLHttpRequest, textStatus, errorThrown) { 
		    	alert("서버오류");
                $this.button('reset');
		    }
		});
		
	}

	function validateEmail(email) {
	    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(String(email).toLowerCase());
	}

	$(document).ready(function(){
		<?php if(!empty( $this->session->userdata ( 'actual_link' ))): ?>
			var encode = ConvertStringToHex("<?= $this->session->userdata ( 'actual_link' )?>");
			$("#redirect").val(encode);
		<?php endif; ?>	
	})
</script>