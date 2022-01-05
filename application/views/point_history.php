<?php  if($seg ==null)  $ss = $csc; ?>
<?php  if($seg !=null)  $ss = $csc-$seg; ?>
<div class="container">
	<div class="row">
		<?php $this->load->view("left_menu",array("left"=>"my")); ?>
		<div id="subRight" class="col-md-9">
			<div class="row">
				<div class="col-md-12">
					<div class="padgeName">
						<h2>예치금/포인트</h2>
					</div>
				</div>
			</div>
			
			<div class="con">
				<div class="s_tit_box2 my-3">
					<h4 class="s_tit">
						나의 예치금: <span class="bold clrRed1"><?=number_format($user[0]->deposit)?></span> 원 &nbsp;&nbsp;&nbsp;
						나의 포인트: <span class="bold clrRed1"><?=number_format($user[0]->point)?></span>P</h4>
					</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 my-4 ">
					<a href="/deposit" class="btn btn-charo text-white my-3">예치금 적립</a>
					<a href="/deposit_return" class="btn btn-charo text-white my-3">예치금 환급</a>
					<a href="/deposit_history" class="btn btn-charo text-white my-3">예치금 이용내역</a>
					<a href="/point_history" class="btn btn-yonpu text-white my-3">포인트 이용내역</a>
				</div>
			</div>
			<form method="get" action="">
	          <div class="row my-4 my-3">  
	            <div class="col-md-3 p-right-2">
	            	<label style="display: block;">적립방법</label>
	             	<select name="shType" id="shType" class="form-control w-100 form-control-sm">
	              		<option value="">-전체-</option>
	                	<option value="A" <?=!empty($_GET['shType']) && $_GET['shType']=="A" ? "selected":""?>>회원가입포인트</option>
	                	<option value="B" <?=!empty($_GET['shType']) && $_GET['shType']=="B" ? "selected":""?>>일정금액포인트</option>
	                	<option value="C" <?=!empty($_GET['shType']) && $_GET['shType']=="C" ? "selected":""?>>이벤트포인트</option>
	                	<option value="D" <?=!empty($_GET['shType']) && $_GET['shType']=="D" ? "selected":""?>>쇼핑몰포인트</option>
	                	<option value="E" <?=!empty($_GET['shType']) && $_GET['shType']=="E" ? "selected":""?>>관리자적립</option>
	              	</select>
	            </div>
	            <div class="col-md-2 p-right-2 p-left-2">
	            	<label style="display: block;">구분</label>
	              	<select name="s" id="s" class="form-control w-100 form-control-sm">
	              		<option value="">=전체=</option>
                    	<option value="Y" <?=$this->input->get("s")=="Y" ? "selected":"" ?>>=적립=</option>
                    	<option value="N" <?=$this->input->get("s")=="N" ? "selected":"" ?>>=사용=</option>
	              	</select>
	            </div>
	            <div class="col-md-2 p-right-2 p-left-2">
	                <label style="display: block;">시작일</label>
	                <input type="date" name="starts_date" class="form-control input-sm" 
	                 value="<?=empty($_GET['starts_date']) == 0 ? $_GET['starts_date']:"" ?>" >
	               </div>
	            <div class="col-md-2 p-right-2 p-left-2">
	                 <label style="display: block;">종료일</label>
	                 <input type="date" name="ends_date" class="form-control input-sm" 
	                 value="<?=empty($_GET['ends_date']) == 0 ? $_GET['ends_date']:"" ?>">
	            </div>
	            <div class="col-md-2 p-left-2">
	            	<label style="display: block;">&nbsp;</label>
	              	<input type="submit" class="btn btn-sm btn-yonpu text-white btn-round" value="검색">
	            </div>
	          </div>
	        </form>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table request_deposit_table table-bordered">
							<thead class="thead-jin">
						      <tr>
						      	<th scope="col">No</th>
						        <th scope="col">구분</th>
						        <th scope="col">적립방법</th>
						        <th scope="col">내용</th>
						        <th scope="col">포인트</th>
						        <th scope="col">일자</th>
						      </tr>
						    </thead>
						    <tbody>
						  		<?php if(!empty($history)): ?>
						  			<?php foreach($history as $value): ?>
						  				<tr>
						  					<td><?=$ss?></td>
						  					<td><?=$value->s==0 ? "적립":"사용"?></td>
						  					<td>
						  						<?php if($value->s==0 && $value->type==1): ?>
						  							회원가입포인트
						  						<?php endif; ?>
						  						<?php if($value->s==0 && $value->type==2): ?>
						  							일정금액포인트	
						  						<?php endif; ?>
						  						<?php if($value->s==0 && $value->type==3): ?>
						  							이벤트포인트
						  						<?php endif; ?>
						  						<?php if( $value->s==0 && $value->type==4): ?>
						  							관리자 적립	
						  						<?php endif; ?>
						  						<?php if( $value->s==0 && $value->type==5): ?>
						  							쇼핑몰포인트 적립	
						  						<?php endif; ?>
						  						<?php if($value->s==0 && $value->type==6): ?>
						  							관리자 결제 취소
						  						<?php endif; ?>
						  						<?php if( $value->s==1 && $value->s_type==1): ?>
						  							배송비 적립/사용	
						  						<?php endif; ?>
						  						<?php if( $value->s==1 && $value->s_type==2): ?>
						  							구매비 적립/사용	
						  						<?php endif; ?>
						  						<?php if( $value->s==1 && $value->s_type==3): ?>
						  							리턴비 적립/사용	
						  						<?php endif; ?>
						  						<?php if( $value->s==1 && $value->s_type==4): ?>
						  							추가비 적립/사용	
						  						<?php endif; ?>
						  					</td>
						  					<td></td>
						  					<td><?=number_format($value->point)?></td>
						  					<td><?=$value->created_date?></td>
						  				</tr>
						  				<?php $ss=$ss-1; ?>
						  			<?php endforeach; ?>
						  		<?php endif; ?>
						    </tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="text-center">
	            <?php echo $this->pagination->create_links(); ?>
	         </div>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/deposit.css'); ?>" rel="stylesheet">