<!-- Create Company Model -->
<div class="modal fade text-left" data-backdrop="false" id="create_company" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33" data-i18n="">Create Company</label>
                <button type="button" class="close" data-dismiss="modal" id="create_company_btn_close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <label data-i18n="">Company Email: </label>
                    <div class="form-group">
                        <input type="email" require placeholder="Company Email Address" id="company_email" name="company_email" class="form-control">
                        <input type="hidden" value="create_company_btn" name="create_company_btn" class="form-control">
                    </div>

                    <div class="form-group">
                        <label data-i18n="">Company ID: </label>
                        <input type="text" require placeholder="Company ID" id="company_id" name="company_id" class="form-control">
                    </div>

                    <input type="hidden" placeholder="ID" id="id" name="id" class="form-control">

                </div>
                <div class="modal-footer">
                    <button type="reset" id="create_company_btn_close" class="btn btn-outline-danger round  mr-1 mb-1" data-i18n="" data-dismiss="modal">Close</button>
                    <button type="button" id="create_company_btn" class="btn btn-success round  mr-1 mb-1" data-i18n=""> <i class="la la-save"></i> Create</button>

                </div>
            </form>
        </div>
    </div>
</div>



<!-- Create Package Model -->
<div class="modal fade text-left" data-backdrop="false" id="create_package" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33" data-i18n="">Create Package</label>
                <button type="button" class="close" id="package_popup_close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Plan Name: </label>
                            <div class="form-group">
                                <input type="text" require placeholder="Plan Name" id="plan_name" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Plan Amount: </label>
                            <div class="form-group">
                                <input type="text" require placeholder="Plan Amount" id="plan_amount" class="form-control number_only">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Plan Type: </label>
                            <div class="form-group">
                                <select class="select2 form-control" id="plan_type" style="width: 100%;">
                                    <option value="Monthly">Monthly</option>
                                    <option value="Yearly">Yearly</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">No of Users: </label>
                            <div class="form-group">
                                <select class="select2 form-control" id="no_user" style="width: 100%;">
                                    <option value="5">5 Users</option>
                                    <option value="50">50 Users</option>
                                    <option value="100">100 Users</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Plan Duration: </label>
                            <div class="form-group">
                                <select class="select2 form-control" id="plan_duration" style="width: 100%;">
                                    <option value="30">1 Month</option>
                                    <option value="180">6 Months</option>
                                    <option value="360">1 Year</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">No of Storage Space: </label>
                            <div class="form-group">
                                <select class="select2 form-control" id="storage_space" style="width: 100%;">
                                    <option value="5 MB">5 MB</option>
                                    <option value="1 GB">1 GB</option>
                                    <option value="6 GB">6 GB</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Status: </label>
                            <div class="form-group">
                                <label class="switch"><input type="checkbox" id="package_status" value="Active"><span class="switch-button"></span> </label>
                            </div>
                        </div>
                        <input type="hidden" id="plan_id" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="package_popup_close" data-dismiss="modal" data-i18n="">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" data-i18n="" id="package_button"> <i class="la la-save"></i> Create</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Change Plan Model -->
<div class="modal fade text-left" data-backdrop="false" id="change_company_package_plan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33" data-i18n="">Change Package Plan</label>
                <button type="button" class="close" id="package_popup_close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <input type="hidden" placeholder="ID" id="__company_id" name="__company_id" class="form-control">

                <div class="modal-body">
                    <div class="card-bodys card-dashboards table-responsives">

                        <table class="table table-striped table-bordereds" id="change_company_subscription_package_list">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Plan Name</th>
                                    <th>Plan Type</th>
                                    <th>Amount</th>
                                    <th>Plan Duration</th>
                                    <th>Storage Space</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Plan Name</th>
                                    <th>Plan Type</th>
                                    <th>Amount</th>
                                    <th>Plan Duration</th>
                                    <th>Storage Space</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>