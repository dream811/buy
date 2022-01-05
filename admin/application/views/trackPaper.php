<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/admin.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/table.min.css" rel="stylesheet" type="text/css" />  
	<script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
	<script src='<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js'></script>	
</head>
<body>
	<?php if(empty($delivery)): ?>
		해당 주문의 존재하지 않습니다.
	<?php 
		return;
	endif; ?>	
	<div class="container-f">
		<div class="pop-title"><h3>운송장 번호 : <strong><?=$delivery[0]->tracking_number?></strong></h3></div>
		<div class="row  p-15">
			<div class="col-md-12">
				<div class="form-group">
				    <label for="exampleInputPassword1">발송지 정보</label>
				    <div class="box-body table-responsive no-padding">
		                <table class="table">
							<tbody>
						    	<tr>
								   	<th>회사명 : </th>
								    <td colspan="3"><?=!empty($company) ? $company[0]->name:""?></td>
								</tr>
								<tr>
								    <th>전화번호:</th>
								    <td><?=!empty($delivery) ? $delivery[0]->phoneNum:""?></td>
								</tr>
								<tr>
								    <th>주소:</th>
								    <td><?=$delivery[0]->Daddress?>(<?=$delivery[0]->area_name?>)</td>
								</tr>
							</tbody>
						</table>
		            </div>
				</div>
			</div>
		</div>
		<div class="row   p-15">
			<div class="col-md-12">
				<div class="form-group">
				    <label for="exampleInputPassword1">수취인 정보</label>
				    <div class="box-body table-responsive no-padding">
		                <table class="table">
							<tbody>
								<tr>
								   	<th>국가/지역:</th>
								    <td colspan="3">XXXXXXXXXX</td>
								</tr>
						    	<tr>
						    		<th>이름:</th>
								   	<td><?=$delivery[0]->billing_krname?></td>
								   	<th>우편번호:</th>
								    <td><?=$delivery[0]->post_number?></td>
								</tr>
								<tr>
									<th>개인식별자코드:</th>
								   	<td><?=$delivery[0]->person_unique_content?>
								   		(<?=$delivery[0]->person_num==1 ? "개인통관고유부호":"사업자등록번호"?>)
								   	</td>
								    <th>전화번호:</th>
								    <td><?=$delivery[0]->phone_number?></td>
								</tr>
								<tr>
									<th>주소:</th>
								   	<td colspan="3"><?=$delivery[0]->address?></td>
								</tr>
							</tbody>
						</table>
		            </div>
				</div>
			</div>
		</div>
	</div>	
</body>
</html>
