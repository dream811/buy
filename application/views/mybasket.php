<?php 
$ee = array('sea'=>"해운특송",'sky'=>"항공특송");
?>
<script>
	var	sea=<?=$sea?>,sky=<?=$sky?>,
	weights_sea = jQuery.parseJSON('<?=$weights_sea?>'),
	weights_sky = jQuery.parseJSON('<?=$weights_sky?>');
	var by_delivery = <?=$by_delivery?>,s_delprice = <?=$s_delprice?> ;
	var review_count = Array();
	review_count["sea"] = <?=$mybasket_sea?>;
	review_count["sky"] = <?=$mybasket_sky?>;
	var userId = <?=$this->session->userdata("fuser")?>;
	var userName = "<?=$this->session->userdata('fname')?>";
</script>
<div class="container">
	<div class="row">
		<div id="subRight" class="col-md-12">
			<div class="padgeName">
				<h2>장바구니</h2>
				<div class="sub_name">구매하기 전 옵션 및 수량 등을 꼭 확인해주세요.</div>
			</div>
			<div class="con">
				<form action="/makeorder" method="post" class="my-15" id="bakset_form">
					<input type="hidden" name="mode" id="mode">
					<input type="hidden" name="type_delete" id="type_delete">
					<input type="hidden" name="inv" id="inv">
					<?php foreach($ee as $key_ee => $ee_ch):?>
					<?php $mybasket = "mybasket_".$key_ee; ?>
					
					<?php if($key_ee=="sky"): ?>
					<div class="padgeName m-0 p-0" style="height: auto;">
						<div class="sub_name"></div>
					</div>	
					<?php endif;?>
					<div class="cm_shop_entered">
						<span class="name"><?=$ee_ch?></span>
					</div>
					<div class="t_board mt20 mb-10">
						<div class="table-responsive">
							<table class="table request_deposit_table table-bordered">
								<colgroup>
									<col width="150px">
									<col width="400px">
									<col width="100px">
									<col width="*">
								</colgroup>
							    <thead class="thead-jin">
							      <tr>
							        <th scope="col">상품정보</th>
							        <th scope="col">상품명</th>
							        <th scope="col">신청개수</th>
							        <th scope="col">상품금액</th>
							        <th scope="col">옵션</th>
							        <th>배송비</th>
							      </tr>
							    </thead>
							    <tbody class="tbody_<?=$key_ee?>">
							    	
							    </tbody>
							</table>
							<div class="ctrl_btn">
								<span class="button_back">
									<a href="javascript:checkProduct('basket_<?=$key_ee?>')" class="btn btn-secondary btn-sm">전체상품 선택/해제</a>
								</span>
								<span class="button_back">
									<a href="javascript:cart_select_delete('<?=$key_ee?>')" class="btn btn-secondary btn-sm">선택상품 삭제</a>
								</span>
								<!-- <span class="button_back">
									<a href="javascript:cart_select_delete('<?=$key_ee?>','all_delete')" class="btn btn-default btn-sm">장바구니 비우기</a>
								</span> -->
								<span class="button_back">
									<a href="javascript:deleteSolded('<?=$key_ee?>')" class="btn btn-default btn-sm">품절상품 모두삭제</a>
								</span>
							</div>
							<div class="text-center my-4">
					   			<a  class="btn btn-default more_<?=$key_ee?>" onclick="moreBasket('<?=$key_ee?>')">장바구니 상품 더보기</a>
					   		</div>
							<div class="cm_shop_cart_sum my-15">
								<span class="lineup">
									<span class="box equal_box">
										<span class="icon"></span>
										<div class="inline-block m-r-20">
											<span class="txt font-weight-bold">총 결제예상금액</span>
											<span class="price price_<?=$key_ee?>">
												<strong></strong>
												<em>원</em>
											</span>
										</div>
										<div class="inline-block">
											<span class="txt font-weight-bold">타오달인 할인금액</span>
											<span class="price halin_<?=$key_ee?>">
												<strong></strong>
												<em>원</em>
											</span>
										</div>
									</span>
								</span>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
					<div id="deliverForm" class="d-none">
						<div class="cm_shop_title" id="DLVR_TY_CD_TEMP">
							<strong class="text-danger font-weight-bold">받는분 배송</strong> 정보
						</div>
						<div class="cm_order_form mb-10">
							<input type="hidden" name="sProNum" id="sProNum" value="1" readonly>
							<ul>
								<li class="ess">
									<span class="opt">받는분 이름 한글</span>
									<div class="value">
										<input type="text" name="ADRS_KR" id="ADRS_KR" maxlength="60" class="input_txt2" required="">
										<a href="javascript:fnPopMemAddr();" class="btn-sm btn btn-warning btn-round">주소록 가져오기</a>
									</div>
								</li>
								<li class="ess">
									<span class="opt">영문</span>
									<div class="value">
										<input type="text" name="ADRS_EN" id="ADRS_EN" maxlength="60" class="input_txt2" required="">
									</div>
								</li>
								<li class="ess">
									<span class="opt">받는 사람 정보	</span>
									<div class="value">
										개인통관고유부호
										<input type="text" name="RRN_NO" id="RRN_NO" maxlength="20" class="input_txt2 m_num" required>			
									</div>
								</li>
								<li class="ess ">
									<span class="opt">받는분 주소</span>
									<div class="value">
										<input type="text" name="ZIP" id="ZIP" maxlength="8" class="input_txt2"  required readonly style="width: 200px" placeholder="우편번호">
										<span class="m-r-8">
											<a href="javascript:openDaumPostcode();" class="btn-sm btn btn-warning btn-round">우편번호 검색</a>
										</span>
										
										<div class="input_double my-10">
											<div class="input_wrap">
												<div>
													<input type="text" name="ADDR_1" id="ADDR_1" maxlength="100" class="form-control"  required readonly placeholder="주소">
												</div>
											</div>
											<input type="hidden" name="ADDR_1_EN" id="ADDR_1_EN" value="">
											<input type="hidden" name="ADDR_2_EN" id="ADDR_2_EN" value="">
											<div class="input_wrap my-10">
												<div>
													<input type="text" name="ADDR_2" id="ADDR_2" maxlength="100" class="form-control" placeholder="상세주소">
												</div>
											</div>
										</div>
									</div>
								</li>

								<li class="ess">
									<span class="opt">받는분 휴대폰</span>
									<div class="value">
										<input type="text" name="MOB_NO1" id="MOB_NO1" maxlength="4" class="input_txt2" 
										title="전화번호 첫자리" required style="width: 80px">
										<span class="dash"></span>
										<input type="text" name="MOB_NO2" id="MOB_NO2" maxlength="4" class="input_txt2" 
										title="전화번호 중간자리" required style="width: 80px">
										<span class="dash"></span>
										<input type="text" name="MOB_NO3" id="MOB_NO3" maxlength="4" class="input_txt2" 
										title="전화번호 마지막자리" required style="width: 80px">
									</div>
								</li>
								<li class="">
									<span class="opt">배송 요청 사항</span>
									<div class="value">
										<select  class="input_txt2" id="exampleFormControlSelect1" onchange="fnReqValGet(this.value);">
											<option>직접기재</option>
									      	<option value="배송 전 연락 바랍니다">배송 전 연락 바랍니다</option>
									      	<option value="부재시 경비실에 맡겨주세요">부재시 경비실에 맡겨주세요</option>
									      	<option value="부재시 집앞에 놔주세요">부재시 집앞에 놔주세요</option>
									      	<option value="택배함에  맡겨주세요">택배함에  맡겨주세요</option>
										</select>
										<div class="my-15">
											<input  type="text" name="REQ_1" id="REQ_1" maxlength="150" class="form-control">
											<p style="padding-top: 10px">* 국내 배송기사 분께 전달하고자 하는 요청사항을 남겨주세요(예: 부재 시 휴대폰으로 연락주세요.)</p>
										</div>
									</div>
								</li>
							</ul>
						</div>
						
					</div>
					<div class="my-10 text-center">
						<a href="<?=base_url("shopping")?>" class="btn btn-lg btn-default">쇼핑계속하기</a>
						<input type="submit" class="btn  btn-danger  btn-lg accept d-none" value="&nbsp;&nbsp;&nbsp;구매하기&nbsp;&nbsp;&nbsp;" id="requestAccept">
						<a href="javascript:visibleForm()" class="btn btn-lg btn-danger enable-purchase">&nbsp;&nbsp;&nbsp;구매하기&nbsp;&nbsp;&nbsp;</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script  id="basket_list" type="text/x-handlebars-template">
<tr id="pid_{{id}}" class='{{#if_eq puse}}e_disabled{{/if_eq}} {{#if_eq pcount}}sold_out{{/if_eq}}'>
	<td class="mid">
		<input type="hidden" class="all_product_price" value="{{multiple price count 1}}">
		<input type="hidden" class="this_delivery" value="{{delivery_price}}">
		<input type="hidden" class="unit" value="{{price}}">
		<input type="hidden" class="weight" value="{{weight}}">
		<input type="hidden" class="type" value="{{p_shoppingpay_use}}">
		<input type="checkbox" name="basket_{{delivery_method}}[]" value="{{id}}" class="basket_{{delivery_method}}" onchange="updateSum('{{delivery_method}}')" {{#if_eq_both puse pcount}}disabled{{/if_eq_both}} id="bats{{id}}">
		<a href="/view/shop_products/{{rid}}" target="_blank">
			<img class="lazy" data-original="/upload/shoppingmal/{{productId}}/{{image}}" width="100" height="100" 
			alt="{{sname}}" title="{{sname}}">
		</a>
	</td>
	<td class="mid"><span class="pg_name">
		{{sname}}</span> {{#if_eq_both puse pcount}}<a href="javascript:deleteChecked({{id}},'{{delivery_method}}')" class="text-danger font-weight-bold">X</a>{{/if_eq_both}}
		
		<div>
			{{#if_eq pcount}}<span class="font-weight-bold text-danger pt-10">SOLD OUT</span>{{/if_eq}}
			{{#if_eq puse}}<span class="font-weight-bold text-danger pt-10 m-l-0">판매종료</span>{{/if_eq}}
		</div>	
	</td>

	<td class="mid">
		<input type="number" class="form-control pg_count" value="{{count}}" onchange="
		changeShopCount({{id}},$(this).val(),{{pcount}},'{{delivery_method}}')" {{#if_eq_both puse pcount}}disabled{{/if_eq_both}}>
	</td>
	<td class="mid pg_price"><span>{{multiple price count 2}}</span>원</td>
	<td class="mid">{{{size}}}</td>
	<td class="mid pg_delivery"><span class="delp">{{accurate delivery_price}}</span>원</td>
</tr>
</script>
<link href="<?php echo site_url('/template/css/shop.css'); ?>?<?=time()?>" rel="stylesheet">
<link href="<?php echo site_url('/template/css/baseket.css'); ?>?<?=time()?>" rel="stylesheet">
<script src="<?php echo site_url('/assets/js/jquery.validate.js') ?>"></script>
<script src="<?php echo site_url('/template/js/shop.js')?>?<?=time()?>"></script>
<script src="<?php echo site_url('/template/js/basket.js')?>?<?=time()?>"></script>
<script type="text/javascript" src="/template/js/delivery.js?<?=time()?>"></script>