<?php $ss= 0;
if($pf==null) $ss = $uc;
if($pf!=null) $ss = $uc-$pf; ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>회원 구매대행 순위</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box">
                  <div class="box-body table-responsive">
                    <table class="table table-hover" >
                      <tr class="thead-dark">
                        <th></th>
                        <th>회원네임(아이디)</th>
                        <th>닉네임</th>
                        <th>구매대행건수</th>
                      </tr>
                      <?php
                      if(!empty($userRecords))
                      {
                          foreach($userRecords as $record)
                          {
                      ?>
                      <tr>
                        <td><?=$ss?></td>
                        <td><?=$record->name?>(<?=$record->loginId?>)</td>
                        <td><?=$record->nickname?></td>
                        <td><?=$record->total?></td>
                      </tr>
                      <?php
                      $ss=$ss-1;
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
