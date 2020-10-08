<?php include("../include/header.php"); ?>

<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Projects</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Projects
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

        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            </div>

            <div class="content-header-right col-md-6 col-12">
                <div class="dropdown float-md-right">
                    <button type="button" class="btn btn-info round btn-min-width mr-1 mb-1 edit_project" id="<?php echo $project_datas["ID"]; ?>"> <i class="la la-plus"></i> Edit Project</button>
                </div>
            </div>

        </div>


        <div class="content-detached content-left">
            <div class="content-body">
                <section class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-head">
                                <div class="card-header">
                                    <h4 class="card-title"><?php echo $project_datas["Project_Name"]; ?></h4>
                                </div>

                            </div>
                            <!-- project-info -->
                            <div id="project-info" class="card-body row">
                                <div class="col-md-12">
                                    <p>
                                        <?php echo $project_datas["Description"]; ?>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
                <!-- Task Progress -->
                <section class="row">

                    <?php
                    if (!empty($project_datas["Project_File"])) {
                    ?>
                        <!-- Project Files -->
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="file-content-inner">
                                <div class="row">
                                    <?php
                                    $project_files = $project_datas["Project_File"];
                                    $project_file = explode(',', $project_files);

                                    foreach ($project_file as $key => $project_file_value) {

                                        $file_extension = explode(".", $project_file_value);
                                        $file_extension =  end($file_extension);

                                        $file_path = 'Folders/Company_Folders/' . Classes_Session::get('Loggedin_Session') . '/Projects/' . $project_file_value;

                                        if ($file_extension == 'png' || $file_extension ==  'jpg' || $file_extension ==  'jpeg' || $file_extension ==  'gif') {
                                            $__fileview = '<img style="width: 100px; height:100px;" src="' . $result["Web_Url"] . $file_path . '">';
                                        } elseif ($file_extension == 'csv') {
                                            $__fileview = '<i style="font-size:100px" class="la la-file-excel-o"></i>';
                                        } elseif ($file_extension == 'pdf') {
                                            $__fileview = '<i style="font-size:100px" class="la la-file-pdf-o"></i>';
                                        } elseif ($file_extension == 'doc' || 'docs') {
                                            $__fileview = '<i style="font-size:100px" class="la la-file-word-o"></i>';
                                        } elseif ($file_extension == 'txt') {
                                            $__fileview = '<i style="font-size:100px" class="la la-file-text-o"></i>';
                                        } elseif ($file_extension == 'ppt' || $file_extension == 'pptx') {
                                            $__fileview = '<i style="font-size:100px" class="la la-file-powerpoint-o"></i>';
                                        } elseif ($file_extension == 'zip' || $file_extension == 'rar') {
                                            $__fileview = '<i style="font-size:100px" class="la la-file-zip-o"></i>';
                                        }

                                    ?>
                                        <div class="col-md-3 ">
                                            <div class="card card-file">
                                                <div class="dropdown-file">
                                                    <a href="" class="dropdown-link" data-toggle="dropdown"><i class="la la-ellipsis-v"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="<?php echo $result["Web_Url"]; ?>download?file_name=<?php echo $project_file_value; ?>" class="dropdown-item">Download</a>
                                                        <a href="#" id="<?php echo $project_file_value; ?>" class="dropdown-item delete_image">Delete</a>
                                                    </div>
                                                </div>

                                                <div class="card-file-thumb">
                                                    <?php echo $__fileview; ?>
                                                </div>
                                                <div class="card-body">
                                                    <h6><?php echo $project_file_value; ?></h6>
                                                    <span><?php echo Classes_Converter::file_size(filesize("../../" . $file_path)); ?></span>
                                                </div>
                                                <div class="card-footer">
                                                    <span class="d-none d-sm-inline">Last Modified: </span><?php echo date($localization_data["Date_Format"], strtotime($project_datas["Created_Date"])); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                        <!--/ Project Files -->
                    <?php
                    }
                    ?>

                </section>
            </div>
        </div>



        <div class="sidebar-detached sidebar-right" ,=",">
            <div class="sidebar">
                <div class="project-sidebar-content">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Project Details</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <table class="table table-striped table-border">
                            <tbody>
                                <tr>
                                    <td>Rate:</td>
                                    <td class="text-right"><?php echo $localization_data["Currency_Symbol"]; ?><?php echo $project_datas["Rate"]; ?></td>
                                </tr>
                                <tr>
                                    <td>Rate Type:</td>
                                    <td class="text-right"><?php echo $project_datas["Rate_Type"]; ?></td>
                                </tr>
                                <tr>
                                    <td>Created:</td>
                                    <td class="text-right"><?php echo date($localization_data["Date_Format"], strtotime($project_datas["Created_Date"])); ?></td>
                                </tr>
                                <tr>
                                    <td>Deadline:</td>
                                    <td class="text-right"><?php echo date($localization_data["Date_Format"], strtotime($project_datas["End_Date"])); ?></td>
                                </tr>
                                <tr>
                                    <td>Priority:</td>
                                    <td class="text-right"><span class="badge badge-default badge-danger"><?php echo $project_datas["Priority"]; ?></span></td>
                                </tr>
                                <tr>
                                    <td>Status:</td>
                                    <td class="text-right"><span class="badge badge-default badge-primary"><?php echo $project_datas["Status"]; ?></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Project Leader -->
                    <div class="card">
                        <div class="card-header mb-0">
                            <h4 class="card-title">Assigned Leader</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-content">
                                <div class="card-body  py-0 px-0">
                                    <div class="list-group">
                                        <a href="<?php echo $result["Web_Url"]; ?>view-employee?employee_id=<?php echo $project_datas["Leader"]; ?>" class="list-group-item">
                                            <div class="media">
                                                <div class="media-left pr-1">
                                                    <img style="width: 50px; height: 50px" src="<?php echo $result["Web_Url"]; ?><?php echo !empty($employee_datas_by_id["Image"]) ? 'Folders/Company_Folders/' . Classes_Session::get("Loggedin_Session") . '/Employee_Image/' . $employee_datas_by_id["Image"] : 'Folders/brand/no_image.png'; ?> " alt="Employee "><i></i>
                                                </div>
                                                <div class="media-body w-100">
                                                    <h6 class="media-heading mb-0"><?php echo $employee_datas_by_id["First_Name"] . ' ' . $employee_datas_by_id["Last_Name"]; ?></h6>
                                                    <p class="font-small-2 mb-0 text-muted"><?php echo $department_results["Department_Name"]; ?></p>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Project Leader -->
                </div>
            </div>
        </div>




    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php include("../include/footer.php"); ?>