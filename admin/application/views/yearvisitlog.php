<script>
var vars = [];
var labels = [];
</script>
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
<script>
	<?php 
		if(!empty($result)): 
			$index = -1;
			foreach($result as $key=> $temp):
				$index++;
				$week = get_first($year,$key); 
				echo "vars[".$index."]=".$temp.";";
				echo "labels[".$index."]='".$week."~".get_7first($week)."';";
			endforeach;
		endif;	
	
	?>
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>요일별 방문로그</h1>
    </section>
    <section class="content">
    	<div class="row">
		    <div class="col-xs-12">
		        <div class="box">
		        	<div class="box-header">
		        		<form action="<?=base_url("yearvisitlog")?>">
		            		<table class="table table-bordered table-striped" style="width: 500px">
		            			<tr>
		            				<th>총 방문자 수</th>
		            				<td><?=$total?>명</td>
		            				<th>월 선택</th>
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
		            			</tr>
		            		</table>
		            		<input type="submit" value="검색" class="btn btn-primary">
		            	</form>
		        	</div>
		        	<div class="box-body table-responsive">
		        		<canvas id="bar_chart" height="100"></canvas>
		        	</div>
		        	<div class="box-footer"></div>
		        </div>
		    </div>
		</div>
    </section>
</div>


<script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.bundle.js"></script>
<script>
var ctx = document.getElementById("bar_chart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: '요일별 방문로그',
            data: vars,
            backgroundColor: 'rgba(0, 188, 212, 0.8)',
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>