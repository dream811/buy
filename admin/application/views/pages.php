<?php
$title = "";
$id =0;
$des = ""; 
$header= "";
$footer =0;
$my = ""; 

$banner =  "";
$event =  "";

if(!empty($content)):
foreach($content as $value):
$id = $value->id;
$des = $value->content;
$title = $value->title;
$header = $value->header;
$footer = $value->footer;
$my = $value->my;
$banner =  $value->banner;
$event =  $value->event;
endforeach;
endif;

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          페이지관리
      </h1>
    </section>
    <section class="content">
        <?php echo form_open_multipart('addPage');?>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>제목</p>
            </div>
            <div class="col-md-8">
              <input type="text" name="title" class="form-control" id="title" required value="<?=$title?>">
              <input type="hidden" name="id" class="form-control" id="ids" value="<?=$id?>">
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>내용</p>
            </div>
            <div class="col-md-8">
              <textarea id="editor" name="content" geditor class="form-control" style="height: 200px"><?=$des?></textarea>
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>노출될 페이지</p>
            </div>
            <div class="col-md-8">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" <?=$header==1 ? "checked":""?> name="header">
                <label class="form-check-label" for="inlineCheckbox1">이용안내</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="1" <?=$my==1 ? "checked":""?> name="my">
                <label class="form-check-label" for="inlineCheckbox2">마이페이지</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="1" <?=$footer==1 ? "checked":""?> name="footer">
                <label class="form-check-label" for="inlineCheckbox3">Footer</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="1" <?=$banner==1 ? "checked":""?> name="banner">
                <label class="form-check-label" for="inlineCheckbox4">배너</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="1" <?=$event==1 ? "checked":""?> name="event">
                <label class="form-check-label" for="inlineCheckbox5">이벤트</label>
              </div>
            </div>
          </div>

          <div class="row my -3">
            <div class="col-md-2"></div>
            <div class="col-md-10">
              <?php if(!empty($map)): ?>
              <?php  foreach($map as $map_v):?>
              <img src="/upload/banner/<?=$id?>/<?=$map_v?>" width=50 height=50>
              <span class="text-danger font-weight-bold delimg" role="button" data-src="/upload/banner/<?=$id?>/<?=$map_v?>">X</span>
              <?php  endforeach;?>
              <?php endif; ?>
            </div>
          </div>
          <div class="row my-3">
              <div class="col-md-12 text-center">
                  <a href="/admin/pages" class="btn btn-primary">새로 등록페이지에로</a>
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
                      <th>메뉴 1</th>
                      <th>메뉴 2</th>
                      <th>메뉴 3</th>
                      <th>제목</th>
                      <th>보기/수정/삭제</th>
                    </tr>
                    <tbody class="wrap">
                      <?php if(!empty($pages)): ?>
                        <?php foreach($pages as $value): ?>
                          <tr class="wrap_tr" data-id="<?=$value->id?>">
                            <th><?=$value->header==1 ? "이용안내":""?>
                                <?=$value->event==1 ? "이벤트":""?>
                                <?=$value->banner==1 ? "배너":""?></th>
                            <th><?=$value->footer==1 ? "Footer":""?></th>
                            <th><?=$value->my==1 ? "마이페이지":""?></th>
                            <th><?=$value->title?></th>
                            <th>
                              <a target="_blink" href="/ipage?id=<?=$value->id?>" class="btn btn-primary btn-sm">보기</a>
                              <a href="<?=base_url()?>pages_edit/<?=$value->id?>" class="btn btn-primary btn-sm">수정</a>
                              <a href="#" data-home="<?=$value->id?>"  class="btn btn-danger btn-sm deletePage">삭제</a>
                            </th>
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
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<link href="<?php echo base_url(); ?>assets/dist/css/editor.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/dist/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea[geditor]",
        theme: "modern",
        language : 'ko_KR',
        height: 370,
        force_br_newlines : false,
        force_p_newlines : true,
        convert_newlines_to_brs : false,
        remove_linebreaks : true,
        forced_root_block : 'p', // Needed for 3.x
                relative_urls:true,
        allow_script_urls: true,
        remove_script_host: true,
            //convert_urls: false,
        formats: { bold : {inline : 'b' }},
        extended_valid_elements: "@[class|id|width|height|alt|href|style|rel|cellspacing|cellpadding|border|src|name|title|type|onclick|onfocus|onblur|target],b,i,em,strong,a,img,br,h1,h2,h3,h4,h5,h6,div,table,tr,td,s,del,u,p,span,article,section,header,footer,svg,blockquote,hr,ins,ul,dl,object,embed,pre",
        plugins: [
            "jbimages",
             "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
             "searchreplace visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
             "save table contextmenu directionality emoticons template paste textcolor"
       ],
       content_css: "/admin/assets/dist/css/editor.css",
       body_class: "editor_content",
       menubar : false,
       toolbar1: "undo redo | fontsizeselect | advlist bold italic forecolor backcolor | charmap | hr | jbimages | autolink link media | preview | code",
       toolbar2: "bullist numlist outdent indent | alignleft aligncenter alignright alignjustify | table"
     }); 
    function fnBbsFileDel(val) {
        var frmObj = document.frmBbs;
        if (!confirm('해당 첨부파일을 삭제하시겠습니까?')) {
            return;
        }
        frmObj.sKind.value = 'D';
        frmObj.sFL_SEQ.value = val;
        frmObj.action = '/admin/bbs_fl_D';
        frmObj.submit();
    }
</script>
<script>
  $(".deletePage").click(function(){
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

  $(".delimg").click(function(){
    var src = "../"+$(this).data("src");
    var hitURL =  baseURL + "deleteF";
    var confirmation = confirm("정말 삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { url : src},
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
      }).done(function(data){
        alert("성공적으로 삭제되였습니다.");
        location.reload();
      });
    }
  })

</script>

pages