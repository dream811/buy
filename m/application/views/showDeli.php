<?php 
	$address_rate = $user[0]->address_rate;
	$address_rate = json_decode($address_rate,true);
	$inul = $user[0]->sending_inul;
	if(!empty($address_rate) && isset($address_rate[$option]))
		$inul = $address_rate[$option];
	$weights=array();
    if(!empty($deli)): 
      	$startWeight=0;
      	$start1= 0;
      	$start2=0;
      	$startPrice = 0;
		foreach($deli as $value):
          	$start1 = $value->startWeight;
            $start2 = $value->endWeight;  
            $startPrice = $value->startPrice*$inul;
            while($start1<=$start2){	
      			array_push($weights,array("weight"=>$start1,"price"=>$startPrice));
      			$start1 = $start1 + $value->weight;
      			$startPrice = $startPrice + $value->goldSpace;
      		} 
      	endforeach;
	endif;
?>
<?php if($option ==3) $weight = "CBM"; else $weight = "kg";?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
  	<link href="<?php echo site_url('/template/css/bootstrap-v3.3.6.min.css'); ?>" rel="stylesheet">
  	<link href="<?php echo site_url('/template/css/style.css');?>" rel="stylesheet">	
  	<link href="<?php echo site_url('/template/css/reset.css');?>" rel="stylesheet">	
  	<link href="<?php echo site_url('/template/css/user.css');?>" rel="stylesheet">
</head>
<body style="margin-top: 0px">
	<div class="container userPage" >
		<div class="row">
			<?php foreach($delivery_address  as $key=>$value): ?>
			<div class="col-xs-6 p-1">
		        <a href="/getPricesByRole?option=<?=$value->id?>" 
		        		class="btn <?=$option==$value->id ? "btn-yonpu":"btn-charo"?> btn-block"><?=$value->area_name?></a>
		    </div>
		    <?php endforeach; ?>
		</div>
		<div class="row" style="margin-top: 10px;">
			
			<div class="col-xs-12 p-1">
				<div class="box">
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover table-bordered">
							<tr>
		                      	<th class="text-center">무게	</th>
		                        <th class="text-center">배송요금</th>
		                    </tr>
		                    <?php //for($ii=$i;$ii<$i+10;$ii++){ ?>
		                    	<?php for($i = 0; $i < sizeof($weights); $i++) { ?>
		                    	<?php if(empty($weights[$i])) continue; ?>
		                    	<tr>
			                      	<th class="text-center"><?=number_format($weights[$i]['weight'],1)?><?=$weight?></th>
			                        <td class="text-center"><?=number_format($weights[$i]['price'])?></th>
		                    	</tr>
		                    <?php //} ?>
		                	<?php } ?>
						</table>
					</div>
				</div>
			</div>
			<?php //} ?>
		</div>
	</div>
</body>
</html>
<style type="text/css">
	html, body {
    background-color: #fff !important;
}
</style>