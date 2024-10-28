<?php
session_start(); 
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    // Ambil data dari form
    $id_karyawan = $_POST['id_karyawan'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash password dengan md5
    $nama = $_POST['nama'];
    $tmp_tgl_lahir = $_POST['tmp_tgl_lahir'];
    $jenkel = $_POST['jenkel'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];
    $no_tel = $_POST['no_tel'];
    $jabatan = $_POST['jabatan'];

    // Proses untuk gambar
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $fotobaru = date('dmYHis') . $foto; // Nama file unik berdasarkan waktu
    $path = "images/" . $fotobaru;

    // Cek apakah NIP sudah ada di database
    $sql = "SELECT * FROM tb_karyawan WHERE id_karyawan = '$id_karyawan'";
    $tambah = mysqli_query($koneksi, $sql);

    if (mysqli_fetch_row($tambah)) {
        // Jika data sudah ada, tampilkan pesan dan kembali ke halaman sebelumnya
        echo "<script>alert('Data dengan NIP = ".$id_karyawan." sudah ada');</script>";
        echo "<script>window.location.href = 'datakaryawan.php';</script>";
    } else {
        // Jika data belum ada, lanjutkan dengan penyimpanan
        if ($_FILES['foto']['error'] == UPLOAD_ERR_OK) { // Cek apakah ada error saat upload
            if (move_uploaded_file($tmp, $path)) { // Pindahkan file foto ke folder tujuan
                // Query untuk menambahkan data ke database
                $query = "INSERT INTO tb_karyawan (id_karyawan, username, password, nama, tmp_tgl_lahir, jenkel, agama, alamat, no_tel, jabatan, foto)
                          VALUES ('$id_karyawan', '$username', '$password', '$nama', '$tmp_tgl_lahir', '$jenkel', '$agama', '$alamat', '$no_tel', '$jabatan', '$fotobaru')";

                if (mysqli_query($koneksi, $query)) {
                    // Jika berhasil, arahkan kembali ke halaman data karyawan
                    header("Location: datakaryawan.php");
                } else {
                    // Jika gagal menyimpan, tampilkan pesan error
                    echo "Gagal menyimpan data: " . mysqli_error($koneksi);
                }
            } else {
                echo "Gagal mengupload gambar.";
            }
        } else {
            echo "Error upload: " . $_FILES['foto']['error'];
        }
    }
}
?>
