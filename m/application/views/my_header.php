<div class="shop_header p-5 bg-green">
	<div class="row">
		<div class="col-xs-12 text-center p-1">
	     	<img src="/template/images/back.png" class="back_btn" width="18px" onclick="history.back()">
	      	<span class="parts1 text-white"><?=$title?></span>
	    </div>
	</div>
</div>
<!-- <div class="category_part">
	<ul class="nav-shop">
		<li class="shop-item"><a href="/mypage"><span class="border-l <?=$_SERVER['REQUEST_URI']=="/mypage" ? "text-yellow":""?>">홈</span></a></li>
		<li class="shop-item"><a href="/mypay"><span class="border-l 
			<?=$_SERVER['REQUEST_URI']=="/mypay" || (!empty($pay_page) && $pay_page==1)  ? "text-yellow":""?>">결제</span></a></li>
		<li class="shop-item"><a href="/deposit"><span class="border-l <?=$_SERVER['REQUEST_URI']=="/deposit" ? "text-yellow":""?>">예치금</span></a></li>
		<li class="shop-item"><a href="/private?option=my"><span class="border-l <?=strpos($_SERVER['REQUEST_URI'],"option=my")!==false ? "text-yellow":""?>">Q&A</span></a></li>
		<li class="shop-item"><a href="/coupon"><span class="border-l 
			<?=$_SERVER['REQUEST_URI']=="/coupon" || $_SERVER['REQUEST_URI']=="/coupon_list" ? "text-yellow":""?>">쿠폰</span></a></li>
		<li class="shop-item"><a href="/mailbox"><span class="border-l <?=$_SERVER['REQUEST_URI']=="/mailbox" ? "text-yellow":""?>">쪽지</span></a></li>
		<li class="shop-item"><a href="/member"><span class="border-l <?=$_SERVER['REQUEST_URI']=="/member" ? "text-yellow":""?>">정보수정</span></a></li>
	</ul>
</div>
 -->