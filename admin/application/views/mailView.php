<?php 
  $tt = is_null($pf) ? $uc:$uc-$pf;
?>
<?php 
  if(empty($panel)) { echo '해당 게시판이 존재하지 않습니다.'; } ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$panel[0]->title?></h1>
    </section>
    <section class="content">
      <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?=base_url()?>bbs?btype=<?=$panel[0]->id?>">글쓰기</a>
                </div>
            </div>
        </div>  
        <div class="row">
            <div class="col-xs-12">
              <div class="box-tools">   
                <form method="get" action="<?=base_url("panel")?>">
                  <input type="hidden" name="id" value="<?=$_GET['id']?>">
                  <div class="input-group" style="margin-bottom: 10px">
                    <div class="pull-right">
                      <input class="btn btn-primary btn-sm" value="검색" type="submit">
                   </div> 
                   <div class="pull-right">
                      <input type="text" name="seach_input"  class="form-control input-sm" style="width: 150px;" 
                      value="<?=empty($_GET['seach_input']) == 0 ? $_GET['seach_input']:"" ?>">
                   </div> 
                   <div class="pull-right">
                      <select name="shCol" id="shCol" class="form-control input-sm">
                        <option value="title" 
                         <?=empty($_GET['shCol']) == 0 && $_GET['shCol']=="title" ? "selected":"" ?>>제목</option>
                        <option value="username" 
                          <?=empty($_GET['shCol']) == 0 && $_GET['shCol']=="username" ? "selected":"" ?>>글쓴이</option>
                        <option value="id" 
                        <?=empty($_GET['shCol']) == 0 && $_GET['shCol']=="id" ? "selected":"" ?>>글번호</option>
                      </select>
                   </div>  
                   <?php if($panel[0]->category_use==1): 
                                       $category = explode("|", $panel[0]->category);   ?>
                    <div class="pull-right">
                      <select class="form-control input-sm" id="category" name="category" required>
                        <?php if(!empty($category)): ?>
                            <option value="total">==전체=</option>
                            <?php foreach($category as $value): ?>
                            <option value="<?=$value?>" <?=empty($_GET['category']) == 0 && $_GET['category']==$value ? "selected":"" ?>><?=$value?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                    </div>
                <?php endif; ?>
                <?php if($panel[0]->state_use==1): ?>
                    <?php $bstate = explode("|", $panel[0]->state); ?>
                    <?php if(!empty($bstate)): ?>
                    <div class="pull-right">
                      <select class="form-control input-sm" id="mode" name="mode">
                            <option value="total">==전체=</option>
                            <?php foreach($bstate as $bvalue): ?>
                            <option value="<?=$bvalue?>" <?=empty($_GET['mode']) == 0 && $_GET['mode']==$bvalue ? "selected":"" ?>><?=$bvalue?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>              
                </div>
                </form>
              </div>
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="thead-dark">
                      <th>순번</th>
                      <th>제목</th>
                      <th>작성자</th>
                      <?php  if($panel[0]->state_use ==1): ?>
                      <th>진행상태</th>
                      <?php endif; ?>
                      <th>등록일</th>
                      <th>조회수</th>
                    </tr>
                    <?php if(!empty($content)): ?>
                      <?php foreach($content as $value): ?>
                        <tr>
                          <td><?=$tt?></td>
                          <td>
                            <?php if($value->security==1): ?>
                              <img src="<?=base_url()?>assets/images/icon_secret.gif">
                            <?php endif; ?>
                            <a href="<?=base_url()?>viewReq/<?=$value->id?>?board_type=<?=$this->input->get("id")?>">
                               <?php if($panel[0]->title=="이용후기"): ?>
                                <span class="grey1">[<?=$value->category?>]</span> 
                              <?php endif; ?>
                              <?=$value->title?>
                                <?= $value->comment_count > 0 ? "<span class='recCnt'>[".$value->comment_count."]</span>":"" ?>
                                <?= !empty($value->file1) || !empty($value->file2) || !empty($value->file3) ? "<img src='/template/images/icon_file.gif'>":"" ?>
                            </a>
                          </td>
                          <td>
                            <a data-toggle="tooltip" class="hastip"  data-uname="<?=$value->UserName?>" data-userid="<?=$value->userId?>" data-deposit="<?=$value->deposit?>">
                            <?=$value->UserName?>
                            </a></td>
                          <?php  if($panel[0]->state_use ==1): ?>
                          <td><?=$value->mode?></td>
                          <?php endif; ?>
                          <td><?=$value->updated_date?></td>
                          <td><?=$value->view?></td>
                        </tr>
                        <?php $tt=$tt-1;?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </table>  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script>
  $('.hastip').tooltipsy({
     content: function ($el, $tip) {
        return '<table width="130" cellspacing="5" style="margin-left:10px;"><tbody><tr><td><span class="bold">'+$el.data("uname")+'</span> ('+$el.data("deposit")+'원)</td></tr><tr>      <td>· <a href="/admin/editOld/'+$el.data("userid")+'" target="_blank" class="popMem">회원정보보기</a></td></tr><tr>      <td>· <a href="javascript:fnPopWinCT(\'/admin/sendMail?userid='+$el.data("userid")+'\', \'MemNote\', 700, 510, \'N\');" class="popMem">쪽지보내기</a></td> </tr> <tr>      <td>· <a href="#" class="popMem">SMS 발송</a></td>    </tr>    <tr>      <td>· <a href="javascript:fnPopWinCT(\'/admin/payhistory?member_part=userId&search_txt='+$el.data("userid")+'\', \'ActingMem\', 1200, 700, \'Y\');" class="popMem">주문내역</a></td>    </tr>    <tr>      <td>· <a href="/admin/deposithistory?mem=name&seach_input='+$el.data("uname")+'" target="_blank" class="popMem">예치금 사용내역</a></td>    </tr>    <tr>      <td>· <a href="/admin/paying/?member_part=userId&search_txt='+$el.data("userid")+'" target="_blank" class="popMem">결제내역</a></td>    </tr>    <tr>      <td>· <a href="/admin/couponList/?shType=name&seach_input='+$el.data("uname")+'" target="_blank" class="popMem">쿠폰발급내역</a></td>    </tr>    <tr>      <td>· <a href="/admin/coupon_register?type=name&content='+$el.data("uname")+'" target="_blank" class="popMem">쿠폰발급</a></td>    </tr>    </tbody></table>';
    },
    offset: [0, 1],
    css: {
        'padding': '10px',
        'max-width': '200px',
        'color': '#303030',
        'background-color': '#f5f5b5',
        'border': '1px solid #deca7e',
        '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
        'text-shadow': 'none',
        'cursor':'pointer'
    }
});
</script>