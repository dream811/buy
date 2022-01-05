<?php 
if($this->input->get("mobile") ==1)
  $l = base_url_home();
else
  $l = base_url_source();

$params = $_SERVER['QUERY_STRING']; 

$width = "";


?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          <?=$type=="shop_banner" ? "쇼핑몰":""?> 배너관리 
          
      </h1>
    </section>
    <section class="content">
        <?php echo form_open_multipart('saveBanner');?>
          <div class="row my-3">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <a class=" btn-sm btn btn-primary" href="<?=base_url($type)?>">PC 배너</a>
              <?php if($type=="shop_banner"): ?>
                <a class="btn-sm btn btn-primary" href="<?=base_url($type)?>?type=24">사이트 우측 배너</a>
              <?php endif; ?>
              <a class=" btn-sm btn btn-primary" href="<?=base_url($type)?>?mobile=1">모바일 배너</a>
              <a class=" btn-sm btn btn-primary" href="<?=base_url($type)?>?type=25&mobile=1">모바일 중간메뉴</a>
              <a class=" btn-sm btn btn-primary" href="<?=base_url($type)?>?type=26&mobile=1">모바일 중간배너</a>
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>제목  </p>
            </div>
            <div class="col-md-8">
              <input type="text" name="title" class="form-control" id="title" required>
              <input type="hidden" name="id" class="form-control" id="ids">
              <input type="hidden" name="mobile" class="form-control" value="<?=$mobile?>">
              <input type="hidden" name="redirect_url" class="form-control" value="<?=current_url() . '?' . $params?>" >
              <input type="hidden" name="type" class="form-control" value="<?=$banner_type?>" >
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>1줄 설명  </p>
            </div>
            <div class="col-md-8">
              <input type="text" name="description" class="form-control" id="description">    
            </div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center"><p>이미지<?=$width?></p></div>
              <div class="col-md-4">
                <input type="file" class="form-control" name="image" id="image">
              </div>
          </div>
          <?php if($banner_type==24 || $banner_type ==17 || $banner_type==25): ?>
            <div class="row my-3">
              <div class="col-md-2 text-center"><p>Hover 이미지<?=$width?></p></div>
                <div class="col-md-4">
                  <input type="file" class="form-control" name="image1" id="image1">
                </div>
          </div>
          <?php endif; ?>
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
              <p>사용유무</p>
            </div>
            <div class="col-md-2">
              <select name="use" id="use" class="form-control">
                <option value="1">사용</option>
                <option value="0">사용안함</option>
              </select>  
            </div>
            <div class="col-md-2 text-center">
              <p>링크타겟    </p>
            </div>
            <div class="col-md-2">
              <select name="target" id="target" class="form-control">
                  <option value="1">자신</option>
                  <option value="2">새창</option>
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
                    <thead class="thead-dark ">
                      <th>이미지</th>
                      <?php if($banner_type==24): ?>
                        <th>HOVER 이미지</th>
                      <?php endif; ?>
                      <th>제목</th>
                      <th>타겟</th>
                      <th>사용유무</th>
                      <th></th>
                    </thead>
                      <?php if(!empty($banner)): ?>
                        <tbody class="wrap">
                        <?php foreach($banner as $value): ?>
                          <tr class="wrap_tr" data-id="<?=$value->id?>">
                            <td><img src="<?=$l?>upload/homepage/banner/<?=$value->image?>" border="0" width="50"></td>
                            <?php if($banner_type==24): ?>
                             <td><img src="<?=$l?>upload/homepage/banner/<?=$value->image1?>" border="0" width="50"></td> 
                            <?php endif; ?>
                            <td class="mid"><?=$value->title?></td>
                            <td class="mid"><?=$value->target==1 ? "자신":"새창"?></td>
                            <td class="mid"><?=$value->use==1 ? "사용":""?></td>
                            <td class="text-center mid">
                              <a class="btn btn-sm btn-info editHomepage" data-home="<?=$value->id?>"><i class="fa fa-pencil"></i></a>
                              <a class="btn btn-sm btn-danger deleteHomepage" href="#" data-home="<?=$value->id?>"><i class="fa fa-trash"></i></a>
                          </td>
                          </tr>
                        <?php endforeach; ?>  
                        </tbody>
                      <?php endif; ?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script type="text/javascript">
  jQuery(document).on("click", ".editHomepage", function(){
    var home = $(this).data("home"),
      hitURL = baseURL + "getHome";
      
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { home : home } 
      }).done(function(data){
        if(data.length > 0){
          $("#description").val(data[0].description);
          $("#link").val(data[0].link);
          $("#use").val(data[0].use);
          $("#target").val(data[0].target);
          $("#title").val(data[0].title);
          $("#ids").val(data[0].id);
        }
      });
  });
  jQuery(document).on("click", ".deleteHomepage", function(){
    var home = $(this).data("home"),
      hitURL = baseURL + "deleteHome",
      currentRow = $(this);
    
    var confirmation = confirm("정말 삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { home : home} 
      }).done(function(data){
        console.log(data);
        currentRow.parents('tr').remove();
        if(data.status = true) { alert("성공적으로 삭제되였습니다."); }
        else if(data.status = false) { alert("삭제오유"); }
        else { alert("접근거절..!"); }
      });
    }
  });

  function showPop(){
    $("#exampleModal").modal("show");
    $("#CATE_NM").val("");
    $("#USE_YN").val("1");
    $("#CATE_SEQ").val(1);
  }
</script>

<script type="text/javascript">
  var hitURL =  baseURL + "updateOrderBanner";
  var art = new Array();
  $(".wrap").sortable({
  update: function(event, ui) {
    var wrap_tr = $(".wrap_tr");
    art = new Array();
     wrap_tr.each(function( index ) {
      art.push($(this).data("id"));
    }).promise().done( function(){ 
      jQuery.ajax({
      type : "POST",
      url : hitURL,
      data : { ids : art } 
      }).done(function(data){
        console.log(data);
      }).always(function(jqXHR, textStatus) {
        console.log(textStatus);
      });
    });
  }
});
</script>