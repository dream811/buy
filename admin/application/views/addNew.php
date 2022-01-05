<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> 회원관리
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <form role="form" id="addUser" action="<?php echo base_url() ?>addNewUser" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="loginId">아이디</label>
                                        <input type="text" class="form-control" required id="loginId" name="loginId" onkeyup="fnRealIDChk();">
                                        <label id="idcheckresult">중복확인을 하셔야됩니다.</label>
                                        <input type="hidden" name="IDCheck" id="IDCheck" value="0">
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">이름</label>
                                        <input type="text" class="form-control" required id="fname" name="fname" maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">등급</label>
                                        <select class="form-control" required id="role" name="role">
                                            <option>==선택==</option>
                                            <?php
                                            if(!empty($roles))
                                            {
                                                foreach ($roles as $rl)
                                                {   ?>
                                                    <option value="<?php echo $rl->roleId ?>"><?php echo $rl->role ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">이메일</label>
                                        <input type="text" class="form-control required email" id="email"  name="email" maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">비번</label>
                                        <input type="password" class="form-control required" id="password"  name="password" maxlength="10">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpassword">비번 확인</label>
                                        <input type="password" class="form-control required equalTo" id="cpassword" name="cpassword" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">헨드폰&nbsp;&nbsp;&nbsp;</label>
                                        <input type="text" name="sMobNo1" id="sMobNo1" maxlength="4" class="hp">
                                        <input type="text" name="sMobNo2" id="sMobNo2" maxlength="4" class="hp">
                                        <input type="text" name="sMobNo3" id="sMobNo3" maxlength="4" class="hp">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="mobile">전화번호&nbsp;&nbsp;&nbsp;</label>
                                    <select name="sTelNo1" id="sTelNo1" class="vm">
                                        <option value="02">02</option>
                                        <option value="031">031</option>
                                        <option value="032">032</option>
                                        <option value="033">033</option>
                                        <option value="041">041</option>
                                        <option value="042">042</option>
                                        <option value="043">043</option>
                                        <option value="050">050</option>
                                        <option value="051">051</option>
                                        <option value="052">052</option>
                                        <option value="053">053</option>
                                        <option value="054">054</option>
                                        <option value="055">055</option>
                                        <option value="061">061</option>
                                        <option value="062">062</option>
                                        <option value="063">063</option>
                                        <option value="064">064</option>
                                        <option value="070">070</option>
                                    </select>
                                    -
                                    <input type="text" name="sTelNo2" id="sTelNo2" maxlength="4" class="input_txt2 hp">
                                    -
                                    <input type="text" name="sTelNo3" id="sTelNo3" maxlength="4" class="input_txt2 hp">
                                </div>      
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nickname">닉네임</label>
                                        <input type="text" class="form-control" id="nickname"  name="nickname">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="birthday">생년월일</label>
                                        <input type="date" class="form-control " id="birthday" name="birthday">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>주소</label>
                                    <div class="form-group">
                                        <input type="text" name="ZIP" id="ZIP" maxlength="8" class="input_txt2" value="" readonly="" placeholder="우편번호" required>
                                        <a href="javascript:openDaumPostcode();" class="btn btn-warning btn-sm">우편번호 검색</a>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="ADDR_1" id="ADDR_1" maxlength="100" class="input_txt2 adr form-control" value="" readonly="" placeholder="주소" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="ADDR_2" id="ADDR_2" maxlength="100" class="input_txt2 adr form-control" value="" placeholder="상세주소">
                                        도로명 주소를 써주세요. 지번 주소 기재 시 통관/세관에서 오류로 분류시켜 통관지연이 될 수 있습니다
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>이메일 수신</label>
                                        <input type="radio" name="sEmailRcvYN" value="1" checked>
                                        <input type="radio" name="sEmailRcvYN" value="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>SMS 수신</label>
                                        <input type="radio" name="sSmsRcvYN" value="1" checked>
                                        <input type="radio" name="sSmsRcvYN" value="0">
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="저장" />
                            <input type="reset" class="btn btn-default" value="재설정" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
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
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>
<script>
    function fnRealIDChk() {
        var sValId = $("input[name='loginId']").val();
        var url = "/admin/IdChk?"
            + "sMemId="+ sValId;
        var returnvalue="";
        if($.trim(sValId).length < 5 || $.trim(sValId).length > 20){
            $("input[name='IDCheck']").val("0"); 
            document.getElementById("idcheckresult").innerHTML = "<span class=\"active\">5~20자의 영문 소문자와 숫자만 입력하세요.</span>"; 
        }else{ 
            var IDReg = /^[A-z]+[A-z0-9]{4,19}$/g;
            if (!IDReg.test($.trim(sValId))){
                $(frmObj + " input[name='IDCheck']").val("0"); 
                debugger;
                document.getElementById("idcheckresult").innerHTML = "<span class=\"active\">사용할 수 없는 아이디 입니다.</span>";
            }else{
                returnvalue = DoCallbackCommon(url).trim();
                if (returnvalue=="0"){
                    $("input[name='IDCheck']").val("1");
                    document.getElementById("idcheckresult").innerHTML = "<span class=\"active\">사용할 수 있는 아이디 입니다.</span>";
                }else{
                    $("input[name='IDCheck']").val("0");
                    document.getElementById("idcheckresult").innerHTML = "<span class=\"active\">사용할 수 없는 아이디 입니다.</span>"; 
                }
            }
        }
    }
    function openDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                if ( data.userSelectedType == "R" ) {
                    document.getElementById('ZIP').value = data.zonecode;
                    document.getElementById('ADDR_1').value = data.roadAddress;
                    document.getElementById('ADDR_2').focus();
                    //document.getElementById('ADDR_1_EN').value = data.addressEnglish;
                } else {
                    alert("지번주소가 아닌 도로명주소를 선택하십시오.");
                }
            }
        }).open();
    }
</script>