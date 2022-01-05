<?php

$max_item = 0;
$div_par = 1;
$max_mul = 0;
$total = 0;
if(!empty($region)){
	$max_item = array_keys($region, max($region));
	$max_item = $max_item[0];
	$max_mul = 1;
	$div_par = $region[$max_item];
	$total  = array_sum($region);
}

$total_val = $total == 0 ? 1 : $total; 

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>지역별(아이피 주소) 방문</h1>
    </section>
    <section class="content">
    	<div class="row">
		    <div class="col-xs-12">

		        	<div class="box-header">
	            		<table class="table table-bordered table-striped" style="width: 500px">
	            			<tr>
	            				<th>총방문자 수</th>
	            				<td><?=$total?>명</td>
	            		</table>

		        	</div>
		        	<div class="box-body table-responsive">
		        		<table class="table table-hover table-bordered">
		        			<colgroup>
		        				<col width="150px">
		        				<col width="100px">
		        				<col width="*">
		        				<col width="100px">
		        			</colgroup>
		        			<thead class="thead-dark">
		        				<th class="mid">지역별</th>
		        				<th class="mid">방문자수</th>
		        				<th class="mid">그래프</th>
		        				<th class="mid">비율</th>	
		        			</thead>
		        			<tbody>
		        			<?php if(!empty($region)): ?>
		        			<?php foreach($region as $key=> $temp): ?>
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
		        	<div class="box-footer">
		        		<?php echo $this->pagination->create_links(); ?>
		        	</div>

		    </div>
		</div>
    </section>
</div>