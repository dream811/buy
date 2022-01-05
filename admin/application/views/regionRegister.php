<?php

$max_item = 0;
$div_par = 1;
$max_mul = 0;
$total = 0;
if(!empty($result)){
	$max_item = array_keys($result, max($result));
	$max_item = $max_item[0];
	$max_mul = 1;
	$div_par = $result[$max_item];
	$total  = array_sum($result);
}

$total_val = $total == 0 ? 1 : $total; 

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>등록 주소지(지역별)회원수</h1>
    </section>
    <section class="content">
    	<div class="row">
		    <div class="col-xs-12">
		        <div class="box">
		        	<div class="box-header">
	            		<table class="table table-bordered table-striped" style="width: 500px">
	            			<tr>
	            				<th>총가입자 수</th>
	            				<td><?=$total?>명</td>
	            		</table>

		        	</div>
		        	<div class="box-body table-responsive">
		        		<table class="table table-hover table-bordered">
		        			<colgroup>
		        				<col width="100px">
		        				<col width="100px">
		        				<col width="*">
		        				<col width="100px">
		        			</colgroup>
		        			<thead class="thead-dark">
		        				<th class="mid">구분</th>
		        				<th class="mid">가입자수</th>
		        				<th class="mid">그래프</th>
		        				<th class="mid">비율</th>	
		        			</thead>
		        			<tbody>
		        			<?php if(!empty($result)): ?>
		        			<?php foreach($result as $key=> $temp): ?>
		        				<tr>	
		        					<td class="mid"><?=$key?></td>
		        					<td class="mid"><?=$temp?>명</td>
		        					<td class="mid">
		        					<div class="display-chart <?=$max_item == $key ? "max" : ""?>" style="width:<?=($temp*$max_mul)*100 / $div_par?>%"></div>
		        					<td class="mid"><?=round(($temp*100) / $total_val , 2)?>%</td>
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