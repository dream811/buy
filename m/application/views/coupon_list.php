<?php $data['title']="나의 쿠폰함" ?>
<?php $this->load->view("my_header",$data); ?>
<?php 
    if($cc==null) $cou=$ac;
    else $cou = $ac-$cc;
?>
<div class="container">
	<div class="row">
		<div id="subRight">
			<div class="row p-10">
				<div class="col-xs-6 p-left-5 p-right-3">
					<a href="/coupon" class="btn btn-charo btn-block">사용가능 쿠폰</a>
				</div>
				<div class="col-xs-6 p-right-5 p-left-3">
					<a href="/coupon_list" class="btn btn-yonpu btn-block">지난쿠폰 내역</a>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="table-responsive border-b">
						<table class="table table-bordered request_deposit_table">
							<thead class="thead-jin">
						      <tr>
						        <th scope="col">No</th>
						        <th scope="col">쿠폰종류</th>
						        <th scope="col">할인	</th>
						        <th scope="col">유효기간</th>
						        <th scope="col">상태</th>
						      </tr>
						    </thead>
						    <tbody>
						    	<?php if(!empty($coupon_list)): ?>
						    		<?php foreach($coupon_list as $value):?>
						    			<?php $result = ""; ?>
						    			<?php if($value['used']==1) $result="사용완료"; ?>
						    			<?php if($value['used']!=1){
						    				if($value['event']==1){
						    					if(date("Y-m-d") <= $value['byd']) $result="사용가능";
						    					if(date("Y-m-d") > $value['byd']) $result="기간만료";
						    				}
						    				if($value['event']==0){
						    					$d  = explode("|", $value['terms']);
						    					if(date("Y-m-d") <=$d[1] && date("Y-m-d") >=$d[0]) $result="사용가능";
						    					else $result="기간만료";
						    				}
						    			} ?>
						    			<tr>
									        <th scope="col" class="mid"><?=$cou?></th>
									        <th scope="col" class="mid"><?=$value['content']?></th>
									        <td scope="col" class="mid"><?=number_format($value['gold'])?><?=$value['gold_type'] ==1?"원":"%"?></td>
									        <td scope="col" class="mid">
									        	<?php 
									        		$ee = explode("|", $value['terms']);
									        		$e1= date_format(date_create($ee[0]),"Y-m-d");
									        		$e2= date_format(date_create($ee[1]),"Y-m-d");
									        	?>
									        	<?=$e1."<br>~".$e2?>
									        </td>
									        <td scope="col" class="mid"><?=$result?></td>

									    </tr>
									    <?php $cou  = $cou-1; ?>
						    		<?php endforeach; ?>
						    	<?php endif; ?>
						    </tbody>
						</table>
					</div>
					<div class="box-footer clearfix text-center">
		                <?php echo $this->pagination->create_links(); ?>
		            </div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.table td, .table th {
	    padding: .45rem !important;
	}
</style>