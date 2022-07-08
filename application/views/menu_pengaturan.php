<div class="card-header border-bottom">
    <h4 class="card-title">PENGATURAN</h4>
    <div class="btn-group">
        <button type="button" class="btn btn-outline-success dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
            Option
        </button>
        <?php
        if ($user['role_id'] == 1) {
            $ubah_skema = base_url('admin/pengaturan/skema');
            $set_lokasi = base_url('admin/pengaturan/set_lokasi');
            $set_jam = base_url('admin/pengaturan/set_jam');
            $set_kalender = base_url('admin/pengaturan/set_kalender');
        } else {
            $ubah_skema = base_url('pengaturan/skema');
            $set_lokasi = base_url('pengaturan/set_lokasi');
            $set_jam = base_url('pengaturan/set_jam');
            $set_kalender = base_url('pengaturan/set_kalender');
        }
        ?>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="<?php echo $ubah_skema; ?>"><i class="me-50" data-feather='refresh-cw'></i> Ubah Skema</a>
            <?php if ($user['role_id'] == 2) { ?>
            <?php } else { ?>
                <a class="dropdown-item" href="<?php echo $set_lokasi; ?>"><i class="me-50" data-feather='refresh-cw'></i> Set Lokasi</a>
                <a class="dropdown-item" href="<?php echo $set_jam; ?>"><i class="me-50" data-feather='refresh-cw'></i> Set Jam</a>
                <a class="dropdown-item" href="<?php echo $set_kalender; ?>"><i class="me-50" data-feather='refresh-cw'></i> Set Kalender</a>
            <?php } ?>
        </div>
    </div>
</div>