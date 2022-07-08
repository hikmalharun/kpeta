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
                        <h4 class="card-title">DATA SEKOLAH</h4>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-success dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                                Option
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#tambah_sekolah"><i data-feather='upload'></i> Tambah Sekolah</a>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Start-->
                    <div class="modal fade text-start" id="tambah_sekolah" tabindex="-1" aria-labelledby="myModalLabel4" data-bs-backdrop="false" aria-hidden="true" style="background: rgba(0,0,0,0.5);">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel4">Tambah Sekolah</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="<?php echo base_url('admin/pegawai/tambah_sekolah'); ?>" class="" enctype="multipart/form-data">
                                        <input type="text" class="form-control mb-1" name="nama" placeholder="Nama Sekolah" id="nama" required>
                                        <input type="text" class="form-control mb-1" name="npsn" placeholder="Nomor Pokok Sekolah Nasional (NPSN)" id="npsn" required>
                                        <button type="submit" name="submit" class="btn btn-primary float-end">Simpan</button>
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
                                                <th>Nama</th>
                                                <th>NPSN</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($sekolah as $s) : ?>
                                                <tr>
                                                    <td><?php echo $s->nama; ?></td>
                                                    <td><?php echo $s->npsn; ?></td>
                                                    <td><?php if ($s->status == 1) { ?>Aktif<?php } else { ?>Tidak Aktif<?php } ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_sekolah">Edit Status</button>
                                                        <!-- Modal Start-->
                                                        <div class="modal fade text-start" id="edit_sekolah" tabindex="-1" aria-labelledby="myModalLabel4" data-bs-backdrop="false" aria-hidden="true" style="background: rgba(0,0,0,0.5);">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="myModalLabel4">Aktifkan Sekolah</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" action="<?php echo base_url('admin/pegawai/edit_sekolah'); ?>" class="" enctype="multipart/form-data">
                                                                            <input type="hidden" class="form-control" name="id" value="<?php echo $s->id; ?>" required>
                                                                            Apa anda yakin ingin mengaktifkan sekolah ini? <br>
                                                                            <button type="submit" name="submit" class="btn btn-success float-end mt-3">Ya, simpan</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal End -->
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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