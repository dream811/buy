<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          쇼핑몰복사사이트관리
      </h1>
    </section>
    <section class="content">

        <form action="./saveShoppingMal" method="post">
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>쇼핑몰 코드</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="shop_code" id="shop_code" class="form-control" required>
              <input type="hidden" name="id" id="ids">
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>명칭</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="name" id="name" class="form-control" required>    
            </div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center"><p>쇼핑몰 URL</p></div>
              <div class="col-md-4">
                <input type="text" name="url" id="url"  class="form-control" required>
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
                      <th>쇼핑몰 코드</th>
                      <th>쇼핑몰 이름  </th>
                      <th>쇼핑몰 URL </th>
                      <th>사용유무</th>
                      <th>수정/삭제</th>
                    </tr>
                    <?php foreach($shoppingmal as $value): ?>
                        <tr>
                          <td><?=$value->id?></td>
                          <td><?=$value->shop_code?></td>
                          <td><?=$value->name?></td>
                          <td><?=$value->url?></td>
                          <td><?=$value->use==1 ?"Y":"N"?></td>
                          <td><a class="btn btn-sm btn-info editShoppingmal" data-shopid="<?=$value->id?>" href="#"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteShoppingmal" href="#" data-shopid="<?=$value->id?>" ><i class="fa fa-trash"></i></a></td>
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
  jQuery(document).on("click", ".editShoppingmal", function(){
    var shopid = $(this).data("shopid"),
      hitURL = baseURL + "getShopping";
      
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { shopid : shopid } 
      }).done(function(data){
        if(data.length > 0){
          $("#ids").val(data[0].id);
          $("#shop_code").val(data[0].shop_code);
          $("#url").val(data[0].url);
          $("#name").val(data[0].name);
          $("#use").val(data[0].use);
        }
      });
  });
  jQuery(document).on("click", ".deleteShoppingmal", function(){
    var shopid = $(this).data("shopid"),
      hitURL = baseURL + "deleteShop",
      currentRow = $(this);
    
    var confirmation = confirm("정말 삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { shopid : shopid} 
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