<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        쿠폰발급회원
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary">                    
                    <div class="box-body">
                        <div class="row my-3">
                             <div class="col-md-6">
                                <a class="btn btn-primary" href="coupon_register">회원검색</a>
                                <a class="btn btn-primary" href="coupon_register?page_type=level">회원등급</a>
                            </div>
                        </div>
                        <div class="row my-3">
                            <form action="coupon_register" method="get">
                                <?php if(empty($_GET["page_type"]) || $_GET["page_type"]!="level"): ?>
                                    <div class="col-md-2">
                                        <select class="form-control memberType" name="type">
                                            <option value="name">이름</option>
                                            <option value="nickname">닉네임</option>
                                            <option value="loginId">아이디</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="te양xt" name="content" class="memberVisible form-control" placeholder="회원검색" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit" class="btn btn-primary" value="검색">
                                    </div>
                                <?php endif;?>
                                <?php if(!empty($_GET["page_type"]) && $_GET["page_type"]=="level"): ?>
                                    <div class="col-md-12">
                                        <?php if(!empty($roles)): ?>
                                        <?php foreach($roles as $vr): ?>
                                            <input type="radio" name="gender" value="<?=$vr->roleId?>" 
                                            <?php if($this->input->get("gender")==$vr->roleId) echo "checked"; ?> > <?=$vr->role?> &nbsp;
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                        <input type="hidden" name="page_type" value="level">
                                        <input type="submit" class="btn btn-primary" value="검색">
                                    </div>
                                <?php endif;?>
                            </form>
                        </div>
                        <form role="form" id="frmCpnInf1" action="<?php echo base_url() ?>saveCoupon" method="post" role="form">
                            <input type="hidden" name="chkMemCode">
                            <input type="hidden" name="event" value="0">
                            <div class="col-xs-6" style="border: 1px solid #a4a8ad;">
                                <div class="box-title">
                                    <h4>배송비 쿠폰 발급</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <p>쿠폰 타입</p>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group">
                                            <select class="form-control" name="coupon_type">
                                                <?php if(!empty($types)):?>
                                                    <?php foreach($types as $ttvalue):
                                                        if($ttvalue->type==1):
                                                     ?>
                                                        <option value="<?=$ttvalue->id?>"><?=$ttvalue->content?></option>
                                                    <?php 
                                                endif;
                                                endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <p>금액 구분</p>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <select class="form-control" name="gold_type">
                                                <option value="1">￦</option>
                                                <option value="2">%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group">
                                            <input type="text" name="gold" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <p>유효기간</p>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" >
                                            <input class="form-control" size="16" type="text" value="<?=date("Y-m-d")?>" readonly name="terms1" >
                                            <span class="input-group-addon" style="width: 39px"><span class="glyphicon glyphicon-calendar">
                                            </span></span>  
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" >
                                            <input class="form-control" size="16" type="text" value="<?=date("Y-m-d")?>" readonly name="terms2" >
                                            <span class="input-group-addon" style="width: 39px"><span class="glyphicon glyphicon-calendar">
                                            </span></span>  
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-4 my-3">
                                    <div class="col-xs-12">
                                        <a href="javascript:void(0);" class="btn btn-primary"  onclick="fnCpnReg('frmCpnInf1');">발급</a>
                                        <input type="reset" class="btn btn-secondary"  value="취소">
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>  
                </div>
            </div>
        </div> 
        <div class="row my-4" id="frmMemList">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr class="thead-dark">
                          <th>
                            <input type="checkbox" class="input_chk" title="선택" name="MemCode_All" id="MemCode_All" value="total" onclick="fnChkBoxTotal(this, 'rtx');">
                          No</th>
                          <th>회원명</th>
                          <th>닉네임(회원레벨)</th>
                          <th>이메일</th>
                          <th>핸드폰</th>
                        </tr>
                        <?php
                        if(!empty($member))
                        {
                            foreach($member as $record)
                            {
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="rtx"  class="chkMemCode" value="<?=$record->userId ?>">
                                <?=$record->userId ?></td>
                            <td><?php echo $record->name ?></td>
                            <td><?php echo $record->nickname ?>(<?=$record->role?>)</td>
                            <td><?php echo $record->email ?></td>
                            <td><?php echo $record->mobile ?></td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>  
                </div>
            </div>
        </div>
    </section>
    
</div>

<script>
    $('.form_date').datetimepicker({
        language:  'kr',
        weekStart: 1,
        autoclose: 1,
        startView: 2,
        forceParse: 0
    });
    function fnCpnReg(frmNm) { 
        var frmObj = "#" + frmNm;

        if (fnSelBoxCnt($("#frmMemList input[class='chkMemCode']")) <= 0) {
            alert('쿠폰을 발급할 회원을 선택하십시오.');
            return;
        }

        if ( Number($(frmObj + " input[name='gold']").val()) <= 0 ) {
            fnMsgFcs($("#CPN_MNY"), '쿠폰 금액을 입력하세요.');
            return;
        }

        $(frmObj + " input[name='chkMemCode']").val( fnGetChkboxValue($("#frmMemList").find(".chkMemCode")) );
        $(frmObj).attr("action", "./saveCoupon");
        $(frmObj).submit(); 
}
</script>