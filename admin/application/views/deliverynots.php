<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         배송구매시 유의사항관리
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <?php echo form_open_multipart('saveregisternots');?>
            <div class="row my-3">
              <div class="col-md-12">
                <h4>유의사항</h4>
                <input type="hidden" name="id" class="form-control" value="2">
              </div>
            </div>
            <div class="row my-3">
              <div class="col-md-12">
                <textarea name="link" class="form-control" id="editor" required>
                  <?=!empty($p) ? $p[0]->link:""?>
                </textarea>
              </div>
            </div>
            <div class="row my-3">
              <div class="col-md-4">
                <select name="use" id="use" class="form-control">
                  <option value="1" <?=!empty($p) && $p[0]->use==1 ? "selected":""?>>사용</option>
                  <option value="0" <?=!empty($p) && $p[0]->use==0 ? "selected":""?>>사용안함</option>
                </select>
              </div>
            </div>
            <div class="row my-3">
                <div class="col-md-4">
                    <input type="submit" class="btn btn-primary" value="저장">
                    <input type="reset" class="btn" value="취소">
                </div>
            </div>
          </form>
        </div>
  	</section>
</div>
<script>
  initSample();
</script>