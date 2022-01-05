<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        쇼핑몰 카테고리 설정
      </h1>
    </section>
    
    <section class="content">
    	<input type="hidden" id="cates_2" value="0">
    	<input type="hidden" id="cates_3" value="0">
        <div class="row">
        	<div class="col-xs-12">
        		<div class="box">
            		<div class="box-body table-responsive no-padding">
            			<table class="table" summary="검색항목">
							<colgroup>
								<col width="33%"/><col width="33%"/><col width="33%"/>
							</colgroup>
							<thead>
								<tr>
									<th scope="col" class="colorset">
										<div class='btn_line_up_center'>
											<span class='shop_btn_pack'>1차 카테고리</span>
											<span class='shop_btn_pack'><span class='blank_3'></span></span>
											<span class='shop_btn_pack'><input type='button' name='' class='input_small blue' value='추가' 
												onclick='fnPopWinCT("<?=base_url()?>category_pro?depth=0&step=1", "1차 카테고리 추가", 500, 700, "Y")'></span>
										</div>
									</th>
									<th scope="col" class="colorset">
										<div class='btn_line_up_center'>
											<span class='shop_btn_pack'>2차 카테고리</span>
											<span class='shop_btn_pack'><span class='blank_3'></span></span>
											<span class='shop_btn_pack'><input type='button' name='' class='input_small blue' value='추가' onclick="c_add('2','','list2');"></span>
										</div>
									</th>
									<th scope="col" class="colorset">
										<div class='btn_line_up_center'>
											<span class='shop_btn_pack'>3차 카테고리</span>
											<span class='shop_btn_pack'><span class='blank_3'></span></span>
											<span class='shop_btn_pack'><input type='button' name='' class='input_small blue' value='추가' onclick="c_add('3','','list3');"></span>
										</div>
									</th>
								</tr>
							</thead> 
							<tbody> 
								<tr>
									<td class="conts">
										<table class="table table-bordered">
											<colgroup><col width="*"><col width="120px"></colgroup>
											<tbody class="list_1 list_r">
												<?php if(!empty($first_category)): ?>
												<?php foreach($first_category as $value): ?>
												<tr id="item_<?=$value->id?>" data-cuid="<?=$value->id?>">
													<td class="pointer text-left mid" onclick="selectSubCategory(<?=$value->id?>,1,$(this))">
														<span class="shop_state_pack ml-5" >
														<?php if($value->use ==1): ?>
															<span class="bg-warning p-5 text-white item_showing">노출</span>
														<?php endif; ?>
														<?php if($value->use ==0): ?>
															<span class="bg-secondary p-5 text-white item_showing">숨김</span>
														<?php endif; ?>
														</span>
														<span class="ml-5 item_name"><?=$value->name?></span></td>
													<td>
														<div class="btn_line_up_center">
															<span class="shop_btn_pack"><input type="button" name="" class="input_small blue btn-block btn" value="수정" 
																onclick='fnPopWinCT("<?=base_url()?>category_pro?depth=<?=$value->parent?>&mode=update&c_uid=<?=$value->id?>&step=1", "1차 카테고리 추가", 500, 700, "Y")'></span>
														</div>
													</td>
												</tr>
												<?php endforeach; ?>
												<?php endif; ?>
												
											</tbody>
										</table>
									</td>
									<td class="conts">
										<table class="table table-bordered">
											<colgroup><col width="*"><col width="120px"></colgroup>
											<tbody class="list_2 list_r">

											</tbody>
										</table>
									</td>
									<td class="conts">
										<table class="table table-bordered">
											<colgroup><col width="*"><col width="120px"></colgroup>
											<tbody class="list_3 list_r">
											</tbody>
										</table>
									</td>
								</tr>
							</tbody> 
						</table>
            		</div>
        		</div>
        	</div>
        </div>
    </section>
</div>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script>
	var ajax_returned = 1;
	function redirect(id =0,name="",showing="",step=1,type=""){

		if(step ==1)
			var depth = 0;
		else
			var depth = $('#cates_'+step).val();

		var	var_showing="",
			var_class="",
			negotive = "";

		if(type == "delete")
		{
			$("#item_"+id).remove();
			return;
		}	

		if(showing ==1)
		{
			var_showing = "노출";
			var_class = "bg-warning";
			negotive = "bg-secondary";
		}

		else{
			var_showing = "숨김";
			var_class = "bg-secondary";
			negotive = "bg-warning";
		}


		if(type == "update" )
		{
			$("#item_"+id).find(".item_name").text(name);
			$("#item_"+id).find(".item_showing").text(var_showing);
			$("#item_"+id).find(".item_showing").removeClass(negotive);
			$("#item_"+id).find(".item_showing").addClass(var_class);
		}

		else{
			var output = "";
			output = "<tr id='item_"+id+"' data-cuid='"+id+"'>";
			output = output + '<td class="pointer text-left mid" onclick="selectSubCategory('+id+','+step+',$(this))">';
			output = output + '<span class="shop_state_pack ml-5" >';
			output = output + '<span class="'+var_class+' p-5 text-white item_showing">'+var_showing+'</span>';
			output = output + "<span class='item_name ml-5'>" + name + "</span>";
			output = output +"</td>";
			output = output + '<td>\
								<div class="btn_line_up_center">\
									<span class="shop_btn_pack"><input type="button" name="" class="input_small blue  btn-block btn" value="수정" \
										onclick=\'fnPopWinCT("<?=base_url()?>category_pro?depth='+depth+'&mode=update&c_uid='+id+'&step='+step+'", "'+step+'차 카테고리 추가", 500, 700, "Y")\'></span>\
								</div>\
							</td>\
						</tr>';
			$(".list_"+step).prepend(output)
		}
	}
	function selectSubCategory(id,step,obj){

		if(ajax_returned ==0 || step ==3)
			return;

		$(".list_"+step).find("tr").removeClass("bg-light");
		if(step ==1)
		{
			$(".list_3").html("");
			$("#cates_3").val(0);
		}
		obj.parent().addClass("bg-light");
		var tem = step + 1;
		$("#cates_"+tem).val(id);
		$(".list_"+tem).html("");
		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url :  "<?php echo base_url(); ?>getshopcategory",
			data : { id:id,type:"list"},
			beforeSend: function(xhr) {
				ajax_returned =0;	
			}
			}).done(function(data){
				var result = data.result;
				var output  ="";
				if(result.length > 0){
					jQuery.each(result,function(index,value){	
						var showing = "";
						if(value.use ==1)
							showing ='<span class="bg-warning p-5 text-white item_showing">노출</span>';
						else 
							showing ='<span class="bg-secondary p-5 text-white item_showing">숨김</span>';
						output = "<tr id='item_"+value.id+"' data-cuid='"+value.id+"'>";
						output = output + '<td class="pointer text-left mid" onclick="selectSubCategory('+value.id+','+tem+',$(this))">';
						output = output + '<span class="shop_state_pack ml-5" >';
						output = output + showing;
						output = output + "<span class='item_name ml-5'>" + value.name + "</span>";
						output = output +"</td>";
						output = output + '<td>\
											<div class="btn_line_up_center">\
												<span class="shop_btn_pack"><input type="button" name="" class="input_small blue  btn-block btn" value="수정" \
													onclick=\'fnPopWinCT("<?=base_url()?>category_pro?depth='+$('#cates_'+tem).val()+'&mode=update&c_uid='+value.id+'&step='+tem+'", "'+step+'차 카테고리 추가", 500, 700, "Y")\'></span>\
											</div>\
										</td>\
									</tr>';

						$(".list_"+tem).append(output);

					});
				}
		}).always(function(jqXHR, textStatus) {
			ajax_returned =1;
		})
	}


	function c_add(c_depth,c_uid,framename){
	    var rtn_cd = true;
		var c_parent = "";
		c_parent = $('#cates_'+c_depth).val();
	    if( c_depth == "2" ) {

	        if( c_parent <=0) {
	            alert('1차 카테고리를 선택해주세요');
	            return false;
	        }
	    }
	    else if( c_depth == "3" ) {

	        if( c_parent <=0) {
	            alert('2차 카테고리를 선택해주세요');
	            return false;
	        }
	    }

	   fnPopWinCT("<?=base_url()?>category_pro?depth="+c_parent+"&step="+c_depth, "1차 카테고리 추가", 500, 700, "Y");
	    return rtn_cd;
	}


</script>

<script type="text/javascript">
  	var hitURL =  baseURL + "updateOrderCategory";
  	var art = new Array();
  	var checked_action = 1;
  	$(".list_r").sortable({
  		update: function(event, ui) {
  			if(checked_action ==1){
  				var wrap_tr = $(this).parent().find("tr");
	    		art = new Array();
	    		wrap_tr.each(function( index ) {
	    			art.push($(this).data("cuid"));
	    		}).promise().done( function(){
	    			jQuery.ajax({
				      	type : "POST",
				      url : hitURL,
				      data : { ids : art },
				      beforeSend:function(){
				      	loading.removeClass("d-none");
				      	checked_action = 0;
				      }
				      }).done(function(data){

				      }).always(function(jqXHR, textStatus) {
				        loading.addClass("d-none");
				        checked_action = 1;
				    });
	    		});
  			}
  		}
	});
</script>