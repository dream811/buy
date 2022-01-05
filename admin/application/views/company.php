<?php 
  $name = "";
  $phone = "";
  $fax = "";
  $site = "";
  $mail = "";
  $c_reg_number = "";
  $person_num = "";
  $business_location = "";
  $agent = "";
  $mail_obus_num = "";
  $ceo = "";
  if(!empty($company)): 
    foreach($company as $value):
      $name = $value->s_company_name;
      $phone = $value->s_glbtel;
      $fax = $value->s_fax;
      $site = $value->s_adshop;
      $mail = $value->s_ademail;
      $c_reg_number = $value->s_company_num;
      $person_num = $value->s_privacy_name;
      $business_location = $value->s_company_addr;
      $agent = $value->s_ceo_name;
      $mail_obus_num = $value->s_company_snum;
      $ceo = $value->s_ceo_name;
    endforeach;
  endif; 
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          업체정보변경  
      </h1>
    </section>
    <section class="content">
        <form action="<?=base_url()?>saveCompany" method="post">
          <div class="row">
            <div class="col-md-6">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-bordered">
                    <tr>
                      <th class="mid text-center table-active">회사명</th>
                      <td><input type="text" name="s_company_name" class="form-control" value="<?=$name?>"></td>
                    </tr>
                    <tr>
                      <th class="mid text-center table-active">대표자</th>
                      <td><input type="text" name="s_ceo_name" class="form-control" value="<?=$ceo?>"></td>
                    </tr>
                    <tr>
                      <th class="mid text-center table-active">사이트 제목</th>
                      <td><input type="text" name="s_adshop" id="s_adshop" maxlength="100" class="form-control" value="<?=$site?>"></td>
                    </tr>
                    <tr>
                      <th class="mid text-center table-active">사업자등록번호</th>
                      <td><input type="text" name="s_company_num" id="s_company_num" maxlength="60" class="form-control" value="<?=$c_reg_number?>"></td>
                    </tr>
                    <tr>
                      <th class="mid text-center table-active">통신판매업번호</th>
                      <td><input type="text" name="s_company_snum" id="s_company_snum" maxlength="100" class="form-control" value="<?=$mail_obus_num?>"></td>
                    </tr>
                    <tr>
                      <th class="mid text-center table-active">대표전화</th>
                      <td><input type="text" name="s_glbtel" class="form-control" value="<?=$phone?>"> </td>
                    </tr>
                    <tr>
                      <th class="mid text-center table-active">팩스전화</th>
                      <td><input type="text" name="s_fax" id="s_fax" maxlength="60" class="form-control" value="<?=$fax?>"></td>
                    </tr>
                    <tr>
                      <th class="mid text-center table-active">이메일</th>
                      <td><input type="email" name="s_ademail" class="form-control" value="<?=$mail?>"></td>
                    </tr>
                    <tr>
                      <th class="mid text-center table-active">개인정보취급책임자</th>
                      <td><input type="text" name="s_privacy_name" id="s_privacy_name" maxlength="60" class="form-control" value="<?=$person_num?>"></td>
                    </tr>
                    <tr>
                      <th class="mid text-center table-active">사업장소재지</th>
                      <td><input type="text" name="s_company_addr" id="s_company_addr" maxlength="150" class="form-control" 
                        value="<?=$business_location?>"></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row my-3">
              <div class="col-md-6">
                <div class="box">
                  <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="저장">
                    <input type="reset" class="btn" value="취소">
                  </div>
                </div>
              </div>
          </div>
        </form>
    </section>
</div>
