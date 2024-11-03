<?php 
session_start();  
include 'koneksi.php';  

if (isset($_POST['simpan'])) { 
    // Ambil data dari form 
    $id_karyawan = $_POST['id_karyawan'];     
    $username = $_POST['username'];     
    $password = md5($_POST['password']);     
    $nama = $_POST['nama'];     
    $tmp_tgl_lahir = $_POST['tmp_tgl_lahir'];     
    $jenkel = $_POST['jenkel'];     
    $agama = $_POST['agama'];     
    $alamat = $_POST['alamat'];     
    $no_tel = $_POST['no_tel'];     
    $jabatan = $_POST['jabatan'];      

    // Cek apakah ID Karyawan sudah ada     
    $sql = "SELECT * FROM tb_karyawan WHERE id_karyawan = '$id_karyawan'";     
    $tambah = mysqli_query($koneksi, $sql);      

    if (mysqli_fetch_row($tambah)) {         
        echo "<script>alert('Data dengan ID = ".$id_karyawan." sudah ada');</script>";         
        echo "<script>window.location.href = 'datakaryawan.php';</script>";     
    } else {         
        // Query insert data tanpa kolom foto         
        $query = "INSERT INTO tb_karyawan (id_karyawan, username, password, nama, tmp_tgl_lahir, jenkel, agama, alamat, no_tel, jabatan) 
                  VALUES ('$id_karyawan', '$username', '$password', '$nama', '$tmp_tgl_lahir', '$jenkel', '$agama', '$alamat', '$no_tel', '$jabatan')";                          

        if(mysqli_query($koneksi, $query)) {             
            echo "<script>alert('Data berhasil disimpan!');</script>";             
            echo "<script>window.location.href = 'datakaryawan.php';</script>";         
        } else {             
            echo "<script>alert('Gagal menyimpan data: " . mysqli_error($koneksi) . "');</script>";         
        }     
    } 
} 
?>
