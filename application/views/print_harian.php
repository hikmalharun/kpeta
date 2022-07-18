<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title><?php echo $title . '-' . $tanggal; ?></title>
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/images/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/favicon.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        table {
            border: 1px solid #000;
            width: 100%;
        }

        tr {
            border: 1px solid #000;
        }

        th {
            border: 1px solid #000;
            text-align: center;
        }

        td {
            border: 1px solid #000;
        }

        @media print {
            .pagebreak {
                clear: both;
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    <div class="text-center">
        <h3>Data Absen <br><?php echo $tanggal; ?></h3>
    </div>
    <strong>ABSEN MASUK</strong>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Jam</th>
                <th>Jarak</th>
                <th>Alamat</th>
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
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagebreak"> </div>
    <strong>ABSEN PULANG</strong>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Jam</th>
                <th>Jarak</th>
                <th>Alamat</th>
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
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>