<?php 
$des  = "";
$title  = "";?>
<?php if(!empty($content)): ?>
<?php foreach($content as $value):
$des = $value->content;
$title = $value->title;
endforeach;
endif; ?>

<div class="container">
	<div class="row">
		<div id="subLeft" class="col-md-3">
			<div class="LeftTitle">
				이용안내
			</div>
			<ul class="leftMenu">
				<li <?php if(strpos($_SERVER['REQUEST_URI'],"deliveryShow")!=false): ?> class="on" <?php endif; ?> >
					<a href="/deliveryShow">배송대행 안내</a>
				</li>
				<li <?php if(strpos($_SERVER['REQUEST_URI'],"buyShow")!=false): ?> class="on" <?php endif; ?>>
					<a href="/buyShow">구매대행 안내</a>
				</li>
				<li <?php if(strpos($_SERVER['REQUEST_URI'],"delivery_price")!=false): ?> class="on" <?php endif; ?>>
					<a href="/delivery_price">배송비 안내</a>
				</li>
				<li <?php if(strpos($_SERVER['REQUEST_URI'],"totalfee")!=false): ?> class="on" <?php endif; ?>>
					<a href="/totalfee">종합수수료 안내</a>
				</li>
				<li <?php if(strpos($_SERVER['REQUEST_URI'],"incomingNot")!=false): ?> class="on" <?php endif; ?>>
					<a href="/incomingNot">수입금지 품목</a>
				</li>
				<li <?php if(strpos($_SERVER['REQUEST_URI'],"gwanbu")!=false): ?> class="on" <?php endif; ?>>
					<a href="/gwanbu">관부가세 안내</a>
				</li>
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
						   <p><?=$des?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<link href="<?php echo site_url('/template/css/user.css'); ?>" rel="stylesheet">