<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          기타배너관리
      </h1>
    </section>
    <section class="content">
        <div class="row clearfix my-3">
          <div class="col-md-1 onepadding p-1">
            <a href="<?=base_url()?>banner_s?type=2" class="btn btn-primary w-100">이용안내#1</a>
          </div>
          <div class="col-md-1 onepadding p-1">
            <a href="<?=base_url()?>banner_s?type=10" class="btn btn-primary w-100">배송/구매 신청</a>
          </div>
          <div class="col-md-1 onepadding p-1">
            <a href="<?=base_url()?>banner_s?type=11" class="btn btn-primary w-100">결제/예치금 배너</a>
          </div>
          <div class="col-md-1 onepadding p-1">
            <a href="<?=base_url()?>banner_s?type=12" class="btn btn-primary w-100">배송/구매 절차</a>
          </div>
          <div class="col-md-1 onepadding p-1">
            <a href="<?=base_url()?>banner_s?type=13" class="btn btn-primary w-100">고객센터 안내</a>
          </div>
          <div class="col-md-1 onepadding p-1">
            <a href="<?=base_url()?>banner_s?type=14" class="btn btn-primary w-100">입금계좌 안내</a>
          </div>
          <div class="col-md-1 onepadding p-1">
            <a href="<?=base_url()?>banner_s?type=15" class="btn btn-primary w-100">블로그/카페</a>
          </div>
          <div class="col-md-1 onepadding p-1">
            <a href="<?=base_url()?>banner_s?type=16" class="btn btn-primary w-100">왼쪽 메뉴</a>
          </div>
          <div class="col-md-1 onepadding p-1">
            <a href="<?=base_url()?>banner_s?type=17" class="btn btn-primary w-100">오른쪽 메뉴</a>
          </div>
          <div class="col-md-1 onepadding p-1">
            <a href="<?=base_url()?>banner_s?type=18" class="btn btn-primary w-100">모바일 메뉴</a>
          </div>
          <div class="col-md-1 onepadding p-1">
            <a href="<?=base_url()?>banner_s?type=19" class="btn btn-primary w-100">모바일 Footer메뉴</a>
          </div>
        </div>
        <?php echo form_open_multipart('saveBannerR');?>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>설명</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="description" class="form-control" id="description">
              <input type="hidden" name="id" class="form-control" id="ids">
              <input type="hidden" name="type" class="form-control" value="<?=$this->input->get("type")?>">
            </div>
            <div class="col-md-2 text-center">
              <p>사이즈</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="size_w" id="size_w" required>*<input type="text" name="size_h" id="size_h" required>
            </div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center"><p>이미지</p></div>
              <div class="col-md-4">
                <input type="file" class="form-control" name="image" id="image">
              </div>
              <div class="col-md-2 text-center"><p>우아래간격</p></div>
              <div class="col-md-4">
                <input type="text" name="mt" placeholder="Margin Top" value="0" id="mt" required>
                <input type="text" name="mb" placeholder="Margin bottom" value="0" id="mb" required>
              </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>링크 URL</p>
            </div>
            <div class="col-md-8">
              <input type="text" name="link" class="form-control" id="link" required>    
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
          <?php if($this->input->get("type")==18 || $this->input->get("type")==17): ?>
            <div class="my-3">
              <div class="col-md-2 text-center"><p>Hover 이미지</p></div>
                <div class="col-md-4">
                  <input type="file" class="form-control" name="image1" id="image1">
                </div>
            </div>
          <?php endif; ?>
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
                      <?php if($this->input->get("type")==18): ?>
                        <th>Hover 이미지</th>
                      <?php endif; ?>
                      <th>URL</th>
                      <th>사이즈 </th>
                      <th>사용유무</th>
                      <th></th>
                    </tr>
                    <tbody class="wrap">  
                      <?php if(!empty($banner_s)): ?>
                        <?php foreach($banner_s  as $value): ?>
                          <tr data-id="<?=$value->id?>" class="wrap_tr mid">
                            <th><img src="/upload/homepage/banner_r/<?=$value->image?>" width="60" border="0"></th>
                            <?php if($this->input->get("type")==18 || $this->input->get("type")==17): ?>
                               <th><img src="/upload/homepage/banner_r/<?=$value->image1?>" width="60" border="0"></th>
                            <?php endif; ?>
                            <th class="mid"><?=$value->link?></th>
                            <th class="mid"><?=$value->size_w?>*<?=$value->size_h?></th>
                            <th class="mid"><?=$value->use==1 ? "사용":""?></th>
                            <td class="text-center mid">
                              <a class="btn btn-sm btn-info editBanner" href="#" data-banner="<?=$value->id?>"><i class="fa fa-pencil"></i></a>
                              <a class="btn btn-sm btn-danger deleteBanner" href="#" data-banner="<?=$value->id?>"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                        <?php endforeach; ?>  
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script type="text/javascript">
  jQuery(document).on("click", ".editBanner", function(){
    var banner = $(this).data("banner"),
      hitURL = baseURL + "getBanner";
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { banner : banner } 
      }).done(function(data){
        if(data.length > 0){
          $("#description").val(data[0].description);
          $("#link").val(data[0].link);
          $("#use").val(data[0].use);
          $("#target").val(data[0].target);
          $("#size_w").val(data[0].size_w);
          $("#size_h").val(data[0].size_h);
          $("#ids").val(data[0].id);
          $("#mt").val(data[0].mt);
          $("#mb").val(data[0].mb);
        }
      });
  });
  jQuery(document).on("click", ".deleteBanner", function(){
    var banner = $(this).data("banner"),
      hitURL = baseURL + "deleteBanner",
      currentRow = $(this);
    
    var confirmation = confirm("정말 삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { banner : banner} 
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