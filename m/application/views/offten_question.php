<div class="container">
	<div class="row">
		<?php $this->load->view("left_menu",NULL); ?>
		<div id="subRight" class="col-md-10">
			<div class="padgeName">
				<h2>자주하는 질문</h2>
			</div>
			<div class="con">
				<div class="tab-qu">
					<h3>고객님들이 자주 문의하시는 질문과 답변을 정리하였습니다.</h3>
					<div class="row">
						<div class="col-md-5th-1 onepadding">
							<a href="/offten_question" class="btn btn-secondary" style="width: 100%">전체</a>
						</div>
						<div class="col-md-5th-1 onepadding">
							<a href="/offten_question?category=9" class="btn btn-secondary" style="width: 100%">회원가입</a>
						</div>
						<div class="col-md-5th-1 onepadding">
							<a href="/offten_question?category=3" class="btn btn-secondary" style="width: 100%">배송대행</a>
						</div>
						<div class="col-md-5th-1 onepadding">
							<a href="/offten_question?category=10" class="btn btn-secondary" style="width: 100%">교환/반품</a>
						</div>
						<div class="col-md-5th-1 onepadding">
							<a href="/offten_question?category=11" class="btn btn-secondary" style="width: 100%">배송비결제</a>
						</div>
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
				<div class="table-responsive">
					<table class="table table-dark">
						<thead>
					      <tr>
					        <th scope="col">순번</th>
					        <th scope="col">제목</th>
					      </tr>
					    </thead>
					    <tbody>
					    	<?php if(!empty($ques)): ?>
					    	<?php foreach($ques as $value): ?>
					    		<tr>
							        <th scope="col"><?=$value->id?></th>
							        <th scope="col">
							        	<a href="post/view/<?=$value->id?>"><?=$value->title?></a>
							        </th>
							      </tr>
					    	<?php endforeach; ?>
					    	<?php endif; ?>
					  	</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="order_table">
        <table class="order_write order_table_top">
          <tbody><tr>
            <th class="title"></th>
          </tr>
          <tr>
            <td class="content">
              
            </td>
          </tr>
          </tbody>
        </table>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>
<script>
	function fnNtView(ids) {
      jQuery.ajax({
        type : "post",
        dataType : "json",
        url : baseURL + "getmailbyid",
        data : {  id : ids } 
        }).done(function(data){
          $("#exampleModal .title").text(data[0]['title']);
          $("#exampleModal .content").text(data[0]['content']);
        });
      $("#exampleModal").modal();
    }
</script>