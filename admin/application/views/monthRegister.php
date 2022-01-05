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
	<?php for($i = 1; $i <=12 ; $i++){ 
		$temp = !empty($result[$year.$i]) ? $result[$year.$i] : 0; 
		$in = $i -1;
		echo "vars[".$in."]=".$temp.";";
		echo "labels[".$in."]='".$i."월';";
	}
	?>
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>월별 회원가입</h1>
    </section>
    <section class="content">
    	<div class="row">
		    <div class="col-xs-12">
		        <div class="box">
		        	<div class="box-header">
				
		            	<form action="<?=base_url("monthloginlog")?>">
		            		<table class="table table-bordered table-striped" style="width: 500px">
		            			<tr>
		            				<th>총가입자 수</th>
		            				<td><?=$total?>명</td>
		            				<th>년도선택</th>
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
            label: '월별 접속로그',
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