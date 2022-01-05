<?php 
$des  = "";
$title  = "";
$my = "";
$footer = "";
$headers="";
$id = 0;
$weight = "";
$event = "";
$banner = "";
?>
<?php if(!empty($content)): ?>
<?php foreach($content as $value):
$id = $value->id;
$des = $value->content;
$title = $value->title;
$my = $value->my;
$footer = $value->footer;
$headers=$value->header;
$event=$value->event;
$banner=$value->banner;
endforeach;
endif; ?>
<?php if($this->input->get("option") ==3) $weight = "CBM"; else $weight = "kg";?>
<div class="container" style="margin-top: 10px">
	<div class="row">
		<div id="subLeft" class="col-md-3">
			<div class="LeftTitle">
				<?php if($event == 1 || $banner == 1):  ?>
				고객센터
				<?php endif;?>
				<?php if($event != 1 && $banner != 1): ?>
				이용안내
				<?php endif;?>
			</div>
			<ul class="leftMenu">
				<?php if($headers==1){  ?>
				<?php  foreach($header as $value): ?>
					<?php $link = "/ipage?id=".$value->id; ?>
					<li class="<?php if($value->id == $id) echo "on" ?>">
						<a href="/ipage?id=<?=$value->id?>"><?=$value->title?></a>
					</li>
				<?php  endforeach; ?>
				<?php } ?>
				<?php if($headers!=1 && ($footer==1 || $my==1)){  ?>

				<?php if($footer ==1): ?>
					<li class="<?=strpos($_SERVER['REQUEST_URI'],"ipage?id=79") !==false ? "on":""?>"><a href="/ipage?id=79">회사소개</a></li>
					<li ><a href="/usetext">이용약관</a></li>
					<li ><a href="/policy">개인정보취급방침</a></li>
					
				<?php endif; ?>
				<?php  foreach(getPages("my") as $value): ?>
				<?php $link = "/ipage?id=".$value->id; ?>
				<li class="<?=strpos($_SERVER['REQUEST_URI'],$link) !==false ? "on":"" ?>"><a href="/ipage?id=<?=$value->id?>"><?=$value->title?></a></li>
				<?php  endforeach; ?>
				<?php } ?>
				<?php if($event == 1 || $banner == 1){  ?>
					<?php if($headers==1){  ?>
					<?php  foreach($header as $value): ?>
						<?php $link = "/ipage?id=".$value->id; ?>
						<li >
							<a href="/ipage?id=<?=$value->id?>"><?=$value->title?></a>
						</li>
					<?php  endforeach; ?>
					<?php } ?>
					<li class="on"><a href="/event">이벤트</a></li>
				<?php } ?>
			</ul>
		</div>
		<div id="subRight" class="col-md-9">
			<div class="padgeName">
				<h2><?=$title?></h2>
			</div>
			<div class="con">
				<div class="row">
					<div class="col-xs-12">
						<div class="userPage">
							<?php if(!empty($map)): ?>
							<?php foreach($map as $v):?>
							<img src="/upload/banner/<?=$id?>/<?=$v?>" class="w-100">
							<?php endforeach;?>
							<?php endif;?>
						   	<div class="<?php if($title =="배송비 안내"){ ?> border <?php } ?> p-15 mb-10"><?=$des?></div>
						   <?php if($title =="배송비 안내"): ?>
						   	<div class="box">
				                <div class="box-body table-responsive no-padding">
				                	<?php foreach($deliveryAddress as $value): ?>
				                	<a href="<?=base_url()?>ipage?id=<?=$id?>&option=<?=$value->id?>" class="btn text-white 
				                		<?php if($options ==$value->id) echo " btn-yonpu"; else echo " btn-charo"; ?>">
				                		<?=$value->area_name?>
				                	</a>
		                			<?php endforeach; ?>
				                  <table class="my-10 table table-hover gothic">
				                    <thead class="thead-grey">
				                      <tr>
				                        <th class="text-center">무게</th>
				                          <?php foreach($man as $childMans): ?>
				                              <th class="text-center"><?=$childMans->role?></th>
				                          <?php endforeach; ?>
				                      </tr>
				                    </thead>
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
				                                    <tr class="text-center">
				                                        <td class="thead-grey"><strong><?=number_format($start1,1)?></strong><?=$weight?></td>
				                                        <?php foreach($man as $childMans): ?>
				                                        <?php 	$halin = $rate[$childMans->roleId][$options];?>
				                                            <td><?=number_format(intval($halin*$startPrice))?>원</td>
				                                        <?php endforeach; ?>
				                                    </tr>
				                        <?php $start1 = $start1 + $value->weight;$startPrice = $startPrice + $value->goldSpace; } endforeach;  ?>
				                    <?php endif; ?>
				                  </table>
				                </div>
				              </div>				
						   <?php endif;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/user.css'); ?>?<?=time()?>" rel="stylesheet">