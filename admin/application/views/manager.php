<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        관리자 관리
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addManger"><i class="fa fa-plus"></i>관리자 가입</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <form name="frmList" id="frmList" method="get" action=""> 
                  <div class="box-tools">   
                    <div class="input-group" style="margin-bottom: 10px">
                      <div class="pull-right">
                        <label style="display:block; ">&nbsp;</label>
                        <input class="btn btn-primary btn-sm" value="검색" type="submit">
                     </div> 
                     <div class="pull-right">
                        <label style="display:block; ">내용</label>
                        <input type="text" name="content" class="form-control input-sm" style="width: 150px;" 
                         value="<?=empty($_GET['content']) == 0 ? $_GET['content']:"" ?>" >
                     </div> 
                     <div class="pull-right">
                        <label style="display:block; ">검색항목</label>
                        <select name="shType" id="shType" class="form-control input-sm">
                          <option value="loginId" <?=empty($_GET['shType'])==0 && $_GET['shType']=="loginId" ? "selected":""?>>아이디</option>
                          <option value="name" <?=empty($_GET['shType'])==0 && $_GET['shType']=="name" ? "selected":""?>>이름</option>
                          <option value="nickname" <?=empty($_GET['shType'])==0 && $_GET['shType']=="nickname" ? "selected":""?>>닉네임</option>
                        </select>
                     </div>
                     <div class="pull-right">
                        <label style="display:block; ">회원등급</label>
                        <select name="shMemLvl" id="shMemLvl" class="form-control input-sm">
                          <option value="">==전체==</option>
                          <?php if(!empty($managers)): ?>
                            <?php foreach($managers  as $value): ?>
                              <option value="<?=$value->roleId?>" <?=empty($_GET['shMemLvl']) ==0 && $_GET['shMemLvl'] == $value->roleId ? "selected":"" ?>><?=$value->role?></option>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </select>
                     </div>
                     <div class="pull-right">
                       <label style="display:block; ">종료일</label>
                        <input type="date" name="ends_date"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['ends_date']) == 0 ? $_GET['ends_date']:"" ?>">
                     </div> 
                     <div class="pull-right">
                       <label style="display:block; ">시작일</label>
                        <input type="date" name="starts_date"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['starts_date']) == 0 ? $_GET['starts_date']:"" ?>">
                     </div> 
                     
                     <div class="pull-right">
                       <label style="display: block;">Page</label>
                       <select name="shPageSize" id="shPageSize" class="form-control input-sm">
                          <?php for($ii = 10 ;$ii<=100;$ii+=5){ ?>
                            <option value="<?=$ii?>" <?=empty($_GET['shPageSize'])==0 && $_GET['shPageSize']==$ii ? "selected":"" ?>><?=$ii?></option>
                          <?php }  ?>
                        </select>
                     </div>
                    </div>
                  </div>
                </form>
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>Id</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th>Role</th>
                      <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                    ?>
                    <tr>
                      <td><?php echo $record->userId ?></td>
                      <td><?php echo $record->name ?></td>
                      <td><?php echo $record->email ?></td>
                      <td><?php echo $record->mobile ?></td>
                      <td><?php echo $record->role ?></td>
                      <td class="text-center">
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editOld/'.$record->userId; ?>"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="<?php echo $record->userId; ?>"><i class="fa fa-trash"></i></a>
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
