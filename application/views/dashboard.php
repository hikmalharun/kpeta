<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/sidebar'); ?>
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row"></div>
        <div class="content-body">
            <!-- Dashboard Analytics Start -->
            <section>
                <div class="container-fluid">
                    <table style="width:100%;" class="mb-2">
                        <tr>
                            <td style="float: left;"><?php echo $tanggal; ?></td>
                            <td style="float: right;">
                                <div id='txt'></div>
                                <script>
                                    function startTime() {
                                        const today = new Date();
                                        let h = today.getHours();
                                        let m = today.getMinutes();
                                        let s = today.getSeconds();
                                        m = checkTime(m);
                                        s = checkTime(s);
                                        document.getElementById('txt').innerHTML = h + ":" + m + ":" + s;
                                        setTimeout(startTime, 1000);
                                    }

                                    function checkTime(i) {
                                        if (i < 10) {
                                            i = "0" + i
                                        }; // add zero in front of numbers < 10
                                        return i;
                                    }
                                </script>
                            </td>
                    </table>
                </div>

                <div class="card card-profile">
                    <img src="<?php echo base_url(); ?>assets/images/bg-profile.jpg" class="img-fluid card-img-top" alt="Profile Cover Photo">
                    <div class="card-body">
                        <div class="profile-image-wrapper">
                            <div class="profile-image">
                                <div class="avatar">
                                    <?php
                                    $nows = date_default_timezone_set('Asia/Jakarta');
                                    $nows = date('H:i:s');
                                    $jam = strtotime($nows);
                                    $jam_masuk = strtotime($skema['masuk']);
                                    //$jam_masuk = strtotime('13:30:00');
                                    $jam_pulang = strtotime($skema['pulang']);
                                    //$jam_pulang = strtotime('19:00:00');
                                    $batas_awal_masuk = $jam_masuk - 7200;
                                    $batas_akhir_masuk = $jam_masuk + 7200;
                                    $batas_akhir_pulang = $jam_pulang + 7200;

                                    $countmasuk = $this->db->get_where('absen_masuk', ['email' => $this->session->userdata('email'), 'tanggal_absen' => date('Y-m-d')])->num_rows();
                                    $countpulang = $this->db->get_where('absen_pulang', ['email' => $this->session->userdata('email'), 'tanggal_absen' => date('Y-m-d')])->num_rows();
                                    ?>
                                    <?php if ($jam < $batas_akhir_masuk) { ?>
                                        <?php if ($jam > $batas_awal_masuk) { ?>
                                            <?php if ($countmasuk >= 1) { ?>
                                                <?php if ($user['gambar'] == "default.jpg") { ?>
                                                    <img src="<?php echo base_url('assets/images/default.jpg') ?>" alt="">
                                                <?php } else { ?>
                                                    <img src="<?php echo base_URL('assets/images/profile/') . $user['gambar']; ?>" alt="gambar">
                                                <?php } ?>
                                            <?php } else { ?>
                                                <?php if ($countmasuk == 0) { ?>
                                                    <?php if ($user['role_id'] == 2) { ?>
                                                        <a href="<?php echo base_url('pegawai/absen_masuk') ?>">
                                                            <i class="fas fa-bell text-warning" style="font-size: 80px; padding: 10px 14px 10px 14px;"></i>
                                                        </a>
                                                    <?php } else { ?>
                                                        <a href="<?php echo base_url('admin/pegawai/absen_masuk') ?>">
                                                            <i class="fas fa-bell text-warning" style="font-size: 80px; padding: 10px 14px 10px 14px;"></i>
                                                        </a>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } elseif ($jam > $jam_pulang) { ?>
                                        <?php if ($jam < $batas_akhir_pulang) { ?>
                                            <?php if ($countpulang >= 1) { ?>
                                                <?php if ($user['gambar'] == "default.jpg") { ?>
                                                    <img src="<?php echo base_url('assets/images/default.jpg') ?>" alt="">
                                                <?php } else { ?>
                                                    <img src="<?php echo base_URL('assets/images/profile/') . $user['gambar']; ?>" alt="gambar">
                                                <?php } ?>
                                            <?php } else { ?>
                                                <?php if ($countpulang == 0) { ?>
                                                    <?php if ($user['role_id'] == 2) { ?>
                                                        <a href="<?php echo base_url('pegawai/absen_pulang') ?>">
                                                            <i class="fas fa-bell text-warning" style="font-size: 80px; padding: 10px 14px 10px 14px;"></i>
                                                        </a>
                                                    <?php } else { ?>
                                                        <a href="<?php echo base_url('admin/pegawai/absen_pulang') ?>">
                                                            <i class="fas fa-bell text-warning" style="font-size: 80px; padding: 10px 14px 10px 14px;"></i>
                                                        </a>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php if ($user['gambar'] == "default.jpg") { ?>
                                            <img src="<?php echo base_url('assets/images/default.jpg') ?>" alt="">
                                        <?php } else { ?>
                                            <img src="<?php echo base_URL('assets/images/profile/') . $user['gambar']; ?>" alt="gambar">
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h3><?php echo strtoupper($user['name']); ?></h3>
                                <h6 class="text-muted"><?php echo $user['jabatan']; ?></h6>
                            </div>
                            <div class="col-sm-6">
                                <h3>DINAS PENDIDIKAN</h3>
                                <h6 class="text-muted"><?php echo $user['sekolah']; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="text-center mt-2">
                <h6 class="fs-6">SKEMA : ABSESNSI DI <?php echo $skema['lokasi']; ?></h6>
                <h6 class="fs-6">LOKASI : <?php echo $skema['lokasi']; ?></h6>
                <table style="width: 100%;" class="mt-1">
                    <tr>
                        <td>
                            <?php if ($masuk) { ?>
                                <i class="far fa-clock fs-1"></i>
                                <h3><?php echo $skema['masuk']; ?></h3>
                                <h6 class="text-muted">Masuk Kantor</h6>
                                <span class="badge badge-light-success rounded-pill fs-3"><?php echo $masuk['jam_absen']; ?></span><br>
                                <p class="badge badge-light-success rounded-pill fs-5"><?php echo round($masuk['jarak'], 0); ?> Meter</p>
                            <?php } else { ?>
                                <i class="far fa-clock fs-1"></i>
                                <h3><?php echo $skema['masuk']; ?></h3>
                                <h6 class="text-muted">Masuk Kantor</h6>
                                <span class="badge badge-light-success rounded-pill fs-3">-</span><br>
                                <p class="badge badge-light-success rounded-pill fs-5">0 Meter</p>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($pulang) { ?>
                                <i class="far fa-clock fs-1"></i>
                                <h3><?php echo $skema['pulang']; ?></h3>
                                <h6 class="text-muted">Pulang Kantor</h6>
                                <span class="badge badge-light-danger rounded-pill fs-3"><?php echo $pulang['jam_absen']; ?></span><br>
                                <p class="badge badge-light-danger rounded-pill fs-5"><?php echo round($pulang['jarak'], 0); ?> Meter</p>
                            <?php } else { ?>
                                <i class="far fa-clock fs-1"></i>
                                <h3><?php echo $skema['pulang']; ?></h3>
                                <h6 class="text-muted">Pulang Kantor</h6>
                                <span class="badge badge-light-danger rounded-pill fs-3">-</span><br>
                                <p class="badge badge-light-danger rounded-pill fs-5">0 Meter</p>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </section>
            <?php
            $bulan = date('m');
            if ($bulan == '01') {
                $month = "JANUARI";
            } elseif ($bulan == '02') {
                $month = "FEBRUARI";
            } elseif ($bulan == '03') {
                $month = "MARET";
            } elseif ($bulan == '04') {
                $month = "APRIL";
            } elseif ($bulan == '05') {
                $month = "MEI";
            } elseif ($bulan == '06') {
                $month = "JUNI";
            } elseif ($bulan == '07') {
                $month = "JULI";
            } elseif ($bulan == '08') {
                $month = "AGUSTUS";
            } elseif ($bulan == '09') {
                $month = "SEPTEMBER";
            } elseif ($bulan == '10') {
                $month = "OKTOBER";
            } elseif ($bulan == '11') {
                $month = "NOVEMBER";
            } elseif ($bulan == '12') {
                $month = "DESEMBER";
            } else {
                $month = "";
            }
            ?>
            <section class="text-center mt-3">
                <div class="card">
                    <div class="container-fluid">
                        <h3 class="m-2"><strong>DATA ABSEN MASUK BULAN <?php echo $month; ?></strong></h3>
                        <div class="table-responsive m-2">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Jarak</th>
                                        <th>Alamat</th>
                                        <th>Foto</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rekap_masuk as $m) : ?>
                                        <tr>
                                            <td><?php echo $m['tanggal_absen']; ?></td>
                                            <td><?php echo $m['jam_absen']; ?></td>
                                            <td><?php echo round($m['jarak']) . " Meter"; ?></td>
                                            <td><?php echo $m['address']; ?></td>
                                            <td><img src="<?php echo base_url('uploads/') . $m['gambar']; ?>" alt="Gambar" width="65px"></td>
                                            <td></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <section class="text-center mt-3">
                <div class="card">
                    <div class="container-fluid">
                        <h3 class="m-2"><strong>DATA ABSEN PULANG BULAN <?php echo $month; ?></strong></h3>
                        <div class="table-responsive m-2">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Jarak</th>
                                        <th>Alamat</th>
                                        <th>Foto</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rekap_pulang as $p) : ?>
                                        <tr>
                                            <td><?php echo $p['tanggal_absen']; ?></td>
                                            <td><?php echo $p['jam_absen']; ?></td>
                                            <td><?php echo round($p['jarak']) . " Meter"; ?></td>
                                            <td><?php echo $p['address']; ?></td>
                                            <td><img src="<?php echo base_url('uploads/') . $p['gambar']; ?>" alt="Gambar" width="65px" height="85px"></td>
                                            <td></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <!-- <section class="text-center mt-2">
                <div class="card">
                    <div class="container-fluid">
                        <table style="width: 100%; font-family: 'Arial Narrow', Arial, sans-serif; font-size: 0.69em;" class="mt-1 mb-1">
                            <tr>
                                <td style="width: 30%;">
                                    <span class="pt-1 pb-1 mb-1">KEHADIRAN <br> 4/19</span>
                                    <div class="progress progress-bar-primary" style="height: 2em;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="37" aria-valuemin="37" aria-valuemax="100" style="width: 37%;">
                                            37%
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 30%;">
                                    <span class="pt-1 pb-1 mb-1">CAPAIAN MENIT <br> 285/856</span>
                                    <div class="progress progress-bar-success" style="height: 2em;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="23" aria-valuemin="23" aria-valuemax="100" style="width: 23%;">
                                            23%
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 30%;">
                                    <span class="pt-1 pb-1 mb-1">TANPA KETERANGAN <br> 295.3/8550</span>
                                    <div class="progress progress-bar-danger" style="height: 2em;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="89" aria-valuemin="89" aria-valuemax="100" style="width: 89%;">
                                            89%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </section>
            <section class="text-center mt-2">
                <h6 class="fs-6">REKAPITULASI KEHADIRAN</h6>
                <h6 class="fs-6">BULAN BERJALAN</h6>
                <div class="card">
                    <div class="card-body" style="font-family: 'Arial Narrow', Arial, sans-serif;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 25%;" class="text-success">MASUK</td>
                                <td style="width: 25%;" class="text-warning">CUTI</td>
                                <td style="width: 25%;" class="text-danger">ALPA</td>
                                <td style="width: 25%;" class="text-primary">DINAS</td>
                            </tr>
                            <tr>
                                <td class="text-success">5</td>
                                <td class="text-warning">0</td>
                                <td class="text-danger">0</td>
                                <td class="text-primary">0</td>
                            </tr>
                            <tr>
                                <td class="text-success">HARI</td>
                                <td class="text-warning">HARI</td>
                                <td class="text-danger">HARI</td>
                                <td class="text-primary">HARI</td>
                            </tr>
                        </table>
                        <hr>
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 25%;">ALPA</td>
                                <td style="width: 25%;">TERLAMBAT</td>
                                <td style="width: 25%;">TAP</td>
                                <td style="width: 25%;">TOTAL TK</td>
                            </tr>
                            <tr>
                                <td class="text-danger">0</td>
                                <td class="text-danger">0</td>
                                <td class="text-danger">0</td>
                                <td class="text-danger">0</td>
                            </tr>
                            <tr>
                                <td>JAM</td>
                                <td>MENIT</td>
                                <td>MENIT</td>
                                <td>MENIT</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </section> -->
        </div>
    </div>
</div>
<!-- END: Content-->

<?php $this->load->view('templates/footer'); ?>