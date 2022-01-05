<div class="container">
	<div class="row">
		<?php $this->load->view("left_menu",array("left"=>"my")); ?>
		<div id="subRight" class="col-md-9">
			<div class="padgeName">
				<h2>예치금/포인트</h2>
			</div>
			<form name="frmPageInfo" id="frmPageInfo" method="post" action="/returntDeposit">
				<input type="hidden" name="sKind" id="sKind" value="">
				<input type="hidden" name="bankId" id="bankId" value="1">
				<div class="con">
					<div class="s_tit_box2">
						<h4 class="s_tit">
							나의 예치금: <span class="bold clrRed1"><?=number_format($user[0]->deposit)?></span> 원 &nbsp;&nbsp;&nbsp;
							나의 포인트: <span class="bold clrRed1"><?=number_format($user[0]->point)?></span>P</h4>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered deposit_table">
						<thead class="thead-jin">
					      <tr>
					        <th scope="col">환급할 금액(원)</th>
					        <th scope="col">예금주</th>
					        <th scope="col">은행명</th>
					        <th scope="col">계좌번호</th>
					      </tr>
					    </thead>
					    <tbody>
					    	<tr>
					    		<td><input type="number" name="MNY" id="MNY" class="form-control"></td>
					    		<td><input type="text" name="OWNER" id="OWNER" class="form-control" value="<?=$this->session->userdata("fname")?>" required></td>
					    		<td><input type="text" name="PYN_NM" id="PYN_NM" class="form-control"  required></td>
					    		<td><input type="text" name="PYN_NUMBER" id="PYN_NUMBER" class="form-control" required=""></td>
					    	</tr>
					    </tbody>
					</table>
				</div>
				<div class="btn_wrap row">
					<div class="col-md-12 text-right">
						<a href="javascript:returnDe();" class="btn btn-warning btn-sm btn-round">환급하기</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8  p-left-0">
						<a href="/deposit" class="btn btn-charo text-white my-3">예치금 적립</a>
						<a href="/deposit_return" class="btn btn-yonpu text-white my-3">예치금 환급</a>
						<a href="/deposit_history" class="btn btn-charo text-white my-3">예치금 이용내역</a>
						<a href="/point_history" class="btn btn-charo text-white my-3">포인트 이용내역</a>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered request_deposit_table">
						<thead class="thead-jin">	
					      <tr>
					        <th scope="col">신청일</th>
					        <th scope="col">환급일</th>
					        <th scope="col">환급할 금액(원)</th>
					        <th scope="col">예금주</th>
					        <th scope="col">환급할 계좌</th>
					        <th>관리자 승인</th>
					        <th></th>
					      </tr>
					    </thead>
					    <tbody>
					  		<?php if(!empty($deposits_return)): ?>
					  			<?php foreach($deposits_return as $value): ?>
					  				<tr>
					  					<td class="mid"><?=$value->created_date?></td>
					  					<td class="mid"><?=$value->accept==1 ? date("Y-m-d",strtotime($value->updated_date)):""?></td>
					  					<td class="mid"><?=number_format($value->amount)?></td>
					  					<td class="mid"><?=$value->owner?></td>
					  					<td class="mid"><?=$value->bank_name?> <?=$value->bank_number?></td>
					  					<td class="mid"><?php 	if($value->accept == 0 ) echo '미정';
					  								if($value->accept == 1 ) echo '승인';
					  								if($value->accept == 2 ) echo '거절'; ?></td>
					  					<td class="mid">
					  						<a href="#" class="btn btn-danger btn-sm refuseDeposit btn-round" data-id="<?=$value->id?>">삭제</a>
					  					</td>
					  				</tr>
					  			<?php endforeach; ?>
					  		<?php endif; ?>
					    </tbody>
					</table>
					<div class="text-center">
		            <?php echo $this->pagination->create_links(); ?>
		          </div>
				</div>
			</form>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/deposit.css'); ?>" rel="stylesheet">
<script>
	function returnDe(){
		if($("#MNY").val() > <?=$user[0]->deposit?> ) {alert("나의 예치금을 다시 확인하세요.");return;}
		if($("#MNY").val() < 10000 ) {alert("10,000원 이상의 환불 금액을 입력해주세요.");return;}
		if($("#OWNER").val().trim() == "") {alert("예금주를 입력하세요.");$("#OWNER").focus();return;}
		if($("#PYN_NM").val().trim() == "") {alert("은행명을 입력하세요.");$("#PYN_NM").focus();return;}
		if($("#PYN_NUMBER").val().trim() == "") {alert("계좌번호를 입력하세요.");$("#PYN_NUMBER").focus();return;}
		$("#frmPageInfo").submit();
	}
	$(".refuseDeposit").click(function(){
		var id = $(this).data("id"),
			hitURL = baseURL + "refuseDeposit",
			currentRow = $(this);
		
		var confirmation = confirm("취소하시겠습니까?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { deposit_id : id} 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { window.location.reload();}
				else if(data.status = false) { alert("삭제실패!"); }
				else { alert("접근거절..!"); }
			});
		}
	});
</script>