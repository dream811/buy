<?php $site = $pageTitle;$data["tt"]=1; ?>
<?php $data["cates"] = $cates; ?>
<link href="<?=base_url_home()?>assets/plugins/ratings/star-rating-svg.css" rel="stylesheet">
<link href="<?php echo site_url('/template/css/shop.css?'.time());?>" rel="stylesheet">
<?php $this->load->view("shop_header",$data); ?>
<div class="container">
	<div id="subRight">
		<div class="row shoplist">
			<div class="product_list_content">
		    </div>
		</div>
	</div>
</div>

<script src="<?=base_url_home()?>assets/plugins/ratings/jquery.star-rating-svg.js"></script>
<script src="/template/js/jquery.infinitescroll.js?123"></script>

<script id="shopping-lists" type="text/x-handlebars-template">
    {{#each  product_list}}
    <a href="/view/shop_products/{{rid}}" class="bg-white mb-5 d-block">
		<div class="product_list p-5">
			<div class="product_img">
				<img src="{{pc_url}}upload/shoppingmal/{{id}}/{{image}}">
			</div>
			<div class="product_content mid p-left-10 mt-10">
				<div class="details">
					<p>{{name}}</p>
					<div>
						<span class="text-gray"><del>{{accurate orgprice}}원</del></span>
						<span class="ml-15 price">{{accurate singo}}원</span>
					</div>
					<div class="my-rating" data-rating="{{review}}">
					</div>
				</div>
			</div>
			<hr class="mt-5 mb-5">
			<div class="p-left-10 pb-5"><span class="text-green fs-12 font-weight-bold">{{methods this}}</span></div>
		</div>
	</a>				
    {{/each}}
</script>

<script>
	$(window).on('beforeunload', function(){
	  $(window).scrollTop(0);
	});
	init1_limit = <?=!isset($limit1) ? 20:$limit1?>;
	init2_limit = <?=!isset($limit2) ? 0:$limit2?>;
	var category_name = "<?=$this->input->get("txt-category")?>";
	var content_name = "<?=$this->input->get("txt-search")?>";
	var all = <?=$records_count?>;
	var page_num = Math.ceil(all / 20);
	$(document).ready(function(){
		$('.product_list_content').infiniteScrollHelper({
			bottomBuffer : 300,
			loadMore: function(page, done) {
				if(page > page_num) return ;
			  	loadProducts("list",init1_limit,init2_limit,category_name,content_name,20,function(){
			  		done();
			  	});
			}
		});

	});
</script>

<script src="<?php echo site_url('/template/js/shop.js')?>?<?=time()?>"></script>