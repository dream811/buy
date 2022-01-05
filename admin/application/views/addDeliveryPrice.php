<?php

$post = '';
$address ='';
$id = 0;
$price = 0;
$post_readonly = "readonly";
$address_readonly = "readonly";
if(!empty($add))
{
    foreach ($add as $uf)
    {
        $post = $uf->post;
        $address = $uf->address;
        $id = $uf->id;
        $price = $uf->price;
    }
}

if(trim($post) !=""){
    $post_readonly = "value='".$post."'";
}


if(trim($address) !=""){
    $address_readonly =  "value='".$address."'";
}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> 도서산간 추가배송비 설정
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-4">
              <!-- general form elements -->
                <div class="box box-primary">
                    <form role="form" id="addUser" action="<?php echo base_url() ?>updateAddDeliveryAddress" method="post">
                        <input type="hidden" name="id" value="<?=$id?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="search_btn">주소</label>
                                    <div class="form-group">
                                        <input type="text" name="post" id="ZIP" maxlength="15" class="input_txt2"   placeholder="우편번호" required 
                                        <?=$post_readonly?>>
                                        <a href="javascript:openDaumPostcode();" class="btn btn-warning btn-sm" id="search_btn">우편번호 검색</a>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="address" id="ADDR_1" maxlength="100" class="input_txt2 adr form-control"  placeholder="주소" required 
                                        <?=$address_readonly?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="price">가격</label>
                                    <input type="text" name="price" class="form-control" style="width: 150px;" value="<?=$price?>">
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <input type="reset" class="btn btn-default" value="재설정" />
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </section>
</div>
<script>
    function openDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                if ( data.userSelectedType == "R" ) {
                    document.getElementById('ZIP').value = data.zonecode;
                    document.getElementById('ADDR_1').value = data.roadAddress;
                    $("#ZIP").attr("readonly", false); 
                    $("#ADDR_1").attr("readonly", false); 
                } else {
                    alert("지번주소가 아닌 도로명주소를 선택하십시오.");
                }
            }
        }).open();
    }
</script>