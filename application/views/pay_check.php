 <?php 
    if($cc==null) $cou=$ac;
    else $cou = $ac-$cc;
?>
<div class="container">
	<div class="row">
		<?php $this->load->view("left_menu",array("left"=>"my")); ?>
		<div id="subRight" class="col-md-9">
			<form name="frmPageInfo" id="frmPageInfo" method="get" action=""> 
				<div class="padgeName">
					<h2>결제페이지</h2>
				</div>
				<div class="con">
					<div class="row">
						<div class="col-md-6  p-left-0">
							<a href="/mypay" class="btn btn-charo text-white">대행결제</a>
							<a href="/payHistory" class="btn btn-yonpu text-white">대행 결제내역</a>
						</div>
					</div>
					<?php if(!empty($bank)): ?>
					<div class="row my-4">
						<div class="col-md-12p-left-0">
							<div class="bscBox vm_box">		
								<b><?=$bank[0]->name?>&nbsp;&nbsp;<?=$bank[0]->bank?>&nbsp;&nbsp;계좌번호 : <?=$bank[0]->number?></b>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<div class="row my-4 my-3">
			            <div class="col-md-2  p-right-2 p-left-0">
			              <select name="shCol" id="shCol" class="form-control w-100 form-control-sm">
			                <option value="" <?=!empty($_GET['shCol']) && $_GET['shCol']=="" || empty($_GET['shCol']) ? "selected":""?>>전체</option>
			                <option value="4" <?=!empty($_GET['shCol']) && $_GET['shCol']=="4" ? "selected":""?>>무통장입금</option>
			                <option value="5" <?=!empty($_GET['shCol']) && $_GET['shCol']=="5" ? "selected":""?>>예치금 전액 결제</option>
			              </select>
			            </div>
			            <div class="col-md-3 p-left-2 p-right-2">
			              <input type="date" class="form-control w-100 input-sm" name="shBeginDay" 
			              value="<?=!empty($_GET['shBeginDay']) ? $_GET['shBeginDay']:""?>">
			            </div>
			            <div class="col-md-3  p-left-2 p-right-2">
			              <input type="date" class="form-control w-100 input-sm" name="shEndDay" 
			              value="<?=!empty($_GET['shEndDay']) ? $_GET['shEndDay']:""?>">
			            </div>
			            <div class="col-md-2 p-left-2">
			              <input type="submit" class="btn btn-yonpu btn-round text-white btn-sm" value="검색">
			            </div>
			        </div>
					<div class="row my-4">
						<div class="col-md-12 p-left-0">
							<div class="table-responsive">
								<table class="table table-bordered request_deposit_table">
								    <thead class="thead-jin">
								      <tr>
								        <th scope="col">No</th>
								        <th scope="col">결제총금액</th>
								        <th scope="col">예치금</th>
								        <th scope="col">포인트</th>
								        <th scope="col" class="text-center">결제구분	</th>
								        <th class="text-center" style="font-size: 12px">미결제금액</th>
								        <th class="text-center">처리일자</th>
								        <th class="text-center">결제내역</th>
								      </tr>
								    </thead>
								    <tbody>
								    	<?php if(!empty($history)): ?>
								    		<?php foreach($history  as $value): ?>
								    			<tr>
								    				<td class="mid"><?=$cou?></td>
								    				<td class="mid"><?=number_format($value->all_amount)?>원</td>
								    				<td class="mid"><?=number_format($value->amount)?>원</td>
								    				<td class="mid text-center"><?=number_format($value->point)?></td>
								    				<td class="mid text-center"><?php
								    					if($value->payed_type==4) echo '무통장 입금';
								    					if($value->payed_type==1) echo '신용카드/체크카드';
								    					if($value->payed_type==5 && $value->by==1) echo '관리자 예치금 전액 결제';
								    					if($value->payed_type==5 && $value->by!=1) echo '예치금 전액 결제';?>

								    					</td>
								    				<td class="mid text-center" style="width: 85px;">
								    					<?php if($value->pending==1):?> <?=number_format($value->pamount)?>원<?php endif; ?>
								    					<?php if($value->pending==2):?> <?=number_format($value->pamount)?>원(관리자 결제취소)<?php endif; ?>
								    				</td>
								    				<td class="mid"><?=explode(" ",$value->payed_date)[0]?></td>
								    				<td class="mid">
								    					<?php if($value->pending==0): ?>주문완료<?php endif; ?>
								    					<?php if($value->pending==1): ?>주문결제진행<?php endif; ?>
								    					<?php if($value->pending==2):?>주문결제취소<?php endif; ?>
								    					<br>
								    					주문번호: <?=$value->ordernum?></td>
								    			</tr>
								    			<?php $cou = $cou-1; ?>
								    		<?php endforeach; ?>
								    	<?php endif; ?>
								    </tbody>
								</table>
							</div>
							<?php echo $this->pagination->create_links(); ?>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>				
<link href="<?php echo site_url('/template/css/user.css'); ?>" rel="stylesheet">