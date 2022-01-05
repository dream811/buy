<?php $data['title']="나의 쿠폰함" ?>
<?php $this->load->view("my_header",$data); ?>
<?php $pagi = sizeof($coupon); ?>
<div class="container">
	<div class="row">
		<div id="subRight">
			<div class="row p-10">
				<div class="col-xs-6 p-left-5 p-right-3">
					<a href="/coupon" class="btn btn-yonpu btn-block">사용가능 쿠폰</a>
				</div>
				<div class="col-xs-6 p-right-5 p-left-3">
					<a href="/coupon_list" class="btn btn-charo btn-block">지난쿠폰 내역</a>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<form name="frmSearch" id="frmSearch" method="get" action="">  
						<div class="table-responsive border-b">
							<table class="table table-bordered request_deposit_table">
								<thead class="thead-jin">
							      <tr>
							        <th scope="col" class="text-center">No</th>
							        <th scope="col" class="text-center">쿠폰종류</th>
							        <th scope="col" class="text-center">할인	</th>
							        <th scope="col" class="text-center">유효기간</th>
							        <th scope="col" class="text-center">남은 기간</th>
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
										        <td scope="col" class="mid text-center"><?=$pagi?></td>
										        <td scope="col" class="mid text-center font-weight-bold"><?=$value->content?></td>
										        <td scope="col" class="mid text-center">
										        	<?=number_format($value->gold)?><?=$value->gold_type ==1?"원":"%"?>
										        </td>
										        <td scope="col" class="mid text-center">
										        	<?php 
										        		$ee = explode("|", $value->terms);
										        		$e1= date_format(date_create($value->created_date),"Y-m-d");
										        		$e2= date( "Y-m-d", strtotime(date("Y-m-d",strtotime($value->created_date))." +".$remain." day" ) );
										        	?>
										        	<?=$e1."<br>~".$e2?>
										        </td>
										        <td scope="col" class="mid text-center">
													<?=$remain?>일
										        </td>
										    </tr>
										    <?php $pagi = $pagi -1; ?>
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
	</div>
</div>
