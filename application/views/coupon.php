<div class="container">
	<div class="row">
		<?php $this->load->view("left_menu",array("left"=>"my")); ?>
		<div id="subRight" class="col-md-9">
			<div class="padgeName">
				<h2>나의 쿠폰함</h2>
			</div>
			<div class="row my-3">
				<div class="col-md-2 p-left-0 p-right-2"><a href="/coupon" class="btn btn-yonpu text-white w-100">사용가능한 쿠폰</a></div>
				<div class="col-md-2 p-left-2 p-right-0"><a href="/coupon_list" class="btn btn-charo text-white w-100">지난쿠폰 내역</a></div>
			</div>
			<form name="frmSearch" id="frmSearch" method="get" action="">  
				<div class="table-responsive">
					<table class="table request_deposit_table table-bordered">
						<thead class="thead-jin">
					      <tr>
					        <th scope="col">No</th>
					        <th scope="col">쿠폰종류</th>
					        <th scope="col">할인	</th>
					        <th scope="col">유효기간</th>
					        <th scope="col">발급일</th>
					        <th scope="col">남은 기간</th>
					      </tr>
					    </thead>
					    <tbody>
					    	<?php if(!empty($coupon)): ?>
					    		<?php foreach($coupon as $value): 
					    			if($value->event ==0){
										$remain = floor((strtotime(explode("|", $value->terms)[1]) - strtotime(date("Y-m-d")))/86400);
										if($remain < 0) continue;
									} 
									else{
										$remain = floor((strtotime($value->byd) - strtotime("now"))/86400);		
									}
					    			if($value->event ==1){
					    				if($value->Diff > $value->use_terms) continue;
					    			}
					    			?>
					    			<tr>
								        <td ><?=$size_coupon?></td>
								        <td class="font-weight-bold"><?=$value->content?></td>
								        <td ><?=number_format($value->gold)?><?=$value->gold_type ==1?"원":"%"?></td>
								        <td ><?=date("Y-m-d",strtotime($value->created_date))?> | 
								        	<?=date( "Y-m-d", strtotime(date("Y-m-d",strtotime($value->created_date))." +".$remain." day" ) )?></td>
								        <td ><?=date("Y-m-d",strtotime($value->created_date))?></td>
								        <td >
											<?=$remain?>일
								        </td>
								    </tr>
								    <?php $size_coupon = $size_coupon-1; ?>
					    		<?php endforeach; ?>
					    	<?php endif; ?>
					    </tbody>
					</table>
				</div>
				<div class="row my-4">
					<div class="col-xs-12">
						<!-- <a href="./registerCoupon" class="btn btn-dark"  -->
						<!-- onclick="fnPopWinCT(this.href, 'CpnReg', 650, 410, 'N');return false">쿠폰등록</a> -->
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
