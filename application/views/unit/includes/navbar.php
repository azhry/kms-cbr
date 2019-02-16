<!-- BEGIN HEADER -->
<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?= base_url('pemilik') ?>">
                <img src="<?= base_url('assets/metronic') ?>/assets/admin/layout4/img/logo-light.png" alt="logo" class="logo-default"/>
            </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-bell"></i>
                        <?php if (count($u_notifikasi) > 0): ?>
                            <span class="badge badge-danger">
                            <?= count($u_notifikasi) ?> </span>
                        <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                    <?php foreach ($notifikasi as $row): ?>
                                        <?php  
                                            if ($row->jenis == 'Tacit' or $row->jenis == 'Tag Tacit')
                                            {
                                                $notifikasi = 'Pengetahuan tacit anda telah divalidasi';
                                                $link = base_url('unit/detail-pengetahuan-tacit/' . $row->id_pengetahuan);
                                                if ($row->jenis == 'Tag Tacit')
                                                {
                                                    $notifikasi = 'Anda ditandai pada pengetahuan tacit';
                                                }
                                            }
                                            else
                                            {
                                                $notifikasi = 'Pengetahuan eksplisit anda telah divalidasi';
                                                $link = base_url('unit/detail-pengetahuan-eksplisit/' . $row->id_pengetahuan);
                                                if ($row->jenis == 'Tag Eksplisit')
                                                {
                                                    $notifikasi = 'Anda ditandai pada pengetahuan eksplisit';
                                                }
                                            }
                                        ?>
                                        <li>
                                            <a href="<?= $link ?>">
                                            <span class="time" style="font-size: 9px;"><?= time_elapsed_string($row->created_at) ?></span>
                                            <span class="details">
                                            <span class="label label-sm label-icon label-danger">
                                            <i class="icon-bell"></i>
                                            </span>
                                            <?= $notifikasi ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- END NOTIFICATION DROPDOWN -->
                    <li class="separator hide">
                    </li>
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <span class="username username-hide-on-mobile">
                        <?= $data_pengguna->nama ?> </span>
                        <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                        <img alt="" class="img-circle" src="<?= file_exists(FCPATH . 'assets/foto/' . $data_pengguna->id_pengguna . '.jpg') ? base_url('assets/foto/' . $data_pengguna->id_pengguna . '.jpg') : 'http://placehold.it/200' ?>"/>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="<?= base_url('unit/profile') ?>">
                                <i class="icon-user"></i> Profile </a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="<?= base_url('logout') ?>">
                                <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>

<!-- BEGIN CONTAINER -->
<div class="page-container">
