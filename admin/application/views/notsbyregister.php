<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      이용약관,유의사항
   </h1>
</section>
<section class="content">
   <div class="row">
      <div class="col-md-6">
         <?php echo form_open_multipart('saveregisternots');?>
         <div class="row my-3">
            <div class="col-md-12">
               <h4>이용약관</h4>
               <input type="hidden" name="id" class="form-control" value="2">
            </div>
         </div>
         <div class="row my-3">
            <div class="col-md-12">
               <textarea name="link" class="form-control" id="editor" geditor required>
               <?=!empty($p) ? $p[0]->link:""?>
               </textarea>
            </div>
         </div>
         <div class="row my-3">
            <div class="col-md-4">
               <select name="use" id="use" class="form-control">
                  <option value="1" <?=!empty($p) && $p[0]->use==1 ? "selected":""?>>사용</option>
                  <option value="0" <?=!empty($p) && $p[0]->use==0 ? "selected":""?>>사용안함</option>
               </select>
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
      <div class="col-md-6">
         <?php echo form_open_multipart('saveregisternots');?>
         <div class="row my-3">
            <div class="col-md-12">
               <h4>개인정보수집</h4>
               <input type="hidden" name="id" class="form-control" value="3">
            </div>
         </div>
         <div class="row my-3">
            <div class="col-md-12">
               <textarea name="link" class="form-control" id="editor_other" geditor required> <?=!empty($p1) ? $p1[0]->link:""?></textarea>
            </div>
         </div>
         <div class="row my-3">
            <div class="col-md-4">
               <select name="use" id="use" class="form-control">
                  <option value="1" <?=!empty($p1) && $p1[0]->use==1 ? "selected":""?>>사용</option>
                  <option value="0" <?=!empty($p1) && $p1[0]->use==0 ? "selected":""?>>사용안함</option>
               </select>
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
</section>
<section class="content-header">
   <h1>
      배송구매시 유의사항
   </h1>
</section>
<section class="content">
   <div class="row">
      <div class="col-md-6">
         <?php echo form_open_multipart('saveregisternots');?>
         <div class="row my-3">
            <div class="col-md-12">
               <h4>배송시 유의사항</h4>
               <input type="hidden" name="id" class="form-control" value="4">
            </div>
         </div>
         <div class="row my-3">
            <div class="col-md-12">
               <textarea name="link" class="form-control" id="editor_1" geditor required>
               <?=!empty($p2) ? $p2[0]->link:""?>
               </textarea>
            </div>
         </div>
         <div class="row my-3">
            <div class="col-md-4">
               <select name="use" id="use" class="form-control">
                  <option value="1" <?=!empty($p2) && $p2[0]->use==1 ? "selected":""?>>사용</option>
                  <option value="0" <?=!empty($p2) && $p2[0]->use==0 ? "selected":""?>>사용안함</option>
               </select>
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
      <div class="col-md-6">
         <?php echo form_open_multipart('saveregisternots');?>
         <div class="row my-3">
            <div class="col-md-12">
               <h4>구매시 유의사항</h4>
               <input type="hidden" name="ids" class="form-control" value="5">
            </div>
         </div>
         <div class="row my-3">
            <div class="col-md-12">
               <textarea name="link" class="form-control" id="editor_2" geditor required>
               <?=!empty($p3) ? $p3[0]->link:""?>
               </textarea>
            </div>
         </div>
         <div class="row my-3">
            <div class="col-md-4">
               <select name="use" id="use" class="form-control">
                  <option value="1" <?=!empty($p3) && $p3[0]->use==1 ? "selected":""?>>사용</option>
                  <option value="0" <?=!empty($p3) && $p3[0]->use==0 ? "selected":""?>>사용안함</option>
               </select>
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