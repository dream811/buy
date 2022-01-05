<?php 
if(empty($bank) || sizeof($bank) ==0):
	echo '관리자 계좌가 존재하지 않습니다.후에 다시 시도하세요';
	return;
endif;
?>
<div class="container">
	<div class="row">
		<?php $this->load->view("left_menu",array("left"=>"my")); ?>
		<div id="subRight" class="col-md-9">
			<div class="padgeName">
				<h2>예치금/포인트</h2>
			</div>
			<form name="frmPageInfo" id="frmPageInfo" method="post" action="/sendRequestDeposit">
				<input type="hidden" name="sKind" id="sKind" value="">
				<input type="hidden" name="bankId" id="bankId" value="1">
				<div class="con">
					<div class="s_tit_box2">
						<h4 class="s_tit">예치금/포인트 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						나의 예치금: <span class="bold clrRed1"><?=number_format($user[0]->deposit)?></span> 원 &nbsp;&nbsp;&nbsp;
						나의 포인트: <span class="bold clrRed1"><?=number_format($user[0]->point)?></span>P</h4>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered deposit_table">
						<thead class="thead-jin">
					      <tr>
					        <th scope="col" class="text-center">예치금액(원)	</th>
					        <th scope="col" class="text-center">입금자명</th>
					        <th scope="col" class="text-center">입금일</th>
					        <th scope="col" class="text-center"><?=$pageTitle?> 예치금 입금계좌</th>
					      </tr>
					    </thead>
					    <tbody>
					    	<tr>
					    		<td>
					    			<input type="text" name="MNY" id="MNY" class="form-control" value="0"> 
					    		</td>
					    		<td>
					    			<input type="text" name="PYN_NM" id="PYN_NM" class="form-control" value="<?=$this->session->userdata("fname")?>"> 
					    		</td>
					    		<td>
					    			<input class="form-control" size="16" type="date" value="<?=date("Y-m-d")?>"  name="PYN_DT">
					    		</td>
					    		<td class="mid">
					    			<?=$bank[0]->bank?> <?=$bank[0]->number?> <?=$bank[0]->name?>
					    		</td>
					    	</tr>
					    </tbody>
					</table>
				</div>
				<div class="btn_wrap row my-3" style="padding-top:8px;">
					<div class="col-md-10">
						<span style="vertical-align:bottom;text-align:left;">*예치금의 경우 무통장입금을 통해서만 가능하오며,신청 후 1일 이내에 확인 후 예치금 반영해드립니다.</span>
					</div>
					<div class="col-md-2 text-right">
						<div>
							<a href="javascript:fnDpstReqDetIn();" class="btn btn-warning btn-sm btn-round" ><span>신청하기</span></a>
						</div>	
					</div>
				</div>
				<div class="row">
					<div class="col-md-8 p-left-0">
						<a href="/deposit" class="btn btn-yonpu text-white my-3">예치금 적립</a>
						<a href="/deposit_return" class="btn btn-charo text-white my-3">예치금 환급</a>
						<a href="/deposit_history" class="btn btn-charo text-white my-3">예치금 이용내역</a>
						<a href="/point_history" class="btn btn-charo text-white my-3">포인트 이용내역</a>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered request_deposit_table">
						<thead class="thead-jin">
					      <tr>
					        <th scope="col">신청일</th>
					        <th scope="col">입금일</th>
					        <th scope="col">입금자명</th>
					        <th scope="col">예치금액(원)</th>
					        <th scope="col">입금계좌</th>
					        <th></th>
					      </tr>
					    </thead>
					    <tbody>
					  		<?php if(!empty($deposits)): ?>
					  			<?php foreach($deposits as $value): ?>
					  				<tr>
					  					<td class="mid"><?=date("Y-m-d",strtotime($value->update_date))?></td>
					  					<td class="mid"><?=$value->accept==1 ? $value->process_date:""?></td>
					  					<td class="mid"><?=$value->name?></td>
					  					<td class="mid"><?=number_format($value->amount)?></td>
					  					<td class="mid"><?=$bank[0]->bank?> <?=$bank[0]->number?> <?=$bank[0]->name?></td>
					  					<td class="mid"><a href="#" class="btn btn-danger btn-sm deleteDeposit btn-round" data-id="<?=$value->id?>">취소</a></td>
					  				</tr>
					  			<?php endforeach; ?>
					  		<?php endif; ?>
					    </tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/deposit.css'); ?>?<?=time()?>" rel="stylesheet">
<script>
    function fnDpstReqDetIn() {
		if ($("#MNY").val() == "" || Number($("#MNY").val().replace(",", "")) < 10000 ) {
			fnMsgFcs($("#MNY"), '10,000원 이상의 금액을 입력해주세요.'); 
		} else if (!fnIptChk($("#PYN_NM"), 2, 20)) {
			fnMsgFcs($("#PYN_NM"), '입금자명을 입력하세요.'); 
		} 
		else if ($("#date-group1-1").val() == "" ) {
			fnMsgFcs($("#date-group1-1"), '입금일을 입력하세요.'); 
		}
		else {
			$("#sKind").val("A");

			var formData = new FormData(document.getElementById("frmPageInfo"));
		$.ajax({
            async: true,
	            type: $("#frmPageInfo").attr('method'),
	            url: $("#frmPageInfo").attr('action'),
	            data: formData,
	            cache: false,
	            processData: false,
	            contentType: false,
	            dataType:"json",
	            success: function (data) {
	            	if(data.status ==1){
	            		socket.emit("chat message",8,"<?=$this->session->userdata('fname')?>",<?=$this->session->userdata('fuser')?>,"deposit",
                    	"<?=$this->session->userdata('fname')?>");
	            	}
	            	location.reload();
	            },
	            error: function(request, status, error) {
	            	alert("서버오류");
	            }
	        });
		}
	}
	jQuery(document).on("click", ".deleteDeposit", function(){
		var id = $(this).data("id"),
			hitURL = baseURL + "deleteDeposit",
			currentRow = $(this);
		
		var confirmation = confirm("취소하시겠습니까?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : id} 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("취소되였습니다."); }
				else if(data.status = false) { alert("삭제실패"); }
				else { alert("접근거절..!"); }
			});
		}
	});	
</script>
