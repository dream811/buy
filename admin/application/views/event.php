<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          이벤트
      </h1>
    </section>
    <section class="content">
        <div class="row">
          <div class="col-md-6">
            <?php echo form_open_multipart('saveEvent');?>
              <div class="row my-3">
                <div class="col-md-2 text-center">
                  <p>제목</p>
                </div>
                <div class="col-md-10">
                  <input type="text" name="title" class="form-control" id="title" required>
                  <input type="hidden" name="id" class="form-control" id="ids">
                </div>
              </div>
              <div class="row my-3">
                <div class="col-md-2 text-center">
                  <p>설명</p>
                </div>
                <div class="col-md-10">
                  <input type="text" name="description" id="description" class="form-control" required>    
                </div>
              </div>
              <div class="row my-3">
                  <div class="col-md-2 text-center"><p>썸네일 이미지 (size 388*149)</p></div>
                  <div class="col-md-4"><input type="file" class="form-control" name="image" id="image"></div>
              </div>
              <div class="row my-3">
                <div class="col-md-2 text-center">
                  <p>링크 URL</p>
                </div>
                <div class="col-md-10">
                  <input type="text" name="link" class="form-control" id="link" required>    
                </div>
              </div>
              <div class="row my-3">
                <div class="col-md-2 text-center">
                  <p>사용유무</p>
                </div>
                <div class="col-md-2">
                  <select name="use" id="use" class="form-control">
                    <option value="1">사용
                    </option><option value="0">사용안함
                  </option></select>  
                </div>
                <div class="col-md-2 text-center">
                  <p>이벤트 기간</p>
                </div>
                <div class="col-md-6">
                  <input type="date" class="" name="terms1" required id="terms1"> ~ 
                  <input type="date" class="" name="terms2" required id="terms2"> 
                </div>
              </div>
              <div class="row my-3">
                  <div class="col-md-2 text-center">
                      <input type="submit" class="btn btn-primary" value="저장">
                      <input type="reset" class="btn" value="취소">
                  </div>
              </div>
            </form>
          </div>
          <div class="col-md-2">
            <?php echo form_open_multipart('saveEventHomepage');?>
              <div><p>이벤트 이미지</p></div>
              <div class="">
                <input type="file" class="form-control" name="image_event" id="image">
                <input type="text" class="form-control" name="link" id="link" placeholder="주소" value="<?=!empty($eventhome) ? $eventhome[0]->link:""?>">
                <select name="use" class="form-control">
                  <option value="1" <?=!empty($eventhome) && $eventhome[0]->use==1 ? "selected":""?>>사용</option>
                  <option value="0" <?=!empty($eventhome) && $eventhome[0]->use==0 ? "selected":""?>>미사용</option>
                </select>
              </div>
              <input type="submit" class="btn btn-primary my-4" value="저장">
              <input type="reset" class="btn my-4" value="취소">
            </form> 
          </div>
          <div class="col-md-4">
            <?php if(!empty($eventhome)): ?>  <img src="../upload/event/<?=$eventhome[0]->image?>" class="w-100"><?php endif; ?>
          </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>이미지</th>
                      <th>내용/설명 </th>
                      <th>시작일|종료일 </th>
                      <th>진행상태</th>
                      <th>사용유무</th>
                      <th>수정/삭제</th>
                      <?php if(!empty($event)): ?>
                        <?php foreach($event as $value): ?>
                          <tr>
                            <th>
                              <img src="/upload/homepage/event/<?=$value->image?>" border="0" width="100"></th>
                            <th><?=$value->description?></th>
                            <th><?=$value->terms?></th>
                            <th><?php
                             if(explode("|",$value->terms)[0] <= date("Y-m-d") &&
                              explode("|",$value->terms)[1] >= date("Y-m-d") ){ echo "진행중";} else echo '종료';
                            ?>
                              </th>
                            <th><?=$value->use==1 ? "사용":""?></th>
                            <th class="text-center">
                              <a class="btn btn-sm btn-info editEvent" href="#" data-event="<?=$value->id?>"><i class="fa fa-pencil"></i></a>
                              <a class="btn btn-sm btn-danger deleteEvent" href="#" data-event="<?=$value->id?>"><i class="fa fa-trash"></i></a>
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
  jQuery(document).on("click", ".editEvent", function(){
    var event = $(this).data("event"),
      hitURL = baseURL + "getEvent";
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { event : event } 
      }).done(function(data){
        if(data.length > 0){
          $("#description").val(data[0].description);
          $("#link").val(data[0].link);
          $("#use").val(data[0].use);
          $("#terms1").val(data[0].terms.split("|")[0]);
          $("#terms2").val(data[0].terms.split("|")[1]);
          $("#title").val(data[0].title);
          $("#ids").val(data[0].id);
        }
      });
  });
  jQuery(document).on("click", ".deleteEvent", function(){
    var event = $(this).data("event"),
      hitURL = baseURL + "deleteEvent",
      currentRow = $(this);
    
    var confirmation = confirm("정말 삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { event : event} 
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