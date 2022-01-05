$('#popFrmImg').on('submit',(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type:'POST',
        url: $(this).attr('action'),
        data:formData,
        dataType: "json",
        async: false,
		processData: false,
		contentType: false,
		
        success:function(data){            	
            $('#exampleModalCenter').modal('toggle');
            if(data.errorId==0){
            	$("input[name='IMG_URL']").eq($("#product_val").val()-1).val(baseURL+"upload/delivery/"+data.img);
            	$("#sImgNo"+$("#product_val").val()).attr("src",baseURL+"upload/delivery/"+data.img);
            }

        }
    });
}));

$(".accept").click(function(e){
	e.preventDefault();
	var FRG_DLVR_COM =new Array();
	var FRG_IVC_NO = new Array();
	var SHOP_ORD_NO = new Array();
	var PARENT_CATE = new Array();
	var ARC_SEQ = new Array();
	var PRO_NM = new Array();
	var COST =new Array();
	var QTY = new Array();
	var CLR = new Array();
	var SZ = new Array();
	var PRO_URL = new Array();
	var IMG_URL = new Array();
	var temp_array = new Array();
	var main_array  =new Array();
	var c_continue = 0;
	var $this = $(this);
	if($(this).attr('id')=="waitAccept"){
		$("#waiting").val(1);
	}
	if($(this).attr('id')=="requestAccept"){
		$("#waiting").val(0);
	}
	if(!$("#agreecyn").is(':checked')){
		$([document.documentElement, document.body]).animate({
	        scrollTop: $(".orderTit").offset().top
	    }, 2000);
		alert("서비스 이용약관을 동의해주세요.");
		c_continue =1;
		return;
	}
	if( $("#ADRS_KR").val().trim() == "" || 
		$("#ADRS_EN").val().trim() == "" || 
		$("#RRN_NO").val().trim()  == "" ||
		$("#MOB_NO1").val().trim() == "" ||
		$("#MOB_NO2").val().trim() == "" ||
		$("#MOB_NO3").val().trim() == "" ||
		$("#ZIP").val().trim() == "" ||
		$("#ADDR_1").val().trim() == ""){
		$([document.documentElement, document.body]).animate({
	        scrollTop: $("#stepOrd-EtcTt").offset().top
	    }, 2000);
		alert("받는 사람 정보를 입력해주세요.");
		c_continue =1;
		return;
	}

	for( var i=1; i<=$("#sProNum").val(); i++ ) {

		temp_array = new Array();
		if(options !='buy'){
			if($(this).attr('id')=="requestAccept"){
				if ( !fnIptChk($("input[name='FRG_IVC_NO']").eq(i-1)) ) {
					fnMsgFcs($("input[name='FRG_IVC_NO']").eq(i-1), '트래킹번호를 입력해주세요.');
					c_continue =1;
					return;
				}
			}	
		}
		if($("input[name='TRACKING_NO_YN']").eq(i-1).prop('checked')){
			temp_array.push("");
			temp_array.push("");
		}
		else{
			temp_array.push($("select[name='FRG_DLVR_COM']").eq(i-1).val()==null?"":$("select[name='FRG_DLVR_COM']").eq(i-1).val());
			temp_array.push($("input[name='FRG_IVC_NO']").eq(i-1).val()==null?"":$("input[name='FRG_IVC_NO']").eq(i-1).val());
		}

		if ( !fnIptChk($("select[name='ARC_SEQ']").eq(i-1)) ) {
			fnMsgFcs($("select[name='ARC_SEQ']").eq(i-1), '통관품목을 선택해 주세요.');
			c_continue =1;
			return;
		}

		if ( !fnIptChk($("input[name='PRO_NM']").eq(i-1)) ) {
			fnMsgFcs($("input[name='PRO_NM']").eq(i-1), '상품명을 입력해 주세요.');
			c_continue =1;
			return;
		}

		
		if ( !fnIptChk($("input[name='COST']").eq(i-1)) ) {
			fnMsgFcs($("input[name='COST']").eq(i-1), '단가를 입력해 주세요.');
			c_continue =1;
			return;
		}

		if ( Number($("input[name='COST']").eq(i-1).val()) <= 0 ) {
			fnMsgFcs($("input[name='COST']").eq(i-1), '단가는 0보다 커야합니다.');
			c_continue =1;
			return;
		}
		if ( !fnIptChk($("input[name='QTY']").eq(i-1)) ) {
			fnMsgFcs($("input[name='QTY']").eq(i-1), '수량을 입력해 주세요.');
			c_continue =1;
			return;
		}
		if ( Number($("input[name='QTY']").eq(i-1).val()) <= 0 ) {
			fnMsgFcs($("input[name='QTY']").eq(i-1), '수량은 0보다 커야합니다.');
			c_continue =1;
			return;
		}
		temp_array.push($("input[name='SHOP_ORD_NO']").eq(i-1).val());
		temp_array.push($("select[name='PARENT_CATE']").eq(i-1).val());
		temp_array.push($("select[name='ARC_SEQ']").eq(i-1).val());
		temp_array.push($("input[name='PRO_NM']").eq(i-1).val()); 
		temp_array.push($("input[name='COST']").eq(i-1).val()); 
		temp_array.push($("input[name='QTY']").eq(i-1).val()); 
		temp_array.push($("input[name='CLR']").eq(i-1).val()); 
		temp_array.push($("input[name='SZ']").eq(i-1).val()); 
		temp_array.push($("input[name='PRO_URL']").eq(i-1).val()); 
		temp_array.push($("input[name='IMG_URL']").eq(i-1).val());
		temp_array.push("");
		temp_array.push("");
		main_array.push(temp_array);
	}

	if(c_continue ==0 ){
		$("#theader").val(JSON.stringify(main_array));
		var formData = new FormData(document.getElementById("deliverForm"));
		$.ajax({
            async: true,
            type: $(gFrmNm).attr('method'),
            url: $(gFrmNm).attr('action'),
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function() {
		      	$this.button('loading');  
		    },
            success: function (data) {
            	if(data == 0 ){
            		alert("서버오류");
                	$this.button('reset');
            	}
                if(data != 0){
                    socket.emit("chat message",1,data,userId,$("#type_options").val(),userName);
                    window.location.href="/mypage"; 
                }
            },
            error: function(request, status, error) {
            	alert("서버오류");
                $this.button('reset');
            }
        });
	}
});

var textarea = document.getElementById("ie-clipboard-contenteditable");