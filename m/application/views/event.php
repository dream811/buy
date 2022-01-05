<div class="container">
	<div class="row">
		<?php $data['title']="이벤트"; ?>
		<?php $data['link']="history.back()"; ?>
		<?php $this->load->view("event_header",$data); ?>
		<div id="subRight" >
			<div class="con">
				<div id="txtEventList">
						<?php if(!empty($event)): ?>
							<?php foreach($event as $value): ?>
									<div class="row p-5">
										<div class="thumnail col-xs-4 p-10 text-center mid gray">
											<h4 style="font-size: 13px" class="font-weight-bold"><a href="<?=$value->link?>" target="_blank" 
												title="<?=$value->title?>">
												<?=$value->title?></a></h4>
											<a href="<?=$value->link?>" target="_blank">
												<img src="<?=base_url_home()?>upload/homepage/event/<?=$value->image?>" alt="<?=$value->title?>" class="w-80">
											</a>
										</div>
										<div class="event_info col-xs-8  p-right-10 p-left-10">
											<p class="ico">
												<?php if(	$value->use==1 && 
															explode("|",$value->terms)[0] <= date("Y-m-d") &&
															explode("|",$value->terms)[1] >= date("Y-m-d") ){?>
												<img src="/template/images/ico_evt_1.gif"></p>
											<?php }
											else{ ?>
												<img src="/template/images/ico_evt_3.gif"></p>
											<?php } ?>
												<p class="txt" title="<?=$value->description?>"><?=$value->description?></p>
											<p class="date" style="font-size: 11px;color: red">기간 : <?=explode("|",$value->terms)[0]?> ~ <?=explode("|",$value->terms)[1]?></p>
										</div>
									</div>
							<?php endforeach; ?>
						<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/event.css');?>" rel="stylesheet">
<style type="text/css">
	#txtEventList .row {
    display: table;
}

#txtEventList [class*="col-"] {
    float: none;
    display: table-cell;
    vertical-align: top;
}
</style>