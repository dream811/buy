<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Ajax extends BaseController {

	function __construct()
	{
		parent::__construct(); 
		$this->load->model('base_model');
	}

	function getProduct(){
		$types = $this->input->post("types");
		$category = $this->base_model->getSelect("tbl_category",
																array(array("record"=>"parent","value"=>0)),
																array(array("record"=>"orders","value"=>"ASC")));
		if(sizeof($category) > 0 ){
			$sub = $this->base_model->getSelect("tbl_category",array(array("record"=>"parent","value"=>$category[0]->id)));
		}
		if($types == null || empty($types)){
			$sShopNum = $this->input->get("sShopNum");
			$ORD_TY_CD = $this->input->get("ORD_TY_CD");
			$tracking_header= $this->base_model->getSelect("tracking_header");
			if($ORD_TY_CD !=1) $t='delivery';
			else $t = 'buy';
			echo '
				<input type="hidden" name="ARV_STAT_CD" id="ARV_S" value="1">
				<div class="order_table order_table_top">
					<div class="order_table order_table_top">
						<div class="row pt-5 pb-5"  style="background-color: #f0f0f0" >
							<div class="fl">
								<h4 class="s_tit vm_box" style="color:#ed7d31;">
									<label >상품#'.$sShopNum.'</label>
									<input type="text" name="StockTxt" id="StockTxt" value="" class="stock-font" readonly="">
									<input type="hidden" name="PRO_STOCK_SEQ" id="PRO_STOCK_SEQ" value="0">
								</h4>
							</div>
							<div class="fr p-right-5">
								<a href=\'javascript:fnPageCopy2('.$sShopNum.',"'.$t.'");\' type="button" class="btn btn-warning btn-sm btn-round ft-12">상품복사</a>
								<a href=\'javascript:fnProPlus('.$sShopNum.',"'.$t.'");\' class="btn btn-danger btn-sm btn-round ft-12">+상품추가</a>
								<a href="javascript:fnStockTempDel('.$sShopNum.');" class="btn btn-danger btn-sm btn-round ft-12">-상품삭제</a>
                            </div>
						</div>
					</div>
				</div>';
				echo '<div class="order_table">';
				if($ORD_TY_CD !=1){?>
				<?php echo '<div class="row">
										<label class="col-sm-2">* 트래킹번호 ( Tracking NO. )</label>
										<div class="col-sm-4 mb-5">
											<select name="FRG_DLVR_COM" class="form-control" id="FRG_DLVR_COM">';
													foreach($tracking_header as $value):
													echo '<option value="'.$value->name.'">'.$value->name.'</option>';
													endforeach;
										echo	'</select>
										</div>
										<div class="col-sm-4">
											<input type="text" class="input_txt2 form-control" name="FRG_IVC_NO" id="FRG_IVC_NO" maxlength="40">
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12">
											<label>
												<input type="checkbox" name="TRACKING_NO_YN" id="TRACKING_NO_YN" onchange="fnTrkNoAfChk('.$sShopNum.');">트래킹 번호 나중에 입력
											</label>
										</div>
									</div>
									<div class="row">
										<label class="col-sm-2">* 오더번호 </label>
										<div class="col-sm-10">
											<input type="text" class="input_txt2 per40 form-control" name="SHOP_ORD_NO" id="SHOP_ORD_NO" maxlength="40" value="">
										</div>
				</div>'; ?>		
				<?php	}
				echo '<div class="row">
										<label class="col-sm-2">* 통관품목</label>
										<div class="col-md-4 mb-5" style="padding-right: 15px;">
											<select name="PARENT_CATE" class="form-control" onchange="fnArcAjax(this.value,\''.$sShopNum.'\');">';
											echo '<option value="">==1차 카테고리==</option>';
											foreach($category as $values):
											echo '<option value="'.$values->id.'">'.$values->name.'</option>';	
											endforeach;
							echo 		'</select>
										</div>
										<div class="col-md-6">
											<select name="ARC_SEQ" class="form-control" id="TextArc_'.$sShopNum.'" onchange="fnArcChkYN(\''.$sShopNum.'\',this.value);">
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
									<div class="row" >
										<label class="col-sm-2">* 상품명</label>
										<div class="col-md-4">
											<input type="text" class="input_txt2 per40 form-control en_product_name" name="PRO_NM" id="PRO_NM" maxlength="200"  value="" title="상품명" required onblur="javascript:fnValKeyRep( /[^a-zA-z0-9 \,\.\-]/g, this );" placeholder="영문">
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
											<input type="text" class="input_txt2 per20 form-control COST" name="COST"  maxlength="10" value="0" title="단가" required onblur="fnNumChiper(this, \'2\');fnTotalProPrice();">
										</div>
									</div>
									<div class="row mb-5">
										<label class="col-xs-4 p-right-0">* 수량</label>
										<div class="col-xs-8">
											<input type="text" class="input_txt2 per20 form-control QTY" name="QTY"  maxlength="5" value="1" title="수량" required onblur="fnNumChiper(this, \'0\');fnTotalProPrice();">
										</div>
									</div>
									<div class="row mb-5">
										<label class="col-xs-4">* 색상</label>
										<div class="col-xs-8">
											<input type="text" class="input_txt2 per20 form-control" name="CLR" id="CLR" maxlength="100" value="" title="색상(영문)">
										</div>
									</div>
									<div class="row mb-5">
										<label class="col-xs-4">* 사이즈</label>
										<div class="col-xs-8">
											<input type="text" class="input_txt2 per20 form-control" name="SZ" id="SZ" maxlength="80" value="" title="사이즈">
										</div>
									</div>
									<div class="row mb-5">
										<label class="col-xs-4">* 상품URL</label>
										<div class="col-xs-8">
											<input type="text" class="input_txt2 full form-control" name="PRO_URL" id="PRO_URL" maxlength="500" value="" title="상품URL">
										</div>
									</div>
									<div class="row">
										<div class="col-xs-4"></div>
										<div class="col-xs-8">
											검수가 필요하신 분들은 정확한 URL주소를 넣어주세요
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12">
											<p class="goods_img text-center">
											<img src="/template/images/sample_img.jpg" width="109" height="128" id="sImgNo'.$sShopNum.'"></p>
											<div class="text-center">
												<a class="btn-small  btn-secondary btn w-100" href="javascript:openPopupImg('.$sShopNum.')"  data-img="1">
													<span>이미지등록</span>
												</a>
											</div>
											<div class="row mt-10 mb-10">
												<label class="col-md-4 p-right-0">* 이미지URL</label>
												<div class="col-md-8">
													<input type="text" class="input_txt2 full form-control" name="IMG_URL" id="IMG_URL" maxlength="500" value="">
												</div>
											</div>
										</div>
									</div>';
				echo '
				</div>
				<div id="TextProduct'.(intval($sShopNum)+1).'"></div>
			';
		}
		if(!empty($types)){
			$sShopNum = $this->input->post("sShopNum");
			$ORD_TY_CD = $this->input->post("ORD_TY_CD");
			// if($ORD_TY_CD !=1) $t='delivery';
			// else $t = 'buy';
			$t = $this->input->post("type_options");
			$tracking_header= $this->base_model->getSelect("tracking_header");		
			$data = $this->input->post("data");
			$pData= json_decode($data);		
			$str = "";	
			if($sShopNum >100) {echo json_encode(array("c"=>1,"data"=>"상품의 개수는 최대 100개를 넘길수 없습니다."));return;}
				
				foreach($pData as $keys=>$child){					
					$temp = "";
					$temp1="";
					$temp .= '
				<input type="hidden" name="ARV_STAT_CD" id="ARV_S" value="1">
				<div class="order_table order_table_top">
					<div class="order_table order_table_top">
						<div class="row pt-5 pb-5"  style="background-color: #f0f0f0" >
							<div class="fl">
								<h4 class="s_tit vm_box" style="color:#ed7d31;">
									<label >상품#'.$sShopNum.'</label>
									<input type="text" name="StockTxt" id="StockTxt" value="" class="stock-font" readonly=>
										<input type="hidden" name="PRO_STOCK_SEQ" id="PRO_STOCK_SEQ" value="0">
								</h4>
							</div>
							<div class="fr p-right-5">
								<a href=\'javascript:fnPageCopy2('.$sShopNum.',"'.$t.'");\' type="button" class="btn btn-warning btn-sm btn-round ft-12">상품복사</a>
								<a href=\'javascript:fnProPlus('.$sShopNum.',"'.$t.'");\' class="btn btn-warning btn-sm btn-round ft-12">+상품추가</a>
								<a href="javascript:fnStockTempDel('.$sShopNum.');" class="btn btn-danger btn-sm btn-round ft-12">-상품삭제</a>
							</div>
						</div>
					</div>
				</div>
				<div class="order_table">';
				if($types ==2){ 
					$temp.= '<div class="row">
										<label class="col-sm-2">* 트래킹번호 ( Tracking NO. )</label>
										<div class="col-sm-4 mb-5">
											<select name="FRG_DLVR_COM" class="form-control" id="FRG_DLVR_COM">';
													foreach($tracking_header as $value):
													$temp .=  '<option value="'.$value->name.'">'.$value->name.'</option>';
													endforeach;
										$temp .= 	'</select>
										</div>
										<div class="col-sm-4">
											<input type="text" class="input_txt2 form-control" name="FRG_IVC_NO" id="FRG_IVC_NO" maxlength="40">
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12">
											<label>
												<input type="checkbox" name="TRACKING_NO_YN" id="TRACKING_NO_YN" onchange="fnTrkNoAfChk('.$sShopNum.');">트래킹 번호 나중에 입력
											</label>
										</div>
									</div>
									<div class="row">
										<label class="col-sm-2">* 오더번호 </label>
										<div class="col-sm-10">
											<input type="text" class="input_txt2 per40 form-control" name="SHOP_ORD_NO" id="SHOP_ORD_NO" maxlength="40" value="'.$child->order.'">
										</div>
				</div>';
				}
				$temp .=  '<div class="row">
					<label class="col-sm-2">* 통관품목</label>
					<div class="col-md-4 mb-5" style="padding-right: 15px;">
						<select name="PARENT_CATE" class="form-control" onchange="fnArcAjax(this.value,\''.$sShopNum.'\');">';
						foreach($category as $values):
						$temp .=  '<option value="'.$values->id.'">'.$values->name.'</option>';	
						endforeach;
		$temp .= 		'</select>
					</div>
					<div class="col-md-6">
						<select name="ARC_SEQ" class="form-control" id="TextArc_'.$sShopNum.'" onchange="fnArcChkYN(\''.$sShopNum.'\',this.value);">';
					if(!empty($sub)):
						foreach($sub as $values):
							$temp.= '<option enchar="'.$values->en_subject.'" cnchar="'.$values->chn_subject.'" value="'.$values->id.'">'.$values->name.'</option>';	
						endforeach;
					endif;
							
					$temp.=	'</select>
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
						<input type="text" class="input_txt2 per40 form-control en_product_name" name="PRO_NM" id="PRO_NM" maxlength="200" title="상품명" required onblur="javascript:fnValKeyRep( /[^a-zA-z0-9 \,\.\-]/g, this );" placeholder="영문">
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
						<input type="text" class="input_txt2 per20 form-control COST" name="COST"  maxlength="10" value="'.(float)$child->price.'" title="단가" required onblur="fnNumChiper(this, \'2\');fnTotalProPrice();">
					</div>
				</div>
				<div class="row mb-5">
					<label class="col-xs-4 p-right-0">* 수량</label>
					<div class="col-xs-8">
						<input type="text" class="input_txt2 per20 form-control QTY" name="QTY"  maxlength="5" value="'.(int)$child->count.'" title="수량" required onblur="fnNumChiper(this, \'0\');fnTotalProPrice();">
					</div>
				</div>
				<div class="row mb-5">
					<label class="col-xs-4">* 색상</label>
					<div class="col-xs-8">
						<input type="text" class="input_txt2 per20 form-control" name="CLR" id="CLR" maxlength="100" value="'.$child->color.'" title="색상(영문)">
					</div>
				</div>
				<div class="row mb-5">
					<label class="col-xs-4">* 사이즈</label>
					<div class="col-xs-8">
						<input type="text" class="input_txt2 per20 form-control" name="SZ" id="SZ" maxlength="80" value="'.$child->size.'" title="사이즈">
					</div>
				</div>
				<div class="row mb-5">
					<label class="col-xs-4">* 상품URL</label>
					<div class="col-xs-8">
						<input type="text" class="input_txt2 full form-control" name="PRO_URL" id="PRO_URL" maxlength="500" value="'.$child->link.'" title="상품URL">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4"></div>
					<div class="col-xs-8">
						검수가 필요하신 분들은 정확한 URL주소를 넣어주세요
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<p class="goods_img text-center">
						<img src="'.$child->image.'" width="109" height="128" id="sImgNo'.$sShopNum.'"></p>
						<div class="text-center">
							<a class="btn-small  btn-secondary btn w-100" href="javascript:openPopupImg('.$sShopNum.')"   data-img="1">
								<span>이미지등록</span>
							</a>
						</div>
						<div class="row mt-10 mb-10">
							<label class="col-md-4 p-right-0">* 이미지URL</label>
							<div class="col-md-8">
								<input type="text" class="input_txt2 full form-control" name="IMG_URL" id="IMG_URL" maxlength="500" value="'.$child->image.'">
							</div>
						</div>
					</div>
				</div>
			</div>';			
				$temp1.='<div id="TextProduct'.(intval($sShopNum)+1).'">';
				$str.=$temp.$temp1;

				$sShopNum++;				
			}
			for($ii=0;$ii<$sShopNum-2;$ii++){
				$str.="</div>";
			}
			echo json_encode(array("c"=>0,"data"=>$str,"num"=>$sShopNum-1));
		}
	}
}
