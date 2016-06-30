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
                        <a href="<?php echo Router::url(array('controller' => 'DashBoard', 'action' => 'index')) ?>" class="nav-link ">
                            <i class="icon-bar-chart"></i>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--menu don hang-->
            <?php
            if (array_intersect(array('Orders/index', 'Chat/index'), $user_perm_code) || $user_level >= ADMINGROUP):
                ?>
                <li class="nav-item  ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-tag"></i>
                        <span class="title"><?php echo __('Đơn hàng') ?></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <?php
                        if (in_array('Orders/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Orders', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Danh sách đơn hàng') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                        <?php
                        if (in_array('Chat/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Chat', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Chat') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                    </ul>
                </li>
            <?php endif;
            ?>

            <?php
            if (array_intersect(array('ShippingServices/index', 'Statuses/index'), $user_perm_code) || $user_level >= ADMINGROUP):
                ?>
                <!-- menu cau hinh don hang -->
                <li class="nav-item  ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-puzzle"></i>
                        <span class="title">Cấu hình đơn hàng</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <?php
                        if (in_array('ShippingServices/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'ShippingServices', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Hình thức giao hàng') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                        <?php
                        if (in_array('Statuses/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Statuses', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Trạng thái đơn hàng') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
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
            <?php endif;
            ?>

            <?php
            if (array_intersect(array('FBPosts/index', 'FBPage/index', 'Chat/index'), $user_perm_code) || $user_level >= ADMINGROUP):
                ?>
                <li class="nav-item  ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-facebook-official"></i>
                        <span class="title"><?php echo __('Fanpage') ?></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <?php
                        if (in_array('FBPosts/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'FBPosts', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Post') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                        <?php
                        if (in_array('FBPage/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'FBPage', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Fanpage') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                        <?php
                        if (in_array('Chat/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Chat', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Chat') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                    </ul>
                </li>
            <?php endif;
            ?>
            <?php
            if (array_intersect(array('Bundles/index', 'Units/index', 'Products/index'), $user_perm_code) || $user_level >= ADMINGROUP):
                ?>
                <li class="nav-item  ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-gift"></i>
                        <span class="title"><?php echo __('Sản phẩm') ?></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <?php
                        if (in_array('Bundles/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Bundles', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Loại sản phẩm') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                        <?php
                        if (in_array('Units/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Units', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Đơn vị tính') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                        <?php
                        if (in_array('Products/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Products', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Danh sách sản phẩm') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                    </ul>
                </li>
            <?php endif;
            ?>
            <?php
            if (array_intersect(array('StockReceivings/index', 'StockDeliverings/index', 'Inventories/index', 'Suppliers/index', 'Stocks/index', 'StockBooks/index'), $user_perm_code) || $user_level >= ADMINGROUP):
                ?>
                <li class="nav-item  ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-archive"></i>
                        <span class="title"><?php echo __('Quản lý kho') ?></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <?php
                        if (in_array('StockReceivings/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'StockReceivings', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Nhập kho') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                        <?php
                        if (in_array('StockDeliverings/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'StockDeliverings', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Xuất kho') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                        <?php
                        if (in_array('Inventories/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Inventories', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Tồn kho') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                        <?php
                        if (in_array('Suppliers/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Suppliers', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Cấu hình công ty') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                        <?php
                        if (in_array('Stocks/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Stocks', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Cấu hình kho') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                        <?php
                        if (in_array('StockBooks/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'StockBooks', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Cấu hình kỳ') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                    </ul>
                </li>
            <?php endif;
            ?>

            <!-- user - menus -->

            <?php
            if (array_intersect(array('Users/index', 'Roles/index', 'Perms/index'), $user_perm_code) || $user_level == ADMINGROUP):
                ?>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-users"></i>
                        <span class="title"><?php echo __('Quản lý nhân viên') ?></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <?php

                        if (in_array('Users/index', $user_perm_code) || $user_level == ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Users', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Nhân viên') ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php
                        if (in_array('Roles/index', $user_perm_code) || $user_level >= ADMINGROUP):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Roles', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Quản lý nhóm quyền') ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php
                        if (in_array('Perms/index', $user_perm_code) || $user_level >= ADMINSYSTEM):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Perms', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Quản lý quyền') ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php
                        if (in_array('Roles/index', $user_perm_code) || $user_level >= ADMINGROUP) {
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Users', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Quản lý truy cập') ?></span>
                                </a>
                            </li>

                        <?php } ?>
                    </ul>
                </li>
            <?php endif;
            ?>

            <!-- group - menus -->

            <?php
            if (array_intersect(array('Groups/index'), $user_perm_code) || $user_level >= ADMINSYSTEM):
                ?>
                <li class="nav-item  ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-user"></i>
                        <span class="title"><?php echo __('Quản lý group') ?></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <?php
                        if (in_array('Groups/index', $user_perm_code) || $user_level >= ADMINSYSTEM):
                            ?>
                            <li class="nav-item  ">
                                <a href="<?php echo Router::url(array('controller' => 'Groups', 'action' => 'index')) ?>" class="nav-link ">
                                    <span class="title"><?php echo __('Danh sách group') ?></span>
                                </a>
                            </li>
                        <?php endif;
                        ?>
                    </ul>
                </li>
            <?php endif; ?>

            <!-- charts - menus -->
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-pie-chart"></i>
                    <span class="title"><?php echo __('Thống kê') ?></span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'DashBoard', 'action' => 'index')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Báo cáo tháng') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'DashBoard', 'action' => 'ordersStatic')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Báo cáo đơn hàng') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?php echo Router::url(array('controller' => 'DashBoard', 'action' => 'usersStatic')) ?>" class="nav-link ">
                            <span class="title"><?php echo __('Báo cáo doanh số') ?></span>
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