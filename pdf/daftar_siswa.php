<?php
require('fpdf.php');

// Koneksi ke database
include 'koneksi.php';

$pdf = new FPDF('L', 'mm', 'A5');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(0, 0, 128);
$pdf->Cell(190, 10, 'SEKOLAH MENENGAH KEJURUAN NEGERI 2 LANGSA', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(190, 7, 'DAFTAR SISWA KELAS IX JURUSAN REKAYASA PERANGKAT LUNAK', 0, 1, 'C');

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(30, 8, 'NIM', 1, 0, 'C', true);
$pdf->Cell(85, 8, 'Nama Mahasiswa', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'No HP', 1, 0, 'C', true);
$pdf->Cell(35, 8, 'Tanggal Lahir', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(240, 248, 255);
$pdf->SetTextColor(0, 0, 0);

$mahasiswa = mysqli_query($connect, "SELECT * FROM mahasiswa");
while ($row = mysqli_fetch_array($mahasiswa)) {
    $pdf->Cell(30, 8, $row['nim'], 1, 0, 'C', true);
    $pdf->Cell(85, 8, $row['nama_lengkap'], 1, 0, 'L', true);
    $pdf->Cell(40, 8, $row['no_hp'], 1, 0, 'C', true);
    $pdf->Cell(35, 8, date('d-m-Y', strtotime($row['tanggal_lahir'])), 1, 1, 'C', true);
}

$pdf->Output();
?>
