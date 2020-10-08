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
                            <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>invoice">Invoice List</a>
                            </li>
                            <li class="breadcrumb-item active">Invoice Detail
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
            <div class="printableArea">
                <section class="card">
                    <div id="invoice-template" class="card-body">
                        <!-- Invoice Company Details -->
                        <div id="invoice-company-details" class="row">
                            <div class="col-md-6 col-sm-12 text-center text-md-left">
                                <div class="media">
                                    <img style="width: 120px; height: 100px" src="<?php echo $result["Web_Url"]; ?>Folders/Company_Folders/<?php echo $company_data_f["Subscriber_ID"]; ?>/Logo/<?php echo $theme_data["Logo"]; ?>" alt="" class="" />
                                    <div class="media-body">
                                        <ul class="ml-2 px-0 list-unstyled">
                                            <li class="text-bold-800"><?php echo $company_data_f["Company_Name"]; ?></li>
                                            <li><?php echo wordwrap($company_data_f["Company_Address"], 35, "<br/>", false); ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 text-center text-md-right">
                                <h2>INVOICE</h2>
                                <p class="pb-3 text-bold-700">#INV-<?php echo $invoicedata["Invoice_ID"]; ?></p>
                            </div>
                        </div>
                        <!--/ Invoice Company Details -->
                        <!-- Invoice Customer Details -->
                        <div id="invoice-customer-details" class="row pt-2">
                            <div class="col-sm-12 text-center text-md-left">
                                <p class="text-muted">Invoice To</p>
                            </div>
                            <div class="col-md-6 col-sm-12 text-center text-md-left">
                                <ul class="px-0 list-unstyled">
                                    <li class="text-bold-800"><?php echo $client_datas_by_id["Contact_Person"]; ?></li>
                                    <li><?php echo wordwrap($invoicedata["Client_Address"], 35, "<br/>", false); ?></li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-sm-12 text-center text-md-right">
                                <p>
                                    <span class="text-muted">Invoice Date :</span> <?php echo date($localization_data["Date_Format"], strtotime($invoicedata["Invoice_Date"])); ?></p>

                                <span class="text-muted">Due Date :</span> <?php echo date($localization_data["Date_Format"], strtotime($invoicedata["Invoice_Due_Date"])); ?></p>
                            </div>
                        </div>
                        <!--/ Invoice Customer Details -->
                        <!-- Invoice Items Details -->
                        <div id="invoice-items-details" class="pt-2">
                            <div class="row">
                                <div class="table-responsive col-sm-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Item</th>
                                                <th>Description</th>
                                                <th class="text-left">Cost</th>
                                                <th class="text-left">Qty</th>
                                                <th class="text-left">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $iterate = 0;
                                            $total_amount = 0;
                                            foreach ($invoice_item_data as $key => $invoice_item_data_value) {
                                                $iterate++;
                                                $total_amount += $invoice_item_data_value["Amount"];
                                            ?>
                                                <tr>
                                                    <th scope="row"><?php echo $iterate; ?></th>
                                                    <td><?php echo $invoice_item_data_value["Item_Name"]; ?></td>
                                                    <td><?php echo $invoice_item_data_value["Description"]; ?></td>
                                                    <td class="text-left"><?php echo $localization_data["Currency_Symbol"]; ?><?php echo number_format($invoice_item_data_value["Cost"], 2); ?></td>
                                                    <td class="text-left"><?php echo $invoice_item_data_value["Quantity"]; ?></td>
                                                    <td class="text-left"><?php echo $localization_data["Currency_Symbol"]; ?><?php echo number_format($invoice_item_data_value["Amount"], 2); ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7 col-sm-12 text-center text-md-left">

                                </div>
                                <div class="col-md-5 col-sm-12">
                                    <br /><br />
                                    <p class="lead">Total due</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>

                                                <?php
                                                $discount = $invoicedata["Invoice_Discount"];
                                                $discount_per = $discount / 100;
                                                $total_discount = $total_amount * $discount_per;
                                                if (!empty($invoicedata["Invoice_Discount"])) {
                                                ?>
                                                    <tr>
                                                        <td>Discount (<?php echo $invoicedata["Invoice_Discount"]; ?>%)</td>
                                                        <td class="text-right"><?php echo $localization_data["Currency_Symbol"]; ?><?php echo number_format($total_discount, 2); ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                                <tr>
                                                    <td class="text-bold-800">Total</td>
                                                    <td class="text-bold-800 text-right"><?php echo $localization_data["Currency_Symbol"]; ?><?php echo number_format($invoicedata["Total"], 2); ?></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center">
                                        <p>Authorized person</p>

                                        <br /><br /><br /><br /><br /><br />
                                        <h6><b>
                                                <hr></b><?php echo $company_data_f["Company_Sign_Name"]; ?></h6>
                                        <p class="text-muted"><?php echo $company_data_f["Company_Sign_Position"]; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Invoice Footer -->
                        <div id="invoice-footer">
                            <div class="row">
                                <div class="col-md-7 col-sm-12">
                                    <h6>Other Description</h6>
                                    <p><?php echo $invoicedata["Other_Description"]; ?></p>
                                </div>
                            </div>
                        </div>
                        <!--/ Invoice Footer -->
                    </div>
                </section>
            </div>
            <!-- File export table -->
            <center>
                <div class="row">
                    <div class="col-md-4 col-sm-12 text-center">
                        <button type="button" class="btn btn-danger btn-lg my-1" id="print"><i class="la la-print"></i> Print</button>
                    </div>

                    <div class="col-md-4 col-sm-12 text-center">
                        <button type="button" class="btn btn-success btn-lg my-1 invoice_pdf_btn" id="<?php echo $invoicedata["Invoice_ID"]; ?>"><i class="la la-download"></i> Download PDF</button>
                    </div>

                    <div class="col-md-4 col-sm-12 text-center">
                        <button type="button" class="btn btn-info btn-lg my-1 invoice_email_btn" id="<?php echo $invoicedata["Invoice_ID"]; ?>"><i class="la la-paper-plane-o"></i> Send to Mail</button>
                    </div>

                </div>

            </center>
        </div>
    </div>

<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php include("../include/footer.php"); ?>