<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        메일 편집
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <form role="form" id="addUser" action="<?php echo base_url() ?>SaveMail" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">제목</label>
                                        <input type="text" class="form-control required" id="title" name="title" maxlength="128" value="<?=$editMail[0]->title?>">
                                        <input type="hidden" name="id" value="<?=$editMail[0]->id?>">
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="content">내용</label>
                                    <textarea class="form-control" name="content" id="content" requried style="height: 300px">
                                        <?=$editMail[0]->content?>
                                    </textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="view">읽은 상태</label>
                                        <select class="form-control required" id="view" name="view">
                                            <option value="0">읽지 않음</option>
                                            <option value="1">읽음</option>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </section>
</div>
<script>
    initSample("content");
</script>