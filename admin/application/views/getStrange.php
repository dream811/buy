<?php 
if($cc==null) $cou=$ac;
else $cou = $ac-$cc;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>이상경로 감지</h1>
    </section>
    <section class="content">
    	<div class="row">
		    <div class="col-md-8">
		        	<div class="box-body table-responsive">
		        		<table class="table table-hover table-bordered">
		        			<colgroup>
		        				<col>
		        				<col>
		        				<col width="400">
		        			</colgroup>
		        			<thead class="thead-dark">
		        				<th class="mid"></th>
		        				<th class="mid">접속아이피</th>
		        				<th class="mid">이상경로</th>
		        				<th class="mid">횟수</th>
		        				<th class="mid">날자</th>
		        			</thead>
		        			<tbody>
		        			<?php if(!empty($result)): ?>
		        			<?php foreach($result as $value): ?>	
		        				<tr>
		        					<td class="mid"><?=$cou?></td>	
		        					<td class="mid"><?=$value->ip?></td>
		        					<td class="mid"><?=$value->strange?></td>
		        					<td class="mid"><?=$value->total?></td>
		        					<td class="mid"><?=date("Y-m-d",strtotime($value->created_date))?></td>
		        				</tr>
		        				<?php $cou--; ?>
		        			<?php endforeach; ?>	
		        			<?php endif;?>
		        			</tbody>
		        		</table>
		        	</div>
		        	<div class="box-footer"><?php echo $this->pagination->create_links(); ?></div>
		    </div>
		</div>
    </section>
</div>