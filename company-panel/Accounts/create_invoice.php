<?php include("../include/header.php"); ?>



    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Invoice</h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>invoice">Invoice</a>
                            </li>
                            <li class="breadcrumb-item active"><?php echo strpos($server, 'edit-invoice') ? 'Edit Invoice' : 'Create Invoice'; ?>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="dropdown float-md-right">
                    <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                </div>
            </div>
        </div>
        <div class="content-body">

            <!-- File export table -->

            <input class="form-control" type="text" hidden id="invoice_id" value="<?php echo $invoicedata["Invoice_ID"]; ?>">

            <section class="card">
                <div id="invoice-template" class="card-body">
                    <!-- Invoice Company Details -->
                    <div class="row" data-select2-id="13">
                        <div class="col-sm-6 col-md-4" data-select2-id="12">
                            <div class="form-group" data-select2-id="11">
                                <label>Client <span class="text-danger">*</span></label>
                                <select class="select2 form-control" id="invoice_client_id" style="width: 100%;">
                                    <option disabled <?php echo strpos($server, 'edit-invoice') ? '' : 'selected'; ?>>Select Client</option>
                                    <?php
                                    foreach ($client_datas as $key => $client_datas_value) {
                                    ?>
                                        <option <?php echo $client_datas_value["Client_ID"] == $invoicedata["Client_ID"] ? 'selected' : ''; ?> value="<?php echo $client_datas_value["Client_ID"]; ?>"><?php echo $client_datas_value["Company_Name"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4" data-select2-id="21">
                            <div class="form-group" data-select2-id="20">
                                <label>Project <span class="text-danger">*</span></label>
                                <select class="select2 form-control" id="invoice_client_project" style="width: 100%;">
                                    <?php
                                    if (!empty($invoicedata["Project_ID"])) {
                                    ?>
                                        <option selected value="<?php echo $invoicedata["Project_ID"]; ?>"><?php echo $invoice_project_datas["Project_Name"]; ?></option>
                                    <?php
                                    } else {
                                    ?>
                                        <option disabled selected>Select Project</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" id="invoice_client_email" value="<?php echo $invoicedata["Client_Email"]; ?>" placeholder="Client Email">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>Client Address</label>
                                <textarea class="form-control" id="invoice_client_address" rows="3"><?php echo $invoicedata["Client_Address"]; ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>Invoice date <span class="text-danger">*</span></label>
                                <input class="form-control" type="date" id="invoice_date" value="<?php echo $invoicedata["Invoice_Date"]; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>Due Date <span class="text-danger">*</span></label>
                                <input class="form-control" type="date" id="invoice_due_date" value="<?php echo $invoicedata["Invoice_Due_Date"]; ?>">
                            </div>
                        </div>
                    </div>
                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">

                            <div class="col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-white" id="additional_row">
                                        <thead>
                                            <tr>
                                                <th class="col-sm-2">Item</th>
                                                <th class="col-md-6">Description</th>
                                                <th style="width:100px;">Unit Cost</th>
                                                <th style="width:80px;">Qty</th>
                                                <th>Amount</th>
                                                <th> <a href="javascript:void(0)" class="text-success" id="add_more_row" title="Add"><i class="la la-plus"></i></a></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if (strpos($server, 'edit-invoice')) {
                                                //var_dump($invoice_item_data);
                                                $count = 0;
                                                foreach ($invoice_item_data as $key => $invoice_item_data_value) {
                                                    $count++;
                                            ?>
                                                    <tr id="<?php echo $invoice_item_data_value["ID"]; ?>">
                                                        <input class="form-control item_id" id="item_id" hidden value="<?php echo $invoice_item_data_value["ID"]; ?>" type="text" style="min-width:150px">

                                                        <td>
                                                            <input class="form-control item_name" id="item_name" value="<?php echo $invoice_item_data_value["Item_Name"]; ?>" type="text" style="min-width:150px">
                                                        </td>
                                                        <td>
                                                            <input class="form-control item_description" id="item_description" value="<?php echo $invoice_item_data_value["Description"]; ?>" type="text" style="min-width:150px">
                                                        </td>
                                                        <td>
                                                            <input class="form-control item_cost number_onlys" id="item_cost1" value="<?php echo $invoice_item_data_value["Cost"]; ?>" style="width:100px" type="text">
                                                        </td>
                                                        <td>
                                                            <input class="form-control quantity number_onlys" onkeypress="this.__handleChange" id="1" value="<?php echo $invoice_item_data_value["Quantity"]; ?>" style="width:80px" type="text">
                                                        </td>
                                                        <td>
                                                            <input class="form-control item_amount number_onlys" readonly="" id="item_amount1" value="<?php echo $invoice_item_data_value["Amount"]; ?>" style="width:120px" type="text">
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)" class="text-danger remove_data_row" id="<?php echo $invoice_item_data_value["ID"]; ?>" data-row="<?php echo $invoice_item_data_value["ID"]; ?>" title="Remove"><i class="la la-trash-o"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <input class="form-control item_name" id="item_name" type="text" style="min-width:150px">
                                                    </td>
                                                    <td>
                                                        <input class="form-control item_description" id="item_description" type="text" style="min-width:150px">
                                                    </td>
                                                    <td>
                                                        <input class="form-control item_cost number_onlys" id="item_cost1" style="width:100px" type="text">
                                                    </td>
                                                    <td>
                                                        <input class="form-control quantity number_onlys" onkeypress="this.__handleChange" id="1" style="width:80px" type="text">
                                                    </td>
                                                    <td>
                                                        <input class="form-control item_amount number_onlys" readonly="" id="item_amount1" style="width:120px" type="text">
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>


                                        </tbody>
                                    </table>
                                </div>


                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-7 col-sm-12 text-center text-md-left">

                            </div>
                            <div class="col-md-12 col-sm-12">
                                <br /><br />
                                <div class="table-responsive">
                                    <table class="table table-hover table-white">
                                        <tbody>
                                            <p class="lead text-right">Total due</p>

                                            <tr>
                                                <td colspan="5" class="text-right">
                                                    Discount %
                                                </td>
                                                <td class="text-right" style="padding-right: 30px;width: 230px">
                                                    <input class="form-control text-right" type="text" value="<?php echo $invoicedata["Invoice_Discount"]; ?>" id="invoice_discount" onkeypress="this.__handleChange">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right; font-weight: bold">
                                                    Total
                                                </td>
                                                <td class="text-right" style="padding-right: 30px;width: 230px; font-weight: bold; font-size: 16px;">
                                                    <?php echo $localization_data["Currency_Symbol"]; ?><b id="final_total"><?php echo empty($invoicedata["Total"]) ? '0.00' : number_format($invoicedata["Total"], 2); ?></b>
                                                </td>
                                                <input class="form-control text-right" type="text" hidden value="<?php echo empty($invoicedata["Total"]) ? '0.00' : $invoicedata["Total"]; ?>" id="invoice_final_total">

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- Invoice Footer -->
                    <div id="invoice-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br /><br />
                                    <label>Other Information</label>
                                    <textarea class="form-control" id="other_desc"><?php echo $invoicedata["Other_Description"]; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 text-center">
                                <button type="button" class="btn btn-info btn-lg my-1 save_invoice_btn" id="save_invoice"><i class="la la-save"></i> <?php echo empty($invoicedata["Invoice_ID"]) ? 'Save Invoice' : 'Update Invoice'; ?></button>
                            </div>
                        </div>

                    </div>
                    <!--/ Invoice Footer -->
                </div>
            </section>
            <!-- File export table -->

        </div>
    </div>

<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php include("../include/footer.php"); ?>