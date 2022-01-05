<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        품목 카테고리
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <a class="btn btn-primary" href="javascript:showPop()"><i class="fa fa-plus" ></i>1단계 카테고리 등록</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                      1단계 카테고리 정렬
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>카테고리</th>
                      <th>사용여부</th>
                      <th>등록일</th>
                      <th></th>
                    </tr>
                    <?php
                    if(!empty($topcat))
                    {
                        foreach($topcat as $record)
                        {
                    ?>
                    <tr>
                      <td><?php echo $record->name ?></td>
                      <td><?= $record->use==1 ?"사용":"중지" ?></td>
                      <td class="text-center">
                          <a class="btn btn-sm btn-info editCat" data-cat="<?=$record->id?>"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteCat" href="#" data-cat="<?=$record->id?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                <?php echo $this->pagination->create_links(); ?>
              </div> 
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">카테고리 정보</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form name="frmPopCate" id="frmPopCate" method="post">
          <input type="hidden" name="CATE_SEQ" id="CATE_SEQ" value="0">
          <input type="hidden" name="parent" id="parent" value="0"> 
          <input type="hidden" name="id" id="PARENT_CATE" value="">
            <table class="order_write order_table_top">
              <colgroup>
                <col width="15%"><col width="35%">
                <col width="15%"><col width="35%">
              </colgroup> 
        <tbody><tr>
          <th>부모 카테고리</th>
          <td><span class="bold">최상위 카테고리</span></td> 
          <th>카테고리 명</th>
          <td><input type="text" name="name" id="CATE_NM" maxlength="100" style="width: 70%;" class="input_txt2" value=""></td> 
        </tr>

        <tr>
          <th>사용여부</th>
          <td colspan="3">
            <select name="use" id="USE_YN">
              <option value="1">사용</option>
              <option value="0">중지</option>
            </select>
          </td>
        </tr>
        </tbody></table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="javascript:fnPopCateReg()">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">카테고리 정렬</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul id="wrap" class="wrap">
          <?php if(!empty($tops)): ?>
          <?php foreach($tops as $value): ?>  
           <li class="categoryids border border-primary p-5" data-id=<?=$value->id?>>
            <?=$value->name?>
          </li> 
          <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
        <button type="button" class="btn btn-primary" onclick="javascript:seporders();">카테고리 정렬</button>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/drag-sort.js"></script>
<style type="text/css">
  .order_write {
    border-left: 1px solid #e5e5e5;
    border-right: 1px solid #e5e5e5;
    border-bottom: 1px solid #e5e5e5;
}
.order_write {
    width: 100%;
}
.order_table_top {
    border-top: 1px solid #e5e5e5;
}
.order_write tbody th {
    padding: 14px 8px;
    text-align: left;
    color: #707070;
    border-right: 1px solid #e5e5e5;
    background-color: #fbfbfb;
    letter-spacing: -0.05em;
}
.order_write tbody th {
    border-bottom: 1px solid #e5e5e5;
    border-left: 1px solid #e5e5e5;
    line-height: 130%;
}
.order_write tbody td {
    padding: 10px 8px;
}
.order_write tbody td {
    border-bottom: 1px solid #e5e5e5;
    border-left: 1px solid #e5e5e5;
    line-height: 130%;
}
</style>
<script type="text/javascript">
  function fnPopCateReg() {
    var frmPopReg = "#frmPopCate";
    var fIptId = "";

    // 카테고리 명
    fIptId = $(frmPopReg + " input[name='name']" );
    if ( !fnIptChk(fIptId) ) {
      fnMsgFcs(fIptId, "카테고리 명을 입력해주세요.");
      return;
    }

    $(frmPopReg).attr("action", "./saveCategory").submit();
}
</script>

<script type="text/javascript">
  jQuery(document).on("click", ".editCat", function(){
    var cat = $(this).data("cat"),
      hitURL = baseURL + "getCats";
      
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { cat : cat } 
      }).done(function(data){
        if(data.length > 0){
          $("#CATE_SEQ").val(2);
          $("#CATE_NM").val(data[0].name);
          $("#USE_YN").val(data[0].use);
          $("#PARENT_CATE").val(data[0].id);
          $("#exampleModal").modal("show");
        }
      });
  });
  jQuery(document).on("click", ".deleteCat", function(){
    var cat = $(this).data("cat"),
      hitURL = baseURL + "deleteCat",
      currentRow = $(this);
    
    var confirmation = confirm("정말 삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { cat : cat} 
      }).done(function(data){
        console.log(data);
        currentRow.parents('tr').remove();
        if(data.status = true) { alert("성공적으로 삭제되였습니다."); }
        else if(data.status = false) { alert("삭제오유"); }
        else { alert("접근거절..!"); }
      });
    }
  });

  function showPop(){
    $("#exampleModal").modal("show");
    $("#CATE_NM").val("");
    $("#USE_YN").val("1");
    $("#CATE_SEQ").val(1);
  }
  function seporders(){
    var cars = [];
    var hitURL = baseURL + "seporders";
    $.each( $(".categoryids"), function( key, item ) {
      cars[key] = $(item).data("id");
    });
    if(cars.length > 0 ){
      $.ajax({
      type : "POST",
      url : hitURL,
      data : { cat : JSON.stringify(cars) } 
      }).done(function(data){
        if(data==1) alert("성공적으로 변경되였습니다");
        else alert("실패하였습니다");
      });
    }
  }
</script>
<script type="text/javascript">
    $('#wrap').dragSort({
      replaceStyle: {
              'background-color': '#fff',
              'border': '1px dashed #ddd'
          },
          dragStyle: {
              'position': 'fixed',
              'box-shadow': '10px 10px 20px 0 #eee'
          }});
  </script>