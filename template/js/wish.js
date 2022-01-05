var here = 0;
var returned_check =1;
var checked_id = new Array();
function getWish(){
	var templateScriptTwo = $('#wish-lists').html();
	var templateTwo = Handlebars.compile(templateScriptTwo);
	if(here >= all) $("#more_wish").addClass("disabled");
	if(here < all && returned_check ==1){
		jQuery.ajax({
		      method: "POST",
		      url: baseURL+"getWish",
		      data: {here:here},
		      dataType:"json",
		      beforeSend: function() {
		        returned_check = 0 ;
		        $('.loading_products').removeClass("d-none");
		    },
		})
		.done(function( msg ) {
			$('.loading_products').addClass("d-none");
			returned_check =1;
			here =  here + 15;
			if(here >= all) $("#more_wish").addClass("disabled");
		    if(msg.status =="success"){

	    		$.each(msg.result,function(index,value){
		    		$(".cm_mypage_wish").find("ul").append(templateTwo(value));
		    	});

		    }
		}).fail(function(jq) {
			$('.loading_products').addClass("d-none");
			returned_check =1;
			alert("서버오류");
			return;
		});
	}
}

function all_check() {
	if($("._chk_class").length < 1) {alert("찜한 상품이 없습니다.");return;}
	$("._chk_class").prop("checked",true);
}

function all_uncheck() {
	if($("._chk_class").length < 1) {alert("찜한 상품이 없습니다.");return;}
	$("._chk_class").prop("checked",false);
}

function select_delete() {
	checked_id = new Array();
	if($("._chk_class").length < 1) {alert("찜한 상품이 없습니다.");return;}

	if($("._chk_class").is(":checked") != true) {alert("삭제할 상품을 선택하세요.");return;}

	if(!confirm("선택한 찜 상품을 삭제하시겠습니까?")) return;
	
	var items = $("._chk_class");
	
	$.each(items,function(index,value){
		if($(this).prop("checked") == true){
			checked_id.push($(this).val());
		}
	});
	ProcessDeleteWish();
}

function deleteWish(id){
	checked_id = new Array();
	checked_id.push(id);
	ProcessDeleteWish();
}

function ProcessDeleteWish(){
	if(!confirm("정말 삭제하시겠습니까?")) return;
	jQuery.ajax({
	    method: "POST",
	    url: baseURL+"deleteWishes",   
	    data: {checked_id:checked_id},
	    dataType:"json",
	    beforeSend: function() {
	        returned_check = 0 ;
	        $('.loading_products').removeClass("d-none");
	    },
	})
	.done(function( msg ) {
		$('.loading_products').addClass("d-none");
		if(msg.status == "deleted")
		{
			$.each(checked_id,function(index,value){
				$("#wish_"+value).remove();
			})
		}
		else{
			alert("처리중 오류가 발생하였습니다.");
		}
	}).fail(function(jq) {
		alert("서버오류");
		location.reload();
		return;
	});	
}

$(document).ready(function(){
	getWish();
})