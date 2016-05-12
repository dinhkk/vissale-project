<div class="form-body form-horizontal">
    <!--/row-->
    <div class="form-group">
        <label class="control-label col-md-3">Post ID</label>
        <div class="col-md-9">
            <input type="text" class="form-control" id="post_id"> </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Mô tả</label>
        <div class="col-md-9">
            <textarea class="form-control" id="description"></textarea> </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Fanpage</label>
        <div class="col-md-9">
            <select class="form-control" id="fb_page_id">
          		<option value="0">--- Fanpage ---</option>
          		<?php foreach($pages as $id => $page) { ?>
            		<option value="<?php echo $id; ?>"><?php echo $page; ?></option>
            	<?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Sản phẩm</label>
        <div class="col-md-9">
        <select class="form-control" required="required" id="product_id">
      		<option value="0">--- Sản phẩm ---</option>
      		<?php foreach($products as $id => $prd_name) { ?>
        		<option value="<?php echo $id; ?>"><?php echo $prd_name; ?></option>
        	<?php } ?>
        </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Phân loại</label>
        <div class="col-md-9">
            <select class="form-control required" required="required" required id="bundle_id">
          		<option value="0">--- Phân loại ---</option>
          		<?php foreach($bundles as $id => $bundle) { ?>
            		<option value="<?php echo $id; ?>"><?php echo $bundle; ?></option>
            	<?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Trả lời khi không có SĐT</label>
        <div class="col-md-9">
            <textarea type="text" class="form-control" id="answer_nophone"></textarea> </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Trả lời khi có SĐT</label>
        <div class="col-md-9">
            <textarea class="form-control" id="answer_phone"></textarea> </div>
    </div>
    
    <?php
        //$data_filters = unserialize( trim( $reply_by_scripting) );
    ?>
    <div class="form-group">
        <label class="col-md-3 control-label">Bộ lọc giá</label>
        <div class="col-md-9">
            <textarea type="text" id="price_pattern" name="" class="form-control form-data"><?php //echo h($data_filters['price']['pattern']); ?></textarea>
            <textarea type="text" id="price_reply" name="" class="form-control form-data"><?php //echo h($data_filters['price']['reply']); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Bộ lọc chi tiết sản phẩm</label>
        <div class="col-md-9">
            <textarea type="text" id="product_detail_pattern" name="" class="form-control form-data"><?php //echo h($data_filters['product_detail']['pattern']); ?></textarea>
            <textarea type="text" id="product_detail_reply" name="" class="form-control form-data"><?php //echo h($data_filters['product_detail']['reply']); ?></textarea>
        </div>
    </div>
    
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="button" class="btn green" id="btnPostModalAddSubmit">Đồng ý</button>
                <button type="button" class="btn default" id="btnPostModalCancel">Huỷ</button>
            </div>
        </div>
    </div>
</div>