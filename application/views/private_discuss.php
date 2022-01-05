<div class="container">
	<div class="row">
		<?php $left = !empty($_GET['option']) ? $_GET['option']:"customer"; ?>
		<?php $this->load->view("left_menu",array("left"=>$left)); ?>
		<div id="subRight" class="col-md-9">
			<div class="padgeName">
				<h2>1:1맞춤문의</h2>
			</div>
			<div class="con">
				<div class="tab-qu">
					<div class="row">
						<div class="col-md-2 onepadding">
							<a href="/private" class="btn btn-primary" style="width: 100%">전체</a>
						</div>
						<div class="col-md-2 onepadding">
							<a href="/private?category=1" class="btn btn-primary" style="width: 100%">입금확인</a>
						</div>
						<div class="col-md-2 onepadding">
							<a href="/private?category=2" class="btn btn-primary" style="width: 100%">입고확인</a>
						</div>
						<div class="col-md-2 onepadding">
							<a href="/private?category=3" class="btn btn-primary" style="width: 100%">배송문의</a>
						</div>
						<div class="col-md-2 onepadding">
							<a href="/private?category=4" class="btn btn-primary" style="width: 100%">결제</a>
						</div>
						<div class="col-md-2 onepadding">
							<a href="/private?category=5" class="btn btn-primary" style="width: 100%">기타문의</a>
						</div>
					</div>
					<div class="row my-4 my-3">
						<form method="get" action="">
							<div class="col-md-2">
								<input type="hidden" name="option" value="<?=!empty($_GET['option']) && $_GET['option'] ? $_GET['option']:""?>">
								<select name="shCol" id="shCol" class="form-control w-100">
									<option value="A" <?=!empty($_GET['shCol']) && $_GET['shCol']=="A" ? "selected":""?>>제목</option>
									<option value="B" <?=!empty($_GET['shCol']) && $_GET['shCol']=="B" ? "selected":""?>>글쓴이</option>
								</select>
							</div>
							<div class="col-md-3">
								<input type="text" name="shKey" id="shKey" maxlength="20" class="form-control w-100" value="<?=!empty($_GET['shKey']) ? $_GET['shKey']:""?>">
								<input type="hidden" name="category" value="<?=!empty($_GET['category']) && $_GET['category'] ? $_GET['category']:""?>">
							</div>
							<div class="col-md-2">
								<input type="submit" class="btn btn-sm btn-primary w-100" value="검색">
							</div>
						</form>	
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-dark">
						<thead>
					      <tr>
					        <th scope="col">순번</th>
					        <th scope="col">제목</th>
					        <th scope="col">작성자</th>
					        <th scope="col">등록일</th>
					        <th scope="col">메시지 상태</th>
					        <th scope="col">답변상태</th>
					      </tr>
					    </thead>
					    <tbody>
					    	<?php if(!empty($ques)): ?>
					    		<?php foreach($ques as $value): ?>
			    			<tr>
						        <th scope="col"><?=$value->id?></th>
						        <th scope="col"><a href="/post/view/<?=$value->id?>?option=<?=$left?>"><?=$value->title?></a></th>
						        <th scope="col"><?=$value->fromId==1 ? "관리자":$this->session->userdata('fname')?></th>
						        <th scope="col"><?=$value->updated_date?></th>
						        <th><?=$value->view==1 ? "읽음":"읽지 않음"?></th>
						        <th>
						        	<?php if($value->mode==1): ?>문의중<?php endif; ?>
						        	<?php if($value->mode==2): ?>답변중<?php endif; ?>
						        	<?php if($value->mode==3): ?>답변완료<?php endif; ?>
						        </th>
						      </tr>
					    		<?php endforeach; ?>
					    	<?php endif; ?>
					  	</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<a href="/board_write?bbc_code=1&option=<?=!empty($_GET['option']) ? $_GET['option']:"customer"?>" 
							class="btn btn-secondary">글쓰기</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<link href="<?php echo site_url('/template/css/event.css'); ?>" rel="stylesheet">