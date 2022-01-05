<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          팝업관리
      </h1>
    </section>
    <section class="content">
        <?php echo form_open_multipart('savePopup');?>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>제목</p>
            </div>
            <div class="col-md-8">
              <input type="text" name="title" class="form-control" id="title" required>
              <input type="hidden" name="id" class="form-control" id="ids">
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>내용</p>
            </div>
            <div class="col-md-8">
              <textarea name="content" geditor class="form-control" id="content"></textarea>
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>시작/종료일</p>
            </div>
            <div class="col-md-4">
              <input type="date" class="" name="terms1" required id="terms1"> ~ <input type="date" class="" name="terms2" required id="terms2"> 
            </div>
            <div class="col-md-1">
              <p>사이즈</p>
            </div>
            <div class="col-md-4">
              <input type="text" class="" name="size_w" required id="size_w"> * <input type="text" class="" name="size_h" required id="size_h"> 
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>좌표설정</p>
            </div>
            <div class="col-md-4">
              <input type="text" class="" name="po_w" required id="po_w"> ~ <input type="text" class="" name="po_h" required id="po_h">   
            </div>
            <div class="col-md-1">
              <p>스크룰유무</p>
            </div>
            <div class="col-md-2">
              <select name="scroll_use" id="scroll_use" class="form-control">
                <option value="1" selected="">사용</option>
                <option value="0">사용안함</option>
              </select>
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
                      <th>순번</th>
                      <th>제목</th>
                      <th>시작일|종료일</th>
                      <th>가로/세로</th>
                      <th>좌표</th>
                      <th>스크롤</th>
                      <th>사용유무</th>
                      <th>수정/삭제</th>
                      <?php if(!empty($popup)): ?>
                        <?php foreach($popup as $value): ?>
                          <tr>
                            <th><?=$value->id?></th>
                            <th><?=$value->title?></th>
                            <th><?=$value->terms?></th>`
                            <th><?=$value->size_w?>*<?=$value->size_h?></th>
                            <th><?=$value->po_w?>*<?=$value->po_h?></th> 
                            <th><?=$value->scroll_use==1 ? "사용가능":""?></th>                           
                            <th><?=$value->use==1 ? "사용":""?></th>
                            <th class="text-center">
                              <a class="btn btn-sm btn-info editPopup" href="#" data-popup="<?php echo $value->id; ?>"><i class="fa fa-pencil"></i></a>
                              <a class="btn btn-sm btn-danger deletePopup" href="#" data-popup="<?php echo $value->id; ?>"><i class="fa fa-trash"></i></a>
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
<link href="<?php echo base_url(); ?>assets/dist/css/editor.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/dist/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
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
  jQuery(document).on("click", ".editPopup", function(){
    var popup = $(this).data("popup"),
      hitURL = baseURL + "editPopup";
      
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { popup : popup } 
      }).done(function(data){
        if(data.length > 0){
          $("#title").val(data[0].title);
          
          $("#size_w").val(data[0].size_w);
          $("#terms1").val(data[0].terms.split("|")[0]);
          $("#terms2").val(data[0].terms.split("|")[1]);
          $("#size_h").val(data[0].size_h);
          $("#po_w").val(data[0].po_w);
          $("#po_h").val(data[0].po_h);
          $("#scroll_use").val(data[0].scroll_use);
          $("#use").val(data[0].use);
          $("#ids").val(data[0].id);
          tinymce.activeEditor.setContent(data[0].content);
        }
      });
  });
  jQuery(document).on("click", ".deletePopup", function(){
    var popup = $(this).data("popup"),
      hitURL = baseURL + "deletePopup",
      currentRow = $(this);
    
    var confirmation = confirm("정말 삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { popup : popup} 
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