<div class="form-body form-horizontal">
	<input type="hidden" id="fb_post_id" value="<?php echo $post['FBPosts']['id'] ?>">
    <!--/row-->
    <div class="form-group">
        <label class="control-label col-md-3">Post ID</label>
        <div class="col-md-9">
            <input type="text" class="form-control" id="post_id" value="<?php echo $post['FBPosts']['post_id'] ?>"> </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Mô tả</label>
        <div class="col-md-9">
            <textarea class="form-control" id="description"><?php echo $post['FBPosts']['description'] ?></textarea> </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Fanpage</label>
        <div class="col-md-9">
            <select class="form-control" id="fb_page_id">
          		<option value="0">--- Fanpage ---</option>
          		<?php foreach($pages as $id => $page) { ?>
            		<option value="<?php echo $id; ?>" <?php if($id==$post['FBPosts']['fb_page_id']) echo 'selected=""'; ?>><?php echo $page; ?></option>
            	<?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Sản phẩm</label>
        <div class="col-md-9">
        <select class="form-control" id="product_id">
      		<option value="0">--- Sản phẩm ---</option>
      		<?php foreach($products as $id => $prd_name) { ?>
        		<option value="<?php echo $id; ?>" <?php if($id==$post['FBPosts']['product_id']) echo 'selected=""'; ?>><?php echo $prd_name; ?></option>
        	<?php } ?>
        </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Phân loại</label>
        <div class="col-md-9">
            <select class="form-control" id="bundle_id">
          		<option value="0">--- Phân loại ---</option>
          		<?php foreach($bundles as $id => $bundle) { ?>
            		<option value="<?php echo $id; ?>" <?php if($id==$post['FBPosts']['bundle_id']) echo 'selected=""'; ?>><?php echo $bundle; ?></option>
            	<?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Trả lời khi không có SĐT</label>
        <div class="col-md-9">
            <textarea type="text" class="form-control" id="answer_nophone"><?php echo $post['FBPosts']['answer_nophone'] ?></textarea> </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Trả lời khi có SĐT</label>
        <div class="col-md-9">
            <textarea class="form-control" id="answer_phone"><?php echo $post['FBPosts']['answer_phone'] ?></textarea> </div>
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="button" class="btn green" id="btnPostModalSubmit">Đồng ý</button>
                <button type="button" class="btn default" id="btnPostModalCancel">Huỷ</button>
            </div>
        </div>
    </div>
</div>