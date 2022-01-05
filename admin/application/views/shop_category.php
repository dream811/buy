<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>쇼핑몰 카테고리</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-8 text-left">
                <div class="form-group">
                    <a class="btn btn-primary" data-toggle="modal" data-target="#details_modal"><i class="fa fa-plus"></i>새로 등록</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-8">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <thead class="thead-dark">
                      <tr>
                        <th>카테고리</th>
                        <th>이미지</th>
                        <th>상품 수</th>
                        <th>사용여부</th>
                        <th>등록일</th>
                        <th></th>
                      </tr>
                    </thead>
                    <?php
                    if(!empty($shop_category))
                    {
                        foreach($shop_category as $record)
                        {
                    ?>
                    <tr>
                      <td><?=$record->name ?></td>
                      <td><img src="/admin/upload/image/<?=$record->image ?>" width=50></td>
                      <td><?=$record->scount ?></td>
                      <td><?=$record->use==1 ? "사용":"미사용" ?></td>
                      <td>
                          <a class="btn btn-sm btn-info" href="javascript:shopCategory(<?php echo $record->id; ?>)"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteShopcategory" href="#" data-id="<?php echo $record->id; ?>">
                            <i class="fa fa-trash"></i>
                          </a>
                      </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" 
aria-hidden="true" id="details_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">카테고리 등록</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
          <?php echo form_open_multipart('createShopCategory');?>
          <div class="row">
            <div class="col-md-12">
              <label for="name"></label>
              <input type="text" name="name" class="form-control"  required>
            </div>
            <div class="col-md-12" style="margin-top: 10px">
              <label for="사용여부"></label>
              <select name="use" class="form-control">
                <option value="1">사용</option>
                <option value="0">미사용</option>
              </select>
            </div>
              <div class="col-xs-12" style="margin-top: 10px">
                <input type="file" name="image" class="form-control">
              </div>
            <div class="col-md-12" style="margin-top: 10px">
              <input type="submit" value="저장" class="btn btn-primary">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" 
aria-hidden="true" id="update_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">카테고리 등록</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
          <?php echo form_open_multipart('updateShopCategory');?>
          <div class="row">
            <div class="col-md-12">
              <label for="name"></label>
              <input type="text" name="name" class="form-control"  required id="name">
              <input type="hidden" name="id" class="form-control"  required id="id">
            </div>
            <div class="col-md-12" style="margin-top: 10px">
              <label for="사용여부"></label>
              <select name="use" class="form-control" id="use">
                <option value="1">사용</option>
                <option value="0">미사용</option>
              </select>
            </div>
              <div class="col-xs-12" style="margin-top: 10px">
                <input type="file" name="image" class="form-control">
              </div>
            <div class="col-md-12" style="margin-top: 10px">
              <input type="submit" value="저장" class="btn btn-primary">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  jQuery(document).on("click", ".deleteShopcategory", function(){
    var id = $(this).data("id"),
      hitURL = baseURL + "deleteShopcategory",
      currentRow = $(this);
    var confirmation = confirm("삭제하시겠습니까 ?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      url : hitURL,
      data : { id : id } 
      }).done(function(data){
        if(data==100){
          currentRow.parents('tr').remove();
        }
        else{
          alert("오류발생");
        }
      });
    }
  });
  function shopCategory(id){
    hitURL = baseURL + "getShops";
    jQuery.ajax({
      type : "POST",
      url : hitURL,
      dataType:'json',
      data : { id : id } 
    }).done(function(data){
      if(data.length > 0)
      {
        $("#name").val(data[0].name);
        $("#id").val(data[0].id);
        $("#use").val(data[0].use);
        $("#update_modal").modal("show");
      }
    });
  }
</script>