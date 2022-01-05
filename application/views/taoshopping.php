<?php 
$list_pro = array(	"rec_products"=> array("rec","추천상품"),
					"new_products"=> array("new","신상품"),
					"cheap_products"=> array("low","싸다"),
					"wow_products"=> array("wow","멋지다")	);
?>
<link href="<?php echo site_url('/assets/plugins/ratings/star-rating-svg.css')?>" rel="stylesheet">
<link href="<?php echo site_url('/template/css/shop.css'); ?>?<?=time()?>" rel="stylesheet">
<link href="<?php echo site_url('/template/css/tao.css'); ?>?<?=time()?>" rel="stylesheet">
<link href="<?php echo site_url('/assets/plugins/swiper/swiper.min.css'); ?>" rel="stylesheet">
<script src="<?php echo site_url('/template/js/shop.js')?>?<?=time()?>"></script>
<script src="<?php echo site_url('/assets/plugins/swiper/swiper.min.js')?>"></script>
<script src="<?php echo site_url('/template/js/main_shop.js')?>?<?=time()?>"></script>
<script src="<?php echo site_url('/assets/plugins/ratings/jquery.star-rating-svg.js')?>"></script>
<div class="container-fluid">
	<div class="c-slider swiper-container-banner swiper-container">
	  	<div class="swiper-wrapper">
		<?php $banner_info = getBanners(23,0); ?>
		<?php foreach ($banner_info as $key => $value): ?>
	    <div class="swiper-slide">
	    	<a href="<?=$value->link?>" target="<?=$value->target==1 ? "_self" : "_blank"?>" title="<?=$value->title?>">
	    		<img src="<?=base_url()?>upload/homepage/banner/<?=$value->image?>" alt="<?=$value->description?>"/>
	    	</a>
	    </div>
	    <? endforeach; ?>
	  	</div>
	    <div class="swiper-button-next"></div>
	    <div class="swiper-button-prev"></div>
	</div>
	<div class="container">
		<div class="favorite_lists">
			<div class="best_p my-15">
				<div>
					<a href="<?=base_url()?>shopping?txt-category=best" target="_blank" title="베스트 상품"><h2 class="fav_h">베스트 상품</h2></a>
					<div class="best-line lines"></div>
				</div>
				<div class="slickeditem">
					<?php $best_products_s = array_chunk($best_products, 4); ?>
					<?php if(!empty($best_products_s)): ?>
					<?php foreach($best_products_s as $v_best): ?>
					<?php 
					$v_best = array_chunk($v_best, 2);
					if(!empty($v_best)):?>
					<div>
					<?php foreach($v_best as $vv_best): ?>
					<table class="table b-none">
						<?php 
						if(!empty($vv_best)): ?>
						<tr>	
						<?php foreach($vv_best as $key => $value):?>
						<td class="b-t-0 <?=$key==0 ? "b-r-3 text-left":"text-right"?>" 
							>
							<div>
								<?php if($key ==0): ?>
								<div class="best_part0">
					              	<div class="best_title">
						                <p><?=$value->best_big?></p>
					              	</div>
					              	<div class="best_small_title">
						                <p><?=$value->best_small?></p>
					              	</div>
					            </div>	
								<?php endif; ?>
								<?php if($key ==1): ?>
								<div class="best_part1">
					              	<div class="best_title">
						                <p><?=$value->best_big?></p>
					             	</div>
					             	<div class="best_small_title">
						                <p><?=$value->best_small?></p>
					              	</div>
					            </div>	
								<?php endif; ?>
								<div class="item_thumb">
									<a href="/view/shop_products/<?=$value->rid?>" title="<?=$value->name?>">
						          		<img src="/upload/shoppingmal/<?=$value->id?>/<?=$value->image?>" width="360" height="360" 
						          		alt="<?=$value->name?>">
						          	</a>	
					          	</div>
							</div>
						</td>
						<?php endforeach;?>
						</tr>
						<?php endif;?>
					</table>
					<div class="clearfix"></div>
					<?php endforeach; ?>
					</div>
					<?php endif; ?>
					<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
			<?php foreach ($list_pro as $key=>$value): ?>
				<?php $spli_arr= array_chunk($$key, 10); ?>
				<div class="rec_p">
					<div>
						<a href="<?=base_url()?>shopping?txt-category=<?=$value[0]?>" target="_blank" title="<?=$value[1]?>"><h2 class="fav_h"><?=$value[1]?></h2></a>
						<div class="rec-line lines"></div>
					</div>
					<div class="se_item_list my-10">
						<div class="item_list item_box_5">
							<div class="layout_fix">
								<?php foreach($spli_arr as $ch_arr): ?>
								<ul class="ul s_ss my-10">
								<?php if(!empty($ch_arr)): ?>
								<?php foreach($ch_arr as $valued_item):?>
								<?php $del_m = "";$del_free=""; ?>
								<?php if($valued_item->p_shoppingpay_use ==0 || $valued_item->p_shoppingpay_use=="2"): ?>
								<?php $del_m = "해운특송"; ?>
								<?php endif; ?>
								<?php if($valued_item->p_shoppingpay_use ==1 ): ?>
								<?php
								if($valued_item->deliverybysea ==1)
								{
									$del_m="해운특송";
									if($valued_item->deliverybysky ==1)
										$del_m .="/";
								}
								if($valued_item->deliverybysky ==1)
									$del_m .="항공특송";
								?>
								<?php if($valued_item->p_shoppingpay_use=="2"): ?>
								<?php $del_free = "무료배송/"; ?>
								<?php endif; ?>
								<?php endif; ?>
									<li class="in_li">
										<div class="item_box noslide addon_quick_view m-l-0">
								          	<div class="item_thumb">
									            <a href="/view/shop_products/<?=$valued_item->rid?>" class="quick_view" title="<?=$valued_item->name?>">
									            	<img  class="lazy" src="/upload/shoppingmal/<?=$valued_item->id?>/<?=$valued_item->image?>" 
									            	height="220" alt="<?=$valued_item->name?>">
									            </a>
								          	</div>   
								          	<div class="details">
									            <div class="parts_pt ellipsis two-lines">
									              <p><?=$valued_item->name?></p>
									            </div>
									            <div><span class="font-weight-bold"><?=number_format($valued_item->singo)?></span>원</div>
									            <div class="my-rating" data-rating="<?=$valued_item->review?>"></div>
									            <hr class="mt-5 mb-5">
									            <div><span class="grey1 fs-12"><?=$del_free.$del_m?></span></div>
								          	</div>
								          	<span class="upper_icon">
									          	<?php $p_icon = explode(",", $valued_item->p_icon); ?>
									          	<?php if(sizeof($p_icon) > 0):?>
									          	<?php foreach($p_icon as $i_value): ?>
									          		<?php if(!empty($icons[$i_value])):?>
									          			<img src="/upload/Products/icon/<?=$icons[$i_value]?>">
									          		<?php endif;?>
									          	<?php endforeach; ?>	
									          	<?php endif;?>
								          	</span>
								      </div>
									</li>
								<?php endforeach;?>
								<?php endif; ?>	
								</ul>
							<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach;?>	
		</div>
	</div>
</div>


<script>
	$('.s_ss').slick({
		lazyLoad: 'ondemand',
		speed: 300,
		slidesToShow: 5,
		slidesToScroll: 1,
		arrows: true, 
		autoplay: true,
		autoplaySpeed: 3000,
		prevArrow : '<button class="slick-prev left-ab-ha" aria-label="Previous" type="button"></button>',
		nextArrow : '<button class="slick-next right-ab-ha" aria-label="Next" type="button"></button>',
		responsive: [
		    {
		      breakpoint: 1024,
		      settings: {
		        slidesToShow: 3,
		        slidesToScroll: 3,
		        infinite: true,
		      }
		    },
		    {
		      breakpoint: 600,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 2
		      }
		    },
		    {
		      breakpoint: 480,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1
		      }
		    }
		]
	});
	$('.slickeditem').slick({
		lazyLoad: 'ondemand',
		speed: 300,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true, 
		autoplay: false,
		autoplaySpeed: 3000,
		prevArrow : '<button class="slick-prev left-ab-ha best" aria-label="Previous" type="button"></button>',
		nextArrow : '<button class="slick-next right-ab-ha best" aria-label="Next" type="button"></button>',

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
</script>



