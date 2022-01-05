<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          부가서비스 관리
      </h1>
    </section>
    <section class="content">

        <form action="/admin/saveService" method="post">
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>제목</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="name" id="name" class="form-control" required>
              <input type="hidden" name="id" id="ids">
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>가격</p>
            </div>
            <div class="col-md-2">
              <input type="text" name="price" id="price" class="form-control" required placeholder="원">    
            </div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center"><p>설명</p></div>
              <div class="col-md-4">
                <textarea id="description" name="description" class="form-control" style="height: 150px"></textarea>
              </div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center"><p>종류</p></div>
              <div class="col-md-2">
                <select class="form-control" name="part" id="part">
                  <option>=선택=</option>
                <?php if(!empty($service_type)): ?>
                  <?php foreach($service_type as $v): ?>
                    <option value="<?=$v->id?>"><?=$v->name?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
                </select>
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
                    <colgroup>
                      <col width="*">
                      <col width="*">
                      <col width="800px">
                    </colgroup>
                    <tr class="thead-dark">
                      <th>Seq</th>
                      <th>제목</th>
                      <th>설명</th>
                      <th>가격</th>
                      <th>종류</th>
                      <th>사용유무</th>
                      <th>수정</th>
                    </tr>
                     <?php if(!empty($services)): ?>
                    <?php foreach($services as $value): ?>
                        <tr>
                          <td><?=$value->id?></td>
                          <td><?=$value->name?></td>
                          <td><?=$value->description?></td>
                          <td><?=$value->price?></td>
                          <td><?=$value->ppart?></td>
                          <td><?=$value->use==1 ? "<span class='text-warning'>사용함</span>":"<span class='text-danger'>사용안함</span>"?></td>
                          <td><a class="btn btn-sm btn-info editService" data-id="<?=$value->id?>" href="javascript:void(0)">
                            <i class="fa fa-pencil"></i></a>
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
  jQuery(document).on("click", ".editService", function(){
    var id = $(this).data("id"),
      hitURL = baseURL + "editService";
      
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
          $("#price").val(data[0].price);
          $("#part").val(data[0].part);
          $("#description").val(data[0].description);
        }
      });
  });
  
</script>