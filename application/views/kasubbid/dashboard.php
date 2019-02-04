<div class="page-content">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row margin-top-10">
        <div class="col-md-12">
            <h2>Selamat Datang.</h2>
            <a href="<?= base_url('kasubbid/pengetahuan-tacit')?>">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat red">
                        <div class="visual">
                            <i class="fa fa-file"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?= count($pengetahuan_tacit) ?>
                            </div>
                            <div class="desc">
                                Pengetahuan Tacit
                            </div>
                        </div>
                        <a class="more" href="<?= base_url('kasubbid/pengetahuan-tacit')?>">
                            View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
            </a>
            <a href="<?= base_url('kasubbid/pengetahuan-eksplisit')?>">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat green">
                        <div class="visual">
                            <i class="fa fa-file-o"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?= count($pengetahuan_eksplisit) ?>
                            </div>
                            <div class="desc">
                                Pengetahuan Eksplisit
                            </div>
                        </div>
                        <a class="more" href="<?= base_url('kasubbid/pengetahuan-eksplisit')?>">
                            View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
            </a>
            <a href="<?= base_url('kasubbid/masalah')?>">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat blue">
                        <div class="visual">
                            <i class="fa fa-info"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?= count($masalah) ?>
                            </div>
                            <div class="desc">
                                Data Kasus
                            </div>
                        </div>
                        <a class="more" href="<?= base_url('kasubbid/masalah')?>">View More<i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
            </a>
            <a href="<?= base_url('kasubbid/pengguna')?>">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat yellow">
                        <div class="visual">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?= count($pengguna) ?>
                            </div>
                            <div class="desc">
                                Data Pengguna
                            </div>
                        </div>
                        <a class="more" href="<?= base_url('kasubbid/pengguna')?>">View More<i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!-- END PAGE CONTENT INNER -->
</div>