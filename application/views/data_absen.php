<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title><?php echo $title; ?></title>
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/images/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/favicon.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <section>
        <div class="container">
            <div class="card mt-5">
                <h1 class="m-2"><?php echo $tanggal; ?></h1>
                <div class="card-body">
                    <table class="table table-lg">
                        <thead>
                            <tr>
                                <th colspan="6"><strong>ABSEN MASUK</strong></th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Jam</th>
                                <th>Jarak</th>
                                <th>Alamat</th>
                                <th>Gambar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            ?>
                            <?php foreach ($rekap_all_masuk as $masuk) : ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $masuk['nama']; ?></td>
                                    <td><?php echo $masuk['jam_absen']; ?></td>
                                    <td><?php echo round($masuk['jarak']); ?> Meter</td>
                                    <td><?php echo $masuk['address']; ?></td>
                                    <td><img src="<?php echo base_url('uploads/') . $masuk['gambar']; ?>" alt="Gambar" width="85px" height="100px"></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <table class="table table-lg">
                        <thead>
                            <tr>
                                <th colspan="6"><strong>ABSEN PULANG</strong></th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Jam</th>
                                <th>Jarak</th>
                                <th>Alamat</th>
                                <th>Gambar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            ?>
                            <?php foreach ($rekap_all_pulang as $pulang) : ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $pulang['nama']; ?></td>
                                    <td><?php echo $pulang['jam_absen']; ?></td>
                                    <td><?php echo round($pulang['jarak']); ?> Meter</td>
                                    <td><?php echo $pulang['address']; ?></td>
                                    <td><img src="<?php echo base_url('uploads/') . $pulang['gambar']; ?>" alt="Gambar" width="85px" height="100px"></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>