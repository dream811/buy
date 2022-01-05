<div class="container">
	<div class="row">
		<?php $left = !empty($_GET['option']) ? $_GET['option']:"customer"; ?>
		<?php $this->load->view("left_menu",array("left"=>$left)); ?>
		<div id="subRight" class="col-md-10">
			<div class="padgeName">
				<h2>1:1맞춤문의</h2>
			</div>
			<div class="con">
				<div class="board_view_head row">
					<div class="col-xs-6">
						<h4 class="bold">No.<?=$privateView[0]->id?>&nbsp;&nbsp;<?=$privateView[0]->title?></h4>
					</div>
					<div class="col-xs-6 text-right">
						<ul>
							<li>작성일 : <?=$privateView[0]->updated_date?></li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<?=$privateView[0]->content?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 my-4 my-3">
						<a href="/board_write?bbc_code=2" class="btn btn-danger">글쓰기</a>
						<a href="/after_use" class="btn btn-secondary">목록</a>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="comment-wrapper">
				            <div class="panel panel-info">
				                <div class="panel-heading">
				                    댓글(<?=sizeof($comment)?>)
				                </div>
				                <div class="panel-body">
				                <?php if(!empty($this->session->userdata('fuser')) && $this->sessioni->userdata('fuser') > 0 ): ?>
				                	<textarea class="form-control" rows="3" name="content" id="content"></textarea><br>
				                    <a href="javascript:void(0);" class="btn btn-info pull-right" 
				                    			onclick="insertComment('<?=$privateView[0]->id?>')">댓글달기</a>
				                <?php endif; ?>
				                    <div class="clearfix"></div>
				                    <hr>
				                    <ul class="media-list">
				                        <?php if(!empty($comment)): ?>
				                        	<?php foreach($comment as $value): ?>
				                        		<li class="media">
						                            <div class="media-body">
						                                <span class="text-muted pull-right">
						                                    <small class="text-muted">
						                                    	<?=calculateTime($value->created_date)?>전
						                                    </small>
						                                </span>
						                                <strong class="text-success"><?=$value->name?></strong>
						                                <p>
						                                    <?=$value->content?>
						                                </p>
						                            </div>
						                        </li>
				                        	<?php endforeach; ?>
				                        <?php endif; ?>
				                    </ul>
				                </div>
				            </div>
				        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<link href="<?php echo site_url('/template/css/user.css'); ?>" rel="stylesheet">
<link href="<?php echo site_url('/template/css/poster.css');?>" rel="stylesheet">