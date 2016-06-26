<?php
	echo $this->Html->script(array(
	    '/js/orders',
	));
?>
<!-- Vung tim kiem 2&3 -->
<div class="portlet light bordered">
<!-- Vung tim kiem 1 -->
<?php
echo $this->Form->create('Orders', array(
	'url' => array(
		'action' => 'index',
		'controller' => 'Orders',
	),
	'type' => 'get',
));
?>
<style>
	.selected_order {background-color:#aeaeae !important;}
</style>
<div class="row">
	<div class="form-group">
		<div class="portlet light bordered col-md-6">
			<div class="md-checkbox-inline">
	            <div class="md-checkbox">
	            	<label>Thông tin</label>
	            </div>
	        </div>
            <?php
            echo $this->Form->input('seach_email_phone', array(
                'div' => false,
                'name'=>'search_email_phone',
                'id'=>'seach_email_phone',
                'type'=>'text',
                'label'=>false,
                'class' => 'form-control',
                'placeholder'=>'Họ tên khách hàng hoặc số điện thoại',
                'default' => isset($this->request->query['search_email_phone'])?$this->request->query['search_email_phone']:'',
            ));
            ?>
        </div>
        <div class="portlet light bordered col-md-6">
	        <div class="md-checkbox-inline">
	            <div class="md-checkbox">
	            	<?php
	                echo $this->Form->input('search_check_ngaytao', array(
	                    'div' => false,
	                    'name'=>'search_check_ngaytao',
	                    'id'=>'search_check_ngaytao',
	                    'type'=>'checkbox',
	                    'label'=>false,
	                    'class' => 'md-check',
	                    'checked'=> isset($this->request->query['search_check_ngaytao'])?($this->request->query['search_check_ngaytao']?true:false):false
	                ));
	                ?>
	                <label for="search_check_ngaytao">
	                    <span></span>
	                    <span class="check"></span>
	                    <span class="box"></span> Ngày tạo </label>
	            </div>
	        </div>
            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
            	<?php
                echo $this->Form->input('search_ngaytao_from', array(
                    'div' => false,
                    'name'=>'search_ngaytao_from',
                    'type'=>'text',
                    'label'=>false,
                    'class' => 'form-control',
                    'default' => isset($this->request->query['search_ngaytao_from'])?$this->request->query['search_ngaytao_from']:''
                ));
                ?>
                <span class="input-group-addon"> to </span>
                <?php
                echo $this->Form->input('search_ngaytao_to', array(
                    'div' => false,
                    'name'=>'search_ngaytao_to',
                    'type'=>'text',
                    'label'=>false,
                    'class' => 'form-control',
                    'default' => isset($this->request->query['search_ngaytao_to'])?$this->request->query['search_ngaytao_to']:''
                ));
                ?>
            </div>
            <!-- /input-group -->
         </div>
         <div class="portlet light bordered col-md-6">
	        <div class="md-checkbox-inline">
	            <div class="md-checkbox">
	            	<?php
	                echo $this->Form->input('search_check_xacnhan', array(
	                    'div' => false,
	                    'name'=>'search_check_xacnhan',
	                    'id'=>'search_check_xacnhan',
	                    'type'=>'checkbox',
	                    'label'=>false,
	                    'class' => 'md-check',
	                    'checked'=> isset($this->request->query['search_check_xacnhan'])?($this->request->query['search_check_xacnhan']?true:false):false
	                ));
	                ?>
	                <label for="search_check_xacnhan">
	                    <span></span>
	                    <span class="check"></span>
	                    <span class="box"></span> Ngày xác nhận </label>
	            </div>
	        </div>
            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
            	<?php
                echo $this->Form->input('search_xacnhan_from', array(
                    'div' => false,
                    'name'=>'search_xacnhan_from',
                    'type'=>'text',
                    'label'=>false,
                    'class' => 'form-control',
                    'default' => isset($this->request->query['search_xacnhan_from'])?$this->request->query['search_xacnhan_from']:''
                ));
                ?>
                <span class="input-group-addon"> to </span>
                <?php
                echo $this->Form->input('search_xacnhan_to', array(
                    'div' => false,
                    'name'=>'search_xacnhan_to',
                    'type'=>'text',
                    'label'=>false,
                    'class' => 'form-control',
                    'default' => isset($this->request->query['search_xacnhan_to'])?$this->request->query['search_xacnhan_to']:''
                ));
                ?>
            </div>
            <!-- /input-group -->
        </div>
        <div class="portlet light bordered col-md-6">
	        <div class="md-checkbox-inline">
	            <div class="md-checkbox">
	            	<?php
	                echo $this->Form->input('search_check_chuyen', array(
	                    'div' => false,
	                    'name'=>'search_check_chuyen',
	                    'id'=>'search_check_chuyen',
	                    'type'=>'checkbox',
	                    'label'=>false,
	                    'class' => 'md-check',
	                    'checked'=> isset($this->request->query['search_check_chuyen'])?($this->request->query['search_check_chuyen']?true:false):false
	                ));
	                ?>
	                <label for="search_check_chuyen">
	                    <span></span>
	                    <span class="check"></span>
	                    <span class="box"></span> Ngày chuyển </label>
	            </div>
	        </div>
            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
            	<?php
                echo $this->Form->input('search_chuyen_from', array(
                    'div' => false,
                    'name'=>'search_chuyen_from',
                    'type'=>'text',
                    'label'=>false,
                    'class' => 'form-control',
                    'default' => isset($this->request->query['search_chuyen_from'])?$this->request->query['search_chuyen_from']:''
                ));
                ?>
                <span class="input-group-addon"> to </span>
                <?php
                echo $this->Form->input('search_chuyen_to', array(
                    'div' => false,
                    'name'=>'search_chuyen_to',
                    'type'=>'text',
                    'label'=>false,
                    'class' => 'form-control',
                    'default' => isset($this->request->query['search_chuyen_to'])?$this->request->query['search_chuyen_to']:''
                ));
                ?>
            </div>
            <!-- /input-group -->
        </div>
    </div>
</div>
<!-- End Vung tim kiem 1 -->
<!-- Vung tim kiem 2 -->
<div class="row">
	<div class="portlet light bordered col-md-6">
		<div class="form-group form-md-checkboxes">
	        <label>Hình thức giao hàng</label>
	        <div class="md-checkbox-inline">
	        	<?php
	        	foreach($shipping_services as $id => $ship) {
	        	?>
	            <div class="md-checkbox">
	            	<?php
	                echo $this->Form->input('search_shipping_service', array(
	                    'div' => false,
	                    'name'=>"search_shipping_service{$id}",
	                    'type'=>'checkbox',
	                    'input-type'=>'shipping',
	                    'id'=>"search_shipping_service{$id}",
	                    'value'=>$id,
	                    'label'=>false,
	                    'class' => 'md-check',
	                    'checked' => isset($this->request->query["search_shipping_service{$id}"])?($this->request->query["search_shipping_service{$id}"]?true:false):false
	                ));
	                ?>
	                <label for="<?php echo "search_shipping_service{$id}"; ?>">
	                    <span></span>
	                    <span class="check"></span>
	                    <span class="box"></span> <?php echo $ship; ?> </label>
	            </div>
	            <?php
	            }
	        	?>
	        </div>
	    </div>
	</div>
	<div class="portlet light bordered col-md-6">
		<div class="form-group form-md-checkboxes">
	        <label>Trạng thái đơn hàng</label>
	        <div class="md-checkbox-inline">
	            <?php foreach($statuses as $id => $stt) { ?>
	            <div class="md-checkbox">
	            	<?php
	                echo $this->Form->input('search_status', array(
	                    'div' => false,
	                    'name'=>"search_status{$id}",
	                    'type'=>'checkbox',
	                    'input-type'=>'status',
	                    'id'=>"search_status{$id}",
	                    'label'=>false,
	                    'class' => 'md-check',
	                    'value'=>$id,
	                    'checked' => isset($this->request->query["search_status{$id}"])?($this->request->query["search_status{$id}"]?true:false):false
	                ));
	                ?>
	                <label for="<?php echo "search_status{$id}"; ?>">
	                    <span></span>
	                    <span class="check"></span>
	                    <span class="box"></span> <?php echo $stt; ?> </label>
	            </div>
	            <?php } ?>
	        </div>
	    </div>
	</div>
</div>
<!-- End Vung tim kiem 2 -->
<!-- Vung tim kiem 3 -->
<div class="row">
	<div class="portlet light bordered col-md-6">
		<div class="form-group form-md-checkboxes">
	        <label>Đầu số điện thoại</label>
	        <div class="md-checkbox-inline">
	            <div class="md-checkbox">
	            	<?php
	            	echo $this->Form->input('seach_viettel', array(
	                    'div' => false,
	                    'name'=>'seach_viettel',
	                    'type'=>'checkbox',
	                    'id'=>'seach_viettel',
	                    'label'=>false,
	                    'class' => 'md-check',
	                    'checked' => isset($this->request->query['seach_viettel'])?($this->request->query['seach_viettel']?true:false):false
	                ));
	                ?>
	                <label for="seach_viettel">
	                    <span></span>
	                    <span class="check"></span>
	                    <span class="box"></span> Viettel </label>
	            </div>
	            <div class="md-checkbox">
	            	<?php
	            	echo $this->Form->input('search_mobi', array(
	                    'div' => false,
	                    'name'=>'search_mobi',
	                    'type'=>'checkbox',
	                    'id'=>'search_mobi',
	                    'label'=>false,
	                    'class' => 'md-check',
	                    'checked' => isset($this->request->query['search_mobi'])?($this->request->query['search_mobi']?true:false):false
	                ));
	                ?>
	                <label for="search_mobi">
	                    <span></span>
	                    <span class="check"></span>
	                    <span class="box"></span> Mobi </label>
	            </div>
	            <div class="md-checkbox">
	            	<?php
	            	echo $this->Form->input('seach_vnm', array(
	                    'div' => false,
	                    'name'=>'seach_vnm',
	                    'type'=>'checkbox',
	                    'id'=>'seach_vnm',
	                    'label'=>false,
	                    'class' => 'md-check',
	                    'checked' => isset($this->request->query['seach_vnm'])?($this->request->query['seach_vnm']?true:false):false
	                ));
	                ?>
	                <label for="seach_vnm">
	                    <span></span>
	                    <span class="check"></span>
	                    <span class="box"></span> VietnamMobile </label>
	            </div>
	            <div class="md-checkbox">
	            	<?php
	            	echo $this->Form->input('seach_vina', array(
	                    'div' => false,
	                    'name'=>'seach_vina',
	                    'type'=>'checkbox',
	                    'id'=>'seach_vina',
	                    'label'=>false,
	                    'class' => 'md-check',
	                    'checked' => isset($this->request->query['seach_vina'])?($this->request->query['seach_vina']?true:false):false
	                ));
	                ?>
	                <label for="seach_vina">
	                    <span></span>
	                    <span class="check"></span>
	                    <span class="box"></span> Vina </label>
	            </div>
	            <div class="md-checkbox">
	            	<?php
	            	echo $this->Form->input('seach_sphone', array(
	                    'div' => false,
	                    'name'=>'seach_sphone',
	                    'type'=>'checkbox',
	                    'id'=>'seach_sphone',
	                    'label'=>false,
	                    'class' => 'md-check',
	                    'checked' => isset($this->request->query['seach_sphone'])?($this->request->query['seach_sphone']?true:false):false
	                ));
	                ?>
	                <label for="seach_sphone">
	                    <span></span>
	                    <span class="check"></span>
	                    <span class="box"></span> S-Phone </label>
	            </div>
	            <div class="md-checkbox">
	            	<?php
	            	echo $this->Form->input('seach_gmobile', array(
	                    'div' => false,
	                    'name'=>'seach_gmobile',
	                    'type'=>'checkbox',
	                    'id'=>'seach_gmobile',
	                    'label'=>false,
	                    'class' => 'md-check',
	                    'checked' => isset($this->request->query['seach_gmobile'])?($this->request->query['seach_gmobile']?true:false):false
	                ));
	                ?>
	                <label for="seach_gmobile">
	                    <span></span>
	                    <span class="check"></span>
	                    <span class="box"></span> GMobile </label>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="portlet light bordered col-md-6">
		<div class="form-group form-md-checkboxes">
	        <label>Điều kiện khác</label>
	        <div class="md-checkbox-inline">
	            <div class="md-checkbox">
	            	<?php
	            	echo $this->Form->input('search_noithanh', array(
	                    'div' => false,
	                    'name'=>'search_noithanh',
	                    'type'=>'checkbox',
	                    'id'=>'search_noithanh',
	                    'label'=>false,
	                    'class' => 'md-check',
	                    'checked' => isset($this->request->query['search_noithanh'])?($this->request->query['search_noithanh']?true:false):false
	                ));
	                ?>
	                <label for="search_noithanh">
	                    <span></span>
	                    <span class="check"></span>
	                    <span class="box"></span> Nội thành </label>
	            </div>
	            <div class="md-checkbox">
	            	<?php
	            	echo $this->Form->input('search_phanloai', array(
	                    'div' => false,
	                    'name'=>'search_phanloai',
	                    'label'=>false,
	                    'class' => 'form-control',
	                    'options'=>$bundles,
	                    'empty'=>'--- Phân loại ---',
	                    'default'=>isset($this->request->query['search_phanloai'])?$this->request->query['search_phanloai']:''
	                ));
	                ?>
	            </div>
	           <div class="md-checkbox">
	           		<?php
	            	echo $this->Form->input('search_nhanvien', array(
	                    'div' => false,
	                    'name'=>'search_nhanvien',
	                    'label'=>false,
	                    'class' => 'form-control',
	                    'options'=>$users,
	                    'empty'=>'--- Nhân viên ---',
	                    'default'=>isset($this->request->query['search_nhanvien'])?$this->request->query['search_nhanvien']:''
	                ));
	                ?>
	            </div>
	        </div>
	    </div>
	</div>
</div>
<!-- End Vung tim kiem 3 -->
<div class="clearfix">
	<input type="submit" class="btn btn-lg yellow" name="btnSearchSubmit" value="Tìm kiếm"></input>
</div>
<?= $this->Form->end() ?>
</div>
<!-- End Vung tim kiem 2&3 -->
<!-- Vung Action -->
<div class="portlet light bordered">
	<div class="row">
		<div class="clearfix col-md-4">
	        <div class="btn-group btn-group-justified">
	            <a href="Orders/add" class="btn btn-default"> Thêm mới </a>
	            <a href="#" class="btn btn-default" id="btnUpdate"> Cập nhật </a>
	            <a href="#" class="btn btn-default" id="btnOrderView"> Xem </a>
	        </div>
	    </div>
		<div class="clearfix col-md-4">
	        <div class="btn-group btn-group-justified">
	            <a href="javascript:;" class="btn btn-default"> In </a>
	            <a href="javascript:;" class="btn btn-default"> In toàn bộ </a>
	            <a href="javascript:;" onclick="export_excel()" class="btn btn-default"> Excel </a>
	        </div>
	    </div>
    </div>
</div>
<!-- End Vung Action -->
<!-- Danh sach don hang -->
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-green">
			<i class="icon-settings font-green"></i> <span
				class="caption-subject bold uppercase">Đơn hàng</span>
		</div>
		<div class="tools"></div>
	</div>
	<div class="portlet-body table-both-scroll">
		<div id="sample_3_wrapper" class="dataTables_wrapper no-footer DTS">
			<div class="row">
				<div class="col-md-12">
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-12">
				<div class="dataTables_length" id="sample_1_length">
					<label>
						<select name="sample_1_length" aria-controls="sample_1" class="form-control input-sm input-xsmall input-inline">
							<option value="10">10</option><option value="15">15</option><option value="20">20</option>
							<option value="40">40</option>
							<option value="60">60</option>
							<option value="100">100</option>
						</select> Số lượng 1 trang
					</label>
				</div>
				<div class="col-md-6 col-sm-12">
				</div>
			</div>
			<div class="table-scrollable">
				<div class="dataTables_scroll">
					<div class="dataTables_scrollBody"
						style="position: relative; overflow: auto; width: 100%; max-height: 300px;">
						<table selected_order="" class="table table-striped table-bordered table-hover order-column dataTable no-footer"
							id="tblListOrder" role="grid" aria-describedby="sample_3_info"
							style="width: 1800px; position: absolute; top: 0px; left: 0px;">
							<thead>
								<tr role="row" style="height: 0px;">
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('total_qty','SL'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('code','Mã'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('postal_code','Mã vận đơn'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('customer_name', 'Tên KH'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('mobile', 'SĐT'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('telco_code','Mã bưu điện'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('address','Địa chỉ'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('note1','Ghi chú'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('shipping_note','Ghi chú bưu điện'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('shipping_service_id','Hình thức giao'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('status_id','Trạng thái'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('total_price','Tổng tiền'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending">Trùng đơn</th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('user_confirmed','NV Xác nhận'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('confirmed','Ngày XN'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('created','Ngày tạo'); ?></th>
								</tr>
							</thead>
							<tbody>
							<?php if(!count($orders)) { ?>
								<tr role="row" rowspan="16">
								Chưa có đơn hàng
								</tr>
							<?php } ?>
							<?php $odd=true; foreach($orders as $order) { ?>
								<tr role="row" <?php if($order['Orders']['duplicate_id']==1) { echo 'style="background: red !important;"'; }; ?> class="order_item <?php if($odd) {$odd=false;echo 'odd';} else {$odd=true;echo 'even';} ?>" data_id="<?php echo h($order['Orders']['id']); ?>" >
									<td style="width: 100px;"><?php echo h($order['Orders']['total_qty']); ?>&nbsp;</td>
									<td style="width: 100px;"><a href="Orders/view/?order_id=<?php echo $order['Orders']['id']; ?>"><?php echo h($order['Orders']['code']); ?>&nbsp;</a></td>
									<td style="width: 100px;"><?php echo h($order['Orders']['postal_code']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['customer_name']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['mobile']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['telco_code']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['address']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['note1']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['shipping_note']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['ShippingServices']['name']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Statuses']['name']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['total_price']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['duplicate_note']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['user_confirmed']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['confirmed']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['created']); ?>&nbsp;</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
						<div
							style="position: relative; top: 0px; left: 0px; width: 1px; height: 500px;"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5 col-sm-12"><div class="dataTables_info" id="sample_3_info" role="status" aria-live="polite"><?php echo $this->Paginator->counter('Trang {:page} / {:pages}, có {:current} / tổng {:count}'); ?></div></div>
				<div class="col-md-7 col-sm-12">
					<div class="dataTables_paginate paging_bootstrap_number btn-group" id="sample_3_paginate">
						<?php 
							echo $this->Paginator->numbers(array('class'=>'btn btn-default','separator' => ''));
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function export_excel() {
		var current_url = window.location.href;
		window.location.assign(current_url + "&&export_excel=1")
	}
</script>