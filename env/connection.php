<?php
$koneksi = mysqli_connect("localhost", "skid5928_crm", "Indonesia12345", "skid5928_crm");
if (!$koneksi) {
    die("Gagal Koneksi") . mysqli_connect_error();
}
function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
