<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          적용환율  
      </h1>
    </section>
    <section class="content">
        <form action="./saveAccurRate" method="post">
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>제목</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="title" class="form-control"  required maxlength="50">
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>환율</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="rate" class="form-control"  required maxlength="10">    
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
                      <th>환율</th>
                      <th>등록일</th>
                      <th></th>
                    </tr>
                    <?php if(!empty($accuringRate)): 
                            foreach($accuringRate as $value): ?>
                        <tr>
                          <td><?=$value->title?></td>
                          <td><?=$value->rate?></td>
                          <td><?=$value->created_date?></td>
                          <td><a href="#" data-id="<?=$value->id?>" class="btn btn-danger btn-sm deleteAcc">삭제</a></td>
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
  jQuery(document).on("click", ".deleteAcc", function(){
    var id = $(this).data("id"),
      hitURL = baseURL + "deleteAcc",
      currentRow = $(this);
    
    var confirmation = confirm("입금계좌를 삭제하시겠습니까?");
    
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
</script>