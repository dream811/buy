<?php  
if(empty($left) || $left=="customer"): ?>
	<div id="subLeft" class="col-md-3">
		<div class="LeftTitle">
			고객센터
		</div>
		<ul class="leftMenu">
              <?php if(!empty($bmenu)): ?>
              <?php foreach($bmenu as $value): ?>
              <li class="<?=!empty($_GET['id']) && $value->iden == $_GET['id'] ? "on":""?>"><a href="/panel?id=<?=$value->iden?>"><?=$value->title?></a></li>
              <?php endforeach; ?>
              <?php endif; ?>
			<li class="<?=strpos(base_url().'event',$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) !==false ?"on":"" ?>"><a href="<?=base_url()?>event">이벤트</a></li>
		</ul>
	</div>	
<?php  endif;?>	
<?php  if(!empty($left) && $left=="my"): ?>
	<div id="subLeft" class="col-md-3">
			<div class="LeftTitle">
				마이페이지
			</div>
			<ul class="leftMenu">
				<li class="<?=strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'mypage') !==false || strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'view/delivery') !==false ?"on":"" ?>"><a href="/mypage">마이홈</a></li>
				<li class="<?=strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'mypay') !==false || strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'payHistory') !==false ?"on":"" ?>"><a href="/mypay">결제페이지</a></li>
				<li class="<?=	strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'deposit') !==false || 
								strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'point_history') !==false ?"on":"" ?>"><a href="/deposit">예치금/포인트</a></li>
				<li class="<?=(strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'private?option=my') !==false || strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'board_write?bbc_code=4') !==false || strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'/post/view/') !==false ? "on":"")
					|| strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'/panel') !==false || strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'board_edit?bbc_code=4') !==false ?"on":"" ?>"><a href="/private?option=my">Q&A</a></li>
				<li class="<?=strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'coupon') !==false ?"on":"" ?>"><a href="/coupon">나의 쿠폰함</a></li>
				<li class="<?=strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'mailbox') !==false ?"on":"" ?>"><a href="/mailbox">받은 쪽지함</a></li>
				<li class="<?=strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'member') !==false ?"on":"" ?>"><a href="/member">회원정보수정</a></li>
			</ul>
		</div>
<?php  endif;?>