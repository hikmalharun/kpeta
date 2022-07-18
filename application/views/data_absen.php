<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title><?php echo $title . ' | ' . $tanggal; ?></title>
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/images/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/favicon.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script>
        function print(pdf) {
            // Create an IFrame.
            var iframe = document.createElement('iframe');
            // Hide the IFrame.  
            iframe.style.visibility = "hidden";
            // Define the source.  
            iframe.src = pdf;
            // Add the IFrame to the web page.
            document.body.appendChild(iframe);
            iframe.contentWindow.focus();
            iframe.contentWindow.print(); // Print.
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="float-end" style="padding: 10px 10px 10px 10px;">
            <button class="btn btn-sm btn-danger" onclick="print('<?php echo base_url('data_absen/print_harian') ?>')">Print PDF</button>
        </div>
        <br />
        <br />
        <br />
        <div class="text-center">
            <h3>Data Absen <br><?php echo $tanggal; ?></h3>
        </div>
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
                        <td><img src="<?php echo base_url('uploads/') . $masuk['gambar']; ?>" alt="Gambar" width="75px" height="100px"></td>
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
                        <td><img src="<?php echo base_url('uploads/') . $pulang['gambar']; ?>" alt="Gambar" width="75px" height="100px"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>