<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        포인트등록관리
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
                <div class="box box-primary">                    
                    <div class="box-body">
                        <form role="form" id="frmCpnInf1" action="<?php echo base_url() ?>savePointByRegister" method="post" role="form">
                            <input type="hidden" name="event" value="0">
                            <div class="col-xs-12" style="border: 1px solid #a4a8ad;">
                                <div class="box-title">
                                    <h4>일정 금액 이상 포인트발급</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <p>금액</p>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <select class="form-control" name="from_gold">
                                                <?php for($i=1;$i<=100;$i++){?>
                                                	<option value="<?=$i?>"><?=$i?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <p>포인트 구분</p>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <select class="form-control" name="point_type">
                                                <option value="1">￦</option>
                                                <option value="2">%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group">
                                            <input type="text" name="point" class="form-control"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-4 my-3">
                                    <div class="col-xs-12">
                                        <input type="submit" value="발급" class="btn btn-primary">
                                        <input type="reset" class="btn btn-secondary"  value="취소">
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>  
                </div>
            </div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="box-body table-responsive no-padding">
	              	<table class="table table-hover">
	                	<tr class="thead-dark">
	                  		<th>일정 금액</th>
	                  		<th>포인트</th>
	                  		<th>변경일</th>
	                  		<th></th>
	                	</tr>
	                	<?php if(!empty($p)): ?>
	                	<?php foreach($p as $value): ?>
	                		<tr class="thead-dark">
		                  		<td><?=$value->from_gold?></td>
		                  		<td><?=$value->point?><?=$value->point_type==1 ? "원":"%"?></td>
		                  		<td><?=$value->created_date?></td>
		                  		<td><a href="javascript:void(0)" class="btn btn-danger btn-sm deletePointR" data-id="<?=$value->id?>">삭제</a></td>
		                	</tr>
	                	<?php endforeach;?>
	                	<?php endif;?>
	              	</table>
	            </div>
			</div>
		</div> 
	</section>
</div>
<script type="text/javascript">
	jQuery(document).on("click", ".deletePointR", function(){
		var id = $(this).data("id"),
			hitURL = baseURL + "deletePointR",
			currentRow = $(this);
		
		var confirmation = confirm("해당 포인트를 삭제하시겠습니까 ?");
		
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
				if(data.status = true) { alert("삭제되였습니다"); }
				else if(data.status = false) { alert("실패"); }
				else { alert("서버 오류..!"); }
			});
		}
	});
</script>