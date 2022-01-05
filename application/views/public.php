<div class="container">
	<div class="row">
    <?php 
      if($cc==null) $cou=$ac;
      else $cou = $ac-$cc;
      $data = array();
      if(!empty($_GET['option']) && $_GET['option']=="my"){
        $data['left'] = "my";
      }
    ?>
		<?php $this->load->view("left_menu",$data); ?>
		<div id="subRight" class="col-md-9">
      <div class="row">
        <div class="col-md-12">
			     <div class="padgeName">
            <h2><?=strpos($_SERVER['REQUEST_URI'],"private?option=my") !==false ? "Q&A" : $panel[0]->title?></h2>
          </div>    
        </div>
			</div>
      <?php if($panel[0]->category_use==1):
      $category = explode("|", $panel[0]->category);
      if(!empty($category)): ?>
        <div class="row">
          <div class="col-md-2 p-left-15 p-right-2">
            <a href="/panel?id=<?=$panel[0]->iden?>" class="btn w-100 text-white 
              <?=empty($this->input->get('category')) ? "btn-yonpu": "btn-charo"?>">전체</a>
          </div>
          <?php if(!empty($category)): ?>
            <?php foreach($category as $key=> $v): ?>
              <?php if(empty($v)) continue; ?>
          <div class="col-md-2 
          <?php if($key !=0 && $key %6 ==0) echo ' p-left-15 p-right-2 ';
                if($key > 0 && ($key ==4 || $key % 5 ==0)) echo ' p-right-15 p-left-2 '; 
                else { echo 'p-left-2 p-right-2';}?>" >
            <a href="/panel?id=<?=$panel[0]->iden?>&category=<?=$v?>" 
              class="btn text-white w-100 <?=$this->input->get('category') == $v ? "btn-yonpu": "btn-charo"?>"><?=$v?></a>
          </div>
          <?php endforeach; ?>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <?php endif; ?>
        <form method="get" action="">
          <input type="hidden" name="id" value="<?=$panel[0]->iden?>">
          <div class="row my-4 my-3">  
            <div class="col-md-2 p-right-2">
              <select name="shCol" id="shCol" class="form-control w-100 form-control-sm">
                <option value="A" <?=!empty($_GET['shCol']) && $_GET['shCol']=="A" ? "selected":""?>>제목</option>
                <option value="B" <?=!empty($_GET['shCol']) && $_GET['shCol']=="B" ? "selected":""?>>글쓴이</option>
              </select>
            </div>
            <div class="col-md-3 p-left-2 p-right-2">
              <input type="text" name="shKey" id="shKey" maxlength="20" class="form-control w-100 input-sm" value="<?=!empty($_GET['shKey']) ? $_GET['shKey']:""?>">
              <input type="hidden" name="category" value="<?=!empty($_GET['category']) && $_GET['category'] ? $_GET['category']:""?>">
            </div>
            <div class="col-md-4 p-left-2">
              <input type="submit" class="btn btn-yonpu text-white  btn-round btn-sm" value="검색">
              <?php if(!empty($this->session->userdata('frole')) && $this->session->userdata('frole') <=$panel[0]->writing_use || $panel[0]->writing_use==0 ): ?>
                  <a href="/board_write?bbc_code=<?=$panel[0]->id?>&option=<?=!empty($_GET['option']) ? $_GET['option']:"customer"?>&id=<?=$panel[0]->iden?>" 
                    class="btn btn-warning btn-round text-white  btn-sm">글쓰기</a>
            <?php endif; ?>
            </div>
          </div>
        </form> 
        
			<div class="con">
				<div class="col-xs-12">
          <div class="table-responsive">
          <table class="table request_deposit_table table-bordered">
              <thead class="thead-jin">
                <tr>
                  <th scope="col">순번</th>
                  <?php if($panel[0]->title=="이용후기"): ?>
                  <th scope="col">이미지</th>
                  <?php endif; ?>
                  <th scope="col">제목</th>
                  <?php //if($panel[0]->writer_use==1): ?>
                  <th scope="col">작성자</th>
                  <?php //endif; ?>
                  <?php if($panel[0]->state_use==1): ?>
                  <th scope="col">상태</th>
                  <?php endif; ?>
                  <?php if($panel[0]->regidate_use==1): ?>
                  <th scope="col">등록일</th>
                  <?php endif; ?>
                  <?php if($panel[0]->view_use==1): ?>
                  <th scope="col">조회수</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody class="border-list">
            <?php if(!empty($content)): ?>
              <?php foreach($content as $key=>$value): ?>
                <tr <?php if($panel[0]->title=="이용후기"): ?>style='height:65px'<?php endif; ?>>
                    <td class="mid"><?=$value->letter_l==1 ? "공지":$cou?></td>
                    <?php if($panel[0]->title=="이용후기"): ?>
                    <td class="cover">
                      <?php preg_match_all('/<img[^>]+>/i',$value->content, $result);?>
                      <?php if(!empty($result[0])): ?>
                        <?php echo $result[0][0]; ?>
                      <?php endif; ?>
                      <?php if(empty($result[0])): ?>
                      <?php if(!empty($value->file1)): ?>
                      <?php $ext = pathinfo($value->file1, PATHINFO_EXTENSION); ?>
                      <?php if( strtolower($ext)=="jpg" || 
                          strtolower($ext)=="jpeg" || 
                          strtolower($ext)=="png" || 
                          strtolower($ext)=="gif"): ?>
                    <img src="/upload/mail/<?=$value->id?>/<?=$value->file1?>" alt="<?=$value->title?>">
                    <?php goto a; ?>
                    <?php endif; ?>     
                  <?php endif; ?>
                  <?php if(!empty($value->file2)): ?>
                    <?php $ext = pathinfo($value->file2, PATHINFO_EXTENSION); ?>
                    <?php if( strtolower($ext)=="jpg" || 
                          strtolower($ext)=="jpeg" || 
                          strtolower($ext)=="png" || 
                          strtolower($ext)=="gif"): ?>
                    <img src="/upload/mail/<?=$value->id?>/<?=$value->file2?>" alt="<?=$value->title?>">
                    <?php goto a; ?>
                    <?php endif; ?> 
                  <?php endif; ?>
                  <?php if(!empty($value->file3)): ?>
                    <?php $ext = pathinfo($value->file3, PATHINFO_EXTENSION); ?>
                    <?php if( strtolower($ext)=="jpg" || 
                          strtolower($ext)=="jpeg" || 
                          strtolower($ext)=="png" || 
                          strtolower($ext)=="gif"): ?>
                    <img src="/upload/mail/<?=$value->id?>/<?=$value->file3?>" alt="<?=$value->title?>">
                    <?php endif; ?> 
                  <?php endif; ?>
                  <?php endif;?>
                   <?php a: ?>
                    </td>
                    <?php endif; ?>
                    <td class="mid ellipsis_max">
                      <?php if($value->security==1): ?>
                        <img src="<?=base_url()?>assets/images/icon_secret.gif">
                      <?php endif; ?>
                        <a href="<?=base_url()?>post/view/<?=$value->id?>?id=<?=$panel[0]->iden?><?=!empty($_GET['option']) ? "&option=".$_GET['option']:"" ?>" title="<?=$value->title?>">
                          <?php if(!empty($value->category)): ?>
                             <span class="grey1">[<?=$value->category?>]</span> 
                          <?php endif; ?>
                         <?=$value->title?>
                         <?= $value->comment_count > 0 ? "<span class='recCnt'>[".$value->comment_count."]</span>":"" ?>
                         <?= !empty($value->file1) || !empty($value->file2) || !empty($value->file3) ? "<img src='/template/images/icon_file.gif'>":"" ?>
                        </a>
                    </td>
                    <?php //if($panel[0]->writer_use==1): ?>
                    <td class="mid"><?=$value->fromId==1 ? "관리자":$value->NickName?></td>
                    <?php //endif; ?>
                    <?php if($panel[0]->state_use==1): ?>
                    <td class="mid"><?=$value->mode?></td>
                    <?php endif; ?>
                    <?php if($panel[0]->regidate_use==1): ?>
                    <td class="mid"><?=date('Y-m-d',strtotime($value->updated_date))?></td>
                    <?php endif; ?>
                    <?php if($panel[0]->view_use==1): ?>
                    <td class="mid"><?=$value->view?></td>
                    <?php endif; ?>
                  </tr>
                  <?php $cou = $cou-1; ?>
              <?php endforeach; ?>
            <?php endif;?>
              </tbody>
          </table>
          <div class="text-center">
            <?php echo $this->pagination->create_links(); ?>
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
</script>
<style>
  table td.cover img{
    width:50px;
    height: 50px;
    object-fit: cover;
  }
</style>