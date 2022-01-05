var lang_date = {
  title: '날짜선택',
  cancel: '취소',
  confirm: '확인',
  year: '년',
  month: '월',
  day: '일'
};
var socket = io.connect('http://taodalin.com:8081');
// var socket = null;
function login_alert() {
    alert("로그인 후 이용할수 있습니다.");
    window.location.href="/login?redirect="+ConvertStringToHex(location.href);
}

Handlebars.registerHelper('if_eq', function(a, opts) {
    if (a <= 0) {
        return opts.fn(this);
    } else {
        return opts.inverse(this);
    }
});

Handlebars.registerHelper('if_eq_both', function(a,b, opts) {
    if (a <= 0 || b<=0) {
        return opts.fn(this);
    } else {
        return opts.inverse(this);
    }
});

Handlebars.registerHelper('if_type_request', function(a, opts) {
    if (a =="eval") {
        return opts.fn(this);
    } else {
        return opts.inverse(this);
    }
});

Handlebars.registerHelper('if_first_last', function(a, opts) {
    if (a % 5 == 0) {
        return "m-l-0";
    } 

    if(a % 5 ==4){
        return "m-r-0";
    }

    return ""
});

Handlebars.registerHelper('accurate', function(a, opts) {
    return fnCommaNum(a);
});


Handlebars.registerHelper('multiple', function(a,b,c, opts) {
  if(c==1)
    return a*b;
  else
    return fnCommaNum(a*b);
});

Handlebars.registerHelper("check_out",function(a,opts){

  var class1 = "",class2 = "";
  var temp1 = 0,temp2 = 0;
  if(a.checked_add == true){
    var s = JSON.stringify(a.add);
    var addes = JSON.parse(s);
    if(addes.length > 0){
      addes.forEach(element =>{
        var converted = JSON.parse(element);
        if(converted.puse > 0)
          temp1 = 1;
        if(converted.pcount > 0)
          temp2 = 2;
      });
    }
  }
  else{
    if(a.puse > 0)
      temp1 = 1;
    if(a.pcount > 0)
      temp2 = 1;
  }

  if(temp1 == 0)
    class1 = "e_disabled ";
  if(temp2 == 0)
    class2 = "sold_out ";

  return class1 + class2;
})

Handlebars.registerHelper('disabled_o', function(a, opts) {

  var class1 = "",class2 = "";
  var temp1 = 0,temp2 = 0;
  if(a.checked_add == true){
    var s = JSON.stringify(a.add);
    var addes = JSON.parse(s);
    if(addes.length > 0){
      addes.forEach(element =>{
        var converted = JSON.parse(element);
        if(converted.puse > 0)
          temp1 = 1;
        if(converted.pcount > 0)
          temp2 = 2;
      });
    }
  }
  else{
    if(a.puse > 0)
      temp1 = 1;
    if(a.pcount > 0)
      temp2 = 1;
  }

  if(temp1 == 0)
    class1 = "e_disabled ";
  if(temp2 == 0)
    class2 = "sold_out ";

  var re  = class1 + class2;

    var s1 = '<span class="font-weight-bold text-danger pt-10">SOLD OUT</span>';
    var s2 = '<span class="font-weight-bold text-danger pt-10 m-l-0">판매종료</span>';

    if(re.includes("e_disabled") && re.includes("sold_out")){
      return s1+s2;
    }

    if(re.includes("e_disabled")){
      return s2;
    }

    if(re.includes("sold_out")){
      return s1;
    }

    return "";

});


Handlebars.registerHelper('add_options' , function(a,opts) {
  var result = "";
  s = JSON.stringify(a);
  var addes = JSON.parse(s);
  if(addes.length > 0){
    addes.forEach(element =>{
      var class1 = "",class2="",count_disabled = "" , sold_out = "" , stock_used = "";
      var converted = JSON.parse(element);
      var options  = converted.size.trim() != "" ? converted.size.split(",").join("<br>") : "";
      if(converted.puse == 0)
      {
        class1 = "e_disabled";
        count_disabled = "disabled";
        stock_used = '<span class="font-weight-bold text-danger pt-10 m-l-0">판매종료</span>';
      }
      if(converted.pcount <= 0)
      {
        class2= "sold_out";
        count_disabled = "disabled";
        sold_out = '<span class="font-weight-bold text-danger pt-10">SOLD OUT</span>';

      }
      var temp = '\
                <li id="pid_'+converted.id+'" class="'+class1+' '+class2+'">\
                  <input type="hidden" class="all_product_price" value="'+converted.price * converted.count+'">\
                  <input type="hidden" class="this_delivery" value="'+converted.delivery_price+'">\
                  <input type="hidden" class="unit" value="'+converted.price+'">\
                  <input type="hidden" class="weight" value="'+converted.weight+'">\
                  <input type="hidden" class="type" value="'+converted.p_shoppingpay_use+'">\
                  <div class="opt_wrap">\
                    <label class="check_mid red">\
                    <input type="checkbox" name="basket_'+converted.delivery_method+'[]"  class="optCheckBox basket_'+converted.delivery_method+' chkORD_SEQ'+converted.productId+'" \
                    name="basket_'+converted.delivery_method+'[]" value="'+converted.id+'" \
                    onchange="updateSum(\''+converted.delivery_method+'\','+converted.id+','+converted.productId+')" '+count_disabled+' id="bats'+converted.id+'">\
                    <i class="ico"></i>\
                    </label>\
                    <div class="opt_name">\
                      '+options+'\
                    </div>\
                  </div>\
                  <div class="qty_wrap">\
                    <span class="quantity circle">\
                    <button class="btn_qnt_minus" onclick="plusValue('+converted.id+',\'minus\')" type="button"></button>\
                    <input class="inp_qnt pg_count" type="num"  value="'+converted.count+'" \
                    onchange="changeShopCount('+converted.id+',$(this).val(),'+converted.pcount+',\''+converted.delivery_method+'\','+converted.productId+')" '+count_disabled+' id="pg'+converted.id+'">\
                    <button class="btn_qnt_plus" onclick="plusValue('+converted.id+',\'plus\')" type="button"></button>\
                    </span>\
                    <div class="option_price">\
                       <span class="price pg_price">'+fnCommaNum(converted.price * converted.count)+'</span><span class="won">원</span>\
                    </div>\
                    <button class="btn_del_cart" type="button" \
                    onclick="deleteChecked('+converted.id+',\''+converted.delivery_method+'\','+converted.productId+')">삭제</button>\
                 </div>\
                 <div>\
                    '+sold_out+stock_used+'\
                  </div>\
              </li>';
    result +=temp;
    })
  }
  return result;
})


Handlebars.registerHelper('length_of_array', function(a, opts) {
    if (a.length > 0) {
        return opts.fn(this);
    } else {
        return opts.inverse(this);
    }
});


Handlebars.registerHelper('methods', function(a,opts) {
  var free_mode = "",dels = "";
  if(a.p_shoppingpay_use ==0 || a.p_shoppingpay_use==2)
    dels = "해운특송";
  else{
    if(a.deliverybysea ==1)
    {
      dels = "해운특송";
      if(a.deliverybysky ==1)
        dels = dels + "/";
    }
    if(a.deliverybysky==1)
      dels  = dels + "항공특송";
  }

  if(a.p_shoppingpay_use ==2)
    free_mode = "무료배송/";

  return free_mode + dels;

});