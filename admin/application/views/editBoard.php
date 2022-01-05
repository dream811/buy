<?php if(empty($board)) {echo "해당 게시가 존재하지 않습니다.";return;} ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        게시판 편집
        <small><?=$board[0]->btitle?></small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                    </div><!-- /.box-header -->
                    <!-- form start -->   
                   <?php echo form_open_multipart('updateBoard', array('id' => 'frmSearch','name'=>'frmBbs')); ?>
                        <input type="hidden" name="sKind" id="sKind">
                        <input type="hidden" name="sFL_SEQ" id="sFL_SEQ">
                        <input type="hidden" name="board_type" id="board_type" value="<?=$this->input->get("board_type")?>">
                        <div class="box-body">
                            <div class="row">
                            	<input type="hidden" name="id" value="<?=$board[0]->id?>">
                                <?php if($board[0]->category_use==1): ?>
                                	<?php $category = explode("|", $board[0]->bcategory); ?>
                                <?php if(!empty($category)): ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="role">카테고리</label>
                                            <select class="form-control" id="category" name="category" required>
                                                <option value="">==선택==</option>
    											<?php foreach($category as $cvalue): ?>
                                                <option value="<?=$cvalue?>" <?=$cvalue==$board[0]->category ? "selected":""?>><?=$cvalue?></option>    
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if($board[0]->bstate_use==1): ?>
                                    <?php $bstate = explode("|", $board[0]->bstate); ?>
                                    <?php if(!empty($bstate)): ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="role">응답처리</label>
                                            <select class="form-control required" id="mode" name="mode">
    											<?php foreach($bstate as $bvalue): ?>
                                                <option value="<?=$bvalue?>" <?=$bvalue==$board[0]->mode ? "selected":""?>><?=$bvalue?></option>    
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php endif; ?>    
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="title">제목</label>
                                        <input type="text" class="form-control" id="title"  name="title" required value="<?=$board[0]->title?>">
                                    </div>
                                </div>
                                <div class="col-md-2">                                
                                    <div class="form-group">
                                        &nbsp;
                                        <div>
                                            <label for="letter_l">공지글</label>
                                            <input type="checkbox" class="form-check-input" name="letter_l" value="1" 
                                            <?php if($board[0]->letter_l > 0):?> checked <?php endif;?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="content">내용</label>
                                        <input type="hidden" name="len" value="<?=$board[0]->file_size?>">
                                        <textarea class="form-control"  geditor name="content" required> <?=$board[0]->content?></textarea>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="content">등록날자</label>
                                        <input type="date"  name="updated_date" value="<?=date("Y-m-d",strtotime($board[0]->updated_date))?>">
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="content">조회수</label>
                                        <input type="text"  name="view" value="<?=$board[0]->view?>">
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php if($board[0]->file_size > 0): ?>
                                    <?=!empty($board[0]->file1) ? "<p class='my-4'>".$board[0]->file1.
                                    "&nbsp;<a href='javascript:fnBbsFileDel(\"1\");'>삭제</a></p>":
                                    " <input type='file' name='file1' class='my-4'>" ?>
                                   <?=!empty($board[0]->file2) ? "<p class='my-4'>".$board[0]->file2.
                                    "&nbsp;<a href='javascript:fnBbsFileDel(\"2\");'>삭제</a></p>":
                                    " <input type='file' name='file2' class='my-4'>" ?>
                                    <?=!empty($board[0]->file3) ? "<p class='my-4'>".$board[0]->file3.
                                    "&nbsp;<a href='javascript:fnBbsFileDel(\"3\");'>삭제</a></p>":
                                    " <input type='file' name='file3' class='my-4'>" ?>
                                    <?php endif; ?>
                                </div> 
                            </div>
                        </div>    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <a  class="btn btn-default" href="/admin/viewReq/<?=$board[0]->id?>">취소</a>
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