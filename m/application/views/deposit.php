<?php $data['title']="예치금/포인트" ?>
<? $site = $pageTitle ?>
<?php 
if(empty($bank) || sizeof($bank) ==0):
	echo '관리자 계좌가 존재하지 않습니다.후에 다시 시도하세요';
	return;
endif;
?>
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
			<form name="frmPageInfo" id="frmPageInfo" method="post" action="/sendRequestDeposit">
				<input type="hidden" name="sKind" id="sKind" value="">
				<input type="hidden" name="bankId" id="bankId" value="1">
				<div class="p-left-10 p-right-10">
					<div class="table-responsive">
						<table class="table table-bordered border-r border-l border-b">
						    <tbody>
						    	<tr>
						    		<td class="mid">예치금액(원)</td>
						    		<td>
						    			<input type="text" name="MNY" id="MNY" class="form-control ft-12" value="0"> 
						    		</td>
						    	</tr>
						    	<tr>	
						    		<td class="mid">입금자명</td>
						    		<td>
						    			<input type="text" name="PYN_NM" id="PYN_NM" class="form-control ft-12" value="<?=$this->session->userdata("fname")?>"> 
						    		</td>
						    	</tr>
						    	<tr>	
						    		<td class="mid">입금일</td>
						    		<td>
						    			<input readonly class="form-control ft-12" type="text" id="date-group1-1" placeholder="YY-mm-dd" name="PYN_DT">
						    		</td>
						    	</tr>
						    	<tr>
					  				<td class="mid">
					  					<span class="ft-12">예치금 입금계좌</span>
					  				</td>
					  				<td >
					  					<textarea class="form-control ft-12" readonly name="Text1"><?=trim($bank[0]->bank." ".$bank[0]->number." ".$bank[0]->name)?>
					  					</textarea>
					  				</td>
					  			</tr>	
						    </tbody>
						</table>
					</div>
					<div class="btn_wrap row">
						<div class="col-xs-8 p-left-5 p-right-5">
							<span style="vertical-align:bottom;text-align:left;font-weight: 900;">*예치금의 경우 무통장입금을 통해서만 가능하오며,신청 후 1일 이내에 확인 후 예치금 반영해드립니다.</span>
						</div>
						<div class="col-xs-4  text-right p-right-5 p-left-5">
							<div>
								<a href="javascript:fnDpstReqDetIn();" class="btn btn-warning btn-round"><span>신청하기</span></a>
							</div>	
						</div>
					</div>
				</div>
				<div class="row mt-10">
					<div class="col-xs-6 p-right-3">
						<a href="/deposit" class="btn btn-yonpu btn-block">예치금 적립</a>	
					</div>
					<div class="col-xs-6 p-left-3">
						<a href="deposit_return" class="btn  btn-charo btn-block">예치금 환급</a>
					</div>
				</div>
				<div class="row mt-5">
					<div class="col-xs-6 p-right-3">
						<a href="/deposit_history" class="btn btn-charo btn-block">예치금 이용내역</a>
					</div>
					<div class="col-xs-6 p-left-3">
						<a href="/point_history" class="btn btn-charo btn-block">포인트 이용내역</a>
					</div>
				</div>
				<div class="row mt-10">
					<div class="col-xs-12">
						<table class="table table-bordered request_deposit_table">
							<thead class="thead-jin">
						      <tr>
						        <th scope="col"	class="mid" style="padding: 3px !important">신청일</th>
						        <th scope="col"	class="mid" style="padding: 3px !important">입금자명</th>
						        <th scope="col"	class=" mid" style="font-size:11px;padding: 3px !important">예치금액(원)</th>
						        <th scope="col"	class="mid" style="padding: 3px !important">입금계좌</th>
						        <th scope="col"></th>
						      </tr>
						    </thead>
						    <tbody>
						  		<?php if(!empty($deposits)): ?>
						  			<?php foreach($deposits as $value): ?>
						  				<tr>
						  					<td	class="mid p-3" style="font-size:11px;min-width:80px;width: 80px;padding: 3px !important"><?=date("Y-m-d", strtotime($value->update_date))?></td>
						  					<td	class="mid p-3" style="width: 90px;padding: 2px !important"><?=$value->name?></td>
						  					<td	class="	mid p-3" style="width: 90px;padding: 2px !important"><?=number_format($value->amount)?></td>
						  					<td	class="mid p-3" style="min-width: 70px;padding: 2px !important">
						  						<?=$bank[0]->bank?><br> <?=$bank[0]->name?><br><?=explode("-",$bank[0]->number)[0]?><br>
						  						<?=isset(explode("-",$bank[0]->number)[1]) ? explode("-",$bank[0]->number)[1]."<br>":""?>
						  						<?=isset(explode("-",$bank[0]->number)[2]) ? explode("-",$bank[0]->number)[2]:""?> 
						  					</td>
						  					<td	class=" p-3 text-center mid" style="padding:2px !important">
						  						<a href="#" class="btn btn-danger btn-sm deleteDeposit btn-round" data-id="<?=$value->id?>">취소</a>
						  					</td>
						  				</tr>
						  			<?php endforeach; ?>
						  		<?php endif; ?>
						    </tbody>
						</table>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/deposit.css'); ?>" rel="stylesheet">
<script>
	$('.form_date').datetimepicker({
        language:  'kr',
        weekStart: 1,
		autoclose: 1,
		startView: 2,
		forceParse: 0
    });
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

	new Rolldate({
				el: '#date-group1-1',
				format: 'YYYY-MM-DD',
				beginYear: <?=date("Y")?>,
				endYear: <?=date("Y")?>,
				lang: lang_date
			})
</script>
