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
                    <button type="button" class="btn btn-info round btn-min-width mr-1 mb-1" data-toggle="modal" data-target="#create_project"> <i class="la la-plus"></i> Create Project</button>
                </div>
            </div>

        </div>

        <div class="tabs-default">
            <ul class="float-md-right">
                <li><a href="#project_grid"><i class="la la-navicon"></i></a></li>
                <li><a href="#project_lists"><i class="la la-th"></i></a></li>
            </ul>
            <div id="project_grid">
                <br> <br><br>

                <div class="row" id="projects_grid_display">
                    <div class="col-lg-4 col-sm-12 col-md-4 col-xl-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Project Overview</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <div class="dropdown dropdown-action profile-action">
                                            <a href="#" class="action-icon dropdown-toggles" data-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(24px, 32px, 0px);">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project"><i class="la la-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project"><i class="la la-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <p>
                                        <strong>Pellentesque habitant morbi tristique</strong> senectus et netus
                                        et malesuada fames ac turpis egestas. Vestibulum tortor quam,
                                        feugiat vitae.
                                        <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend
                                        leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum
                                        erat wisi, condimentum sed, <code>commodo vitae</code>, ornare
                                        <div class="pro-deadline m-b-15">
                                            <div class="sub-title">
                                                Deadline:
                                            </div>
                                            <div class="text-muted">
                                                17 Apr 2019
                                            </div>
                                        </div>

                                        <div class="project-members m-b-15">
                                            <div>Project Leader :</div>
                                            <ul class="team-members">
                                                <li>
                                                    <a href="#" data-toggle="tooltip" title="" data-original-title="Jeffery Lalor"><img alt="" src="assets/img/profiles/avatar-16.jpg"></a>
                                                </li>
                                            </ul>
                                        </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Project Overview</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <div class="dropdown dropdown-action profile-action">
                                            <a href="#" class="action-icon dropdown-toggles" data-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(24px, 32px, 0px);">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project"><i class="la la-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project"><i class="la la-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <p>
                                        <strong>Pellentesque habitant morbi tristique</strong> senectus et netus
                                        et malesuada fames ac turpis egestas. Vestibulum tortor quam,
                                        feugiat vitae.
                                        <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend
                                        leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum
                                        erat wisi, condimentum sed, <code>commodo vitae</code>, ornare
                                        <div class="pro-deadline m-b-15">
                                            <div class="sub-title">
                                                Deadline:
                                            </div>
                                            <div class="text-muted">
                                                17 Apr 2019
                                            </div>
                                        </div>

                                        <div class="project-members m-b-15">
                                            <div>Project Leader :</div>
                                            <ul class="team-members">
                                                <li>
                                                    <a href="#" data-toggle="tooltip" title="" data-original-title="Jeffery Lalor"><img alt="" src="assets/img/profiles/avatar-16.jpg"></a>
                                                </li>
                                            </ul>
                                        </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Project Overview</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <div class="dropdown dropdown-action profile-action">
                                            <a href="#" class="action-icon dropdown-toggles" data-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(24px, 32px, 0px);">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project"><i class="la la-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project"><i class="la la-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <p>
                                        <strong>Pellentesque habitant morbi tristique</strong> senectus et netus
                                        et malesuada fames ac turpis egestas. Vestibulum tortor quam,
                                        feugiat vitae.
                                        <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend
                                        leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum
                                        erat wisi, condimentum sed, <code>commodo vitae</code>, ornare
                                        <div class="pro-deadline m-b-15">
                                            <div class="sub-title">
                                                Deadline:
                                            </div>
                                            <div class="text-muted">
                                                17 Apr 2019
                                            </div>
                                        </div>

                                        <div class="project-members m-b-15">
                                            <div>Project Leader :</div>
                                            <ul class="team-members">
                                                <li>
                                                    <a href="#" data-toggle="tooltip" title="" data-original-title="Jeffery Lalor"><img alt="" src="assets/img/profiles/avatar-16.jpg"></a>
                                                </li>
                                            </ul>
                                        </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Project Overview</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <div class="dropdown dropdown-action profile-action">
                                            <a href="#" class="action-icon dropdown-toggles" data-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(24px, 32px, 0px);">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project"><i class="la la-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project"><i class="la la-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <p>
                                        <strong>Pellentesque habitant morbi tristique</strong> senectus et netus
                                        et malesuada fames ac turpis egestas. Vestibulum tortor quam,
                                        feugiat vitae.
                                        <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend
                                        leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum
                                        erat wisi, condimentum sed, <code>commodo vitae</code>, ornare
                                        <div class="pro-deadline m-b-15">
                                            <div class="sub-title">
                                                Deadline:
                                            </div>
                                            <div class="text-muted">
                                                17 Apr 2019
                                            </div>
                                        </div>

                                        <div class="project-members m-b-15">
                                            <div>Project Leader :</div>
                                            <ul class="team-members">
                                                <li>
                                                    <a href="#" data-toggle="tooltip" title="" data-original-title="Jeffery Lalor"><img alt="" src="assets/img/profiles/avatar-16.jpg"></a>
                                                </li>
                                            </ul>
                                        </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Project Overview</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <div class="dropdown dropdown-action profile-action">
                                            <a href="#" class="action-icon dropdown-toggles" data-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(24px, 32px, 0px);">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project"><i class="la la-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project"><i class="la la-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <p>
                                        <strong>Pellentesque habitant morbi tristique</strong> senectus et netus
                                        et malesuada fames ac turpis egestas. Vestibulum tortor quam,
                                        feugiat vitae.
                                        <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend
                                        leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum
                                        erat wisi, condimentum sed, <code>commodo vitae</code>, ornare
                                        <div class="pro-deadline m-b-15">
                                            <div class="sub-title">
                                                Deadline:
                                            </div>
                                            <div class="text-muted">
                                                17 Apr 2019
                                            </div>
                                        </div>

                                        <div class="project-members m-b-15">
                                            <div>Project Leader :</div>
                                            <ul class="team-members">
                                                <li>
                                                    <a href="#" data-toggle="tooltip" title="" data-original-title="Jeffery Lalor"><img alt="" src="assets/img/profiles/avatar-16.jpg"></a>
                                                </li>
                                            </ul>
                                        </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="project_lists">
                <br> <br><br>
                <section id="file-export">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-content collapse show ">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="projects_list">
                                    <thead>
                                        <tr>
                                            <th>Project Name</th>
                                            <th>Client</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Rate</th>
                                            <th>Rate Type</th>
                                            <th>Priority</th>
                                            <th>Leader</th>
                                            <th>Created Date</th>
                                            <th>Created By</th>
                                            <th>Modified Date</th>
                                            <th>Modified By</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Project Name</th>
                                            <th>Client</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Rate</th>
                                            <th>Rate Type</th>
                                            <th>Priority</th>
                                            <th>Leader</th>
                                            <th>Created Date</th>
                                            <th>Created By</th>
                                            <th>Modified Date</th>
                                            <th>Modified By</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>



    </div>
</div>

<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php include("../include/footer.php"); ?>