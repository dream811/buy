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
					<table class="proBtn_write w-100">
						<tbody>
							<tr class="border">
								<td>
									<h4 class="s_tit vm_box" style="color:#ed7d31;">
										<label style="font-size:14px;">상품#'.$sShopNum.'</label>
										<input type="text" name="StockTxt" id="StockTxt" value="" class="stock-font" readonly="">
										<input type="hidden" name="PRO_STOCK_SEQ" id="PRO_STOCK_SEQ" value="0">
									</h4>
								</td>
								<td class="text-right">
									<div class="row">
										<div class="col-md-12">
											<a href=\'javascript:fnPageCopy2('.$sShopNum.',"'.$t.'");\' type="button" 
											class="btn btn-warning btn-sm btn-round">상품복사</a>
											<a href=\'javascript:fnProPlus('.$sShopNum.',"'.$t.'");\' 
											class="btn btn-danger btn-sm btn-round">+상품추가</a>
											<a href="javascript:fnStockTempDel('.$sShopNum.');" 
											class="btn btn-danger btn-sm btn-round">-상품삭제</a>
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
						<tbody>';
							if($ORD_TY_CD !=1){
						echo '<tr id="DLVR_1">
								<th>트래킹번호<br>Tracking No.</th>
								<td colspan="3" class="vm_box">
									<div class="row">
										<div class="col-md-2 form-group tracks" style="padding-right: 15px">
											<select name="FRG_DLVR_COM" class="form-control" id="FRG_DLVR_COM">';
												foreach($tracking_header as $value):
												echo '<option value="'.$value->name.'">'.$value->name.'</option>';
												endforeach;
									echo	'</select>
										</div>
										<div class="col-md-4 form-group tracks" style="padding-right: 15px">
											<input type="text" class="input_txt2 form-control" name="FRG_IVC_NO" id="FRG_IVC_NO" maxlength="40" value="">
										</div>
										<div class="col-md-4 form-group">
											<label>
												<input type="checkbox" name="TRACKING_NO_YN" id="TRACKING_NO_YN" onchange="fnTrkNoAfChk('.$sShopNum.');">트래킹 번호 나중에 입력
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
											<input type="text" class="input_txt2 per40 form-control" name="SHOP_ORD_NO" id="SHOP_ORD_NO" maxlength="40" value="">
										</div>
									</div>													
								</td>
							</tr>';
						 	}
						echo '<tr>
								<th>
									<p class="goods_img"><img src="/template/images/sample_img.jpg" width="109" height="128" 
									id="sImgNo'.$sShopNum.'"></p>
									<br><a class="btn-small  btn-secondary btn" href="javascript:openPopupImg('.$sShopNum.')" 
									data-img="'.$sShopNum.'"><span>이미지등록</span></a>
								</th>
								<td colspan="3">
									<div class="row" style="margin-top: 10px">
										<label class="col-sm-2">* 통관품목</label>
										<div class="col-md-4" style="padding-right: 15px;">
											<select name="PARENT_CATE" class="form-control" onchange="fnArcAjax(this.value,\''.$sShopNum.'\');">';
											echo '<option value="">==1차 카테고리==</option>';
											foreach($category as $values):
											echo '<option value="'.$values->id.'">'.$values->name.'</option>';	
											endforeach;
							echo 		'</select>
										</div>
										<div class="col-md-6">
											<select name="ARC_SEQ" class="form-control" id="TextArc_'.$sShopNum.'" onchange="fnArcChkYN(\''.$sShopNum.'\',this.value);">
												
											</select>
										</div>
									</div>
									<div class="row" style="margin-top: 10px">
										<label class="col-sm-2">* 상품명</label>
										<div class="col-md-4">
											<input type="text" class="input_txt2 per40 form-control en_product_name" name="PRO_NM" id="PRO_NM" maxlength="200"  value="" title="상품명" required onblur="javascript:fnValKeyRep( /[^a-zA-z0-9 \,\.\-]/g, this );" placeholder="영문">
										</div>
									</div>
									<div class="row" style="margin-top: 10px">
										<label class="col-sm-2">* 단가</label>
										<div class="col-md-4" style="padding-right: 15px;">
											단가
											<input type="text" class="input_txt2 per20 form-control-custom COST" name="COST"  maxlength="10" value="0" title="단가" required 
											onblur="fnNumChiper(this, \'2\');fnTotalProPrice();">
										</div>
										<div class="col-md-4">
											수량&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="text" class="input_txt2 per20 form-control-custom QTY" name="QTY"  maxlength="5" value="1" title="수량" required 
											onblur="fnNumChiper(this, \'0\');fnTotalProPrice();">
										</div>
									</div>
									<div class="row" style="margin-top: 10px">
										<label class="col-sm-2">* 옵션</label>
										<div class="col-md-4" style="padding-right: 15px;">
											색상
											<input type="text" class="input_txt2 per20 form-control-custom" name="CLR" id="CLR" maxlength="100" value="" title="색상(영문)">
										</div>
										<div class="col-md-4">	
											사이즈
											<input type="text" class="input_txt2 per20 form-control-custom" name="SZ" id="SZ" maxlength="80" value="" title="사이즈">
										</div>
									</div>
									<div class="row" style="margin-top: 10px">
										<label class="col-sm-2">* 상품URL</label>
										<div class="col-sm-10">
											<input type="text" class="input_txt2 full form-control" name="PRO_URL" id="PRO_URL" maxlength="500" value="" title="상품URL">
										</div>
									</div>
									<div class="row" style="margin-top: 10px">
										<label class="col-sm-2 fs-12">* 이미지URL	</label>
										<div class="col-sm-10">
											<input type="text" class="input_txt2 full form-control" name="IMG_URL" id="IMG_URL" maxlength="500" value="">
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="TextProduct'.(intval($sShopNum)+1).'" class="pro_p"></div>
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
			if($types ==2) $o = "delivery";
			else  $o = "buy";
			if($sShopNum >100) {echo json_encode(array("c"=>1,"data"=>"상품의 개수는 최대 100개를 넘길수 없습니다."));return;}
				
				foreach($pData as $keys=>$child){					
					$temp = "";
					$temp1="";
					$temp .= '
				<input type="hidden" name="ARV_STAT_CD" id="ARV_S" value="1">
				<div class="order_table order_table_top">
					<table class="proBtn_write" style= "width:100%">
						<tbody>
							<tr class="border">
								<td>
									<h4 class="s_tit vm_box" style="color:#ed7d31;">
										<label style="font-size:14px;">상품#'.$sShopNum.'</label>
										<input type="text" name="StockTxt" id="StockTxt" value="" class="stock-font" readonly="">
										<input type="hidden" name="PRO_STOCK_SEQ" id="PRO_STOCK_SEQ" value="0">
									</h4>
								</td>
								<td class="text-right">
									<div class="row">
										<div class="col-md-12">
											<a href=\'javascript:fnPageCopy2('.$sShopNum.',"'.$t.'");\' 
											type="button" class="btn btn-warning btn-sm btn-round">상품복사</a>
											<a href=\'javascript:fnProPlus('.$sShopNum.',"'.$t.'");\' 
											class="btn btn-danger btn-sm btn-round">+상품추가</a>
											<a href="javascript:fnStockTempDel('.$sShopNum.');" 
											class="btn btn-danger btn-sm btn-round">-상품삭제</a>
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
						<tbody>';
							if($types ==2){
						$temp.= '<tr id="DLVR_1">
								<th>트래킹번호<br>Tracking No.</th>
								<td colspan="3" class="vm_box">
									<div class="row">
										<div class="col-md-2 form-group tracks" style="padding-right: 15px">
											<select name="FRG_DLVR_COM" class="form-control" id="FRG_DLVR_COM">';
												foreach($tracking_header as $value):
												$temp.= '<option value="'.$value->name.'">'.$value->name.'</option>';
												endforeach;
									$temp.=	'</select>
										</div>
										<div class="col-md-4 form-group tracks" style="padding-right: 15px">
											<input type="text" class="input_txt2 form-control" name="FRG_IVC_NO" id="FRG_IVC_NO" maxlength="40" value="">
										</div>
										<div class="col-md-4 form-group">
											<label>
												<input type="checkbox" name="TRACKING_NO_YN" id="TRACKING_NO_YN" onchange="fnTrkNoAfChk('.$sShopNum.');">트래킹 번호 나중에 입력
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
											<input type="text" class="input_txt2 per40 form-control" name="SHOP_ORD_NO" id="SHOP_ORD_NO" maxlength="40" value="'.$child->order.'">
										</div>
									</div>													
								</td>
							</tr>';
						 	}
						$temp.= '<tr>
								<th>
									<p class="goods_img">
									<img src="'.$child->image.'" width="109" height="128" id="sImgNo'.$sShopNum.'"></p>
									<br><a class="btn-small  btn-secondary btn" href="javascript:openPopupImg('.$sShopNum.')" 
									data-img="'.$sShopNum.'"><span>이미지등록</span></a>
								</th>
								<td colspan="3">
									<div class="row" style="margin-top: 10px">
										<label class="col-sm-2">* 통관품목</label>
										<div class="col-md-4" style="padding-right: 15px;">
											<select name="PARENT_CATE" class="form-control" onchange="fnArcAjax(this.value,\''.$sShopNum.'\');">';
											if(!empty($category)):
												foreach($category as $values):
												$temp.= '<option value="'.$values->id.'">'.$values->name.'</option>';	
												endforeach;
											endif;	
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
									<div class="row" style="margin-top: 10px">
										<label class="col-sm-2">* 상품명</label>
										<div class="col-md-4">
											<input type="text" class="input_txt2 per40 form-control en_product_name" name="PRO_NM" id="PRO_NM" maxlength="200" title="상품명" required onblur="javascript:fnValKeyRep( /[^a-zA-z0-9 \,\.\-]/g, this );" placeholder="영문">
										</div>
									</div>
									<div class="row" style="margin-top: 10px">
										<label class="col-sm-2">* 단가</label>
										<div class="col-md-5" style="padding-right: 15px;">
											단가
											<input type="text" class="input_txt2 per20 form-control COST" name="COST"  maxlength="10" value="'.(float)$child->price.'" title="단가" required 
											onblur="fnNumChiper(this, \'2\');fnTotalProPrice();">
										</div>
										<div class="col-md-5">
											수량
											<input type="text" class="input_txt2 per20 form-control QTY" name="QTY"  maxlength="5" value="'.(int)$child->count.'" title="수량" required 
											onblur="fnNumChiper(this, \'0\');fnTotalProPrice();">
										</div>
									</div>
									<div class="row" style="margin-top: 10px">
										<label class="col-sm-2">* 옵션</label>
										<div class="col-md-5" style="padding-right: 15px;">
											색상
											<input type="text" class="input_txt2 per20 form-control" name="CLR" id="CLR" maxlength="100" value="'.$child->color.'" title="색상(영문)">
										</div>
										<div class="col-md-5">	
											사이즈
											<input type="text" class="input_txt2 per20 form-control" name="SZ" id="SZ" maxlength="80" value="'.$child->size.'" title="사이즈">
										</div>
									</div>
									<div class="row" style="margin-top: 10px">
										<label class="col-sm-2">* 상품URL</label>
										<div class="col-sm-10">
											<input type="text" class="input_txt2 full form-control" name="PRO_URL" id="PRO_URL" maxlength="500" value="'.$child->link.'" title="상품URL">
										</div>
									</div>
									<div class="row" style="margin-top: 10px">
										<label class="col-sm-2 fs-12">* 이미지URL</label>
										<div class="col-sm-10">
											<input type="text" class="input_txt2 full form-control" name="IMG_URL" id="IMG_URL" maxlength="500" value="'.$child->image.'">
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>';

				$temp1.='<div id="TextProduct'.(intval($sShopNum)+1).'" class="pro_p">';
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
