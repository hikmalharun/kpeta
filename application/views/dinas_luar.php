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
                                        <!-- <div class="mb-1" id="map" style="width: 100%;height: 320px;"></div> -->
                                        <!-- =========== LEAFLET =========== -->
                                        <div class="leaflet-map leaflet-container leaflet-fade-anim leaflet-grab leaflet-touch-drag mb-1" id="drag-map" tabindex="0" style="position: relative; outline: none;">
                                            <div class="leaflet-pane leaflet-map-pane" style="transform: translate3d(-686px, 0px, 0px);">
                                                <!-- <div class="leaflet-pane leaflet-tile-pane">
                                                    <div class="leaflet-layer " style="z-index: 1; opacity: 1;">
                                                        <div class="leaflet-tile-container leaflet-zoom-animated" style="z-index: 18; transform: translate3d(0px, 0px, 0px) scale(1);">
                                                            <img alt="" role="presentation" src="https://a.tile.osm.org/12/2076/1410.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(716px, 246px, 0px); opacity: 1;">
                                                            <img alt="" role="presentation" src="https://b.tile.osm.org/12/2075/1409.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(460px, -10px, 0px); opacity: 1;">
                                                            <img alt="" role="presentation" src="https://c.tile.osm.org/12/2076/1409.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(716px, -10px, 0px); opacity: 1;">
                                                            <img alt="" role="presentation" src="https://c.tile.osm.org/12/2075/1410.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(460px, 246px, 0px); opacity: 1;">
                                                            <img alt="" role="presentation" src="https://a.tile.osm.org/12/2074/1409.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(204px, -10px, 0px); opacity: 1;">
                                                            <img alt="" role="presentation" src="https://a.tile.osm.org/12/2077/1409.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(972px, -10px, 0px); opacity: 1;">
                                                            <img alt="" role="presentation" src="https://b.tile.osm.org/12/2074/1410.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(204px, 246px, 0px); opacity: 1;">
                                                            <img alt="" role="presentation" src="https://b.tile.osm.org/12/2077/1410.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(972px, 246px, 0px); opacity: 1;">
                                                            <img alt="" role="presentation" src="https://c.tile.osm.org/12/2073/1409.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(-52px, -10px, 0px); opacity: 1;">
                                                            <img alt="" role="presentation" src="https://b.tile.osm.org/12/2078/1409.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(1228px, -10px, 0px); opacity: 1;">
                                                            <img alt="" role="presentation" src="https://a.tile.osm.org/12/2073/1410.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(-52px, 246px, 0px); opacity: 1;">
                                                            <img alt="" role="presentation" src="https://c.tile.osm.org/12/2078/1410.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(1228px, 246px, 0px); opacity: 1;">
                                                        </div>
                                                        <div class="leaflet-tile-container leaflet-zoom-animated" style="z-index: 17; transform: translate3d(0px, 0px, 0px) scale(0.5);"></div>
                                                    </div>
                                                </div> -->
                                                <div class="leaflet-pane leaflet-shadow-pane">
                                                    <img src="<?php echo base_url(); ?>app-assets/vendors/css/maps/images/marker-shadow.png" class="leaflet-marker-shadow leaflet-zoom-animated" alt="" style="margin-left: -12px; margin-top: -41px; width: 41px; height: 41px; transform: translate3d(654px, 187px, 0px);">
                                                </div>
                                                <div class="leaflet-pane leaflet-overlay-pane"></div>
                                                <div class="leaflet-pane leaflet-marker-pane">
                                                    <img src="<?php echo base_url(); ?>app-assets/vendors/css/maps/images/marker-icon.png" class="leaflet-marker-icon leaflet-zoom-animated leaflet-interactive leaflet-marker-draggable" alt="" tabindex="0" style="margin-left: -12px; margin-top: -41px; width: 25px; height: 41px; transform: translate3d(654px, 187px, 0px); z-index: 200;">
                                                </div>
                                                <div class="leaflet-pane leaflet-tooltip-pane"></div>
                                                <div class="leaflet-pane leaflet-popup-pane"></div>
                                                <div class="leaflet-proxy leaflet-zoom-animated" style="transform: translate3d(531438px, 360914px, 0px) scale(2048);"></div>
                                            </div>
                                            <div class="leaflet-control-container">
                                                <div class="leaflet-top leaflet-left">
                                                    <div class="leaflet-control-zoom leaflet-bar leaflet-control">
                                                        <a class="leaflet-control-zoom-in" href="#" title="Zoom in" role="button" aria-label="Zoom in">+</a>
                                                        <a class="leaflet-control-zoom-out" href="#" title="Zoom out" role="button" aria-label="Zoom out">−</a>
                                                    </div>
                                                </div>
                                                <div class="leaflet-top leaflet-right"></div>
                                                <div class="leaflet-bottom leaflet-left"></div>
                                                <!-- <div class="leaflet-bottom leaflet-right">
                                                    <div class="leaflet-control-attribution leaflet-control">
                                                        <a href="https://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> | Map data © <a href="https://www.openstreetmap.org/">OpenStreetMap</a>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                        <!-- =========== LEAFLET =========== -->
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
<!-- 
<script>
    var map = L.map('map').setView([-6.3738321, 107.9567161], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([-6.3738321, 107.9567161]).addTo(map)
        .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
        .openPopup();
</script> -->