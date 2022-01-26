<?php
include "header.php";
?>

<style>
    body{
        background-color: #4b4276;
    }
</style>

<nav class="navbar navbar-expand-lg" style="margin-top: 40px" >
    <h3>History Peminjaman Buku</h3>
</nav >
<table class="table table-bordered border-secondary">
    <thead style="background-color: #cccdcc" align="center">
        <th>NO</th><th>Tanggal Pinjam</th><th>Tanggal harus Kembali</th><th>Nama Buku</th><th>Status</th><th>Aksi</th>
    </thead>
    <tbody  align="center">
        <?php
            include "koneksi.php";
            $qry_histori=mysqli_query($conn,"select * from peminjaman_buku order by id_peminjaman_buku desc");
            $no=0;
            while($dt_histori=mysqli_fetch_array($qry_histori)){
            $no++;

            //menampilkan buku yang dipinjam
            $buku_dipinjam="<ol>";
            $qry_buku=mysqli_query($conn,"select * from detail_peminjaman_buku join buku on buku.id_buku = detail_peminjaman_buku.id_buku where id_peminjaman_buku = '".$dt_histori['id_peminjaman_buku']."'");
            while($dt_buku=mysqli_fetch_array($qry_buku)){
                $buku_dipinjam.="<li>".$dt_buku['nama_buku']."</li>";
            }
            $buku_dipinjam.="</ol>";

            //menampilkan status sudah kembali atau belum
            $qry_cek_kembali=mysqli_query($conn,"select * from pengembalian_buku where id_peminjaman_buku = '".$dt_histori['id_peminjaman_buku']."'");
            if(mysqli_num_rows($qry_cek_kembali)>0){
                $dt_kembali=mysqli_fetch_array($qry_cek_kembali);
                $denda="denda Rp. ".$dt_kembali['denda'];
                $status_kembali="<label class='alert alert-success'>Sudah kembali <br>".$denda."</label>";
                $button_kembali="";
            } else {
                $status_kembali="<label class='alert alert-danger'>Belum kembali</label>";
                $button_kembali="<a href='kembali.php?id=".$dt_histori['id_peminjaman_buku']."' class='btn btn-warning' onclick='return confirm(\"hello\")'>Kembalikan</a>";
            }
        ?>
        <tr>
            <td><?=$no?></td><td><?=$dt_histori['tanggal_pinjam']?></td><td><?=$dt_histori['tanggal_kembali']?></td><td><?=$buku_dipinjam?></td><td><?=$status_kembali?></td><td><?=$button_kembali?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>
<a href="home.php" class="btn btn-primary" type="submit" value="KEMBALI">Kembali</a>
<hr>