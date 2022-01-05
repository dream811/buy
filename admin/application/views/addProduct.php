<?php

$name = '';
$color = '';
$size = '';
$brand = '';
$oprice = '';
$pprice = '';
$bsales = '';
$category = '';
$st = '';
$thumb = '';
$image = '';
$use = '';
$details = '';
$short  ='';
$id = '';
if(!empty($product))
{
    foreach ($product as $uf)
    {
        $name = $uf->name;
        $brand = $uf->brand;
        $oprice = $uf->origin_price;
        $color = $uf->color;
        $image = $uf->image;
        $short = $uf->short_description;
        $bsales = $uf->bef_sales;
        $pprice = $uf->product_price;
        $st = $uf->sales_term;
        $size = $uf->size;
        $thumb = $uf->thumbnail;
        $use = $uf->use;
        $details = $uf->detailed_desctiption;
        $id = $uf->id;
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        상품관리
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-10">
              <!-- general form elements -->
                <div class="box box-primary">
                    <?php echo form_open_multipart('registerProduct');?>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">상품명</label>
                                        <input type="text" class="form-control required" id="name" name="name" maxlength="128" value="<?=$name?>">
                                        <input type="hidden" name="id" value="<?=$id?>">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="brand">브랜드</label>
                                        <input type="text" class="form-control required" id="brand"  name="brand" maxlength="128" value="<?=$brand?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="oprice">상품 원가(￥)</label>
                                        <input type="text" class="form-control required" id="oprice"  name="oprice" maxlength="10" value="<?=$oprice?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bsales">상품 가격</label>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <input type="text" class="form-control required" id="bsales"  name="bsales" maxlength="10" placeholder="할인전 가격" value="<?=$bsales?>">
                                            </div>
                                            <div class="col-xs-6">
                                                <input type="text" class="form-control required" id="pprice"  name="pprice" maxlength="10" placeholder="상품 가격" value="<?=$pprice?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">품목</label>
                                        <select class="form-control required" id="category" name="category">
                                            <option value="0">Select Role</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="terms">판매기간</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" >
                                                <input class="form-control" size="16" type="text" value="<?=date("Y-m-d")?>" readonly name="terms1" value="<?php if($st !='') echo explode("|", $st)[0]; ?>">
                                                <span class="input-group-addon" style="width: 39px"><span class="glyphicon glyphicon-calendar">
                                                </span></span>  
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                <input class="form-control" size="16" type="text" value="<?=date("Y-m-d")?>" readonly name="terms2" value="<?php if($st !='') echo explode("|", $st)[1]; ?>">
                                                <span class="input-group-addon" style="width: 39px"><span class="glyphicon glyphicon-calendar">
                                                </span></span>  
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="color">색상</label>
                                        <input type="text" class="form-control required" id="color" name="color" maxlength="128" value="<?=$color?>">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="size">사이즈</label>
                                        <input type="text" class="form-control required" id="size"  name="size" maxlength="128" value="<?=$size?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="thumb">썸네일 이미지</label>
                                        <input type="file" name="thumb" id="thumb"  value="<?=$thumb?>">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">상품 이미지   </label>
                                        <input type="file" name="image" id="image" value="<?=$image?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="short">간략 설명</label>
                                        <input type="text" name="short" id="short"  value="<?=$short?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="use">사용여부</label>
                                        <select class="form-control" id="use" name="use">
                                            <option value="0" <?php if($use == 0) echo 'selected';?>>중지</option>
                                            <option value="1" <?php if($use == 1) echo 'selected';?>>사용</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="details">상세설명</label>
                                        <input type="text" name="details" id="details" class="form-control" value="<?=$details?>">
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <input type="reset" class="btn btn-default" value="취소" />
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </section>
</div>

<script>
    $('.form_date').datetimepicker({
        language:  'kr',
        weekStart: 1,
        autoclose: 1,
        startView: 2,
        forceParse: 0
    });
</script>