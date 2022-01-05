<div class="modal fade" tabindex="-1" role="dialog" id="contact_modal">
	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">배송지 목록</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="table-responsive">
				<table class="table table-dark add_tab">
					<thead>
				      <tr>
				        <th scope="col">NO</th>
				        <th scope="col">수취인</th>
				        <th scope="col">주소</th>
				        <th scope="col">상세주소</th>
				      </tr>
				    </thead>
				    <tbody>
				    	<?php if(!empty($contacts)): ?>
				    		<?php foreach($contacts as $value): ?>
				    			<tr id="tr_<?=$value->id?>">
				    				<td class="ids"><?=$value->id?></td>
				    				<td class="name_td"><?=$value->name?></td>
				    				<td class="address_td"><?=$value->address?></td>
				    				<td class="details_td"><?=$value->details_address?></td>
				    				<td>
				    					<a href="#" class="btn btn-sm btn-warning editContact" data-delivery="<?=$value->id?>">수정</a>
				    					<a href="javascript:void();" class="btn btn-sm btn-danger deleteContact" data-delivery="<?=$value->id?>">삭제</a>
				    				</td>
				    			</tr>
				    		<?php endforeach; ?>
				    	<?php endif; ?>	
				    </tbody>
				</table>
	      </div>
	      <div class="modal-footer">
	      	<a href="#" class="btn btn-danger" onclick="goToRegister()">등록</a>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="register_form">
	<form action="registerContact" method="post" id="registerContact">
		<div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header text-center">
		        <h5 class="modal-title">배송지 등록</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <div class="table-responsive">
					<div class="form-group">
					    <label for="postcode">우편번호</label> <a href="javascript:openDaumPostcode();" class="btn btn-warning btn-sm">주소검색</a>
					    <input type="text" class="form-control my-4" name="postcode" required id="postcode" readonly>
					    <input type="hidden" name="page" value="mypage">
					    <input type="hidden" name="id" value="" id="del_id">
				  	</div>
				  	<div class="form-group">
					    <label for="address">주소</label>
					    <input type="text" class="form-control" name="address" readonly placeholder="한글" required id="address">
				  	</div>
				  	<div class="form-group">
					    <label for="details">상세주소</label>
					    <input type="text" class="form-control" name="details" id="details">
				  	</div>
				  	<div class="form-group">
					    <label for="name">수취인 이름(한글)</label>
					    <input type="text" class="form-control" name="name" required id="name">
				  	</div>
				  	<div class="form-group">
					    <label for="eng_name">수취인 이름(영문)</label>
					    <input type="text" class="form-control" name="eng_name" id="eng_name">
				  	</div>
				  	
				  	<div class="form-group">
				  		<label>연락처</label>
						<div class="row grid" style="width: 200px">
						  	<div class="col">
						  		<input type="text" name="p1" class="form-control" required id="p1">
						  	</div>
						  	<div class="col">
						  		<input type="text" name="p2" class="form-control" required id="p2">
						  	</div>
						  	<div class="col">
						  		<input type="text" name="p3" class="form-control" required id="p3">
						  	</div>
						</div>
				  	</div>
				  	<div class="form-group">
				  		<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" id="inlineCheckbox1" value="1" name="type" checked>
						  <label class="form-check-label" for="inlineCheckbox1">개인통관고유부호 (추천)</label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" id="inlineCheckbox2" value="2" name="type">
						  <label class="form-check-label" for="inlineCheckbox2">사업자번호</label>
						</div>
				  	</div>
				  	<div class="form-group">
					    <label for="RRN_NO">받는 사람 정보</label>
					    <input type="text" class="form-control" name="RRN_NO" id="RRN_NO">
				  	</div>
		      	</div>
		      <div class="modal-footer text-left">
		      	<a href="javascript:registerContact()" class="btn btn-danger">배송지 등록</a>
		      	<a href="#" class="btn btn-secondary" onclick="closeRegister()">목록</a>
		      </div>
		    </div>
		  </div>
		</div>
	</form>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="table_modal">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content" style="height: 80vh;">
      <div class="modal-header text-center">
        <h5 class="modal-title">배송 요금표</h5>
        <p><?=$this->session->userdata("fname")?>회원님은 <?=$this->session->userdata("froleText")?> 등급 혜택을 적용 받고 있습니다.</p>
      </div>
      <div class="modal-body">
        <iframe src="/getPricesByRole" style="width: 100%;border:none;height: calc(80vh - 188px);"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="address_modal">
	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	<div class="modal-body" style="height: 500px">
	        	<iframe src="<?=base_url()?>MemCtr_S" width="100%" height="100%"></iframe>
	    	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
	      	</div>
	    </div>
	 </div>
</div>
<script>
	var register_form = $("#register_form");
	function goToRegister(){
		$("#contact_modal").modal('toggle');
		$("#register_form").modal('show');
		register_form.find("#del_id").val("");
	    register_form.find("#postcode").val("");
	    register_form.find("#address").val("");
	    register_form.find("#details").val("");
	    register_form.find("#name").val("");
	    register_form.find("#eng_name").val("");
	    register_form.find("#p1").val("");
	    register_form.find("#p2").val("");
	    register_form.find("#p3").val("");
	    register_form.find("#RRN_NO").val("");
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
				  url: "deleteContact",
				  data: { id:id}
				})
				.done(function( msg ) {
				    currentRow.parents('tr').remove();
				});
	    	}
    	}
    });

    $(document).on("click", ".editContact", function(){
    	var contact_modal = $("#contact_modal");
    	var id=$(this).data("delivery");
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
function registerContact(){
	if($("#postcode").val().trim()=="" || $("#address").val().trim()=="")
    {
    	alert("해당 주소를 입력하세요");
    	return;
    }
    if($("#name").val().trim()=="" || $("#eng_name").val().trim()=="")
    {
    	alert("이름을 입력하세요");
    	return;
    }
    if($("#name").val().trim()=="" || $("#eng_name").val().trim()=="")
    {
    	alert("이름을 입력하세요");
    	return;
    }
    var data = $('#registerContact').serialize();
    $.ajax({
        method: "POST",
        url: baseURL+"registerContact",
        data: data,
        dataType:"json"
    })
    .done(function( msg ) {
      if(msg.result==100){
      		alert("등록되였습니다.");
      		if($("#del_id").val() > 0){
      			$("#tr_"+$("#del_id").val()+" .name_td").text($("#name").val());
      			$("#tr_"+$("#del_id").val()+" .address_td").text($("#address").val());
      			$("#tr_"+$("#del_id").val()+" .details").text($("#details").val());
      		
      		}
      		else{
      			$(".add_tab tbody").append('<tr id="tr_'+msg.value+'">\
				    				<td class="ids">'+msg.value+'</td>\
				    				<td class="name_td">'+$("#name").val()+'</td>\
				    				<td class="address_td">'+$("#address").val()+'</td>\
				    				<td class="details_td">'+$("#details").val()+'</td>\
				    				<td>\
				    					<a href="#" class="btn btn-sm btn-warning editContact" data-delivery="'+msg.value+'">수정</a>\
				    					<a href="javascript:void();" class="btn btn-sm btn-danger deleteContact" data-delivery="'+msg.value+'">삭제</a>\
				    				</td>\
				    			</tr>');
      		}	
      	}
      	if(msg==101) 
      	{
      		alert("서버오류.");
      	}
      	$("#register_form").modal("toggle");
      	$("#contact_modal").modal("show");
    });
  }
</script>
<style>
	.name_td{
		white-space: nowrap;
    	overflow: hidden;
    	text-overflow: ellipsis;
    	max-width: 50px;
	}
	.address_td{
		white-space: nowrap;
    	overflow: hidden;
    	text-overflow: ellipsis;
    	max-width: 100px;
	}
</style>