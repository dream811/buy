<script>
	

	window.alert = function(al, $){
    return function(msg) {
        al(msg);
        $(window).trigger("okbuttonclicked");
    };
}(window.alert, window.jQuery);

$(window).on("okbuttonclicked", function() {
	<?php if($step!=""): ?>
		window.location.href = baseURL+"dashboard?step="+<?=$step?>;
	<?php endif; ?>
	<?php if($step==""): ?>
		window.location.href = baseURL+"dashboard";
	<?php endif; ?>
    
});

window.alert("배송비 없는 주문이 포함되여 있습니다.\n 상태변경이 불가능합니다.");

</script>