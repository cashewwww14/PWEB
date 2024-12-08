<?php
require('fpdf.php');

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(0, 10, 'DAFTAR SISWA TERDAFTAR', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Kursus Bahasa', 0, 1, 'C');
$pdf->Ln(10);

$header = ['ID', 'Nama', 'Alamat', 'Tgl Lahir', 'JK', 'No Telp', 'Email'];
$colWidths = [15, 40, 50, 30, 15, 30, 40];

$pdf->SetFont('Arial', 'B', 10);
foreach ($header as $i => $col) {
    $pdf->Cell($colWidths[$i], 7, $col, 1, 0, 'C');
}
$pdf->Ln();

include 'config.php';
$query = "SELECT * FROM siswa";  
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $pdf->SetFont('Arial', '', 10);
    
    $namaLength = strlen($row['nama']);
    if ($namaLength > 25) {
        $colWidths[1] = max(50, $namaLength * 1.5);
    }

    $alamatLength = strlen($row['alamat']);
    if ($alamatLength > 50) {
        $colWidths[2] = max(60, $alamatLength * 1.5);
    }
    
    $pdf->Cell($colWidths[0], 6, $row['id'], 1, 0, 'C');
    $pdf->Cell($colWidths[1], 6, $row['nama'], 1, 0, 'L');
    $pdf->Cell($colWidths[2], 6, $row['alamat'], 1, 0, 'L');
    $pdf->Cell($colWidths[3], 6, $row['tanggal_lahir'], 1, 0, 'C');
    $pdf->Cell($colWidths[4], 6, $row['jenis_kelamin'], 1, 0, 'C');
    $pdf->Cell($colWidths[5], 6, $row['no_telp'], 1, 0, 'C');
    $pdf->Cell($colWidths[6], 6, $row['email'], 1, 0, 'L');
    $pdf->Ln();
}

$pdf->Output();
?>
