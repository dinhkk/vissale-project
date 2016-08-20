<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 8/20/16
 * Time: 11:09 AM
 */
    //debug($page);
?>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#"><span>Công cụ</span></a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Kiểm tra page</span>
        </li>
    </ul>
</div>


<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-share font-red-sunglo hide"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Search</span>
            <span class="caption-helper">Điền FanPage ID để kiểm tra ...</span>
        </div>

    </div>
    <div class="portlet-body">
        <div class="container">
            <form method="POST" action="/FBPage/searchPages">
                <div class="col-lg-6">
                    <div class="input-group" >
                        <input type="text" class="input-sm form-control" name="page_id" />
                    </div>
                    <div class="form-group">
                    </div>
                    <div class="col-lg-6">
                        <button id="search_page" class="btn green" type="submit" >Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-social-dribbble font-green"></i>
                    <span class="caption-subject font-green bold uppercase">Thông tin page</span>
                </div>
                <div class="actions">
                    <a href="javascript:;" class="btn btn-circle btn-icon-only btn-default">
                        <i class="icon-cloud-upload"></i>
                    </a>
                    <a href="javascript:;" class="btn btn-circle btn-icon-only btn-default">
                        <i class="icon-wrench"></i>
                    </a>
                    <a href="javascript:;" class="btn btn-circle btn-icon-only btn-default">
                        <i class="icon-trash"></i>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th> #ID </th>
                            <th> Page ID</th>
                            <th> Tên Page </th>
                            <th> Tên Group </th>
                            <th> Ngày Tạo </th>
                            <th> Trạng Thái </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php if(empty($page)) { ?>
                                <td colspan="5">Không tìm thấy</td>
                            <?php } ?>
                            <?php if(!empty($page)) { ?>
                                <td> <?=$page['FBPage']['id']?> </td>
                                <td> <?=$page['FBPage']['page_id']?> </td>
                                <td> <?=$page['FBPage']['page_name']?> </td>
                                <td> <?=$page['Group']['name']?> </td>
                                <td> <?=$page['FBPage']['created']?> </td>
                                <td>
                                    <?php
                                    if ($page['FBPage']['status']==0) {
                                        echo '<span class="label label-sm label-success"> Đã đăng ký </span>';
                                    }
                                    if ($page['FBPage']['status']==1) {
                                        echo '<span class="label label-sm label-danger"> Không đăng ký </span>';
                                    }
                                    ?>
                                </td>
                            <?php } ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

