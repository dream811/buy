<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          추천상품
      </h1>
    </section>
    <section class="content">
        <?php echo form_open_multipart('saveRecommentProduct');?>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>제목</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="title" class="form-control" id="title" required>
              <input type="hidden" name="id"  id="ids">
            </div>
            <div class="col-md-1 text-center">
              <p>사이즈</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="size_w" id="size_w" required> * <input type="text" name="size_h" id="size_h" required>
            </div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center"><p>이미지</p></div>
              <div class="col-md-4"><input type="file" class="form-control" name="image" id="image"></div>
              <div class="col-md-1 text-center"><p>할인율</p></div>
              <div class="col-md-2"><input type="text" class="form-control" name="halin_rate" 
                id="halin_rate" placeholder="%" required></div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>할인전 가격</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="halin_price" class="form-control" id="halin_price">
            </div>
            <div class="col-md-1 text-center">
              <p>할인후 가격</p>
            </div>
            <div class="col-md-2">
              <input type="text" name="price" class="form-control" id="price">
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center"><p>링크 URL</p></div>
            <div class="col-md-8"><input type="text" name="link" class="form-control" id="link" required></div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center"><p>내용</p></div>
            <div class="col-md-8"><input type="text" name="content" class="form-control" required id="content"></div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>링크타겟</p>
            </div>
            <div class="col-md-2">
              <select name="target" id="target" class="form-control">
                <option value="1">자신</option>
                <option value="0">새창</option>
              </select>
            </div>
            <div class="col-md-2 text-center"></div>
            <div class="col-md-1 text-center"><p>사용유무</p></div>
            <div class="col-md-2">
              <select name="use" id="use" class="form-control">
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
                      <th>이미지</th>
                      <th>URL</th>
                      <th>사이즈</th>
                      <th>사용유무</th>
                      <th>수정/삭제</th>
                      <?php if(!empty($recomment_products)): ?>
                        <?php foreach($recomment_products as $value): ?>
                          <tr>
                            <th>
                              <img src="/upload/homepage/recommendPro/<?=$value->image?>" border="0" width="100"></th>
                            <th><?=$value->link?></th>
                            <th><?=$value->size_w?>*<?=$value->size_h?></th>
                            <th><?=$value->use==1 ? "사용":""?></th>
                            <th class="text-center">
                              <a class="btn btn-sm btn-info editRecomP" href="#" data-rep="<?php echo $value->id; ?>"><i class="fa fa-pencil"></i></a>
                              <a class="btn btn-sm btn-danger deleteRecomP" href="#" data-rep="<?php echo $value->id; ?>"><i class="fa fa-trash"></i></a>
                          </th>
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
  jQuery(document).on("click", ".editRecomP", function(){
    var rep = $(this).data("rep"),
      hitURL = baseURL + "editRecomP";
      
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { rep : rep } 
      }).done(function(data){
        if(data.length > 0){
          $("#title").val(data[0].title);
          $("#size_w").val(data[0].size_w);
          $("#size_h").val(data[0].size_h);
          $("#halin_price").val(data[0].halin_price);
           $("#price").val(data[0].price);
          $("#halin_rate").val(data[0].halin_rate);
          $("#link").val(data[0].link);
          $("#content").val(data[0].content);
          $("#target").val(data[0].target);
          $("#use").val(data[0].use);
          $("#ids").val(data[0].id);
        }
      });
  });
  jQuery(document).on("click", ".deleteRecomP", function(){
    var rep = $(this).data("rep"),
      hitURL = baseURL + "deleteRecomP",
      currentRow = $(this);
    
    var confirmation = confirm("정말 삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { rep : rep} 
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