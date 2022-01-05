<?php

$a_date = $year."-".$month."-01";
$max =  date("t", strtotime($a_date));
$max_item = 0;
$div_par = 1;
$max_mul = 0;
$total = 0;
if(!empty($result)){
	foreach ($result as $key => $value) {
		$total = $total + $value->total;
	}
}

$total_val = $total == 0 ? 1 : $total; 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>주별 유입사이트순위</h1>
    </section>
    <section class="content">
    	<div class="row">
		    <div class="col-md-8">
		        <div class="box">
		        	<div class="box-header">
				
		            	<form action="<?=base_url("weekSite")?>">
		            		<table class="table table-bordered table-striped" style="width: 700px">
		            			<tr>
		            				<th>전체수</th>
		            				<td><?=$total?></td>
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
		            					<select name="month">
		            						<option value="">-선택-</option>
		            					<?php


		            					for($i = 1 ; $i < 13 ; $i++){

		            					?>
		            					<option value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>" <?=$i == $month ? "selected" : ""?>><?=$i?></option>
		            				<?php } ?>
		            					</select>월
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
		        			<colgroup>
		        				<col width="100">
		        				<col width="*">
		        				<col width="100">
		        			</colgroup>
		        			<thead class="thead-dark">
		        				<th class="mid">구분</th>
		        				<th class="mid">접속경로</th>
		        				<th class="mid">접속횟수</th>
		        			</thead>
		        			<tbody>
		        			<?php if(!empty($result)): ?>
		        			<?php foreach($result as $key => $temp): ?>
		        				<?php $week = get_first($year,$temp->week); ?>	
		        				<tr>	
		        					<td class="mid"><?=$week?> ~ <?=get_7first($week)?></td>
		        					<td class="mid"><a href="<?=$temp->site?>" target="_blank"><?=$temp->site?></a></td>
		        					<td class="mid"><?=$temp->total?></td>
		        				</tr>
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