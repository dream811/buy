 <?php 
    if($cc==null) $cou=$ac;
    else $cou = $ac-$cc;
?>

<div class="container">
	<div class="row">
		<?php $this->load->view("left_menu",array("left"=>"my")); ?>
		<div id="subRight" class="col-md-9">
			<div class="padgeName">
				<h2>나의 쿠폰함</h2>
			</div>
			<div class="row my-3">
				<div class="col-md-2 p-left-0 p-right-2"><a href="/coupon" class="btn btn-charo text-white w-100">사용가능한 쿠폰</a></div>
				<div class="col-md-2 p-left-2 p-right-0"><a href="/coupon_list" class="btn btn-yonpu text-white w-100">지난쿠폰 내역</a></div>
			</div>
			<div class="table-responsive">
				<table class="table request_deposit_table table-bordered">
					<thead class="thead-jin">
				      <tr>
				        <th scope="col">No</th>
				        <th scope="col">쿠폰종류</th>
				        <th scope="col">할인	</th>
				        <th scope="col">유효기간</th>
				        <th scope="col">발급일</th>
				        <th scope="col">사용일</th>
				        <th scope="col">상태</th>
				      </tr>
				    </thead>
				    <tbody>
				    	<?php if(!empty($coupon_list)): ?>
				    		<?php foreach($coupon_list as $value):?>
				    			<?php $used_date  = date("Y-m-d",strtotime($value['updated_date'])); ?>
				    			<?php $result = ""; ?>
				    			<?php if($value['used']==1) $result="사용완료"; ?>
				    			<?php if($value['used']!=1){
				    				if($value['event']==1){

				    					if(date("Y-m-d") <= $value['byd']) $result="사용가능";
				    					if(date("Y-m-d") > $value['byd']){
				    						$result="기간만료";
				    						$used_date = "미사용";
				    					}
				    				}
				    				if($value['event']==0){
				    					$d  = explode("|", $value['terms']);
				    					if(date("Y-m-d") <=$d[1] && date("Y-m-d") >=$d[0]) $result="사용가능";
				    					else{
				    						$result="기간만료";
				    						$used_date = "미사용";
				    					}
				    				}
				    			} ?>
				    			<tr>
							        <td ><?=$cou?></td>
							        <td class="font-weight-bold"><?=$value['content']?></td>
							        <td ><?=number_format($value['gold'])?><?=$value['gold_type'] ==1?"원":"%"?></td>
							        <td ><?=$value['terms']?></td>
							        <td ><?=date("Y-m-d",strtotime($value['created_date']))?></td>
							        <td ><?=$used_date?></td>
							        <td  class="text-danger"><?=$result?></td>
							    </tr>
							    <?php $cou = $cou-1; ?>
				    		<?php endforeach; ?>
				    	<?php endif; ?>
				    </tbody>
				</table>
				<div class="box-footer clearfix text-center">
	                <?php echo $this->pagination->create_links(); ?>
	            </div>
			</div>
		</div>
	</div>
</div>
