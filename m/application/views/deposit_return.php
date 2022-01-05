<?php $data['title']="예치금/포인트" ?>
<div class="container">
	<div class="row">
		<?php $this->load->view("my_header",$data); ?>
		<div id="subRight">
			<div class="row pt-10 pb-10">
				<div class="col-xs-6">
					<p>나의 예치금: <span class="font-weight-bold"><?=number_format($user[0]->deposit)?></span> 원</p>
				</div>
				<div class="col-xs-6">
					<p>나의 포인트: <span class="font-weight-bold"><?=number_format($user[0]->point)?></span> P</p>
				</div>
			</div>
			<form name="frmPageInfo" id="frmPageInfo" method="post" action="/returntDeposit">
				<input type="hidden" name="sKind" id="sKind" value="">
				<input type="hidden" name="bankId" id="bankId" value="1">
				<div class="p-left-10 p-right-10">
					<div class="table-responsive">
						<table class="table table-bordered border-r border-l border-b">
						    <tbody>
						    	<tr>
						    		<td class="mid text-center">환급할 금액(원)</td>
						    		<td><input type="number" name="MNY" id="MNY" class="form-control"></td>
						    	</tr>
						    	<tr>
						    		<td class="mid text-center">예금주</td>
						    		<td><input type="text" name="OWNER" id="OWNER" class="form-control" value="<?=$this->session->userdata("fname")?>" required></td>
						    	</tr>
						    	<tr>
						    		<td class="mid text-center">은행명</td>
						    		<td><input type="text" name="PYN_NM" id="PYN_NM" class="form-control"  required></td>
						    	</tr>
						    		<td class="mid text-center">계좌번호</td>
						    		<td><input type="text" name="PYN_NUMBER" id="PYN_NUMBER" class="form-control" required></td>
						    	</tr>
						    </tbody>
						</table>
					</div>
					<div class="btn_wrap row pb-5">
						<div class="col-md-12 p-5">
							<div class="text-right">
								<a href="javascript:returnDe();" class="btn btn-warning btn-round">환급하기</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-10">
					<div class="col-xs-6 p-right-3">
						<a href="/deposit" class="btn btn-charo  w-100">예치금 적립</a>	
					</div>
					<div class="col-xs-6 p-left-3">
						<a href="deposit_return" class="btn  btn-yonpu w-100">예치금 환급</a>
					</div>
				</div>
				<div class="row mt-5">
					<div class="col-xs-6 p-right-3">
						<a href="/deposit_history" class="btn btn-charo w-100">예치금 이용내역</a>
					</div>
					<div class="col-xs-6 p-left-3">
						<a href="/point_history" class="btn btn-charo w-100">포인트 이용내역</a>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="mt-10 border-b">
							<table class="table">
								<thead class="thead-jin">	
							      <tr>
							        <th scope="col" class="text-center" style="padding: 3px !important">신청일</th>
							        <th scope="col" style="padding: 3px !important">환급금액(원)</th>
							        <th scope="col" style="padding: 3px !important">환급계좌</th>
							        <th class="text-center" style="padding: 3px !important">승인</th>
							        <th></th>
							      </tr>
							    </thead>
							    <tbody>
							  		<?php if(!empty($deposits_return)): ?>
							  			<?php foreach($deposits_return as $value): ?>
							  				<tr>
							  					<td class="text-center mid" style="min-width:80px;width: 90px;padding: 3px !important"><?=date_format(date_create($value->created_date),"Y-m-d")?></td>
							  					<td class="mid" style="width: 80px;padding: 3px !important"><?=number_format($value->amount)?></td>
							  					<td class="text-left mid"><?=$value->owner?><br><?=$value->bank_name?><br><?=$value->bank_number?></td>
							  					<td class="text-center mid" style="min-width: 50px"><?php 	if($value->accept == 0 ) echo '미정';
							  								if($value->accept == 1 ) echo '승인';
							  								if($value->accept == 2 ) echo '거절'; ?></td>
							  					<td class="text-center mid">
							  						<?php if($value->accept == 0 || $value->accept == 2): ?>
							  							<a href="#" class="btn btn-danger btn-sm refuseDeposit btn-round" data-id="<?=$value->id?>">삭제</a>
							  						<?php endif; ?>
							  					</td>
							  				</tr>
							  			<?php endforeach; ?>
							  		<?php endif; ?>
							    </tbody>
							</table>
						</div>
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
<style type="text/css">
	.table-responsive {
		margin-bottom: 10px;
	}
	.table td, .table th{
		    padding: .45rem !important;
	}
</style>