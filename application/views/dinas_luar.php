<?php $this->load->view('templates/header') ?>
<?php $this->load->view('templates/sidebar') ?>
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row"></div>
        <?php echo $this->session->flashdata('pesan_token'); ?>
        <section>
            <div class="content-body">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">DINAS LUAR</h4>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-success dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                                Option
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#tambah_sekolah"><i data-feather='upload'></i> Ajukan Dinas Luar</a>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Start-->
                    <div class="modal fade text-start" id="tambah_sekolah" tabindex="-1" aria-labelledby="myModalLabel4" data-bs-backdrop="false" aria-hidden="true" style="background: rgba(0,0,0,0.5);">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel4">Dinas Luar</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="<?php echo base_url('admin/kehadiran/dinas_luar'); ?>" class="" enctype="multipart/form-data">
                                        <label for="tipe">Tipe Dinas Luar (DL)</label>
                                        <select name="tipe" id="tipe" class="form-control mb-1" required>
                                            <option value="">Pilih</option>
                                            <option value="1">Dinas Luar Full</option>
                                            <option value="2">Dinas Luar, Masuk Kerja</option>
                                            <option value="3">Masuk Kerja, Dinas Luar</option>
                                            <option value="4">Dinas Luar Dihari Libur</option>
                                            <option value="5">WFH (Work From Home)</option>
                                        </select>
                                        <label for="lokasi">Lokasi</label>
                                        <input type="text" id="lokasi" name="lokasi" class="form-control mb-1" placeholder="Copy Paste Titik Koordinat Dari Google Map" required>

                                        <div class="mb-1" id="map" style="width: 100%;height: 320px;"></div>

                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <label for="t_mulai">Tanggal Mulai</label>
                                                    <input type="date" name="t_mulai" id="t_mulai" class="form-control mb-1" required>
                                                </td>
                                                <td>
                                                    <label for="t_akhir">Tanggal Akhir</label>
                                                    <input type="date" name="t_akhir" id="t_akhir" class="form-control mb-1" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="j_mulai">Jam Mulai</label>
                                                    <input type="time" name="j_mulai" id="j_mulai" class="form-control mb-1" required>
                                                </td>
                                                <td>
                                                    <label for="j_akhir">Jam Akhir</label>
                                                    <input type="time" name="j_akhir" id="j_akhir" class="form-control mb-1" required>
                                                </td>
                                            </tr>
                                        </table>
                                        <label for="ket">Keterangan</label>
                                        <textarea type="text" name="keterangan" id="ket" class="form-control mb-1" aria-rowindex="5"></textarea>
                                        <button type="submit" name="submit" class="btn btn-success float-end">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal End -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-hover display nowrap mb-0" id="table">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Dasar</th>
                                                <th>Kegiatan</th>
                                                <th>Tempat</th>
                                                <th>Jam</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- END: Content-->
<?php $this->load->view('templates/footer') ?>

<script>
    var map = L.map('map').setView([-6.3738321, 107.9567161], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([-6.3738321, 107.9567161]).addTo(map)
        .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
        .openPopup();
</script>