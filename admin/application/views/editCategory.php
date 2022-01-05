<?php

$name = '';
$image = "/upload/noimage.jpeg";
$use = '';
$id = 0;
if(!empty($category))
{
    foreach ($category as $uf)
    {
        $id = $uf->id;
        $name = $uf->name;
        $image = $uf->image !="" ? base_url_source()."upload/image/".$uf->image:"/upload/noimage.jpeg";
        $use = $uf->use;
    }
}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        상품 정보
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-10">
              <!-- general form elements -->
                <div class="box box-primary">
                    <?php echo form_open_multipart('registerCategory');?>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">상품명</label>
                                        <input type="text" class="form-control required" id="name" name="name" maxlength="128" value="<?=$name?>" required>
                                        <input type="hidden" name="id" value="<?=$id?>" id="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row my-4 ">    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="brand">이미지</label>
                                        <input type="file" class="form-control" id="i1"  name="image" onchange="previewFile(this,1)">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-xs-2">
                                        <img src="<?=$image?>" id="img1" style="width: 100%">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <label for="use">사용여부</label>
                                                <select name="use" id="use" class="form-control">
                                                    <option value="1" <?php if($use ==1) echo "selected"; ?>>사용</option>
                                                    <option value="0" <?php if($use ==0) echo "selected"; ?>>중지</option>
                                                </select>
                                            </div>
                                        </div>
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

function previewFile(iss,id) {
  var file  = iss.files[0];
  var reader  = new FileReader();
  reader.onloadend = function () {
    $("#img"+id).attr("src",reader.result);
  }

  if (file) {
    reader.readAsDataURL(file);
  } else {
    $("#img"+id).attr("src","");
  }
}

</script>
