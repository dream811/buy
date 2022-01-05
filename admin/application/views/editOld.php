<?php

$userId = '';
$name = '';
$email = '';
$mobile = '';
$roleId = '';
$deposit = 0;
$point = 0;
$address = '';
$details = '';
$zip = '';
$telephone = '';
$loginId = '';
$nickname = '';
$createdDtm = '';
$log_date = '';
$birthday = '';
$log_num = 0;
$sEmailRcvYN = '';
$sSmsRcvYN = '';
$type  = "";
$complete_orders  = 0;
$mag = array();
if(!empty($role_manage))
    $mag = json_decode($role_manage[0]->content);
var_dump($mag);
if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $userId = $uf->userId;
        $name = $uf->name;
        $email = $uf->email;
        $mobile = $uf->mobile;
        $roleId = $uf->roleId;
        $deposit = $uf->deposit;
        $point = $uf->point;
        $address = $uf->address;
        $details = $uf->detail_address;
        $zip = $uf->postNum;
        $telephone = $uf->telephone;
        $loginId = $uf->loginId;
        $nickname = $uf->nickname;
        $createdDtm = $uf->createdDtm;
        $log_date = $uf->log_date;
        $birthday = $uf->birthday;
        $log_num = $uf->log_num;
        $sEmailRcvYN = $uf->emailRecevice;
        $sSmsRcvYN = $uf->smsRecevice;
        $type  = $uf->type;
        $complete_orders = $uf->complete_orders;
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> 회원관리
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
                <?php } ?>
                <?php
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>

                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- left column -->
            <form role="form" action="<?php echo base_url() ?>editUser" method="post" id="editUser" role="form">
                <div class="col-md-8">
                  <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header">
                        </div><!-- /.box-header -->
                        <!-- form start -->

                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="loginId">아이디</label>
                                            <input type="text" class="form-control" id="loginId" name="loginId" value="<?php echo $loginId; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nickname">닉네임</label>
                                            <input type="text" class="form-control" id="nickname" name="nickname" value="<?php echo $nickname; ?>" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fname">Full Name</label>
                                            <input type="text" class="form-control" id="fname" placeholder="Full Name" name="fname" value="<?php echo $name; ?>" maxlength="128">
                                            <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $email; ?>" maxlength="128">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" placeholder="Password" name="password" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cpassword">Confirm Password</label>
                                            <input type="password" class="form-control" id="cpassword" placeholder="Confirm Password" name="cpassword" maxlength="10">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile">Mobile Number</label>
                                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $mobile; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select class="form-control" id="role" name="role">
                                                <option value="0">Select Role</option>
                                                <?php
                                                if(!empty($roles))
                                                {
                                                    foreach ($roles as $rl)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $rl->roleId; ?>" <?php if($rl->roleId == $roleId) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="createdDtm">가입일</label>
                                            <input type="text" class="form-control" id="createdDtm"  disabled value="<?=$createdDtm?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="log_num">로그인횟수</label>
                                            <input type="text" class="form-control" id="log_num" name="log_num" value="<?=$log_num?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="birthday">생년월일</label>
                                            <input type="date" class="form-control" id="birthday" name="birthday" value="<?=date("Y-m-d",strtotime($birthday))?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="deposit">예치금</label>
                                            <input type="text" class="form-control" id="deposit"  name="deposit" readonly
                                            value="<?=$deposit?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="point">포인트</label>
                                            <input type="text" class="form-control" id="point" name="point" readonly
                                            value="<?=$point?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zip">우편번호</label>
                                            <input type="text" class="form-control" id="zip"  name="zip" readonly=""
                                            value="<?=$zip?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-primary" onclick="javascript:openDaumPostcode();" style="display: block;">
                                            우편번호 검색</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="addr_1">주소</label>
                                            <input type="text" class="form-control" id="addr_1" name="addr_1"
                                            readonly value="<?=$address?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="details">상세주소</label>
                                            <input type="text" class="form-control" id="details" name="details" value="<?=$details?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telephone">전화번호</label>
                                            <input type="text" class="form-control" id="telephone" name="telephone" value="<?=$telephone?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telephone">회원상태</label>
                                            <select class="form-control" id="isDeleted" name="isDeleted">
                                                <option value="0" selected>능동회원</option>
                                                <option value="1">탈퇴회원</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>이메일 수신: </label>
                                            <label>
                                                예
                                                <input type="radio" name="emailRecevice" value="1" <?php if($sEmailRcvYN ==1) echo "checked";?>>
                                            </label>
                                            <label>
                                                아니오
                                                <input type="radio" name="emailRecevice" value="0" <?php if($sEmailRcvYN ==0) echo "checked";?>>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>SMS 수신: </label>
                                            <label>
                                                예
                                                <input type="radio" name="smsRecevice" value="1" <?php if($sSmsRcvYN ==1) echo "checked";?>>
                                            </label>
                                            <label>
                                                아니오
                                                <input type="radio" name="smsRecevice" value="0" <?php if($sSmsRcvYN ==0) echo "checked";?>>
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="complete_orders">
                                        주문완료건
                                      </label>
                                      <input type="text" class="form-control" value="<?=$complete_orders?>"  name="complete_orders">
                                    </div>
                                  </div>
                                </div>
                            </div><!-- /.box-body -->
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <input type="reset" class="btn btn-default" value="취소" />
                        </div>
                    </div>
                </div>
                <?php if($type == 0): ?>
                    <?php foreach(MANAGE_LIST as $n): ?>
                        <div class="col-md-2">
                        <?php foreach($n as $key=>$n_ch): ?>
                                <label style="width: 150px;" class="font-weight-bold"><?=$n_ch?></label>
                                <input type="checkbox" name="settings[]" value="<?=$key?>" <?php if(in_array($key, $mag)) echo "checked"; ?>>
                        <?php endforeach;?>
                         </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </form>
        </div>
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>
<script>
    function openDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                if ( data.userSelectedType == "R" ) {
                    document.getElementById('zip').value = data.zonecode;
                    document.getElementById('addr_1').value = data.roadAddress;
                    document.getElementById('details').focus();
                    //document.getElementById('ADDR_1_EN').value = data.addressEnglish;
                } else {
                    alert("지번주소가 아닌 도로명주소를 선택하십시오.");
                }
            }
        }).open();
    }
</script>
