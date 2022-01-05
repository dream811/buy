<?php 
$data['category'] = $category;
$data['tt'] = 3;
$data['t'] = 1;?>
<link href="<?php echo site_url('/template/css/shop.css?'.time());?>" rel="stylesheet">
<link href="<?php echo site_url('/template/css/wish.css?'.time());?>" rel="stylesheet">
<?php $this->load->view("shop_header",$data); ?>

<div class="container">
	<div id="subRight" style="padding-top: 10px">
		<div class="row border-b pb-10">
			<div class="col-xs-12">
				<a href="#none" onclick="all_check();return false;" class="btn btn-default btn-sm">전체선택</a>
				<a href="#none" onclick="all_uncheck();return false;" class="btn btn-default btn-sm">선택해제</a>
				<a href="#none" onclick="select_delete();return false;" class="btn btn-secondary btn-sm">선택삭제</a>
			</div>
		</div>
		<div class="cm_mypage_wish pt-10">
        	<ul>
        	</ul>
        </div>
        <div class="text-center my-4">
   			<a id="more_wish" class="btn btn-default " onclick="getWish()">더보기</a>
   		</div>
	</div>
</div>
<script  id="wish-lists" type="text/x-handlebars-template">
	<li id=wish_{{id}}>
		<div class="wish_box">
		    <dl>
		        <dt>
		        	<div style="position:relative">
		        		<label class="check_mid red">
		        			<input type="checkbox" name="unwished[]" class="_chk_class" value="{{id}}" />
		        			<i class="ico"></i>
		        		</label>
		        	</div>
		            <a href="/view/shop_products/{{pcode}}" class="thumb">
		            	<img src="{{pc_url}}upload/shoppingmal/{{pid}}/{{image}}" alt="{{name}}" title="{{name}}" /></a>
		        </dt>
		        <dd class="mt-10 p-left-10 p-right-10 pb-10" >
		            <a href="/view/shop_products/{{pcode}}" class="title">{{name}}</a>
		        </dd>
		        <dd class="p-left-10 p-right-10">
		            <span class="price">{{accurate singo}}원</span>
		            <span class="button_pack">
		            	<a href="#none" class="text-danger font-weight-bold" onclick="deleteWish({{id}})">찜삭제</a>
		            </span>
		        </dd>
		    </dl>
		</div>
	</li>
</script>
<script>
	var all  = <?=$records_count?>;
</script>
<script type="text/javascript" src="/template/js/wish.js?<?=time()?>"></script>
<script src="<?php echo site_url('/template/js/shop.js')?>?<?=time()?>"></script>