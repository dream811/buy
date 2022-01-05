<?php $mul = 1; ?>
<div class="container">
	<div class="row">
		<?php $this->load->view("left_menu",array("left"=>"my")); ?>
		<div id="subRight" class="col-md-9">
			<div class="padgeName">
				<h2>예치금/포인트</h2>
			</div>
			<input type="hidden" name="sKind" id="sKind" value="">
			<input type="hidden" name="bankId" id="bankId" value="1">
			<div class="con">
				<div class="s_tit_box2 my-3">
					<h4 class="s_tit">
						나의 예치금: <span class="bold clrRed1"><?=number_format($user[0]->deposit)?></span> 원 &nbsp;&nbsp;&nbsp;
						나의 포인트: <span class="bold clrRed1"><?=number_format($user[0]->point)?></span>P</h4>
					</h4>
				</div>
			</div>
			<div class="my-15">
		        <form method="get" action="<?=base_url()?>deposit_history">
		            <div class="input-group">
		              <div class="pull-right p-1" style="line-height: 33px;height: 33px">날짜</div>
		              <div class="pull-right p-1">
		                <input type="date" name="from" class="form-control input-sm" 
		                value="<?=$this->input->get("from")?>">
		              </div>
		              <div class="pull-right p-1" style="line-height: 33px;height: 33px">~</div>
		              <div class="pull-right p-1">
		                <input type="date" name="to" class="form-control input-sm" value="<?=$this->input->get("to")?>">
		              </div>
		              <div class="pull-right p-1">
		                <input type="submit" class="btn btn-sm btn-yonpu text-white btn-round" value="검색">
		              </div>
		            </div>
		            <input type="hidden" name="option" value="<?=!empty($_GET['option']) && $_GET['option'] ? $_GET['option']:""?>">
		        </form> 
		      </div>
			<div class="row">
				<div class="col-md-8 my-4  p-left-0">
					<a href="/deposit" class="btn btn-charo text-white my-3">예치금 적립</a>
					<a href="/deposit_return" class="btn btn-charo text-white my-3">예치금 환급</a>
					<a href="/deposit_history" class="btn btn-yonpu text-white my-3">예치금 이용내역</a>
					<a href="/point_history" class="btn btn-charo text-white my-3">포인트 이용내역</a>
				</div>
			</div>

			<div class="table-responsive">
				<table class="table request_deposit_table table-bordered">
					<thead class="thead-jin">
				      <tr>
				        <th scope="col">사용일</th>
				        <th scope="col">내용	</th>
				        <th scope="col">금액</th>
				      </tr>
				    </thead>
				    <tbody>
				  		<?php if(!empty($history)): ?>
				  			<?php foreach($history as $value): ?>
				  				<tr>
				  					<td><?=$value['updated_date']?></td>
				  					<td>
				  						<?php 
				  						if($value['typess'] == 5 && $value['by'] !=1){ echo '예치금 전액 결제';$mul=-1;}
				  						if($value['typess'] == 120 && $value['by'] ==1){ echo '결제취소(예치금 결제)';$mul=1;}
				  						if($value['typess'] == 5 && $value['by'] ==1){ echo '관리자 예치금 전액 결제';$mul=-1;}
				  						if($value['typess'] ==101 ) 
				  						{
				  							if($value['pending'] ==0) {echo '예치금 환급';$mul=-1;}
				  							if($value['pending'] ==2) {echo '예치금 환급 (관리자 결제취소)';$mul=1;}
				  						}
				  						if($value['typess'] ==102 ) 
				  						{
				  							if($value['pending'] ==0) {echo '예치금 적립';$mul=1;}
				  							if($value['pending'] ==2) {echo '예치금 적립 (관리자 결제취소)';$mul=-1;}
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
				  					<td><?=number_format((empty($mul) ? 1:$mul) *$value['amount'])?></td>
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