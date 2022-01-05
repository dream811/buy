<?php 
if(empty($delivery)) return;
$services_ss=array();
$services_ss = json_decode($delivery[0]->content,true);
?>
<?php $weight = "";

if($delivery[0]->Did ==3)
	$weight = "CBM";
else
	$weight  ="kg";

?>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
         	<div class="conBox">
			   <div id="mid-col">
			      <div class="box">
			         <div class="box-container corners02">
			            <!-- Begin 검색 폼 -->
			            <div class="con">
			               <form name="frmSearch" id="frmSearch" method="get" action=""> 
			               </form>
			               <div class="step_box" id="AreaStep1">
			                  <p class="clrBoth"></p>
			                  <div class="step_box">
			                     <div class="orderTit">
			                        <h3>주문 정보</h3>
			                     </div>
			                  </div>
			                  <div class="order_table">
			                     <table class="order_view" summary="센터, 배송방식 셀로 구성">
			                        <colgroup>
			                           <col width="15%">
			                           <col width="35%">
			                           <col width="15%">
			                           <col width="35%">
			                        </colgroup>
			                        <tbody>
			                           <tr>
			                              	<th>주문번호</th>
			                              	<td><?=$delivery[0]->ordernum?></td>
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
			                        <tbody>
			                        </tbody>
			                     </table>
			                  </div>
			               </div>
			               <div class="step_box" id="AreaStep1">
			                  <p class="clrBoth"></p>
			                  <div class="step_box">
			                     <div class="orderTit">
			                        <h3>센터 정보</h3>
			                     </div>
			                  </div>
			                  <div class="order_table">
			                     <table class="order_view" summary="센터, 배송방식 셀로 구성">
			                        <colgroup>
			                           <col width="15%">
			                           <col width="35%">
			                           <col width="15%">
			                           <col width="35%">
			                        </colgroup>
			                        <tbody>
			                           <tr>
			                              <th>센터</th>
			                              <td><?=$delivery[0]->area_name?></td>
			                              <th>수입방식</th>
			                              <td><?=$delivery[0]->Sname?></td>
			                           </tr>
			                        </tbody>
			                        <tbody>
			                        </tbody>
			                     </table>
			                  </div>
			               </div>
			               <div class="step_box" id="AreaStep2">
			                  <p class="clrBoth pHt20"></p>
			                  <div class="step_box">
			                     <div class="orderTit">
			                        <h3>수취인 정보</h3>
			                     </div>
			                  </div>
			                  <div class="order_table">
			                     <table class="order_view" summary="주소검색, 우편번호, 주소, 상세주소, 수취인 이름(한글), 수취인 이름(영문), 전화번호, 핸드폰번호, 용도, 주민번호, 통관번호 셀로 구성">
			                        <colgroup>
			                           <col width="15%">
			                           <col width="35%">
			                           <col width="15%">
			                           <col width="35%">
			                        </colgroup>
			                        <tbody>
			                           <tr>
			                              <th>수취인 주소</th>
			                              <td colspan="3"><?=$delivery[0]->post_number?> <?=$delivery[0]->address?> <?=$delivery[0]->detail_address?>
			                              </td>
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
			                                 <?=$delivery[0]->Sname?>
			                                 <?=$delivery[0]->person_unique_content?>
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
			               <div class="row my-4" style="text-align:center">
			                  <button type="button" class="btn btn-primary" onclick="javascript:fnAdrsMod('<?=$delivery[0]->id?>');">수정</button>
			               </div>
			               <div class="step_box" id="AreaStep3">
			                  <p class="clrBoth pHt20"></p>
			                  <div class="step_box">
			                     <div class="orderTit">
			                        <h3>상품 정보</h3>
			                     </div>
			                  </div>
			                  <div class="order_table">
			                     <table class="order_view" summary="상품 신청내역">
			                        <caption></caption>
			                        <colgroup>
			                           <col width="13%">
			                           <col width="17%">
			                           <col width="*">
			                        </colgroup>
			                        <tbody>
			                           <tr>
			                              <th><label><input type="checkbox" name="chkPROAll" id="chkPROAll" class="vm" value="Y" onclick="fnCkBoxAllSel( 'frmSearch', 'chkPROAll', 'chkPRO_SEQ' );"> No</label></th>
			                              <th colspan="2">상품 목록</th>
			                           </tr>
			                           	<?php if(!empty($products)): ?>
			                           	<?php $serial_product = 1; ?>
			                           	<?php foreach($products as $key=>$value):  ?>
		                           		<?php $temp_nanum = 0; ?>
		                           		<?php if($delivery[0]->combine !=-1): ?>
						    			<?php $temp_nanum = 1; ?>
						    			<?php endif; ?>
						    			<?php if($delivery[0]->combine ==-1 && $delivery[0]->ordernum == $value->new_order): ?>
						    			<?php $temp_nanum = 1; ?>
						    			<?php endif; ?>
			                           		<tr <?php if($temp_nanum ==0): ?>class="table-active"<?php endif; ?>>
			                              <td>
			                                 <label><?=$value->serial?></label><br>
			                                 <span class="whGraBtn">
			                                 <button type="button" class="btn btn-primary <?php if($temp_nanum ==0): ?>disabled<?php endif; ?>" 
			                                 onclick="fnProAdd('M', '<?=$value->id?>', '2');">상품 수정</button>
			                                 </span>
			                              </td>
			                              <td>
			                                 <p class="goods_img"><a href="" target="_blank" title="">
			                                 	<img src="<?=$value->image?>" width="100" height="100"></a>
			                                 </p>
			                              </td>
			                              <td>
			                                 <!-- 상품 정보 -->
			                                 <table class="order_noBd">
			                                    <colgroup>
			                                       <col width="25%">
			                                       <col width="*">
			                                    </colgroup>
			                                    <tbody>
			                                       <tr>
			                                          <th>TRACKING NO</th>
			                                          <td>
			                                             <a href="javascript:" onclick="fnDlvrShDirect('<?=$value->Tname?>', '<?=$value->trackingNumber?>');" class="blue" style="letter-spacing:-0.05em;"><?=$value->trackingNumber?></a>
			                                          </td>
			                                       </tr>
			                                       <tr>
			                                          <th>오더번호 NO</th>
			                                          <td>
			                                             <?=$value->order_number?>
			                                          </td>
			                                       </tr>
			                                       <tr>
			                                          <th>입고상태</th>
			                                          <td>
			                                             <span class="bold red1">(
			                                             	<?php 
			                                             	if($value->step==0) echo '입고대기';
							    							if($value->step==101) echo '입고완료';
							    							if($value->step==102) echo '오류입고';
							    							if($value->step==103) echo '노데이타';
			                                             	?>
			                                             )</span>
			                                            <?php if($delivery[0]->combine ==-1): ?>
							    							<?php if($value->combine == 1): ?><span class="text-danger">묶음배송</span><?php endif; ?>
								    						<?php if($value->combine == 2): ?><span class="text-danger">나눔배송</span><?php endif; ?>
								    						<?php if($value->combine == 4): ?><span class="text-danger">신청취소</span><?php endif; ?>
								    						<?php if($value->type == 4): ?>
								    						<span class="text-danger">리턴신청</span> 
								    						<?php endif; ?>
								    						<?php if(!empty($value->ordernum)): ?>
								    						(<a  class="text-danger" href="<?=base_url()?>ShowDelivery?ORD_SEQ=<?=$value->did1?>">
								    							<?php echo $value->new_order; ?></a>)
								    						<?php endif; ?>
							    						<?php endif; ?>
							    						<?php if($delivery[0]->combine !=-1): ?>
							    							<?php if($value->combine == 1): ?><span class="text-danger">묶음배송</span><?php endif; ?>
								    						<?php if($value->combine == 2): ?><span class="text-danger">나눔배송</span><?php endif; ?>
								    						<?php if($value->combine == 4): ?><span class="text-danger">신청취소</span><?php endif; ?>
								    						<?php if($value->type == 4): ?>
								    						<span class="text-danger">리턴신청</span> 
								    						<?php endif; ?>
								    						<?php if(!empty($value->ordernum)): ?>
								    						(<a  class="text-danger" 
								    						href="<?=base_url()?>ShowDelivery?ORD_SEQ=<?=$value->did?>">
								    						<?php  echo $value->ordernum;?></a>)
								    						<?php endif; ?>
							    						<?php endif; ?>
			                                          </td>
			                                       </tr>
			                                       <tr>
			                                          <th>상품명 영문/중문 (품목)</th>
			                                          <td class="lht_150"><a href="<?=$value->url?>" target="_blank">
			                                          	<span class="bold" ><?=$value->productName?>/<?=!empty($value->chn_subject) ? $value->chn_subject : ""?>/<?=!empty($value->kr_subject) ? $value->kr_subject : ""?></p></a></td>
			                                       </tr>
			                                       <tr>
			                                          <th>옵션</th>
			                                          <td><?=$value->size?><?=!empty($value->color) ? ",".$value->color : ""?></td>
			                                       </tr>
			                                       <tr>
			                                          <th>단가 * 수량</th>
			                                          <td>￥<?=$value->unitPrice?>&nbsp;&nbsp;*&nbsp;&nbsp;<?=$value->count?>&nbsp;&nbsp;=&nbsp;&nbsp;<span class="bold clrRed1">￥<?=$value->pp?></span></td>
			                                       </tr>
			                                    </tbody>
			                                 </table>
			                              </td>
			                           </tr>
			                           <?php endforeach; ?>
			                           <?php endif; ?>
			                        </tbody>
			                     </table>
			                     <p class="clrBoth pHt10"></p>
			                  </div>
			                  <input type="hidden" id="sDelView" name="sDelView" value="N">
			               </div>

			               <div class="step_box" id="AreaStep3">
			                  <div id="TextProduct1"></div>
			                  <p class="clrBoth pHt10"></p>
			                  <div class="step_box">
			                     <div class="orderTit">
			                        <h3>금액 정보</h3>
			                     </div>
			                  </div>
			                  <div class="order_table">
			                     <table class="order_view" summary="총 금액정보">
			                        <colgroup>
			                           <col width="15%">
			                           <col width="35%">
			                           <col width="15%">
			                           <col width="35%">
			                        </colgroup>
			                        <tbody>
			                           <tr>
			                              <th>중국 내 배송비</th>
			                              <td>¥<?=!empty($delivery[0]->cur_send) ? $delivery[0]->cur_send:"0.00"?></p>
			                              <th>총 수량 / 상품 총액</th>
			                              <td><span class="ft_15 bold text-primary"><?=$delivery[0]->ProCount?></span> / <span class="ft_15 bold text-danger">￥<?=number_format($delivery[0]->ProSum)?></span></td>
			                           </tr>
			                           <tr>
			                              
			                           </tr>
			                        </tbody>
			                     </table>
			                  </div>
			                  <p class="clrBoth pHt20"></p>
			                  <?php if($delivery[0]->state!=1 && $delivery[0]->state!=2 && $delivery[0]->state!=4): ?>
								<div class="row">
									<div class="col-md-12">
										<div class="orderTit">
											<h3>결제 정보</h3>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
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
													<p class="clrBoth"></p>
													<label class="font-weight-bold" style="width: 150px">- 구매비용 금액 : </label>
													<label><?=number_format($delivery[0]->purchase_price)?> 원 (<?=$delivery[0]->payed_checked==1 ? "결제완료":"결제대기"?>)</label><br>
													<label style="width:150px;">- 구매비</label> 
													<label>: <?=number_format($rr[1])?> 원</label><br>
													<label style="width:150px;">- 구매 수수료</label> 
													<label >: <?=$rat ?> 원</label><br>
													<?php if(number_format($rr[2]*$sss) > 0): ?>
													<label style="width:150px;">- 현지 배송비</label>
													<label >: <?=number_format($rr[2]*$sss)?> 원</label><br>
													<?php endif; ?>
												</td>
											</tr>
										<?php endif; ?>
										<?php if(!empty($delivery[0]->sending_price)):
											$del_price = str_replace(",", "", $delivery[0]->sending_price);
										 ?>
											<?php if(!empty($services_ss)): ?>
											<?php foreach($services_ss as $sv): ?>
											<?php if(empty($sv)) continue; ?>
											<?php $del_price = $del_price-$sv;?>
											<?php endforeach; ?>
											<?php endif; ?>
											<tr>	
												<th>배송비용</th>	
												<td colspan="3" style="line-height:180%;">		
													<p class="clrBoth"></p>
													<label class="font-weight-bold" style="width: 150px">- 배송비용 금액 : </label> 
													<label><?=$delivery[0]->sending_price?> 원 (<?=$delivery[0]->payed_send==1 ? "결제완료":"결제대기"?>)</label><br>
													<label style="width:150px;">- 배송비</label> 
													<label >: <?=number_format($del_price)?> 원</label><br>
													<?php if(!empty($service_ss)): ?>
													<?php foreach($service_ss as $ssv_key=>$ssv): ?>
													<?php if(empty($ssv)) continue; ?>
													<label style="width:150px;">- <?=$aa_value[$ssv_key]?></label> 
													<label >:  <?=number_format($ssv)?> 원</label><br>	
													<?php endforeach; ?>
													<?php endif; ?>					
												</td>
											</tr>
										<?php endif; ?>
										<?php if(!empty($delivery[0]->return_price)):
											$del_price = str_replace(",", "", $delivery[0]->sending_price);
										 ?>
											<tr>	
												<th>리턴비용</th>	
												<td colspan="3" style="line-height:180%;">		
													<p class="clrBoth"></p><label class="font-weight-bold" style="width: 150px">- 리턴비용 금액 : </label> 
													<label><?=number_format(str_replace(",", "", $delivery[0]->return_price))?> 원 (<?=$delivery[0]->return_check==1 ? "결제완료":"결제대기"?>)</label><br>
													<label style="width:150px;">- 리턴비</label> 
													<label >: <?=number_format(str_replace(",", "", $delivery[0]->return_price)-str_replace(",", "", $delivery[0]->rfee))?> 원</label><br>		
													<label style="width:150px;">- 리턴수수료</label> 
													<label >: <?=number_format(str_replace(",", "", $delivery[0]->rfee))?> 원</label><br>			
												</td>
											</tr>
										<?php endif; ?>
										<?php if(!empty($adding)): ?>	
											<tr>	
												<th>추가결제비용</th>	<td colspan="3" style="line-height:180%;">		
													<p class="clrBoth"></p>
													<label class="font-weight-bold" style="width: 150px">- 추가결제비용 금액 :  </label>
													<label><?=$adding[0]->add_price?> 원 (<?=$adding[0]->add_check==0 ? "결제완료":"결제대기"?>)</label><br>
													<?php if($adding[0]->gwan !=0): ?>
													<label style="width:150px;">- 관/부가세</label> 
													<label >: <?=$adding[0]->gwan?> 원</label><br>
													<?php endif; ?>
													<?php if($adding[0]->pegi !=0): ?>
													<label style="width:150px;">- 폐기수수료</label> 
													<label >:  <?=$adding[0]->pegi?> 원</label><br>
													<?php endif; ?>
													<?php if($adding[0]->check_custom !=0): ?>
													<label style="width:150px;">- 검역수수료</label> 
													<label >:  <?=$adding[0]->check_custom?> 원</label><br>
													<?php endif; ?>
													<?php if($adding[0]->cart_bunhal !=0): ?>
													<label style="width:200px;">- 카툰분할 수 신고/BL 분할</label> 
													<label >:  <?=$adding[0]->cart_bunhal?> 원</label><br>
													<?php endif; ?>
													<?php if($adding[0]->gwatae !=0): ?>
													<label style="width:150px;">- 과태료</label> 
													<label >:  <?=$adding[0]->gwatae?> 원</label><br>
													<?php endif; ?>			
												</td>
											</tr>
										<?php endif; ?>	
										</table>
									</div>
								</div>
							<?php endif; ?>
			                  <div class="row">
									<div class="col-md-12">
										<div class="orderTit">
											<h3>요청 사항</h3>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
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
															<label style="padding-right:2px;">
																<input type="checkbox" class="input_chk" name="EtcDlvr"  mny="<?=$chd['price']?>" value="<?=$chd['id']?>" onclick="fnEtcSvcChk($(this));" disabled 
																<?php if(isset($services_ss[$chd['id']]) && $services_ss[$chd['id']]>=0) echo "checked"; ?> ><?=$chd['name']?>
																<span style="color:#d30009;font-weight:bold;">
																	(<?= $chd['price'] == 0 ? '무료':$chd['price'].'원' ?>)
																</span>
															</label>
														<?php endforeach; ?>
													<?php endif; ?>
													</td>
												</tr>
												<?php endforeach; ?>
												<?php endif; ?>
											</tbody>
										</table>
									</div>
								</div>
			                  <div class="order_table">
			                     <table class="order_view" summary="기타 사항">
			                        <colgroup>
			                           <col width="15%">
			                           <col width="*">
			                        </colgroup>
			                        <tbody>
			                           <tr>
			                              <th>물류센터 요청사항</th>
			                              <td><?=$delivery[0]->logistics_request?></td>
			                           </tr>
			                        </tbody>
			                     </table>
			                  </div>
			               </div>
			               <span class="whGraBtn">
			               <button type="button" class="txt" onclick="fnOrdComment('296');" title="">코멘트</button>
			               </span>
			               <div class="btn-area" style="text-align:center">
			                  <a href="/admin" class="txt btn btn-primary">목록</a>
			                  <a  href="ActDelivery?ORD_SEQ=<?=$delivery[0]->id?>" class="txt btn btn-danger" onclick="javascript:fnPageEdit();">수정</a>
			               </div>
			            </div>
			         </div>
			      </div>
			   </div>
			</div>
         </div>
     </div>
 </section>
 <script type="text/javascript">
 	function fnProAdd(pKind, pOrdSeq, pProSeq) {
		fnPopWinCT("./ActingPro_W?sKind=" + pKind + "&sOrdSeq=" + pOrdSeq + "&sProSeq=" + pProSeq, "ActingPro", 1000, 680, "Y")
	}
	function fnAdrsMod(pOrdSeq) {
		fnPopWinCT("./ActingAdrs_W?sOrdSeq=" + pOrdSeq, "ActingAdrs", 1000, 630, "N")
	}


 </script>