<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          포인트 설정
      </h1>
    </section>
    <section class="content">
      <form action="savepointRegister" method="post">
        <div class="row my-3">
          <div class="col-md-2 text-center">
            <p>등록시 포인트 설정</p>
          </div>
          <div class="col-md-2">
            <input type="text" name="point" id="point" class="form-control" value="<?=$s[0]->point?>">
          </div>
        </div>
        <div class="row my-3">
            <div class="col-md-2 text-center">
                <input type="submit" class="btn btn-primary" value="저장">
                <input type="reset"  class="btn" value="취소">
            </div>
        </div>
      </form>
    </section>
</div>
