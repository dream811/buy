<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Header 관리 (only PNG)
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <?php echo form_open_multipart('saveHeader');?>
            <div class="row my-3">
              <div class="col-md-12">
                <h4>로고 업로드</h4>
                <input type="file" name="image" class="my-4">
                <input type="file" name="image1" class="my-4">
              </div>
              <div class="col-md-6">
                <h4>로고</h4>
                <img src="<?=!empty($p) && !empty($p[0]->image) ? "../template/images/".$p[0]->image:"/upload/noimage.jpeg"?>" class="w-100">     
              </div>
            </div>
            <div class="row my-4">
                <div class="col-md-4">
                    <input type="submit" class="btn btn-primary" value="저장">
                    <input type="reset" class="btn" value="취소">
                </div>
            </div>
          </form>
        </div>
        <div class="col-md-6">
          <?php echo form_open_multipart('saveFooter');?>
            <div class="row my-3">
              <div class="col-md-12">
                <h4>Footer 관리</h4>
                <input type="hidden" name="id" class="form-control" value="3">
              </div>
            </div>
            <div class="row my-3">
              <div class="col-md-12">
                <h4>로고 업로드</h4>
                <input type="file" name="image" class="my-4">
                <input type="file" name="image1" class="my-4">
              </div>
            </div>
            <div class="row my-3">
              <div class="col-md-12">
                <textarea name="content" class="form-control" id="content" geditor required> <?=!empty($p1) ? $p1[0]->description:""?></textarea>
              </div>
               <div class="col-md-6">
                <h4>로고&nbsp;&nbsp;
                <span role="button" class="text-danger font-weight-bold" 
                onclick="javascript:deleteFooterImg('image','<?=!empty($p1) ? $p1[0]->image : ""?>')">X 삭제</span></h4>
                <img src="<?=!empty($p1) && !empty($p1[0]->image) ? "../template/images/".$p1[0]->image:"/upload/noimage.jpeg"?>"  class="w-100">     
              </div>
              <div class="col-md-6">
                <h4>보조 이미지&nbsp;&nbsp;
                <span role="button" class="text-danger font-weight-bold" 
                onclick="javascript:deleteFooterImg('image1','<?=!empty($p1) ? $p1[0]->image1 : ""?>')">X 삭제</span></h4>
                <img src="<?=!empty($p1) && !empty($p1[0]->image1) ? "../template/images/".$p1[0]->image1:"/upload/noimage.jpeg"?>"  class="w-100">               
              </div>
            </div>
            <div class="row my-3">
                <div class="col-md-4">
                    <input type="submit" class="btn btn-primary" value="저장">
                    <input type="reset" class="btn" value="취소">
                </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row my-4">
        <div class="col-md-6">
          <?php echo form_open_multipart('saveMobileHeader');?>
            <div class="row my-3">
              <div class="col-md-12">
                <h4>로고 업로드</h4>
                <input type="file" name="image" class="my-4">
                <input type="file" name="image1" class="my-4">
              </div>
              <div class="col-md-6">
                <h4>로고</h4>
                <img src="<?=!empty($p2) && !empty($p2[0]->image) ? base_url_home()."template/images/".$p2[0]->image:"/upload/noimage.jpeg"?>" class="w-100">     
              </div>
              <div class="col-md-6">
                <h4>보조 이미지</h4>
                <img src="<?=!empty($p2) && !empty($p2[0]->image1) ? base_url_home()."template/images/".$p2[0]->image1:"/upload/noimage.jpeg"?>"  class="w-100">               
              </div>
            </div>
            <div class="row my-4">
                <div class="col-md-4">
                    <input type="submit" class="btn btn-primary" value="저장">
                    <input type="reset" class="btn" value="취소">
                </div>
            </div>
          </form>
        </div>
      </div>
  </section>
  
</div>
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
function deleteFooterImg(type,img){
    var confirmation = confirm("삭제하시겠습니까?");
    hitURL = baseURL + "deleteFooterImg";
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      url : hitURL,
      data : { type : type,img:img } 
      }).done(function(data){
        location.reload();
      });
    }
  }

</script>

