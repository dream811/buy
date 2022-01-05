$(document).ready(function(){
	getReivews('#ID_'+type+'_list',type,'');
	$('body').delegate('.ajax_wish','click',function(e){ 
		e.preventDefault();
		var mode = 'add', code = $(this).data('code'), $this = $(this), $batch = $('.ajax_wish_'+code);
		if($(this).hasClass('if_wish')) { mode = 'delete'; }
		$.ajax({
			data: {'mode':mode,'code':code},
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
					if($this.hasClass('quick_wish')) {
						$this.removeClass('wish_hit').removeClass('if_wish'); $this.attr('title','찜하기');
						$batch.removeClass('wish_hit').removeClass('if_wish'); $batch.attr('title','찜하기');
					}
					else {
						$this.removeClass('if_wish'); $this.attr('title','찜하기');
						$batch.removeClass('if_wish'); $batch.attr('title','찜하기');
					}
					return;
				}
				if(data.status == "3"){
					alert(data.result);
					if($this.hasClass('quick_wish')) {
						$this.addClass('wish_hit').addClass('if_wish'); $this.attr('title','찜해제');
						$batch.addClass('wish_hit').addClass('if_wish'); $batch.attr('title','찜해제'); 
					}
					else {
						$this.addClass('if_wish'); $this.attr('title','찜해제');
						$batch.addClass('if_wish'); $batch.attr('title','찜해제'); 
					} 
					return;
				}
				else { alert("NONE"); }
			},
			error:function(request,status,error){
				alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
		})
	});
})