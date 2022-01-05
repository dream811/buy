<?php 
  $id = "0";
  $title = "";
  $type = "";
  $postc = 0;
  $category_use = 1;
  $category = "";
  $state_use = 1;
  $state = "";
  $title_l = 0;
  $letter_l = 0;
  $sms = 1;
  $file_size = 0;
  $security = 0;
  $ins_title_use = 1;
  $ins_title = "";
  $num_use = 1;
  $writer_use = 1;
  $regidate_use = 1;
  $view_use = 1;
  $recommend_use = 1;
  $wrview_use = 0;
  $writing_use = "";
  $comment_use = "";
  $download_use = 0;
  $content = "";
  if(!empty($board)): 
    foreach($board as $value):
      $id = $value->id;
      $title = $value->title;
      $type = $value->type;
      $postc = $value->postc;
      $category_use = $value->category_use;
      $category = $value->category;
      $state_use = $value->state_use;
      $state = $value->state;
      $title_l = $value->title_l;
      $letter_l = $value->letter_l;
      $sms = $value->sms;
      $file_size = $value->file_size;
      $security = $value->security;
      $ins_title_use = $value->ins_title_use;
      $ins_title = $value->ins_title;
      $num_use = $value->num_use;
      $writer_use = $value->writer_use;
      $regidate_use = $value->regidate_use;
      $view_use = $value->view_use;
      $recommend_use = $value->recommend_use;
      $wrview_use = $value->wrview_use;
      $writing_use = $value->writing_use;
      $comment_use = $value->comment_use;
      $download_use = $value->download_use;
      $content = $value->content;
    endforeach;
  endif; 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        게시판 등록
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <form role="form" id="addUser" action="<?php echo base_url() ?>addBoard" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="title">게시판명</label>
                                        <input type="text" class="form-control" id="title" name="title" required value="<?=$title?>">
                                        <input type="hidden" name="id" value="<?=$id?>">
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">타입</label>
                                        <select class="form-control" id="type" name="type">
                                            <option value="1">일반게시판</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="postc">게시물수</label>
                                        <select class="form-control" id="postc" name="postc">
                                            <?php for($i=1;$i<=40;$i++){ ?>
                                                <option value="<?=$i?>" <?php 
                                                if(!empty($postc) && $postc > 0 && $postc==$i) echo 'selected';
                                                ?>><?=$i?></option>
                                            <?php  } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_use">분류사용</label>
                                        <select class="form-control" id="category_use" name="category_use">
                                            <option value="1" <?php if($category_use==1) echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($category_use==0) echo 'selected'; ?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">분류명(ex:잡담|유머|질문|답변)</label>
                                        <input type="text" class="form-control" id="category" name="category" value="<?=$category?>">
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state_use">상태사용</label>
                                        <select class="form-control" id="state_use" name="state_use">
                                            <option value="1" <?php if($state_use==1) 
                                            echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($state_use==0) 
                                            echo 'selected'; ?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">상태내용(ex:문의중|답변중|답변완료)</label>
                                        <input type="text" class="form-control" id="state" name="state" value="<?=$state?>">
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title_l">제목길이제한(한글 기준)</label>
                                        <select class="form-control" id="title_l" name="title_l">
                                            <?php for($i=1;$i<=100;$i++){ ?>
                                                <option value="<?=$i?>" <?php 
                                                     if(!empty($title_l) && $title_l > 0 && $title_l==$i) echo 'selected';
                                                 ?>><?=$i?></option>
                                            <?php  } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="letter_l">공지글수</label>
                                        <select class="form-control" id="letter_l" name="letter_l">
                                            <?php for($i=1;$i<=20;$i++){ ?>
                                                <option value="<?=$i?>" <?php 
                                                    if(!empty($letter_l) && $letter_l > 0 && $letter_l==$i) echo 'selected';
                                                 ?>><?=$i?></option>
                                            <?php  } ?>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sms">sms알림기능사용</label>
                                        <select class="form-control" id="sms" name="sms">
                                            <option value="1" <?php if($sms==1) 
                                            echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($sms==0) 
                                            echo 'selected'; ?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="file_size">파일용량제한(MB(한 게시물 최대) / 0MB 이면 파일업로드 불가)</label>
                                        <select class="form-control" id="file_size" name="file_size">
                                             <option value="0" <?php  if($file_size==0) echo 'selected';?>>0</option>
                                            <?php for($i=1;$i<=10;$i++){ ?>
                                                <option value="<?=$i?>" <?php 
                                                    if(!empty($file_size) && $file_size > 0 && $file_size==$i) echo 'selected';
                                                ?>><?=$i?></option>
                                            <?php  } ?>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="security">비밀글사용</label>
                                        <select class="form-control" id="security" name="security">
                                            <option value="1" <?php if($security==1) 
                                            echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($security==0) 
                                            echo 'selected'; ?>>사용안함</option>
                                            <option value="-1" <?php if($security==-1) 
                                            echo 'selected'; ?>>강제사용</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ins_title_use">추천기능사용</label>
                                        <select class="form-control" id="ins_title_use" name="ins_title_use">
                                            <option value="1" <?php if($ins_title_use==1) 
                                            echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($ins_title_use==0) 
                                            echo 'selected'; ?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="ins_title">타이틀대체</label>
                                        <input type="text" class="form-control" id="ins_title" name="ins_title" value="<?=$ins_title?>">
                                    </div>
                                </div>   
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="num_use">번호사용(리스트에서 게시물번호 사용 여부)</label>
                                        <select class="form-control" id="num_use" name="num_use">
                                            <option value="1" <?php if($num_use==1) 
                                            echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($num_use==0) 
                                            echo 'selected'; ?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>   
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="writer_use">작성자 사용(리스트에서 작성자 사용 여부)</label>
                                        <select class="form-control" id="writer_use" name="writer_use">
                                            <option value="1" <?php if($writer_use==1) 
                                            echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($writer_use==0) 
                                            echo 'selected'; ?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="regidate_use">등록일 사용(리스트에서 등록일 사용 여부)</label>
                                        <select class="form-control" id="regidate_use" name="regidate_use">
                                           <option value="1" <?php if($regidate_use==1) 
                                            echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($regidate_use==0) 
                                            echo 'selected'; ?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="view_use">조회수 사용(리스트에서 조회수 사용 여부)</label>
                                        <select class="form-control" id="view_use" name="view_use">
                                            <option value="1" <?php if($view_use==1) 
                                            echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($view_use==0) 
                                            echo 'selected'; ?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="recommend_use">추천수 사용(리스트에서 추천수 사용 여부)</label>
                                        <select class="form-control" id="recommend_use" name="recommend_use">
                                            <option value="1" <?php if($recommend_use==1) 
                                            echo 'selected'; ?>>사용함</option>
                                            <option value="0" <?php if($recommend_use==0) 
                                            echo 'selected'; ?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wrview_use">글보기 권한</label>
                                        <select class="form-control" id="wrview_use" name="wrview_use">
                                            <option value="100000" <?php if($wrview_use ==0) echo 'selected'; ?>>0: 비회원</option>
                                            <?php if(!empty($role)): ?>
                                                <?php foreach($role as $value): ?>
                                            <option value="<?=$value->level?>"  <?php 
                                            if($wrview_use ==$value->level) echo 'selected'; ?>><?=$value->level?> : <?=$value->role?></option>    
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="writing_use">쓰기 권한</label>
                                        <select class="form-control" id="writing_use" name="writing_use">
                                            <?php if(!empty($role)): ?>
                                                <?php foreach($role as $value): ?>
                                            <option value="<?=$value->level?>" <?php 
                                            if($writing_use ==$value->level) echo 'selected'; ?>><?=$value->level?> : <?=$value->role?></option>    
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="comment_use">댓글쓰기 권한</label>
                                        <select class="form-control" id="comment_use" name="comment_use">
                                            <?php if(!empty($role)): ?>
                                                <?php foreach($role as $value): ?>
                                            <option value="<?=$value->level?>" <?php 
                                            if($comment_use ==$value->level) echo 'selected'; ?>><?=$value->level?> : <?=$value->role?></option>    
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="download_use">다운로드 권한</label>
                                        <select class="form-control" id="role" name="download_use">
                                            <option value="100000" <?php if($download_use ==0) echo 'selected'; ?>>0: 비회원</option>
                                            <?php if(!empty($role)): ?>
                                                <?php foreach($role as $value): ?>
                                            <option value="<?=$value->level?>" <?php 
                                            if($download_use ==$value->level) echo 'selected'; ?>><?=$value->level?> : <?=$value->role?></option>    
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="content" geditor name="content"><?=$content?></textarea>
                                    </div>
                                </div>   
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <a href="/admin/board_settings" class="btn btn-default">취소</a>
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