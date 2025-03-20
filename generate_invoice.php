<?php
require_once('tcpdf/tcpdf.php');

// Create a new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Company Name');
$pdf->SetTitle('Invoice');
$pdf->SetSubject('Invoice PDF');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'INVOICE', "Your Company Name\nwww.yourcompany.com");

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Define HTML content with style
$html = <<<EOD
<style>
    h1 {
        color: navy;
        font-family: times;
        font-size: 24pt;
        text-align: center;
    }
    p.first {
        color: #003300;
        font-family: helvetica;
        font-size: 12pt;
    }
    p.first span {
        color: #006600;
        font-style: italic;
    }
    p#second {
        color: rgb(00,63,127);
        font-family: times;
        font-size: 12pt;
        text-align: justify;
    }
    p#second > span {
        background-color: #FFFFAA;
    }
    table.first {
        color: #003300;
        font-family: helvetica;
        font-size: 8pt;
        border-left: 3px solid red;
        border-right: 3px solid #FF00FF;
        border-top: 3px solid green;
        border-bottom: 3px solid blue;
        background-color: #ccffcc;
    }
    td {
        border: 2px solid blue;
        background-color: #ffffee;
    }
    td.second {
        border: 2px dashed green;
    }
    div.test {
        color: #CC0000;
        background-color: #FFFF66;
        font-family: helvetica;
        font-size: 10pt;
        border-style: solid solid solid solid;
        border-width: 2px 2px 2px 2px;
        border-color: green #FF00FF blue red;
        text-align: center;
    }
</style>

<h1>Invoice</h1>
<p class="first">This is a sample invoice generated using TCPDF.</p>
<p id="second">This paragraph is styled differently.</p>
<table class="first" cellpadding="4" cellspacing="6">
    <tr>
        <td>Item</td>
        <td>Quantity</td>
        <td>Price</td>
    </tr>
    <tr>
        <td>Product 1</td>
        <td>2</td>
        <td>$10.00</td>
    </tr>
    <tr>
        <td>Product 2</td>
        <td>1</td>
        <td>$20.00</td>
    </tr>
</table>
<div class="test">Total: $40.00</div>
EOD;

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('invoice.pdf', 'I');
?>
