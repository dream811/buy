<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          배송지주소관리
      </h1>
    </section>
    <section class="content">
      <?php echo form_open_multipart('updateDelA');?>
      <div class="row my-3">
        <div class="col-md-2 text-center">
          <p>지사코드</p>
        </div>
        <div class="col-md-4">
          <input type="text" name="area_code" id="area_code" class="form-control" required>
          <input type="hidden" name="id" id="ids">
        </div>
        <div class="col-md-2 text-center">
          <p>지사명</p>
        </div>
        <div class="col-md-4">
          <input type="text" name="area_name" id="area_name" class="form-control" required>    
        </div>
      </div>
      <div class="row my-3">
        <div class="col-md-2 text-center">
          <p>First Name</p>
        </div>
        <div class="col-md-4">
          <input type="text" name="firstName" id="firstName" class="form-control" required>
        </div>
        <div class="col-md-2 text-center">
          <p>Last Name</p>
        </div>
        <div class="col-md-4">
          <input type="text" name="lastName" id="lastName" class="form-control" required>    
        </div>
      </div>
      <div class="row my-3">
        <div class="col-md-2 text-center">
          <p>주소</p>
        </div>
        <div class="col-md-4">
          <input type="text" name="address" id="address" class="form-control" required>
        </div>
        <div class="col-md-2 text-center">
          <p>사서함</p>
        </div>
        <div class="col-md-4">
          <input type="text" name="mailbox" id="mailbox" class="form-control">    
        </div>
      </div>
      <div class="row my-3">
        <div class="col-md-2 text-center">
          <p>City </p>
        </div>
        <div class="col-md-4">
          <input type="text" name="city" id="city" class="form-control" required>
        </div>
        <div class="col-md-2 text-center">
          <p>STATE</p>
        </div>
        <div class="col-md-4">
          <input type="text" name="state" id="state" class="form-control" required>    
        </div>
      </div>
      <div class="row my-3">
        <div class="col-md-2 text-center">
          <p>우편번호</p>
        </div>
        <div class="col-md-4">
          <input type="text" name="postNum" id="postNum" class="form-control" required>
        </div>
        <div class="col-md-2 text-center">
          <p>전화번호</p>
        </div>
        <div class="col-md-4">
          <input type="text" name="phoneNum" id="phoneNum" class="form-control" required>    
        </div>
      </div>
      <div class="row my-3">
        <div class="col-md-2 text-center">
          <p>센터 수수료</p>
        </div>
        <div class="col-md-4">
          <input type="text" name="fee" id="fee" class="form-control" required>
        </div>
        <div class="col-md-2 text-center">
          <p>사용유무</p>
        </div>
        <div class="col-md-4">
          <label>사용 <input type="radio" name="use" id="use1" value="1"></label>
          <label>미사용 <input type="radio" name="use" id="use2" value="0"></label>
        </div>
      </div>
      <div class="row my-3">
          <div class="col-md-2 text-center"><p>내용</p></div>
          <div class="col-md-4">
            <input type="text" name="comment" id="comment" maxlength="60" class="form-control" value="">
          </div>
          <div class="col-md-2 text-center"><p>이미지</p></div>
          <div class="col-md-4">
            <input type="file" name="image" id="image" maxlength="60" class="form-control" value="">
          </div>
      </div>
      <div class="row my-3">
          <div class="col-md-2 text-center">
              <input type="submit" class="btn btn-primary" value="저장">
              <a href="" class="btn">취소</a>
          </div>
      </div>
    </form>
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr class="thead-dark">
                  <th>지사</th>
                  <th>지사명</th>
                  <th>City</th>
                  <th>Address</th>
                  <th>Tel</th>
                  <th>수수료</th>
                  <th>사용유무</th>
                  <th>수정/삭제</th>
                </tr>
                <?php foreach($daddress as $value): ?>
                    <tr>
                      <td><?=$value->area_code?></td>
                      <td><?=$value->area_name?></td>
                      <td><?=$value->city?></td>
                      <td><?=$value->address?></td>
                      <td><?=$value->phoneNum?></td>
                      <td><?=$value->fee?></td>
                      <td><?=$value->use==1 ? "사용":"중지" ?></td>
                      <td><a class="btn btn-sm btn-info updateDelA" href="#" data-dela="<?=$value->id?>"><i class="fa fa-pencil"></i></a>
                      <a class="btn btn-sm btn-danger deleteDelA" href="#" data-dela="<?=$value->id?>"><i class="fa fa-trash"></i></a></td>
                </tr>
                <?php endforeach; ?>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
    </div>
</section>
</div>

<script type="text/javascript">
  jQuery(document).on("click", ".updateDelA", function(){
    var delA = $(this).data("dela"),
      hitURL = baseURL + "getDelA";
      
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { delA : delA } 
      }).done(function(data){
        if(data.length > 0){
          $("#ids").val(data[0].id);
          $("#area_code").val(data[0].area_code);
          $("#firstName").val(data[0].firstName);
          $("#lastName").val(data[0].lastName);
          $("#area_name ").val(data[0].area_name);
          $("#address").val(data[0].address);
          $("#mailbox").val(data[0].mailbox);
          $("#city").val(data[0].city);
          $("#state").val(data[0].state);
          $("#postNum").val(data[0].postNum);
          $("#phoneNum").val(data[0].phoneNum);
          $("#comment").val(data[0].comment);
          $("#fee").val(data[0].fee);
          if(data[0].use ==1 ) {$("#use1").prop('checked', true);$("#use2").prop('checked', false);}
          else {$("#use2").prop('checked', true);$("#use1").prop('checked', false);}
        }
      });
  });
  jQuery(document).on("click", ".deleteDelA", function(){
    var dela = $(this).data("dela"),
      hitURL = baseURL + "deleteDt",
      currentRow = $(this);
    
    var confirmation = confirm("삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { dela : dela} 
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