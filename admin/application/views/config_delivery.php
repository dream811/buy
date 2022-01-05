<?php $siteInfo = $config_delivery[0]; ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        상품/배송관련설정
      </h1>
    </section>
    <section class="content">
        <div class="row">
        	<div class="col-xs-12">
        		<form name="frm" method=post action="<?=base_url("config_delivery_pro")?>">
        			<div class="box box-primary">
        				<div class="box-body table-responsive no-padding">
							<div class="form_box_area">
								<table class="table table-bordered" summary="검색항목">
									<colgroup>
										<col width="230px"/><!-- 마지막값은수정안함 --><col width="*"/>
									</colgroup>
									<tbody class="thead-dark">

										<tr>
											<th class="article">기본배송비<span class="ic_ess" title="필수"></span></th>
											<td class="conts"><input type="text" name="s_delprice" class="input_text number_style" style="width:60px" value='<?=$siteInfo->s_delprice?>' />
											무료배송은 0을 입력하세요.
											</td>
										</tr>
										<tr>
											<th class="article">무료배송비<span class="ic_ess" title="필수"></span></th>
											<td class="conts"><input type="text" name="s_delprice_free" class="input_text number_style" style="width:60px" 
												value='<?=$siteInfo->s_delprice_free?>' />
											</td>
										</tr>
										<tr>
											<th class="article">지정택배사<span class="ic_ess" title="필수"></span></th>
											<td class="conts">
												<select name="s_del_company" class="input_txt2">
													<?php foreach(Arr_Delivery_Company as $key=> $value): ?>
													<option value="<?=$key?>" <?=$siteInfo->s_del_company == $key ? "selected":""?>><?=$key?></option>	
													<?php endforeach; ?>
												</select>
											</td>
										</tr>
										<tr>
											<th class="article">평균배송기간<span class="ic_ess" title="필수"></span></th>
											<td class="conts"><input type="text" name="s_del_date" class="input_text " style="width:100px" 
												value='<?=$siteInfo->s_del_date?>' />
											</td>
										</tr>
										<tr>
											<th class="article">반송/교환배송비<span class="ic_ess" title="필수"></span></th>
											<td class="conts"><input type="text" name="s_del_complain_price" class="input_text " style="width:250px" 
												value='<?=$siteInfo->s_del_complain_price?>' />
											</td>
										</tr>
										<tr>
											<th class="article">반송주소<span class="ic_ess" title="필수"></span></th>
											<td class="conts"><input type="text" name="s_del_return_addr" class="input_text " style="width:250px" 
												value='<?=$siteInfo->s_del_return_addr?>' />
											</td>
										</tr>

										<tr>
											<th class="article">교환/반품/환불이 가능한 경우<span class="ic_ess" title="필수"></span></th>
											<td class="conts">
												<textarea class="form-control" id="editor" geditor name="s_complain_ok"><?=$siteInfo->s_complain_ok?></textarea>
											</td>
										</tr>
										<tr>
											<th class="article">교환/반품/환불이 불 가능한 경우<span class="ic_ess" title="필수"></span></th>
											<td class="conts">
												<textarea name="s_complain_fail" id="editor1" geditor class="form-control"><?=$siteInfo->s_complain_fail?></textarea>
											</td>
										</tr>
										<tr>
											<th class="article">참고사항</th>
											<td class="conts">
												<div class="guide_text">
													<span class="ic_blue"></span>
													<span class="blue">상품등록시 해당상품의 배송정책을 따로 입력하거나  직접 설정할 수 있습니다.</span>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div style="margin-bottom: 10px;text-align: center;">
								<input type="submit" value="저장" class="btn btn-primary btn-lg">
							</div>
						</div>
        			</div>
				</form>
        	</div>
        </div>
    </section>
</div>

<link href="<?php echo base_url(); ?>assets/dist/css/editor.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/dist/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea[geditor]",
        theme: "modern",
        language : 'ko_KR',
        height: 370,
        force_br_newlines : false,
        force_p_newlines : true,
        convert_newlines_to_brs : false,
        remove_linebreaks : true,
        forced_root_block : 'p', // Needed for 3.x
                relative_urls:true,
        allow_script_urls: true,
        remove_script_host: true,
            //convert_urls: false,
        formats: { bold : {inline : 'b' }},
        extended_valid_elements: "@[class|id|width|height|alt|href|style|rel|cellspacing|cellpadding|border|src|name|title|type|onclick|onfocus|onblur|target],b,i,em,strong,a,img,br,h1,h2,h3,h4,h5,h6,div,table,tr,td,s,del,u,p,span,article,section,header,footer,svg,blockquote,hr,ins,ul,dl,object,embed,pre",
        plugins: [
            "jbimages",
             "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
             "searchreplace visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
             "save table contextmenu directionality emoticons template paste textcolor"
       ],
       content_css: "/admin/assets/dist/css/editor.css",
       body_class: "editor_content",
       menubar : false,
       toolbar1: "undo redo | fontsizeselect | advlist bold italic forecolor backcolor | charmap | hr | jbimages | autolink link media | preview | code",
       toolbar2: "bullist numlist outdent indent | alignleft aligncenter alignright alignjustify | table"
     }); 
    function fnBbsFileDel(val) {
        var frmObj = document.frmBbs;
        if (!confirm('해당 첨부파일을 삭제하시겠습니까?')) {
            return;
        }
        frmObj.sKind.value = 'D';
        frmObj.sFL_SEQ.value = val;
        frmObj.action = '/admin/bbs_fl_D';
        frmObj.submit();
    }
</script>