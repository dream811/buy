<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>게시판 설정</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>Bbs_SetUp_W"><i class="fa fa-plus"></i>새로 등록</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <thead class="thead-dark">
                      <tr>
                        <th>게시판명</th>
                        <th>타입</th>
                        <th>비밀글</th>
                        <th>파일용량제한</th>
                        <th>추천기능</th>
                        <th>게시글수</th>
                        <th>수정/삭제</th>
                        <th class="text-center"></th>
                        <th></th>
                      </tr>
                    </thead>
                    <?php
                    if(!empty($board))
                    {
                        foreach($board as $record)
                        {
                    ?>
                    <tr>
                      <td><?=$record->title ?></td>
                      <td>일반</td>
                      <td><?php 
                        if($record->security==1) echo "사용"; 
                        if($record->security==0) echo "사용안함";
                        if($record->security==-1) echo "강제사용";
                        ?></td>
                      <td><?=$record->file_size?></td>
                      <td><?=$record->recommend_use==1 ? "사용":"사용안함"?></td>
                      <td><?=$record->postc?></td>
                      <td>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editboards/'.$record->id; ?>"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteBoard" href="#" data-id="<?php echo $record->id; ?>"><i class="fa fa-trash"></i></a>
                      </td>
                      <td><input type="text" class="form-control" style="width: 100px" onblur="javascript:changeGrade(<?=$record->id?>,$(this).val());" 
                        value="<?=$record->grade?>"></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
  jQuery(document).on("click", ".deleteBoard", function(){
    var id = $(this).data("id"),
      hitURL = baseURL + "deleteBoard",
      currentRow = $(this);
    var confirmation = confirm("삭제하시겠습니까 ?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      url : hitURL,
      data : { id : id } 
      }).done(function(data){
        if(data==100){
          currentRow.parents('tr').remove();
        }
        else{
          alert("오류발생");
        }
      });
    }
  });

  function  changeGrade(id,grade){
    hitURL = baseURL + "changeGrade",
    jQuery.ajax({
      type : "POST",
      url : hitURL,
      data : { id : id,grade:grade } 
    }).done(function(data){
    });
  }
</script>