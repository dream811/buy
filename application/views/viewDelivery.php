<?php
$labels = ""; 
$price = "";
$error_message  ="";
if($delivery[0]->state==1 || $delivery[0]->state==2 || $delivery[0]->state==11 || $delivery[0]->state==17 || $delivery[0]->state==18  || 
	$delivery[0]->state==16 || $delivery[0]->state==15 || $delivery[0]->state==14 || $delivery[0]->state==23)
{
	$labels =  "배송";
	$price = $delivery[0]->sending_price;
	$error_message = "오류입고를 그대로 받으시겠습니까?";
}
if($delivery[0]->state==4 || $delivery[0]->state==5 || $delivery[0]->state==6 || $delivery[0]->state==7)
{
	$labels =  "구매";
	$price = $delivery[0]->pprice;
	$error_message = "판매자한테 교환 신청 하겠습니까?\\n(오류입고를 그대로 받으실려면 관리자와 상담)";
}
if($delivery[0]->state==19 || $delivery[0]->state==20 || $delivery[0]->state==21 || $delivery[0]->state==24)
{
	$labels =  "리턴";
}
if($delivery[0]->state==30 || $delivery[0]->state==31 || $delivery[0]->state==33)
{
	$labels =  "재고";
}
 
$ss=array();
$ss = json_decode($delivery[0]->content,true);
?>
<?php  $weight = "";?>
<?php if($delivery[0]->addid ==3) $weight = "CBM"; else $weight = "kg";?>
<link href="<?php echo site_url('/template/css/user.css'); ?>?<?=time()?>" rel="stylesheet">
<link href="<?php echo site_url('/template/css/delivery.css'); ?>?<?=time()?>" rel="stylesheet">
<div class="container">
	<div class="row">
		<?php $this->load->view("left_menu",array("left"=>"my")); ?>
		<div id="subRight" class="col-md-9">           
			<div class="padgeName">
				<h2>마이홈</h2>
			</div>
			<div class="con">
				<div class="row">
					<div class="col-md-12 p-left-0">
						<div class="orderTit">
							<h3>주문 정보</h3>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 p-left-0">
						<table class="order_view">
							<colgroup>
							<col width="20%"> 
							<col width="35%"> 
							<col width="20%"> 
							<col width="35%"> 
							</colgroup>
							<tbody>
								<tr> 
									<th>주문번호</th> 
									<td><span class="bold"><?=$delivery[0]->ordernum?></span></td> 
									<th>상태</th> 
									<td><?php 
												if($delivery[0]->payed_checked ==1 || $delivery[0]->payed_send ==1){
													echo  '<p class="myl_nocolor">결제완료</p>';
												}
												else echo '<p class="myl_nocolor">지불전</p>';
											?>	
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 p-left-0">
						<div class="orderTit">
							<h3>센터 정보</h3>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12  p-left-0">
						<table class="order_view" summary="센터, 배송방식 셀로 구성">
							<colgroup>
							<col width="20%"> 
							<col width="35%"> 
							<col width="20%"> 
							<col width="35%"> 
							</colgroup>
							<tbody>
								<tr> 
									<th>센터</th> 
									<td><?=$delivery[0]->area_name?></td> 
									<th>수입방식</th> 
									<td><?=$delivery[0]->method?></td> 
								</tr>
								</tbody><tbody>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12  p-left-0">
						<div class="orderTit">
							<h3>수취인 정보</h3>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12  p-left-0">
						<div class="order_table">
							<table class="order_view" 
								summary="주소검색, 우편번호, 주소, 상세주소, 수취인 이름(한글), 수취인 이름(영문), 전화번호, 핸드폰번호, 용도, 주민번호, 통관번호 셀로 구성"> 
								<colgroup>
									<col width="20%"> 
									<col width="35%"> 
									<col width="20%"> 
									<col width="35%"> 
								</colgroup>    
								<tbody>
									<tr> 
										<th>수취인 주소</th> 
										<td colspan="3"><?=$delivery[0]->post_number?> <?=$delivery[0]->address?> <?=$delivery[0]->detail_address?></td> 
									</tr>
									<tr> 
										<th>수취인 이름(한글)</th> 
										<td><?=$delivery[0]->billing_krname?></td> 
										<th class="thb">수취인 이름(영문)</th> 
										<td><?=$delivery[0]->billing_name?>
										</td> 
									</tr>
									<tr> 
										<th>연락처</th>
										<td><?=$delivery[0]->phone_number?></td> 
										<th>받는 사람 정보</th> 
										<td>
											<?=$delivery[0]->method?> <?=$delivery[0]->person_unique_content?>
										</td> 
									</tr>
									<tr> 
										<th>배송 요청 사항</th> 
										<td colspan="3"><?=$delivery[0]->request_detail?></td> 
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php if(	$delivery[0]->state ==1  ||  
							$delivery[0]->state ==2  || 
							$delivery[0]->state ==4  ||  
							$delivery[0]->state ==5  || 
							$delivery[0]->state ==6  || 
							$delivery[0]->state ==7  || 
							$delivery[0]->state ==11): ?>
				<div class="row my-4 my-3">
					<div class="col-md-12">
						<button class="btn btn-warning btn-sm btn-round" data-toggle="modal" data-target="#dele">수정</button>
					</div>
				</div>
				<?php endif; ?>
				<div class="row my-15">
					<div class="col-md-12  p-left-0">
						<div class="orderTit">
							<h3>상품 정보</h3>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12  p-left-0">
						<form id="frmproducts">
							<div class="table-responsive">
								<table class="table table-dark table-bordered">
									<colgroup>
										<col>
										<col width="160">
										<col>
									</colgroup>
									<thead>
								      <tr style="border-right: 1px solid #e2e2e2;">
								        <th scope="col">No</th>
								        <th scope="col">상품 목록</th>
								        <th scope="col"></th>
								      </tr>
								    </thead>
								    <tbody class="product_tbody">
								    	<?php $error = ""; ?>
								    	
								    	<?php if(!empty($products)): ?>
								    		
								    		<?php foreach($products  as $key=>$value): ?>
								    			<?php $temp_nanum = 0; ?>
								    			<?php if($value->step ==102): ?>
								    				<?php $error = 1;  ?>
								    			<?php endif; ?>
								    			<?php if($delivery[0]->combine !=-1): ?>
								    					<?php $temp_nanum = 1; ?>
								    			<?php endif; ?>
								    			<?php if($delivery[0]->combine ==-1 && $delivery[0]->ordernum == $value->new_order): ?>
								    					<?php $temp_nanum = 1; ?>
								    			<?php endif; ?>
								    			<?php if($value->step ==103): ?>
								    			<?php $temp_nanum= 0; ?>
								    			<?php endif ?>
								    			<tr <?php if($temp_nanum ==0): ?>class="bg-secondary" <?php endif; ?>>
								    				<td><p style="margin-top: 100px;">
								    					<?=$value->serial?>
								    					<?php if($temp_nanum ==1): ?>
								    					<input type="checkbox" name="product_et[]" class="product_et" 
								    					<?php if($value->step ==102): ?><?php echo " checked "?>  <?php endif; ?> value="<?=$value->id?>">	
								    					<?php endif; ?>
								    					</p>
								    				</td>
								    				<td class="mid"><img src="<?=$value->image?>" width="150"></td>
								    				<td style="padding: 0 !important">
								    					<table class="table viewd_table">
								    						<colgroup>
								    							<col width="185px">
								    							<col width="*">
								    						</colgroup>
								    						<tr>
								    							<th class="b-t-0 b-r-1">TRACKING NO</th>
								    							<td class="b-none" style="text-align: left !important">
								    								<?=!empty($value->trackingNumber) ? $value->trackingNumber : '&nbsp;'?>
								    							</td>
								    						</tr>
								    						<tr class="">
								    							<th class="b-r-1">오더번호 NO</th>
								    							<td style="text-align: left !important">
								    								<?=!empty($value->order_number) ? $value->order_number : "&nbsp;"?>
								    							</td>
								    						</tr>
								    						<tr class="">
								    							<th class="b-r-1">입고상태</th>
								    							<td style="text-align: left !important">
								    								<?php 
									    							if($value->step==0) echo '입고대기';
									    							if($value->step==101) echo '입고완료';
									    							if($value->step==102) echo '오류입고';
									    							if($value->step==103) echo '노데이타';
									    						?>
									    						<?php if($delivery[0]->combine ==-1): ?>
									    							<?php if($value->combine == 1): ?><span class="text-danger">묶음배송</span><?php endif; ?>
										    						<?php if($value->combine == 2): ?><span class="text-danger">나눔배송</span><?php endif; ?>
										    						<?php if($value->type == 4): ?>
										    						<span class="text-danger">리턴신청</span> 
										    						<?php endif; ?>
										    						<?php if($value->combine == 4): ?><span class="text-danger">신청취소</span><?php endif; ?>
										    						<?php if(!empty($value->ordernum)): ?>
										    						<a  class="text-danger" href="<?=base_url()?>view/delivery/<?=$value->drid?>">
										    							(<?php echo $value->new_order; ?>)</a>
										    						<?php endif; ?>
									    						<?php endif; ?>
									    						<?php if($delivery[0]->combine !=-1): ?>
									    						<?php if($value->combine == 1): ?>
									    							<span class="text-danger">묶음배송</span>
									    						<?php endif; ?>
										    					<?php if($value->combine == 2): ?>
										    						<span class="text-danger">나눔배송</span>
										    					<?php endif; ?>
										    					<?php if($value->type == 4): ?>
										    						<span class="text-danger">리턴신청</span>
										    					<?php endif; ?>
										    					<?php if($value->combine == 4): ?><span class="text-danger">신청취소</span><?php endif; ?>
										    						<?php if(!empty($value->ordernum)): ?>
										    						<a  class="text-danger" 
										    						href="<?=base_url()?>view/delivery/<?=$value->rid?>">
										    						(<?php  echo $value->ordernum;?>)</a>
										    						<?php endif; ?>
									    						<?php endif; ?>
								    							</td>
								    						</tr>
								    						<tr class="">
								    							<th class="b-r-1">영문/중문/한문(품목)</th>
								    							<td style="text-align: left !important">
								    								<a href="<?=$value->url?>" target="_blank" class='text-danger'>
											    						<?=$value->productName?>/<?=!empty($value->chn_subject) ? $value->chn_subject : ""?>/<?=!empty($value->kr_subject) ? $value->kr_subject : ""?>
											    					</a>
								    							</td>
								    						</tr>
								    						<tr class="">
								    							<th class="b-r-1 mid">옵션</th>
								    							<td style="text-align: left !important">
								    								<?=$value->size?>
								    								<?=!empty($value->color) ? ",색상 : ".$value->color: ""?>
								    							</td>
								    						</tr>
								    						<tr class="">
								    							<th class="b-r-1">단가 * 수량</th>
								    							<td style="text-align: left !important">
								    								<?=$value->unitPrice?> * <?=$value->count?>
								    							</td>
								    						</tr>
								    					</table>
								    				</td>
								    			</tr>

								    		<?php endforeach; ?>
								    	<?php endif; ?>
								    </tbody>
								</table>
								<?php if(($delivery[0]->state ==7 || $delivery[0]->state ==11) && $error !=1): ?>	
									<a href="javascript:void(0);" class="btn btn-danger text-white my-3 btn-round btn-sm" 
									data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중" onclick="returnRequest(this)">리턴신청</a>
									<input type="file" name="returns" id="fileInput" style="display: inline-block;">
								<?php endif;?>
								<?php if(	$error ==1 && $delivery[0]->state !=13 && 
											$delivery[0]->state !=13 && 
											$delivery[0]->state !=17 && 
											$delivery[0]->state !=18 && 
											$delivery[0]->state !=19 && 
											$delivery[0]->state !=20 && 
											$delivery[0]->state !=21 && 
											$delivery[0]->state !=24 ): ?>	
									<a href="javascript:void(0);"   class="btn btn-warning text-white my-3 btn-round btn-sm" 
									data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중" onclick="submitError(this)">오류확인</a>
									<a href="javascript:void(0);" class="btn btn-danger text-white my-3 btn-round btn-sm" 
									data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중" onclick="returnRequest(this)">리턴신청</a>
									<input type="file" name="returns" id="fileInput" style="display: inline-block;">
								<?php endif;?>
							</div>
						</form>
					</div>
				<?php if($delivery[0]->state !=4 && $delivery[0]->state !=5 && $delivery[0]->state !=6): ?>	
				<div class="row">
					<div class="col-md-12  p-left-0">
						<div class="orderTit">
							<h3>금액 정보</h3>
						</div>
					</div>
				</div>
				<div class="row m-rr-15 border">
					<div class="col-md-3  p-left-0">
						<p class="myl">중국 내 배송비	</p>
					</div>
					<div class="col-md-3">
						<p class="myl_nocolor">¥<?=!empty($delivery[0]->cur_send) ? $delivery[0]->cur_send:"0.00"?></p>
					</div>
					<div class="col-md-3">
						<p class="myl">총 수량 / 상품 총액</p>
					</div>
					<div class="col-md-3 p-right-0">
						<p class="myl_nocolor"><span class="text-primary bold"><?=$delivery[0]->ppcount?></span> / <span class="text-danger bold">¥<?=number_format($delivery[0]->pprice,2)?></span></p>
					</div>
				</div>
			<?php endif; ?>
				<div class="row my-15">
					<div class="col-md-12  p-left-0">
						<div class="orderTit">
							<h3>요청 사항</h3>
						</div>
					</div>
				</div>
				<div class="row"> 
					<div class="col-md-12  p-left-0">
						<table class="order_write">
							<colgroup>
								<col width="15%"><col width="*">
							</colgroup>
							<tbody>
								<?php if(!empty($service_header)): ?>
								<?php foreach($service_header as $vas): ?>
								<tr>
									<th><?=$vas->name?></th>
									<td class="vm_box">
									<?php if(!empty($aa[$vas->id])): ?>
										<?php foreach($aa[$vas->id] as $chd): ?>
											<div class="services_header">
												<label>
													<input type="checkbox" class="input_chk" name="EtcDlvr" disabled 
													value="<?=$chd['id']?>" 
													<?php if(isset($ss[$chd['id']]) && $ss[$chd['id']]>=0) echo "checked"; ?>><?=$chd['name']?>
													<span style="color:#d30009;font-weight:bold;">
														(<?= $chd['price'] == 0 ? '무료':number_format($chd['price']).'원' ?>)
													</span>
												</label>
												<label>-<?=$chd['description']?></label>
											</div>
										<?php endforeach; ?>
									<?php endif; ?>
									</td>
								</tr>
								<?php endforeach; ?>
								<?php endif; ?>
								<tr>
									<th>물류 요청사항	</th>
									<td>
										<input type="text" name="REQ_2" id="REQ_2" maxlength="100" class="input_txt2 full form-control" value="<?=$delivery[0]->logistics_request?>" readonly>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			<?php if($delivery[0]->state!=1 && $delivery[0]->state!=2 && $delivery[0]->state!=4): ?>
				<div class="row my-15">
					<div class="col-md-12  p-left-0">
						<div class="orderTit">
							<h3>결제 정보</h3>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12  p-left-0">
						<table class="order_write">
							<colgroup>
								<col width="15%"><col width="*%">
							</colgroup>
							<tr>
								<th>무게정보</th> 
								<td colspan="3">
									<?php 
										$rr = !empty($delivery[0]->real_weight) ? $delivery[0]->real_weight :0;
										$rr1 = !empty($delivery[0]->mem_wt) ? $delivery[0]->mem_wt:0
									?>
									실무게: <span class="bold"><?=$rr?></span> <?=$weight?>&nbsp;&nbsp;
									부피무게: <?=$rr1 ?> kg (<?=$delivery[0]->width?> * <?=$delivery[0]->height?> * <?=$delivery[0]->length?> cm)&nbsp;&nbsp;
									적용무게: <span class="bold"><?=$rr > $rr1 ? $rr : $rr1 ?> <?=$weight?></span>
								</td>
							</tr>
						<?php 
							$delivery[0]->purchase_price = str_replace(",", "", $delivery[0]->purchase_price);
							if($delivery[0]->purchase_price >0): ?>
							<?php $rr = explode("|", $delivery[0]->pur_fee); ?>
							<?php 
								if(!empty($delivery[0]->cur_send))
									$sss = str_replace(",", "", $delivery[0]->cur_send);
								else
									$sss=0;
								$rat = (int)$delivery[0]->purchase_price-(int)$sss*$rr[2]- (int)$rr[1];
							?> 
							<tr>
								<th>구매비용</th>	
								<td colspan="3" style="line-height:180%;">		
									<p class="clrBoth"></p><label class="font-weight-bold" style="width: 150px">-구매비용 금액</label>
									<label><?=number_format($delivery[0]->purchase_price)?> 원 (<?=$delivery[0]->payed_checked==1 ? "결제완료":"결제대기"?>)</label><br>
									<label style="width:150px;">- 구매비 </label> 
									<label><?=number_format($rr[1])?> 원</label><br>
									<label style="width:150px;">- 구매 수수료 </label> 
									<label ><?=number_format($rat) ?> 원</label><br>
									<label style="width:150px;">- 현지 배송비</label>
									<label ><?=number_format($rr[2]*$sss)?> 원</label><br>
								</td>
							</tr>
						<?php endif; ?>
						<?php if(!empty($delivery[0]->sending_price)):
							$del_price = str_replace(",", "", $delivery[0]->sending_price);
						 ?>
							<?php foreach($ss as $sv): ?>
							<?php if(empty($sv)) continue; ?>
							<?php $del_price = $del_price-$sv;?>
							<?php endforeach; ?>
							<tr>	
								<th>배송비용</th>	
								<td colspan="3" style="line-height:180%;">		
									<p class="clrBoth"></p>
									<label class="font-weight-bold" style="width: 150px">- 배송비용 금액</label>
									<label><?=$delivery[0]->sending_price?> 원 (<?=$delivery[0]->payed_send==1 ? "결제완료":"결제대기"?>)</label><br>
									<label style="width:150px;">- 배송비</label> 
									<label ><?=number_format($del_price)?> 원</label><br>
									<?php if(!empty($ss)): ?>
									<?php foreach($ss as $ssv_key=>$ssv): ?>
									<?php if(empty($ssv) ) continue; ?>
									<label style="width:150px;">- <?=$aa_value[$ssv_key]?></label> 
									<label ><?=number_format($ssv) ?> 원</label><br>	
									<?php endforeach; ?>
									<?php endif; ?>					
								</td>
							</tr>
						<?php endif; ?>
						<?php if(!empty($delivery[0]->return_price)):
							$del_price = str_replace(",", "", $delivery[0]->sending_price);
						 ?>
							<?php foreach($ss as $sv): ?>
							<?php $del_price = $del_price-$sv;?>
							<?php endforeach; ?>
							<tr>	
								<th>리턴비용</th>	
								<td colspan="3" style="line-height:180%;">		
									<p class="clrBoth"></p>
									<label class="font-weight-bold" style="width: 150px">- 리턴비용 금액</label>
									<label><?=number_format(str_replace(",", "", $delivery[0]->return_price))?> 원 (<?=$delivery[0]->return_check==1 ? "결제완료":"결제대기"?>)</label><br>
									<label style="width:150px;">- 리턴비</label> 
									<label ><?=number_format(str_replace(",", "", $delivery[0]->return_price)-str_replace(",", "", $delivery[0]->rfee))?>원</label><br>		
									<label style="width:150px;">- 리턴수수료</label> 
									<label ><?=number_format(str_replace(",", "", $delivery[0]->rfee))?>원</label><br>			
								</td>
							</tr>
						<?php endif; ?>
						<?php if(!empty($adding)): ?>	
							<tr>	
								<th>추가결제비용</th>	<td colspan="3" style="line-height:180%;">		
									<p class="clrBoth"></p>
									<label class="font-weight-bold" style="width: 150px">- 추가결제비용 금액</label>
									<label> <?=$adding[0]->add_price?> 원 (<?=$adding[0]->add_check==0 ? "결제완료":"결제대기"?>)</label><br>
									<?php if($adding[0]->gwan !=0): ?>
									<label style="width:150px;">- 관/부가세</label> 
									<label ><?=$adding[0]->gwan?> 원</label><br>
									<?php endif; ?>
									<?php if($adding[0]->pegi !=0): ?>
									<label style="width:150px;">- 폐기수수료</label> 
									<label ><?=number_format($adding[0]->pegi)?> 원</label><br>
									<?php endif; ?>
									<?php if($adding[0]->check_custom !=0): ?>
									<label style="width:150px;">- 검역수수료</label> 
									<label ><?=$adding[0]->check_custom?> 원</label><br>
									<?php endif; ?>
									<?php if($adding[0]->cart_bunhal !=0): ?>
									<label style="width:150px;">- 카툰분할 수 신고/BL 분할</label> 
									<label ><?=$adding[0]->cart_bunhal?> 원</label><br>
									<?php endif; ?>
									<?php if($adding[0]->gwatae !=0): ?>
									<label style="width:150px;">- 과태료</label> 
									<label ><?=$adding[0]->gwatae?> 원</label><br>
									<?php endif; ?>	
									<?php if($adding[0]->add_fee !=0): ?>
									<label style="width:150px;">- 기타 추가비용</label> 
									<label ><?=$adding[0]->add_fee?> 원</label><br>
									<?php endif; ?>	
								</td>
							</tr>
						<?php endif; ?>	
						</table>
					</div>
				</div>
			<?php endif; ?>
				<div class="row my-15">
					<div class="col-md-12  p-left-0">
						<div class="orderTit">
							<h3><?=$pageTitle?> 안내사항</h3>
						</div>
					</div>
				</div>
				<div class="row my-4">
					<div class="col-md-12 text-center">
						<?php if($delivery[0]->state ==1 || $delivery[0]->state ==4): ?>
							<a href="/editDelivery/<?=$delivery[0]->rid?>" class="btn btn-warning btn-sm btn-round">수정</a>
							<a href="javascript:deleteOrder();" class="btn btn-danger btn-sm btn-round">주문삭제</a>
						<?php endif; ?>
						<a href="/mypage" class="btn btn-default btn-sm btn-round">목록</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<form method="post" id="deliverForm">
	<input type="hidden" name="did" value="<?=$delivery[0]->id?>">
</form>	
<div class="modal fade" id="dele" tabindex="-1" role="dialog" aria-labelledby="dele" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?=base_url()?>updateBilling" method="post">
    	<input type="hidden" name="id" value="<?=$delivery[0]->rid?>">
    	<div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title">수취인정보</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>	
	      	<div class="modal-body">
	        	<div class="order_table" style="clear: both;">
					<table class="table table-bordered" summary="주소검색, 우편번호, 주소, 상세주소, 수취인 이름(한글), 수취인 이름(영문), 전화번호, 핸드폰번호, 용도, 주민번호, 통관번호 셀로 구성"> 
						<tbody>
							<tr>
								<th scope="row" class="text-center mid">받는 사람</th>
								<td>
									<div class="row">
										<div class="col-md-8 p-right-0">
											한글 <input type="text" name="ADRS_KR" id="ADRS_KR" maxlength="60" class="input_txt2 ipt_type1 w-80" required="" value="<?=$delivery[0]->billing_krname?>">
										</div>
										<div class="col-md-4 p-left-0">
											<a class="btn btn-warning btn-round btn-sm" href="javascript:fnPopMemAddr();"><span>주소록 가져오기</span></a> 
										</div>
									</div>
									<div class="row my-10">
										<div class="col-md-8 p-right-0">
											영문 <input type="text" name="ADRS_EN" id="ADRS_EN" maxlength="60" class="input_txt2 ipt_type1 w-80" required="" value="<?=$delivery[0]->billing_name?>">
										</div>	
									</div>
									<div class="my-10 row">
										<div class="col-md-12">
											*사업자 영문명은 반드시 고쳐주세요 (한글발음나는대로 입력시 통관지연)
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row" class="text-center mid">받는 사람 정보</th>
								<td>
									<div class="form-row">
										<div class="form-check form-check-inline">
											<label><input type="radio" class="form-check-input vm" name="RRN_CD" id="RRN_CD" 
												value="1" <?=$delivery[0]->person_num==1 ? "checked":""?>> 개인통관고유부호 (추천)</label>
										</div>
										<div class="form-check form-check-inline">
											<label><input type="radio" class="form-check-input vm " name="RRN_CD" id="RRN_CD" value="3"
												<?=$delivery[0]->person_num==3 ? "checked":""?>> 사업자등록번호</label>
										</div>
										<input type="text" name="RRN_NO" id="RRN_NO" maxlength="20" class="input_txt2 m_num" 
											required="" value="<?=$delivery[0]->person_unique_content?>">
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row" class="text-center mid">주소 및 연락처</th>
								<td>
									<label style="width:70px;">연락처</label>
									<?php 
									$p  = explode("-", $delivery[0]->phone_number);
									?>
									<input type="text" name="MOB_NO1" id="MOB_NO1" maxlength="4" class="input_txt2 hp mb-2" 
									value="<?=!empty($p[0]) ? $p[0]:""?>" title="전화번호 첫자리" required=""> -
									<input type="text" name="MOB_NO2" id="MOB_NO2" maxlength="4" class="input_txt2 hp mb-2" 
									value="<?=!empty($p[1]) ? $p[1]:""?>" title="전화번호 중간자리" required=""> -
									<input type="text" name="MOB_NO3" id="MOB_NO3" maxlength="4" class="input_txt2 hp mb-2" 
									value="<?=!empty($p[2]) ? $p[1]:""?>" title="전화번호 마지막자리" required="">
									<div class="row my-10" >
										<label class="height32" style="width:70px;">우편번호</label> 
										<input type="text" name="ZIP" id="ZIP" maxlength="8" class="input_txt2" 
										value="<?=$delivery[0]->post_number?>" required="" readonly="">
										<a class="btn_small btn btn-sm btn-warning btn-round"  href="javascript:openDaumPostcode();">
											<span>우편번호 검색</span>
										</a>
									</div>
									<div class="row my-10">
										<label class="height32" style="width:70px;">주소</label>
										<input type="text" name="ADDR_1" id="ADDR_1" maxlength="100" class="input_txt2 adr" 
											value="<?=$delivery[0]->address?>" required="" readonly="">
									</div>
									<input type="hidden" name="ADDR_1_EN" id="ADDR_1_EN" value="">
									<input type="hidden" name="ADDR_2_EN" id="ADDR_2_EN" value="">
									<div class="row my-10">
										<label class="height32" style="width:70px;">상세주소</label>
										<input type="text" name="ADDR_2" id="ADDR_2" maxlength="100" class="input_txt2 adr" 
											value="<?=$delivery[0]->detail_address?>">
									</div>
									<div class="row">
										<div class="col-sm-12" style="padding-top: 10px">
											* 도로명 주소를 써주세요. 지번 주소 기재 시 통관/세관에서 오류로 분류시켜 통관지연이 될 수 있습니다
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row" class="text-center mid">배송 요청 사항</th>
								<td >
									<div class="form-group">
										<select class="form-control" id="exampleFormControlSelect1" onchange="fnReqValGet(this.value);">
									      <option>직접기재</option>
									      <option value="배송 전 연락 바랍니다">배송 전 연락 바랍니다</option>
									      <option value="부재시 경비실에 맡겨주세요">부재시 경비실에 맡겨주세요</option>
									      <option value="부재시 집앞에 놔주세요">부재시 집앞에 놔주세요</option>
									      <option value="택배함에  맡겨주세요">택배함에  맡겨주세요</option>
									    </select>
									</div>
									<div class="form-group">
										<input type="text" name="REQ_1" id="REQ_1" maxlength="100" class="input_txt2 full form-control"
										 value="<?=$delivery[0]->request_detail?>">
										<p style="padding-top: 10px">* 국내 배송기사 분께 전달하고자 하는 요청사항을 남겨주세요(예: 부재 시 휴대폰으로 연락주세요.)</p>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-warning btn-sm btn-round" data-dismiss="modal">닫기</button>
			    <input type="submit" class="btn btn-danger btn-round btn-sm" value="저장">
			 </div>
	    </div>
    </form>
  </div>
</div>

<script type="text/javascript">
	function deleteOrder() {
		if (confirm("주문을 삭제 하시겠습니까?\n삭제시 복구가 불가능합니다.")) { 
			$("#deliverForm").attr("method", "post").attr("action", "/deletesO");
			$("#deliverForm").submit();
		}
	}
	function openDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
				if ( data.userSelectedType == "R" ) {
					document.getElementById('ZIP').value = data.zonecode;
					document.getElementById('ADDR_1').value = data.roadAddress;
					document.getElementById('ADDR_2').focus();
					document.getElementById('ADDR_1_EN').value = data.addressEnglish;
				} else {
					alert("지번주소가 아닌 도로명주소를 선택하십시오.");
				}
            }
        }).open();
    }
    function fnMemAddrCfm(aAddr) {
		var aMemAddr = aAddr.split("|");
		var aMobNo = "";
		aMobNo = aMemAddr[5].split("-");

		$("input[name='ADRS_KR']").val( aMemAddr[0] );
		$("input[name='ADRS_EN']").val( aMemAddr[1] );
		$("input[name='ZIP']").val( aMemAddr[2] );
		$("input[name='ADDR_1']").val( aMemAddr[3] );
		$("input[name='ADDR_2']").val( aMemAddr[4] );
		$("input[name='MOB_NO1']").val( aMobNo[0] );
		$("input[name='MOB_NO2']").val( aMobNo[1] );``
		$("input[name='MOB_NO3']").val( aMobNo[2] );
		$("input[name='RRN_CD']:radio[value='" + aMemAddr[6] + "']").prop("checked", true);
		$("input[name='RRN_NO']").val( aMemAddr[7]);
		$("input[name='ADDR_1_EN']").val( aMemAddr[8] );
		$("input[name='ADDR_2_EN']").val( aMemAddr[9] );
	}
	function fnReqValGet(sVal) {
		$("input[name='REQ_1']").val( sVal );
	}

	function returnRequest(obj){
		var $this = $(obj);
		if(fnSelBoxCnt($(".product_et")) <=0){
			fnMsgFcs($(".product_tbody"), '리턴할 상품을 선택해주세요');
			return;
		}
		var con = confirm("이 상품을 리턴하시겠습니까?");
		if(con){
			var formData = new FormData(document.getElementById("frmproducts"));
			$.ajax({
		        type:'POST',
		        url: "/returnRequest",
		        data:formData,
		        dataType: "json",
		        async: false,
				processData: false,
				contentType: false,
				beforeSend: function() {
					$this.button("loading");
			    },
		        success:function(data){            	
		           location.href = "<?=base_url()?>mypage?step=19";
		        },
		         error: function(jqXHR, exception) {
		         	$this.button("reset");
		        }
		    }).done(function(data) {
			  	$this.button("reset");
			});
		}
	}

	function submitError(obj){
		var $this = $(obj);
		
		var con = confirm("<?=$error_message?>");
		if(con){
			$.ajax({
		        type:'POST',
		        url: "/submitError",
		        data:{ordernum:<?=$delivery[0]->id?>},
		        dataType: "json",
				beforeSend: function() {
					$this.button("loading");
			    },
		        success:function(data){            	
		           if(data.result == 0) alert("오더넘버가 비였습니다.");
		           if(data.result == 1)  location.href="/mypage?step=13";
		           if(data.result == -1) alert("서버오류");
		        },
		         error: function(jqXHR, exception) {
		         	$this.button("reset");
		        }
		    }).done(function(data) {
			  	$this.button("reset");
			});
		}	
	}
</script>