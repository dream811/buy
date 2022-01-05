<?php if(empty($panel)) return; ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->                
                <div class="box box-primary">
                    <?php echo form_open_multipart(base_url()."writePost/".$btype, array('id' => 'frmSearch','name'=>'frmBbs')); ?>
                        <div class="box-body">
                            <div class="row">
                                <?php if($panel[0]->category_use==1): 
                                       $category = explode("|", $panel[0]->category);   ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="role">카테고리</label>
                                            <select class="form-control" id="category" name="category" required>
                                                <?php if(!empty($category)): ?>
                                                    <?php foreach($category as $value): ?>
                                                    <option value="<?=$value?>"><?=$value?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>  
                                <?php if($panel[0]->state_use==1): 
                                    $state = explode("|", $panel[0]->state);   ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="role">응답처리</label>
                                            <select class="form-control required" id="mode" name="mode">
                                            <?php if(!empty($category)): ?>    
                                                <?php foreach($state as $value): ?>
                                                <option value="<?=$value?>"><?=$value?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>    
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-md-10">                                
                                    <div class="form-group">
                                        <label for="fname">제목</label>
                                        <input type="text" class="form-control required" id="title" name="title" required>
                                    </div>
                                </div>
                                <?php if($panel[0]->letter_l > 0): ?>
                                <div class="col-md-2">                                
                                    <div class="form-group">
                                        &nbsp;
                                        <div>
                                            <label for="letter_l">공지글</label>
                                            <input type="checkbox" class="form-check-input" name="letter_l" value="1">
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>    
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="content">내용</label>
                                        <textarea class="form-control" name="content" geditor id="content" style="height: 300px" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php if($panel[0]->file_size > 0 && $this->session->userdata("level") <= $panel[0]->download_use): ?>
                                    <input type='file' name='file1' class='my-4'>
                                    <input type='file' name='file2' class='my-4'>
                                    <input type='file' name='file3' class='my-4'>
                                    <?php endif; ?>
                                </div> 
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <a href="/admin/panel?id=<?=$panel[0]->id?>" class="btn btn-default">취소</a>
                        </div>
                    </form>
                </div>
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