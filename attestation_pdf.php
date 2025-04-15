<?php
require_once 'connection.php';
require_once 'libs/fpdf.php';

$db = new Database();
$conn = $db->connect();

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID manquant.");
}

// Récupérer infos stagiaire et date
$stmt = $conn->prepare("
    SELECT s.NOM_STG, s.PRN_STG, p.DATE_POSER
    FROM poser p
    JOIN stagiaire s ON s.ID_STG = p.ID_STG
    WHERE p.ID_MSG = ?
");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Demande non trouvée.");
}

// Génération du PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(0, 10, utf8_decode("Attestation de Stage"), 0, 1, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);

$text = "Nous attestons que l'étudiant(e) {$data['NOM_STG']} {$data['PRN_STG']} a bien effectué un stage au sein de notre établissement.";
$pdf->MultiCell(0, 10, utf8_decode($text));

$pdf->Ln(10);
$pdf->Cell(0, 10, "Date de la demande : " . $data['DATE_POSER'], 0, 1);

$pdf->Ln(20);
$pdf->Cell(0, 10, "Signature", 0, 1, 'R');

$pdf->Output('I', 'attestation.pdf');
