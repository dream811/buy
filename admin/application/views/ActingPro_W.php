<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <?php

$trackingNumber = '';
$c1 = '';
$c2 = '';
$productName = '';
$unitPrice = '';
$count = 0;
$color = '';
$size = '';
$url = '';
$image = '';
$id = '';
$tracking_header = '';
if(!empty($pinfo))
{
    foreach ($pinfo as $uf)
    {
        $trackingNumber = $uf->trackingNumber;
        $c2 = $uf->category;
        $productName = $uf->productName;
        $unitPrice = $uf->unitPrice;
        $count = $uf->count;
        $size = $uf->size;
        $color = $uf->color;
        $url = $uf->url;
        $image = $uf->image;
        $id = $uf->id;
        $tracking_header = $uf->trackingHeader;
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> 상품관리
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary">
                    <!-- form start -->
                    <form role="form" action="<?php echo base_url() ?>updateProduct" method="post" id="uproduct" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="loginId">트래킹번호</label>
                                        <div class="form-group">
                                            <div class="col-xs-4">
                                                <select name="trackingHeader" class="form-control" id="trackingHeader">
                                                    <?php foreach($tracking_headers as $value): ?>
                                                        <option value="<?=$value->name?>" <?php if($tracking_header == $value->name) echo 'selected'; ?>><?=$value->name?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-xs-8">
                                                <input type="text" name="trackingNumber" value="<?=$trackingNumber?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="nickname">* 통관품목</label>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <select class="form-control" onchange="fnArcAjax(this.value,'1');">
                                                <?php if(!empty($categorys)): ?>
                                                    <?php foreach($categorys as $value): ?>
                                                        <option value="<?=$value->id?>" <?php if($value->id == $pid) echo 'selected'; ?>><?=$value->name?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-6">
                                            <select class="form-control" id="TextArc_1" onchange="fnArcChkYN('1',this.value);" name="category">
                                                <?php if(!empty($category_ch)): ?>
                                                    <?php foreach($category_ch as $value): ?>
                                                        <option enchar="<?=$value->en_subject?>" value="<?=$value->id?>" <?php if($value->id == $c2) echo 'selected'; ?>><?=$value->name?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">* 상품명(영문/중문) </label>
                                        <input type="text" class="form-control" id="productName"  name="productName" value="<?php echo $productName; ?>">
                                        <input type="hidden" value="<?php echo $id; ?>" name="id" id="id"/>    
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="unitPrice">* 단가</label>
                                        <input type="text" class="form-control" id="unitPrice"  name="unitPrice" value="<?php echo $unitPrice; ?>" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="count">* 수량</label>
                                        <input type="text" class="form-control" id="count"  name="count" value="<?php echo $count; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="color"> 색상</label>
                                        <input type="text" class="form-control" id="color"  name="color" value="<?php echo $color; ?>" maxlength="128">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="size"> 사이즈</label>
                                        <input type="text" class="form-control" id="size" name="size" value="<?php echo $size; ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="url">* 상품URL </label>
                                        <input type="text" class="form-control" id="url" name="url" value="<?php echo $url; ?>">
                                    </div>
                                </div>   
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image">* 이미지URL</label>
                                        <input type="text" class="form-control" id="image" name="image" value="<?php echo $image; ?>">
                                    </div>
                                </div>   
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <a  href="javascript:self.close();" class="btn btn-default">닫기</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>    
    </section>
</div>
</body>
</html>
<style type="text/css">
    .content-wrapper, .right-side, .main-footer{
        margin-left: 0px
    }
</style>
<script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/head.js"></script>
<script type="text/javascript">
    function fnArcAjax(sSeq, ShopNum){
      var url = "?CATE_SEQ="+sSeq; 
      fnGetChgHtmlAjax("TextArc_"+ShopNum, "/getCateogrys", url);
   }
   function fnArcChkYN(val1,val2){
      $("#TempShopNum").val(val1);
      var val = "sArcSeq=" + val2;  
      fnCtmArcProNmGet(val1);
   }
   function fnCtmArcProNmGet(ShopNum) {
      var fProNmEn = "", fProNmCn = "";

      fProNmEn = $("#TextArc_1 option:selected").attr("EnChar");
      fProNmCn = $("#TextArc_1 option:selected").attr("CnChar");
      $("input[name='productName']").val( fProNmEn );
   }
</script>