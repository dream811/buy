<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?=$this->input->get('step')?>차 카테고리 관리</title>
	<link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />  
	<link href="<?php echo base_url(); ?>assets/dist/css/admin.css?<?=time()?>" rel="stylesheet" type="text/css" />  
	<script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
</head>
<body>
	<div class="wrapper">
		<div class="row">
			<div class="col-xs-12">
				<div class="box p-10">
					<div class="box-body table-responsive no-padding">
						<table class="table table-bordered">
							<colgroup><col width="*"><col width="120px"></colgroup>
							<?php if(!empty($category)): ?>
							<?php foreach($category as $value): ?>
							<tr>
								<td  class="pointer text-left">
									<span class="shop_state_pack ml-5">
										<?php if($value->use ==1): ?>
											<span class="bg-warning p-5 text-white">노출</span>
										<?php endif; ?>
										<?php if($value->use ==0): ?>
											<span class="bg-secondary p-5 text-white">숨김</span>
										<?php endif; ?>
									</span><?=$value->name?>
								</td>
								<td>
									<div class="btn_line_up_center">
										<span class="shop_btn_pack">
											<input type="button" name="" class="btn btn-block btn-defult" value="수정" onclick="c_add(<?=$depth?>, <?=$value->id?>, 'content');">
										</span>
									</div>
								</td>
							</tr>
							<?php endforeach; ?>
							<?php endif; ?>
						</table>
					</div>
					<div class="box-footer">
		                <?php echo form_open_multipart('addShopCategory',array('name' => 'frm'));?>
							<input type="hidden" name="parent" id="c_depth" value="<?=$depth?>">
							<input type="hidden" name="c_uid" id="c_uid">
							<input type="hidden" name="_mode">
							<input type="hidden" name="step" value="<?=$this->input->get("step")?>">
							<!-- 검색영역 -->
							<div class="form_box_area">
								<table class="table table-bordered" summary="검색항목">
									<colgroup><col width="120px"><col width="*"></colgroup>
									<tbody>
										<tr>
											<td class="article mid">카테고리명<span class="ic_ess" title="필수"></span></td>
											<td class="conts"><input type="text" name="name" class="form-control" id="name" required></td>
										</tr>											
										<tr>
											<td class="article mid">노출여부<span class="ic_ess" title="필수"></span></td>
											<td class="conts">
												<span class="multi">
													<input type="radio" id="c_viewY" name="use" value="1" checked="">
													<label for="c_viewY"> 노출</label>
												</span>
												<span class="multi">
													<input type="radio" id="c_viewN" name="use" value="0">
													<label for="c_viewN"> 숨김</label>
												</span>
											</td>
										</tr>
										
										<tr>
											<td class="article mid">상단배너사용</td>
											<td class="conts">
												<span class="multi">
													<input type="radio" id="c_img_top_banner_useY" name="banner_use" value="1" class="top_banner_use">
													<label for="c_img_top_banner_useY"> 사용</label>
												</span><span class="multi">
													<input type="radio" id="c_img_top_banner_useN" name="banner_use" value="0" class="top_banner_use" checked="">
													<label for="c_img_top_banner_useN"> 사용안함</label></span>
											</td>
										</tr>
										<tr class="top_banner_area" style="display: none;">
											<td class="article top_banner_area mid" style="display: none;">상단 배너<br>(1200 x free)</td>
											<td class="conts top_banner_area mid" style="display: none;">
												<div class="mb-5 banner_exised none">
													<img src="" class="w-100" id="img_banner">
													<br>
													<a href="javascript:void(0)" class="text-danger banner" onclick="deleteFile(1,<?=!empty($value->id) ? $value->id : ""?>,'banner',this)">삭제</a>
												</div>
												<input type="file" name="banner" size="20" class="input_text">
											</td>
										</tr>
										<tr class="top_banner_area" style="display: none;">
											<td class="article top_banner_area mid" style="display: none;">모바일 상단 배너<br>(600 x free)</td>
											<td class="conts top_banner_area mid" style="display: none;">
												<div class="mb-5 mobile_exised none">
													<img src="" class="w-100" id="img_mobile_banner">
													<br>
													<a href="javascript:void(0)" class="text-danger mobile_banner" onclick="deleteFile(2,<?=!empty($value->id) ? $value->id : ""?>,'mobile_banner',this)">삭제</a>
												</div>
												<input type="file" name="mobile_banner" size="20" class="input_text">
											</td>
										</tr>
										<tr class="top_banner_area" style="display: none;">
											<td class="article top_banner_area mid" style="display: none;">아이콘<br>(50 x 50)</td>
											<td class="conts top_banner_area mid" style="display: none;">
												<div class="mb-5 icon_exised none">
													<img src="" class="" id="img_icon">
													<br>
													<a href="javascript:void(0)" class="text-danger icon" onclick="deleteFile(3,<?=!empty($value->id) ? $value->id : ""?>,'icon',this)">삭제</a>
												</div>
												<input type="file" name="icon" size="20" class="input_text">
											</td>
										</tr>
										<tr class="top_banner">
											<td class="article top_banner_area mid" style="display: none;">배너 링크 주소</td>
											<td class="conts top_banner_area" style="display: none;">
												<input type="text" name="banner_link" class="form-control" id="banner_link">
											</td>
										</tr>
										<tr class="top_banner_area" style="display: none;">
											<td class="article top_banner_area mid" style="display: none;">배너 링크 형식</td>
											<td class="conts top_banner_area" style="display: none;">
												<span class="multi"><input type="radio" id="c_img_top_banner_target_self" name="banner_type" value="_self" checked="">
													<label for="c_img_top_banner_target_self"> 같은창</label>
												</span>
												<span class="multi">
													<input type="radio" id="c_img_top_banner_target_blank" name="banner_type" value="_blank">
													<label for="c_img_top_banner_target_blank"> 새창</label>
												</span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<!-- 버튼영역 -->
							<div class="bottom_btn_area">
								<div class="text-center">
									<span class="shop_btn_pack">
										<input type="submit" name="" class="btn btn-primary btn-lg" value="저장" >
										<input type="button" name="" class="btn btn-danger btn-lg" value="삭제" onclick="c_delete()">
										<input type="button" name="" class="btn btn-secondary btn-lg" value="닫기" onclick="self.close();">
									</span>
								</div>
							</div>
							<!-- 버튼영역 -->
						</form>
		            </div>
		        </div>
			</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	
	var uid_content = 0;
	var banner_url="",mobile_banner_url="",icon_url="";
	<?php if($mode =="update"): ?>
	uid_content = JSON.parse('<?=$uid_content?>');
	<?php endif; ?>

	var top_banner_use_check = function() {
		if($(".top_banner_use:checked").val() == "1") 
			$(".top_banner_area").show();
		else  
			$(".top_banner_area").hide();
	}
	$(".top_banner_use").click(top_banner_use_check);	
	top_banner_use_check();

	function c_add(depth,id,type){
		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url :  "<?php echo base_url(); ?>getshopcategory",
			data : { depth : depth,id:id,type:type } 
			}).done(function(data){
				showUpdateInformation(data);
			});
	}

	function deleteFile(i_type,id,type,obj){
	    var $this=$(obj);
	    var message = confirm("이 첨부파일을 삭제하시겠습니까?");
	    var hitURL = "<?=base_url()?>deleteShopBanner";
	    if(i_type ==1)
	    	var url = banner_url;
	    if(i_type ==2)
	    	var url = mobile_banner_url;
	    if(i_type ==3)
	    	var url = icon_url;
	    if(message){
	        jQuery.ajax({
	        type : "POST",
	        dataType : "json",
	        url : hitURL,
	        data : { id : id,url:url,type:type} ,
	        }).done(function(data){
	            if(data.status ==null)
	            {
	                alert("서버오류");
	                return;
	            }
	            if(data.status ==0)
	            {
	                alert("이미지가 존재하지 않습니다.");
	                return;
	            }
	            else{
	            	$("#img_"+type).remove();
	                $("."+type).remove();
	            }  
	        }).fail(function (jqXHR, textStatus, errorThrown) { 
	           console.log(jqXHR);
	        }); 
	    }
	}
	function c_delete() {
	    chkDel = confirm('메뉴를 삭제하시겠습니까?');
	    if(true == chkDel) {
	        document.frm._mode.value = "delete";
	        frm.submit();
	    }
	}

	function showUpdateInformation(data){
		if(data.success ==1)
		{
			var result = data.result;
			if(result.use ==1){
				$("#c_viewY").prop('checked', true);
			}
			else
				$("#c_viewN").prop('checked', true);
			if(result.banner_use ==1){
				$("#c_img_top_banner_useY").prop('checked', true);
			}
			else
				$("#c_img_top_banner_useN").prop('checked', true);

			$("#banner_link").val(result.banner_link);

			if(result.banner_type =="_self"){
				$("#c_img_top_banner_target_self").prop('checked', true);
			}
			else
				$("#c_img_top_banner_target_blank").prop('checked', true);

			if(result.banner !=null && result.banner.trim() !="")
			{
				$("#img_banner").attr("src","<?=base_url_source()?>upload/thumb/"+result.banner);
				$(".banner_exised").removeClass("none");
				banner_url = result.banner;
			}
			if(result.mobile_banner !=null && result.mobile_banner.trim() !="")
			{
				$("#img_mobile_banner").attr("src","<?=base_url_source()?>upload/thumb/"+result.mobile_banner);
				$(".mobile_exised").removeClass("none");
				mobile_banner_url = result.mobile_banner;
			}
			if(result.icon !=null && result.icon.trim() !="")
			{
				$("#img_icon").attr("src","<?=base_url_source()?>upload/thumb/"+result.icon);
				$(".icon_exised").removeClass("none");
				icon_url = result.icon;
			}
			$("#name").val(result.name);
			$("#c_uid").val(result.id);
			top_banner_use_check();
		}
	}

	$(document).ready(function(){
		if(uid_content.length > 0){
			uid_content = uid_content[0];
			uid_content.result =uid_content; 
			uid_content.success =1; 
			showUpdateInformation(uid_content);
		}
	})
</script>
<style type="text/css">
	.article {
	    background: #f1f1f1;
	    color: #000;
	    font-size: 12px;
	}
	.multi {
	    margin-right: 20px;
	}
</style>