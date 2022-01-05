<?php 
$class = array();
$class[0]="";
$class[1]="";
$class[2]="";
$last_item = $selected_name;
if(!empty($breads_name)){
	$class[sizeof($breads_name)-1] = "active";
}

else{
	if($this->input->get("txt-category") =="best"){
		$last_item = "베스트상품";
	}
	if($this->input->get("txt-category") =="rec"){
		$last_item = "추천상품";
	}
	if($this->input->get("txt-category") =="new"){
		$last_item = "신상품";
	}
	if($this->input->get("txt-category") =="low"){
		$last_item = "싸다";
	}
	if($this->input->get("txt-category") =="wow"){
		$last_item = "멋지다";
	}

}

?>
<link href="<?php echo site_url('/assets/plugins/ratings/star-rating-svg.css')?>" rel="stylesheet">
<link href="<?php echo site_url('/template/css/shop.css'); ?>?<?=time()?>" rel="stylesheet">
<script src="<?php echo site_url('/assets/plugins/ratings/jquery.star-rating-svg.js')?>"></script>
<script src="<?php echo site_url('/template/js/shop.js')?>?<?=time()?>"></script>
<div class="container">
	<div class="row">
		<div id="subRight" class="col-md-12">
			<h1 class="d-none">쇼핑몰</h1>
			<div>
			    <ol class="breadcrumb breadcrumb-arrow">
					<?php if(!empty($breads_name)): ?>
					<?php foreach($breads_name as $key=>$value):?>
					<li class="<?=$class[$key]?>">
					<?php if($key ==sizeof($breads_name)-1): ?><span><?=$value?></span><?php endif ;?>
					<?php if($key !=sizeof($breads_name)-1): ?><a href="/shopping?txt-category=<?=$breads[$key]?>"><?=$value?></a><?php endif ;?>
					</li>						
					<?php endforeach;?>
					<?php endif; ?>
					<?php if(empty($breads_name)): ?>
						<li class="active"><span  class="font-weight-bold"><?=$last_item?></span></li>
					<?php endif; ?>
				</ol>
			</div>
			<div class="con">
				<div class="t_board">
					<div class="se_item_list">
					    <div class="item_list item_box_5">
					      	<div class="layout_fix clearfix">
					        	<ul class="ul" id="content_products">
					        		
					        	</ul>
					        </div>
					    </div>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>

<script src="/template/js/jquery.infinitescroll.js"></script>
<script id="shopping-lists" type="text/x-handlebars-template">
    {{#each  product_list}}
    <li class="li">
      <div class="item_box noslide addon_quick_view {{if_first_last @index}}">
        {{#if_eq count}}<span class="soldout"><img src="/assets/images/ic_soldout.png" alt="품절"></span>{{/if_eq}}
          <div class="item_thumb">
            <a href="/view/shop_products/{{rid}}" class="quick_view" title="{{name}}">
            	<img class="lazy" data-original = "/upload/shoppingmal/{{id}}/{{image}}" height="220" title="{{name}}">
            </a>
          </div>   
          <div class="details">
            <div class="parts_pt ellipsis two-lines">
              <p>{{name}}</p>
            </div>
            <div><span class="font-weight-bold">{{accurate singo}}</span>원</div>
            <div class="my-rating" data-rating="{{review}}"></div>
            <hr class="mt-5 mb-5">
            <div><span class="grey1">{{methods this}}</span></div>
          </div>
          {{#length_of_array icons}}
          <span class="upper_icon">
          	{{#each icons}}
          	<img src="/upload/Products/icon/{{this}}">
          	{{/each}}
          </span>
          {{/length_of_array}}
      </div>
    </li>
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
		$('#content_products').infiniteScrollHelper({
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
