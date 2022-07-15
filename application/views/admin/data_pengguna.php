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
                        <h4 class="card-title">DATA PENGGUNA</h4>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-success dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                                Option
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#add_user"><i data-feather='user'></i> Tambah Pengguna</a>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Start-->
                    <div class="modal fade text-start" id="add_user" tabindex="-1" aria-labelledby="myModalLabel4" data-bs-backdrop="false" aria-hidden="true" style="background: rgba(0,0,0,0.5);">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel4">Tambah Pengguna</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="<?php echo base_url('admin/pegawai/add_user'); ?>" class="" enctype="multipart/form-data">
                                        <label for="name">Nama Lengkap</label>
                                        <input id="name" name="name" type="text" class="form-control mb-1" placeholder="Nama Lengkap" required>
                                        <label for="email">Email</label>
                                        <input id="email" name="email" type="text" class="form-control mb-1" placeholder="Email" required>
                                        <label for="nohp">No. WhatsApp</label>
                                        <input id="nohp" name="nohp" type="text" class="form-control mb-1" placeholder="Nomor Whatsapp" required>
                                        <label for="sekolah">Sekolah</label>
                                        <select name="sekolah" class="form-control mb-1" required>
                                            <option value="">Pilih Sekolah</option>
                                            <?php foreach ($sekolah as $skl) : ?>
                                                <option value="<?php echo $skl->nama; ?>"><?php echo $skl->nama; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn btn-success float-end">Simpan</button>
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
                                                <!-- <th>Foto</th> -->
                                                <th>Email</th>
                                                <th>Jabatan</th>
                                                <th>Status</th>
                                                <th>Role</th>
                                                <th>Sekolah</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data_pengguna as $pg) : ?>
                                                <tr>
                                                    <td><?php echo $pg->name; ?></td>
                                                    <!-- <td><img src="<?php echo base_url('assets/images/profile/') . $pg->gambar; ?>" alt="FotoProfile" class="avatar" width="80px"></td> -->
                                                    <td><?php echo $pg->email; ?></td>
                                                    <td><?php echo $pg->jabatan; ?></td>
                                                    <td>
                                                        <?php if ($pg->status == 1) { ?>
                                                            Aktif
                                                        <?php } else { ?>
                                                            Tidak Aktif
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($pg->role_id == 1) {
                                                            echo "Admin";
                                                        } elseif ($pg->role_id == 2) {
                                                            echo "Pegawai";
                                                        } else {
                                                            echo "Kepala Sekolah";
                                                        } ?>
                                                    </td>
                                                    <td><?php echo $pg->sekolah; ?></td>
                                                    <td>
                                                        <form method="post" action="<?php echo base_url('admin/pegawai/status'); ?>" class="" enctype="multipart/form-data">
                                                            <input type="hidden" name="id" value="<?php echo $pg->id; ?>">
                                                            <button type="submit" class="btn btn-sm btn-success" style="width: 80%; margin: 2px;">Status Pengguna</button>
                                                        </form>
                                                        <form method="post" action="<?php echo base_url('admin/pegawai/reset_password'); ?>" class="" enctype="multipart/form-data">
                                                            <input type="hidden" name="id" value="<?php echo $pg->id; ?>">
                                                            <button type="submit" class="btn btn-sm btn-success" style="width: 80%; margin: 2px;">Reset Password</button>
                                                        </form>
                                                        <form method="post" action="<?php echo base_url('admin/pegawai/reset_skema'); ?>" class="" enctype="multipart/form-data">
                                                            <input type="hidden" name="email" value="<?php echo $pg->email; ?>">
                                                            <button type="submit" class="btn btn-sm btn-success" style="width: 80%; margin: 2px;">Reset Skema</button>
                                                        </form>
                                                        <?php
                                                        $whatsapp = "https://api.whatsapp.com/send?phone=";
                                                        $link = base_url() . 'authentication/verify_account?token=' . $pg->token . '%20%20Dengan%20%20*Username*%20=%20' . $pg->email . ',%20*Password*%20=%20' . $pg->password_default;
                                                        $text = $link;
                                                        ?>
                                                        <a href="<?php echo $whatsapp . $pg->nohp . '&text=' . $text; ?>" type="button" class="btn btn-sm btn-success" target="_blank" style="width: 80%; margin: 2px;">Kirim Verifikasi</a>
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