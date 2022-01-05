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
<style type="text/css">
	header, .topInfo, #footer, .container{
		min-width: unset !important
	}
</style>
<!DOCTYPE html>
<html>
<head>
	<title></title>
  	<link href="<?php echo site_url('/template/css/bootstrap-v3.3.6.min.css'); ?>" rel="stylesheet">
  	<link href="<?php echo site_url('/template/css/style.css');?>" rel="stylesheet">	
  	<link href="<?php echo site_url('/template/css/reset.css');?>" rel="stylesheet">	
</head>
<body>
	<div class="container" >
		<div class="row">
			<div class="col-xs-12 active">
		        <?php foreach($delivery_address  as $key=>$value): ?>
		        	<a href="/getPricesByRole?option=<?=$value->id?>" 
		        		class="btn text-white  <?=$option==$value->id ? "btn-yonpu":"btn-charo" ?> btn-round"><?=$value->area_name?></a>
		        <?php endforeach; ?>
		    </div>
		</div>
		<div class="row" style="margin-top: 10px;">
			<?php for($i = 0; $i < sizeof($weights); $i+=10) { ?>
			<div class="col-xs-6 col-md-2">
				<div class="box">
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover table-bordered">
							<tr>
		                      	<th>무게(kg)	</th>
		                        <th>배송요금</th>
		                    </tr>
		                    <?php for($ii=$i;$ii<$i+10;$ii++){ ?>
		                    	<?php if(empty($weights[$ii])) continue; ?>
		                    	<tr>
			                      	<td><span class="form-weight-bold"><?=number_format($weights[$ii]['weight'],1)?></span><?=$weight?></td>
			                        <td><?=number_format($weights[$ii]['price'])?></td>
		                    	</tr>
		                    <?php } ?>
						</table>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</body>
</html>