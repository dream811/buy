<?php 
ksort($category_header);
if(sizeof($product)) $uf = $product[0];
else return;
$images = array();
$i1 = $uf->i1!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i1:"";
$i2 = $uf->i2!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i2:"";
$i3 = $uf->i3!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i3:"";
$i4 = $uf->i4!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i4:"";
$i5 = $uf->i5!="" ? "/upload/shoppingmal/".$uf->id."/".$uf->i5:"";

if($uf->i1 !=""){
	array_push($images, "/upload/shoppingmal/".$uf->id."/".$uf->i1);
}

if($uf->i2 !=""){
	array_push($images, "/upload/shoppingmal/".$uf->id."/".$uf->i2);
}

if($uf->i3 !=""){
	array_push($images, "/upload/shoppingmal/".$uf->id."/".$uf->i3);
}

if($uf->i4 !=""){
	array_push($images, "/upload/shoppingmal/".$uf->id."/".$uf->i4);
}

if($uf->i5 !=""){
	array_push($images, "/upload/shoppingmal/".$uf->id."/".$uf->i5);
}
?>
<script>
	var o_type = new Array(),price = <?=$uf->singo?>,add_options = new Array(),init_add = 0,
	delivery_method="<?=$uf->p_shoppingpay_use ==1 && $uf->deliverybysky==1  && $uf->deliverybysea==0 ? "sky" : "sea"?>",
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
<link href="<?php echo site_url('/template/css/shop.css'); ?>?<?=time()?>" rel="stylesheet">
<link href="<?php echo site_url('/template/css/product.css'); ?>?<?=time()?>" rel="stylesheet">
<link href="<?php echo site_url('/assets/plugins/ratings/star-rating-svg.css')?>" rel="stylesheet">
<script src="<?php echo site_url('/assets/plugins/ratings/jquery.star-rating-svg.js')?>"></script>
<div class="container">
	<input type="hidden" name="option_select_expricesum" id="option_select_expricesum" value="<?=$uf->singo?>">
	<input type="hidden" name="option_select_addsum" id="option_select_addsum" value="0">
	<div class="row">
		<div id="subRight" class="col-md-12">
			<div class="p_category d-none">
			    <ol class="breadcrumb breadcrumb-arrow">
			    	<?php if(!empty($category_header)): ?>
			    	<?php $txt = ""; ?>
			    	<?php foreach($category_header as $key =>$value):?>	
			    		<?php if($key != sizeof($category_header)): ?>
			    			<li class="">
								<a href="/shopping?txt-category=<?=$value["code"]?>"><?=$value["name"]?></a>					
							</li>
			    		<?php endif;?>
			    		<?php if($key == sizeof($category_header)): ?>
			    			<li class="active">
								<span><?=$value["name"]?></span>					
							</li>
			    		<?php endif;?>	
					<?php endforeach;?>
			    	<?php endif; ?>
				</ol>
			</div>
			<div class="con">
				<main>
				    <div class="dark-grey-text">
				    	<?php echo form_open_multipart('basket_update',array("id"=>"deliverForm"));?>
					      	<div class="row wow fadeIn">
						        <div class="col-md-4 mb-4 p-left-0 p-right-0">
						        	<div id="carousel-products" class="carousel slide mb-10" data-ride="carousel">
									    <div class="carousel-inner" role="listbox">
									    	<?php foreach($images as $key=>$value): ?>
									    		<div class="item <?=$key ==0 ? "active":""?>">
									                <a>
									                  <img src="<?=$value?>"  alt="<?=$uf->name?>">
								                	</a>
								              	</div>
									    	<?php endforeach; ?>
									    </div>
								    </div>
								    <div>
							    		<?php foreach($images as $key=>$value): ?>
								    		<img src="<?=$value?>" data-holder-rendered="true" width="19%" role="button" onclick="$('#carousel-products').carousel(<?=$key?>)">
								    	<?php endforeach; ?>
								    </div>
								</div>
						        <div class="col-md-8 mb-4 second_details">
						        	<div class="likes_product">
						        		<button type="button" id="like-add" class="c_product_btn c_product_btn_pick 
						        		<?=$wish > 0 ? "if_wish":"not_if_wish"?>" data-pcode="<?=$uf->rid?>">
						        			<span></span>
						        		</button>
										<button type="button" class="c_product_btn c_product_btn_share">
											<span></span>
										</button>
						        	</div>
						        	
						        	<h1 class="product-title mb-20"><?=$uf->name?></h1>
						        	<div class="mb-20 border-bottom"></div>
						        	<div class="shared_buttons p-10 disabled_btns">
						        		<p class="mb-10 font-weight-bold">공유하기</p>
						        		<div class="fb-share-button" data-href="<?=current_self()?>" data-layout="button" data-size="large">
									      	<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=current_self()?>" class="fb-xfbml-parse-ignore"></a>
									    </div>
									    <a href="https://twitter.com/share?ref_src=<?=current_self()?>" class="twitter-share-button" data-size="large" data-lang="ko" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
									    <span class="sociallink ml-1">
										    <a href="javascript:sendLinkKakao('<?=$og_title?>','<?=$og_image?>','<?=$og_url?>','<?=$og_url?>')" id="kakao-link-btn" title="카카오톡으로 공유">
										        <img src="/assets/images/Kakao_Story.png" width=20 alt="Kakaotalk">카카오스토리
										    </a>
										</span>
						        	</div>
						        	<div>
										<table class="table border-none">
											<colgroup>
												<col width="150px"></col>
											</colgroup>
											<tr>
												<th>소비자가격</th>
												<td><span class="font-weight-bold"><?=number_format($uf->orgprice)?></span>원</td>
											</tr>
											<tr>
												<th>판매가격</th>
												<td><span class="font-weight-bold ft-18"><?=number_format($uf->singo)?></span>원</td>
											</tr>
											<tr>
												<th>포인트</th>
												<td><?=$uf->point > 0 ? $uf->point."P":"없음"?></td>
											</tr>
											<tr>
												<th>제조사/원산지</th>
												<td ><?=$uf->brand?>/<?=$uf->wonsanji?></td>
											</tr>
											<?php if(!empty($add_options)): ?>
											<?php foreach($add_options as $value):?>
											<tr>
												<th>
													<label class="option-name"><?=$value->name?></label>
												</th>
												<td>
													<select class="form-control option-value" data-name="<?=$value->name?>" name="product_feature[]" 
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
															data-insert="<?=$value->name?> : <?=$sec_val->name?>" <?=$disabled?>>
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
												<td class="mid"><?php if((($uf->deliverybysea ==1 && $delivery_price[0] > 0) || ($uf->deliverybysky==1 && $delivery_price[1] > 0)) && $uf->p_shoppingpay_use==1):  ?>
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
										</table>
										<input type="hidden" name="delivery_type" id="delivery_type">
										<input type="hidden" name="pcode" value="<?=$uf->rid?>" >
										<input type="hidden" name="color" class="color">
										<input type="hidden" name="size" class="size">
										<div class="c-detail__count">
										  	<span class="updown_box">
												<input type="text" name="option_select_cnt" class="updown_input" id="option_select_cnt" value="1" 
												data-max="<?=$uf->count?>" 
												onblur="update_sum_price()">
												<span class="updown">
													<a href="javascript:pro_cnt_up()" class="btn_up" title="더하기"></a>
													<a href="javascript:pro_cnt_down()" class="btn_down" title="빼기"></a>
												</span>
											</span>
											<?php if($uf->use ==0 || $uf->count <= 0): ?>
											<?php if($uf->count <= 0): ?><span class="font-weight-bold text-danger" style="margin-left: 30px">SOLD OUT</span><?php endif; ?>
											<?php if($uf->use==0): ?><span class="font-weight-bold text-danger" style="margin-left: 30px">재고없음</span><?php endif; ?>	
											<?php endif;?>
										</div>
										<div class="c-detail__total">
											<span id="option_select_count_display">1</span>
											<span id="option_free_price_display">
												<em class="sky">
												<?php if($uf->p_shoppingpay_use ==2 || $delivery_price[0] ==0):?>
												무료배송	
												<?php endif;?>
												<?php if($delivery_price[0] > 0):?>
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
											</div>
										</div>									
										<?php if($uf->use == 1 && $uf->count > 0): ?>
										<div class="c-detail__buttons">
										  	<a href="javascript:void(0)" onclick="app_submit('<?=$uf->rid?>','cart',$(this));" 
										  		title="CART" class="u-b-cart" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중"
										  		>
										  	</a>
										  	<a href="javascript:visibleForm();" title="BUY" class="u-b-buy"></a>
										</div>	
										<?php endif;?>
										
									</div>
						        </div>
					      	</div>
					      	<div id="deliveryForm" class="d-none">
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
													<input  type="text" name="REQ_1" id="REQ_1" maxlength="100" class="form-control">
													<p style="padding-top: 10px">* 국내 배송기사 분께 전달하고자 하는 요청사항을 남겨주세요(예: 부재 시 휴대폰으로 연락주세요.)</p>
												</div>
											</div>
										</li>
									</ul>
								</div>
								<div class="text-center">
									<a href="javascript:void(0)" onclick="$('#deliveryForm').addClass('d-none');" class="btn btn-default btn-lg">
									쇼핑계속하기
									</a>
									<input type="submit" class="btn  btn-danger btn-lg accept" 
									value="&nbsp;&nbsp;&nbsp;구매하기&nbsp;&nbsp;&nbsp;" id="requestAccept">
								</div>
							</div>
				      	</form>
				      
				       	<div class="row mt-20 hover-slick">
				       		<div class="col-md-12 p-left-0">
				       			<hr>
				       			<h2 class="font-weight-bold withnames ft-18 mt-20 mb-20">다른 고객이 함께 구매한 상품</h2>
				       		</div>
				       		<div class="col-md-12 s_ss p-left-0 p-right-0" id="related_top">

				       		</div>
				       	</div>
				      	<div class="row mt-20 mb-20">
			      			<div id="exTab1">
			      				<nav class="navigation" id="nav">	
						      		<ul>
										<li class="active"><a  href="#1a">상품정보</a></li>
										<li><a href="#2a">상품평가(<?=$review["review_count"]?>)</a></li>
										<li><a href="#3a">상품문의(<?=$qna?>)</a></li>
									  	<li><a href="#4a">주문/배송안내</a></li>
									</ul>
								</nav>
								<div class="tab-details clearfix my-15">
									<div class="tab-panes active" id="1a">
										<?php 
										$uf->description = str_replace("../../upload/tinymce/", "/upload/tinymce/", $uf->description);
										$uf->description = str_replace("../upload/tinymce/", "/upload/tinymce/", $uf->description);
										?>
								        <p><?=$uf->description?></p>
									</div>
									<div class="tab-panes" id="2a">
										<hr>
										<h2 class="font-weight-bold mb-20 mt-20">상품평</h2>
									    <div id="eval_contents_area"  class="cm_shop_inner ">
										   <div class="top_area">
										      <span class="guide_txt">게시판 성격과 다른 내용의 글을 등록할 경우 임의로 삭제될 수 있습니다.</span>
										      <span class="btn_box">
										         <span class="button_pack ">
										            <a href="javascript:eval_write_form_view()" class="btn btn-sm btn-danger">상품평가 입력하기</a>
										         </span>
										      </span>
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
											                           <input type="text" id="fakeFileTxt" class="fakeFileTxt" readonly="readonly" disabled="" placeholder="사진 첨부는 600kb이하의 이미지 JPG,JPEG,GIF,PNG만 등록가능합니다.">
											                           <div class="fileDiv">
											                              <input type="button" class="buttonImg" value="사진첨부">
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
										         				<input type="submit" class="btn btn-secondary btn-lg align-top btn_ok" value="등록" 
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
										   			<a id="more_eval" class="btn btn-default " onclick="getReivews()">더보기</a>
										   		</div>
										   	</div>
										</div>
									</div>
									<div class="tab-panes" id="3a">
										<hr>
										<h2 class="font-weight-bold mb-20 mt-20">상품문의</h2>
									    <div id="qna_contents_area" class="cm_shop_inner">
											<div class="top_area">
												<span class="guide_txt">게시판 성격과 다른 내용의 글을 등록할 경우 임의로 삭제될 수 있습니다.</span>
												<span class="btn_box">
													<span class="button_pack ">
														<a href="javascript:qna_write_form_view()" class="btn btn-sm btn-danger">상품문의 입력하기<span class="edge"></span></a>

													</span>
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
										         				<input type="submit" class="btn btn-secondary btn-lg align-top btn_ok" value="등록" data-loading-text="처리중" data-type="qna"/>
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
										   			<a id="more_qna" class="btn btn-default " onclick="getReivews('#ID_qna_list','qna')">더보기</a>
										   		</div>
										   	</div>
										</div>
									</div>
									<div class="tab-panes product_detail" id="4a">
									    <div class="detail_box">
										   <div class="layout_fix">
										      <div class="detail_guide">
										         <div class="hit">상품정보에 배송/교환/반품 및 취소와 관련된 안내가 별도 기재된 경우 ,아래의 내용보다 우선하여 적용됩니다.</div>
										         <div class="left_box">
										            <div class="stitle"><img src="/assets/images/stitle_icon.gif" alt="" />판매자정보</div>
										            <div class="basic_info">
										               <dl>
										                  <dd>
										                     <div class="opt">상호명</div>
										                     <div class="conts"><?=$siteInfo->s_adshop?></div>
										                  </dd>
										                  <dd>
										                     <div class="opt">대표자</div>
										                     <div class="conts"><?=$siteInfo->s_ceo_name?></div>
										                  </dd>
										                  <dd>
										                     <div class="opt">사업자등록번호</div>
										                     <div class="conts"><?=$siteInfo->s_company_num?></div>
										                  </dd>
										                  <dd>
										                     <div class="opt">통신판매업번호</div>
										                     <div class="conts"><?=$siteInfo->s_company_snum?></div>
										                  </dd>
										                  <dd>
										                     <div class="opt">대표전화</div>
										                     <div class="conts"><?=$siteInfo->s_glbtel?></div>
										                  </dd>
										                  <dd>
										                     <div class="opt">팩스전화</div>
										                     <div class="conts"><?=$siteInfo->s_fax?></div>
										                  </dd>
										                  <dd>
										                     <div class="opt">이메일</div>
										                     <div class="conts"><?=$siteInfo->s_ademail?></div>
										                  </dd>
										                  <dd>
										                     <div class="opt">개인정보취급책임자</div>
										                     <div class="conts"><?=$siteInfo->s_privacy_name?></div>
										                  </dd>
										                  <dd>
										                     <div class="opt">사업장소재지</div>
										                     <div class="conts"><?=$siteInfo->s_company_addr?></div>
										                  </dd>
										               </dl>
										            </div>
										         </div>
										         <div class="right_box">
										            <div class="stitle"><img src="/assets/images/stitle_icon.gif" alt="" />배송/반품/취소/교환안내</div>
										            <div class="basic_info">
										               <dl>
										                  <dd>
										                     <div class="opt">지정택배사</div>
										                     <div class="conts"><?=$siteInfo->s_del_company?></div>
										                  </dd>
										                  <dd>
										                     <div class="opt">기본배송비</div>
										                     <div class="conts"><?=number_format($siteInfo->s_delprice)?></div>
										                  </dd>
										                  <dd>
										                     <div class="opt">평균배송기간</div>
										                     <div class="conts"><?=$siteInfo->s_del_date?></div>
										                  </dd>
										                  <dd>
										                     <div class="opt">반송주소</div>
										                     <div class="conts"><?=$siteInfo->s_del_return_addr?></div>
										                  </dd>
										               </dl>
										            </div>
										         </div>
										         <div class="stitle"><img src="/assets/images/stitle_icon.gif" alt="" />교환/반품/환불이 가능한 경우</div>
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
				      	<div class="row mt-20 hover-slick">
				       		<div class="col-md-12 p-left-0">
				       			<hr>
				       			<h2 class="font-weight-bold withnames ft-18  mt-20 mb-20">다른 고객이 함께 본 상품</h2>
				       		</div>
				       		<div class="col-md-12 s_ss  p-left-0 p-right-0" id="related_bottom">
				       		</div>
				       </div>
				    </div>
				</main>
			</div>
		</div>
	</div>
</div>

<span class="hide method">sea</span>

<script>	
	var pcode = "<?=$uf->rid?>";
	var loaded =0;
	var review_count = Array(); 
	review_count["eval"] =  <?=$review["review_count"]?>;
	review_count["qna"] = <?=$qna?>
				
</script>
<script src="<?php echo site_url('/assets/js/scrollspy.min.js')?>"></script>
<script src="<?php echo site_url('/assets/js/jquery.validate.js') ?>"></script>
<script src="<?php echo site_url('/template/js/shop.js')?>"></script>

<script src="<?php echo site_url('/template/js/product.js')?>?<?=time()?>"></script>
<script src="<?php echo site_url('/template/js/shop_product.js')?>"></script>
<script type="text/javascript" src="/template/js/delivery.js"></script>
<script id="eval-lists" type="text/x-handlebars-template">
	<li class="eval_box_area" id="view_{{id}}">
		<div class="post_box">
			{{#if_type_request type}}
			<div id="rating_{{id}}" class="fl" data-rating="{{eval_point}}"></div>
			{{else}}
			{{#if reply_use}}
			<span class="texticon_pack"><span class="red">답변완료</span></span>
			{{else}}
			<span class="texticon_pack"><span class="dark">답변대기</span></span>
			{{/if}}
			{{/if_type_request}}

			<a href="javascript:eval_show('view_{{id}}')" class="title">{{title}}</a>
			<span class="title_icon">
				{{#if new}}<img src="/assets/images/board_ic_new.gif" alt="새글">{{/if}}
				{{#if image_uploaded}}<img src="/assets/images/board_ic_photo.gif" alt="사진첨부">{{/if}}
			</span>
			<span class="button_pack ">
				<a href="javascript:eval_show('view_{{id}}')" class="btn_sm_white btn btn-default btn-sm">내용보기<span class="edge"></span></a>
				<a href="javascript:eval_show('view_{{id}}')" class="btn_sm_black btn btn-secondary btn-sm">내용닫기<span class="edge"></span></a>
				{{#if permission}}<a href="javascript:eval_del('{{id}}');" class="btn_sm_black btn btn-secondary btn-sm">삭제<span class="edge"></span></a>{{/if}}
			</span>
			<span class="writer"><span class="name">{{nickname}}</span><span class="bar"></span><span class="date">{{rdate}}</span></span>
		</div>

		<div class="open_box">
			<div class="conts_txt">
				<dl>
					<dt>{{title}}</dt>
					<dd>
						{{#if image_uploaded}}
						<div class="img"><img src="/upload/request/{{img}}" alt="{{title}}"></div>
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
        <img class="lazy w-100" src="/upload/shoppingmal/{{id}}/{{image}}"  height=220>
        <div class="parts_pt ellipsis two-lines"><p>{{name}}</p></div>
        <p>
        	<strong class="price">{{accurate singo}}</strong>원</p>
        <p><span  class="ratings" 
        	data-rating="{{#if review_used}}{{review.review}}{{else}}0{{/if}}"></span>
    	</p>
    	<hr class="mt-5 mb-5">
    	<div><span class="grey1">{{methods this}}</span></div>
    </a>
</script>
<script>
	$("#nav").scrollspy({ offset: -135 });
</script>
