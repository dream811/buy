<!DOCTYPE html>
<html>
<head>
	<title></title>
	  <script>
    window.jQuery || document.write('<script src="<?php echo site_url('/template/js/jquery-v1.11.3.min.js') ?>"><\/script>')
  </script>
  <script src="<?php echo site_url('/template/js/common.js')?>"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo site_url('/template/css/user.css'); ?>?<?=time()?>" rel="stylesheet">
	<link href="<?php echo site_url('/template/css/reset.css'); ?>" rel="stylesheet">
</head>
<style>

	header, .topInfo, #footer, .container {
	    min-width: unset !important;
	    width: 100%;
	    padding: 0
	}

	td{
		font-size: 12px;
	}
	th{
		font-size: 13px;
	}
	
</style>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12 p-0">
				<div class="pop-title"><h3><?=$mode=="plus" ? "묶음배송":"나눔배송"?></h3></div>
			</div>
		</div>
		<div class="row">
			<div class="titSub">
				현재 주문정보
			</div>
			<div class="col-md-12 p-0">
				<input type="hidden" name="shGo" id="shGo" value="1">
				<input type="hidden" name="sKind" id="sKind">
				<input type="hidden" name="sCnt" id="sCnt" value="<?=sizeof($delivery)?>">
				<div class="table-responsive">
					<table class="table table-dark border-table">
						<thead class="thead-dark">
							<tr>
								<th class="text-center">주문번호</th>
								<th class="text-center">수취인</th>
								<th class="text-center">배송센터</th>
								<th class="text-center">배송구분	</th>
								<th class="text-center">일자	</th>
							</tr>
						</thead>
						<tbody>
							<?php if(empty($delivery)): ?>
								<?php echo $error;return; ?>
							<?php endif; ?>
							<?php if(!empty($delivery)): ?>
									<tr>
										<td  class="text-center"><?=$delivery[0]->ordernum?></td>	
										<td class="text-center"><?=$delivery[0]->billing_krname?></td>
										<td class="text-center"><?=$delivery[0]->area_name?></td>
										<td class="text-center">
											<?php if($delivery[0]->get=="delivery") echo '배송대행'; ?>
											<?php if($delivery[0]->get=="buy") echo '구매대행'; ?>
										</td>	
										<td class="text-center"><?=date("Y-m-d",strtotime($delivery[0]->updated_date))?></td>							
									</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">

			<div class="col-md-12 p-0">
				<div class="titSub">
					대상 상품정보 목록
				</div>
				<form name="popfrmBundle" id="popfrmBundle" method="get">
					<input type="hidden" name="shGo" id="shGo" value="1">
					<input type="hidden" name="sKind" id="sKind">
					<input type="hidden" name="orders" value="<?=$delivery[0]->delivery_id?>">
					<div class="table-responsive">
						<table class="table table-dark border-table">
							<thead class="thead-dark">
								<tr>
									<th class="text-center">주문번호</th>
									<th class="text-center">상품명</th>
									<th class="text-center">상품이미지</th>
									<th class="text-center">가격</th>
									<th class="text-center" width="100px">수량</th>
									<th class="text-center">배송구분</th>
									<th class="text-center">일자	</th>
								</tr>
							</thead>
							<tbody>
								<?php if(empty($delivery)): ?>
									<?php echo $error;return; ?>
								<?php endif; ?>
								<?php if(!empty($delivery)): ?>
									<?php if($mode=="plus" && sizeof($child) >0 || $mode=="minus"): ?>
										<?php foreach($delivery as $value): ?>
											<tr>
												<td class="text-center mid">
													<?php if($mode=="plus"): ?>
														<input type="checkbox" class="main-seq" name="chkORD_SEQ[]"  value="<?=$value->id?>|<?=$value->delivery_id?>" id="idx_<?=$value->id?>">
													<?php endif; ?>
													<?php if($mode=="minus"): ?>
													<input type="checkbox" class="chkORD_SEQ" name="chkORD_SEQ[]"  value="<?=$value->id?>" id="idx_<?=$value->id?>">
													<?php endif; ?>	
													<label class="form-check-label form-weight-bold" for="idx_<?=$value->id?>" style="font-weight:900"><?=$value->serial?></label>		
													
												</td>	
												<td class="text-center mid"><?=$value->productName?></td>
												<td class="text-center"><img src="<?=$value->image?>" width="50"></td>
												<td class="text-center mid"><?=$value->unitPrice?></td>
												<td class="text-center">
													<select name="MNS_CNT[]" id="MNS_CNT"  class="form-control" disabled>
													<?php for($i=1;$i<=$value->count;$i++){  ?>
														<option value="<?=$i?>" <?=$value->count == $i ? "selected": ""?>><?=$i?></option>
													<?php } ?>
													</select>
												</td>
												<td class="text-center mid">
													<?php if($value->get=="delivery") echo '배송대행'; ?>
													<?php if($value->get=="buy") echo '구매대행'; ?>
												</td>	
												<td class="text-center mid"><?=date("Y-m-d",strtotime($value->updated_date))?></td>							
											</tr>
										<?php endforeach; ?> 
									<?php endif; ?>	
								<?php endif; ?>
								<?php if(empty($child)): ?>
									<?php if($mode =="plus") {echo $error;return;} ?>
								<?php endif; ?>
								<?php if(!empty($child)): ?>
									<?php foreach($child as $value): ?>
										<tr>
											<td class="text-center mid">
												<?php if($mode=="plus"): ?>
													<input type="checkbox" class="chkORD_SEQ" name="chkORD_SEQ[]"  value="<?=$value->id?>|<?=$value->delivery_id?>" id="idx_<?=$value->id?>">
												<?php endif; ?>
												<?php if($mode=="minus"): ?>
												<input type="checkbox" class="chkORD_SEQ" name="chkORD_SEQ[]"  value="<?=$value->id?>" id="idx_<?=$value->id?>">
												<?php endif; ?>	
												<label for="idx_<?=$value->id?>"><?=$value->serial?></label></td>	
											<td class="text-center mid"><?=$value->productName?></td>
												<td  class="text-center"><img src="<?=$value->image?>" width="50"></td>
												<td  class="text-center mid"><?=$value->unitPrice?></td>
												<td class="text-center">
													<select name="MNS_CNT[]" id="MNS_CNT" disabled="" class="form-control">
													<?php for($i=1;$i<=$value->count;$i++){  ?>
														<option value="<?=$i?>" <?=$value->count == $i ? "selected": ""?>><?=$i?></option>
													<?php } ?>
													</select>
												</td>
												<td class="text-center mid">
													<?php if($value->get=="delivery") echo '배송대행'; ?>
													<?php if($value->get=="buy") echo '구매대행'; ?>
												</td>	
												<td class="text-center mid"><?=date("Y-m-d",strtotime($value->updated_date))?></td>							
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
					<div class="text-center my-4 mb-10">
					<?php if(!empty($_GET['mode']) && $_GET['mode']=="plus"): ?>
						<a href="javascript:fnOrdMix();" class="btn btn-warning btn-sm btn-round">묶음</a>
					<?php endif; ?>
					<?php if(!empty($_GET['mode']) && $_GET['mode']=="minus"): ?>
						<a href="javascript:fnOrdMinus();" class="btn btn-warning btn-sm btn-round">나눔</a>
					<?php endif; ?>
						<a href="javascript:self.close();" class="btn  btn-danger btn-sm btn-round">닫기</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>

<script type="text/javascript">

$(document).ready( function() {

	$(":checkbox").bind( "change", function(idx) {
		if ( $(this).prop("checked") == true ) {
			$(this).parent().parent().find("select").attr("disabled", false);
		} else {
			$(this).parent().parent().find("select").attr("disabled", true);
		}
	});

});

	function fnOrdMix() {
		var frmObj = "#popfrmBundle"; 

		if (fnSelBoxCnt($(frmObj + " input[name='chkORD_SEQ[]']")) <= 0) {
			alert('묶을 주문을 선택하십시오.');
			return;
		}

		if (fnSelBoxCnt($(frmObj + " input[class='main-seq']")) <= 0) {
			alert('현재 주문의 상품들을 포함시켜 주세요');
			return;
		}
	 
		if (confirm("한번 묶음은 더이상 다시 묶을수 없습니다.\n진행하시겠습니까?")) {
			var formData = new FormData(document.getElementById("popfrmBundle"));
			alert(formData);
			$.ajax({
	            type: "POST",
	            url:"/ActingPlus_I",
	            data: formData,
    			processData: false,
   				contentType: false,
    			dataType:"json",
	            success: function (data) {
	            	alert(data.msg);
	            	if(data.ordernum.trim() !="")
            		{
            			opener.gotoRequest(data.ordernum,data.option);
            		}
	            	self.close();
	            },
	            error: function(request, status, error) {
	            	self.close();
	            }
	        });
		}
	}
	function fnOrdMinus() {
		var frmObj = "#popfrmBundle"; 
		var val = 0;

		$('select').each(function (i, e){
			val += Number($(this).val());
		});


		if (fnSelBoxCnt($(frmObj + " input[name='chkORD_SEQ[]']")) <= 0) {
			alert('나눌 제품을 선택하십시오.');
			return;
		}

		
		if (confirm("나눔을 진행하시겠습니까?")) {
			var formData = new FormData(document.getElementById("popfrmBundle"));
			$.ajax({
	            type: "POST",
	            url:"/ActingMinus_I",
	            data: formData,
    			processData: false,
   				contentType: false,
    			dataType:"json",
	            success: function (data) {
	            	alert(data.msg);
	            	if(data.ordernum.trim() !="")
	        		{
	        			opener.gotoRequest(data.ordernum,data.option);
	        		}
		            self.close();
	            },
	            error: function(request, status, error) {
	            	self.close();
	            }
	        });
		}
}

</script>