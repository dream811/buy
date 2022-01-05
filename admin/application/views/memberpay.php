<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        회원별 통계
      </h1>
    </section>
    <section class="content">
        <div class="row">
        	<div class="col-xs-12">
        		<div class="box-tools">   
                  <form method="get">
                    <div class="input-group" style="margin-bottom: 10px">
                      <div class="pull-right">
                        <label style="display: block;">......</label>
                        <input class="btn btn-primary btn-sm" value="검색" type="submit">
                     </div> 
                    <div class="pull-right">
                       <label style="display: block;">검색어</label>
                       <input type="text" name="content" class="form-control input-sm" 
                       	value="<?=empty($_GET['content']) == 0 ? $_GET['content']:"" ?>">
                    </div>
                     <div class="pull-right">
	                    <label style="display: block;">검색옵션</label>
	                    <select class="form-control input-sm" style="width: 150px;" name="shType">
	                        <option value="">== 구분</option>                
	                        <option value="loginId" 
	                        <?=empty($_GET['shType']) == 0 && $_GET['shType']=="loginId"? "selected":"" ?>>아이디</option>
	                        <option value="name" <?=empty($_GET['shType']) == 0 && $_GET['shType']=="name"? "selected":"" ?>>회원명</option>
	                    </select>
	                </div>
                     <div class="pull-right">
                       <label style="display: block;">종료일</label>
                       <input type="date" name="ends_date" class="form-control input-sm" 
                       value="<?=empty($_GET['ends_date']) == 0 ? $_GET['ends_date']:"" ?>">
                     </div>
                     <div class="pull-right">
                       <label style="display: block;">시작일</label>
                       <input type="date" name="starts_date" class="form-control input-sm" 
                       value="<?=empty($_GET['starts_date']) == 0 ? $_GET['starts_date']:"" ?>">
                     </div>
                     <div class="pull-right">
                       <label style="display: block;">Page</label>
                       <select name="shPageSize" id="shPageSize" class="form-control input-sm">
                          <?php for($ii = 10 ;$ii<=100;$ii+=5){ ?>
                            <option value="<?=$ii?>" <?=empty($_GET['shPageSize'])==0 && $_GET['shPageSize']==$ii ? "selected":"" ?>><?=$ii?></option>
                          <?php }  ?>
                        </select>
                     </div>
                   </div>
                 </form>
                </div>
        		<div class="box">
        			<div class="box-body table-responsive no-padding">
	                  	<table class="table table-hover">
		                    <tr class="thead-dark">
		                      <th>회원</th>
		                      <th>배송대행</th>
		                      <th>건수</th>
		                      <th>구매대행</th>
		                      <th>건수</th>
		                      <th>리턴대행</th>
		                      <th>건수</th>
                          <th>쇼핑몰</th>
                          <th>건수</th>
		                      <th>예치금</th>
		                    </tr>
		                    <?php if(!empty($memberpay)): ?>
		                    	<?php foreach($memberpay as $value): ?>
		                    		<tr>
				                      <th><?=$value->name?></th>
				                      <th><?=$value->SUM1 == NULL || $value->SUM1 == 0 ? "0":$value->SUM1?>원</th>
				                      <th><?=$value->count1?></th>
				                      <th><?=$value->SUM2 == NULL || $value->SUM2 == 0 ? "0":$value->SUM2?>원</th>
				                      <th><?=$value->count2?></th>
				                      <th><?=$value->SUM3 == NULL || $value->SUM3 == 0 ? "0":$value->SUM3?>원</th>
				                      <th><?=$value->count3?></th>
                              <th><?=$value->SUM4 == NULL || $value->SUM4 == 0 ? "0":$value->SUM4?>원</th>
                              <th><?=$value->count4?></th>
				                      <th><?=$value->deposit?>원</th>
				                    </tr>
		                    	<?php endforeach;  ?>
		                    <?php endif; ?>
	                  </table>
	                </div><!-- /.box-body -->
	                <div class="box-footer clearfix">
	                  <?php echo $this->pagination->create_links(); ?>
	                </div>
        		</div>
        	</div>
        </div>
    </section>
</div>
