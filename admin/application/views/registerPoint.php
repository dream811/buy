<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        적립포인트
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">                    
                        <div class="box-body">
                            <div class="row border-bottom1">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="role">회원검색</label>
                                        <form action=" " method="get">
                                            <div>
                                                <select class="member" style="padding:3px" name="types">
                                                    <option value="name">회원이름</option>
                                                    <option value="loginId">회원아이디</option>
                                                </select>
                                                <input type="text" name="member" style="padding: 3px">
                                                <input type="submit" value="검색" class="btn btn-secondary">
                                                <?php if(!empty($member)): ?>
                                                    <select class="selectmember" style="padding: 5px"  onchange="fnMemChgVal(this);">
                                                        <option value="">회원을 선택하세요</option>
                                                    <?php foreach($member as $value): ?>
                                                        <option value="<?=$value->userId?>|<?=$value->name?>"><?=$value->name?></option>
                                                    <?php endforeach; ?>
                                                    </select>
                                                <?php endif;?>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                            <form role="form" id="addUser" action="<?php echo base_url() ?>savePointUsers" method="post" role="form">
                                <input type="hidden" name="users" value="" id="users">
                                <div class="row border-bottom1">
                                    <div class="col-md-12">                                
                                        <div class="form-group">
                                            <label for="role">회원</label>
                                            <input type="text" class="form-control required" id="user_names"  required readonly>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row border-bottom1">
                                    <div class="col-md-12">                                
                                        <div class="form-group">
                                            <label for="role">유효기간</label>
                                            <div class="row">
                                                <div class="col-xs-2">
                                                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" >
                                                        <input class="form-control" size="16" type="text" value="<?=date("Y-m-d")?>" readonly name="terms1" >
                                                        <span class="input-group-addon" style="width: 39px"><span class="glyphicon glyphicon-calendar">
                                                        </span></span>  
                                                    </div>
                                                </div>
                                                <div class="col-xs-2">
                                                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" >
                                                        <input class="form-control" size="16" type="text" value="<?=date("Y-m-d")?>" readonly name="terms2" >
                                                        <span class="input-group-addon" style="width: 39px"><span class="glyphicon glyphicon-calendar">
                                                        </span></span>  
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row border-bottom1">
                                    <div class="col-md-12">                                
                                        <div class="form-group">
                                            <label for="role">포인트 금액</label>
                                            <div>
                                                <select name="plus">
                                                    <option value="+" selected="">+</option>
                                                    <option value="-">-</option>
                                                </select>
                                                <input type="text" name="point">
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row border-bottom1">
                                    <div class="col-md-2">                                
                                        <div class="form-group">
                                            <label for="role">상태</label>
                                            <select name="use" class="form-control">
                                                <option value="1">완료</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row my-3 my-4">
                                    <div class="col-xs-12">
                                        <input type="submit" class="btn btn-primary" value="저장" />
                                        <input type="reset" class="btn btn-default" value="취소" />
                                    </div>
                                </div>
                        </div>
    
                        <div class="box-footer">
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <form name="frmList" id="frmList" method="get" action=""> 
            <div class="box-tools">   
              <div class="input-group" style="margin-bottom: 10px">
                <div class="pull-right">
                  <label style="display:block; ">&nbsp;</label>
                  <input class="btn btn-primary btn-sm" value="검색" type="submit">
               </div> 
               <div class="pull-right">
                  <label style="display:block; ">적립방법</label>
                  <select name="shType" id="shType" class="form-control input-sm">
                     <option value="">-전체-</option>
                    <option value="A" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="A" ? "selected":""?>>회원가입포인트</option>
                    <option value="B" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="B" ? "selected":""?>>일정금액포인트</option>
                    <option value="C" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="C" ? "selected":""?>>이벤트포인트</option>
                    <option value="D" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="D" ? "selected":""?>>쇼핑몰포인트</option>
                    <option value="E" <?=empty($_GET['shType'])==0 && $_GET['shType'] =="E" ? "selected":""?>>관리자적립</option>
                  </select>
               </div>
               <div class="pull-right">
                  <label style="display:block; ">구분</label>                                
                  <select name="s" id="s" class="form-control input-sm">
                    <option value="">=전체=</option>
                    <option value="Y" <?=$this->input->get("s")=="Y" ? "selected":"" ?>>=적립=</option>
                    <option value="N" <?=$this->input->get("s")=="N" ? "selected":"" ?>>=사용=</option>
                  </select>
               </div>
               <div class="pull-right">
                 <label style="display: block;">종료일</label>
                 <input type="date" name="ends_date" class="form-control input-sm" 
                 value="<?=empty($_GET['ends_date']) == 0 ? $_GET['ends_date']:"" ?>">
               </div>
               <div class="pull-right">
                 <label style="display: block;">시작일</label>
                 <input type="date" name="starts_date" class="form-control input-sm" 
                 value="<?=empty($_GET['starts_date']) == 0 ? $_GET['starts_date']:"" ?>" >
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
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr class="thead-dark">
                            <th>No </th>
                            <th>회원명(아이디)</th>
                            <th>구분</th>
                            <th>적립방법</th>
                            <th>포인트</th>
                            <th>남은 포인트</th>
                            <th>상태</th>
                            <th>일자</th>
                            <th></th>
                        </tr>
                        <?php
                        if(!empty($pointUser))
                        {
                            foreach($pointUser as $record)
                            {
                        ?>
                        <tr>
                            <td><?php echo $record->id ?></td>
                            <td><?php echo $record->name ?>(<?php echo $record->loginId ?>)</td>
                            <td><?= $record->s==0 ? "적립":"사용" ?></td>
                            <td><?php if($record->s==0 && $record->type==1): ?>
                                    회원가입포인트
                                <?php endif; ?>
                                <?php if($record->s==0 && $record->type==2): ?>
                                    일정금액포인트 
                                <?php endif; ?>
                                <?php if($record->s==0 && $record->type==3): ?>
                                    이벤트포인트
                                <?php endif; ?>
                                <?php if( $record->s==0 && $record->type==4): ?>
                                    관리자 적립  
                                <?php endif; ?>
                                <?php if( $record->s==0 && $record->type==5): ?>
                                    쇼핑몰포인트 적립  
                                <?php endif; ?>
                                <?php if( $record->s==1 && $record->s_type==1): ?>
                                    배송비 적립/사용   
                                <?php endif; ?>
                                <?php if( $record->s==1 && $record->s_type==2): ?>
                                    구매비 적립/사용   
                                <?php endif; ?>
                                <?php if( $record->s==1 && $record->s_type==3): ?>
                                    리턴비 적립/사용   
                                <?php endif; ?>
                                <?php if( $record->s==1 && $record->s_type==4): ?>
                                    추가비 적립/사용   
                                <?php endif; ?></td>
                            <td><?php echo $record->point ?></td>
                            <td><?php echo $record->remain ?></td>
                            <td><?php echo $record->state==1 ? "활성":"취소" ?></td>
                            <td><?php echo $record->created_date ?></td>
                            <td >
                                  <a class="btn btn-sm btn-info <?=$record->state==0 ? "disabled":""?>" 
                                   href="<?php echo base_url().'cancelPoint/'.$record->id; ?>">취소</a>
                                  <a class="btn btn-sm btn-danger deletePointUser" href="#" data-id="<?php echo $record->id; ?>">삭제</a>
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
        </div>
    </section>
</div>

<script>
    var tempArray='';
    var tempUser = [];
    var tempId = '';
    $('.form_date').datetimepicker({
        language:  'kr',
        weekStart: 1,
        autoclose: 1,
        startView: 2,
        forceParse: 0
    });
    function fnMemChgVal(sObj) { 
        if(sObj.value =="") return;
        var temp = sObj.value.split("|");
        if(tempUser[temp[0]] !=null) return;
        tempUser[temp[0]] = temp[1];    
        tempArray = tempArray+temp[1];
        tempArray = tempArray+",";
        tempId = tempId+temp[0];
        tempId = tempId+",";
        $("#user_names").val(tempArray);
        $("#users").val(tempId);
    }

    jQuery(document).on("click", ".deletePointUser", function(){
        var id = $(this).data("id"),
            hitURL = baseURL + "deletePoint",
            currentRow = $(this);
        
        var confirmation = confirm("이 포인트를 삭제하시겠습니까 ?");
        
        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { id : id } 
            }).done(function(data){
                console.log(data);
                currentRow.parents('tr').remove();
            });
        }
    });
</script>