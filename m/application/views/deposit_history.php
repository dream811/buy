<?php $data['title']="예치금/포인트" ?>
<div class="container">
	<div class="row">
		<?php $this->load->view("my_header",$data); ?>
		<div id="subRight" class="col-md-10">	
			<div class="row pt-10 pb-10">
				<div class="col-xs-6">
					<p>나의 예치금: <span class="font-weight-bold"><?=number_format($user[0]->deposit)?></span> 원</p>
				</div>
				<div class="col-xs-6">
					<p>나의 포인트: <span class="font-weight-bold"><?=number_format($user[0]->point)?></span> P</p>
				</div>
			</div>
			<input type="hidden" name="sKind" id="sKind" value="">
			<input type="hidden" name="bankId" id="bankId" value="1">
			<div class="row">
				<div class="col-xs-6 p-left-0 p-right-3">
					<a href="/deposit" class="btn btn-charo  w-100">예치금 적립</a>	
				</div>
				<div class="col-xs-6 p-left-3 p-right-0">
					<a href="deposit_return" class="btn  btn-charo w-100">예치금 환급</a>
				</div>
			</div>
			<div class="row pt-5">
				<div class="col-xs-6 p-left-0 p-right-3">
					<a href="/deposit_history" class="btn btn-yonpu w-100">예치금 이용내역</a>
				</div>
				<div class="col-xs-6 p-left-3 p-right-0">
					<a href="/point_history" class="btn btn-charo w-100">포인트 이용내역</a>
				</div>
			</div>
			<div class="p-left-0 p-right-0 mt-10">
				<form method="get" action="<?=base_url()?>deposit_history"> 
			        <div class = "row">   
			            <div class="col-xs-5 p-left-3 p-right-3">
			                <input type="date" name="from" class="form-control input-sm" value="<?=empty($_GET['from']) == 0 ? $_GET['from']:"" ?>" >
			               </div>
			            <div class="col-xs-5 p-left-5 p-right-5">
			                 <input type="date" name="to" class="form-control input-sm" value="<?=empty($_GET['to']) == 0 ? $_GET['to']:"" ?>">
			            </div>
			            <div class="col-xs-2 p-left-3 p-right-3">
			            	<input type="submit" class="btn-block btn btn-yonpu btn-round btn-sm" value="검색">
			            </div>
			        </div>
			    </form>
			</div>
			<div class="mt-10">
				<table class="table request_deposit_table table-bordered">
					<colgroup>
						<col width="30%"> 
                        <col width="45%"> 
                        <col width="25%"> 
					</colgroup>
					<thead class="thead-jin">
				      <tr>
				        <th scope="col" class="mid">사용일</th>
				        <th scope="col" class="mid">내용	</th>
				        <th scope="col" class="mid">금액(원)</th>
				      </tr>
				    </thead>
				    <tbody>
				  		<?php if(!empty($history)): ?>
				  			<?php foreach($history as $value): ?>
				  				<tr>
				  					<td><?=explode(" ",$value['updated_date'])[0]?></td>
				  					<td><?php 
				  						if($value['typess'] == 5 && $value['by'] !=1){ echo '예치금 전액 결제';$mul=-1;}
				  						if($value['typess'] == 5 && $value['by'] ==1){ echo '관리자 예치금 전액 결제';$mul=-1;}
				  						if($value['typess'] == 120 && $value['by'] ==1){ echo '결제취소(예치금 결제)';$mul=1;}
				  						if($value['typess'] ==101 ) 
				  						{
				  							if($value['pending'] ==0) {echo '예치금 환급';$mul=-1;}
				  							if($value['pending'] ==2) {echo '예치금환급 취소';$mul=1;}
				  						}
				  						if($value['typess'] ==102 ) 
				  						{
				  							if($value['pending'] ==0) {echo '예치금 적립';$mul=1;}
				  							if($value['pending'] ==2) {echo '예치금적립 취소';$mul=-1;}
				  						}
				  						if($value['typess'] ==16 ) 
				  						{
				  							echo '관리자 예치금 적립';$mul=1;

				  						}
				  						if($value['typess'] ==17 ) 
				  						{
				  							echo '관리자 예치금 삭감';$mul=-1;

				  						}
				  						if(!empty($value['ordernum'])) 
				  						{
				  							echo ' 주문번호 : '.$value['ordernum'];

				  						}
				  					?></td>
				  					<td><?=number_format($value['amount'])?></td>
				  				</tr>
				  			<?php endforeach; ?>
				  		<?php endif; ?>
				    </tbody>
				</table>
				<div class="text-center">
					<?php echo $this->pagination->create_links(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/deposit.css'); ?>" rel="stylesheet">