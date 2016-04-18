
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN THEME PANEL -->

<!-- END THEME PANEL -->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="index.html">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Tables</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Datatables</span>
        </li>
    </ul>

</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> User Management
    <small> </small>
</h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">Quản lý nhân viên</span>
                </div>
                <div class="actions">
                    <button id="sample_editable_1_new" class="btn btn-warning"> <?php echo __("Phân Quyền") ?>
                        <i class="fa fa-sitemap"></i>
                    </button>
                    <button id="sample_editable_1_new" class="btn red-mint"> <?php echo __("Đổi Mật Khẩu") ?>
                        <i class="fa fa-key"></i>
                    </button>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <button id="sample_editable_1_new" class="btn green"> Add New
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                    <tr>
                        <th> Edit </th>
                        <th> Delete </th>
                        <th> Username </th>
                        <th> Full Name </th>
                        <th> Points </th>
                        <th> Notes </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <a class="edit" href="javascript:;"> Edit </a>
                        </td>
                        <td>
                            <a class="delete" href="javascript:;"> Delete </a>
                        </td>
                        <td> alex </td>
                        <td> Alex Nilson </td>
                        <td> 1234 </td>
                        <td class="center"> power user </td>

                    </tr>
                    <tr>
                        <td>
                            <a class="edit" href="javascript:;"> Edit </a>
                        </td>
                        <td>
                            <a class="delete" href="javascript:;"> Delete </a>
                        </td>
                        <td> lisa </td>
                        <td> Lisa Wong </td>
                        <td> 434 </td>
                        <td class="center"> new user </td>

                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
