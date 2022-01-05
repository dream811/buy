<?php  if($seg ==null)  $ss = $csc; ?>
<?php  if($seg !=null)  $ss = $csc-$seg; ?>
<div class="container">
	<div class="row">
		<?php $data['title']="예치금/포인트" ?>
		<?php $this->load->view("my_header",$data); ?>
		<div id="subRight">
			<div class="row pt-10 pb-10">
				<div class="col-xs-6">
					<p>나의 예치금: <span class="font-weight-bold"><?=number_format($user[0]->deposit)?></span> 원</p>
				</div>
				<div class="col-xs-6">
					<p>나의 포인트: <span class="font-weight-bold"><?=number_format($user[0]->point)?></span> P</p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 p-right-3">
					<a href="/deposit" class="btn btn-charo  btn-block">예치금 적립</a>	
				</div>
				<div class="col-xs-6 p-left-3">
					<a href="deposit_return" class="btn  btn-charo btn-block">예치금 환급</a>
				</div>
			</div>
			<div class="row pt-5">
				<div class="col-xs-6 p-right-3">
					<a href="/deposit_history" class="btn btn-charo btn-block">예치금 이용내역</a>
				</div>
				<div class="col-xs-6 p-left-3">
					<a href="/point_history" class="btn btn-yonpu btn-block">포인트 이용내역</a>
				</div>
			</div>
			<div class="p-left-3 p-right-3 mt-10">
				<form method="get" action="<?=base_url()?>point_history"> 
			        <div class="row mt-10">  
			        	<div class="col-xs-3">
			        		<label class="pt-10">적립방법</label>
			        	</div>
			        	<div class="col-xs-9">
			        		<select name="shType" id="shType" class="form-control">
			              		<option value="">-전체-</option>
			                	<option value="A" <?=!empty($_GET['shType']) && $_GET['shType']=="A" ? "selected":""?>>회원가입포인트</option>
			                	<option value="B" <?=!empty($_GET['shType']) && $_GET['shType']=="B" ? "selected":""?>>일정금액포인트</option>
			                	<option value="C" <?=!empty($_GET['shType']) && $_GET['shType']=="C" ? "selected":""?>>이벤트포인트</option>
			                	<option value="D" <?=!empty($_GET['shType']) && $_GET['shType']=="D" ? "selected":""?>>쇼핑몰포인트</option>
			                	<option value="E" <?=!empty($_GET['shType']) && $_GET['shType']=="E" ? "selected":""?>>관리자적립</option>
			              	</select>
			        	</div>    
			        </div>
			        <div class="row">
			            <div class="col-xs-3">
			            	<label class="pt-10">구분</label>
			            </div>
			            <div class="col-xs-9">
			              	<select name="s" id="s" class="form-control">
			              		<option value="">=전체=</option>
		                    	<option value="Y" <?=$this->input->get("s")=="Y" ? "selected":"" ?>>=적립=</option>
		                    	<option value="N" <?=$this->input->get("s")=="N" ? "selected":"" ?>>=사용=</option>
			              	</select>
			            </div>
			         </div> 
			        <div class ="row mt-10">   
			            <div class="col-xs-5 p-right-3">
			                <input type="date" name="starts_date" class="form-control input-sm" 
			                 value="<?=empty($_GET['starts_date']) == 0 ? $_GET['starts_date']:"" ?>" >
			               </div>
			            <div class="col-xs-5 p-left-3 p-right-3">
			                <input type="date" name="ends_date" class="form-control input-sm" 
			                 value="<?=empty($_GET['ends_date']) == 0 ? $_GET['ends_date']:"" ?>">
			            </div>
			            <div class="col-xs-2 p-left-3">
			            	<input type="submit" class="btn-block btn btn-sm btn-round btn-yonpu" value="검색">
			            </div>
			        </div>
			    </form>
			</div>
			<div class="row mt-10">
				<div class="col-xs-12">
					<div class="table-responsive border-b">
						<table class="table request_deposit_table table-bordered">
							<thead class="thead-jin">
						      <tr>
						      	<th scope="col" class="mid">No</th>
						        <th scope="col" class="tmid">구분</th>
						        <th scope="col" class="mid">적립방법</th>
						        <th scope="col" class="mid">포인트</th>
						        <th scope="col" class="mid">일자</th>
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
						  					<td><?=number_format($value->point)?></td>
						  					<td><?=date_format(date_create($value->created_date),"Y-m-d")?></td>
						  				</tr>
						  				<?php $ss=$ss-1; ?>
						  			<?php endforeach; ?>
						  		<?php endif; ?>
						    </tbody>
						</table>
					</div>
					<div class="text-center">
						<?php echo $this->pagination->create_links(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/deposit.css'); ?>" rel="stylesheet">