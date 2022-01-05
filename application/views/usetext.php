
<div class="container">
	<div class="row">
		<div id="subLeft" class="col-md-3">
			<div class="LeftTitle">
				이용안내
			</div>
			<ul class="leftMenu">
				<li ><a href="/ipage?id=79">회사소개</a></li>
				<li class="<?=$_SERVER['REQUEST_URI']=="/usetext" ? "on":""?>"><a href="/usetext">이용약관</a></li>
				<li class="<?=$_SERVER['REQUEST_URI']=="/policy" ? "on":""?>"><a href="/policy">개인정보취급방침</a></li>
			</ul>
		</div>
		<div id="subRight">
			<div class="padgeName">
				<h2><?=$f?></h2>
			</div>
			<div class="con">
				<div class="row">
					<div class="col-xs-12">
						<div class="userPage">
							<?=!empty($p) ? $p[0]->link:""?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>