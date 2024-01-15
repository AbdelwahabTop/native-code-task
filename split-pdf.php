<?php

require_once('uploadPdf.php');
require_once('PDFMerger/PDFMerger.php');

use PDFMerger\PDFMerger;

processForm();


// Core function
function processForm()
{
    try {
        $from = $_POST['from'];
        $to = $_POST['to'];
        $pdfName = $_FILES['pdf']['name'];

        if (validate($from, $to, $pdfName)) {
            splitPDF($from, $to, $pdfName);
        }
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Validate form
function validate($from, $to, $pdfName)
{
    if ($from > $to) {
        echo "From page number must be less than to page number";
        return false;
    }

    if ($from < 1 || $to < 1) {
        echo "Page number must be greater than 0";
        return false;
    }

    if ($from == "" || $to == "") {
        echo "From page number and to page number must be filled";
        return false;
    }

    if ($pdfName == "") {
        echo "PDF file must be uploaded";
        return false;
    }

    return true;
}

// Split PDF file and show it
function splitPDF($from, $to, $pdfName)
{
    if (!validate($from, $to, $pdfName)) {
        return;
    }
    $pdf = new PDFMerger();
    $pdf->addPDF('uploads/' . $pdfName, $from . '-' . $to);
    $split_filename = basename($pdfName, '.pdf') . '_' . $from . '_to_' . $to . '.pdf';
    $splitFilePath = __DIR__ . '/newPDF/' . $split_filename;
    $pdf->merge('file',  $splitFilePath);

    echo "<div style='display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; height: 100vh;'>";

    echo "<p style='font-weight: bold; font-size: 20px; margin-bottom: 20px;'>File splitted from page number: " . $from . " to page number: " . $to . " successfully</p>";

    echo "<div style='width: 80%; height: 500px; margin-bottom: 20px;'>";
    echo "<iframe src='newPDF/" . $split_filename . "' style='width: 100%; height: 100%; border: none;'></iframe>";
    echo "</div>";

    echo "<a href='newPDF/" . $split_filename . "' style='display: inline-block; background-color: #4caf50; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 4px;'>Download splitted file</a>";

    echo "</div>";
}
