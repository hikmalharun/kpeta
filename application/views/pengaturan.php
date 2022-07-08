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
                                <div class="col-lg-12">
                                    <img src="<?php echo base_url('assets/images/bg-profile.jpg'); ?>" alt="Gambar" width="100%">
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