<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          택배 관리  
      </h1>
    </section>
    <section class="content">
        <?php echo form_open_multipart('addSends');?>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>제목</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="name" class="form-control"  required id="name">
              <input type="hidden" name="id" class="form-control" id="ids">
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>이미지</p>
            </div>
            <div class="col-md-2">
              <input type="file" name="image" class="form-control" >
            </div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center">
                  <input type="submit" class="btn btn-primary" value="저장">
                  <input type="reset" class="btn" value="취소">
              </div>
          </div>
        </form>
        <div class="row">
            <div class="col-xs-8">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>제목</th>
                      <th>이미지</th>
                      <th></th>
                    </tr>
                    <?php if(!empty($send_management)): 
                            foreach($send_management as $value): ?>
                        <tr>
                          <td><?=$value->name?></td>
                          <td>
                            <?php if(!empty($value->image)): ?>
                            <img src="<?=base_url_home()?>upload/income/<?=$value->image?>" width=100>
                            <?php endif;?>  
                          </td>
                          <td>
                            <a href="#" data-id="<?=$value->id?>" class="btn btn-primary btn-sm editAddress">편집</a>
                            <a href="#" data-id="<?=$value->id?>" class="btn btn-danger btn-sm deleteSend">삭제</a>
                          </td>
                        </tr>
                    <?php endforeach;
                        endif; ?>    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
  jQuery(document).on("click", ".deleteSend", function(){
    var id = $(this).data("id"),
      hitURL = baseURL + "deleteSend",
      currentRow = $(this);
    
    var confirmation = confirm("해당 수입방식을 삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { id : id } 
      }).done(function(data){
        console.log(data);
        currentRow.parents('tr').remove();
        if(data == 1) { alert("성공적으로 삭제되였습니다."); }
        else if(data != 1) { alert("삭제 실패"); }
        else { alert("Access denied..!"); }
      });
    }
  });
  jQuery(document).on("click", ".editAddress", function(){
    var id = $(this).data("id"),
      hitURL = baseURL + "editAddress",
      currentRow = $(this);
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { id : id } 
      }).done(function(data){
        if(data.length > 0 ){
          $("#ids").val(data[0].id);
          $("#name").val(data[0].name);
        }
      });
  });
</script>