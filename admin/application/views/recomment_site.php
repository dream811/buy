<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          추천사이트관리
      </h1>
    </section>
    <section class="content">
        <?php echo form_open_multipart('saveRecommend');?>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>제목</p>
            </div>
            <div class="col-md-8">
              <input type="text" name="title" class="form-control" id="title">
              <input type="hidden" name="id" class="form-control" id="ids">
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>설명</p>
            </div>
            <div class="col-md-8">
              <input type="text" name="content" class="form-control" required id="content">    
            </div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center"><p>이미지</p></div>
              <div class="col-md-4"><input type="file" class="form-control" name="image" id="image"></div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>링크 URL   </p>
            </div>
            <div class="col-md-8">
              <input type="text" name="link" class="form-control" id="link">    
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>추천여부</p>
            </div>
            <div class="col-md-2">
              <select name="recommend" id="recommend" class="form-control">
                <option value="1">예
                </option><option value="0">아니
              </option></select>  
            </div>
            <div class="col-md-2 text-center">
              <p>사용유무</p>
            </div>
            <div class="col-md-2">
              <select name="use" id="use" class="form-control">
                <option value="1">사용
                </option><option value="0">사용안함
              </option></select>  
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
                      <th>사이트명</th>
                      <th>이미지</th>
                      <th>URL</th>
                      <th>추천</th>
                      <th>사용</th>
                      <th>수정/삭제</th>
                      <?php if(!empty($recomment_site)): ?>
                        <?php foreach($recomment_site as $value): ?>
                          <tr>
                            <th><?=$value->title?></th>
                            <th>
                              <a href="<?=$value->link?>" target="blink"><img src="/upload/homepage/recommend/<?=$value->image?>" 
                              border="0" width="94" height="32"></a>
                            </th>
                            <th><?=$value->link?></th>
                            <th><?=$value->recommend==1 ? "추천":""?></th>
                            <th><?=$value->use==1 ? "사용":""?></th>
                            <th class="text-center">
                              <a class="btn btn-sm btn-info editRecommend" href="#" data-recommend="<?php echo $value->id; ?>"><i class="fa fa-pencil"></i></a>
                              <a class="btn btn-sm btn-danger deleteRecommend" href="#" data-recommend="<?php echo $value->id; ?>"><i class="fa fa-trash"></i></a>
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
  jQuery(document).on("click", ".editRecommend", function(){
    var recommend = $(this).data("recommend"),
      hitURL = baseURL + "editRecommend";
      
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { recommend : recommend } 
      }).done(function(data){
        if(data.length > 0){
          $("#title").val(data[0].title);
          $("#content").val(data[0].content);
          $("#link").val(data[0].link);
          $("#recommend").val(data[0].recommend);
          $("#use").val(data[0].use);
          $("#ids").val(data[0].id);
        }
      });
  });
  jQuery(document).on("click", ".deleteRecommend", function(){
    var recommend = $(this).data("recommend"),
      hitURL = baseURL + "deleteRecommend",
      currentRow = $(this);
    
    var confirmation = confirm("정말 삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { recommend : recommend} 
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