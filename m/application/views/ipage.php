<?php 
$des  = "";
$title  = "";
$my = "";
$id = 0;?>
<?php if(!empty($content)): ?>
<?php foreach($content as $value):
$id = $value->id;	
$des = $value->content;

$des = str_replace("../../upload/tinymce/", base_url_home()."upload/tinymce/", $des);

$title = $value->title;
$my = $value->my;
$weight = "";
endforeach;
endif; ?>
<?php $data['title'] = $title; ?>
<?php $this->load->view("ipage_header",$data); ?>
<?php if($this->input->get("option") ==3) $weight = "CBM"; else $weight = "kg";?>
<div class="container">
	<div class="row">
		<div id="subRight">
			<div class="con">
				<div class="row">
					<div class="col-xs-12">
						<div class="userPage">
							<?php if(!empty($map)): ?>
							<?php foreach($map as $v):?>
							<img src="<?=base_url_home()?>upload/banner/<?=$id?>/<?=$v?>" class="w-100">
							<?php endforeach;?>
							<?php endif;?>
						   <div class="<?php if($title =="배송비 안내"): ?>border p-5 <?php endif ?>"><?=$des?></div>
						   <?php if($title =="배송비 안내"): ?>
								<div class="box mt-10">
					                <div class="box-body no-padding">
					                	<div class="row">
							                <?php foreach($deliveryAddress as $key=>$value): ?>
							                	<div class="col-xs-6 p-1">
							                    <a href="<?=base_url()?>ipage?id=<?=$id?>&option=<?=$value->id?>" class="btn 
							                      <?php  if($value->id == $this->input->get("option") || (empty($this->input->get("option")) && $key==0)) echo " btn-yonpu"; else echo "btn-charo";  ?>  btn-block "><?=$value->area_name?></a>
							                     </div>
							                <?php endforeach; ?>
						            	</div>
					                  <table class="table table-hover mt-10">
					                    <tr>
					                      <th>무게</th>
					                        <?php foreach($man as $childMans): ?>
					                            <th class="text-center"><?=$childMans->role?></th>
					                        <?php endforeach; ?>
					                    </tr>
					                    <?php if(!empty($deliveryContents)): 
					                        $startWeight=0;
					                        $start1= 0;
					                        $start2=0;
					                        $startPrice = 0;
					                        ?>

					                        <?php foreach($deliveryContents as $value): ?>
					                            <?php   $start1 = $value->startWeight;
					                                    $start2 = $value->endWeight;  
					                                    $startPrice = $value->startPrice;

					                                    while($start1<=$start2){ ?>
					                                    <tr>
					                                        <td class="thead-grey"><strong><?=number_format($start1,1)?></strong><?=$weight?></th>
					                                        <?php foreach($man as $childMans): ?>
					                                        <?php 	$halin = $rate[$childMans->roleId][$options];?>
					                                            <td class="text-center"><?=number_format(intval($halin*$startPrice))?></th>
					                                        <?php endforeach; ?>
					                                    </tr>
					                        <?php $start1 = $start1 + $value->weight;$startPrice = $startPrice + $value->goldSpace; } endforeach;  ?>
					                    <?php endif; ?>
					                  </table>
					                </div>
					              </div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/user.css'); ?>" rel="stylesheet">