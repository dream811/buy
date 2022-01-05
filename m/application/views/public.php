<style type="text/css">
table td.cover img{
    width:50px;
  }
  
  .table td, .table th{
        padding: .5rem !important;
  }

  #subRight {
    padding-bottom: 32px !important
  }
</style>
<div class="container">
	<div class="row">
    <?php 
      if($cc==null) $cou=$ac;
      else $cou = $ac-$cc;
    ?>
    <?php 
    $data['title']=$panel[0]->title;
    if($this->input->get("option")=="my"):  ?>
      <?php 
      $data['mmy']=1;
      ?>
      <?php $this->load->view("my_header",$data); ?>
    <?php endif; ?>
    <?php if($this->input->get("option")!="my"):  ?>
      <?php //$data['title']="고객센터" ?>
      <?php $data["link"] = "history.back();"; ?>
      <?php $this->load->view("event_header",$data); ?>
    <?php endif; ?>
		<div id="subRight">
    <?php  $error = $this->session->flashdata('error');
      if($error)
      { ?>
       <?php echo "<script>alert('".$error."');</script>"; ?>
      <?php } ?>
      
      <!-- <div class="row pt-10 ">
        <div class="col-md-4 p-left-5">
          <div class="padgeName" style="border-bottom:none">
            <h2 style="font-size: 15px" class="text-green"><?=$panel[0]->title?></h2>
          </div>
        </div>
        <div class="col-md-8 p-left-0 p-right-0">
            <div class="row">
              <div class="col-xs-4 p-right-5 p-left-5">
                <a href="#" class="btn btn-d7-gradient w-100 btn-sm btn-round text-black" data-toggle="modal" data-target="#table_modal">내 배송요금표</a>
              </div>
              <div class="col-xs-4 p-right-5 p-left-5">
                <a href="#" class="btn btn-d7-gradient w-100 btn-sm btn-round text-black" data-toggle="modal" data-target="#address_modal">내 사서함주소</a>
              </div>
              <div class="col-xs-4 p-right-5 p-left-5">
                <a href="#" class="btn btn-d7-gradient w-100 btn-sm btn-round text-black" data-toggle="modal" data-target="#contact_modal">내 주소관리</a>
              </div>
            </div>
          </div>
      </div> -->
      <?php if($panel[0]->category_use==1):
      $category = explode("|", $panel[0]->category);
      if(!empty($category)): ?>
        <div class="row pt-10">
          <div class="col-md-12 p-3">
            <select class="form-control combo_sel">
              <option value="" <?=empty($this->input->get("category")) ? "selected":""?>>전체</option>
              <?php foreach($category as $key=> $v): ?>
              <option value="<?=$v?>" <?=$this->input->get("category")==$v ? "selected" : ""?>><?=$v?></option>
            <!-- <div class="col-xs-4 mb-5 p-right-3 p-left-3">
              <a href="/panel?id=<?=$panel[0]->iden?>&category=<?=$v?>" class="btn <?=$this->input->get("category")==$v ? "btn-yonpu":"btn-charo"?> w-100" 
                style="font-size: 14px"><?=$v?></a>
            </div> -->
            <?php endforeach; ?>
            </select>
          </div>
          <!-- <div class="col-xs-4 mb-5 p-right-3 p-left-3">
            <a href="/panel?id=<?=$panel[0]->iden?>" class="btn <?=empty($this->input->get("category")) ? "btn-yonpu":"btn-charo"?> w-100" 
              style="font-size: 14px">전체</a>
          </div>
          <?php foreach($category as $key=> $v): ?>
          <div class="col-xs-4 mb-5 p-right-3 p-left-3">
            <a href="/panel?id=<?=$panel[0]->iden?>&category=<?=$v?>" class="btn <?=$this->input->get("category")==$v ? "btn-yonpu":"btn-charo"?> w-100" 
              style="font-size: 14px"><?=$v?></a>
          </div>
          <?php endforeach; ?> -->
        </div>
      <?php endif; ?>
      <?php endif; ?>
        <form method="get" action="">
          <input type="hidden" name="id" value="<?=$panel[0]->iden?>">
          <div class="row mb-10 pt-10">  
            <div class="col-xs-4  p-right-3 p-left-5">
              <select name="shCol" id="shCol" class="form-control w-100">
                <option value="A" <?=!empty($_GET['shCol']) && $_GET['shCol']=="A" ? "selected":""?>>제목</option>
                <option value="B" <?=!empty($_GET['shCol']) && $_GET['shCol']=="B" ? "selected":""?>>글쓴이</option>
              </select>
            </div>
            <div class="col-xs-6  p-right-3 p-left-3">
              <input type="text" name="shKey" id="shKey" maxlength="20" class="form-control w-100" value="<?=!empty($_GET['shKey']) ? $_GET['shKey']:""?>">
              <input type="hidden" name="category" value="<?=!empty($_GET['category']) && $_GET['category'] ? $_GET['category']:""?>">
            </div>
            <div class="col-xs-2  p-right-5 p-left-3">
              <input type="submit" class="btn btn-yonpu text-black w-100 btn-round" value="검색">
            </div>
          </div>
        </form> 
        <div class="row">
          <div class="col-xs-12 p-right-5 p-left-5">
            <div class="con">
              <div class="mb-0">
                <table class="table request_deposit_table table-bordered">
                  <colgroup>
                    <col width="60px"></col>
                    <col></col>
                  </colgroup>
                    <thead class="thead-jin">
                      <tr>
                        <th scope="col" class="text-center">순번</th>
                        <th scope="col">제목</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php if(!empty($content)): ?>
                    <?php foreach($content as $key=>$value): ?>
                      <tr>
                          <td class="mid text-center"><?=$value->letter_l==1 ? "공지":$cou?></td>
                          <td class="mid">
                              <?php if($value->security==1): ?>
                              <img src="<?=base_url()?>assets/images/icon_secret.gif">
                            <?php endif; ?>
                              <a href="<?=base_url()?>post/view/<?=$value->id?>?id=<?=$panel[0]->iden?><?=!empty($_GET['option']) ? "&option=".$_GET['option']:"" ?>">
                               <span style="font-size:14px"><?=$value->title?><?= !empty($value->file1) || !empty($value->file2) || !empty($value->file3) ? "<img src='".base_url_home()."template/images/icon_file.gif'>":"" ?></span>
                               <?= $value->comment_count > 0 ? "<span class='recCnt'>[".$value->comment_count."]</span>":"" ?>
                               <div class="text-muted ft-10">
                                <?php if($panel[0]->state_use==1): ?>
                                <?=$value->mode?>&nbsp;&nbsp;&nbsp; 
                                <?php endif; ?>
                                <?php if($panel[0]->writer_use==1): ?>
                                작성자 : <?=$value->fromId==1 ? "관리자":$value->NickName?>
                                <?php endif; ?>
                                <?php if($panel[0]->regidate_use==1): ?>
                                &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;등록일 : <?=date_format(date_create($value->updated_date),"Y-m-d")?>
                                <?php endif; ?>  
                              </div>
                              </a>
                          </td>
                          
                        </tr>
                        <?php $cou = $cou-1; ?>
                    <?php endforeach; ?>
                  <?php endif;?>
                    </tbody>
                </table>
              </div>
              <div class="row mt-10 mb-10">
                <div class="col-xs-12  text-center p-0">
                  <?php echo $this->pagination->create_links(); ?>
                    <?php if(!empty($this->session->userdata('frole')) && $this->session->userdata('frole') <=$panel[0]->writing_use || $panel[0]->writing_use==0 ): ?>
                    <a href="/board_write?bbc_code=<?=$panel[0]->id?>&option=<?=!empty($_GET['option']) ? $_GET['option']:"customer"?>&id=<?=$panel[0]->iden?>" 
                        class="btn btn-warning btn-round write_btn">글쓰기</a>
                  <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
		</div>
	</div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="order_table">
        <table class="order_write order_table_top">
          <tbody><tr>
            <th class="title"></th>
          </tr>
          <tr>
            <td class="content">
              
            </td>
          </tr>
          </tbody>
        </table>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view("popup_address",NULL); ?>
<link href="<?php echo site_url('/template/css/poster.css'); ?>" rel="stylesheet">
<script>
	function fnNtView(ids) {
      jQuery.ajax({
        type : "post",
        dataType : "json",
        url : baseURL + "getmailbyid",
        data : {  id : ids } 
        }).done(function(data){
          $("#exampleModal .title").text(data[0]['title']);
          $("#exampleModal .content").text(data[0]['content']);
        });
      $("#exampleModal").modal();
    }
    $('.combo_sel').on('change', function (e) {
      location.href="/panel?id=<?=$this->input->get("id")?>"+"&category="+this.value;
  });
    var  pagination = $(".pagination");
    if(pagination.length > 0){
      var write_btn = $(".write_btn");
      var sub = write_btn.position().left - (pagination.position().left+pagination.width());
      if(sub < 20){
        pagination.css("margin-right",(20-sub)+"px");
      }
    }
</script>
