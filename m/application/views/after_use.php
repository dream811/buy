<div class="container">
	<div class="row">
		<?php $this->load->view("left_menu",NULL); ?>
		<div id="subRight" class="col-md-10">
			<div class="padgeName">
				<h2>이용후기</h2>
			</div>
			<div class="con">
				<div class="tab-qu">
					<div class="row">
						<div class="col-md-2 onepadding">
							<a href="/after_use" class="btn btn-secondary" style="width: 100%">전체</a>
						</div>
						<div class="col-md-2 onepadding">
							<a href="/after_use?category=6" class="btn btn-secondary" style="width: 100%">배송대행</a>
						</div>
						<div class="col-md-2 onepadding">
							<a href="/after_use?category=7" class="btn btn-secondary" style="width: 100%">구매대행</a>
						</div>
						<div class="col-md-2 onepadding">
							<a href="/after_use?category=8" class="btn btn-secondary" style="width: 100%">리턴</a>
						</div>
					</div>
					<div class="row my-4 my-3">
						<form method="get" action="">
							<div class="col-md-2">
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
					        <th scope="col">조회수</th>
					      </tr>
					    </thead>
					    <tbody>
					    	<?php if(!empty($after_use)): ?>
					    		<?php foreach($after_use as $value): ?>
					    			<tr>
								        <th scope="col"><?=$value->id?></th>
								        <th scope="col">
								        	<a href="/post/view/<?=$value->id?>"><?=$value->title?></a>
								        </th>
								        <th scope="col"><?=$value->name?></th>
								        <th scope="col"><?=$value->updated_date?></th>
								        <th scope="col"><?=$value->view?></th>
								      </tr>
					    		<?php endforeach; ?>
					    	<?php endif; ?>
					  	</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<a href="/board_write?bbc_code=2" class="btn btn-secondary">글쓰기</a>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>
<link href="<?php echo site_url('/template/css/poster.css');?>" rel="stylesheet">