<?php 

$banner = getBanners(23,1);
$mid_menu = getBanners(25,1);
$mid_ad = getBanners(26,1);
?>

<?php 
$list_pro = array(	"best_products"=> "best",
					"rec_products"=> "rec",
					"new_products"=> "news",
					"cheap_products"=> "low",
					"wow_products"=>"wow");

$list_names = array("베스트상품",
					"&nbsp;추천상품&nbsp;&nbsp;",
					"&nbsp;&nbsp;&nbsp;신상품&nbsp;&nbsp;&nbsp;",
					"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;싸다&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
					"&nbsp;&nbsp;&nbsp;멋지다&nbsp;&nbsp;&nbsp;");
?>
<link href="<?php echo site_url('/template/css/shop.css?'.time());?>" rel="stylesheet">
<link href="<?php echo site_url('/template/css/tao.css?'.time()); ?>" rel="stylesheet">
<link href="<?=base_url_home()?>assets/plugins/ratings/star-rating-svg.css" rel="stylesheet">
<script src="<?=base_url_home()?>assets/plugins/ratings/jquery.star-rating-svg.js"></script>
<script src="<?php echo site_url('/template/js/shop.js')?>?<?=time()?>"></script>
<?php $data["tt"]=1; ?>
<?php $this->load->view("shop_header",$data); ?>
<section class="taoshopping">
	<div class="shopping_banner">
		<div class="carousel slide banners" data-ride="carousel" id="banner_car">
	        <ol class="carousel-indicators">
	          <?php if(!empty($banner)): ?>
	          <?php foreach($banner as $keys=>$value): ?>
	          	<li data-target="#logos" data-slide-to="<?=$keys?>" class="<?=$keys ==0 ? "active":""?>"></li>
	          <?php endforeach; ?>
	          <?php endif; ?>
	        </ol>
	        <div class="carousel-inner" role="listbox">
	            <?php if(!empty($banner)): ?>
	              <?php foreach($banner as $keys=>$value): ?>
	                <div class="item <?=$keys==0 ? "active":""?>">
	                  	<a href="<?=$value->link == ""? "#":$value->link?>" target="<?=$value->target==2 ? "_blink":""?>">
	                    	<img  data-src="/upload/homepage/banner/<?=$value->image?>" src="/upload/homepage/banner/<?=$value->image?>" data-holder-rendered="true" class="w-100">
	                  	</a>
	                </div>
	              <?php endforeach; ?>
	            <?php endif; ?>
	        </div>
	         <a class="left carousel-control" href="#banner_car" data-slide="prev">
	            <img src="<?=base_url_home()?>assets/images/banner_l.png" class="im-left">
	        </a>
	        <a class="right carousel-control" href="#banner_car" data-slide="next">
	            <img src="<?=base_url_home()?>assets/images/banner_r.png" class="im-right">
	        </a>
	    </div>
	</div>
</section>
<section class="mid-menu mt-20">
   <ul class="row">
        <?php if(!empty($mid_menu)): ?>
        <?php foreach($mid_menu as $key=>$value):?>
        <li class="col-xs-3 col-md-2 <?=$key%4==0 ? "p-left-0":"p-left-1"?> <?=$key%4==3 ? "p-right-0":"p-right-1"?> p-bottom-2">
        	<div class="bg-white text-center pb-5">
        		<a href="<?=$value->link?>" target="<?=$value->target==1 ? "_self":"_blink"?>">
	          		<img src="<?=base_url()?>upload/homepage/banner/<?=$value->image?>" class="img-responsive m-auto" alt="<?=$value->description?>" width=50 height=50>
	          		<span><?=$value->title?></span>
	          	</a>
        	</div>

      	</li>
      <?php endforeach; ?>
      	<?php endif; ?>
    </ul>
</section>
<section class="mid-ad mt-20">
	<div>
		<?php if(!empty($mid_ad)): ?>
		<a href="<?=$mid_ad[0]->link?>" target="<?=$mid_ad[0]->target ==1 ? "_self":"_blink"?>">
			<img src="<?=base_url()?>upload/homepage/banner/<?=$mid_ad[0]->image?>" class="w-100">
		</a>
		<?php endif; ?>
	</div>
</section>
<?php $index = 0; ?>
<?php foreach($list_pro  as $key=>$list_item): ?>
<section class="best mt-20">
	<P class="fav-header"><?=$list_names[$index]?></P>
	<?php $index++; ?>
	<img src="/assets/images/<?=$list_item?>.png" class="w-100">
	<div>
		<?php if(!empty($$key)): ?>
		<?php foreach($$key as $value): ?>
		<a href="/view/shop_products/<?=$value->rid?>" class="bg-white mb-5 d-block">
			<div class="product_list p-5">
				<div class="product_img">
					<img src="<?=base_url_home()?>upload/shoppingmal/<?=$value->id?>/<?=$value->image?>">
				</div>
				<div class="product_content mid p-left-10 mt-10">
					<div class="details">
						<p><?=$value->name?></p>
						<div>
							<span class="text-gray"><del><?=number_format($value->orgprice)?>원</del></span>
							<span class="ml-15 price"><?=number_format($value->singo)?>원</span>
						</div>
						 <div class="my-rating" data-rating="<?=$value->review?>"></div>
					</div>
				</div>
			</div>
			<hr class="mt-5 mb-5">
			<?php $del_m = "";$del_free=""; ?>
			<?php if($value->p_shoppingpay_use ==0 || $value->p_shoppingpay_use=="2"): ?>
			<?php $del_m = "해운특송"; ?>
			<?php endif; ?>
			<?php if($value->p_shoppingpay_use ==1 ): ?>
				<?php
				if($value->deliverybysea ==1)
				{
					$del_m="해운특송";
					if($value->deliverybysky ==1)
						$del_m .="/";
				}
				if($value->deliverybysky ==1)
					$del_m .="항공특송";
				?>
				<?php if($value->p_shoppingpay_use=="2"): ?>
				<?php $del_free = "무료배송/"; ?>
				<?php endif; ?>
			<?php endif; ?>
			<div class="p-left-10 pb-5"><span class="text-green fs-12 font-weight-bold"><?=$del_free.$del_m?></span></div>
		</a>
		<?php endforeach;?>	
		<?php endif;?>
	</div>
</section>
<?php endforeach; ?>
<script>
	$('.banners').carousel(
	  {
	    interval: 8000
	  }
	);
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