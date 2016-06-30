<?php
    echo $this->Html->script(array(
        '/js/orders',
    ));
    ?>
 <?= $this->Form->create('Orders', ['role'=>'form']) ?>
 <div class="row">
	<div class="col-md-4">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">
					<i class="icon-settings font-dark"></i> <span
						class="caption-subject bold uppercase">Thông tin khách hàng</span>
				</div>
				<div class="tools"></div>
			</div>
			<div class="portlet-body form form-horizontal">
				<div class="form-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Mã</label>
                        <div class="col-md-6">
                        <input disabled type="text" class="form-control spinner">
                        </div>
                    </div>
                    <div class="form-group">
	                    <label class="col-md-4 control-label">Mã vận đơn</label>
	                    <div class="col-md-6">
	                    	<div class="input-group input-medium">
		                    	<?php
					            echo $this->Form->input('postal_code', array(
					                'div' => false,
					                'type'=>'text',
					                'label'=>false,
					                'name'=>'postal_code',
					                'id'=>'postal_code',
					                'class' => 'form-control',
					                'placeholder'=>'Mã bưu điện'
					            ));
					            ?>
		                        <span class="input-group-btn">
		                            <button class="btn blue" type="button">Xem</button>
		                        </span>
	                        </div>
	                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Tên KH</label>
                        <div class="col-md-6">
                        <?php
			            echo $this->Form->input('customer_name', array(
			                'div' => false,
			                'type'=>'text',
			                'label'=>false,
			                'name'=>'customer_name',
			                'id'=>'customer_name',
			                'class' => 'form-control',
			                'placeholder'=>'Tên khách hàng'
			            ));
			            ?>
                        </div>
                    </div>
                    <div class="form-group">
	                    <label class="col-md-4 control-label">SĐT</label>
	                    <div class="col-md-6">
	                    	<div class="input-group input-medium">
		                        <input id="mobile" type="text" class="form-control" value="">
		                        <span class="input-group-btn">
		                            <button class="btn blue" type="button">Gọi</button>
		                        </span>
	                        </div>
	                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Địa chỉ</label>
                        <div class="col-md-6">
                        <?php
			            echo $this->Form->input('address', array(
			                'div' => false,
			                'type'=>'text',
			                'label'=>false,
			                'name'=>'address',
			                'id'=>'address',
			                'class' => 'form-control'
			            ));
			            ?>
                        </div>
                    </div>
                    <div class="form-group">
	                    <label class="col-md-4 control-label">Tỉnh/TP</label>
	                    <div class="col-md-6">
	                    	<div class="input-group input-medium">
	                    		<?php
					            echo $this->Form->input('city', array(
					                'div' => false,
					                'type'=>'text',
					                'label'=>false,
					                'name'=>'city',
					                'id'=>'city',
					                'class' => 'form-control'
					            ));
					            ?>
		                        <span class="input-group-btn">
		                            <button class="btn blue" type="button">...</button>
		                        </span>
	                        </div>
	                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Ghi chú 1</label>
                        <div class="col-md-6">
                        <?php
			            echo $this->Form->input('note1', array(
			                'div' => false,
			                'type'=>'text',
			                'label'=>false,
			                'name'=>'note1',
			                'id'=>'note1',
			                'class' => 'form-control spinner'
			            ));
			            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Ghi chú 2</label>
                        <div class="col-md-6">
                        <?php
			            echo $this->Form->input('note2', array(
			                'div' => false,
			                'type'=>'text',
			                'label'=>false,
			                'name'=>'note2',
			                'id'=>'note2',
			                'class' => 'form-control spinner'
			            ));
			            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Lý do huỷ</label>
                        <div class="col-md-6">
                        <?php
			            echo $this->Form->input('cancel_note', array(
			                'div' => false,
			                'type'=>'text',
			                'label'=>false,
			                'name'=>'cancel_note',
			                'id'=>'cancel_note',
			                'class' => 'form-control spinner'
			            ));
			            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">GC giao hàng</label>
                        <div class="col-md-6">
                        <?php
			            echo $this->Form->input('shipping_note', array(
			                'div' => false,
			                'type'=>'text',
			                'label'=>false,
			                'name'=>'shipping_note',
			                'id'=>'shipping_note',
			                'class' => 'form-control spinner'
			            ));
			            ?>
                        </div>
                    </div>
                </div>
			</div>
			<div class="portlet-title">
				<div class="col-md-offset-3 col-md-9">
                    <button type="button" class="btn green">Lịch sử đơn hàng</button>
                </div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
	<div class="col-md-4">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<i class="icon-settings font-dark"></i> <span
						class="caption-subject bold uppercase">Thông tin đơn hàng</span>
				</div>
				<div class="tools"></div>
			</div>
			<div class="portlet-body">
				<!-- start -->
				<div class="form-group form-md-checkboxes">
			        <div class="md-checkbox-inline">
			            <div class="md-checkbox">
			            	<?php
				            echo $this->Form->input('is_top_priority', array(
				                'div' => false,
				                'type'=>'checkbox',
				                'label'=>false,
				                'name'=>'is_top_priority',
				                'id'=>'is_top_priority',
				                'class' => 'md-check'
				            ));
				            ?>
			                <label for="is_top_priority">
			                    <span></span>
			                    <span class="check"></span>
			                    <span class="box"></span> Ưu tiên </label>
			            </div>
			            <div class="md-checkbox">
			                <?php
				            echo $this->Form->input('is_send_sms', array(
				                'div' => false,
				                'type'=>'checkbox',
				                'label'=>false,
				                'name'=>'is_send_sms',
				                'id'=>'is_send_sms',
				                'class' => 'md-check'
				            ));
				            ?>
			                <label for="is_send_sms">
			                    <span></span>
			                    <span class="check"></span>
			                    <span class="box"></span> Đã SMS </label>
			            </div>
			            <div class="md-checkbox">
			            	<?php
				            echo $this->Form->input('is_inner_city', array(
				                'div' => false,
				                'type'=>'checkbox',
				                'label'=>false,
				                'name'=>'is_inner_city',
				                'id'=>'is_inner_city',
				                'class' => 'md-check'
				            ));
				            ?>
			                <label for="is_inner_city">
			                    <span></span>
			                    <span class="check"></span>
			                    <span class="box"></span> Nội thành </label>
			            </div>
			        </div>
			    </div>
			    <!-- end -->
			    <div class="form-group form-md-checkboxes">
			        <div class="md-checkbox-inline">
			        	<span class="box"></span> Trạng thái </label>
			        	<?php
			        	echo $this->Form->input('field', array(
						    'options' => $statuses,
						    'label'=>false,
						    'empty' => '--- Trạng thái ---',
						    'class'=>'form-control',
							'name'=> 'default_status_id',
							'id'=> 'default_status_id',
							'disabled'=>true,
							'default'=> $default_status['id']
						));
			        	?>
	            	</div>
			    </div>
			    <div class="form-group form-md-checkboxes">
			        <div class="md-checkbox-inline">
			        	<span class="box"></span> Giao hàng </label>
			        	<?php
			        	echo $this->Form->input('field', array(
						    'options' => $shipping_services,
						    'label'=>false,
						    'empty' => '--- Giao hàng ---',
						    'class'=>'form-control',
							'name'=> 'shipping_service_id',
							'id'=> 'shipping_service_id'
						));
			        	?>
	            	</div>
			    </div>
			    <div class="form-group form-md-checkboxes">
			        <div class="md-checkbox-inline">
			        	<span class="box"></span><label> Phân loại </label>
			        	<?php
			        	echo $this->Form->input('field', array(
						    'options' => $bundles,
						    'label'=>false,
						    'empty' => '--- Phân loại ---',
						    'class'=>'form-control',
							'name'=> 'bundle_id',
							'id'=> 'bundle_id'
						));
			        	?>
	            	</div>
			    </div>
                <div class="form-group form-md-checkboxes">
			        <div class="md-checkbox-inline">
			        	<span class="box"></span><label> Trạng thái </label>
		              	<?php
			        	echo $this->Form->input('field', array(
						    'options' => $statuses,
						    'label'=>false,
						    'empty' => '--- Trạng thái ---',
						    'class'=>'form-control',
							'name'=> 'status_id',
							'id'=> 'status_id'
						));
			        	?>
	            	</div>
			    </div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
	<div class="col-md-4">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<i class="icon-settings font-dark"></i> <span
						class="caption-subject bold uppercase">Chi phí</span>
				</div>
				<div class="tools"></div>
			</div>
			<div class="portlet-body form form-horizontal">
				<div class="form-body">
	                <div class="form-group">
	                    <label class="col-md-4 control-label">Thành tiền</label>
	                    <div class="col-md-6">
	                    <?php
			            echo $this->Form->input('price', array(
			                'div' => false,
			                'type'=>'text',
			                'label'=>false,
			                'name'=>'price',
			                'id'=>'price',
			                'class' => 'form-control spinner',
			                'disabled'=>true
			            ));
			            ?>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-md-4 control-label">Giảm giá</label>
	                    <div class="col-md-6">
	                    <?php
			            echo $this->Form->input('discount_price', array(
			                'div' => false,
			                'type'=>'text',
			                'label'=>false,
			                'name'=>'discount_price',
			                'id'=>'discount_price',
			                'class' => 'form-control spinner'
			            ));
			            ?>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-md-4 control-label">Phí vận chuyển</label>
	                    <div class="col-md-6">
	                    <?php
			            echo $this->Form->input('shipping_price', array(
			                'div' => false,
			                'type'=>'text',
			                'label'=>false,
			                'name'=>'shipping_price',
			                'id'=>'shipping_price',
			                'class' => 'form-control spinner'
			            ));
			            ?>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-md-4 control-label">Phụ thu</label>
	                    <div class="col-md-6">
	                    <?php
			            echo $this->Form->input('other_price', array(
			                'div' => false,
			                'type'=>'text',
			                'label'=>false,
			                'name'=>'other_price',
			                'id'=>'other_price',
			                'class' => 'form-control spinner'
			            ));
			            ?>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-md-4 control-label">Tổng tiền</label>
	                    <div class="col-md-6">
	                    <?php
			            echo $this->Form->input('total_price', array(
			                'div' => false,
			                'type'=>'text',
			                'label'=>false,
			                'name'=>'total_price',
			                'id'=>'total_price',
			                'class' => 'form-control spinner',
			                'disabled'=>true
			            ));
			            ?>
	                    </div>
	                </div>
                </div>
			</div>
			<div class="portlet-title">
				<div class="col-md-offset-3 col-md-9">
					<?= $this->Form->button(__('Xác nhận'),['class'=>'btn btn-primary','type'=>"button",'id'=>'btnOrderAdd']) ?>
                    <button type="button" class="btn btn-danger">Huỷ</button>
                </div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<!-- modal list product -->
<div id="modal_list_production" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="btn_list_production_close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Danh sách sản phẩm</h4>
            </div>
            <div class="modal-body" id="list_product">
                
            </div>
        </div>
    </div>
</div>
<!-- end modal list product -->
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">
					<i class="icon-settings font-dark"></i> <span
						class="caption-subject bold uppercase">Danh sách mặt hàng</span>
				</div>
				<div class="tools"></div>
			</div>
			<div class="portlet-body">
				<div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
					<div class="row">
						<div class="col-md-12">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label col-md-3">Sản phẩm</label>
										<div class="col-md-9">
											<input type="text" class="form-control" prd_id="" prd_code="" id ="add_prd_name" prd_price="0" prd_color="" prd_size="">
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label col-md-3">Số lượng</label>
										<div class="col-md-9">
											<input type="text" class="form-control" id ="add_prd_sl">
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label col-md-3">Giá</label>
										<div class="col-md-9">
											<input type="text" class="form-control" disabled id ="add_prd_price">
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label col-md-3">Kho</label>
										<div class="col-md-9">
											<input type="text" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<button type="button" class="btn btn-primary" disabled id="btn_add_product">Thêm</button>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12" id="ajax">
						</div>
					</div>
					<div class="table-scrollable">
						<table
							class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed"
							width="100%" id="tb_orderproducts" role="grid" is_changed="0"
							aria-describedby="sample_1_info" style="width: 100%;">
							<thead>
								<tr role="row">
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">STT</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">Code</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">Tên SP</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">Màu</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">Size</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">Số lượng</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">Đơn giá</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">Thành tiền</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-md-5 col-sm-12">
						</div>
						<div class="col-md-7 col-sm-12">
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<?= $this->Form->end() ?>
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