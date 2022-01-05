<?php 
$img  ="";
$i1 = $value->i1!="" ? "upload/shoppingmal/".$value->id."/".$value->i1:"";
$free_mode = "";$dels = "";
if($value->p_shoppingpay_use ==0 || $value->p_shoppingpay_use==2)
    $dels = "해운특송";
  else{
    if($value->deliverybysea ==1)
    {
      $dels = "해운특송";
      if($value->deliverybysky ==1)
        $dels = $dels . "/";
    }
    if($value->deliverybysky==1)
      $dels  = $dels . "항공특송";
  }

  if($value->p_shoppingpay_use ==2)
    $free_mode = "무료배송/";
?>
<a href="/view/shop_products/<?=$value->rid?>" class="productlist">
	<div class="product_list p-5">
		<div class="product_img">
			<img src="<?=base_url_home().$i1?>">
		</div>
		<div class="product_content mid p-left-10">
			<div class="details">
				<p><?=$value->name?></p>
				<div>
					<span class="text-gray"><del><?=number_format($value->orgprice)?>원</del></span>
					<span class='font-weight-bold ml-15'><?=number_format($value->singo)?>원</span>
				</div>
				<div class="my-rating" data-rating="<?=$value->review?>"></div>
				<hr class="mt-5 mb-5">
				<div class="p-left-5 pb-5"><span class="text-green fs-12 font-weight-bold"><?=$free_mode.$dels?></span></div>
			</div>
		</div>
	</div>
</a>