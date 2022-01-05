<? $site = $pageTitle; ?>
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
<link href="<?php echo site_url('/template/css/shop.css?'.time());?>" rel="stylesheet">
<link href="<?php echo site_url('/template/css/basket.css?'.time());?>" rel="stylesheet">
<div class="container">
	<?php 

	$data['tt'] = 2;
	$data['t'] = 1;?>
	<?php $this->load->view("shop_header",$data); ?>
<div class="container">
	<div id="subRight" >
		<div class="con">
			<form action="/makeorder" method="post" id="bakset_form">
				<input type="hidden" name="mode" id="mode">
				<input type="hidden" name="type_delete" id="type_delete">
				<input type="hidden" name="inv" id="inv">
				<div class="t_board mt20 p-5">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<?php foreach($ee as $key_ee => $ee_ch):?>
					  	<li class="nav-item <?=$key_ee == "sea" ? "active" : ""?>">
					    	<a class="nav-link" id="<?=$key_ee?>-tab" data-toggle="tab" href="#content_<?=$key_ee?>" role="tab" aria-controls="<?=$key_ee?>" aria-selected="true"><?=$ee_ch?>
					    	</a>
					  	</li>
					  	<?php endforeach;?>
					</ul>

					<div class="tab-content" id="myTabContent">
						<?php foreach($ee as $key_ee => $ee_ch):?>
						<div class="tab-pane fade <?=$key_ee == "sea" ? "active in" : ""?>"   role="tabpanel" 
							aria-labelledby="<?=$key_ee?>-tab" id="content_<?=$key_ee?>">
							<div class="row mt-10">
								<div class="col-xs-4 p-right-5 ">
									<a href="javascript:checkProduct('basket_<?=$key_ee?>')" class="btn btn-default btn-xs ">전체 선택/해제</a>
								</div>
								<div class="col-xs-8 text-right p-left-5 ">
									<a href="javascript:cart_select_delete('<?=$key_ee?>')" class="btn btn-secondary btn-xs ">선택상품 삭제</a>
									<!-- <a href="javascript:cart_select_delete('<?=$key_ee?>','all_delete')" class="btn btn-secondary btn-xs ">장바구니 비우기</a> -->
                                    <a href="javascript:deleteSolded('<?=$key_ee?>')" class="btn btn-secondary btn-xs ">품절상품 모두삭제</a>
								</div>
							</div>
							<ul class="tbody_<?=$key_ee?>">
								
							</ul>
                            <div class="text-center my-4">
                                <a  class="btn btn-default more_<?=$key_ee?>" 
                                    onclick="moreBasket('<?=$key_ee?>')">장바구니 상품 더보기</a>
                            </div>
							<div class="pay_due">
						        <div class="pay_info">
						            <span class="lineup">
										<span class="box equal_box">
											<span class="icon"></span>
											<div class="inline-block m-r-20">
												<span class="txt font-weight-bold">총 결제예상금액</span>
												<span class="price_<?=$key_ee?> price_bottom">
													<strong>0</strong>
													<em>원</em>
												</span>
											</div>
											<div class="inline-block">
												<span class="txt font-weight-bold">타오달인 할인금액</span>
												<span class="halin_<?=$key_ee?> price_bottom">
													<strong>0</strong>
													<em>원</em>
												</span>
											</div>
										</span>
									</span>
						        </div>
						        <div class="smt1">
						        	<a class="btn btn-danger btn-block btn-lg" 
							        onclick="javascript:visibleForm(); return false">
							            구매하기
							        </a>
						        </div>
						        <div class="smt2 d-none">
						        	<div class="row">
						        		<div class="col-xs-6 p-left-0 p-right-5">
						        			<a href="javascript:visibleForm()"  
						        				class="btn btn-grey btn-block btn-lg">쇼핑 계속하기</a>
						        		</div>
						        		<div class="col-xs-6 p-right-0 p-left-5">
						        			<input type="submit" value="구매하기" 
						        			class="btn btn-danger btn-block btn-lg">
						        		</div>
						        	</div>
						        </div>
						    </div>		
						</div>
						<?php endforeach;?>
					</div>
				</div>
				<div id="deliveryForm" class="d-none">
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
                                            <div class="col-md-6 mb-5 p-right-0">
                                                한글
                                                <div class="row">
                                                    <div class="col-xs-6 p-3">
                                                        <input type="text" name="ADRS_KR" id="ADRS_KR" maxlength="60" class="input_txt2 ipt_type1 form-control" required placeholder="한글 이름을 입력하세요">
                                                    </div>
                                                    <div class="col-xs-6 p-3">
                                                        <a class="ft-12 btn-sm btn btn-warning btn-round" href="javascript:fnPopMemAddr();" style="padding: 5px 6px;">
                                                        <span>주소록 가져오기</span></a> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-5">
                                                영문
                                                <input type="text" name="ADRS_EN" id="ADRS_EN" maxlength="60" class="input_txt2 ipt_type1 form-control" required placeholder="영문[대문자]이름을 입력하세요">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p class="imt_t">*사업자 영문명은 반드시 고쳐주세요
                                                    <br>한글발음나는대로 입력시 통관지연합니다</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>받는 사람 정보</th>
                                    <td colspan="3">
                                        <div class="form-row p-left-15">
                                            <div class="col-md-6">
                                                <label>개인통관고유부호</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="RRN_NO" id="RRN_NO" maxlength="20" 
                                                class="input_txt2 m_num form-control"  required>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>주소 및 연락처</th>
                                    <td colspan="3">
                                        <div class="row">
                                            <label class="col-md-4 col-md-2 mt-10 p-right-0">연락처</label> 
                                            <div class="col-md-8 col-md-4">
                                                <div class="row">
                                                    <div class="col-xs-4 p-3">
                                                        <input type="text" name="MOB_NO1" id="MOB_NO1" maxlength="4" class="form-control  w-100 mb-2"  value="" title="전화번호 첫자리" required>
                                                    </div>
                                                    <div class="col-xs-4 p-3">
                                                        <input type="text" name="MOB_NO2" id="MOB_NO2" maxlength="4" class="form-control  w-100 mb-2"  value="" title="전화번호 중간자리" required> 
                                                    </div>
                                                    <div class="col-xs-4 p-3">
                                                        <input type="text" name="MOB_NO3" id="MOB_NO3" maxlength="4" class="form-control  w-100 mb-2"  value="" title="전화번호 마지막자리" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-10">
                                            <label class="col-md-2">우편번호
                                                <a class="btn-sm btn-round btn btn-sm btn-warning" href="javascript:openDaumPostcode();">
                                                    <span>우편번호 검색</span>
                                                </a></label> 
                                            <div class="col-md-10">
                                                <input type="text" name="ZIP" id="ZIP" maxlength="8" class="input_txt2 form-control w-100"  required readonly>
                                            </div>
                                        </div>
                                        <div class="row mt-10">
                                            <label class="col-sm-2">주소</label>
                                            <div class="col-sm-2">
                                                <input type="text" name="ADDR_1" id="ADDR_1" maxlength="100" class="adr form-control w-100" required readonly>
                                            </div>
                                        </div>
                                        <input type="hidden" name="ADDR_1_EN" id="ADDR_1_EN" value="">
                                        <input type="hidden" name="ADDR_2_EN" id="ADDR_2_EN" value="">
                                        <div class="row mt-10">
                                            <label class="col-sm-2">상세주소</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="ADDR_2" id="ADDR_2" maxlength="100" class="adr form-control w-100" >
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
                                    <th>요청 사항</th>
                                    <td colspan="3">
                                        <div class="row pt-5">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <select class="form-control" id="exampleFormControlSelect1" onchange="fnReqValGet(this.value);">
                                                      <option>직접기재</option>
                                                      <option value="배송 전 연락 바랍니다">배송 전 연락 바랍니다</option>
                                                      <option value="부재시 경비실에 맡겨주세요">부재시 경비실에 맡겨주세요</option>
                                                      <option value="부재시 집앞에 놔주세요">부재시 집앞에 놔주세요</option>
                                                      <option value="택배함에  맡겨주세요">택배함에  맡겨주세요</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <input  type="text" name="REQ_1" id="REQ_1" maxlength="100" class="input_txt2 full form-control" value="">
                                                    <p style="padding-top: 10px">* 국내 배송기사 분께 전달하고자 하는 요청사항을 남겨주세요(예: 부재 시 휴대폰으로 연락주세요.)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
    			</div>
			</form>
		</div>
	</div>
</div>
<script src="<?=base_url_home()?>assets/js/jquery.validate.js"></script>
<script src="<?php echo site_url('/template/js/shop.js')?>?<?=time()?>"></script>
<script src="<?php echo site_url('/template/js/basket.js')?>?<?=time()?>"></script>
<script type="text/javascript" src="/assets/js/delivery.js?<?=time()?>"></script>
<script type="text/javascript">

	function deleteBasket(id){
		var confirmation = confirm("변경하시겠습니까?");
		if(confirmation)
			jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : baseURL+"deleteBasket",
				data : { id : id } 
				}).done(function(data){
					if(data==1)	window.location.reload();
			});
	}
</script>

<script  id="basket_list" type="text/x-handlebars-template">

<li class="p-10 {{{check_out this}}}" id="pidp_{{productId}}">
	{{#if checked_add}}{{else}}
	<input type="hidden" class="all_product_price" value="{{multiple price count 1}}">
	<input type="hidden" class="this_delivery" value="{{delivery_price}}">
	<input type="hidden" class="unit" value="{{price}}">
	<input type="hidden" class="weight" value="{{weight}}">
	<input type="hidden" class="type" value="{{p_shoppingpay_use}}">
	{{/if}}
   <div class="prd_wrap">
      	<div class="list_top">
         	<label class="check_mid red ">
         		{{#if checked_add}}
         		<input type="checkbox" class="option_all  prodCheckBox{{delivery_method}}"  
	         	onclick="fnChkBoxTotalByClass(this, 'chkORD_SEQ{{productId}}');" data-parent=0>
         		{{else}}
         		<input type="checkbox" class="option_all  basket_{{delivery_method}} chkORD_SEQ{{productId}}" 
	         	name="basket_{{delivery_method}}[]" value="{{id}}" onchange="updateSum('{{delivery_method}}',{{id}},{{productId}})" data-parent={{productId}} 
	         	id="bats{{id}}"
                {{#if_eq_both puse pcount}}disabled{{/if_eq_both}} >
         		{{/if}}
	         	
	         	<i class="ico"></i>
         	</label>
         	<a  href="/view/shop_products/{{rid}}" target="_blink" class="gtm_alink prd_name">
         	{{sname}}</a>
         	<div>
				{{{disabled_o this}}}
			</div>	
      	</div>
      	<div class="list_mid">
        	<a  href="/view/shop_products/{{rid}}" target="_blink"  class="prd_img gtm_alink">
        		<img data-original="{{pc_url}}upload/shoppingmal/{{productId}}/{{image}}" alt="{{sname}}" class="lazy" width="76">
        	</a>
        	{{#if checked_add}}
        	<ul class="in_list">
        	{{{add_options this.add}}}
        	</ul>
        	{{else}}
        	<ul class="in_list">      
                <li id="pid_{{id}}">
                	<input type="hidden" class="all_product_price" value="{{multiple price count 1}}">
					<input type="hidden" class="this_delivery" value="{{delivery_price}}">
					<input type="hidden" class="unit" value="{{price}}">
					<input type="hidden" class="weight" value="{{weight}}">
					<input type="hidden" class="type" value="{{p_shoppingpay_use}}">
                    <div class="qty_wrap">     
                            <span class="quantity circle">
                            <button class="btn_qnt_minus" onclick="plusValue({{id}},'minusprevent t')" type="button"></button>
                            <input class="inp_qnt pg_count" type="number" value="{{count}}" title="수량" autocomplete="off" onchange="
							changeShopCount({{id}},$(this).val(),{{pcount}},'{{delivery_method}}',{{productId}})" {{#if_eq_both puse pcount}}disabled{{/if_eq_both}} id="pg{{id}}">
                            <button class="btn_qnt_plus" onclick="plusValue({{id}},'plus')" type="button"></button>
                        </span>
                        
                        <button class="btn_del_cart" onclick="deleteChecked({{id}},'{{delivery_method}}')" type="button">삭제</button>
                    </div>
                </li>
        	</ul>
        	{{/if}}
        </div>
        <div class="list_price">
	        <dl class="prd_price">
	            <dt>상품금액</dt>
	            <dd>
	               <strong class="pg_price">{{multiple pdtprice 1 2}}</strong>원
	            </dd>
	       	</dl>
	    </div>
    </div>
    <div class="list_btm">
      <dl>
         <dt class="price_tit">
            배송비
         </dt>
         <dd class="price_num pg_delivery">
            <span class="delp">{{multiple delp 1 2}}</span>원
         </dd>
      </dl>
   </div>
</li>       	



</script>