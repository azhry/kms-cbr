<div class="page-content">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row margin-top-10">
        <div class="col-md-12">
            <h2>Selamat Datang.</h2>
            <a href="<?= base_url('anggota-lumbung/pengetahuan-tacit')?>">
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
                                Pengetahuan Tacit Saya
                            </div>
                        </div>
                        <a class="more" href="<?= base_url('anggota-lumbung/pengetahuan-tacit')?>">
                            View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
            </a>
            <a href="<?= base_url('anggota-lumbung/pengetahuan-eksplisit')?>">
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
                                Pengetahuan Eksplisit Saya
                            </div>
                        </div>
                        <a class="more" href="<?= base_url('anggota-lumbung/pengetahuan-eksplisit')?>">
                            View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!-- END PAGE CONTENT INNER -->
</div>