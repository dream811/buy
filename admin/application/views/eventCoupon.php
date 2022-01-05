<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        이벤트쿠폰관리
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary">                    
                    <div class="box-body">
                        <form role="form" id="frmCpnInf1" action="<?php echo base_url() ?>saveCoupon" method="post" role="form">
                            <input type="hidden" name="event" value="1">
                            <input type="hidden" name="id" id="id">
                            <div class="col-xs-12" style="border: 1px solid #a4a8ad;">
                                <div class="box-title">
                                    <h4>배송비 쿠폰 발급</h4>
                                </div>
                                <div class="row">
                                     <div class="col-md-2">
                                        <p>이벤트 쿠폰 종류</p>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select name="event_coupon" class="form-control">
                                                <option value="1">회원가입 이벤트 쿠폰</option>
                                            </select>
                                        </div>    
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <p>쿠폰 타입</p>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select class="form-control" name="coupon_type" id="coupon_type">
                                                <?php if(!empty($types)):?>
                                                    <?php foreach($types as $ttvalue):
                                                     ?>
                                                        <option value="<?=$ttvalue->id?>"><?=$ttvalue->content?></option>
                                                    <?php 
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
                                            <select class="form-control" name="gold_type" id="gold_type">
                                                <option value="1">￦</option>
                                                <option value="2">%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="gold" class="form-control" required id="gold">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <p>유효기간</p>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <input type="number" name="use_terms" maxlength="5" class="form-control"  placeholder="발급일로부터 60일" required id="use_terms">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <p>이벤트 기간</p>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" >
                                            <input class="form-control" size="16" type="text" value="<?=date("Y-m-d")?>" readonly name="terms1" id="terms1">
                                            <span class="input-group-addon" style="width: 39px"><span class="glyphicon glyphicon-calendar">
                                            </span></span>  
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" >
                                            <input class="form-control" size="16" type="text" value="<?=date("Y-m-d")?>" readonly name="terms2" id="terms2">
                                            <span class="input-group-addon" style="width: 39px"><span class="glyphicon glyphicon-calendar">
                                            </span></span>  
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row my-4">
                                    <div class="col-md-2">
                                        <p style="margin: 0">사용여부</p>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="use" class="form-control" id="use"> 
                                            <option value="1">사용</option>
                                            <option value="0">중지</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row my-4 my-3">
                                    <div class="col-xs-12">
                                        <input type="submit" class="btn btn-primary"  value="발급" >
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
                          <th>금액</th>
                          <th>유효기간</th>
                          <th>이벤트 기간</th>
                          <th>사용 여부 </th>
                          <th>쿠폰 종류</th>
                          <th>쿠폰 타입</th>
                          <th>창조일</th>
                          <th></th>
                        </tr>
                        <?php
                        if(!empty($coupon))
                        {
                            foreach($coupon as $record)
                            {
                        ?>
                        <tr>
                            <td><?php echo $record->gold ?></td>
                            <td><?php echo $record->use_terms ?></td>
                            <td><?php echo $record->terms?></td>
                            <td><?=$record->use==1 ? "사용":""?></td>
                            <td><?=$record->event_coupon==1 ?"회원가입 이벤트 쿠폰":"회원가입 추천인 쿠폰"?></td>
                            <td>
                                <?=$record->tcontent?>
                            </td>
                            <td><?=$record->created_date?></td>
                            <td class="text-center">
                              <a class="btn btn-sm btn-info edtCoupon" data-event="<?=$record->id?>"><i class="fa fa-pencil"></i></a>
                              <a class="btn btn-sm btn-danger delCoupon" href="#" data-event="<?=$record->id?>"><i class="fa fa-trash"></i></a>
                          </td>
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

    jQuery(document).on("click", ".edtCoupon", function(){
    var id = $(this).data("event"),
        hitURL = baseURL + "edtCoupon";
      
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { id : id } 
      }).done(function(data){
        var terms1="";
        var terms2="";
        if(data.length > 0){
            terms = data[0].terms.split("|");
            terms1 = terms[0] !=undefined ? terms[0]:"";
            terms2 = terms[1] !=undefined ? terms[1]:"";
            $("#coupon_type").val(data[0].coupon_type);
            $("#gold_type").val(data[0].gold_type);
            $("#gold").val(data[0].gold);
            $("#use_terms").val(data[0].use_terms);
            $("#terms1").val(terms1);
            $("#terms2").val(terms2);
            $("#use").val(data[0].use);
            $("#id").val(data[0].id);
        }
      });
  });
  jQuery(document).on("click", ".delCoupon", function(){
    var id = $(this).data("event"),
      hitURL = baseURL + "delCoupon",
      currentRow = $(this);
    
    var confirmation = confirm("정말 삭제하시겠습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { id : id} 
      }).done(function(data){
        
        currentRow.parents('tr').remove();
        if(data.result == "success") { alert("성공적으로 삭제되였습니다."); }
        else if(data.result == "error") { alert("삭제오유"); }
        else { alert("접근거절..!"); }
      });
    }
  });
</script>