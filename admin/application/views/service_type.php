<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          부가서비스 종류
      </h1>
    </section>
    <section class="content">

        <form action="./saveServiceType" method="post">
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>네임</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="name" id="name" class="form-control" required>
              <input type="hidden" name="id" id="ids">
            </div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center"><p>사용유무</p></div>
              <div class="col-md-2">
                <select class="form-control" name="use" id="use">
                  <option value="1">사용</option>
                  <option value="0">사용안함</option>
                </select>
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
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>Seq</th>
                      <th>이름</th>
                      <th>사용유무</th>
                      <th>수정/삭제</th>
                    </tr>
                    <?php if(!empty($services)): ?>
                    <?php foreach($services as $value): ?>
                        <tr>
                          <td><?=$value->id?></td>
                          <td><?=$value->name?></td>
                          <td><?=$value->use==1 ?"Y":"N"?></td>
                          <td><a class="btn btn-sm btn-info editServiceType" data-id="<?=$value->id?>" href="#"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteServiceType" href="#" data-id="<?=$value->id?>" ><i class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
  jQuery(document).on("click", ".editServiceType", function(){
    var id = $(this).data("id"),
      hitURL = baseURL + "editServiceType";
      
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { id : id } 
      }).done(function(data){
        if(data.length > 0){
          $("#ids").val(data[0].id);
          $("#name").val(data[0].name);
          $("#use").val(data[0].use);
        }
      });
  });
  jQuery(document).on("click", ".deleteServiceType", function(){
    var id = $(this).data("id"),
      hitURL = baseURL + "deleteServiceType",
      currentRow = $(this);
    
    var confirmation = confirm("정말 삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { id : id} 
      }).done(function(data){
        console.log(data);
        currentRow.parents('tr').remove();
        if(data.status = true) { alert("성공적으로 삭제되였습니다."); }
        else if(data.status = false) { alert("삭제오유"); }
        else { alert("접근거절..!"); }
      });
    }
  });
</script>