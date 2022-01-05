<?php 
if($options =='buy') $page_label = '구매';
else $page_label = '배송';
?>

<div class="container">
	<div class="row">
		<div id="subLeft" class="col-md-3">
			<div class="LeftTitle">
				<?=$page_label?>대행
			</div>
			<ul class="leftMenu">
				<li class="on"><a href="<?=$page_label=='배송'?'/delivery':'/delivery?options=buy'?>"> <?=$page_label?>대행 신청</a></li>
				<li class=""><a href="<?=$page_label=='배송'?'/multi?type=1':'/multi?type=2'?>"> 대량등록(엑셀)</a></li>
			</ul> 
		</div>
		<div id="subRight" class="col-md-9"> 
			<div class="padgeName">
				<h2><?=$page_label?>대행 신청</h2>
			</div>
			<input type="hidden" id="product_val" value="">
			<div class="con">

				<form method="post" action="/insertDeliver" id="deliverForm" enctype="multipart/form-data">
					<input type="hidden" name="TempProNum" id="TempProNum" value="1">
					<input type="hidden" name="PRO_AMT" id="PRO_AMT" value="0.00">
					<input type="hidden" name="SHIP_AMT" id="SHIP_AMT" value="0">
					<input type="hidden" name="deliver" value="<?=$options?>">
					<input type="hidden" name="TempCtmsNum" id="TempCtmsNum" value="1">
					<input type="hidden" name="TempShopNum" id="TempShopNum" value="5">
					<input type="hidden" name="waiting" id="waiting">
					<input type="hidden" name="theader" id="theader">
					<input type="hidden" name="type_options" id="type_options" value="<?=$options?>">
					<input type="hidden" name="fees" id="fees">
					<div class="step_box">
						<div class="orderTit">
							<h4><?=$page_label?>대행 신청서</h4>
						</div>
					</div>
					<div class="step_box">
						<p class="orderAgreeTit">* 서비스 신청 유의사항</p>
						<div class="order_write agree_box_custom">
							<?php if(!empty($pp) && $pp[0]->use==1): ?>
								<?=$pp[0]->link?>
							<?php endif; ?>
						</div>
						<p class="orderAgreeCk">
							<label><input type="checkbox" name="agreecyn" id="agreecyn" class="vm" value=""> 
								<b>주의사항을 모두 숙지하였으며, 위 약관에 동의합니다.</b></label>
						</p>
						<p class="clearfix pHt30"></p>
						<div class="orderStepTit">
							<p>
								<span class="stepTxt">STEP</span>
								<span class="stepNo">01</span>
							</p>
							<h4>배송받을 물류센터를 선택해주세요.</h4>
						</div>
						<div class="order_table border clearfix">
							<div class="row">
								<?php foreach($delivery_address as $key=>$value): ?>
									<div class="col-md-3">
										<label class="rdoFtBig rdoFtBig-cus">
										<input type="radio" name="CTR_SEQ" rel="0" class="input_chk" value="<?=$value->id?>" <?php if($key==0) echo 'checked'; ?> 
										data-v="<?=$value->area_code?>|<?=$value->area_name?>|<?=$value->address?>|<?=$this->session->userdata('fsase')?>|
										<?=$value->postNum?>|<?=$value->phoneNum?>"><?=$value->area_name?></label>
									</div>
								<?php endforeach; ?>
							</div>
							<div class="row">
								<div class="col-md-12">
									<ul class="areaMyAddrBox">
										<?php if(!empty($delivery_address)): ?>
										<li class="areaMyAddr">* <?=$delivery_address[0]->area_name?>(<?=$delivery_address[0]->area_code?>) 주소 : <span class="bold clrBlue2"><?=$this->session->userdata('fsase')?>,</span> 
											<?=$delivery_address[0]->address?> <br>
										ZIP CODE: <?=$delivery_address[0]->postNum?>,
										TEL: <?=$delivery_address[0]->phoneNum?></li>
										<?php endif; ?>
									</ul>
									*입고완료 확인되면 배송요청,묶음배송 혹은 나눔배송요청 해주셔야 합니다
								</div>
							</div>
						</div>
						<p class="clearfix pHt30"></p>
						<input type="hidden" name="DLVR_TY_CD" id="DLVR_TY_CD" value="1">
						<div class="stepOrd-DlvrTy">
							<div class="orderStepTit">
								<p>
									<span class="stepTxt">STEP</span>
									<span class="stepNo">02</span>
								</p>
								<h4>수입방식을 선택해주세요.</h4>
							</div>
							<div class="order_table">
								<table class="order_write" summary="배송방식">
									<colgroup>
										<col width="15%"> 
										<col width="*"> 
									</colgroup>
									<tbody>
									<tr> 
										<td colspan="2">
											<div style="line-height:150%;padding:6px 0 0 0;">
												<ul class="rdoBox">
													<?php if(!empty($sends)): ?>
													<?php foreach($sends as $key_s=>$value_se): ?>
													<li>
														<label class="rdoFtBig">
															<input type="radio" name="REG_TY_CD" id="REG_TY_CD" rel="0" class="input_chk" value="<?=$value_se->id?>" <?php if($key_s==0){ echo "checked";} ?>> <?=$value_se->name?>
														</label>
													</li>
													<?php endforeach; ?>
													<?php endif; ?>
												</ul>
											</div>
											
										</td>
									</tr>
									</tbody>
								</table> 
							</div>
						</div>
						<p class="clearfix pHt30"></p>
						<div id="stepOrd-EtcTt">
							<div class="step_box">
								<p class="clearfix"></p>
								<div class="orderStepTit">
									<p>
										<span class="stepTxt">STEP</span>
										<span class="stepNo">03</span>
									</p>
									<h4>받는 사람 정보를 입력해주세요.</h4>
								</div>
								<div class="order_table clearfix">
									<table class="order_write" summary="주소검색, 우편번호, 주소, 상세주소, 수취인 이름(한글), 수취인 이름(영문), 전화번호, 핸드폰번호, 용도, 주민번호, 통관번호 셀로 구성"> 
										<colgroup>
											<col width="15%"> 
											<col width="35%"> 
											<col width="15%"> 
											<col width="35%"> 
										</colgroup>
										<tbody>
											<tr>
												<th>받는 사람</th>
												<td colspan="3">
													<div class="row">
														<div class="col-md-6 p-right-0">
															한글 <input value="<?= $orderInfos[0]['order']['strReceiverName'] ?>" type="text" name="ADRS_KR" id="ADRS_KR" maxlength="60"
															class="ipt_type1 w-80 input_txt2" required>
														</div>
														<div class="col-md-6 p-left-0">
															<a class="btn-sm btn btn-warning btn-round" href="javascript:fnPopMemAddr();">
																<span>주소록 가져오기</span>
															</a> 
														</div>
													</div>
													<div class="row my-10">
														<div class="col-md-6 p-right-0">
															영문 <input value="<?= $orderInfos[0]['order']['strReceiverName'] ?>" type="text" name="ADRS_EN" id="ADRS_EN" maxlength="60"
															class="ipt_type1 w-80 input_txt2" required>
														</div>												
													</div>
													<div class="row my-4">
														<div class="col-md-12">
															*사업자 영문명은 반드시 고쳐주세요 (한글발음나는대로 입력시 통관지연)
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<th>받는 사람 정보</th>
												<td colspan="3">
													<div class="form-row">
														<div class="form-group col-md-3">
															<label><input type="radio" class="form-check-input vm" name="RRN_CD" id="RRN_CD" value="1" checked>개인통관고유부호</label>
														</div>
														<div class="form-group col-md-3">
															<label><input type="radio" class="form-check-input vm " name="RRN_CD" id="RRN_CD" value="3"> 사업자등록번호</label>
														</div>
														<div class="form-group col-md-6">
															<input type="text" name="RRN_NO" id="RRN_NO" maxlength="20" class="input_txt2 m_num form-control" value="" required onfocus="fnFocusInExp( &#39;RRN_NO&#39;, aRrnCdNm[$(&#39;input[name=RRN_CD]:radio:checked&#39;).val()] );" onblur="fnFocusOutReg( &#39;RRN_NO&#39;, aRrnCdNm[$(&#39;input[name=RRN_CD]:radio:checked&#39;).val()], /[^a-zA-Z0-9]/g );">
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<th>주소 및 연락처</th>
												<td colspan="3">
													<div class="row">
														<label class="col-sm-2 pt-5">연락처</label> 
														<div class="col-md-10">
															<input type="text" name="MOB_NO1" id="MOB_NO1" maxlength="4" class="input_txt2 hp mb-2"  value="" title="전화번호 첫자리" required> -
															<input type="text" name="MOB_NO2" id="MOB_NO2" maxlength="4" class="input_txt2 hp mb-2"  value="" title="전화번호 중간자리" required> -
															<input type="text" name="MOB_NO3" id="MOB_NO3" maxlength="4" class="input_txt2 hp mb-2"  value="" title="전화번호 마지막자리" required>
														</div>
													</div>
													<div class="row my-10">
														<label class="col-sm-2 pt-10">우편번호</label> 
														<div class="col-sm-10">
															<input type="text" value="<?= $orderInfos[0]['order']['strPostCode'] ?>"  name="ZIP" id="ZIP" maxlength="8" class="input_txt2 form-control" value="" required readonly>
															<a class="btn btn-sm btn-warning btn-round" style="margin-top: 10px;" href="javascript:openDaumPostcode();">
																<span>우편번호 검색</span>
															</a>
														</div>
													</div>
													<div class="row my-10">
														<label class="col-sm-2 pt-10">주소</label>
														<div class="col-sm-10">
															<input type="text" value="<?= $orderInfos[0]['order']['strReceiverAddr1'] ?>" name="ADDR_1" id="ADDR_1" maxlength="100" class="input_txt2 adr form-control" value="" required readonly>
														</div>
													</div>
													<input type="hidden" name="ADDR_1_EN" id="ADDR_1_EN" value="">
													<input type="hidden" name="ADDR_2_EN" id="ADDR_2_EN" value="">
													<div class="row my-10">
														<label class="col-sm-2 pt-10">상세주소</label>
														<div class="col-sm-10">
															<input type="text" value="<?= $orderInfos[0]['order']['strReceiverAddr2'] ?>" name="ADDR_2" id="ADDR_2" maxlength="100" class="input_txt2 adr form-control " value="">
														</div>
													</div>
													<div class="row">
														<div class="col-sm-2"></div>
														<div class="col-sm-10 pt-10">
															* 도로명 주소를 써주세요. 지번 주소 기재 시 통관/세관에서 오류로 분류시켜 통관지연이 될 수 있습니다
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<th><?=$page_label?> 요청 사항</th>
												<td colspan="3">
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
														<input  type="text" value="<?= $orderInfos[0]['order']['strParcelPrintMessage'] ?>" name="REQ_1" id="REQ_1" maxlength="100" class="input_txt2 full form-control" value="">
														<p class="pt-10">* 국내 배송기사 분께 전달하고자 하는 요청사항을 남겨주세요(예: 부재 시 휴대폰으로 연락주세요.)</p>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<input type="hidden" name="sProNum" id="sProNum" value="<?=count($orderInfos)?>" readonly="">
							<div class="step_box">
								<p class="clrBoth pHt30"></p>
								<div class="row">
									<div class="col-md-4 p-left-0">
										<select class="form-control" id="types_order">
											<option value="0">==선택==</option>
											<?php if($options =="buy"): ?>
												<option value="2">타오바오 장바구니 복사</option>
												<option value="4">알리바바 장바구니 복사</option>
											<?php endif; ?>
											<?php if($options !="buy"): ?>
												<option value="1">타오바오 주문복사</option>											
												<option value="3">알리바바 주문복사</option>
											<?php endif; ?>																						
										</select>
									</div>
									<div class="col-md-4 p-left-5 p-right-5">
										<a href="javascript:opentao();" class="btn btn-danger  btn-round w-100">타오바오&알리바바-장바구니&주문복사</a>
									</div>
									<div class="col-md-2 p-left-5 p-right-5">
										<a href="javascript:registerProducts();" class="btn btn-danger btn-round w-100" >상품 등록하기</a>
									</div>
									<div class="col-md-2 p-right-0 p-left-5">
										<button type="button" class="btn btn-warning btn-round w-100"  data-toggle="modal" data-target=".bd-example-modal-lg">등록방법</button>	
									</div>
								</div>
								<div class="row my-10">
									<div class="col-md-12 p-left-0 p-right-0">
										<div class="taoali" style="display: none;">
											<div name="cartSub" id="ie-clipboard-contenteditable" contenteditable="true" 
											style="border:1px solid #fc6504; overflow: auto;height: 300px"></div>
										</div>
									</div>
								</div>
							</div>							
							<div class="step_box">
								<p class="clrBoth pHt30"></p>
								<div class="orderStepTit">
									<p>
										<span class="stepTxt">STEP</span>
										<span class="stepNo">04</span> 
									</p>
									<h4>상품 정보를 입력해 주세요</h4>
								</div>
                                <?php  $no = 1;  $prdTotalCnt=0; $prdTotalPrice = 0; ?>
                                <?php foreach($orderInfos as $orderInfo): ?>

                                    <div id="TextProduct1" class="clrBoth pro_p">
                                        <input type="hidden" name="ARV_STAT_CD" id="ARV_STAT_CD" value="1">
                                        <div class="order_table order_table_top">
                                            <table class="proBtn_write w-100">
                                                <tbody>
                                                <tr class="border">
                                                    <td>
                                                        <h4 class="s_tit vm_box" style="color:#ed7d31;">
                                                            <label style="font-size:14px;">상품#<?= $no++ ?></label>
                                                            <input type="text" name="StockTxt" id="StockTxt"  class="stock-font" readonly>
                                                            <input type="hidden" name="PRO_STOCK_SEQ" id="PRO_STOCK_SEQ" value="0">
                                                        </h4>
                                                    </td>
                                                    <td class="text-right">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <a href="javascript:fnPageCopy2('1','<?=$options?>');"
                                                                   type="button" class="btn btn-warning btn-sm btn-round">상품복사</a>
                                                                <a href="javascript:fnProPlus('1','<?=$options?>');"
                                                                   class="btn btn-danger btn-sm btn-round">+상품추가</a>
                                                                <button type="button" class="btn btn-danger btn-sm btn-round"
                                                                        onclick="fnStockTempDel(1)">-상품삭제</button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="order_table">
                                            <table class="order_write">
                                                <colgroup>
                                                    <col width="15%"><col width="35%">
                                                    <col width="15%"><col width="35%">
                                                </colgroup>
                                                <tbody>
                                                <?php  if($options !='buy'){ ?>
                                                    <tr id="DLVR_1">
                                                        <th>트래킹번호<br>Tracking No.</th>
                                                        <td colspan="3" class="vm_box">
                                                            <div class="row">
                                                                <div class="col-md-2 form-group tracks p-right-15">
                                                                    <select name="FRG_DLVR_COM" class="form-control" id="FRG_DLVR_COM">
                                                                        <?php foreach($tracking_header as $value): ?>
                                                                            <option value="<?=$value->name?>"><?=$value->name?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4 form-group tracks p-right-15">
                                                                    <input type="text" class="input_txt2 form-control" name="FRG_IVC_NO"
                                                                           id="FRG_IVC_NO" maxlength="40">
                                                                </div>
                                                                <div class="col-md-4 form-group">
                                                                    <label>
                                                                        <input type="checkbox" name="TRACKING_NO_YN" id="TRACKING_NO_YN"
                                                                               value="Y" onchange="fnTrkNoAfChk('1');">트래킹 번호 나중에 입력
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr id="ORD_1">
                                                        <th>오더번호</th>
                                                        <td colspan="3" class="vm_box">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="text" class="input_txt2 per40 form-control" name="SHOP_ORD_NO"
                                                                           id="SHOP_ORD_NO" maxlength="40" value="<?=$orderInfo['order']['strOrdererNumber']?>">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th>

                                                        <p class="goods_img"><img src="/template/images/sample_img.jpg" width="109"
                                                                                  height="128" id="sImgNo1"></p>
                                                        <br><a class="btn-small  btn-secondary btn" href="javascript:openPopupImg(1)"
                                                               data-img="1"><span>이미지등록</span></a>
                                                    </th>
                                                    <td colspan="3">
                                                        <div class="row my-10">
                                                            <label class="col-sm-2 pt-10">* 통관품목</label>
                                                            <div class="col-md-4 p-right-15">
                                                                <select name="PARENT_CATE" class="form-control"
                                                                        onchange="fnArcAjax(this.value,'1');">
                                                                    <option value="-1">==1차 카테고리==</option>
                                                                    <?php if(!empty($category)): ?>
                                                                        <?php foreach($category as $value): ?>
                                                                            <option value="<?=$value->id?>"><?=$value->name?></option>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select name="ARC_SEQ" class="form-control" id="TextArc_1"
                                                                        onchange="fnArcChkYN('1',this.value);">
                                                                    <option value="" rel>품목은 정확하게 선택해주세요</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-2"></div>
                                                            <div class="col-md-10" style="padding-top: 7px;">
                                                                카테고리에 없는 품목은 직접 영문명 상세기재 바랍니다.
                                                            </div>
                                                        </div>
                                                        <div class="row my-10">
                                                            <label class="col-sm-2 pt-10">* 상품명</label>
                                                            <div class="col-md-4">
                                                                <input type="text" value="<?=$orderInfo['strVendorItemPackageName']."---".$orderInfo['product_item']['strSubItemName']?>" class="input_txt2 per40 form-control en_product_name" name="PRO_NM" id="PRO_NM" maxlength="200"  title="상품명" required onblur="javascript:fnValKeyRep( /[^a-zA-z0-9 \,\.\-]/g, this );" placeholder="영문">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-2"></div>
                                                            <div class="col-md-10" style="padding-top: 7px;">
                                                                정확한 작성을 해주셔야 통관지연을 막을수 있습니다.
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $prdTotalCnt += $orderInfo['nShippingCount'];
                                                        $prdTotalPrice += $orderInfo['product_item']['nSubItemBasePrice']*$orderInfo['nShippingCount'];
                                                        ?>
                                                        <div class="row my-10">
                                                            <label class="col-sm-2 pt-10">* 단가</label>
                                                            <div class="col-md-4 p-right-15">
                                                                단가
                                                                <input type="text" value="<?=number_format($orderInfo['product_item']['nSubItemBasePrice'], 2)?>" class="input_txt2 per20 form-control-custom COST"
                                                                       name="COST"  maxlength="10" value="0" title="단가" required
                                                                       onblur="fnNumChiper(this, '2');fnTotalProPrice();">
                                                            </div>
                                                            <div class="col-md-4">
                                                                수량&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <input type="text" value="<?=$orderInfo['nShippingCount']?>" class="input_txt2 per20 form-control-custom QTY"
                                                                       name="QTY"  maxlength="5" value="1" title="수량" required
                                                                       onblur="fnNumChiper(this, '0');fnTotalProPrice();">
                                                            </div>
                                                        </div>
                                                        <div class="row my-10">
                                                            <label class="col-sm-2 pt-10">* 옵션</label>
                                                            <div class="col-md-4 p-right-15">
                                                                색상
                                                                <input type="text" value="<?=$orderInfo['product_item']['strSubItemKoOptionPattern0']?>" class="input_txt2 per20 form-control-custom" name="CLR"
                                                                       id="CLR" maxlength="100"  title="색상(영문)">
                                                            </div>
                                                            <div class="col-md-4">
                                                                사이즈
                                                                <input type="text" value="<?=$orderInfo['product_item']['strSubItemKoOptionPattern1']?>" class="input_txt2 per20 form-control-custom" name="SZ"
                                                                       id="SZ" maxlength="80"  title="사이즈">
                                                            </div>
                                                        </div>
                                                        <div class="row my-10">
                                                            <label class="col-sm-2 pt-10">* 상품URL</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" value="<?=$orderInfo['strProductUrl']?>" class="input_txt2 full form-control" name="PRO_URL"
                                                                       id="PRO_URL" maxlength="500"  title="상품URL">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-2"></div>
                                                            <div class="col-md-10" style="padding-top: 7px;">
                                                                검수가 필요하신 분들은 정확한 URL주소를 넣어주세요
                                                            </div>
                                                        </div>
                                                        <div class="row my-10">
                                                            <label class="col-sm-2 pt-10 fs-12">* 이미지URL	</label>
                                                            <div class="col-sm-10">
                                                                <input value="<?=$orderInfo['product_item']['strSubItemImage']?>" type="text" class="input_txt2 full form-control" name="IMG_URL"
                                                                       id="IMG_URL" maxlength="500">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div id="TextProduct<?= $no ?>" class="pro_p"></div>
								<p class="clrBoth pHt30"></p>
								<div class="orderStepTit gold_element">
									<h4>금액 정보</h4>
								</div>
								<div class="order_table">
									<table class="order_write">
										<colgroup>
											<col width="15%"> 
											<col width="30%">  
											<col width="*">  
										</colgroup>   
										<tbody>
											<tr> 
												<td rowspan="3">
													<ul class="proTtAmt">
														<li><span class="fl">총 수량</span> <span class="fr"><span id="TextTotalProCNT" class="proTtQtyTxt"><?=$prdTotalCnt?> 개</span></span> </li>
														<li><span class="fl">총 금액</span>  <span class="fr">￥<span id="TextTotalAmt" class="proTtAmtTxt"><?=number_format($prdTotalPrice, 2)?></span></span> </li>
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
								<p class="clrBoth pHt30"></p>
								<div class="orderStepTit">
									<p>
										<span class="stepTxt">STEP</span>
										<span class="stepNo">05</span>
									</p>
									<h4>요청사항을 입력해 주세요</h4>
								</div>
								<div class="order_table">
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
															<input type="checkbox" class="input_chk" name="EtcDlvr"  mny="<?=$chd['price']?>" value="<?=$chd['id']?>" onclick="fnEtcSvcChk($(this));"><?=$chd['name']?>
															<span style="color:#d30009;font-weight:bold;">
																(<?= $chd['price'] == 0 ? '무료':number_format($chd['price']).'원' ?>)
															</span>
														</label>
														<label>- <?=$chd['description']?></label>
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
													<input type="text" name="REQ_2" id="REQ_2" maxlength="100" class="input_txt2 full form-control" value="">
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div style="margin-top: 15px;">
						<?php if(isset($options) && $options=="buy"): ?>
							<button  class="btn  btn-danger accept btn-round"   id="requestAccept" 
							data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중">구매견적</button>
						<?php endif; ?>
						<?php if(!isset($options) || $options !='buy'): ?>
							<button  class="btn   accept btn-round btn-warning"  id="waitAccept" 
							data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중">접수대기</button>
							<button  class="btn  btn-danger accept btn-round"   id="requestAccept" 
							data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중">접수신청</button>
						<?php endif; ?>
						<?php if($options != "buy"): ?>
						<p class="text-danger pt-10">
						트래킹번호 나중에 입력하실려면 접수대기만 선택 가능합니다.<br>
                        타오바오에서 트래킹번호 확인되면 마이페이지에서 수정하여 입력후 접수신청을 하면 됩니다.<br>
                        (트래킹번호 미 입력시 입고지연 될수 있습니다.)  
                        </p>
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
     <div>
     	<a target="_blank" href="/assets/images/<?=$options?>.jpg"><img src="/assets/images/<?=$options?>.jpg" class="w-100"></a>
     </div>
    </div>
  </div>
</div>
<link href="<?php echo site_url('/template/css/delivery.css'); ?>?<?=time()?>" rel="stylesheet">
<script>
	var userId = <?=$this->session->userdata("fuser")?>;
	var userName = "<?=$this->session->userdata('fname')?>";
	var options = "<?=$options?>";
</script>
<script type="text/javascript" src="/template/js/delivery.js?" defer></script>
<script type="text/javascript" src="/template/js/new_delivery.js?<?=time()?>" defer></script>