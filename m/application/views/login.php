<? $site = getSiteName(); ?>
<? $data['title'] = "로그인"; ?>
<div class="container">
	<div class="row">
		<?php $this->load->view("nologin.php",$data); ?>	
		<div id="subRight">
		<form action="/doLogin" method="post">
			<input type="hidden" name="redirect" value="<?=$this->input->get("redirect")?>" id="redirect">
			<div class="row">
				<div class="col-md-12 p-left-5 p-right-5">
					<?php	
					$error = $this->session->flashdata('error');
				    if($error)
				    {
				        ?>
				        <script type="text/javascript">
				           	alert("<?php echo $this->session->flashdata('error'); ?>");
				        </script> 
				    <?php } ?>
					<div class="loginBox mb-5">
						<p class="text-center" style="font-size: 16px;">로그인하세요</p>
						<div class="form-group">
							<input type="text" name="sMemId" id="sMemId" value="" maxlength="20" title="아이디" class="form-control form-control-lg" placeholder="아이디" required>
						</div>
						<div class="form-group">
							<input type="password" name="sMemPw" id="sMemPw" value="" maxlength="20"  class="form-control form-control-lg" placeholder="비밀번호" required>
						</div>
						<div class="form-group mb-0">
							<input type="checkbox" class="inp_chk form-check-input">
                            <label class="labelChk">아이디 저장</label>
						</div>
						<input type="submit" class="btn btn-green text-white btn-lg btn-block" value="로그인">
						<div class="row">
							<div class="col-xs-6 p-0 pt-3 p-right-3">
								<a class="btn btn-default w-100" data-toggle="modal" data-target="#findpass">아이디/비밀번호 찾기</a>
							</div>
							<div class="col-xs-6 p-0 pt-3">
								<a href="/register" class="btn btn-default w-100">회원가입</a>
							</div>
						</div>
						<!-- <div class="text-right">
							<a  class="p-5 text-white" data-toggle="modal" data-target="#findpass" style="font-size: 15px">아이디/비밀번호 찾기</a>
							<a href="/register" class="p-5 text-white" style="font-size: 15px">회원가입</a>
						</div> -->
					</div>
				</div>
			</div>
		</form>
	</div>
<link href="<?php echo site_url('/template/css/user.css'); ?>" rel="stylesheet">
<script>
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

			var val = "sMemId=" + document.getElementById("sMemId").value
			+ "&sMemPw=" + escape(document.getElementById("sMemPw").value);
			//+ "&rememberID=" + rememberID;
 
            DoCallbackCommonPost("/Front/Join/Login_Ajax.asp", val);
			return false;
		}
	}
</script>

<script>
	$(document).ready(function(){
		<?php if(!empty( $this->session->userdata ( 'actual_link' ))): ?>
			var encode = ConvertStringToHex("<?= $this->session->userdata ( 'actual_link' )?>");
			$("#redirect").val(encode);
		<?php endif; ?>	
	})
</script>