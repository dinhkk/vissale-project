<?php
	echo $this->Html->script(array(
	    '/js/fbpages',
	));
?>
<div class="row">
	<div class="col-md-6">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">
					<i class="icon-settings font-dark"></i> <span
						class="caption-subject bold uppercase">Cấu hình hệ thống</span>
				</div>
				<div class="tools"></div>
			</div>
			<div class="portlet-body form">
				<form class="form-horizontal" role="form" id="formConfig">
					<div class="form-body">

						<div class="form-group">
							<label class="col-md-3 control-label">Facebook app_id:</label>
							<div class="col-md-9">
								<input id="fb_app_id" name="fb_app_id" class="form-control" rows="3" value="<?php echo h($fb_app_id); ?>" placeholder="<?php echo h($fb_app_id); ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Facebook fb_app_secret_key:</label>
							<div class="col-md-9">
								<input id="fb_app_secret_key" name="fb_app_secret_key" class="form-control" rows="3" value="<?php echo h($fb_app_secret_key); ?>" placeholder="<?php echo h($fb_app_secret_key); ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Facebook fb_app_version:</label>
							<div class="col-md-9">
								<input id="fb_app_version" name="fb_app_version" class="form-control" rows="3" value="<?php echo h($fb_app_version); ?>" placeholder="<?php echo h($fb_app_version); ?>">
							</div>
						</div>
						<!--comment-->
						<div class="form-group">
							<label class="col-md-3 control-label">Comment khi có SĐT</label>
							<div class="col-md-9">
								<textarea id="txaCommentPhone" class="form-control" rows="3"><?php echo h($reply_comment_has_phone); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Comment khi không có SĐT</label>
							<div class="col-md-9">
								<textarea id="txaCommentNoPhone" class="form-control" rows="3"><?php echo h($reply_comment_nophone); ?></textarea>
							</div>
						</div>

						<!--inbox-->
						<div class="form-group">
							<label class="col-md-3 control-label">Inbox khi có SĐT</label>
							<div class="col-md-9">
								<textarea id="reply_conversation_has_phone" class="form-control form-data" rows="3"><?php echo h($reply_conversation_has_phone); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Inbox khi không có SĐT</label>
							<div class="col-md-9">
								<textarea id="reply_conversation_nophone" class="form-control form-data" rows="3"><?php echo h($reply_conversation_nophone); ?></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Bộ lọc từ</label>
							<div class="col-md-9">
								<input type="text" id="txtWordsBlacklist" class="form-control" value="<?php echo h($words_blacklist); ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Bộ lọc SĐT</label>
							<div class="col-md-9">
								<input type="text" id="txtPhoneFilter" class="form-control" value="<?php echo h($phone_filter); ?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Bộ lọc Facebook ID</label>
							<div class="col-md-9">
								<textarea type="text" id="user_coment_filter" name="user_coment_filter" class="form-control"><?php echo h($user_coment_filter); ?></textarea>

							</div>
						</div>

						<div class="form-group">
							<div class="form-group form-md-checkboxes">
						        <label class="col-md-3 control-label">Cấu hình khác</label>
						        <div class="md-checkbox col-md-9">
						            <div class="md-checkbox">
						                <input type="checkbox" id="cbLike" name="cbLike" <?php if($like_comment) echo 'checked'; ?> class="md-check">
						                <label for="cbLike">
						                    <span class="inc"></span>
						                    <span class="check"></span>
						                    <span class="box"></span> Like </label>
						            </div>
						            <div class="md-checkbox">
						                <input type="checkbox" id="cbHidePhone" <?php if($hide_phone_comment) echo 'checked'; ?> name="cbHidePhone" class="md-check">
						                <label for="cbHidePhone">
						                    <span></span>
						                    <span class="check"></span>
						                    <span class="box"></span> Ẩn khi có số điện thoại </label>
						            </div>
						            <div class="md-checkbox">
						                <input type="checkbox" id="cbHideNoPhone" <?php if($hide_nophone_comment) echo 'checked'; ?> name="cbHideNoPhone" class="md-check">
						                <label for="cbHideNoPhone">
						                    <span></span>
						                    <span class="check"></span>
						                    <span class="box"></span> Ẩn khi không có số điện thoại </label>
						            </div>
						            <div class="md-checkbox">
						                <input type="checkbox" <?php if($reply_conversation) echo 'checked'; ?> id="cbInbox" name="cbInbox" class="md-check">
						                <label for="cbInbox">
						                    <span></span>
						                    <span class="check"></span>
						                    <span class="box"></span> Trả lời inbox </label>
						            </div>
						        </div>
						    </div>
						    <div class="form-group form-md-radios">
                                <label class="col-md-3 control-label" for="formConfig"></label>
                                <div class="col-md-9">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" id="rdKhongchia" name="rdChiaOrder" class="md-radiobtn">
                                            <label for="rdKhongchia">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Không chia đơn hàng </label>
                                        </div>
                                        <div class="md-radio">
                                            <input type="radio" id="rdTuchia" name="rdChiaOrder" class="md-radiobtn" checked="">
                                            <label for="rdTuchia">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Tự chia đơn hàng </label>
                                        </div>
                                        <div class="md-radio">
                                            <input type="radio" id="rdAdminchia" name="rdChiaOrder" class="md-radiobtn">
                                            <label for="rdAdminchia">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Admin chia đơn hàng </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
					<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-3 col-md-9">
								<button type="button" class="btn green" id="btnSaveConfig">Lưu</button>
								<?php if (!empty($user_level==100)): ?>
									<a class="btn btn-primary" href="<?php echo $fblogin_url; ?>">Login Facebook</a>
								<?php endif; ?>

								<?php if (!empty($user_level==100)): ?>
									<a class="btn btn-primary" href="<?php echo $fblogin_messenger_url; ?>">Login Messenger</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
	<div class="col-md-6">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<i class="icon-settings font-green"></i> <span
						class="caption-subject bold uppercase">Đăng ký Fanpage với
						hệ thống</span>
				</div>
				<div class="tools">
					<?php if (!empty($user_level==100)): ?>
						<a style="height: 40px;" href="<?php echo $fblogin_url; ?>">Đồng bộ danh sách Fanpage</a>
					<?php endif; ?>
					|
					<?php if (!empty($user_level==100)): ?>
						<a target="_blank" style="height: 40px;" href="<?php echo $fb_active_callback; ?>">Kích hoạt Fanpage</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="portlet-body">
				<div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
					<div class="table-scrollable">
						<table
							class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-column collapsed"
							width="100%" id="sample_2" role="grid"
							aria-describedby="sample_2_info" style="width: 100%;">
							<thead>
								<tr role="row">
									<th class="all" tabindex="0"
										aria-controls="sample_2" rowspan="1" colspan="1" style="width: 25%;">Page ID</th>
									<th class="min-phone-l" tabindex="0"
										aria-controls="sample_2" rowspan="1" colspan="1" style="width: 40%;">Tên Fanpage</th>
									<th class="min-tablet" tabindex="0"
										aria-controls="sample_2" rowspan="1" colspan="1" style="width: 10%;">Đăng ký?</th>
									<th class="none" tabindex="0" aria-controls="sample_2"
										rowspan="1" colspan="1" style="width:25%;">...</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($pages as $page) { ?>
								<tr role="row" fb_page_id=<?php echo $page['FBPage']['id']; ?>>
									<td><?php echo $page['FBPage']['page_id']; ?></td>
									<td><?php echo $page['FBPage']['page_name']; ?></td>
									<td><input disabled type="radio" class="md-radiobtn" <?php if($page['FBPage']['status']==0) echo 'checked'; ?>></td>
									<td>
										<?php if($page['FBPage']['status']!=0){ ?>
											<button type="button" class="btn green btnRegPage">Subscribe Page</button>
										<?php } else { ?>
											<button type="button" class="btn purple-plum btnCancelPage">Unsubscribe Page</button>
										<?php } ?>
										<button type="button" class="btn red btnRemovePage">Delete Page</button>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>


<div class="row">
	<div class="col-md-6">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">
					<i class="icon-settings font-dark"></i> <span
						class="caption-subject bold uppercase">Đăng nhập lại (khi đổi mật khẩu Facebook)</span>
				</div>
				<div class="tools"></div>
			</div>
			<div class="portlet-body form">
				<div class="form-actions">
					<div class="row">
						<div class="col-md-offset-3 col-md-9">
							<button type="button" class="btn red" id="btnRemoveUser">Xoá tài khoản</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
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