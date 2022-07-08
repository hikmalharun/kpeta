<?php $this->load->view('templates/header') ?>
<?php $this->load->view('templates/sidebar') ?>
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row"></div>
        <?php echo $this->session->flashdata('pengaturan'); ?>
        <section>
            <div class="content-body">
                <div class="card">
                    <?php $this->load->view('menu_pengaturan'); ?>
                    <div class="card-body">
                        <div class="container-fluid mt-2">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="skema">Skema Absen <span class="text-danger">*</span></label>
                                    <table class="mb-1" width="100%">
                                        <tr>
                                            <td width="95%">
                                                <input type="text" class="form-control" placeholder="Skema Absen" value="<?php echo "Absen di " . $skema['lokasi']; ?>" required readonly>
                                            </td>
                                            <td>
                                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#skema">Pilih</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    <label for="jam_kerja">Jam Kerja <span class="text-danger">*</span></label>
                                    <select name="jam_kerja" id="jam_kerja" class="form-control mb-1" required>
                                        <option value="">Pilih</option>
                                        <?php foreach ($jam as $jm) : ?>
                                            <option value="<?php echo $jm['id'] ?>"><?php echo $jm['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
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
<!-- Modal Skema Start-->
<div class="modal fade text-start" id="skema" tabindex="-1" aria-labelledby="myModalLabel4" data-bs-backdrop="false" aria-hidden="true" style="background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Pilih Skema Absen</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('admin/pengaturan/save_lokasi'); ?>" class="" enctype="multipart/form-data">
                    <select name="skema" id="skema" class="form-control mb-1" required>
                        <option value="">Pilih</option>
                        <?php foreach ($lokasi as $lk) : ?>
                            <option value="<?php echo $lk['id']; ?>"><?php echo $lk['nama']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="email" value="<?php echo $user['email']; ?>">
                    <button type="submit" class="btn btn-success float-end">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Skema End -->