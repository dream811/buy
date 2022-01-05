var  height = $("#moved_item").offset().top;
var old_eval_id;
var here = new Array();
var returned_check = new Array();
here["qna"] = here["eval"] = 0;
returned_check["qna"]  = returned_check["eval"] = 1;
$("#delivery_method").change(function(){
    delivery_price = $(this).find(":selected").data("price");
    $(".method").text($(this).val());
    delivery_method = $(this).val();
    update_sum_price();
});

$(".new-rating-4").starRating({
    initialRating:0,
    disableAfterRate: true,
    starSize: 35,
    starShape: 'rounded',
    emptyColor: 'lightgray',
    hoverColor: 'salmon',
    activeColor: 'crimson',
    minRating: 0,
    callback: function(currentRating, $el){
        $("#eval_point").val(currentRating);
    }
});

$(".option-value").change(function(){
    var temp_price = parseInt(price);
    var count = $("#option_select_cnt").val();
    var name = $(this).data("name");
    init_add = 0;
    output_adds = new Array();
    var size = "";
    add_options[$(this).val()] = $(this).find(":selected").data("price");
    var temp = 0;
    $.each($(".option-value"),function(index,value){
        var this_p = parseInt($(this).find(":selected").data("price"));
        output_adds.push($(this).val());
        if(temp < this_p)
            temp = this_p;
        size += $(this).find(":selected").data("insert") + ",";
    });
    if(size.trim()!="")
        size = size.substring(0, size.length - 1);
    $(".size").val(size);
    $("#option_select_expricesum").val(temp);
    $("#option_select_addsum").val(temp);
    $("#option_select_expricesum_display").text(fnCommaNum((temp)*count));
});

$('.slicks').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: true,
      fade: true,
      arrows:false
    });


$('.part-slick-recommend').slick({
    speed: 300,
    slidesToShow: 8,
    slidesToScroll: 1,
    arrows: false, 
    autoplay: true,
    autoplaySpeed: 3000,
    responsive: [
    {
        breakpoint: 1024,
        settings: {
        slidesToShow: 8,
        slidesToScroll: 3,
        infinite: true,
      }
    },
    {
        breakpoint: 600,
        settings: {
        slidesToShow: 5,
        slidesToScroll: 2
      }
    },
    {
        breakpoint: 480,
        settings: {
        slidesToShow: 3,
        slidesToScroll: 1
      }
    }
  ]
});

$(".my-rating-4").starRating({
    readOnly:true,
    starShape: 'rounded',
    starSize: 20,
    emptyColor: 'lightgray',
    hoverColor: 'salmon',
    activeColor: 'crimson',
    minRating: 0
});

$(".btn_ok").on('click',function(e){
    e.preventDefault();
    var new_rating = $(".new-rating-4");
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
                    location.href = "/login?redirect="+ConvertStringToHex(location.href);
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
});

$(".c_product_btn_share").click(function(){
    if($(".shared_buttons").hasClass("disabled_btns"))
        $(".shared_buttons").removeClass("disabled_btns");
    else
        $(".shared_buttons").addClass("disabled_btns");
})

window.onscroll = function() {myFunction()};

function myFunction() {
    var header = document.getElementById("myTab");
    var sticky = header.offsetTop;
    if (window.pageYOffset > sticky + 250) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
}

function pro_cnt_up() {
    cnt = $("#option_select_cnt").val()*1;
    if(cnt > $("#option_select_cnt").data("max")-1)
    {
        alert("최대상품개수보다 클수 없습니다.");
        return;
    }
    $("#option_select_cnt").val(cnt+1);
    update_sum_price();
}
function pro_cnt_down() {

    cnt = $("#option_select_cnt").val()*1;
    if(cnt > 1) $("#option_select_cnt").val(cnt-1);

    update_sum_price();
}


function update_sum_price() {
    if($("#option_select_cnt").val() > $("#option_select_cnt").data("max"))
    {
        alert("최대상품개수보다 클수 없습니다.");
        $("#option_select_cnt").val($("#option_select_cnt").data("max")) ;
    }
    if($("#option_select_cnt").val() <=0 || isNaN($("#option_select_cnt").val()))
    {
        $("#option_select_cnt").val(1);
    }
    var sumprice = 0;
    sumprice = String(parseInt($("#option_select_expricesum").val())*$("#option_select_cnt").val());
    if(sumprice == "NaN") sumprice = "0";
    $("#option_select_expricesum_display").html(fnCommaNum(sumprice));
    $("#option_select_count_display").html($("#option_select_cnt").val());
    
    if(t_delivery ==0 && by_delivery > sumprice){
        $("#option_free_price_display").html("+배송비 "+delivery_price*$("#option_select_cnt").val()+"<br><span style='color:#999;margin-top: 5px'>("+fnCommaNum(by_delivery)+"원 이상 결제시 무료 배송)</span>");
    }

    if((t_delivery ==0 && by_delivery <= sumprice)   || t_delivery ==2)
    {
        $("#option_free_price_display").html("<em class='sky'>무료배송</em>");
    }
    if(t_delivery ==1)
    {
        var del_price = getFindPrice(delivery_method,weight * $("#option_select_cnt").val());
        if(delivery_method =="sea")
            $("#delivery_method").find(":selected").text("해운특송 (5일 ~ 7일) +"+fnCommaNum(del_price)+"원");
        if(delivery_method =="sky")
            $("#delivery_method").find(":selected").text("항공특송 (3일 ~ 5일) +"+fnCommaNum(del_price)+"원");
        $("#option_free_price_display").html("+배송비 "+fnCommaNum(del_price));
    }
}

function visibleForm(){
    if($("#deliveryForm").hasClass("d-none"))
    {
        

        $("#deliveryForm").removeClass("d-none");
        $(".buy-btn").removeClass("d-none");
        $(".origin-section").addClass("d-none");
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#deliveryForm").offset().top-200
        }, 500);   
    }
}

$(document).ready(function(){
    var pcode = $("input[name='pcode']").val();
    getRelatedProduct(pcode,"related_top");
    getReivews('#ID_eval_list','eval','');
    getReivews('#ID_qna_list','qna','');
    getRelatedProduct(pcode,"related_bottom");
    $("#deliverForm").validate({
        rules:{
            ADRS_KR: {
                required: true,
            },
            ADRS_EN: {
                required: true
            },
            RRN_NO: {
                required: true,
            },

            ZIP: {
                required: true,
            },
            ADDR_1: {
                required: true
            },
            MOB_NO1: {
                required: true,
            },
            MOB_NO2: {
                required: true,
            },
            MOB_NO3: {
                required: true,
            },
        },
        messages: {
            ADRS_KR :  "이 필드는 반드시 입력해야 합니다.",
            ADRS_EN :  "이 필드는 반드시 입력해야 합니다.",
            RRN_NO :  "이 필드는 반드시 입력해야 합니다.",
            ZIP: "이 필드는 반드시 입력해야 합니다.",
            ADDR_1: "이 필드는 반드시 입력해야 합니다.",
            MOB_NO1: "이 필드는 반드시 입력해야 합니다.",
            MOB_NO2: "이 필드는 반드시 입력해야 합니다.",
            MOB_NO3: "이 필드는 반드시 입력해야 합니다."
        },
        submitHandler: function(form) { //通过之后回调

            if($("#option_select_cnt").val() >=2){
                alert("합 배송시 포장,부피 등의  추가로 인한 비용 발생이 되실수 있습니다. \n상품 출고전 결제 페이지 에서 확인 하시고 결제진행을  해주시기바랍니다.");
            }
        //进行ajax传值
            event.preventDefault();
            var con =1;
            $("#delivery_type").val("purchase");

            var form = $('#deliverForm')[0];
            var data = new FormData(form);
            $.ajax({
                type: "POST",
                url: "/update_bracket",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                dataType:"json",
                success: function (data) {
                    var add_msg= "";
                    if(data.status =="login_error"){
                        login_alert();
                        return;
                    }
                    if(data.status =="error"){
                        alert(data.message);
                        return;
                    }
                    if(data.status =="success_purchase"){
                        if(data.happened_adds)
                        {
                            add_msg = "\n도서산관추가배송비가 추가되였습니다.결제페이지에서 확인하세요";
                        }
                        socket.emit("chat message",1,data.post_id,userId,"shop",userName);
                        alert(data.message + add_msg);
                        location.href = "/mypay";
                        return;
                    }

                },
                error: function (e) {
                    alert("오류발생");
                    location.reload();
                }
            })
            return false;
        },
        invalidHandler: function(form, validator) {return false;}
    });

    $('.nav-tabs a').on('shown.bs.tab', function(event){
        var position = height-220;
        $('html, body').animate({
            scrollTop: position
        },100);
    });
});

function app_submit(pcode,type,obj){
    var con = 1;
    $.each($(".option-value"),function(index,value){
        if($(this).val() ==""){
            alert("옵션을 선택하세요");
            $(this).focus();
            con =0;
            return false;
        }
    });
    if(con ==0) 
    {
        return;
    }
    $("#delivery_type").val("basket");
    var formData = new FormData(document.getElementById("deliverForm"));
    $.ajax({
        url: "/update_bracket",
        type: "POST",
        dataType: "json",
        data: formData,
        async: false,
        processData: false,
        contentType: false,
        success: function(data){
            if(data.status =="login_error"){
                login_alert();
                return;
            }
            if(data.status =="error"){
                alert(data.message);
                return;
            }
            if(data.status =="success"){
                alert(data.message);
                return;
            }
        }
    }).fail(function(jq){
        alert("예상치 못한 오류가 발생하였습니다.잠시후에 오세요");
        location.reload();
    })
}

function getRelatedProduct(pcode,element){
    var templateScriptTwo = $('#related-lists').html();
    var templateTwo = Handlebars.compile(templateScriptTwo);
    var obj  = $("#"+element);
    $.ajax({
        url: "/relatedProudct",
        type: "POST",
        dataType: "json",
        data: {pcode : pcode },
        beforeSend:function(){
            $('.loading_products').removeClass("d-none");
        },
        success: function(data){
            if(data.length > 0)
            {   
                $.each(data,function(index,value){
                    value.product_image = baseURL_HOME + "upload/shoppingmal/" + value.id  +"/" + value.image;
                    obj.append(templateTwo(value)); 
                });
                $(".ratings").starRating({
                    readOnly:true,
                    disableAfterRate: false,
                    starShape: 'rounded',
                    starSize: 15,
                    emptyColor: 'lightgray',
                    hoverColor: 'salmon',
                    activeColor: 'crimson',
                    minRating: 0
                });

                obj.slick({
                  speed: 300,
                  slidesToShow: 5,
                  slidesToScroll: 1,
                  arrows: false, 
                  autoplay: true,
                  autoplaySpeed: 3000,
                  prevArrow : '<button class="slick-prev right-ab-ha" aria-label="Previous" type="button"></button>',
                  nextArrow : '<button class="slick-next left-ab-ha" aria-label="Next" type="button"></button>',
                  responsive: [
                    {
                      breakpoint: 1024,
                      settings: {
                        slidesToShow: 5,
                        slidesToScroll: 3,
                        infinite: true,
                      }
                    },
                    {
                      breakpoint: 600,
                      settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1
                      }
                    },
                    {
                      breakpoint: 480,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                      }
                    }
                  ]
                });
                // $("img.lazy").lazyload();
            }
            else
                $(".withnames").text("");
            $('.loading_products').addClass("d-none");
            height = $("#moved_item").offset().top;
        }
    }).fail(function(xhr){
        $('.loading_products').addClass("d-none");
        height = $("#moved_item").offset().top;
    });
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
        }).fail(function(jq) {
            $('.loading_products').addClass("d-none");
            returned_check[type] =1;
            return;
        })
    } 
}


function eval_show(id) {
    $(".eval_box_area").removeClass("open");

    // 열려있는걸 다시 클릭했을때는 닫기만 처리한다.
    if(old_eval_id == id) {this.old_eval_id = 0;return;}

    $("#"+id).addClass("open");

    old_eval_id = id;
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

function eval_write_form_view() {
    $("#eval_contents_area .form_area").toggle();
}

function qna_write_form_view() {
    $("#qna_contents_area .form_area").toggle();
}