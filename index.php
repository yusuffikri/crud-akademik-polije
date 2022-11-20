<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "akademik_polije";
$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) { // Cek Koneksi
    die("Tidak bisa terkoneksi dengan database");
}

$nim     = "";
$nama    = "";
$alamat  = "";
$jurusan = "";
$error   = "";
$sukses  = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id         = $_GET['id'];
    $sql1       = "delete from mahasiswa where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error  = "Gagal melakukan delete data";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "select * from mahasiswa where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $id      = $r1['id'];
    $nim     = $r1['nim'];
    $nama    = $r1['nama'];
    $alamat  = $r1['alamat'];
    $jurusan = $r1['jurusan'];

    if ($nim == '') {
        $error = "Data tidak dapat ditemukan";
    }
}

if (isset($_POST['simpan'])) { //Create
    $nim        = $_POST['nim'];
    $nama       = $_POST['nama'];
    $alamat     = $_POST['alamat'];
    $jurusan    = $_POST['jurusan'];

    if ($nim && $nama && $alamat && $jurusan) {
        if ($op == 'edit') { //Untuk update
            $sql1       = "update mahasiswa set nim = '$nim',nama='$nama',alamat = '$alamat',jurusan='$jurusan' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //Untuk insert
            $sql1   = "insert into mahasiswa(nim,nama,alamat,jurusan) values ('$nim','$nama','$alamat','$jurusan')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa Polije</title>

    <!-- CSS Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <!-- CSS Sendiri -->
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="mx-auto">

        <!-- Input Data -->
        <div class="card">
            <div class="card-header text-white bg-primary">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jurusan" id="jurusan">
                                <option value="">- Pilih Jurusan -</option>
                                <option value="Teknik" <?php if ($jurusan == "teknik") echo "selected" ?>>Jurusan Teknik</option>
                                <option value="Teknologi Informasi" <?php if ($jurusan == "teknologiInformasi") echo "selected" ?>> Jurusan Teknologi Informasi</option>
                                <option value="Teknologi Pertanian" <?php if ($jurusan == "teknologiPertanian") echo "selected" ?>>Jurusan Teknologi Pertanian</option>
                                <option value="Peternakan" <?php if ($jurusan == "peternakan") echo "selected" ?>>Jurusan Peternakan</option>
                                <option value="Kesehatan" <?php if ($jurusan == "kesehatan") echo "selected" ?>>Jurusan Kesehatan</option>
                                <option value="Bahasa dan Kepariwisataan" <?php if ($jurusan == "bkp") echo "selected" ?>>Jurusan Bahasa dan Kepariwisataan</option>
                                <option value="Manajemen Agroindustri" <?php if ($jurusan == "mna") echo "selected" ?>>Jurusan Manajemen Agroindustri</option>
                                <option value="Perkebunan" <?php if ($jurusan == "perkebunan") echo "selected" ?>>Jurusan Perkebunan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>

        <!-- Output Data -->
        <div class="card">
            <div class="card-header text-white bg-primary">
                Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col">Action</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2   = "select * from mahasiswa order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id      = $r2['id'];
                            $nim     = $r2['nim'];
                            $nama    = $r2['nama'];
                            $alamat  = $r2['alamat'];
                            $jurusan = $r2['jurusan'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nim ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $alamat ?></td>
                                <td scope="row"><?php echo $jurusan ?></td>
                                <td scope="row">
                                    <button type="button" class="btn btn-warning">Edit</button>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Anda yakin akan menghapus data ini?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>


                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</body>

</html>