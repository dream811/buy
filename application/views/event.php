<div class="container">
	<div class="row">
		<?php $this->load->view("left_menu",NULL); ?>
		<div id="subRight" class="col-md-9">
			<div class="padgeName">
				<h2>이벤트</h2>
			</div>
			<div class="con">
				<div id="txtEventList">
					<ul class="event_list">
						<?php if(!empty($event)): ?>
							<?php foreach($event as $value): ?>
								<li>
									<div class="row">
										<p class="thumnail col-md-6">
											<a href="<?=$value->link?>" target="_blank">
												<img src="/upload/homepage/event/<?=$value->image?>" alt="<?=$value->title?>">
											</a>
										</p>
										<div class="event_info col-md-6">
											<p class="ico">
												<?php if(	$value->use==1 && 
															explode("|",$value->terms)[0] <= date("Y-m-d") &&
															explode("|",$value->terms)[1] >= date("Y-m-d") ){?>
												<img src="/template/images/ico_evt_1.gif"></p>
											<?php }
											else{ ?>
												<img src="/template/images/ico_evt_3.gif"></p>
											<?php } ?>
											<h4><a href="<?=$value->link?>" target="_blank" 
												title="<?=$value->title?>">
												<?=$value->title?></a></h4>
											<p class="txt" title="<?=$value->description?>"><?=$value->description?></p>
											<p class="date">기간 : <?=explode("|",$value->terms)[0]?> ~ <?=explode("|",$value->terms)[1]?></p>
										</div>
									</div>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/event.css'); ?>" rel="stylesheet">