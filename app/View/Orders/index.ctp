<?php
echo $this->element('plugins/datepicker');
?>
<script>
    $(function () {
        $('.datepicker').datepicker({
            orientation: "left",
            autoclose: true,
            todayBtn: true,
            todayHighlight: true
        });
    });
</script>
<!-- Vung tim kiem 2&3 -->
<div class="portlet light bordered">
    <!-- Vung tim kiem 1 -->
    <?= $this->Form->create('search_order_form', ['role' => 'form']) ?>
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
                    'name' => 'search_email_phone',
                    'id' => 'seach_email_phone',
                    'type' => 'text',
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Họ tên khách hàng hoặc số điện thoại'
                ));
                ?>
            </div>
            <div class="portlet light bordered col-md-6">
                <div class="md-checkbox-inline">
                    <div class="md-checkbox">
                        <?php
                        echo $this->Form->input('search_check_ngaytao', array(
                            'div' => false,
                            'name' => 'search_check_ngaytao',
                            'id' => 'search_check_ngaytao',
                            'type' => 'checkbox',
                            'label' => false,
                            'class' => 'md-check'
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
                        'name' => 'search_ngaytao_from',
                        'type' => 'text',
                        'label' => false,
                        'class' => 'form-control datepicker'
                    ));
                    ?>
                    <span class="input-group-addon"> to </span>
                    <?php
                    echo $this->Form->input('search_ngaytao_to', array(
                        'div' => false,
                        'name' => 'search_ngaytao_to',
                        'type' => 'text',
                        'label' => false,
                        'class' => 'form-control datepicker'
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
                            'name' => 'search_check_xacnhan',
                            'id' => 'search_check_xacnhan',
                            'type' => 'checkbox',
                            'label' => false,
                            'class' => 'md-check'
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
                        'name' => 'search_xacnhan_from',
                        'type' => 'text',
                        'label' => false,
                        'class' => 'form-control datepicker'
                    ));
                    ?>
                    <span class="input-group-addon"> to </span>
                    <?php
                    echo $this->Form->input('search_xacnhan_to', array(
                        'div' => false,
                        'name' => 'search_xacnhan_to',
                        'type' => 'text',
                        'label' => false,
                        'class' => 'form-control datepicker'
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
                            'name' => 'search_check_chuyen',
                            'id' => 'search_check_chuyen',
                            'type' => 'checkbox',
                            'label' => false,
                            'class' => 'md-check'
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
                        'name' => 'search_chuyen_from',
                        'type' => 'text',
                        'label' => false,
                        'class' => 'form-control datepicker'
                    ));
                    ?>
                    <span class="input-group-addon"> to </span>
                    <?php
                    echo $this->Form->input('search_chuyen_to', array(
                        'div' => false,
                        'name' => 'search_chuyen_to',
                        'type' => 'text',
                        'label' => false,
                        'class' => 'form-control datepicker'
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
                    foreach ($shipping_services as $ship) {
                        ?>
                        <div class="md-checkbox">
                            <input type="checkbox" name="<?php echo "search_ship_{$ship['ShippingServices']['id']}"; ?>" id="<?php echo "search_ship_{$ship['ShippingServices']['id']}"; ?>" class="md-check">
                            <label for="<?php echo "search_ship_{$ship['ShippingServices']['id']}"; ?>">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> <?php echo $ship['ShippingServices']['name']; ?> </label>
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
                    <?php
                    foreach ($statuses as $stt) {
                        ?>
                        <div class="md-checkbox">
                            <input type="checkbox" name="<?php echo "search_stt_{$stt['Statuses']['id']}"; ?>" id="<?php echo "search_stt_{$stt['Statuses']['id']}"; ?>" class="md-check">
                            <label for="<?php echo "search_stt_{$stt['Statuses']['id']}"; ?>">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> <?php echo $stt['Statuses']['name']; ?> </label>
                        </div>
                        <?php
                    }
                    ?>
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
                        <input type="checkbox" id="seach_viettel" name="seach_viettel" class="md-check">
                        <label for="seach_viettel">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Viettel </label>
                    </div>
                    <div class="md-checkbox">
                        <input type="checkbox" id="search_mobi" name="search_mobi" class="md-check" checked="">
                        <label for="search_mobi">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Mobi </label>
                    </div>
                    <div class="md-checkbox">
                        <input type="checkbox" id="seach_vnm" name="seach_vnm" class="md-check">
                        <label for="seach_vnm">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> VietnamMobile </label>
                    </div>
                    <div class="md-checkbox">
                        <input type="checkbox" id="seach_vina" name="seach_vina" class="md-check">
                        <label for="seach_vina">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Vina </label>
                    </div>
                    <div class="md-checkbox">
                        <input type="checkbox" id="seach_sphone" name="seach_sphone" class="md-check">
                        <label for="seach_sphone">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> S-Phone </label>
                    </div>
                    <div class="md-checkbox">
                        <input type="checkbox" id="seach_gmobile" name="seach_gmobile" class="md-check">
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
                        <input type="checkbox" id="search_noithanh" name="search_noithanh" class="md-check">
                        <label for="search_noithanh">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Nội thành </label>
                    </div>
                    <div class="md-checkbox">
                        <select class="form-control" name="search_phanloai">
                            <option value="0">--- Phân loại ---</option>
                            <?php foreach ($bundles as $bundle) { ?>
                                <option value="<?php echo $bundle['Bundles']['id']; ?>"><?php echo "Phân loại:{$bundle['Bundles']['name']} | Mã:{$bundle['Bundles']['id']}"; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="md-checkbox">
                        <select class="form-control" name="search_nhanvien">
                            <option value="0">--- Nhân viên ---</option>
                            <?php foreach ($users as $user) { ?>
                                <option value="<?php echo $user['Users']['id']; ?>"><?php echo "Tên đăng nhập:{$user['Users']['username']} | Tên:{$user['Users']['name']}"; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Vung tim kiem 3 -->
    <div class="clearfix">
        <input type="Submit" class="btn btn-lg yellow" value="Tìm kiếm"></input>
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
                <a href="Orders/edit" class="btn btn-default"> Cập nhật </a>
                <a href="Orders/view" class="btn btn-default"> Xem </a>
            </div>
        </div>
        <div class="clearfix col-md-4">
            <div class="btn-group btn-group-justified">
                <a href="javascript:;" class="btn btn-default"> In </a>
                <a href="javascript:;" class="btn btn-default"> In toàn bộ </a>
                <a href="javascript:;" class="btn btn-default"> Excel </a>
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
                            <table
                                class="table table-striped table-bordered table-hover order-column dataTable no-footer"
                                id="sample_3" role="grid" aria-describedby="sample_3_info"
                                style="width: 1800px; position: absolute; top: 0px; left: 0px;">
                                <thead>
                                    <tr role="row" style="height: 0px;">
                                        <th class="sorting" aria-controls="sample_3" rowspan="1"
                                            colspan="1"
                                            style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
                                            aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('total_qty', 'SL'); ?></th>
                                        <th class="sorting" aria-controls="sample_3" rowspan="1"
                                            colspan="1"
                                            style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
                                            aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('code', 'Mã'); ?></th>
                                        <th class="sorting" aria-controls="sample_3" rowspan="1"
                                            colspan="1"
                                            style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
                                            aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('postal_code', 'Mã vận đơn'); ?></th>
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
                                            aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('telco_code', 'Mã bưu điện'); ?></th>
                                        <th class="sorting" aria-controls="sample_3" rowspan="1"
                                            colspan="1"
                                            style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
                                            aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('address', 'Địa chỉ'); ?></th>
                                        <th class="sorting" aria-controls="sample_3" rowspan="1"
                                            colspan="1"
                                            style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
                                            aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('note1', 'Ghi chú'); ?></th>
                                        <th class="sorting" aria-controls="sample_3" rowspan="1"
                                            colspan="1"
                                            style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
                                            aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('shipping_note', 'Ghi chú bưu điện'); ?></th>
                                        <th class="sorting" aria-controls="sample_3" rowspan="1"
                                            colspan="1"
                                            style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
                                            aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('shipping_service_id', 'Hình thức giao'); ?></th>
                                        <th class="sorting" aria-controls="sample_3" rowspan="1"
                                            colspan="1"
                                            style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
                                            aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('status_id', 'Trạng thái'); ?></th>
                                        <th class="sorting" aria-controls="sample_3" rowspan="1"
                                            colspan="1"
                                            style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
                                            aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('total_price', 'Tổng tiền'); ?></th>
                                        <th class="sorting" aria-controls="sample_3" rowspan="1"
                                            colspan="1"
                                            style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
                                            aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('duplicate_id', 'Trùng đơn'); ?></th>
                                        <th class="sorting" aria-controls="sample_3" rowspan="1"
                                            colspan="1"
                                            style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
                                            aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('user_confirmed', 'NV Xác nhận'); ?></th>
                                        <th class="sorting" aria-controls="sample_3" rowspan="1"
                                            colspan="1"
                                            style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
                                            aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('confirmed', 'Ngày XN'); ?></th>
                                        <th class="sorting" aria-controls="sample_3" rowspan="1"
                                            colspan="1"
                                            style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
                                            aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('created', 'Ngày tạo'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $odd = true;
                                    foreach ($orders as $order) {
                                        ?>
                                        <tr role="row" class="<?php
                                        if ($odd) {
                                            $odd = false;
                                            echo 'odd';
                                        } else {
                                            $odd = true;
                                            echo 'even';
                                        }
                                        ?>">
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
                                            <td style="width: 100px;"><?php echo h($order['Orders']['duplicate_id']); ?>&nbsp;</td>
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
                        <div class="dataTables_paginate paging_bootstrap_number" id="sample_3_paginate">
                            <?php echo $this->Paginator->numbers(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>