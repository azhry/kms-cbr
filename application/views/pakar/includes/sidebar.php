<!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <div class="page-sidebar md-shadow-z-2-i  navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
            <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
            <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
            <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                <li>
                    <a href="<?= base_url('pakar') ?>">
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                    <span class="title">Data Problem</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= base_url('pakar/problem-solving') ?>">
                                <span class="title">Problem Solving</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('pakar/gejala') ?>">
                                <span class="title">Gejala</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('pakar/masalah') ?>">
                                <span class="title">Kasus</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('pakar/data-revise') ?>">
                                <span class="title">Data Revise</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                    <span class="title">Pengetahuan Saya</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= base_url('pakar/pengetahuan-tacit') ?>">
                                <span class="title">Tacit</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('pakar/pengetahuan-eksplisit') ?>">
                                <span class="title">Eksplisit</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                    <span class="title">Pengetahuan Yg Terbagikan</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= base_url('pakar/share-tacit') ?>">
                                <span class="title">Tacit</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('pakar/share-eksplisit') ?>">
                                <span class="title">Eksplisit</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                    <span class="title">Validasi Pengetahuan</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= base_url('pakar/validasi-tacit') ?>">
                                <span class="title">Tacit</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('pakar/validasi-eksplisit') ?>">
                                <span class="title">Eksplisit</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?= base_url('pakar/reward') ?>">
                        <span class="title">Reward</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('pakar/pengguna') ?>">
                        <span class="title">Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('pakar/unit') ?>">
                        <span class="title">Data Unit</span>
                    </a>
                </li>
            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
