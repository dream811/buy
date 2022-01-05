<?php $contact_size = sizeof($contacts); ?>
<div class="container">
	<div class="row">
		<?php $this->load->view("left_menu",array("left"=>"my")); ?>
		<div id="subRight" class="col-md-9">           
			<div class="padgeName">
				<h2>마이홈</h2>
			</div>
			<div class="con">
				<div class="row header_my pt-5 pb-5">
					<div class="col-md-6">
						<span class="clrMemLvl1 text-white"><?=$this->session->userdata('fname')?></span> 	
						<span  class="clrMemLvl1 font-weight-bold  text-white">고객님</span><br>
					</div>
					<div class="col-md-6 text-right" style="line-height: 39px;height: 39px">
						<a href="#" class="btn text-white btn-sm btn-yonpu btn-round" data-toggle="modal" data-target="#table_modal">나의 배송요금표</a>
						<a href="#" class="btn text-white btn-sm btn-yonpu btn-round" data-toggle="modal" data-target="#address_modal">나의 사서함주소</a>
						<a href="#" class="btn text-white btn-sm btn-yonpu btn-round" data-toggle="modal" data-target="#contact_modal">나의 주소관리</a>
					</div>
				</div>
				<div class="row my-10">
					<div class="col-xs-12">
						<div style="font-weight:bold;color:#000000;">나의 배송현황</div>
					</div>
				</div>
				<div class="row myPageTab2">
					<?php foreach($category as $value): ?>
						<div class="col-md-5 col-sm-4 col-xs-6 text-center">
							<img src="<?=$value->image?>" height=32>
							<h3><?=$value->title?></h3>
							<ul>
								<?php foreach($delivery[$value->step] as $child): ?>
									<li>
										<a href="/mypage?step=<?=$child->step?>" class="<?=$step==$child->step?"selected":""?>">
											<span ><?=$child->name?></span><span class="fr">
												<?php if(isset($step_array[$child->step]) && $step_array[$child->step] > 0 && $child->step!=12) 
												echo $step_array[$child->step]; ?>
												<?php if($child->step==12) echo $errorCoutr; ?>
												<?php if(!isset($step_array[$child->step]) && $child->step!=12) echo 0; ?>
											</span>
										</a>
									</li>
								<?php endforeach; ?>						
							</ul>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="row">
					<form method="get" action="<?=base_url()?>mypage" id="frmS">
						<div class="col-xs-12 p-left-1 p-right-1">
							<div class="input-group mb-10">
				                 <div class="pull-right p-1">
				                 	<input type="hidden" name="today" id="today" value="<?= !empty($_GET['today']) ? $_GET['today']:""?>">
				                    <select class="form-control form-control-sm" name="process">
				                    	<option value="1" 
				                    	<?php if(!empty($_GET['process']) && $_GET['process'] == "1" || empty($_GET['[process']))  echo 'selected'; ?>
				                    	>처리순</option>
				                    	<option value="2"
				                    	<?php if(!empty($_GET['process']) && $_GET['process'] == '2') echo 'selected';?>>등록순</option>
				                    </select>
				                 </div> 
				                 <div class="pull-right p-1">
				                   <a href="javascript:fnSearchDate('D1');" class="btn-sm btn btn-round  <?= !empty($_GET['today']) && $_GET['today'] == 'D1' ? "btn-dark":"btn-charo text-white"; ?>">오늘</a>
				                 </div> 
				                 <div class="pull-right p-1">
				                   <a href="javascript:fnSearchDate('D7');" class="btn-sm btn btn-round  <?= !empty($_GET['today']) && $_GET['today'] == 'D7' ? "btn-dark":"btn-charo text-white"; ?>">1주일</a>
				                 </div>
				                 <div class="pull-right p-1">
				                   <a href="javascript:fnSearchDate('M1');" class="btn-sm btn btn-round  <?= !empty($_GET['today']) && $_GET['today'] == 'M1' ? "btn-dark":"btn-charo text-white"; ?>">1개월</a>
				                 </div>
				                 <div class="pull-right p-1">
				                   <a href="javascript:fnSearchDate('M3');" class="btn-sm btn btn-round  <?= !empty($_GET['today']) && $_GET['today'] == 'M3' ? "btn-dark":"btn-charo text-white"; ?>">3개월</a>
				                 </div>
				                 <div class="pull-right p-1">
				                   <a href="javascript:fnSearchDate('');" class="btn text-white btn-round btn-sm  
				                   <?= empty($_GET['today']) || $_GET['today'] == "" ? "btn-dark":"btn-charo text-white"; ?>
				                   ">전체</a>
				                 </div>
				                 <div class="pull-right p-1">
				                  <input type="date" name="from" class="form-control input-sm" 
                     value="<?=empty($_GET['from']) == 0 ? $_GET['from']:date("Y-m-d", time()-7776000) ?>">
				                 </div>
				                 <div class="pull-right p-1">
				                   <input type="date" name="to" class="form-control input-sm" 
                     value="<?=empty($_GET['to']) == 0 ? $_GET['to']:date("Y-m-d") ?>">
				                 </div>
							</div>
						</div>
						<div class="col-xs-12 border-2-top"  style="background:#eeeeee;">
							<div class="input-group mb-10 my-15" >
				                 <div class="pull-right p-1">
				                    <label style="display:block;" class="text-center">주문번호 </label>
				                    <input type="text" name="search_ptracking" class="form-control input-sm" style="width: 150px;" 
				                     value="<?=empty($_GET['search_ptracking']) == 0 ? $_GET['search_ptracking']:"" ?>" >
				                 </div> 
				                 <div class="pull-right p-1">
				                   <label style="display:block; " class="text-center">트래킹번호</label>
				                    <input type="text" name="search_tracking_number"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['search_tracking_number']) == 0 ? $_GET['search_tracking_number']:"" ?>">
				                 </div> 
				                 <div class="pull-right p-1">
				                   <label style="display:block; " class="text-center">수취인명</label>
				                    <input type="text" name="search_receiver"  class="form-control input-sm" style="width: 150px;" 
				                    value="<?=empty($_GET['search_receiver']) == 0 ? $_GET['search_receiver']:""?>">
				                 </div> 
				                 <div class="pull-right p-1">
				                   <label style="display:block; " class="text-center">오더넘버</label>
				                    <input type="text" name="search_porder" class="form-control input-sm" style="width: 150px;" 
				                    value="<?=empty($_GET['search_porder']) == 0 ? $_GET['search_porder']:"" ?>">
				                 </div> 
				                 <div class="pull-right p-1">
				                    <label style="display:block; ">&nbsp;</label>
				                    <input class="btn btn- btn-sm btn-yonpu text-white btn-round" value="검색" type="submit">
				                </div> 
							</div>

						</div>
					
					</form>	
				</div>
				<form name="frmSearch" id="frmSearch" method="post" action="" class="my-4">
					<input type="hidden" name="did" id="did">
					<div class="table-responsive">
						<table class="table table-bordered vertical-none">
							<colgroup>
								<col width="25%">
								<col width="18.75%">
								<col width="18.75%">
								<col width="20%">
								<col width="15%">
							</colgroup>
							<thead class="thead-jin">
						      <tr>
						        <th scope="col" class="mid text-center">
						        	<input type="checkbox" onclick="fnChkBoxTotal(this, 'chkORD_SEQ');">
						        주문정보</th>
						        <th scope="col" class="mid">등록일</br>처리일</th>
						        <th scope="col" class="mid">상품가격</th>
						        <th scope="col" class="mid">결제금액/운송장번호</th>
						        <th scope="col" class="mid">상태</th>
						      </tr>
						    </thead>
						    <tbody>
							     <?php  foreach($deliver_content as $dvalue): ?>
							     	<tr>
							     		<td class="mid">
											<a href="/view/delivery/<?=$dvalue->rid?>" class="bold blue">
												<?=$dvalue->ordernum?></a> I 
												<?=$dvalue->area_name?><br>
												<span class="font-weight-bold">
													<?php 
															if($dvalue->type=="1") echo '배송대행';
															if($dvalue->type=="2") echo '구매대행';
															if($dvalue->type=="4") echo '리턴대행';
															if($dvalue->type=="3") echo '쇼핑몰';
													?>
												</span>
												<?php  if($dvalue->pcount >1) echo ' I 합배송';else echo ' I 단독배송'; ?>
												<?php  	if($dvalue->combine == 1) echo ' I 묶음배송';
														if($dvalue->combine == 2) echo ' I 나눔배송'; ?>
												<br><label>
													<input type="checkbox" class="input_chk" name="chkORD_SEQ" id="chkORD_SEQ" value="<?=$dvalue->id?>">&nbsp;&nbsp;<?=$dvalue->billing_krname?></label>
												<br><a href="javascript:viewProducts(<?=$dvalue->id?>)"  class="btn btn-sm btn-secondary mt-5 btn-round"><span>상품보기</span>
											</a>
										</td>
										<td class="mid ">
											<?=date("Y-m-d",strtotime($dvalue->created_date))?>
											</br>
											<?=date("Y-m-d",strtotime($dvalue->updated_date))?>
										</td >
										<td class="mid"><?=number_format($dvalue->pprice,2)?>(<?=$dvalue->type ==3 ? "원":"￥"?>)</td>
										<td class="mid ">
											<?php if($dvalue->purchase_price > 0): ?>
												<a href="javascript:fnChaView(<?=$dvalue->id?>);" class="modalPop" wd="500" ht="250" ><strong>구매비용(<?php if($dvalue->payed_checked==1) echo '완료';else echo '미입금'; ?>)</strong><br><?=number_format(str_replace(",","",$dvalue->purchase_price))?>원</a>
											<?php endif; ?>
											<?php if($dvalue->sending_price > 0): ?>
												<br>
												<a href="javascript:fnChaView(<?=$dvalue->id?>);" class="modalPop" wd="500" ht="250" ><strong>배송비용(<?php if($dvalue->payed_send==1) echo '완료';else echo '미입금'; ?>)</strong><br><?=number_format(str_replace(",","",$dvalue->sending_price))?>원</a>
											<?php endif; ?>
											<?php if($dvalue->return_price > 0): ?>
												<br>
												<a href="javascript:fnChaView(<?=$dvalue->id?>);" class="modalPop" wd="500" ht="250" ><strong>리턴비용(<?php if($dvalue->return_check==1) echo '완료';else echo '미입금'; ?>)</strong><br><?=number_format(str_replace(",","",$dvalue->return_price))?>원</a>
											<?php endif; ?>
											<?php if($dvalue->add_check==1): ?><br>
												<a href="javascript:fnChaView(<?=$dvalue->id?>);" class="modalPop" wd="500" ht="250" ><strong>추가결제비용(미입금)</strong><br><?=number_format(str_replace(",","",$dvalue->add_price))?>원</a>
											<?php endif; ?>

											<?php if($dvalue->add_check==0 && $dvalue->add_check!=NULL): ?><br>
												<a href="javascript:fnChaView(<?=$dvalue->id?>);" class="modalPop" wd="500" ht="250" ><strong>추가결제비용(완료)</strong><br><?=number_format(str_replace(",","",$dvalue->add_price))?>원</a>
											<?php endif; ?>
											<?php if($dvalue->add_check==2): ?><br>
												<a href="javascript:fnChaView(<?=$dvalue->id?>);" class="modalPop" wd="500" ht="250" ><strong>추가결제비용(결제대기중)</strong><br><?=number_format(str_replace(",","",$dvalue->add_price))?>원</a>
											<?php endif; ?>
											<?php if($dvalue->add_check==3): ?><br>
												<a href="javascript:fnChaView(<?=$dvalue->id?>);" class="modalPop" wd="500" ht="250" ><strong>추가결제비용(취소)</strong><br><?=number_format(str_replace(",","",$dvalue->add_price))?>원</a>
											<?php endif; ?>
											<?php if($dvalue->state == 16 || $dvalue->state == 23): ?>
												<a target="_blank" href="https://www.doortodoor.co.kr/parcel/pa_004.jsp" class="btn-block text-danger"><?=$dvalue->tracking_number?></a>
											<?php endif; ?>
										</td>
										<td class="mid">
											<?php if(trim($dvalue->Dcomment)!="" && $dvalue->Duse==1): ?>
					                            <button type="button" class="btn btn-super-sm btn-grey btn-round btn-block " onclick="fnFrgImgView2('<?=$dvalue->id?>');" >메모&실사</button>
					                        <?php endif; ?>
					                        <?php if($dvalue->pays ==1) { ?> <a href="#" class="btn btn-warning disabled btn-super-sm btn-round btn-block ">승인대기</a> <?php } ?>
											<?php if($dvalue->state==5 || $dvalue->state==14 || $dvalue->state==20): ?>
											<a href="/mypay" class="btn btn-warning btn-super-sm btn-round btn-block ">결제대기</a>
											<?php endif; ?>
											<?php if($dvalue->state!=5 && $dvalue->state!=14 && $dvalue->state!=20 && $dvalue->add_check==1): ?>
												<a href="/mypay" class="btn btn btn-warning btn-super-sm btn-round btn-block ">결제대기</a>
											<?php endif; ?>
											<?php if($dvalue->state ==40): ?>
												<a  class="btn btn-warning btn-super-sm disabled btn-round btn-block ">배송비 제출중</a>	
											<?php endif; ?>
											
					                        <?php if($dvalue->state ==23 && !empty($dvalue->tracking_number)): ?>
												<a href="https://unipass.customs.go.kr/csp/index.do" target="_blank"  class="btn btn-super-sm btn-grey text-white btn-round btn-block ">통관조회</a>
											<?php endif; ?>
											<?php if($dvalue->state ==1 || $dvalue->state ==4): ?> 
												<a href="/view/delivery/<?=$dvalue->rid?>" class="btn btn-grey btn-super-sm btn-round btn-block ">수정</a>	
											<?php endif; ?>
											<?php if($dvalue->state ==11):?>
												<a href="javascript:requestDelivery(<?=$dvalue->id?>,<?=$dvalue->ordernum?>);" class="btn btn-danger btn-super-sm btn-round btn-block ">배송요청</a>
											<?php endif; ?>
											<?php if($dvalue->state ==2 || $dvalue->state ==11 || $dvalue->state ==7): ?>
												<a href="javascript:fnPopPlus(<?=$dvalue->id?>);" class="btn btn-yonpu btn-super-sm text-white btn-round btn-block 
												<?php if($dvalue->combine !=-1) echo 'disabled' ?>">묶음배송</a>
												<a href="javascript:fnPopMinus(<?=$dvalue->id?>);" href="#" class="btn btn-yonpu btn-super-sm text-white btn-round btn-block 
													<?php if($dvalue->combine !=-1) echo 'disabled' ?>">나눔배송</a>
											<?php endif; ?>
										</td>
							     	</tr>
							     	<tr id="dproduct<?=$dvalue->id?>"></tr>
							     <?php  endforeach;?>
						  	</tbody>
						</table>
					</div>
				</form>	
				<div class="text-center">
	            	<?php echo $this->pagination->create_links(); ?>
	         	 </div>
				<div class="row my-4">
					<?php //if($step ==1): ?>
						<!-- <a href="javascript:acceptOrder()" class="btn btn-secondary btn-sm">주문신청</a> -->
					<?php //endif; ?>
					<?php if($step ==1 || $step ==4 || $step ==14  || $step ==5): ?>
						<a href="javascript:deleteOrder()" class="btn btn-warning btn-round">주문삭제</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="table_modal">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content" style="height: 80vh;">
      <div class="modal-header text-center">
        <h5 class="modal-title">배송 요금표</h5>
      </div>
      <div class="modal-body">
      	 <p class="text-center"><?=$this->session->userdata("fname")?>회원님은 <?=$user[0]->role?> 등급 혜택을 적용 받고 있습니다.</p>
        <iframe src="/getPricesByRole" style="width: 100%;border:none;height: calc(80vh - 188px);"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-round" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="address_modal">
	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	<div class="modal-body" style="height: 500px">
	        	<iframe src="<?=base_url()?>MemCtr_S" width="100%" height="100%"></iframe>
	    	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-danger btn-round" data-dismiss="modal">닫기</button>
	      	</div>
	    </div>
	 </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="contact_modal">
	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">배송지 목록</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="table-responsive">
				<table class="table table-dark">
					<thead>
				      <tr>
				        <th scope="col">NO</th>
				        <th scope="col">수취인</th>
				        <th scope="col">주소</th>
				        <th scope="col">상세주소</th>
				        <th scope="col"></th>
				      </tr>
				    </thead>
				    <tbody>
				    	<?php if(!empty($contacts)): ?>
				    		<?php foreach($contacts as $value): ?>
				    			<tr>
				    				<td><?=$contact_size?></td>
				    				<td><?=$value->name?></td>
				    				<td><?=$value->address?></td>
				    				<td><?=$value->details_address?></td>
				    				<td>
				    					<a href="#" class="btn btn-sm btn-warning editContact btn-round" data-delivery="<?=$value->id?>">수정</a>
				    					<a href="javascript:void();" class="btn btn-sm btn-danger deleteContact btn-round" data-delivery="<?=$value->id?>">삭제</a>
				    				</td>
				    			</tr>
				    			<?php $contact_size = $contact_size - 1; ?>
				    		<?php endforeach; ?>
				    	<?php endif; ?>	
				    </tbody>
				</table>
	      </div>
	      <div class="modal-footer" style="text-align: center;">
	      	<a href="#" class="btn btn-danger btn-sm btn-round" onclick="goToRegister()">등록</a>
	        <button type="button" class="btn btn-default btn-sm btn-round" data-dismiss="modal">닫기</button>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="register_form">
	<form action="<?=base_url()?>registerContact" method="post"  id="registerContact">
		<div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header text-center">
		        <h5 class="modal-title">배송지 등록</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <div class="table-responsive">
		        	<table  class="table table-bordered">
		        		<tbody>
						    <tr>
						      	<th scope="row" class="mid text-center"><label for="postcode">우편번호</label></th>
						      	<td class="mid">
								    <input type="text" name="postcode" required id="postcode">.
								    <a href="javascript:openDaumPostcode();" class="btn btn-warning btn-sm btn-round">주소검색</a>
								    <input type="hidden" name="page" value="mypage">
								    <input type="hidden" name="id" value="" id="del_id">
								</td>
						    </tr>
						    <tr>
						      <th scope="row" class="mid text-center"><label for="address">주소</label></th>
						      <td class="mid">
						      	<input type="text" class="form-control" name="address" readonly placeholder="한글" required id="address">
						      </td>
						    </tr>
						    <tr>
						      <th scope="row" class="mid text-center"><label for="details">상세주소</label></th>
						      <td class="mid"><input type="text" class="form-control" name="details" id="details"></td>
						    </tr>
						    <tr>
						      <th scope="row" class="mid text-center"><label for="name">수취인 이름(한글)</label></th>
						      <td class="mid"><input type="text" class="form-control" name="name" required id="name"></td>
						    </tr>
						    <tr>
						      <th scope="row" class="mid text-center"><label for="eng_name">수취인 이름(영문)</label></th>
						      <td class="mid"><input type="text" class="form-control" name="eng_name" id="eng_name"></td>
						    </tr>
						    <tr>
						      <th scope="row" class="mid text-center"><label>연락처</label></th>
						      <td class="mid">
						      		<div class="row grid">
									  	<div class="col">
									  		<input type="text" name="p1" class="form-control" required id="p1">
									  	</div>
									  	<div class="col">
									  		<input type="text" name="p2" class="form-control" required id="p2">
									  	</div>
									  	<div class="col">
									  		<input type="text" name="p3" class="form-control" required id="p3">
									  	</div>
									</div>
								</td>
						    </tr>
						    <tr>
						      <th scope="row" class="mid text-center"><label>받는 사람 정보</label></th>
						      <td class="mid">
							      	<div class="form-check form-check-inline">
									  <input class="form-check-input" type="radio" id="inlineCheckbox1" value="1" name="type" checked>
									  <label class="form-check-label" for="inlineCheckbox1">개인통관고유부호 (추천)</label>
									</div>
									<div class="form-check form-check-inline">
									  <input class="form-check-input" type="radio" id="inlineCheckbox2" value="2" name="type">
									  <label class="form-check-label" for="inlineCheckbox2">사업자번호</label>
									</div>
									<input type="text" class="form-control" name="RRN_NO" id="RRN_NO">
								</td>
						    </tr>
						</tbody>
		        	</table>
		      	</div>
		      <div class="modal-footer" style="text-align: center;">
		      	<a href="Javascript:void(0)" onclick="registerAdds(this);" class="btn btn-danger btn-sm btn-round" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> 처리중">
		      		배송지 등록
		      	</a>
		      	<a href="#" class="btn btn-default btn-sm btn-round" onclick="closeRegister();">목록</a>
		      </div>
		    </div>
		  </div>
		</div>
	</form>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="details_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">결제내역상세</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="silsa_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">실사내역</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
       		<iframe id="ifrm"  frameborder="0" width="100%" height="600"></iframe>
      </div>
    </div>
  </div>
</div>

 <link href="<?php echo site_url('/template/css/my.css'); ?>?<?=time()?>" rel="stylesheet">
<script language="JavaScript">
	function goToRegister(){
		$("#contact_modal").modal('toggle');
		$("#register_form").modal('show');
	    $("#postcode").val("");
	    $("#address").val("");
	    $("#details").val("");
	    $("#name").val("");
	    $("#eng_name").val("");
	    $("#p1").val("");
	    $("#p2").val("");
	    $("#p3").val("");
	    $("#RRN_NO").val("");
		$("#del_id").val("");
	}
	function openDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
				if ( data.userSelectedType == "R" ) {
					document.getElementById('postcode').value = data.zonecode;
					document.getElementById('address').value = data.roadAddress;
					document.getElementById('details').focus();
					//document.getElementById('ADDR_1_EN').value = data.addressEnglish;
				} else {
					alert("지번주소가 아닌 도로명주소를 선택하십시오.");
				}
            }
        }).open();
    }

    function closeRegister(){
    	$("#contact_modal").modal('show');
		$("#register_form").modal('toggle');
    }
    $(".deleteContact").click(function(){
    	currentRow = $(this);
    	var id=$(this).data("delivery");
    	if(id > 0){
    		var message = confirm("정말 삭제하시겠습니까?");
	    	if(message){
	    		$.ajax({
				  method: "POST",
				  url: "deleteContact",
				  data: { id:id}
				})
				.done(function( msg ) {
				    currentRow.parents('tr').remove();
				});
	    	}
    	}
    });

    $(".editContact").click(function(){
    	var contact_modal = $("#contact_modal");
    	var register_form = $("#register_form");
    	var id=$(this).data("delivery");
    	var register_form = $("#register_form");
    	$.ajax({
		  	method: "POST",
		  	url: baseURL+"getContact",
		  	data: { id:id},
		  	dataType:'json'
		})
		.done(function( msg ) {
		    register_form.find("#del_id").val(msg[0].id);
		    register_form.find("#postcode").val(msg[0].postcode);
		    register_form.find("#address").val(msg[0].address);
		    register_form.find("#details").val(msg[0].details_address);
		    register_form.find("#name").val(msg[0].name);
		    register_form.find("#eng_name").val(msg[0].eng_name);
		    register_form.find("#p1").val(msg[0].phone.split("-")[0]);
		    register_form.find("#p2").val(msg[0].phone.split("-")[1]);
		    register_form.find("#p3").val(msg[0].phone.split("-")[2]);
		    register_form.find("#RRN_NO").val(msg[0].unique_info);
		    if(msg[0].type==1) register_form.find("#inlineCheckbox1").attr('checked', 'checked');
		    else register_form.find("#inlineCheckbox2").attr('checked', 'checked');
		    contact_modal.modal('toggle');
			register_form.modal('show');
		});

    });
    function viewProducts(id){ 
    	if($("#dproduct"+id).text().trim() == "") fnGetChgHtmlAjax("dproduct"+id,baseURL+"getDproducts","?dp="+id);
    	else{
    		if($("#dproduct"+id).is(":visible")) $("#dproduct"+id).hide();
    		else  $("#dproduct"+id).show();
    	}
    	
    }

    function deleteOrder() {

    	var frmObj = "#frmSearch";
		var did = "";
		$(frmObj + " input[name='sKind']").val("D");

		if (fnSelBoxCnt($(frmObj + " input[name='chkORD_SEQ']")) <= 0) {
			alert('삭제할 주문을 선택하십시오.');
			return;
		}
		$(frmObj + " input[name='chkORD_SEQ']").each(function(){
			if($(this).is(":checked")) did = did+$(this).val()+"|";
		});
		$(frmObj + " input[name='did']").val(did);
		if (confirm("주문을 삭제 하시겠습니까?\n삭제시 복구가 불가능합니다.")) { 
			$("#frmSearch").attr("method", "post").attr("action", "./deletesO");
			$("#frmSearch").submit();
		}
    }

    function acceptOrder() {

    	var frmObj = "#frmSearch";
		var did = "";
		$(frmObj + " input[name='sKind']").val("D");

		if (fnSelBoxCnt($(frmObj + " input[name='chkORD_SEQ']")) <= 0) {
			alert('신청할 주문을 선택하십시오.');
			return;
		}
		$(frmObj + " input[name='chkORD_SEQ']").each(function(){
			if($(this).is(":checked")) did = did+$(this).val()+"|";
		});
		$(frmObj + " input[name='did']").val(did);
		if (confirm("정말 신청하시겠습니까?")) { 
			$("#frmSearch").attr("method", "post").attr("action", "./acceptO");
			$("#frmSearch").submit();
		}
    }

    function fnSearchDate(value){
    	$("#today").val(value);
    	$("#frmS").submit();
    }
    function fnChaView(id){

		jQuery.ajax({
			type : "POST",
			url : baseURL+"getTotalDelivery",
			data : { delivery_id : id ,my:1} 
			}).done(function(data){
				$("#details_modal").modal("show");
				$("#details_modal .modal-body").html(data);
		});
	}

	function requestDelivery(id,ordernum){
		$.ajax({
		  	method: "POST",
		  	url: "<?=base_url()?>requestDelivery",
		  	data: { id:id},
		  	dataType:'json',
		  	success: function(data) {
                if(data.status==100){
                	socket.emit("chat message",1,ordernum,<?=$this->session->userdata('fuser')?>,
                		"reqdelivery","<?=$this->session->userdata('fname')?>");
			    	window.location.href ="/mypage?step=40";
			    }
			    if(data.status==102) {
			    	alert("오류입고된 상품을 확인해주세요");
			    	return;
			    }
            },
            error: function(data) {
                alert("서버오류");
            }
		});
	}


function registerAdds(obj){

	if ( !fnIptChk($("input[name='postcode']"))) {

		fnMsgFcs($("input[name='postcode']"), '우편번호를 입력해 주세요');
		return;
	}

	if ( !fnIptChk($("input[name='address']"))) {

		fnMsgFcs($("input[name='address']"), '주소명을 입력해 주세요.');
		return;
	}

	if ( !fnIptChk($("input[name='details']"))) {

		fnMsgFcs($("input[name='details']"), '상세주소명을 입력해 주세요.');
		return;
	}

	if ( !fnIptChk($("input[name='name']"))) {

		fnMsgFcs($("input[name='name']"), '수취인이름을 입력해 주세요.');
		return;
	}

	if ( !fnIptChk($("input[name='eng_name']"))) {

		fnMsgFcs($("input[name='eng_name']"), '수취인이름(영문)을 입력해 주세요.');
		return;
	}

	if ( !fnIptChk($("input[name='p1']"))) {

		fnMsgFcs($("input[name='p1']"), '연락처를 입력해 주세요.');
		return;
	}

	if ( !fnIptChk($("input[name='p2']"))) {

		fnMsgFcs($("input[name='p2']"), '연락처를 입력해 주세요.');
		return;
	}

	if ( !fnIptChk($("input[name='p3']"))) {

		fnMsgFcs($("input[name='p3']"), '연락처를 입력해 주세요.');
		return;
	}

	if ( !fnIptChk($("input[name='RRN_NO']"))) {

		fnMsgFcs($("input[name='RRN_NO']"), '받는 사람 정보를 입력해 주세요.');
		return;
	}

	var $this = $(obj);
	var formData = new FormData(document.getElementById("registerContact"));
	$.ajax({
        method: "POST",
        url: baseURL + "registerContact",
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function() {
	      	$this.button('loading');  
	    },
        success: function (data) {
        	$this.button('reset');
        	alert("성공적으로 등록했습니다.");
        	location.reload();
        },
        error: function(request, status, error) {
        	alert("서버오류");
            $this.button('reset');
        }
    });
}
function gotoRequest(data = "",option=""){
	if(data.trim() !="")
		socket.emit("chat message",1,data,"<?=$this->session->userdata('fuser')?>", option,"<?=$this->session->userdata('fname')?>");
	location.href= "<?=base_url()?>mypage?step=40";
}
</script>