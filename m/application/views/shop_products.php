<link href="/template/css/slick-theme.css" rel="stylesheet">
<link href="/template/css/slick.css" rel="stylesheet">
<link href="<?php echo site_url('/template/css/product.css?'.time()); ?>" rel="stylesheet">
<link href="<?php echo site_url('/template/css/shop.css?'.time());?>" rel="stylesheet">
<link href="<?=base_url_home()?>assets/plugins/ratings/star-rating-svg.css" rel="stylesheet">
<link href="<?php echo site_url('/template/css/delivery.css');?>" rel="stylesheet">
<script src="<?=base_url_home()?>assets/plugins/ratings/jquery.star-rating-svg.js"></script>
<?php 
if(sizeof($product)) $uf = $product[0];
else return;
$i1 = $uf->i1!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i1:"";
$i2 = $uf->i2!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i2:"";
$i3 = $uf->i3!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i3:"";
$i4 = $uf->i4!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i4:"";
$i5 = $uf->i5!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i5:"";
$uf->description = str_replace("../../upload/tinymce/", base_url_home()."upload/tinymce/", $uf->description);
$uf->description = str_replace("../upload/tinymce/", base_url_home()."upload/tinymce/", $uf->description);
?>

<script>
	var o_type = new Array(),price = <?=$uf->singo?>,add_options = new Array(),init_add = 0,
	delivery_method="<?=$uf->p_shoppingpay_use ==1 && $uf->deliverybysky==1 && $uf->deliverybysea==0  ? "sky" : "sea"?>",
				output_adds = new Array(),sea=<?=$sea?>,sky=<?=$sky?>,
				weights_sea = jQuery.parseJSON('<?=$weights_sea?>'),weights_sky = jQuery.parseJSON('<?=$weights_sky?>');
	o_type.push("색상","색갈","칼러","칼라");
	var delivery_price = <?=$uf->p_shoppingpay_use ==1 && $uf->deliverybysky==1 && $uf->deliverybysea==0 ? $delivery_price[1] : $delivery_price[0]?>;
	var t_delivery = <?=$uf->p_shoppingpay_use?>;
	var by_delivery = <?=$siteInfo->s_delprice_free?>;
	var weight = <?=$uf->weight?>;
	var userId = "<?=$this->session->userdata("fuser")?>";
	var userName = "<?=$this->session->userdata('fname')?>";
</script>

	<?php 
	$data['category'] = $category;
	$data['tt'] = 3;
	$data['t'] = 1;?>
	<?php $this->load->view("shop_header",$data); ?>
<div class="container">
	<div id="subRight"  style="padding-top: 10px">
		<div class="con">
			<main class="pt-4">
			    <div class="dark-grey-text">
			      <!--Grid row-->
			      	<div class="row wow fadeIn">
			        <!--Grid column-->
				        <div class="col-md-6 mb-4">
				        	<div class="slicks">
				        		<?php if($i1!=""): ?>
				        		<div>
					        		<img src="<?=base_url_home()?><?=$i1?>" class="img-fluid w-100">
					        	</div>
				        		<?php endif; ?>
				        		<?php if($i2!=""): ?>
			        			<div>
					        		<img src="<?=base_url_home()?><?=$i2?>" class="img-fluid w-100">
					        	</div>
				        		<?php endif; ?>
				        		<?php if($i3!=""): ?>
				        		<div>
					        		<img src="<?=base_url_home()?><?=$i3?>" class="img-fluid w-100">
					        	</div>
				        		<?php endif; ?>
				        		<?php if($i4!=""): ?>
				        		<div>
					        		<img src="<?=base_url_home()?><?=$i4?>" class="img-fluid w-100">
					        	</div>
				        		<?php endif; ?>
				        		<?php if($i5!=""): ?>
				        		<div>
					        		<img src="<?=base_url_home()?><?=$i5?>" class="img-fluid w-100">
					        	</div>
				        		<?php endif; ?>
				        	</div>
				        </div>
				        <!--Grid column-->

				        <!--Grid column-->
				        <div class="col-md-6 mb-4">
				        	<input type="hidden" name="option_select_expricesum" id="option_select_expricesum" value="<?=$uf->singo?>">
							<input type="hidden" name="option_select_addsum" id="option_select_addsum" value="0">
				        	<?php echo form_open_multipart('basket_update',array("id"=>"deliverForm"));?>
				        		<input type="hidden" name="delivery_type" id="delivery_type">
								<input type="hidden" name="pcode" value="<?=$uf->rid?>" >
								<input type="hidden" name="color" class="color">
								<input type="hidden" name="size" class="size">
					        	<div>
					        		<h2 class="product-title"><?=$uf->name?></h2>
							          <!--Content-->
							        <div class="p-4 c-detail table-responsive">
							        	<table class="table borderless">
							        		<tr>
							        			<th class="mid">소비자가격</th>
							        			<td><?=number_format($uf->orgprice)?>원</td>
							        		</tr>
							        		<tr>
							        			<th class="mid">판매가격</th>
							        			<td><span class="font-weight-bold ft-14"><?=number_format($uf->singo)?></span>원</td>
							        		</tr>
							        		<tr>
							        			<th class="mid">포인트</th>
							        			<td><?=number_format($uf->point)?>P</td>
							        		</tr>
							        		<tr>
							        			<th class="mid">제조사/원산지 </th>
							        			<td ><?=$uf->brand?>/<?=$uf->wonsanji?></td>
							        		</tr>
							        		<?php if(!empty($add_options)): ?>
											<?php foreach($add_options as $value):?>
											<tr>
												<th class="mid">
													<label class="option-name"><?=$value->name?></label>
												</th>
												<td>
													<select class="form-control option-value"
													 data-name="<?=$value->name?>" name="product_feature[]" required 
													<?=$value->count <=0 ? "disabled":""?>>
														<option value="" data-price=0>선택</option>
														<?php if(!empty($second_arr[$value->id])): ?>
														<?php foreach($second_arr[$value->id] as $sec_val):?>
														<?php 
														$storage = "";
														$disabled = "";
														if($sec_val->count <=0){
															$storage = "(재고없음)";
															$disabled = "disabled";
														}
														?>
														<option value="<?=$sec_val->id?>" data-price="<?=$sec_val->supply?>"  
															<?=$disabled?> 
															data-insert="<?=$value->name?> : <?=$sec_val->name?>">
															<?=$sec_val->name?> <?php $min_value = $sec_val->supply - $uf->singo; ?>
															<?php if($min_value > 0): ?>
															 + <?=number_format($min_value)?>원
															<?php endif;?>
															<?=$storage?> 
														</option>
														<?php endforeach;?>
														<?php endif;?>
													</select>
												</td>
											</tr>			 
											<?php endforeach;?>
											<?php endif;?>
											<?php if($uf->p_shoppingpay_use ==1):?>
											<tr>
												<th class="mid">배송방식 </th>
												<td class="mid">
													<?php if(	($uf->deliverybysea ==1 && $delivery_price[0] > 0) || 
																	($uf->deliverybysky==1 && $delivery_price[1] > 0) ):  ?>
													<select name="delivery_method" class="form-control" id="delivery_method">
													<?php if($uf->deliverybysea ==1): ?>	
														<option  value="sea" data-price="<?=$delivery_price[0]?>">
														해운특송 (5일 ~ 7일) +<?=number_format($delivery_price[0])?>원
														</option>
													<?php endif; ?>
													<?php if($uf->deliverybysky ==1): ?>	
														<option  value="sky" data-price="<?=$delivery_price[1]?>">
														항공특송 (3일 ~ 5일) +<?=number_format($delivery_price[1])?>원
														</option>
													<?php endif; ?>
													</select>
													<?php endif; ?>	
												</td>
											</tr>
											<?php endif; ?>	
											<tr>
												<th class="mid">
													구매수량										
												</th>
												<td>
													<span class="quantity">
														<a class="decrease" href="javascript:void(0)" onclick="pro_cnt_down()">수량 감소</a>
														<a class="increase" href="javascript:void(0)" onclick="pro_cnt_up()">수량 증가</a>
														<input type="text" name="option_select_cnt" 
														class="updown_input valid" id="option_select_cnt" value="1" 
														data-max="<?=$uf->count?>" onblur="update_sum_price()" aria-invalid="false">
													</span>
												</td>
											</tr>
							        	</table>
							        </div>
							        <div class="c-detail__total">
										<span id="option_select_count_display">1</span>
										<span id="option_free_price_display">
											<em class="sky">
											<?php if($uf->p_shoppingpay_use ==2 || $delivery_price[0] ==0):?>
											무료배송	
											<?php endif;?>
											<<?php if($delivery_price[0] > 0):?>
											+배송비 <?=number_format($uf->deliverybysea ==1 || $uf->p_shoppingpay_use ==0 ? $delivery_price[0] : $delivery_price[1])?><br>
											<?php if($uf->p_shoppingpay_use ==0): ?>
											<span style='color:#999;margin-top: 5px'>
											(<?=number_format($siteInfo->s_delprice_free)?>원 이상 결제시 무료 배송)
											<?php endif; ?>
											</span>
											<?php endif;?>
											</em>
										</span>
										<strong id="option_select_expricesum_display"><?=number_format($uf->singo)?></strong>
									</div>
									<div class="product_top">
										<div class="item_review">
											<span class="tit">상품평점(총  <?=$review["review_count"]?>건)</span>
											<div class="my-rating-4 inline-block" data-rating="<?=$review["review"]?>"></div>
											<span class="live-rating"><?=number_format($review["review"],1,'.',',')?></span>
											<div class="likes_product inline-block">
								        		<button type="button" id="like-add" class="c_product_btn c_product_btn_pick 
								        		<?=$wish > 0 ? "if_wish":"not_if_wish"?>" data-pcode="<?=$uf->rid?>">
								        			<span></span>
								        		</button>
												<button type="button" class="c_product_btn c_product_btn_share">
													<span></span>
												</button>
								        	</div>
								        	<div class="shared_buttons p-10 disabled_btns">
								        		<p class="mb-10 font-weight-bold">공유하기</p>
								        		<div class="fb-share-button" data-href="<?=current_self()?>" data-layout="button" data-size="large">
											      	<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=current_self()?>" class="fb-xfbml-parse-ignore"></a>
											    </div>
											    <a href="https://twitter.com/share?ref_src=<?=current_self()?>" class="twitter-share-button" data-size="large" data-lang="ko" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
											    <span class="sociallink ml-1">
												    <a href="javascript:sendLinkKakao('<?=$og_title?>','<?=$og_image?>','<?=$og_url?>','<?=current_self()?>')" id="kakao-link-btn" title="카카오톡으로 공유">
												        <img src="<?=base_url_home()?>assets/images/Kakao_Story.png" width=20 alt="Kakaotalk">카카오스토리
												    </a>
												</span>
								        	</div>
										</div>

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
		        				<div id="buy-button" class="pdpButtonArea">
		        					<?php if($uf->use == 1 && $uf->count > 0): ?>
		        					<div class="row">
		        						<div class="col-xs-6 p-right-5">
		        							<a class="btn btn-lg btn-default btn-block" href="javascript:void(0)" 
		        							onclick="app_submit('<?=$uf->rid?>','cart',$(this));">장바구니 담기</a>
		        						</div>
		        						<div class="col-xs-6 p-left-5 origin-section">
		        							<a  class="btn btn-lg btn-danger btn-block visible-btn" href="javascript:visibleForm();">구매하기</a>
		        						</div>
		        						<div class="col-xs-6 p-left-5 d-none buy-btn">
		        							<input type="submit" value="구매하기" class="btn btn-lg btn-danger btn-block" id="requestAccept">
		        						</div>
		        					</div>
		        					<?php endif; ?>
		        					<?php if($uf->use == 0 || $uf->count <= 0): ?>
									<div class="sold-out">일시품절</div>
									<?php endif; ?>
								</div>
		        			</form>
				        	
		        			<div class="row mt-20 hover-slick">
					       		<div class="col-md-12 p-left-0">
					       			<hr>
					       			<h2 class="font-weight-bold withnames ft-14 mt-10 mb-10">다른 고객이 함께 구매한 상품</h2>
					       		</div>
					       		<div class="col-md-12 s_ss p-left-0 p-right-0" id="related_top">

					       		</div>
					       </div>
					       <div class="row mt-20 mb-20" id="moved_item">
				      			<div id="exTab1">
				      				<nav class="navigation" id="nav">	
							      		<ul  class="nav nav-tabs" id="myTab" role="tablist">
											<li class="active nav-item">
												<a  href="#1a" data-toggle="tab" data-tab="#1a">상품정보</a>
											</li>
											<li class="nav-item">
												<a href="#2a" data-toggle="tab" data-tab="#2a">상품평가<br>(<?=$review["review_count"]?>)</a>
											</li>
											<li class="nav-item">
												<a href="#3a" data-toggle="tab" data-tab="#3a">상품문의<br>(<?=$qna?>)</a>
											</li>
										  	<li class="nav-item">
										  		<a href="#4a" data-toggle="tab" data-tab="#4a">주문/배송<br>안내</a>
										  	</li>
										</ul>
									</nav>
								</div>
								<div class="tab-content clearfix my-15">
									<div class="tab-pane active details" id="1a">
								        <p><?=$uf->description?></p>
									</div>
									<div class="tab-pane" id="2a">
										<h2 class="font-weight-bold mb-20 mt-20">상품평</h2>
									    <div id="eval_contents_area"  class="cm_shop_inner ">
										   <div class="top_area">
										      <span class="guide_txt">
										      게시판 성격과 다른 내용의 글을 등록할 경우 임의로 삭제될 수 있습니다.</span>
										      <div class="text-right btn_box">
										         <span class="button_pack ">
										            <a href="javascript:eval_write_form_view()" 
										            class="btn btn-danger btn-xs btn-round">상품평가 입력하기</a>
										         </span>
										      </div>
										   </div>
										   <!-- 등록폼 처음부터노출 -->
										   <div class="form_area d-none">
										   	<?php echo form_open_multipart('eval_update',array('class' => 'eval_frm','id'=>'eval_frm'));?>
										         <input type="hidden" name='type' value='eval'>
										         <input type="hidden" name="id" id="id" value="0"/>
										         <input type="hidden" name="pcode" value="<?=$uf->rid?>" id="pcode"/>
										         <div class="inner">
										         	<table class="table table-bordered">
										         		<colgroup>
										         			<col width="150px"></col>
										         		</colgroup>
										         		<tr>
										         			<th class="text-center mid">평가 점수</th>
										         			<td><input type="hidden" id="eval_point" value="0" name="eval_point">
										                  		<div class="new-rating-4 inline-block" data-rating="0"></div>
										                  	</td>
										         		</tr>
										         		<tr>
										         			<th class="text-center mid">평가 제목</th>
										         			<td ><div class="form_title">
										         				<?php if(empty($this->session->userdata("fuser"))): ?>
										         				<input type="text" name="title" id="eval_title" class="form-control"  value="로그인 후 입력가능 합니다." 
										         				onclick="login_alert()" required>
										         				<?php endif; ?>
										         				<?php if(!empty($this->session->userdata("fuser"))): ?>
										         				<input type="text" name="title" id="eval_title" class="form-control" value=""  required>	
										         				<?php endif; ?>	
										         				</div>
										         			</td>
										         		</tr>
										         		<tr>
										         			<th class="text-center mid">사진 첨부</th>
										         			<td>
										         				<div class="form_file">
											                        <div class="input_file_box">
											                           <div class="fileDiv">
											                              <input type="button" class="buttonImg btn btn-block" value="사진첨부(600KB 이하)">
											                              <input type="file" class="realFile" name="img" 
											                              onchange="javascript:document.getElementById('fakeFileTxt').value = this.value">
											                           </div>
											                        </div>
											                     </div>
										         			</td>
										         		</tr>
										         		<tr>
										         			<td colspan="2">
										         				<?php if(empty($this->session->userdata("fuser"))): ?>
										         				<textarea name="content" id="eval_content" class="form-control" onclick="login_alert()"  >로그인 후 입력가능 합니다.</textarea>
										         				<?php endif; ?>
										         				<?php if(!empty($this->session->userdata("fuser"))): ?>
										         				<textarea name="content" id="eval_content" class="form-control"></textarea>
										         				<?php endif; ?>	
										         				<input type="submit" class="btn btn-secondary align-top btn_ok btn-block mt-10" value="등록" 
										         				data-loading-text="처리중" data-type="eval"/>
										         			</td>
										         		</tr>
										         	</table>
										         </div>
										      </form>
										   </div>
										   <!-- //등록폼 -->
										   	<div id="ID_eval_list">
										   		<div class="list_area">
										   			<ul></ul>
										   		</div>
										   		<div class="text-center my-4">
										   			<a id="more_eval" class="btn btn-default btn-round" onclick="getReivews()">상품평 더보기</a>
										   		</div>
										   	</div>
										</div>
									</div>
									<div class="tab-pane" id="3a">
										<h2 class="font-weight-bold mb-20 mt-20">상품문의</h2>
									    <div id="qna_contents_area" class="cm_shop_inner">
											<div class="top_area">
												<span class="guide_txt">
												게시판 성격과 다른 내용의 글을 등록할 경우 임의로 삭제될 수 있습니다.</span>
												<span class="btn_box">
													<div class="text-right button_pack ">
														<a href="javascript:qna_write_form_view()" 
															class="btn btn-xs btn-danger btn-round">상품문의 입력하기
														<span class="edge"></span>
														</a>
													</div>
												</span>
											</div>
											<div class="form_area d-none">
												<?php echo form_open_multipart('eval_update',array('class' => 'eval_frm','id'=>'qna_frm'));?>
													<input type="hidden" name="id"  value="0"/>
										         	<input type="hidden" name="pcode" value="<?=$uf->rid?>"/>
													<input type="hidden" name='type' value='qna'>
													<table class="table table-bordered">
														<colgroup>
										         			<col width="150px"></col>
										         		</colgroup>
														<tr>
															<th class="text-center mid">문의제목</th>
															<?php if(!empty($this->session->userdata("fuser"))): ?>
															<td><input type="text" class="form-control" name="title" id="qna_title"></td>
															<?php endif; ?>
															<?php if(empty($this->session->userdata("fuser"))): ?>
															<td><input type="text" class="form-control" name="title" id="qna_title" onclick="login_alert()"></td>
															<?php endif; ?>
														</tr>
														<tr>
															<td colspan="2">
										         				<?php if(empty($this->session->userdata("fuser"))): ?>
										         				<textarea name="content" id="qna_content" class="form-control" onclick="login_alert()">로그인 후 입력가능 합니다.</textarea>
										         				<?php endif; ?>
										         				<?php if(!empty($this->session->userdata("fuser"))): ?>
										         				<textarea name="content" id="qna_content" class="form-control"></textarea>
										         				<?php endif; ?>	
										         				<input type="submit" class="btn btn-secondary btn-block mt-10 align-top btn_ok" value="등록" data-loading-text="처리중" data-type="qna"/>
										         			</td>
														</tr>
													</table>
												</form>	
											</div>
											<div id="ID_qna_list">
										   		<div class="list_area">
										   			<ul></ul>
										   		</div>
										   		<div class="text-center my-4">
										   			<a id="more_qna" class="btn btn-default btn-round" onclick="getReivews('#ID_qna_list','qna')">상품문의 더보기</a>
										   		</div>
										   	</div>
										</div>
									</div>
									<div class="tab-pane product_detail" id="4a">
									    <div class="detail_box">
										   <div class="layout_fix">
										      <div class="detail_guide pt-10">
										         <div class="hit">상품정보에 배송/교환/반품 및 취소와 관련된 안내가 별도 기재된 경우 ,아래의 내용보다 우선하여 적용됩니다.</div>
										         <div class="left_box">
										            <div class="stitle">
										            	<img src="<?=base_url_home()?>assets/images/stitle_icon.gif" alt="" />판매자정보
										            </div>
										            <div class="basic_info">
										               	<table class="table table-bordered">
										               		<tr>
										               			<th>상호명</th>
										               			<td><?=$siteInfo->s_adshop?></td>
										               		</tr>
										               		<tr>
										               			<th>대표자</th>
										               			<td><?=$siteInfo->s_ceo_name?></td>
										               		</tr>
										               		<tr>
										               			<th>사업자등록번호</th>
										               			<td><?=$siteInfo->s_company_num?></td>
										               		</tr>
										               		<tr>
										               			<th>통신판매업번호</th>
										               			<td><?=$siteInfo->s_company_snum?></td>
										               		</tr>
										               		<tr>
										               			<th>대표전화</th>
										               			<td><?=$siteInfo->s_glbtel?></td>
										               		</tr>
										               		<tr>
										               			<th>팩스전화</th>
										               			<td><?=$siteInfo->s_fax?></td>
										               		</tr>
										               		<tr>
										               			<th>이메일</th>
										               			<td><?=$siteInfo->s_ademail?></td>
										               		</tr>
										               		<tr>
										               			<th>개인정보취급책임자</th>
										               			<td><?=$siteInfo->s_privacy_name?></td>
										               		</tr>
										               		<tr>
										               			<th>사업장소재지</th>
										               			<td><?=$siteInfo->s_company_addr?></td>
										               		</tr>
										               	</table>
										            </div>
										         </div>
										         <div class="right_box">
										            <div class="stitle"><img src="<?=base_url_home()?>assets/images/stitle_icon.gif" alt="" />배송/반품/취소/교환안내</div>
										            <div class="basic_info">
										            	<table class="table table-bordered">
										            		<tr>
										            			<th>지정택배사</th>
										            			<td><?=$siteInfo->s_del_company?></td>
										            		</tr>
										            		<tr>
										            			<th>기본배송비</th>
										            			<td><?=number_format($siteInfo->s_delprice)?></td>
										            		</tr>
										            		<tr>
										            			<th>평균배송기간</th>
										            			<td><?=$siteInfo->s_del_date?></td>
										            		</tr>
										            		<tr>
										            			<th>반송주소</th>
										            			<td><?=$siteInfo->s_del_return_addr?></td>
										            		</tr>
										            	</table>
										            </div>
										         </div>
										         <div class="stitle"><img src="<?=base_url_home()?>assets/images/stitle_icon.gif" alt="" />교환/반품/환불이 가능한 경우</div>
										         <div class="text_box">
										            <ul>
										               <?=htmlspecialchars_decode($siteInfo->s_complain_ok)?>
										            </ul>
										         </div>
										         <div class="stitle"><img src="/assets/images/stitle_icon.gif" alt="" />교환/반품/환불이 <b>불</b>가능한 경우</div>
										         <div class="text_box">
										            <ul>
										               <?=htmlspecialchars_decode($siteInfo->s_complain_fail)?>
										            </ul>
										         </div>
										      </div>
										   </div>
										</div>
									</div>
								</div>
							</div>
				        </div>
				        <!--Grid column-->
			      	</div>

			      	<div class="row p-left-10 p-right-10 hover-slick">
			       		<div class="col-md-12 p-left-0">
			       			<hr>
			       			<h2 class="font-weight-bold withnames ft-18  mt-20 mb-20">다른 고객이 함께 본 상품</h2>
			       		</div>
			       		<div class="col-md-12 s_ss  p-left-0 p-right-0" id="related_bottom">
			       		</div>
			       </div>
			      	
			      </div>
			      <!--Grid row-->
			    </div>
			  </main>
		</div>
	</div>
</div>
<script>var pcode = "<?=$uf->rid?>";var loaded =0;var review_count = Array(); review_count["eval"] =  <?=$review["review_count"]?>;review_count["qna"] = <?=$qna?></script>
<script src="<?=base_url_home()?>assets/js/jquery.validate.js"></script>
<script src="<?php echo site_url('/template/js/shop.js')?>?<?=time()?>"></script>
<script src="<?php echo site_url('/template/js/shop_product.js')?>?<?=time()?>"></script>
<script type="text/javascript" src="/assets/js/delivery.js?<?=time()?>"></script>
<script id="eval-lists" type="text/x-handlebars-template">
	<li class="eval_box_area" id="view_{{id}}" onclick="eval_show('view_{{id}}')">
		<div class="post_box">
			{{#if_type_request type}}
			<div id="rating_{{id}}" class="fl" data-rating="{{eval_point}}"></div>
			{{else}}
			{{#if reply_use}}
			<div class="texticon_pack"><span class="red">답변완료</span></div>
			{{else}}
			<div class="texticon_pack"><span class="dark">답변대기</span></div>
			{{/if}}
			{{/if_type_request}}

			<a href="javascript:void(0))" class="title">{{title}}</a>
			<span class="button_pack fr">
				{{#if permission}}<a href="javascript:eval_del('{{id}}');" class="btn_sm_black btn btn-danger btn-xs btn-round">삭제<span class="edge"></span></a>{{/if}}
			</span>
			<span class="title_icon">
				{{#if new}}<img src="{{pc_url}}assets/images/board_ic_new.gif" alt="새글">{{/if}}
				{{#if image_uploaded}}<img src="{{pc_url}}assets/images/board_ic_photo.gif" alt="사진첨부">{{/if}}
			</span>
			<span class="writer"><span class="name">{{nickname}}</span><span class="bar"></span><span class="date">{{rdate}}</span></span>
		</div>

		<div class="open_box">
			<div class="conts_txt">
				<dl>
					<dt>{{title}}</dt>
					<dd>
						{{#if image_uploaded}}
						<div class="img"><img src="{{img}}" alt="{{title}}" class="w-100"></div>
						{{/if}}
						{{content}}
					</dd>
				</dl>
			</div>
			{{#if reply_use}}
			<div class="reply">
				<div class="conts_txt">
					<span class="admin">
						<span class="name">{{talk_intype}}</span><span class="bar"></span><span class="date">{{talk_rdate}}</span>
					</span>
					{{talk_content}}
				</div>
			</div>
			{{/if}}
		</div>
	</li>
</script>
<script  id="related-lists" type="text/x-handlebars-template">
	<a href="/view/shop_products/{{rid}}" class="p-left-5 p-right-5">  
        <img class="lazy related-img" src="{{product_image}}">
        <div class="parts_pt ellipsis two-lines"><p class="stitle">{{name}}</p></div>
        <p >
        	<strong class="price">{{accurate singo}}</strong>원</p>
        <p><span  class="ratings" 
        	data-rating="{{#if review_used}}{{review.review}}{{else}}0{{/if}}"></span>
    	</p>
    	<hr class="mt-5 mb-5">
    	<div><span class="grey1">{{methods this}}</span></div>
    </a>
</script>

<script>
	var sendLinkKakao = function (title,image,link,link1) {
	    Kakao.Link.sendDefault({
	        objectType: 'feed',
	        content: {
	            title: title,
	            description: "",//$scope.data.content,
	            imageUrl: image,
	            imageWidth: 800,
	            imageHeight: 450,
	            link: {
	                mobileWebUrl: link1,
	                webUrl: link
	            }
	        }
	    });
	};
</script>