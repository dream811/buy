<div class="container">
	<div class="row">
		<div id="subLeft" class="col-md-3">
			<div class="LeftTitle">
				마이페이지
			</div>
			<ul class="leftMenu">
				<li ><a href="/mypage">마이홈</a></li>
				<li ><a href="/mypay">결제페이지</a></li>
				<li ><a href="/deposit">예치금/포인트</a></li>
				<li class="on"><a href="/private">Q&A</a></li>
				<li ><a href="/coupon">나의 쿠폰함</a></li>
				<li ><a href="/mailbox">받은 쪽지함</a></li>
				<li ><a href="/member">회원정보수정</a></li>
			</ul>
		</div>
		<div id="subRight" class="col-md-9">
			<div class="padgeName">
				<h2>Q&amp;A</h2>
			</div>
			<div class="con">
				<div class="row my-3">
					<div class="col-md-2"><a href="/private" class="btn btn-secondary w-100">전체</a></div>
					<div class="col-md-2"><a href="/private?category=1" class="btn btn-secondary w-100">입금확인</a></div>
					<div class="col-md-2"><a href="/private?category=2" class="btn btn-secondary w-100">입고확인</a></div>
					<div class="col-md-2"><a href="/private?category=3" class="btn btn-secondary w-100">배송문의</a></div>
					<div class="col-md-2"><a href="/private?category=4" class="btn btn-secondary w-100">결제</a></div>
					<div class="col-md-2"><a href="/private?category=5" class="btn btn-secondary w-100">기타문의</a></div>
				</div>
				<div class="table-responsive">
					<table class="table table-dark">
						<thead>
					      <tr>
					        <th scope="col">순번</th>
					        <th scope="col">제목	</th>
					        <th scope="col">작성자</th>
					        <th scope="col">등록일</th>
					      </tr>
					    </thead>
					    <tbody>
					    	<?php  if(!empty($ques)): ?>
					    	<?php  foreach($ques as $value):?>
					    		<tr>
					    			<th scope="col"><?=$value->id?></th>
							        <th scope="col"><?=$value->title?></th>
							        <th scope="col"><?=$value->name?></th>
							        <th scope="col"><?=$value->updated_date?></th>
					    		</tr>
					    	<?php  endforeach;?>
					    	<?php  endif;?>

					    </tbody>
					</table>
				</div>
				<div class="my-4 row">
					<div class="col-xs-12">
						<a href="/board_write?bbc_code=1" class="btn btn-secondary">글쓰기</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>