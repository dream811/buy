<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <form name="frmList" id="frmList" method="get" action=""> 
                <div class="box-tools">   
                  <div class="input-group" style="margin-bottom: 10px">
                    <div class="pull-right">
                      <label style="display:block; ">..........</label>
                      <input class="btn btn-primary btn-sm" value="검색" type="submit">
                   </div> 
                   <div class="pull-right">
                      <label style="display:block; ">전화번호</label>
                      <input type="text" name="phone" class="form-control input-sm" style="width: 150px;" 
                       value="<?=empty($_GET['phone']) == 0 ? $_GET['phone']:"" ?>" >
                   </div> 
                   <div class="pull-right">
                     <label style="display: block;">월</label>
                     <input type="date" name="ends_date" class="form-control input-sm" 
                     value="<?=empty($_GET['ends_date']) == 0 ? $_GET['ends_date']:"" ?>">
                   </div>
                  </div>
                </div>
              </form>
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>No</th>
                      <th>전송정보</th>
                      <th>전송내용</th>
                      <th>결과</th>
                    </tr>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

