<?php
	include 'C:\wamp\www\smses\lib\ProjectLibrary.php';
	
	require_once 'C:/wamp/www/smses/print/tcpdf/config/lang/eng.php';
	require_once 'C:/wamp/www/smses/print/tcpdf/tcpdf.php';
	
	session_start();

	$con = new DatabaseConnection();
	date_default_timezone_set ("Asia/Manila");
	
	class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		$this->SetY(4);
		$this->SetFont('courier', 'B', 14);
		// Title
		$title = "CES Electrical Supplies Inc.";
		$this->writeHTML($title, 'C', true, 0, true, 0);
		$this->SetFont('courier','B', 8);
		$address = <<<EOD
				Barbs Bldg. Echavez Ong Compound, Quezon Avenue Ext.<br />
				Palao, Iligan City 9200 Philippines <br />
				Tel. No. (063) 905-899-88453 Website: http://www.cessupplies.ph

EOD;
		$this->writeHTMLCell($w=0, $h=0, $x='', $y='', $address, $border=0, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);
	}
	
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-10);
		$this->SetFont('courier','B', 8);
		
		$title = "Receipt Generated: ".date("Y-m-d h:m:s"). " | 
				  Employee: ".$_SESSION['user']->getName()." | 
				  Thank You for choosing CES Inc.
		
		";
		$this->writeHTML($title, 'L', true, 0, true, 0);
	}
	
}
	
if (isset($_GET['receipt'])){
	
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->setPageOrientation('L', $autopagebreak='', $bottommargin=2);
	$pdf->setPrintHeader(true); $pdf->setPrintFooter(true);
	$pdf->SetFont('courier','B', 10);
	$pdf->AddPage('L', 'HLTR'); $pdf->SetY(18);
	
	$txt = <<<EOD

-------------------------------------------------------------------------------------------
O F F I C I A L    R E C I E P T
-------------------------------------------------------------------------------------------
EOD;
$pdf->Write($h=0, $txt, $link='', $fill=0, $align='C', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);

$receipt = $_SESSION['printqueue'];
$date = $receipt->getDate();

$text = <<<EOD
	Date: $date
EOD;
$pdf->writeHTMLCell($w=0, $h=0, $x=10, $y=36, $text, $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);

$OR = $receipt->getNumber();
$text = <<<EOD
	OR Number: $OR
EOD;
$pdf->writeHTMLCell($w=0, $h=0, $x=150, $y=36, $text, $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=10, $y=45, "ITEM CODE", $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=40, $y=45, "ITEM NAME", $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=100, $y=45, "ITEM PRICE", $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=150, $y=45, "QUANTITY", $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=190, $y=45, "AMOUNT", $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);

$text = <<<EOD
-------------------------------------------------------------------------------------------
EOD;
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y=49, $text, $border=0, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);

$items = $receipt->getItemList();
$list_y = 53; $total = 0;
for ($i=0; $i<sizeof($items)+1; $i++){
	if (empty($items[$i])){
	
	}
	else {
		//get item...
		$item = $items[$i]->getItemNumber();
		//get item code, name, price
		$itemcode = $item->getID(); $itemname = $item->getName(); $itemprice = $item->getPrice();
		//get quantity...
		$quantity = $items[$i]->getQuantity();
		$amount = $quantity * $itemprice;
		$total = $total + $amount;
	
		$pdf->writeHTMLCell($w=0, $h=0, $x=10, $y=$list_y, $itemcode, $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);
		$pdf->writeHTMLCell($w=0, $h=0, $x=40, $y=$list_y, $itemname, $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);
		$pdf->writeHTMLCell($w=0, $h=0, $x=100, $y=$list_y, "Php. " . number_format($itemprice, 2), $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);
		$pdf->writeHTMLCell($w=0, $h=0, $x=150, $y=$list_y, $quantity, $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);
		$pdf->writeHTMLCell($w=55, $h=0, $x=150, $y=$list_y,  "Php. " . number_format($amount, 2), $border=0, $ln=1, $fill=0, $reseth=true, $align='R', $autopadding=true);

		$list_y = $list_y + 5;
	}
}

$pdf->SetY(-18);
$text = <<<EOD
AMOUNT TOTAL
------------------------------------------------------------------------------------------- 
EOD;
$pdf->writeHTMLCell($w=0, $h=4, $x='', $y=110, $text, $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);
$pdf->SetFont('courier', 'B', 14);
$pdf->writeHTMLCell($w=0, $h=4, $x=155, $y=110, "PHP. ". number_format($total, 2), $border=0, $ln=1, $fill=0, $reseth=true, $align='R', $autopadding=true);

$pdf->SetFont('courier', 'B', 11);
$receive = $receipt->getPaid();
$pdf->writeHTMLCell($w=0, $h=4, $x=105, $y=117, "Recieved Amount: Php. ". number_format($receive, 2), $border=0, $ln=1, $fill=0, $reseth=true, $align='R', $autopadding=true);
$change = $receive - $total;
$pdf->writeHTMLCell($w=0, $h=4, $x=105, $y=121, "Change: Php. ". number_format($change, 2), $border=0, $ln=1, $fill=0, $reseth=true, $align='R', $autopadding=true);

	$pdf->Output('reciept.pdf', 'I');
}

?>