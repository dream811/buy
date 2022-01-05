<?php $data['title'] = "주문 및 배송현황"; ?>
<?php $this->load->view("my_header",$data); ?>
<div class="container">
	<div class="row">
		<div id="subRight"> 
			<div class="con">
				<div class="row myPageTab2 bg-white" style="padding-top: 20px">
					<?php foreach($category as $value): ?>
						<div class="col-md-12 text-center p-left-10 p-right-10 mb-10" >
							<div class="p-5 bg-weakgreen">
								<img src="<?=$value->image?>" height=32>
								<span ><?=$value->title?></span>
							</div>
							<ul class="border-l border-r border-b bg-gray">
								<?php foreach($delivery[$value->step] as $child): ?>
									<li class="p-left-10">
										<a href="/viewdeliveryState?step=<?=$child->step?>" class="<?=$step==$child->step?"selected":""?>">
											<span ><?=$child->name?></span><span class="fr">
												<?php if(isset($step_array[$child->step]) && $step_array[$child->step] > 0 && $child->step!=12) 
												echo $step_array[$child->step]; ?>
												<?php if($child->step==12) echo $errorCoutr; ?>
												<?php if(!isset($step_array[$child->step]) && $child->step!=12) echo 0; ?>
											</span>
										</a>
									</li>
								<?php endforeach; ?>						
							</ul>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="row">
					<form method="get" action="<?=base_url()?>viewdeliveryState" id="frmS">
						<div class="row">
							<div class="col-xs-3 p-left-10 p-right-1">
								<input type="hidden" name="today" id="today" value="<?= !empty($_GET['today']) ? $_GET['today']:""?>">
			                    <select class="form-control" name="process">
			                    	<option value="1" 
			                    	<?php if(!empty($_GET['process']) && $_GET['process'] == "1" || empty($_GET['[process']))  echo 'selected'; ?>
			                    	>처리순</option>
			                    	<option value="2"
			                    	<?php if(!empty($_GET['process']) && $_GET['process'] == '2') echo 'selected';?>>등록순</option>
			                    </select>
							</div>
							<div class="col-xs-9 p-left-1 p-right-10">
								<div class="row">
									<div class="col-xs-6 p-1">
						            <input type="date" name="from" class="form-control" value="<?=empty($_GET['from']) == 0 ? $_GET['from']:date("Y-m-d", time()-7776000) ?>"  style="padding: 6px 6px;">
						       </div>
						        <div class="col-xs-6 p-1">
						            <input type="date" name="to" class="form-control" value="<?=empty($_GET['to']) == 0 ? $_GET['to']:date("Y-m-d") ?>"  style="padding: 6px 6px;">
					            </div>
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 p-left-10 p-right-1">
								<div class="row">
									<div class="col-xs-4 p-1">
										<select class="form-control ft-12" style="padding: 6px 6px;" name="type">
											<option value="">=선택=</option>
											<option value="1" <?=$this->input->get("type") ==1 ? "selected":""?>>주문번호</option>
											<option value="2" <?=$this->input->get("type") ==2 ? "selected":""?>>트래킹번호</option>
											<option value="3" <?=$this->input->get("type") ==3 ? "selected":""?>>수취인명</option>
											<option value="4" <?=$this->input->get("type") ==4 ? "selected":""?>>오더넘버</option>
										</select>
									</div>
									<div class="col-xs-8 p-1">
										<input type="text" class="form-control" name="content" value="<?=$this->input->get("content")?>">
									</div>
								</div>
							</div>
							<div class="col-xs-2 p-left-1 p-right-10 pt-2">
								<input class="btn btn-yonpu btn-round btn-block" value="검색" type="submit">
							</div>
						</div>
					</form>	
				</div>	
				<form name="frmSearch" id="frmSearch" method="post" action="" class="mt-5">
					<input type="hidden" name="did" id="did">
					<div class="p-left-10 p-right-10 pb-5">
						<table class="table border-b border-r">
						    <tbody>
							     <?php  foreach($deliver_content as $key_dval=>$dvalue): ?>
							     	<?php if($key_dval > 0): ?>
							     	<tr>
							     		<td class="border-none"></td>
							     		<td class="border-none"></td>
							     	</tr>
							     	<?php endif; ?>
							     	<tr class="border-l">
							     		<td class="mid bg-gray border-r" style="min-width: 80px;width: 80px">
							     			<input type="checkbox" class="input_chk" name="chkORD_SEQ" id="chkORD_SEQ" value="<?=$dvalue->id?>"> 주문정보
							     		</td>
							     		<td style="min-width: 133px;width: 133px;padding: 2px !important" class="border-r">
							     			<a href="/view/delivery/<?=$dvalue->rid?>" class="bold blue"><?=$dvalue->ordernum?></a> | <?=$dvalue->area_name?><br>
												<span class="font-weight-bold">
													<?php 
														if($dvalue->type=="1") echo '배송대행';
														if($dvalue->type=="2") echo '구매대행';
														if($dvalue->type=="4") echo '리턴대행';
														if($dvalue->type=="3") echo '쇼핑몰';
													?>
													</span> | <?php 
												if($dvalue->pcount >1) echo '합배송';else echo '단독배송';?><br>
												<?php  	if($dvalue->combine == 1) echo '묶음배송<br>';
														if($dvalue->combine == 2) echo '나눔배송<br>'; ?>
												<label><?=$dvalue->billing_krname?></label>
							     		</td>
							     		<td rowspan="4" class="mid border-r border-b" style="min-width: 130px;width: 130px">
							     			<?php if(trim($dvalue->Dcomment)!="" && $dvalue->Duse==1): ?>
					                            <button type="button" class="btn btn-super-sm btn-secondary btn-block btn-round " onclick="fnFrgImgView2('<?=$dvalue->id?>');" title="">메모&실사</button>
					                        <?php endif; ?>
					                        <?php if($dvalue->pays ==1) { ?> <a href="#" class="btn btn-secondary disabled btn-block btn-super-sm btn-round">승인대기</a> <?php } ?>
											<?php if($dvalue->state==5 || $dvalue->state==14 || $dvalue->state==20): ?>
											<a href="/mypay" class="btn btn-warning btn-super-sm btn-block btn-round">결제대기</a>
											<?php endif; ?>
											<?php if($dvalue->state!=5 && $dvalue->state!=14 && $dvalue->state!=20 && $dvalue->add_check==1): ?>
												<a href="/mypay" class="btn btn-success btn-super-sm btn-block btn-round">결제대기</a>
											<?php endif; ?>
											<?php if($dvalue->state ==40): ?>
												<a  class="btn btn-warning btn-super-sm disabled btn-block btn-round">배송비제출중</a>	
											<?php endif; ?>
											
					                        <?php if($dvalue->state ==23 && !empty($dvalue->tracking_number)): ?>
												<a href="https://unipass.customs.go.kr/csp/index.do" target="_blink"  class="btn-round btn btn-super-sm btn-rok text-white btn-block">통관조회</a>
											<?php endif; ?>
											<?php if($dvalue->state ==1 || $dvalue->state ==4): ?>
												<a href="/view/delivery/<?=$dvalue->rid?>" class="btn btn-grey btn-super-sm btn-block btn-round">수정</a>	
											<?php endif; ?>
											<?php if($dvalue->state ==11):?>
												<a href="javascript:requestDelivery(<?=$dvalue->id?>,<?=$dvalue->ordernum?>);" class="btn btn-danger btn-super-sm btn-block btn-round">배송요청</a>
											<?php endif; ?>
											<?php if($dvalue->state ==2 || $dvalue->state ==11 || $dvalue->state ==7): ?>
												<a href="javascript:fnPopPlus(<?=$dvalue->id?>);" class="btn btn-yonpu btn-super-sm btn-block text-white btn-round 
												<?php if($dvalue->combine !=-1) echo 'disabled' ?>">묶음배송</a>
												<a href="javascript:fnPopMinus(<?=$dvalue->id?>);" href="#" class="btn btn-yonpu btn-super-sm btn-block  text-white btn-round 
													<?php if($dvalue->combine !=-1) echo 'disabled' ?>">나눔배송</a>
											<?php endif; ?>
											<a href="javascript:viewProducts(<?=$dvalue->id?>)"  class="btn btn-super-sm btn-secondary btn-round btn-block viewpro_btn">
												<span>상품보기</span>
											</a>
							     		</td>
							     	</tr>
							     	<tr>
							     		<td class="mid bg-gray border-r border-l">
							     			등록일<br>처리일
							     		</td>
							     		<td>
							     			<?=date_format(date_create($dvalue->created_date),"Y-m-d")?>
											</br>
											<?=date_format(date_create($dvalue->updated_date),"Y-m-d")?>
							     		</td>
							     	</tr>
							     	<tr>
							     		<td class="mid bg-gray border-r border-l">
							     			상품가격
							     		</td>
							     		<td>
							     			￥ <?=number_format($dvalue->pprice, 2, '.', '')?>
							     		</td>
							     	</tr>
							     	<tr class="border-b">
							     		<td  class="mid bg-gray border-r border-l">
							     			결제금액<br>운송장번호
							     		</td>
							     		<td class="mid">
							     			<?php if($dvalue->purchase_price > 0): ?>
												<a href="javascript:fnChaView(<?=$dvalue->id?>);" class="modalPop" wd="500" ht="250" ><strong>구매비용(<?php if($dvalue->payed_checked==1) echo '완료';else echo '미입금'; ?>)</strong><br><?=number_format(str_replace(",","",$dvalue->purchase_price))?>원</a>
											<?php endif; ?>
											<?php if($dvalue->sending_price > 0): ?>
												<br>
												<a href="javascript:fnChaView(<?=$dvalue->id?>);" class="modalPop" wd="500" ht="250" ><strong>배송비용(<?php if($dvalue->payed_send==1) echo '완료';else echo '미입금'; ?>)</strong><br><?=number_format(str_replace(",","",$dvalue->sending_price))?>원</a>
											<?php endif; ?>
											<?php if($dvalue->return_price > 0): ?>
												<br>
												<a href="javascript:fnChaView(<?=$dvalue->id?>);" class="modalPop" wd="500" ht="250" ><strong>리턴비용(<?php if($dvalue->return_check==1) echo '완료';else echo '미입금'; ?>)</strong><br><?=number_format(str_replace(",","",$dvalue->return_price))?>원</a>
											<?php endif; ?>
											
											<?php if($dvalue->add_check==1): ?>
												<br>
												<a href="javascript:fnChaView(<?=$dvalue->id?>);" class="modalPop" wd="500" ht="250" ><strong>추가결제비용(미입금)</strong><br><?=number_format(str_replace(",","",$dvalue->add_price))?>원</a>
											<?php endif; ?>
											<?php if($dvalue->add_check==0 && $dvalue->add_check!=NULL): ?><br>
												<a href="javascript:fnChaView(<?=$dvalue->id?>);" class="modalPop" wd="500" ht="250" ><strong>추가결제비용(완료)</strong><br><?=number_format(str_replace(",","",$dvalue->add_price))?>원</a>
											<?php endif; ?>
											<?php if($dvalue->add_check==2): ?><br>
												<a href="javascript:fnChaView(<?=$dvalue->id?>);" class="modalPop" wd="500" ht="250" ><strong>추가결제비용(결제대기중)</strong><br><?=number_format(str_replace(",","",$dvalue->add_price))?>원</a>
											<?php endif; ?>
											<?php if($dvalue->add_check==3): ?><br>
												<a href="javascript:fnChaView(<?=$dvalue->id?>);" class="modalPop" wd="500" ht="250" ><strong>추가결제비용(취소)</strong><br><?=number_format(str_replace(",","",$dvalue->add_price))?>원</a>
											<?php endif; ?>
											<?php if($dvalue->state == 16 || $dvalue->state == 23): ?>
												<a target="_blink" href="https://www.doortodoor.co.kr/parcel/pa_004.jsp" class="btn-block text-danger"><?=$dvalue->tracking_number?></a>
											<?php endif; ?>
											
							     		</td>
							     	</tr>
							     	<tr id="dproduct<?=$dvalue->id?>" class="thead-dark border-l"></tr>
							     <?php  endforeach;?>
						  	</tbody>
						</table>
					</div>
				</form>	
				<div class="text-center">
					<?php echo $this->pagination->create_links(); ?>
				</div>
				<?php if($step ==1 || $step ==4 || $step ==14  || $step ==5): ?>
				<div class="row my-4 p-left-5">
					<a href="javascript:deleteOrder()" class="btn btn-warning btn-sm btn-round">주문삭제</a>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="details_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">결제내역상세</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="silsa_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">실사내역</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
       		<iframe id="ifrm"  frameborder="0" width="100%" height="600"></iframe>
      </div>
    </div>
  </div>
</div>
<link href="<?php echo site_url('/template/css/my.css'); ?>" rel="stylesheet">

<script language="JavaScript">
function goToRegister(){
	$("#contact_modal").modal('toggle');
	$("#register_form").modal('show');
    $("#postcode").val("");
    $("#address").val("");
    $("#details").val("");
    $("#name").val("");
    $("#eng_name").val("");
    $("#p1").val("");
    $("#p2").val("");
    $("#p3").val("");
    $("#RRN_NO").val("");
	$("#del_id").val("");
}
function openDaumPostcode() {
    new daum.Postcode({
        oncomplete: function(data) {
			if ( data.userSelectedType == "R" ) {
				document.getElementById('postcode').value = data.zonecode;
				document.getElementById('address').value = data.roadAddress;
				document.getElementById('details').focus();
				//document.getElementById('ADDR_1_EN').value = data.addressEnglish;
			} else {
				alert("지번주소가 아닌 도로명주소를 선택하십시오.");
			}
        }
    }).open();
}

function closeRegister(){
	$("#contact_modal").modal('show');
	$("#register_form").modal('toggle');
}
$(".deleteContact").click(function(){
	currentRow = $(this);
	var id=$(this).data("delivery");
	if(id > 0){
		var message = confirm("정말 삭제하시겠습니까?");
    	if(message){
    		$.ajax({
			  method: "POST",
			  url: baseURL+"deleteContact",
			  data: { id:id}
			})
			.done(function( msg ) {
			    currentRow.parents('tr').remove();
			});
    	}
	}
});

function acceptOrder() {

	var frmObj = "#frmSearch";
	var did = "";
	$(frmObj + " input[name='sKind']").val("D");

	if (fnSelBoxCnt($(frmObj + " input[name='chkORD_SEQ']")) <= 0) {
		alert('신청할 주문을 선택하십시오.');
		return;
	}
	$(frmObj + " input[name='chkORD_SEQ']").each(function(){
		if($(this).is(":checked")) did = did+$(this).val()+"|";
	});
	$(frmObj + " input[name='did']").val(did);
	if (confirm("정말 신청하시겠습니까?")) { 
		$("#frmSearch").attr("method", "post").attr("action", "./acceptO");
		$("#frmSearch").submit();
	}
}

$(".editContact").click(function(){
	var contact_modal = $("#contact_modal");
	var register_form = $("#register_form");
	var id=$(this).data("delivery");
	var register_form = $("#register_form");
	$.ajax({
	  	method: "POST",
	  	url: "getContact",
	  	data: { id:id},
	  	dataType:'json'
	})
	.done(function( msg ) {
	    register_form.find("#del_id").val(msg[0].id);
	    register_form.find("#postcode").val(msg[0].postcode);
	    register_form.find("#address").val(msg[0].address);
	    register_form.find("#details").val(msg[0].details_address);
	    register_form.find("#name").val(msg[0].name);
	    register_form.find("#eng_name").val(msg[0].eng_name);
	    register_form.find("#p1").val(msg[0].phone.split("-")[0]);
	    register_form.find("#p2").val(msg[0].phone.split("-")[1]);
	    register_form.find("#p3").val(msg[0].phone.split("-")[2]);
	    register_form.find("#RRN_NO").val(msg[0].unique_info);
	    if(msg[0].type==1) register_form.find("#inlineCheckbox1").attr('checked', 'checked');
	    else register_form.find("#inlineCheckbox2").attr('checked', 'checked');
	    contact_modal.modal('toggle');
		register_form.modal('show');
	});

});
function viewProducts(id){ 
	if($("#dproduct"+id).text().trim() == "") fnGetChgHtmlAjax("dproduct"+id,baseURL+"getDproducts","?dp="+id);
	else{
		if($("#dproduct"+id).is(":visible")) $("#dproduct"+id).hide();
		else  $("#dproduct"+id).show();
	}
	
}

function deleteOrder() {

	var frmObj = "#frmSearch";
	var did = "";
	$(frmObj + " input[name='sKind']").val("D");

	if (fnSelBoxCnt($(frmObj + " input[name='chkORD_SEQ']")) <= 0) {
		alert('삭제할 주문을 선택하십시오.');
		return;
	}
	$(frmObj + " input[name='chkORD_SEQ']").each(function(){
		if($(this).is(":checked")) did = did+$(this).val()+"|";
	});
	$(frmObj + " input[name='did']").val(did);
	if (confirm("주문을 삭제 하시겠습니까?\n삭제시 복구가 불가능합니다.")) { 
		$("#frmSearch").attr("method", "post").attr("action", "./deletesO");
		$("#frmSearch").submit();
	}
}

function fnSearchDate(value){
	debugger;
	$("#today").val(value);
	$("#frmS").submit();
}
function fnChaView(id){

	jQuery.ajax({
		type : "POST",
		url : baseURL+"getTotalDelivery",
		data : { delivery_id : id ,my:1} 
		}).done(function(data){
			$("#details_modal").modal("show");
			$("#details_modal .modal-body").html(data);
	});
}

function requestDelivery(id,ordernum){
	$.ajax({
	  	method: "POST",
	  	url: "<?=base_url()?>requestDelivery",
	  	data: { id:id},
	  	dataType:'json',
	  	success: function(data) {
            if(data.status==100){
            	socket.emit("chat message",1,ordernum,<?=$this->session->userdata('fuser')?>,
            		"reqdelivery","<?=$this->session->userdata('fname')?>");
		    	window.location.href ="/viewdeliveryState?step=40";
		    }
		    if(data.status==102) {
		    	alert("오류입고된 상품을 확인해주세요");
		    	return;
		    }
        },
        error: function(data) {
            alert("서버오류");
        }
	});
}

function registerAdds(obj){

	if ( !fnIptChk($("input[name='postcode']"))) {

		fnMsgFcs($("input[name='postcode']"), '우편번호를 입력해 주세요');
		return;
	}

	if ( !fnIptChk($("input[name='address']"))) {

		fnMsgFcs($("input[name='address']"), '주소명을 입력해 주세요.');
		return;
	}

	if ( !fnIptChk($("input[name='details']"))) {

		fnMsgFcs($("input[name='details']"), '상세주소명을 입력해 주세요.');
		return;
	}

	if ( !fnIptChk($("input[name='name']"))) {

		fnMsgFcs($("input[name='name']"), '수취인이름을 입력해 주세요.');
		return;
	}

	if ( !fnIptChk($("input[name='eng_name']"))) {

		fnMsgFcs($("input[name='eng_name']"), '수취인이름(영문)을 입력해 주세요.');
		return;
	}

	if ( !fnIptChk($("input[name='p1']"))) {

		fnMsgFcs($("input[name='p1']"), '연락처를 입력해 주세요.');
		return;
	}

	if ( !fnIptChk($("input[name='p2']"))) {

		fnMsgFcs($("input[name='p2']"), '연락처를 입력해 주세요.');
		return;
	}

	if ( !fnIptChk($("input[name='p3']"))) {

		fnMsgFcs($("input[name='p3']"), '연락처를 입력해 주세요.');
		return;
	}

	if ( !fnIptChk($("input[name='RRN_NO']"))) {

		fnMsgFcs($("input[name='RRN_NO']"), '받는 사람 정보를 입력해 주세요.');
		return;
	}

	var $this = $(obj);
	var formData = new FormData(document.getElementById("registerContact"));
	$.ajax({
        method: "POST",
        url: baseURL + "registerContact",
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function() {
	      	$this.button('loading');  
	    },
        success: function (data) {
        	$this.button('reset');
        	alert("성공적으로 등록했습니다.");
        	location.reload();
        },
        error: function(request, status, error) {
        	alert("서버오류");
            $this.button('reset');
        }
    });
}

function gotoRequest(data = "",option=""){
	if(data.trim() !="")
		socket.emit("chat message",1,data,"<?=$this->session->userdata('fuser')?>", option,"<?=$this->session->userdata('fname')?>");
	location.href= "<?=base_url()?>viewdeliveryState?step=40";
}
</script>