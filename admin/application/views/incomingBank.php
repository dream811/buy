<?php 
  $name = "";
  $bank = "";
  $number = "";
  if(!empty($incomingBank)): 
    foreach($incomingBank as $value):
      $name = $value->name;
      $bank = $value->bank;
      $number = $value->number;
    endforeach;
  endif; 
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          입금계좌관리  
      </h1>
    </section>
    <section class="content">
        <form action="./saveBank" method="post">
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>예금주  </p>
            </div>
            <div class="col-md-4">
              <input type="text" name="name" class="form-control" value="<?=$name?>">
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>은행</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="bank" class="form-control" value="<?=$bank?>">    
            </div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center"><p>계좌번호</p></div>
              <div class="col-md-4"><input type="text" name="number" id="number" maxlength="60" class="form-control" value="<?=$number?>"></div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center">
                  <input type="submit" class="btn btn-primary" value="저장">
                  <input type="reset" class="btn" value="취소">
              </div>
          </div>
        </form>
        <div class="row">
            <div class="col-xs-8">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>예금주 </th>
                      <th>은행명</th>
                      <th>은행명</th>
                    </tr>
                        <tr>
                          <td><?=$name?></td>
                          <td><?=$bank?></td>
                          <td><?=$number?></td>
                        </tr>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
