<?php 
$index = 0;

if(!empty($result))
	foreach ($result as $key => $value) {
		$index = $index + $value->total;
	}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>월별 유입사이트순위</h1>
    </section>
    <section class="content">
    	<div class="row">
		    <div class="col-md-8">
		        <div class="box">
		        	<div class="box-header">
				
		            	<form action="<?=base_url("monthSite")?>">
		            		<table class="table table-bordered table-striped" style="width: 700px">
		            			<tr>
		            				<th>전체수</th>
		            				<td><?=$index?></td>
		            				<th>년도 선택</th>
		            				<td>
		            					<select name="year">
		            						<option value="">-선택-</option>
		            					<?php
		            					$t = date("Y") - 2;

		            					for($i = $t; $i<$t+3 ; $i++){

		            					?>
		            					<option value="<?=$i?>" <?=$i == $year ? "selected" : ""?>><?=$i?></option>
		            				<?php } ?>
		            					</select>년
		            				</td>
		            				<th>도메인 검색</th>
		            				<td><input type="text"  name="domain" value="<?=$this->input->get("domain")?>"></td>
		            			</tr>
		            		</table>
		            		<input type="submit" value="검색" class="btn btn-primary">
		            	</form>

		        	</div>
		        	<div class="box-body table-responsive">
		        		<table class="table table-hover table-bordered">
		        			<thead class="thead-dark">
		        				<th class="mid">구분</th>
		        				<th class="mid">접속경로</th>
		        				<th class="mid">접속횟수</th>
		        			</thead>
		        			<tbody>
		        			<?php if(!empty($result)): ?>
		        			<?php foreach($result as $value): ?>	
		        				<tr>	
		        					<td class="mid"><?=$year."-".$value->month?></td>
		        					<td class="mid"><a href="<?=$value->site?>" target="_blank"><?=$value->site?></a></td>
		        					<td class="mid"><?=$value->total?></td>
		        				</tr>
		        				<?php $index--; ?>
		        			<?php endforeach; ?>	
		        			<?php endif;?>
		        			</tbody>
		        		</table>
		        	</div>
		        	<div class="box-footer"></div>
		        </div>
		    </div>
		</div>
    </section>
</div>