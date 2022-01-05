<?php
  $postcode = "";
  $del_id = "";
  $address = "";
  $details = "";
  $name  = "";
  $eng_name = "";
  $p1 = "";
  $p2 = "";
  $p3 = "";
  $type = "";
  $RRN_NO = "";
  if(!empty($deliverys)):
    foreach($deliverys as $value):
    	$phones = explode("-",$value->phone);
      	$postcode = $value->postcode;
      	$del_id = $value->id;
      	$address = $value->address;
      	$details= $value->details_address;
      	$name = $value->name;
      	$eng_name = $value->eng_name;
      	$p1 = $phones[0];
      	$p2 = $phones[1];
      	$p3 = $phones[2];
      	$type = $value->type;
      	$RRN_NO = $value->unique_info;
    endforeach;
  endif;
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="content-language" content="es-ES" />
		<meta name="viewport" content="width=device-width,
		initial-scale=1.0, maximum-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
	    <link href="<?php echo site_url('/template/css/reset.css'); ?>?<?=time()?>" rel="stylesheet">
	    <script>
    window.jQuery || document.write('<script src="<?php
    echo site_url('/template/js/jquery-v1.11.3.min.js') ?>"><\/script>')
  </script>
	    <script src="<?php echo site_url('/template/js/bootstrap-v3.3.6.min.js') ?>"></script>
	    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
	</head>
	<body>
		<div class="container">
			<h2 class="mb-10 my-10 font-weight-bold">나의 배송주소</h2>
			<form action="/registerContact" method="post">
				<div class="table-responsive">
		        	<table  class="table table-bordered">
		        		<tbody>
						    <tr>
						      	<th scope="row" class="mid text-center"><label for="postcode">우편번호</label></th>
						      	<td class="mid">
								    <input type="text" name="postcode" required id="postcode" value="<?=$postcode?>">.
								    <a href="javascript:openDaumPostcode();" class="btn btn-warning btn-sm btn-round">주소검색</a>
								    <input type="hidden" name="page" value="mypage">
									<input type="hidden" name="id" value="<?=$del_id?>" id="del_id">
								</td>
						    </tr>
						    <tr>
						      <th scope="row" class="mid text-center"><label for="address">주소</label></th>
						      <td class="mid">
						      	<input type="text" class="form-control" name="address" readonly placeholder="한글" required id="address" value="<?=$address?>">
						      </td>
						    </tr>
						    <tr>
						      <th scope="row" class="mid text-center"><label for="details">상세주소</label></th>
						      <td class="mid"><input type="text" class="form-control" name="details" id="details" value="<?=$details?>"></td>
						    </tr>
						    <tr>
						      <th scope="row" class="mid text-center"><label for="name">수취인 이름(한글)</label></th>
						      <td class="mid"><input type="text" class="form-control" name="name" required id="name" value="<?=$name?>"></td>
						    </tr>
						    <tr>
						      <th scope="row" class="mid text-center"><label for="eng_name">수취인 이름(영문)</label></th>
						      <td class="mid"><input type="text" class="form-control" name="eng_name" id="eng_name" value="<?=$eng_name?>"></td>
						    </tr>
						    <tr>
						      <th scope="row" class="mid text-center"><label>연락처</label></th>
						      <td class="mid">
						      		<div class="row grid">
									  	<div class="col">
									  		<input type="text" name="p1" class="form-control" required id="p1" value="<?=$p1?>">
									  	</div>
									  	<div class="col">
									  		<input type="text" name="p2" class="form-control" required id="p2" value="<?=$p2?>">
									  	</div>
									  	<div class="col">
									  		<input type="text" name="p3" class="form-control" required id="p3" value="<?=$p3?>">
									  	</div>
									</div>
								</td>
						    </tr>
						    <tr>
						      <th scope="row" class="mid text-center"><label>받는 사람 정보</label></th>
						      <td class="mid">
							      	<div class="form-check form-check-inline">
									  <input class="form-check-input" type="radio" id="inlineCheckbox1" value="1" name="type" <?php  if($type ==1 || empty($type)) echo 'checked'; ?>>
									  <label class="form-check-label" for="inlineCheckbox1">개인통관고유부호 (추천)</label>
									</div>
									<div class="form-check form-check-inline">
									  <input class="form-check-input" type="radio" id="inlineCheckbox2" value="3" name="type" <?php  if($type ==3) echo 'checked'; ?>>
									  <label class="form-check-label" for="inlineCheckbox2">사업자번호</label>
									</div>
									<input type="text" class="form-control" name="RRN_NO" id="RRN_NO" value="<?=$RRN_NO?>">
								</td>
						    </tr>
						</tbody>
		        	</table>
		      	</div>
				<div class="row my-10">
				  	<div class="col-md-12 my-3">
				  		<input type="submit"  class="btn btn-warning btn-round btn-sm" value="등록하기">
				  		<a href="/User_MemAddr_S" class="btn btn-default btn-round btn-sm">목록가기</a>
				  	</div>
				</div>
			</form>
		</div>
	</body>
</html>
<script>
	function openDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
				if ( data.userSelectedType == "R" ) {
					document.getElementById('postcode').value = data.zonecode;
					document.getElementById('address').value = data.roadAddress;
					document.getElementById('details').focus();
				} else {

					alert("지번주소가 아닌 도로명주소를 선택하십시오.");
				}
            }
        }).open();
	    }
</script>
<style type="text/css">
	th{
		background: #f3f0f0
	}
	.table th{
		border-top: none;
	}
	.table-responsive{
		border-top: none;
	}
  #footer, .container, .topInfo, header{
    min-width: unset
  }
</style>
