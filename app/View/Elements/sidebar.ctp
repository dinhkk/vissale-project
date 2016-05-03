<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper hide">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler"> </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            <li class="sidebar-search-wrapper">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit">
                                <i class="icon-magnifier"></i>
                            </a>
                        </span>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <li class="nav-item start ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start ">
                        <a href="index.html" class="nav-link ">
                            <i class="icon-bar-chart"></i>
                            <span class="title">Dashboard 1</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--menu don hang-->
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-tag"></i>
                    <span class="title"><?php echo __('Đơn hàng') ?></span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'Orders', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Danh sách đơn hàng') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'Chat', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Chat') ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- menu cau hinh don hang -->
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-puzzle"></i>
                    <span class="title">Cấu hình đơn hàng</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'ShippingServices', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Hình thức giao hàng') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'Statuses', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Trạng thái đơn hàng') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="#" class="nav-link ">
                            <span class="title">Loại mẫu in</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="#" class="nav-link ">
                            <span class="title">Thông tin mẫu in</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-facebook-official"></i>
                    <span class="title"><?php echo __('Fanpage') ?></span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'FBPosts', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Post') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'FBPage', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Fanpage') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'Chat', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Chat') ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-gift"></i>
                    <span class="title"><?php echo __('Sản phẩm') ?></span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'Bundles', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Loại sản phẩm') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'Units', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Đơn vị tính') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'Products', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Danh sách sản phẩm') ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-archive"></i>
                    <span class="title"><?php echo __('Quản lý kho') ?></span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'StockReceivings', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Nhập kho') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'StockDeliverings', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Xuất kho') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'Inventories', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Tồn kho') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'Suppliers', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Cấu hình công ty') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'Stocks', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Cấu hình kho') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'StockBooks', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Cấu hình kỳ') ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-group"></i>
                    <span class="title"><?php echo __('Quản lý nhân viên') ?></span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'Users', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Nhân viên') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'Users', 'action' => 'setPermissions')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Quản lý quyền') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'Users', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Quản lý truy cập') ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->