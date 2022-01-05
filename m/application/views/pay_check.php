<?php 
$data['title']="마이페이지";
$data['pay_page']=1;
?>
<?php $this->load->view("my_header",$data); ?>
<?php 
    if($cc==null) $cou=$ac;
    else $cou = $ac-$cc;
?>
<div class="container">
	<div class="row">
		<div id="subRight">
			<form name="frmPageInfo" id="frmPageInfo" method="get" action=""> 
				<div class="con">
					<div class="row p-10">
						<div class="col-xs-12 p-5">
							<a href="/mypay" class="btn btn-charo">대행결제</a>
							<a href="/payHistory" class="btn btn-yonpu">대행 결제내역</a>
						</div>
					</div>
					<?php if(!empty($bank)): ?>
					<div class="row">
						<div class="col-md-12">
							<div class="bscBox vm_box">		
								<b><?=$bank[0]->name?>&nbsp;&nbsp;<?=$bank[0]->bank?>&nbsp;&nbsp;계좌번호 : <?=$bank[0]->number?></b>
							</div>
						</div>
					</div>	
					<?php endif; ?>
					<div class="row my-4 my-3">
			            <div class="col-md-12">
			              <select name="shCol" id="shCol" class="form-control w-100">
			                <option value="" <?=!empty($_GET['shCol']) && $_GET['shCol']=="" || empty($_GET['shCol']) ? "selected":""?>>전체</option>
			                <option value="4" <?=!empty($_GET['shCol']) && $_GET['shCol']=="4" ? "selected":""?>>무통장입금</option>
			                <option value="5" <?=!empty($_GET['shCol']) && $_GET['shCol']=="5" ? "selected":""?>>예치금 전액 결제</option>
			              </select>
			            </div>
			        </div>
			        <div class="row">    
			            <div class="col-xs-5 p-right-1">
			              <input type="date" class="form-control" name="shBeginDay" value="<?=!empty($_GET['shBeginDay']) ? $_GET['shBeginDay']:""?>">
			            </div>
			            <div class="col-xs-5 p-left-1 p-right-1">
			              <input type="date" class="form-control" name="shEndDay" value="<?=!empty($_GET['shEndDay']) ? $_GET['shEndDay']:""?>">
			            </div>
			            <div class="col-xs-2 p-left-1">
			              <input type="submit" class="btn-block btn btn-yonpu btn-round" value="검색">
			            </div>
			        </div>
					<div class="row my-4">
						<div class="col-md-12">
							<div class="table-responsive border-b">
								<table class="table request_deposit_table table-bordered">
								    <thead class="thead-jin">
								      <tr>
								        <th scope="col" class="text-center">No</th>
								        <th scope="col" class="text-center">결제총금액</th>
								        <th scope="col" class="text-center">예치금</th>
								        <th scope="col" class="text-center">포인트</th>
								        <th scope="col" class="text-center">상태</th>
								      </tr>
								    </thead>
								    <tbody>
								    	<?php if(!empty($history)): ?>
								    		<?php foreach($history  as $value): ?>
								    			<tr>
								    				<td class="mid"><?=$cou?></td>
								    				<td class="mid text-center"><?=number_format($value->all_amount)?>원</td>
								    				<td class="mid text-center"><?=number_format($value->amount)?>원</td>
								    				<td class="mid text-center"><?=number_format($value->point)?></td>
								    				<td class="mid text-center"><a href="javascript:getpayC('<?=$value->id?>')" class="text-danger">상세보기</a></td>
								    			</tr>
								    			<?php $cou = $cou-1; ?>
								    		<?php endforeach; ?>
								    	<?php endif; ?>
								    </tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="text-center">
				<?php echo $this->pagination->create_links(); ?>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="details_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">대행결제내역상세</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
       <div class="modal-body">
      </div>
    </div>
  </div>
</div>				
<link href="<?php echo site_url('/template/css/user.css'); ?>" rel="stylesheet">
<script>
function getpayC(security){

	jQuery.ajax({
		type : "POST",
		url : baseURL+"getpayC",
		data : { id : security} 
		}).done(function(data){
			$("#details_modal").modal("show");
			$("#details_modal .modal-body").html(data);
	});

}
</script>