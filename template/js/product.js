var old_eval_id;
var here = new Array();
var returned_check = new Array();
here["qna"] = here["eval"] = 0;
returned_check["qna"]  = returned_check["eval"] = 1;
$(".btn_ok").on('click',function(e){
	e.preventDefault();
	var $this = $(this);
    var h_type = $this.data("type");
	var templateScriptTwo = $('#eval-lists').html();
    var formData = new FormData(document.getElementById(h_type+"_frm"));
    if($("#"+h_type+"_title").val().trim() == ""){
    	$("#"+h_type+"_title").focus();
    	alert("제목이 비였습니다.");
    	return;
    }
    if($("#"+h_type+"_content").val().trim() == ""){
    	$("#"+h_type+"_content").focus();
    	alert("내용이 비였습니다.");
    	return;
    }
    $.ajax({
        type:'POST',
        url: $("#"+h_type+"_frm").attr('action'),
        data:formData,
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
		beforeSend:function(){
			$this.button('loading');
		},
        success:function(data){    
        	$this.button('reset');       	
            if(data.status == "success"){
            	var templateTwo = Handlebars.compile(templateScriptTwo);
				if(data.type == "eval"){
					$('#ID_eval_list ul').prepend(templateTwo(data.result));
					$("#rating_"+data.result.id).starRating({
					 	initialRating:data.result.eval_point,
						disableAfterRate: false,
					    starSize: 20,
					    starShape: 'rounded',
					    emptyColor: 'lightgray',
					    hoverColor: 'salmon',
					    activeColor: 'crimson',
					    minRating: 0,
					    readOnly:true,
					    callback: function(currentRating, $el){
					      	$("#eval_point").val(currentRating);
					  	}
					});

					$("#eval_title").val("");
                    $("#eval_content").val("");
                    $("#eval_point").val("");
				}
				else{
					$('#ID_qna_list ul').prepend(templateTwo(data.result));
					$("#qna_title").val("");
                    $("#qna_content").val("");
				}
            }
            if(data.status =="error"){
            	alert(data.result);
            	return;
            }
        }
    }).fail(function(jqXHR,res){
    	alert("서버오류");
    	location.reload();
    });

});    


// $("#carousel-products .item img").elevateZoom({tint:true, tintColour:'#F90', tintOpacity:0.5});
function changeShopCount(price,id,count){
	if(count <=0 ){alert("수량은 0보다 작을수 없습니다.");return;}
	var size = $(".size").text();
	var color = $(".color").text();
	jQuery.ajax({
      method: "POST",
      url: baseURL+"addCar",   
      data: {id:id,count:count,size:size,color:color}
    })
    .done(function( msg ) {
      	if(msg == 3)
      		alert('옵션을 선택해주세요');
      	if(msg == 2)
      		alert('상품이 존재하지 않습니다.');	
      	if(msg ==1 )
        	alert("장바구니에 추가되였습니다");
        if(msg ==5 )
        	alert("이미 장바구니에 추가된 상품입니다.");
    });
}


function eval_show(id) {
	$(".eval_box_area").removeClass("open");

	// 열려있는걸 다시 클릭했을때는 닫기만 처리한다.
	if(old_eval_id == id) {this.old_eval_id = 0;return;}

	$("#"+id).addClass("open");

	old_eval_id = id;
}

function getReivews(class_name="#ID_eval_list",type="eval",$second=""){
	var templateScriptTwo = $('#eval-lists').html();
	var templateTwo = Handlebars.compile(templateScriptTwo);

	if(here[type] >= review_count[type]) $("#more_"+type).addClass("disabled");
	if(here[type] < review_count[type] && returned_check[type] ==1){
		jQuery.ajax({
		      method: "POST",
		      url: baseURL+"getReivews",   
		      data: {here:here[type],pcode:pcode,type:type},
		      dataType:"json",
		      beforeSend: function() {
		        returned_check[type] = 0 ;
		        $('.loading_products').removeClass("d-none");
		    },
		})
		.done(function( msg ) {
			$('.loading_products').addClass("d-none");
			returned_check[type] =1;
			here[type] =  here[type] + 15;
			if(here[type] >= review_count[type]) $("#more_"+type).addClass("disabled");
		    if(msg.status =="success"){
		    	if(msg.type =="eval"){
		    		$.each(msg.result,function(index,value){
			    		$(class_name).find("ul").append(templateTwo(value));
			    		$("#rating_"+value.id).starRating({
			    			readOnly:true,
						 	initialRating:value.eval_point,
							disableAfterRate: false,
						    starSize: 20,
						    starShape: 'rounded',
						    emptyColor: 'lightgray',
						    hoverColor: 'salmon',
						    activeColor: 'crimson',
						});
			    	});
		    	}
		    	else{
		    		$.each(msg.result,function(index,value){
			    		$(class_name).find("ul").append(templateTwo(value));
			    	});
		    	}
		    }
		    if($second =="start"){
		    	getReivews('#ID_eval_list','eval','');
		    }
		    footer_position = $("#footer").position().top;
		}).fail(function(jq) {
			$('.loading_products').addClass("d-none");
			returned_check[type] =1;
			return;
		})
	}
	
}
function qna_write_form_view() {
	$("#qna_contents_area .form_area").toggle();
}

// 리뷰 삭제
function eval_del(uid) {
	var cur = $("#view_"+uid);
	if(confirm("정말 삭제하시겠습니까?")) {
		$.ajax({
			url: "/eval_update",
			cache: false,
			type: "POST",
			data: {_mode : "delete", uid : uid },
			success: function(data){
				if( data.trim() == "login" ) {
					alert('비정상적인 유저활동이 감지되였습니다');
					return;
				}
				if( data.trim() == "no data" ) {
					alert('등록하신 글이 아닙니다.');
				}
				else if( data.trim() == "is reply" ) {
					alert('댓글이 있으므로 삭제가 불가합니다.');
				}

				else if(data.trim() =="none"){
					alert('내용이 비였습니다.');
				}

				else {
					alert('정상적으로 삭제하였습니다.');
					cur.remove();
				}
			}
		});
	}
}

$("#like-add").click(function(){
	var $this = $(this);
	var pcode = $(this).data("pcode");
	var  mode = "add";
	if($(this).hasClass("not_if_wish"))
		mode = "delete";
	if(pcode.trim() != "")	
	{
		$.ajax({
			data: {'mode':mode,'code':pcode},
			type: 'POST',
			cache: false,
			url: baseURL+'product_wish',
			dataType:"json",
			success: function(data) {
				if(data.status == "1"){
					alert(data.result);
					location.href =	"/login?redirect="+ConvertStringToHex(location.href);
					return;
				}
				if(data.status == "2"){
					alert(data.result); 
					$this.removeClass("if_wish");
					$this.addClass("not_if_wish");
					return;
				}
				if(data.status == "3"){
					alert(data.result);
					$this.addClass("if_wish");
					$this.removeClass("not_if_wish");
					return;
				}
				else { alert("NONE"); }
			},
			error:function(request,status,error){
				alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
		})
	}
})

$(document).ready(function(){
	$(window).scroll(function() {
        var h =$(window).scrollTop();
        var i = 0;
        if(h > 1370)
        {
			if(i ==2 || i==0)
			{
				$("#nav").addClass("fixed");
				$("#nav").scrollspy({ offset: -135 });
				
			}
        	i=1;
        }
        else
        {
        	if(i ==1 || i==0)
			{
				$("#nav").removeClass("fixed");
				$("#nav").scrollspy({ offset: -135 });
			}
        	i=2;
        }

    });

    
})