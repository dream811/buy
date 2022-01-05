<?php $data['title'] = "마이홈"; ?>
<?php $this->load->view("my_header",$data); ?>
<?php $contact_size = sizeof($contacts); ?>
<div class="container">
	<div class="row">
		<div id="subRight">           
			<div class="con">
				<div class="row p-10 bg-charo">
					<div class="col-xs-4 p-3 ellipsis" style="height: 31px;line-height: 31px">
						<span class="clrMemLvl1 text-white" style="font-size:12px;"><?=$this->session->userdata('fname')?></span> 	
						<span style="font-size:13px;font-weight:bold;" class="text-white">고객님</span><br>
					</div>
					<div class="col-xs-8 p-3 text-right">
						<a href="#" class="btn btn-yonpu btn-sm btn-round" data-toggle="modal" 
						data-target="#table_modal" style="padding: 5px 2px;font-size: 11px">내 배송요금표</a>
						<a href="#" class="btn btn-yonpu  btn-sm btn-round" data-toggle="modal" 
						data-target="#address_modal" style="padding: 5px 2px;font-size: 11px">내 사서함주소</a>
						<a href="#" class="btn btn-yonpu  btn-sm btn-round" data-toggle="modal" 
						data-target="#contact_modal" style="padding: 5px 2px;font-size: 11px">내 주소관리</a>
					</div>
				</div>
				<div class="myhome_menu">
					<div class="row">
						<div class="col-xs-3 text-center p-0 border-b ming100 border-r">
							<a href="/viewdeliveryState">
								<img src="/template/images/myhome/delivery.png">
								<p class="ft-12">주문 및 <br>배송현황</p>
							</a>
						</div>
						<div class="col-xs-3 text-center p-0 border-b ming100 border-r">
							<a href="/mypay">
								<?php if($content > 0 ): ?>
								<span class="notify_icon"><?=$content?></span>
								<?php endif;?>
								<img src="/template/images/myhome/paying.png" >
								<p class="ft-12">결제페이지</p>
							</a>
						</div>
						<div class="col-xs-3 text-center p-0 border-b ming100 border-r">
							<a href="/deposit">
								<img src="/template/images/myhome/deposit.png">
								<p class="ft-12">예치금/포인트</p>
							</a>
						</div>
						<div class="col-xs-3 text-center p-0 border-b ming100">
							<a href="/private?option=my">
								<img src="/template/images/myhome/Q&A.png" >
								<p class="ft-12">Q & A</p>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3 text-center p-0 border-b ming100 border-r">
							<a href="/coupon">
								<?php if($coupon > 0 ): ?>
								<span class="notify_icon"><?=$coupon?></span>
								<?php endif;?>
								<img src="/template/images/myhome/coupon.png" >
								<p class="ft-12">나의쿠폰함</p>
							</a>
						</div>
						<div class="col-xs-3 text-center p-0 border-b ming100 border-r">
							<a href="/mailbox">
								<?php if($mail_count > 0 ): ?>
								<span class="notify_icon"><?=$mail_count?></span>
								<?php endif;?>
								<img src="/template/images/myhome/mail.png">
								<p class="ft-12">받은쪽지함</p>
							</a>
						</div>
						<div class="col-xs-3 text-center p-0 border-b ming100 border-r">
							<a href="/member">
								<img src="/template/images/myhome/member.png">
								<p class="ft-12">회원정보수정</p>
							</a>
						</div>
						<div class="col-xs-3 text-center p-0 border-b ming100">
							
						</div>
					</div>
				</div>
				<div class="row mt-20 pb-10">
					<div class="col-xs-12">
						<a href="/logout" class="btn btn-green btn-block btn-lg">로그아웃</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="table_modal">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content" >
      <div class="modal-header text-center">
        <h5 class="modal-title">배송 요금표</h5>
      </div>
      <div class="modal-body">
      	<p><?=$this->session->userdata("fname")?>회원님은 <?=$user[0]->role?> 등급 혜택을 적용 받고 있습니다.</p>
        <iframe src="/getPricesByRole" style="width: 100%;border:none;height: calc(80vh - 188px);"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-round" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="address_modal">
	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
		        <h5 class="modal-title">나의 중국주소</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
	      	<div class="modal-body" style="height: 500px">
	        	<iframe src="<?=base_url()?>MemCtr_S" width="100%" height="100%" class="border-none"></iframe>
	    	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-danger btn-round" data-dismiss="modal">닫기</button>
	      	</div>
	    </div>
	 </div>
</div>

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
	        <div>
				<table class="table table-dark">
					<colgroup>
						<col width="10%"> 
						<col width="18%"> 
						<col width="37%"> 					
						<col width="22%"><col width=""> 
					</colgroup>
					<thead>
				      <tr>
				        <th scope="col">NO</th>
				        <th scope="col">수취인</th>
				        <th scope="col">주소</th>
				        <th scope="col">상세주소</th>
				        <th scope="col"></th>
				      </tr>
				    </thead>
				    <tbody>
				    	<?php if(!empty($contacts)): ?>
				    		<?php foreach($contacts as $value): ?>
				    			<tr>
				    				<td><?=$contact_size?></td>
				    				<td><?=$value->name?></td>
				    				<td><?=$value->address?></td>
				    				<td><?=$value->details_address?></td>
				    				<td>
				    					<a href="#" class="btn btn-sm btn-warning editContact btn-block btn-round" data-delivery="<?=$value->id?>">수정</a>
				    					<a href="javascript:void();" class="btn btn-sm btn-danger deleteContact btn-block btn-round" data-delivery="<?=$value->id?>">삭제</a>
				    				</td>
				    			</tr>
				    			<?php $contact_size = $contact_size -1; ?>
				    		<?php endforeach; ?>
				    	<?php endif; ?>	
				    </tbody>
				</table>
	      </div>
	      <div class="modal-footer" style="text-align: center;">
	      	<a href="#" class="btn btn-danger btn-round" onclick="goToRegister()">등록</a>
	        <button type="button" class="btn btn-default btn-round" data-dismiss="modal">닫기</button>
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
					    <label for="postcode">우편번호</label> <a href="javascript:openDaumPostcode();" class="btn btn-warning btn-sm btn-round">주소검색</a>
					    <input type="text" class="form-control my-4" name="postcode" required id="postcode">
					    <input type="hidden" name="page" value="viewdeliveryState">
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
				  		<label for="RRN_NO" class="d-block">받는 사람 정보</label>
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
					    <input type="text" class="form-control" name="RRN_NO" id="RRN_NO">
				  	</div>
		      	</div>
		      <div class="modal-footer text-left">
		      	<a href="Javascript:void(0)" onclick="registerAdds(this);" class="btn btn-danger btn-sm btn-round" 
		      	data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중">
		      		배송지 등록
		      	</a>
		      	<a href="#" class="btn btn-secondary btn-round btn-sm" onclick="closeRegister();">목록</a>
		      </div>
		    </div>
		  </div>
		</div>
	</form>
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
<script>
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
				  url: "deleteContact",
				  data: { id:id}
				})
				.done(function( msg ) {
				    currentRow.parents('tr').remove();
				});
	    	}
		}
	});
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
</script>