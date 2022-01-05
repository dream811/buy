<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/admin.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/neo.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> 쪽지쓰기
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary">
                    <!-- form start -->
                    <form role="form" action="<?php echo base_url() ?>multisend" method="post" id="uproduct" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="receman">받는 사람 :</label>
                                    <?php if(empty($_GET['chkMemCode'])): ?>
                                    <select class="form-control" name="receman">
                                        <option value="0">전체</option>
                                    <?php if(!empty($role)): ?>
                                    <?php foreach($role as $value): ?>
                                        <option value="<?=$value->roleId?>"><?=$value->role?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                     </select>
                                    <?php endif; ?>
                                    <?php if(!empty($_GET['chkMemCode'])): ?>
                                        <?=$users?>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-12">
                                    <label for="title">제목</label>
                                    <input type="text" class="form-control" name="title" required>
                                    <input type="hidden" name="ids" value="<?=!empty($_GET['chkMemCode']) ? $_GET['chkMemCode']:''?>">
                                </div>
                                <div class="col-md-12 my-4">
                                    <textarea class="form-control" id="description" geditor name="content" required></textarea>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <a  href="javascript:self.close();" class="btn btn-default">닫기</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </section>
</div>
</body>
</html>
<script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/head.js"></script>

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
