<link href="<?php echo site_url('/template/css/shop.css'); ?>?<?=time()?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/template/css/wish.css?<?=time()?>">
<div class="container my-1">
	<div class="row">
		<div id="subRight" class="col-md-12">
			<div class="padgeName">
	            <h2>찜한상품</h2>
	        </div>
	        <div class="text-right mb-10">
				<a href="#none" onclick="all_check();return false;" class="btn btn-default btn-sm">전체선택</a>
				<a href="#none" onclick="all_uncheck();return false;" class="btn btn-default btn-sm">선택해제</a>
				<a href="#none" onclick="select_delete();return false;" class="btn btn-secondary btn-sm">선택삭제</a>
	        </div>
	        <div class="cm_mypage_wish">
	        	<ul>
	        	</ul>
	        </div>
	        <div class="text-center my-4">
	   			<a id="more_wish" class="btn btn-default " onclick="getWish()">더보기</a>
	   		</div>
		</div>
	 </div>
</div>

<script src="<?php echo site_url('/template/js/shop.js')?>?<?=time()?>"></script>
<script  id="wish-lists" type="text/x-handlebars-template">
	<li id=wish_{{id}}>
		<div class="wish_box">
		    <dl>
		        <dt>
		            <a href="/view/shop_products/{{pcode}}" class="thumb">
		            	<img src="/upload/shoppingmal/{{pid}}/{{image}}" alt="test1" title="{{name}}" height="255"/></a>
		        </dt>
		        <dd>
		            <a href="/view/shop_products/{{pcode}}" class="title">{{name}}</a>
		        </dd>
		        <dd>
		            <span class="price">{{accurate singo}}원</span>
		            <label><input type="checkbox" name="unwished[]" class="_chk_class" value="{{id}}" /></label>
		            <span class="button_pack"><a href="#none" class="btn btn-sm btn-default" onclick="deleteWish({{id}})">찜삭제</a></span>
		        </dd>
		    </dl>
		</div>
	</li>
</script>
<script>
	var all  = <?=$records_count?>;
</script>
<script type="text/javascript" src="/template/js/wish.js?<?=time()?>"></script>

