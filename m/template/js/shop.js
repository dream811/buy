var options = {

    url: "/getProductsWithJson",

     listLocation: "product_list",

    getValue: function(element) {
        return element.name;
    },

    template: {
        type: "links",
        fields: {
            link: "website_link"
        }
    },


    list: {
        maxNumberOfElements: 10,
        match: {
            enabled: true
        },
        sort: {
            enabled: true
        }
    },
    ajaxSettings: {
        dataType: "json",
        method: "POST",
        data: {
          name: $("#txt-search").val(),
          category:""        }
      },

      preparePostData: function(data) {

        return data;
    },
    requestDelay: 400


};
function getFindPrice(dtype="sea",weight){
    var rates = 1;
    var temp = "";
    var price = 0;
    var init_weight = 0;
    if(dtype =="sea"){
        rates = sea;
        temp = weights_sea;
    }
    if(dtype =="sky"){
        rates = sky;
        temp = weights_sky;
    }

    if(temp.length ==0)
    {
        price = 0;
        return price;
    }

    init_weight = temp[0].weight;
    price = temp[0].price;
    $.each(temp,function(index,value){

        if(weight == value.weight || weight < value.weight){
            price = value.price;
            return false;
        }

    });
    return price;
}

function loadProducts(type,limit1=20,limit2="",category,name,size=20,callback){

    var lists = new Array();
    var templateScriptTwo = $('#shopping-lists').html();
    jQuery.ajax({
    type : "POST",
    dataType : "json",
    url : baseURL+"getProductsWithJson",
    data : { type : type,"limit1":limit1,"limit2":limit2,"category":category,"name":name },
    beforeSend: function() {
        disableScroll();
        $('.loading_products').removeClass("d-none");
        product_loaded =0;
    }
    }).done(function(data){
        if(data.product_list.length ==0)
            $('.product_list_content').html("자료가 비였습니다.");
        else{
            var templateTwo = Handlebars.compile(templateScriptTwo);
            $('.product_list_content').append(templateTwo(data));
        }
        $("img.lazy").lazyload();
        $(".my-rating").starRating({
            readOnly:true,
            starShape: 'rounded',
            starSize: 20,
            emptyColor: 'lightgray',
            hoverColor: 'salmon',
            activeColor: 'crimson',
            minRating: 0
        });

    }).always(function(a, textStatus, b) {
        
        enableScroll();
        product_loaded = 1;
        $('.loading_products').addClass("d-none");
        init1_limit = init1_limit + size;
        init2_limit = init2_limit + size;
        if (typeof callback == "function") 
            callback(); 
    });
}

$(document).ready(function(){
    var height_shop_header = $("#shopping_top").height() + 83;
    $("body").css("margin-top",height_shop_header + "px");
});


function disableScroll() { 
    document.body.classList.add("stop-scrolling"); 
} 

function enableScroll() { 
    document.body.classList.remove("stop-scrolling"); 
} 

$(document).ready(function(){
    $("#txt-search").easyAutocomplete(options);

    $(".more-search").click(function(){
        if($(".search-section").hasClass("d-none"))
        {
            $(".search-section").removeClass("d-none");
            $("html, body").animate({ scrollTop: 0 }, 100);

        }
        else
            $(".search-section").addClass("d-none");
    })
})