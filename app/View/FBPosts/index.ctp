<?php
	echo $this->Html->script(array(
	    '/js/fbposts',
	));
?>
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>Quản lý sản phẩm theo bài post </div>
        <div class="tools">
        </div>
    </div>
    <div class="portlet-body flip-scroll">
        <table class="table table-bordered table-striped table-condensed flip-content">
            <thead class="flip-content">
                <tr>
                    <th width="25%"> Post ID </th>
                    <th width="25%"> Mô tả </th>
                    <th> Sản phẩm </th>
                    <th> Phân loại </th>
                    <th> ... </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($posts as $post) { ?>
                <tr>
                    <td width="25%"><?php echo $post['FBPosts']['post_id'] ?></td>
                    <td width="25%"><?php echo $post['FBPosts']['description'] ?></td>
                    <td><?php echo $post['Products']['name'] ?></td>
                    <td><?php echo $post['Bundles']['name'] ?></td>
                    <td width="20%">
	                    <div class="btn-group btn-group-justified" post_id="<?php echo $post['FBPosts']['id'] ?>">
				            <a href="#" class="btn btn-default copyPost"> Copy </a>
				            <a href="#" class="btn btn-default updatePost"> Cập nhật </a>
				            <a href="#" class="btn btn-default delPost"> Xoá </a>
				        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal thong bao -->
<div class="modal fade" id="modalThongbao" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông báo</h4>
            </div>
            <div class="modal-body" id="modalThongbaoContent"></div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" id="modalThongbaoClose" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- modal edit-copy post -->
<!-- modal edit post -->
<div id="modalPost" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Post</h4>
            </div>
            <div class="modal-body" id="modalPostBody">
            </div>
        </div>
    </div>
</div>
<!-- end modal edit post -->