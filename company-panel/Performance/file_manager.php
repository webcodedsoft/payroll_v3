<?php include("../include/header.php"); ?>




    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">File Manager</h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Users</a>
                            </li>
                            <li class="breadcrumb-item active">File Manager
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="dropdown float-md-right">
                    <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownBreadcrumbButton"><a class="dropdown-item" href="#"><i class="la la-calendar-check-o"></i> Calender</a>
                        <a class="dropdown-item" href="#"><i class="la la-cart-plus"></i> Cart</a>
                        <a class="dropdown-item" href="#"><i class="la la-life-ring"></i> Support</a>
                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="file-wrap">


                <div class="file-sidebar">
                    <div class="file-header justify-content-center">
                        <span>Projects</span>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <div class="file-pro-list">
                            <div class="file-scroll">
                                <ul class="file-menu" id="file_pro_list">

                                </ul>
                            </div>
                        </div>
                        <br>
                        <div class="card-body" style="padding: 0px">
                            <canvas id="storage_chart" width="200" height="200"></canvas>
                        </div>


                    </div>
                </div>
                <div class="file-cont-wrap">
                    <div class="file-cont-inner">
                        <div class="file-cont-header">
                            <div class="file-options">
                                <!-- <a href="javascript:void(0)" id="file_sidebar_toggle" class="file-sidebar-toggle">
                                    <i class="la la-bars"></i>
                                </a> -->
                            </div>
                            <span>File Manager</span>
                            <div class="file-options">
                                <!-- <span class="btn-file"><input type="file" class="upload"><i class="la la-cloud-upload"></i></span> -->
                            </div>
                        </div>
                        <div class="file-content">

                            <div class="file-body">
                                <div class="file-scroll">
                                    <div class="file-content-inner">


                                        <div class="row" id="file_list_view">
                                            <div></div>
                                            <?php
                                            $file_datas = Classes_Upload::get($company_data_f["Subscriber_ID"]);

                                            foreach ($file_datas["Files"] as $key => $file_data) {
                                                $real_path = substr($file_datas["Path"], 6);
                                                $file_extension = explode(".", $file_data);
                                                $file_extension =  end($file_extension);

                                                if ($file_extension == 'png' || $file_extension ==  'jpg' || $file_extension ==  'jpeg' || $file_extension ==  'gif') {
                                                    $__fileview = '<img style="width: 100px; height:100px;" src="' . $result["Web_Url"] . $real_path . '/' . $file_data . '">';
                                                } elseif ($file_extension == 'csv') {
                                                    $__fileview = '<i style="font-size:100px" class="la la-file-excel-o"></i>';
                                                } elseif ($file_extension == 'pdf') {
                                                    $__fileview = '<i style="font-size:100px" class="la la-file-pdf-o"></i>';
                                                } elseif ($file_extension == 'txt') {
                                                    $__fileview = '<i style="font-size:100px" class="la la-file-text-o"></i>';
                                                } elseif ($file_extension == 'ppt' || $file_extension == 'pptx') {
                                                    $__fileview = '<i style="font-size:100px" class="la la-file-powerpoint-o"></i>';
                                                } elseif ($file_extension == 'zip' || $file_extension == 'rar') {
                                                    $__fileview = '<i style="font-size:100px" class="la la-file-zip-o"></i>';
                                                } elseif ($file_extension == 'doc' || 'docx') {
                                                    $__fileview = '<i style="font-size:100px" class="la la-file-word-o"></i>';
                                                }

                                            ?>
                                                <div class="col-md-3 ">
                                                    <div class="card card-file">
                                                        <div class="dropdown-file">
                                                            <a href="" class="dropdown-link" data-toggle="dropdown"><i class="la la-ellipsis-v"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a onclick="location.href='<?php echo $result['Web_Url']; ?>download?file_name=<?php echo $file_data; ?>'" class="dropdown-item">Download</a>
                                                                <a href="#" id="<?php echo $file_data; ?>" class="dropdown-item delete_image">Delete</a>
                                                            </div>
                                                        </div>
                                                        <div class="card-file-thumb">
                                                            <?php echo $__fileview; ?>
                                                        </div>
                                                        <div class="card-body">
                                                            <h6><?php echo $file_data; ?></h6>
                                                            <span><?php echo Classes_Converter::file_size(filesize($file_datas["Path"] . "/" . $file_data)); ?></span>
                                                        </div>
                                                        <div class="card-footer">
                                                            <span class="d-none d-sm-inline">Last Modified: </span><?php echo Classes_Converter::TimeConvert(date("Y-m-d H:i:s", filemtime($file_datas["Path"] . "/" . $file_data))); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>





                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>


<?php include("../include/footer.php"); ?>