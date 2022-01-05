<?php 
	$pid = array();
	if(sizeof($delivery) ==0) return;
	$phone_number=  explode("-",$delivery[0]->phone_number);
	if($delivery[0]->get=="delivery") $page_label = '배송';
	if($delivery[0]->get!="delivery") $page_label = '구매';
	$fee = "";
	$options = $delivery[0]->get;
	$ss_array=array();
	if(!empty($delivery[0]->content))
	{
		$ss_array = json_decode($delivery[0]->content,true);
		foreach ($ss_array as $key => $value) {
			$fee .=$key.",";
		}
	}
?>

<div class="container">
	<div class="row">
		<div id="subRight"> 
			<div class="p-5 bg-green">
	            <p class="parts1 text-white text-center"><?=$page_label?>대행 신청</p>
	        </div>
			<input type="hidden" id="product_val">
			<div class="con">
				<form method="post" action="/updateDeliver" id="deliverForm" enctype="multipart/form-data">
					<input type="hidden" name="TempProNum" id="TempProNum" value="<?=sizeof($products)?>">
					<input type="hidden" name="PRO_AMT" id="PRO_AMT" 
					value="<?=!empty($sum_price[0]) ? $sum_price[0]->price : '0.00'?>">
					<input type="hidden" name="SHIP_AMT" id="SHIP_AMT" value="0">
					<input type="hidden" name="TempCtmsNum" id="TempCtmsNum" value="1">
					<input type="hidden" name="TempShopNum" id="TempShopNum" value="5">
					<input type="hidden" name="waiting" id="waiting">
					<input type="hidden" name="theader" id="theader">
					<input type="hidden" name="fees" id="fees" value="<?=$fee?>">
					<input type="hidden" name="type_options" value="<?=$delivery[0]->get?>">
					<input type="hidden" name="id" value="<?=$delivery[0]->id?>">
					<input type="hidden" name="deliver" value="<?=$delivery[0]->get?>">
					<input type="hidden" name="pid" id="pid">
					<div class="step_box mt-10" style="margin-left: 10px;margin-right: 10px">
	                    <div class="orderTit" style="background-color: #82cbc4;border:none">
	                        <h4><?=$page_label?>대행 신청서</h4>
	                    </div>
	                </div>   
					<div class="step_box">
						<div class="p-3 border" style="margin: 10px;margin-top: 0px">
	                        <p class="orderAgreeTit">[<?=$page_label?>대행] 서비스 신청 유의사항</p>
	                        <div class="order_write agree_box_custom">
	                            <?php if(!empty($pp) && $pp[0]->use==1): ?>
	                                <?=$pp[0]->link?>
	                            <?php endif; ?>
	                        </div>
	                    </div>
						<p class="orderAgreeCk">
							<label><input type="checkbox" name="agreecyn" id="agreecyn" class="vm" value="" checked> 
								<b>주의사항을 모두 숙지하였으며, 위 약관에 동의합니다.</b></label>
						</p>
						<div class="orderStepTit">
	                        <p>
	                            <span class="stepTxt">STEP</span>
	                            <span class="stepNo">01</span>
	                        </p>
	                        <h4>배송받을 물류센터 선택</h4>
	                    </div>
	                    <div class="pHt10"></div>
						<div class="order_table clearfix">
							<?php $delivery_address_key = 0; ?>
	                        <?php $delivery_address_chs = array_chunk($delivery_address, 4); ?>
	                        <?php $laa = 0; ?>
	                        <?php foreach($delivery_address_chs as $key=>$value): ?>
	                        <div class="row">
	                        <?php foreach($value as $ch_value): ?>
	                        	<?php if($ch_value->id == $delivery[0]->place) $delivery_address_key = $key;  ?>
	                            <div class="col-xs-3 text-center p-3">
	                                <input type="radio" name="CTR_SEQ" rel="0" class="input_chk" value="<?=$ch_value->id?>" 
	                                <?php if($ch_value->id == $delivery[0]->place) echo 'checked'; ?> 
	                                id="CTR_SEQ<?=$ch_value->id?>" data-addrsid="<?=$ch_value->id?>" 
	                                data-v="<?=$ch_value->area_code?>|<?=$ch_value->area_name?>|<?=$ch_value->address?>|<?=$this->session->userdata('fsase')?>|
                                        <?=$ch_value->postNum?>|<?=$ch_value->phoneNum?>">&nbsp;<label for="CTR_SEQ<?=$ch_value->id?>"><?=$ch_value->area_name?></label>
	                            </div>

	                            <?php $laa = $laa+1; ?>
	                        <?php endforeach; ?>
	                        </div>
	                        <?php endforeach; ?>
	                        <div class="row">
								<div class="col-md-12">
									<ul class="areaMyAddrBox" style="height:40px;">
										<?php if(!empty($delivery_address)): ?>
										<li class="areaMyAddr">* <?=$delivery_address[$delivery_address_key]->area_name?>(<?=$delivery_address[$delivery_address_key]->area_code?>) 주소 : <span class="bold clrBlue2"><?=$this->session->userdata('fsase')?>,</span> 
											<?=$delivery_address[$delivery_address_key]->address?> <br>
										ZIP CODE: <?=$delivery_address[$delivery_address_key]->postNum?>,
										TEL: <?=$delivery_address[$delivery_address_key]->phoneNum?></li>
										<?php endif; ?>
									</ul>
								*입고완료 확인되면 배송요청,묶음배송 혹은 나눔배송요청 해주셔야 합니다
								</div>
							</div>	
	                    </div>

						<input type="hidden" name="DLVR_TY_CD" id="DLVR_TY_CD" value="1">
						<div class="pHt10"></div>
						<div class="stepOrd-DlvrTy">
							<div class="orderStepTit">
		                        <p>
		                            <span class="stepTxt">STEP</span>
		                            <span class="stepNo">02</span>
		                        </p>
		                        <h4>수입방식 선택</h4>
		                    </div>
		                    <div class="pHt10"></div>
	                        <div class="order_table">
	                            <?php if(!empty($sends)): ?>
	                            <?php $sends = array_chunk($sends, 2); ?>
	                                <?php foreach($sends as $vas): ?>
	                                <?php foreach($vas as $key_s=>$value_se): ?>
	                                <div class="col-xs-6">
	                                    <!-- <div class="income_parts text-center" onclick="javascript:selectIncome(<?=$value_se->id?>)">
	                                        <img src="/upload/income/<?=$value_se->image?>" class="parts1">
	                                        <label class="label_income">
	                                            <img src="/template/images/<?=$delivery[0]->incoming_method==$value_se->id ? "add_selected.png":"add_unselected.png"?>" 
	                                            width="18" id="income_img_<?=$value_se->id?>">
	                                        </label>
	                                    </div> -->
	                                    <input type="radio" name="REG_TY_CD" id="REG_TY_CD<?=$value_se->id?>"  rel="0" class="input_chk" 
	                                    value="<?=$value_se->id?>" <?php if($delivery[0]->incoming_method==$value_se->id ){ echo "checked";} ?>>&nbsp;<label for="REG_TY_CD<?=$value_se->id?>"><?=$value_se->name?></label>
	                                </div>
	                                <?php endforeach; ?>
	                                <?php endforeach; ?>
	                            <?php endif; ?> 
	                        </div>
						</div>
						<div id="stepOrd-EtcTt">
							<div class="step_box">
								<p class="clearfix"></p>
								<div class="orderStepTit">
			                        <p>
			                            <span class="stepTxt">STEP</span>
			                            <span class="stepNo">03</span>
			                        </p>
			                        <h4>받는 사람 정보 입력</h4>
			                    </div>
			                    <div class="pHt10"></div>
								<div class="order_table p-5" style="clear: both;">
									<table class="order_write border-r" summary="주소검색, 우편번호, 주소, 상세주소, 수취인 이름(한글), 수취인 이름(영문), 전화번호, 핸드폰번호, 용도, 주민번호, 통관번호 셀로 구성"> 
										<colgroup>
	                                        <col width="25%"> 
	                                        <col width="35%"> 
	                                        <col width="15%"> 
	                                        <col width="25%"> 
	                                    </colgroup>
										<tbody>
											<tr>
												<th class="border-t">받는 사람</th>
												<td colspan="3" class="border-t">
													<div class="row">
														<div class="col-md-6">
															한글
															<div class="row">
																<div class="col-xs-6  p-3">
																	<input type="text" name="ADRS_KR" id="ADRS_KR" maxlength="60" class="input_txt2 ipt_type1 form-control" required value="<?=$delivery[0]->billing_krname?>">
																</div>
																<div class="col-xs-6  p-3">
																	<a class="ft-12 btn-sm btn-round btn btn-warning" href="javascript:fnPopMemAddr();"><span>주소록 가져오기</span></a> 
																</div>
															</div>
														</div>
													</div>
													<div class="row" style="margin-top: 10px;">
														<div class="col-md-6">
															영문 <input type="text" name="ADRS_EN" id="ADRS_EN" maxlength="60" class="input_txt2 ipt_type1 form-control" required value="<?=$delivery[0]->billing_name?>">
														</div>	
														<div class="col-md-6" style="padding-top: 15px">*사업자 영문명은 반드시 고쳐주세요 (한글발음나는대로 입력시 통관지연)</div>													
													</div>
												</td>
											</tr>
											<tr>
												<th>받는 사람 정보</th>
												<td colspan="3">
													<div class="row">
														<div class="col-md-3">
															<label><input type="radio" class="form-check-input vm" name="RRN_CD" id="RRN_CD" value="1" <?php if($delivery[0]->person_num == 1) echo 'checked'; ?>> 개인통관고유부호</label>
														</div>
														<div class="col-md-3">
															<label><input type="radio" class="form-check-input vm " name="RRN_CD" id="RRN_CD" value="3" <?php if($delivery[0]->person_num == 3) echo 'checked'; ?>> 사업자등록번호</label>
														</div>
														<div class="col-md-6">
															<input type="text" name="RRN_NO" id="RRN_NO" maxlength="20" class="input_txt2 m_num form-control" value="<?=$delivery[0]->person_unique_content?>" required onfocus="fnFocusInExp( &#39;RRN_NO&#39;, aRrnCdNm[$(&#39;input[name=RRN_CD]:radio:checked&#39;).val()] );" onblur="fnFocusOutReg( &#39;RRN_NO&#39;, aRrnCdNm[$(&#39;input[name=RRN_CD]:radio:checked&#39;).val()], /[^a-zA-Z0-9]/g );">
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<th>주소 및 연락처</th>
												<td colspan="3">
													<div class="row">
														<label class="col-md-4 mt-10 p-right-0">연락처</label> 
														<div class="row">
															<div class="col-md-8">
																<div class="col-xs-4 p-3">
																	<input type="text" name="MOB_NO1" id="MOB_NO1" maxlength="4" 
																	class="form-control  w-100 mb-2"  value="<?=!empty($phone_number[0]) ? $phone_number[0]:""?>" title="전화번호 첫자리" required>
																</div>
																<div class="col-xs-4 p-3">
																	<input type="text" name="MOB_NO2" id="MOB_NO2" maxlength="4" 
																	class="form-control  w-100 mb-2"  value="<?=!empty($phone_number[1]) ? $phone_number[1]:""?>" title="전화번호 중간자리" required>
																</div>
																<div class="col-xs-4 p-3">
																	<input type="text" name="MOB_NO3" id="MOB_NO3" maxlength="4" 
																	class="form-control  w-100 mb-2" value="<?=!empty($phone_number[2]) ? $phone_number[2]:""?>" title="전화번호 마지막자리" required>
																</div>
															</div>
														</div>
													</div>
													<div class="row" style="margin-top: 10px">
														<label class="col-md-2">우편번호
															<a class="btn btn-sm btn-warning btn-round" href="javascript:openDaumPostcode();">
																<span>우편번호 검색</span>
															</a></label> 
														<div class="col-md-10">
															<input type="text" name="ZIP" id="ZIP" maxlength="8" class="input_txt2 form-control" value="<?=$delivery[0]->post_number?>" required readonly>
														</div>
													</div>
													<div class="row" style="margin-top: 10px">
														<label class="col-sm-2">주소</label>
														<div class="col-sm-10">
															<input type="text" name="ADDR_1" id="ADDR_1" maxlength="100" class="input_txt2 adr form-control" value="<?=$delivery[0]->address?>" required readonly>
														</div>
													</div>
													<input type="hidden" name="ADDR_1_EN" id="ADDR_1_EN" value="">
													<input type="hidden" name="ADDR_2_EN" id="ADDR_2_EN" value="">
													<div class="row" style="margin-top: 10px">
														<label class="col-sm-2">상세주소</label>
														<div class="col-sm-10">
															<input type="text" name="ADDR_2" id="ADDR_2" maxlength="100" class="input_txt2 adr form-control " 
															value="<?=$delivery[0]->detail_address?>">
														</div>
													</div>
													<div class="row">
														<div class="col-sm-2"></div>
														<div class="col-sm-10" style="padding-top: 10px">
															* 도로명 주소를 써주세요. 지번 주소 기재 시 통관/세관에서 오류로 분류시켜 통관지연이 될 수 있습니다
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<th><?=$page_label?> 요청 사항</th>
												<td colspan="3">
													<div class="form-group  ml-5">
														<select class="form-control" id="exampleFormControlSelect1" onchange="fnReqValGet(this.value);">
													      <option>직접기재</option>
													      <option value="배송 전 연락 바랍니다">배송 전 연락 바랍니다</option>
													      <option value="부재시 경비실에 맡겨주세요">부재시 경비실에 맡겨주세요</option>
													      <option value="부재시 집앞에 놔주세요">부재시 집앞에 놔주세요</option>
													      <option value="택배함에  맡겨주세요">택배함에  맡겨주세요</option>
													    </select>
													</div>
													<div class="form-group ml-5">
														<input  type="text" name="REQ_1" id="REQ_1" maxlength="100" class="input_txt2 full form-control" value="<?=$delivery[0]->request_detail?>">
														<p style="padding-top: 10px">* 국내 배송기사 분께 전달하고자 하는 요청사항을 남겨주세요(예: 부재 시 휴대폰으로 연락주세요.)</p>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<input type="hidden" name="sProNum" id="sProNum" value="<?=sizeof($products)?>" readonly="">
							<div class="step_box">
								<p class="clrBoth pHt30"></p>
								<div class="row">
									<div class="col-md-3 my-4">
										<select class="form-control" id="types_order">
											<option value="0">==선택==</option>
											<?php if($delivery[0]->get =="buy"): ?>
												<option value="2">타오바오 장바구니복사</option>
												<option value="4">알리바바 장바구니 복사</option>
											<?php endif; ?>
											<?php if($delivery[0]->get !="buy"): ?>
												<option value="1">타오바오 주문복사</option>											
												<option value="3">알리바바 주문복사</option>
											<?php endif; ?>																						
										</select>
									</div>
									<div class="col-md-4 mb-5">
										<a href="javascript:opentao();" class="btn btn-danger btn-sm btn-block btn-round">타오바오&알리바바-장바구니&주문복사</a>
									</div>
									<div class="col-md-2 mb-5">
										<a href="javascript:registerProducts();" class="btn btn-danger btn-sm btn-block btn-round">상품 등록하기</a>
									</div>
									<div class="col-md-2 mb-5">
										<button type="button" class="btn btn-warning btn-sm btn-block btn-round" data-toggle="modal" data-target=".bd-example-modal-lg">등록방법</button>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="taoali">
											<div name="cartSub" id="ie-clipboard-contenteditable" contenteditable="true" style="border:1px solid #fc6504; overflow: auto;height: 300px"></div>
										</div>
									</div>
								</div>
							</div>							
							<div class="step_box">
								<p class="clrBoth pHt10"></p>
	                            <div class="orderStepTit">
			                        <p>
			                            <span class="stepTxt">STEP</span>
			                            <span class="stepNo">04</span>
			                        </p>
			                        <h4>상품정보를 입력해주세요</h4>
			                    </div>
								<?php if(!empty($products)): ?>
									<?php foreach($products as $key=>$valuep): 
										array_push($pid,$valuep->id);
										?>
										<div id="TextProduct<?=$key+1?>" class="clrBoth">
											<input type="hidden" name="ARV_STAT_CD" id="ARV_STAT_CD" value="1">
											<input type="hidden" name="pro_id" value="<?=$valuep->id?>">
											<div class="order_table order_table_top">
												<div class="row pt-5 pb-5"  style="background-color: #f0f0f0" >
													<div class="fl">
														<h4 class="s_tit vm_box" style="color:#ed7d31;">
															<label >상품#<?=$key+1?></label>
															<input type="text" name="StockTxt" id="StockTxt" value="" class="stock-font" readonly="">
															<input type="hidden" name="PRO_STOCK_SEQ" id="PRO_STOCK_SEQ" value="0">
														</h4>
													</div>
													<div class="fr p-right-5">
														<a href="javascript:fnPageCopy2('<?=$key+1?>','<?=$delivery[0]->get?>');" 
															type="button" class="btn btn-warning btn-sm btn-round ft-12">상품복사</a>
														<a href="javascript:fnProPlus('<?=$key+1?>','<?=$delivery[0]->get?>');" 
															class="btn btn-danger btn-sm btn-round ft-12">+상품추가</a>
														<a href="javascript:fnStockTempDel(<?=$key+1?>);" 
															class="btn btn-danger btn-sm btn-round ft-12">-상품삭제</a>
													</div>
												</div>
											</div>
											<div class="order_table">
											<?php  if($delivery[0]->get !='buy'){ ?>
												<div class="row">
													<label class="col-sm-2">*트래킹번호<br>Tracking No.</label>
													<div class="col-sm-4 mb-5">
														<select name="FRG_DLVR_COM" class="form-control" id="FRG_DLVR_COM">
															<?php foreach($tracking_header as $value): ?>
																<option value="<?=$value->name?>"
																	<?php if($valuep->trackingHeader == $value->name) echo 'selected'; ?>
																	>
																	<?=$value->name?></option>
															<?php endforeach; ?>
														</select>
													</div>
													<div class="col-sm-4">
														<input type="text" class="input_txt2 form-control" name="FRG_IVC_NO" id="FRG_IVC_NO" maxlength="40" value="<?=$valuep->trackingNumber?>">
													</div>
												</div>
												<div class="row">
													<div class="col-xs-12">
														<label>
															<input type="checkbox" name="TRACKING_NO_YN" id="TRACKING_NO_YN" value="Y" onchange="fnTrkNoAfChk('<?=$key+1?>');">트래킹 번호 나중에 입력
														</label>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-2">* 오더번호 </label>
													<div class="col-sm-10">
														<input type="text" class="input_txt2 per40 form-control" name="SHOP_ORD_NO" id="SHOP_ORD_NO" maxlength="40" value="<?=$valuep->order_number?>">
													</div>
												</div>
												
											<?php } ?>
												<div class="row">
													<label class="col-sm-2">* 통관품목</label>.
													<div class="col-md-4 mb-5">
														<select name="PARENT_CATE" class="form-control" 
														onchange="fnArcAjax(this.value,'<?=$key+1?>');">
															<?php $pidss = "pid".$valuep->id; ?>
															<?php if(!empty($categorys)): ?>
																<?php foreach($categorys as $value): ?>
																	<option value="<?=$value->id?>" 
																	<?php if($$pidss == $value->id) echo 'selected'; ?>	 ><?=$value->name?></option>
																<?php endforeach; ?>
															<?php endif; ?>
														</select>
													</div>
													<div class="col-md-6">
														<select name="ARC_SEQ" class="form-control" id="TextArc_<?=$key+1?>" onchange="fnArcChkYN('<?=$key+1?>',this.value);">
															<option value="" rel>품목은 정확하게 선택해주세요</option>
															<?php $ss = "category_ch".$valuep->id; ?>
															<?php if(!empty($$ss)): ?>
																<?php foreach($$ss as $value): ?>
																	<option value="<?=$value->id?>" 
															<?php if($valuep->category == $value->id) echo 'selected'; ?>
																		><?=$value->name?></option>
																<?php endforeach; ?>
															<?php endif; ?>
														</select>
													</div>
												</div>
												<div class="row">
			                                        <div class="col-sm-2"></div>
			                                        <div class="col-md-10" style="padding-top: 7px;">
			                                            카테고리에 없는 품목은 직접 영문명 상세기재 바랍니다.
			                                        </div>
			                                    </div>
			                                    <div class="row" >
			                                        <label class="col-sm-2">* 상품명</label>
			                                        <div class="col-md-4">
			                                        	<input type="text" class="input_txt2 per40 form-control en_product_name" name="PRO_NM" 
			                                        	id="PRO_NM" maxlength="200"  value="<?=$valuep->productName?>" title="상품명" required>
			                                        </div>
			                                    </div>
			                                    <div class="row">
			                                        <div class="col-sm-2"></div>
			                                        <div class="col-md-10" style="padding-top: 7px;">
			                                            카테고리에 없는 품목은 직접 영문명 상세기재 바랍니다.
			                                        </div>
			                                    </div>
			                                    <div class="row mb-5">
			                                        <label class="col-xs-4 p-right-0">* 단가</label>
			                                        <div class="col-xs-8">
			                                        	<input type="text" class="input_txt2 per20 form-control COST" name="COST"  
			                                        	maxlength="10" value="<?=$valuep->unitPrice?>" title="단가" required  
														onblur="fnNumChiper(this, '2');fnTotalProPrice();">
			                                        </div>
			                                    </div>
			                                    <div class="row mb-5">
			                                        <label class="col-xs-4 p-right-0">* 수량</label>
			                                        <div class="col-xs-8">
			                                        	<input type="text" class="input_txt2 per20 form-control QTY" name="QTY"  maxlength="5" 
			                                        	value="<?=$valuep->count?>" title="수량" required 
														onblur="fnNumChiper(this, '0');fnTotalProPrice();">
			                                        </div>
			                                    </div>
			                                    <div class="row mb-5">
			                                        <label class="col-xs-4">* 색상</label>
			                                        <div class="col-xs-8">
			                                        	<input type="text" class="input_txt2 per20 form-control" name="CLR" id="CLR" maxlength="100" value="<?=$valuep->color?>" title="색상(영문)">
			                                        </div>
			                                    </div>
			                                    <div class="row mb-5">
			                                        <label class="col-xs-4">* 사이즈</label>
			                                        <div class="col-xs-8">
			                                        	<input type="text" class="input_txt2 per20 form-control" name="SZ" id="SZ" 
			                                        	maxlength="80" value="<?=$valuep->size?>" title="사이즈">
			                                        </div>
			                                    </div>
			                                    <div class="row mb-5">
			                                        <label class="col-xs-4">* 상품URL</label>
			                                        <div class="col-xs-8">
			                                        	<input type="text" class="input_txt2 full form-control" name="PRO_URL" id="PRO_URL" 
			                                        	maxlength="500" value="<?=$valuep->url?>" title="상품URL">
														<input type="hidden" name="pro_step" value="<?=$valuep->step?>">
			                                        </div>
			                                    </div>
			                                    <div class="row">
			                                    	<div class="col-xs-4"></div>
			                                        <div class="col-xs-8">
			                                            검수가 필요하신 분들은 정확한 URL주소를 넣어주세요
			                                        </div>
			                                    </div>
			                                    <div class="row pb-5">
                                        			<div class="col-xs-12">
                                        				<p class="goods_img text-center">
														<?php 
									    				if(sizeof(explode("upload/shoppingmal", $valuep->image)) >1)
									    					$ss = base_url_home().$valuep->image;
									    				else
									    					$ss = $valuep->image;
									    				?>
									    				<img src="<?=$ss?>" width="109" height="128" id="sImgNo<?=$key+1?>"></p>
									    				<div class="text-center">
									    					<a class="btn-small  btn-secondary btn w-100" 
									    					href="javascript:openPopupImg(<?=$key+1?>)" 
															data-img="<?=$key+1?>"><span>이미지등록</span></a>
									    				</div>
									    				<div class="row mt-10">
			                                                <label class="col-md-4 p-right-0">* 이미지URL  </label>
			                                                <div class="col-md-8">
			                                                	<input type="text" class="input_txt2 full form-control" name="IMG_URL" id="IMG_URL" maxlength="500" value="<?=$valuep->image?>">
			                                                </div>
			                                            </div>
                                        			</div>
                                        		</div>
											</div>
										<?php if($key == sizeof($products)-1): ?>
											<div id="TextProduct<?=$key+2?>"></div>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
								<?php for($u=0;$u<sizeof($products);$u++){ ?>
										</div>
								<?php  }?>

								<p class="clrBoth pHt30"></p>
								<div class="orderStepTit">
									<h4>금액 정보</h4>
								</div>
								<div class="order_table p-5">
									<table>
										<colgroup>
											<col width="15%"> 
											<col width="30%">  
											<col width="*">  
										</colgroup>   
										<tbody>
											<tr> 
												<td rowspan="3">
													<ul class="proTtAmt">
														<li><span class="fl">총 수량</span> <span class="fr"><span id="TextTotalProCNT" class="proTtQtyTxt"><?=!empty($sum_price[0]) ? $sum_price[0]->count:1?> 개</span></span> </li>
														<li><span class="fl">총 금액</span>  <span class="fr">￥<span id="TextTotalAmt" class="proTtAmtTxt"><?=!empty($sum_price[0]) ? number_format($sum_price[0]->price, 2, '.', ''):0.00?></span></span> </li>
														<li style="height:auto;"><h3><span class="proTtBtmTxt">* 세관에 신고되는 금액 입니다 (쇼핑몰 결제 금액과 동일)<br>
														* 총 금액이 150달러를 넘을 경우 일반통관으로 진행되며 수수료 3,300원이 추가 부과됩니다.</span>
														</h3>
														</li>
													</ul>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<p class="clrBoth pHt10"></p>
	                            <div class="orderStepTit">
			                        <p>
			                            <span class="stepTxt">STEP</span>
			                            <span class="stepNo">05</span>
			                        </p>
			                        <h4>요청사항을 입력해주세요</h4>
			                    </div>
			                    <p class="clrBoth pHt10"></p>
								<div class="order_table p-5">
									<table class="order_write">
										<colgroup>
											<col width="25%"><col width="*">
										</colgroup>
										<tbody>
											<?php if(!empty($service_header)): ?>
												<?php foreach($service_header as $vas): ?>
												<tr>
													<th><?=$vas->name?></th>
													<td class="vm_box border p-left-5">
													<?php if(!empty($aa[$vas->id])): ?>
														<?php foreach($aa[$vas->id] as $chd): ?>
															<?php 
			                                                    $servce_label = "";
			                                                    $question_mark = "";
			                                                    if(!empty($chd['description']))
			                                                    {
			                                                        $servce_label = "<div id='service".$chd['id']."' class='d-none service_content p-left-10'><p> - ".$chd['description']."</p></div>";
			                                                        $question_mark = "<img src='/template/images/service_question_mark.png' width='20px' onclick='showServiceContent(".$chd['id'].")'>";
			                                                    }
			                                                ?>
															<label class="p-left-5">
																<input type="checkbox" class="input_chk" name="EtcDlvr"  mny="<?=$chd['price']?>" value="<?=$chd['id']?>" onclick="fnEtcSvcChk($(this));"  
																<?php if(isset($ss_array[$chd['id']]) && $ss_array[$chd['id']]>=0) echo "checked"; ?> ><?=$chd['name']?>
																<span style="color:#d30009;font-weight:bold;">
																	(<?= $chd['price'] == 0 ? '무료':number_format($chd['price']).'원' ?>)
																</span>
															</label>
															<?=$question_mark?>
		                                                    <div class="d-block"></div>
		                                                    <?=$servce_label?>
														<?php endforeach; ?>
													<?php endif; ?>
													</td>
												</tr>
												<?php endforeach; ?>
												<?php endif; ?>
											<tr>
												<th>물류 요청사항	</th>
												<td>
													<input type="text" name="REQ_2" id="REQ_2" maxlength="100" class="input_txt2 full form-control ml-5" value="<?=$delivery[0]->logistics_request?>">
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div style="margin-top: 15px;">
							<?php if($delivery[0]->get=="buy"): ?>
	                        <div class="row pb-10 ">
	                            <div class="col-xs-12">
	                                <button  class="btn w-100 btn-danger btn-round accept"  id="requestAccept" 
	                                data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중">
	                                    구매견적
	                                </button>    
	                            </div>
	                        </div>
	                    <?php endif; ?>
	                    <?php if($delivery[0]->get !='buy'): ?>
	                        <div class="row pb-10">
	                            <div class="col-xs-6 p-right-5">
	                                <button  class="btn  btn-warning accept w-100 btn-round"   id="waitAccept" 
	                                data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중">
	                                    접수대기
	                                </button>    
	                            </div>
	                            <div class="col-xs-6  p-left-5">
	                                <button  class="btn  btn-danger accept w-100 btn-round"  id="requestAccept" 
	                                data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중">
	                                    접수신청
	                                </button>    
	                            </div>
	                        </div>
	                        <div class="row bg-white">
	                            <div class="col-xs-12">
	                                <p class="text-danger pt-10">트래킹번호 나중에 입력하실려면 접수대기만 선택 가능합니다 
	                                타오바오에서 트래킹번호 확인되면 마이페이지에서 수정하여 입력후 접수신청을 하면 됩니다 
	                                (트래킹번호 미 입력시 입고지연 될수 있습니다 )  
	                                </p>
	                            </div>
	                        </div>
	                    <?php endif; ?>
						</div>
					</div>			
				</form>
			</div>
		</div>
	</div>	
</div>
<div class="modal" tabindex="-1" role="dialog" id="exampleModalCenter">
  <div class="modal-dialog" role="document">
  		<?php echo form_open_multipart('registerImage',array('id' => 'popFrmImg'));?>
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">이미지 등록</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		    <table class="board_list" summary="">
		        <colgroup>
		        <col width="15%">
		        <col width="*">
		        </colgroup>
				<thead>
				<tr> 
					<th>이미지</th>
					<th></th>
				</tr>
				</thead> 
				<tbody>
				<tr>
					<td><input type="file" name="FILE_NM" id="FILE_NM"></td>
				</tr>
				</tbody>
		    </table> 
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-danger btn-round">등록</button>
	        <button type="button" class="btn btn-default btn-round" data-dismiss="modal">취소</button>
	      </div>
	    </div>
	</form>
  </div>
</div>
<div id='loader' style='display: none;'>
  <img src='/template/images/reload.gif' width='150' height='150'>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-header"> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
     	<div class="modal-body">
     		<div>
     			<a target="_blink" href="<?=base_url_home()?>assets/images/<?=$delivery[0]->get?>.jpg"><img src="<?=base_url_home()?>assets/images/<?=$delivery[0]->get?>.jpg" class="w-100"></a>
	    	</div>
	    	<div>
		     	<p>
		     		전체를 원하시는 경우 Ctrl+A키를 눌러 전체 복사 해주세요.<br>
		     		단락이나 부분적인 상품을 원하시는 경우 마우스로 끌기하여 해당 내용을 복사하면 됩니다.<br>
		     		보기단추를 클릭하지 않으면  원하는 모든 상품이 현시되지 않습니다.<br>
		     		그러므로 보기단추를 클릭하고 복사하십시요.
		     	</p>
     		</div>
     	</div>
    </div>
  </div>
</div>
<link href="<?php echo site_url('/template/css/delivery.css');?>" rel="stylesheet">
<script type="text/javascript" src="/assets/js/delivery.js?<?=time()?>"></script>
<script>

	$('#popFrmImg').on('submit',(function(e) {
	    e.preventDefault();
	    var formData = new FormData(this);

	    $.ajax({
	        type:'POST',
	        url: $(this).attr('action'),
	        data:formData,
	        dataType: "json",
	        async: false,
			processData: false,
			contentType: false,
			
	        success:function(data){            	
	            $('#exampleModalCenter').modal('toggle');
	            if(data.errorId==0){
	            	// $("#IMG_URL").val(baseURL+"upload/delivery/"+data.img);
	            	$("#TextProduct"+$("#product_val").val()+" #IMG_URL").first().val(baseURL_HOME+"upload/delivery/"+data.img);
	            	$("#sImgNo"+$("#product_val").val()).attr("src",baseURL_HOME+"upload/delivery/"+data.img);
	            }

	        },
	        error: function(data){
	            console.log("error");
	            console.log(data);
	        }
	    });
	}));

	$(".accept").click(function(e){
		e.preventDefault();
		var FRG_DLVR_COM =new Array();
		var FRG_IVC_NO = new Array();
		var SHOP_ORD_NO = new Array();
		var PARENT_CATE = new Array();
		var ARC_SEQ = new Array();
		var PRO_NM = new Array();
		var COST =new Array();
		var QTY = new Array();
		var CLR = new Array();
		var SZ = new Array();
		var PRO_URL = new Array();
		var IMG_URL = new Array();
		var temp_array = new Array();
		var main_array  =new Array();
		var c_continue = 0;
		var $this = $(this);
		if($(this).attr('id')=="waitAccept"){
			$("#waiting").val(1);
		}
		if($(this).attr('id')=="requestAccept"){
			$("#waiting").val(0);
		}
		if(!$("#agreecyn").is(':checked')){
			$([document.documentElement, document.body]).animate({
		        scrollTop: $(".orderTit").offset().top
		    }, 2000);
			alert("서비스 이용약관을 동의해주세요.");
			c_continue =1;
			return;
		}
		if( $("#ADRS_KR").val().trim() == "" || 
			$("#ADRS_EN").val().trim() == "" || 
			$("#RRN_NO").val().trim()  == "" ||
			$("#MOB_NO1").val().trim() == "" ||
			$("#MOB_NO2").val().trim() == "" ||
			$("#MOB_NO3").val().trim() == "" ||
			$("#ZIP").val().trim() == "" ||
			$("#ADDR_1").val().trim() == ""){
			$([document.documentElement, document.body]).animate({
		        scrollTop: $("#stepOrd-EtcTt").offset().top
		    }, 2000);
			alert("받는 사람 정보를 입력해주세요.");
			c_continue =1;
			return;
		}

		for( var i=1; i<=$("#sProNum").val(); i++ ) {

			temp_array = new Array();
			<?php if($options !='buy'): ?>
			if($(this).attr('id')=="requestAccept"){	
				if ( !fnIptChk($("input[name='FRG_IVC_NO']").eq(i-1)) ) {
					fnMsgFcs($("input[name='FRG_IVC_NO']").eq(i-1), '트래킹번호를 입력해주세요.');
					c_continue =1;
					return;
				}
			}	
			<?php endif; ?>
			if($("input[name='TRACKING_NO_YN']").eq(i-1).prop('checked')){
				temp_array.push("");
				temp_array.push("");
			}
			else{
				temp_array.push($("select[name='FRG_DLVR_COM']").eq(i-1).val()==null?"":$("select[name='FRG_DLVR_COM']").eq(i-1).val());
				temp_array.push($("input[name='FRG_IVC_NO']").eq(i-1).val()==null?"":$("input[name='FRG_IVC_NO']").eq(i-1).val());
			}

			if ( !fnIptChk($("select[name='ARC_SEQ']").eq(i-1)) ) {
				fnMsgFcs($("select[name='ARC_SEQ']").eq(i-1), '통관품목을 선택해 주세요.');
				c_continue =1;
				return;
			}

			if ( !fnIptChk($("input[name='PRO_NM']").eq(i-1)) ) {
				fnMsgFcs($("input[name='PRO_NM']").eq(i-1), '상품명을 입력해 주세요.');
				c_continue =1;
				return;
			}
			
			if ( !fnIptChk($("input[name='COST']").eq(i-1)) ) {
				fnMsgFcs($("input[name='COST']").eq(i-1), '단가를 입력해 주세요.');
				c_continue =1;
				return;
			}

			if ( Number($("input[name='COST']").eq(i-1).val()) <= 0 ) {
				fnMsgFcs($("input[name='COST']").eq(i-1), '단가는 0보다 커야합니다.');
				c_continue =1;
				return;
			}
			if ( !fnIptChk($("input[name='QTY']").eq(i-1)) ) {
				fnMsgFcs($("input[name='QTY']").eq(i-1), '수량을 입력해 주세요.');
				c_continue =1;
				return;
			}
			if ( Number($("input[name='QTY']").eq(i-1).val()) <= 0 ) {
				fnMsgFcs($("input[name='QTY']").eq(i-1), '수량은 0보다 커야합니다.');
				c_continue =1;
				return;
			}
			temp_array.push($("input[name='SHOP_ORD_NO']").eq(i-1).val());
			temp_array.push($("select[name='PARENT_CATE']").eq(i-1).val());
			temp_array.push($("select[name='ARC_SEQ']").eq(i-1).val());
			temp_array.push($("input[name='PRO_NM']").eq(i-1).val()); 
			temp_array.push($("input[name='COST']").eq(i-1).val()); 
			temp_array.push($("input[name='QTY']").eq(i-1).val()); 
			temp_array.push($("input[name='CLR']").eq(i-1).val()); 
			temp_array.push($("input[name='SZ']").eq(i-1).val()); 
			temp_array.push($("input[name='PRO_URL']").eq(i-1).val()); 
			temp_array.push($("input[name='IMG_URL']").eq(i-1).val());
			if($("input[name='pro_step']").eq(i-1).val()!=undefined && $("input[name='pro_step']").eq(i-1).val()!=""){
	            temp_array.push($("input[name='pro_step']").eq(i-1).val());
	         }
	         else{temp_array.push("");}
	         if($("input[name='pro_id']").eq(i-1).val()!=undefined && $("input[name='pro_id']").eq(i-1).val()!=""){
	            temp_array.push($("input[name='pro_id']").eq(i-1).val());
	         }
			main_array.push(temp_array);
		}
		if(c_continue ==0 ){
			$("#theader").val(JSON.stringify(main_array));
			var formData = new FormData(document.getElementById("deliverForm"));
			$.ajax({
	            async: true,
	            type: $(gFrmNm).attr('method'),
	            url: $(gFrmNm).attr('action'),
	            data: formData,
	            cache: false,
	            processData: false,
	            contentType: false,
	            beforeSend:function(){
	            	$this.button("loading");
	            },
	            success: function (data) {
	                if(data > 0){
	                    window.location.href="/mypage";
	                }
	            },
	            error: function(request, status, error) {
	             	$this.button("reset");   ;
	             	alert("서버오류");
	            }
	        });
		}
	});

	$(document).ready(function(){
		$("#pid").val("<?=implode(",",$pid)?>")
	})

</script>	
