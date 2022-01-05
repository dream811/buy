<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        품목관리
      </h1>
    </section>
    <section class="content">
      <form action="/admin/saveCategory" method="post" enctype="multipart/form-data">
        <input type="hidden" name="CATE_SEQ" id="CATE_SEQ" value="1">
        <input type="hidden" name="id" value="" id="id">
        <input type="hidden" name="url" value="childCat">
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>카테고리</p>
          </div>
          <div class="col-md-2">
            <select class="form-control" name="parent" id="parent">
              <?php if(!empty($topcat)): ?>
                <option value="">카테고리를 선택해주세요</option>
                <?php foreach($topcat as $value1): ?>
                  <option value="<?=$value1->id?>" 
                    <?php if($this->input->get("category") == $value1->id) echo "selected"; ?>>
                    <?=$value1->name?></option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>일반통관</p>
          </div>
          <div class="col-md-2">
            <select class="form-control" name="general_customs" id="general_customs">
             <option value="1">예</option>
             <option value="0">아니</option>
            </select>
          </div>
          <div class="col-md-2 text-center">
            <p>HS_CODE</p>
          </div>
          <div class="col-md-2">
            <input type="text" class="form-control" name="hs_code" id="hs_code">
          </div>
        </div>  
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>영문 품목명</p>
          </div>
          <div class="col-md-6">
            <input type="text" name="en_subject" class="form-control" id="en_subject" required> 
          </div>
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>한글 품목명 </p>
          </div>
          <div class="col-md-6">
            <input type="text" name="kr_subject" class="form-control" id="kr_subject" required>
          </div>
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>중국 품목명 </p>
          </div>
          <div class="col-md-6">
            <input type="text" name="chn_subject" class="form-control" id="chn_subject">
          </div>
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>관세율</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="tariff_rate" class="form-control" id="tariff_rate">
          </div><div class="col-md-2 text-center">
            <p>부가세율</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="vat_rate" class="form-control" id="vat_rate">
          </div>
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>사용유무</p>
          </div>
          <div class="col-md-2">
            <select class="form-control" name="use" id="use">
             <option value="1">사용</option>
             <option value="0">중지</option>
            </select>
          </div>
          <div class="col-md-2 text-center">
            <p>음식여부</p>
          </div>
          <div class="col-md-2">
            <select class="form-control" name="food" id="food">
             <option value="1">예</option>
             <option value="0">아니</option>
            </select>
          </div>
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>사용유무</p>
          </div>
          <div class="col-md-2">
            <select class="form-control" name="use" id="use">
             <option value="1">사용</option>
             <option value="0">중지</option>
            </select>
          </div>
        </div>
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>이미지</p>
          </div>
          <div class="col-md-2">
            <input type="file" name="image">
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <input type="submit" class="btn btn-primary" name="" value="저장">
            <input type="reset"  class="btn btn-secondary" name="" value="취소">
          </div>
        </div>
      </form>
        <div class="row my-4">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>HS</th>
                      <th>영문 품목명</th>
                      <th>한글 품목명</th>
                      <th>중국 품목명</th>
                      <th>관세율</th>
                      <th>부가세율</th>
                      <th>일반통관</th>
                      <th>음식여부</th>
                      <th>사용여부</th>
                      <th>이미지</th>
                      <th>수정/삭제</th>
                    </tr>
                    <?php
                    if(!empty($childCat))
                    {
                        foreach($childCat as $record)
                        {
                    ?>
                    <tr>
                      <td><?php echo $ss ?></td>
                      <td><?=$record->en_subject?></td>
                      <td><?=$record->kr_subject?></td>
                      <td><?=$record->chn_subject?></td>
                      <td><?=$record->tariff_rate?></td>
                      <td><?=$record->vat_rate?></td>
                      <td><?=$record->general_customs==1 ? "일반통관":""?></td>
                      <td><?=$record->food ==1 ? "음식":"" ?></td>
                      <td><?= $record->use==1 ?"사용":"중지" ?></td>
                      <td>
                      <?php if(!empty($record->image)): ?>
                        <img src="/upload/cat/<?=$record->id?>/<?=$record->image?>" width="100">
                      <?php endif; ?></td>
                      <td class="text-center">
                        <a class="btn btn-sm btn-info editCat" href="JavaScript:void(0)" data-id="<?php echo $record->id; ?>"><i class="fa fa-pencil"></i></a>
                        <a class="btn btn-sm btn-danger deleteCat" href="#" data-catid="<?php echo $record->id; ?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <?php
                    $ss = $ss-1;
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">카테고리 정보</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form name="frmPopCate" id="frmPopCate" method="post">
          <input type="hidden" name="sKind" id="sKind" value="A">
          <input type="hidden" name="CATE_SEQ" id="CATE_SEQ" value="0">
          <input type="hidden" name="PARENT_CATE" id="PARENT_CATE" value="">

            <table class="order_write order_table_top">
        <colgroup>
          <col width="15%"><col width="35%">
          <col width="15%"><col width="35%">
        </colgroup> 

        <tbody><tr>
          <th>부모 카테고리</th>
          <td><span class="bold">최상위 카테고리</span></td> 
          <th>카테고리 명</th>
          <td><input type="text" name="CATE_NM" id="CATE_NM" maxlength="100" style="width: 70%;" class="input_txt2" value=""></td> 
        </tr>

        <tr>
          <th>사용여부</th>
          <td colspan="3">
            <select name="USE_YN" id="USE_YN">
              <option value="Y">사용</option>
              <option value="N">중지</option>
            </select>
          </td>
        </tr>
        </tbody></table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="javascript:fnPopCateReg()">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  jQuery(document).ready(function(){
    jQuery("#parent").change(function(){
      location.href = "/admin/childCat?category="+$(this).val();
    });

    jQuery(document).on("click", ".editCat", function(){
      var id = $(this).data("id"); 
      var hitURL = baseURL + "getCat";
      $("#CATE_SEQ").val(2);
        jQuery.ajax({
        type : "POST",
        dataType : "json",
        url : hitURL,
        data : { id : id } 
        }).done(function(data){
          $("#kr_subject").val(data[0]['kr_subject']);
          $("#en_subject").val(data[0]['en_subject']);
          $("#chn_subject").val(data[0]['chn_subject']);
          $("#hs_code").val(data[0]['hs_code']);
          $("#vat_rate").val(data[0]['vat_rate']);
          $("#tariff_rate").val(data[0]['tariff_rate']);
          $("#parent").val(data[0]['parent']);
          $("#general_customs").val(data[0]['general_customs']);
          $("#food").val(data[0]['food']);
          $("#use").val(data[0]['use']);
          $("#id").val(id);
        });
    });

    jQuery(document).on("click", ".deleteCat", function(){
      var id = $(this).data("catid"); 
      var hitURL = baseURL + "deleteCat";
      var ok = confirm("정말 삭제하시겠습니까?");
      if(ok == true){
        $("#CATE_SEQ").val(2);
        jQuery.ajax({
          type : "POST",
          dataType : "json",
          url : hitURL,
          data : { cat : id } 
        }).done(function(data){
          location.reload();
        });
      }
    });
});
</script>