<div class="portlet light portlet-fit portlet-datatable bordered">
    <div class="portlet-body">
        <div class="table-container" style="">

            <div id="datatable_ajax_wrapper" class="dataTables_wrapper dataTables_extended_wrapper no-footer"><div class="custom-alerts alert alert-danger fade in" id="prefix_1335965776457"><button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button><i class="fa-lg fa fa-warning"></i>  Could not complete request. Please check your internet connection</div><div class="row"><div class="col-md-8 col-sm-12"><div class="dataTables_paginate paging_bootstrap_extended" id="datatable_ajax_paginate"><div class="pagination-panel"> Page <a class="btn btn-sm default prev disabled" href="#"><i class="fa fa-angle-left"></i></a><input type="text" style="text-align:center; margin: 0 5px;" maxlenght="5" class="pagination-panel-input form-control input-sm input-inline input-mini"><a class="btn btn-sm default next disabled" href="#"><i class="fa fa-angle-right"></i></a> of <span class="pagination-panel-total"></span></div></div><div class="dataTables_length" id="datatable_ajax_length"><label><span class="seperator">|</span>View <select name="datatable_ajax_length" aria-controls="datatable_ajax" class="form-control input-xs input-sm input-inline"><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option><option value="150">150</option><option value="-1">All</option></select> records</label></div><div class="dataTables_info" id="datatable_ajax_info" role="status" aria-live="polite"></div></div><div class="col-md-4 col-sm-12"><div class="table-group-actions pull-right">
                            <span> </span>
                            <select class="table-group-action-input form-control input-inline input-small input-sm">
                                <option value="">Select...</option>
                                <option value="Cancel">Cancel</option>
                                <option value="Cancel">Hold</option>
                                <option value="Cancel">On Hold</option>
                                <option value="Close">Close</option>
                            </select>
                            <button class="btn btn-sm green table-group-action-submit">
                                <i class="fa fa-check"></i> Submit</button>
                        </div></div></div><div class="table-responsive"><table id="datatable_ajax" class="table table-striped table-bordered table-hover table-checkable dataTable no-footer" aria-describedby="datatable_ajax_info" role="grid">
                        <thead>
                            <tr class="heading" role="row"><th width="2%" class="sorting_disabled" rowspan="1" colspan="1">
                        <div class="checker"><span><input type="checkbox" class="group-checkable"></span></div> </th><th width="5%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1"> Record&nbsp;# </th><th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1"> Date </th><th width="200" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1"> Customer </th><th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1"> Ship&nbsp;To </th><th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1"> Price </th><th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1"> Amount </th><th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1"> Status </th><th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1"> Actions </th></tr>
                        <tr class="filter" role="row"><td rowspan="1" colspan="1"> </td><td rowspan="1" colspan="1">
                                <input type="text" name="order_id" class="form-control form-filter input-sm"> </td><td rowspan="1" colspan="1">
                                <div data-date-format="dd/mm/yyyy" class="input-group date date-picker margin-bottom-5">
                                    <input type="text" placeholder="From" name="order_date_from" readonly="" class="form-control form-filter input-sm">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm default">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                                <div data-date-format="dd/mm/yyyy" class="input-group date date-picker">
                                    <input type="text" placeholder="To" name="order_date_to" readonly="" class="form-control form-filter input-sm">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm default">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </td><td rowspan="1" colspan="1">
                                <input type="text" name="order_customer_name" class="form-control form-filter input-sm"> </td><td rowspan="1" colspan="1">
                                <input type="text" name="order_ship_to" class="form-control form-filter input-sm"> </td><td rowspan="1" colspan="1">
                                <div class="margin-bottom-5">
                                    <input type="text" placeholder="From" name="order_price_from" class="form-control form-filter input-sm"> </div>
                                <input type="text" placeholder="To" name="order_price_to" class="form-control form-filter input-sm"> </td><td rowspan="1" colspan="1">
                                <div class="margin-bottom-5">
                                    <input type="text" placeholder="From" name="order_quantity_from" class="form-control form-filter input-sm margin-bottom-5 clearfix"> </div>
                                <input type="text" placeholder="To" name="order_quantity_to" class="form-control form-filter input-sm"> </td><td rowspan="1" colspan="1">
                                <select class="form-control form-filter input-sm" name="order_status">
                                    <option value="">Select...</option>
                                    <option value="pending">Pending</option>
                                    <option value="closed">Closed</option>
                                    <option value="hold">On Hold</option>
                                    <option value="fraud">Fraud</option>
                                </select>
                            </td><td rowspan="1" colspan="1">
                                <div class="margin-bottom-5">
                                    <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                        <i class="fa fa-search"></i> Search</button>
                                </div>
                                <button class="btn btn-sm red btn-outline filter-cancel">
                                    <i class="fa fa-times"></i> Reset</button>
                            </td></tr>
                        </thead>
                        <tbody> </tbody>
                    </table></div><div class="row"><div class="col-md-8 col-sm-12"><div class="dataTables_paginate paging_bootstrap_extended"><div class="pagination-panel"> Page <a class="btn btn-sm default prev disabled" href="#"><i class="fa fa-angle-left"></i></a><input type="text" style="text-align:center; margin: 0 5px;" maxlenght="5" class="pagination-panel-input form-control input-sm input-inline input-mini"><a class="btn btn-sm default next disabled" href="#"><i class="fa fa-angle-right"></i></a> of <span class="pagination-panel-total"></span></div></div><div class="dataTables_length"><label><span class="seperator">|</span>View <select name="datatable_ajax_length" aria-controls="datatable_ajax" class="form-control input-xs input-sm input-inline"><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option><option value="150">150</option><option value="-1">All</option></select> records</label></div><div class="dataTables_info"></div></div><div class="col-md-4 col-sm-12"></div></div></div>
        </div>
    </div>
</div>