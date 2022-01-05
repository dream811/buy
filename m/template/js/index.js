function loadMore(id,data={},rates=1,ths){
	jQuery.ajax({
		type : "POST",
		dataType : "json",
		url : hitURL,
		 beforeSend: function () {
	        // 禁用按钮防止重复提交
	        ths.button("loading");
	    },
		data : data
		}).done(function(data){
			ths.button("reset");
			if(data.length > 0 )
				data.forEach((element) => 
				{
					
					var free_mode = "",dels = "";
				  	if(element.p_shoppingpay_use ==0 || element.p_shoppingpay_use==2)
				    	dels = "해운특송";
				 	else{
				    	if(element.deliverybysea ==1)
				    {
				      dels = "해운특송";
				      if(element.deliverybysky ==1)
				        dels = dels + "/";
				    }
				    if(element.deliverybysky==1)
					    dels  = dels + "항공특송";
					 }

				  	if(element.p_shoppingpay_use ==2)
				    	free_mode = "무료배송/";
					$(".product_list_content").append('<a href="/view/shop_products/'+element.rid+'" class="productlist">\
						<div class="product_list p-5">\
															<div class="product_img">\
																<img src="'+home+"upload/shoppingmal/"+element.id+"/"+element.i1+'">\
															</div>\
															<div class="product_content mid p-left-10">\
																<div class="details">\
																	<p>'+element.name+'</p>\
																	<div>\
																		<span class="text-gray"><del>'+number_format(element.orgprice)+'원</del></span>\
																		<span class=\'font-weight-bold ml-15\'>'+number_format(element.singo)+'원</span>\
																	</div>\
																	<div class="my-rating" data-rating="'+element.review+'"></div>\
																	<hr class="mt-5 mb-5">\
																	<div class="p-left-5 pb-5"><span class="text-green fs-12 font-weight-bold">'+free_mode + dels+'</span></div>\
																</div>\
															</div>\
														</div>\
						</a>');

				});
		$(".my-rating").starRating({
		    readOnly:true,
		    starShape: 'rounded',
		    starSize: 20,
		    emptyColor: 'lightgray',
		    hoverColor: 'salmon',
		    activeColor: 'crimson',
		    minRating: 0
		});	
	})
}