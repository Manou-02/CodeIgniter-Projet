<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
?>
<page>
	<page_footer>
		<hr />
		<h1 style="font-size:13px;">Fait à .................................................... le <?= date('d/m/y')?></h1>
	</page_footer>
</page>
<style type="text/css">
    .table td,
  .table th {
    background-color: #fff ;
    text-align: center;
  }
  .table-bordered th,
  .table-bordered td {
    border: 1px solid #ddd ;
  }
}
</style>
<table style="width: 100%;border-collapse: collapse;" class="table table-bordered">
	<tr>
		<td style="text-align: center;font-weight: bold;margin-left: 35px" colspan="4">LISTE DES PRODUITS ACTUEL</td>
	</tr>
	<tr style="border:1px solid black">
		<td style="width: 25%;">Code du Produit</td>
		<td style="width: 25%;">Designation</td>
		<td style="width: 25%;">Prix unitaire (Ar)</td>
		<td style="width: 25%;">Stock (Kg)</td>
	</tr>
<?php
$row = 1;
$bg = "";
foreach($produit AS $value){
if($row % 2 == 0)
	$bg = 221021;
else
	$bg = 112101;
?>

<tr>
	<td>P<?=$value->codePro?></td>
	<td><?=$value->Design?></td>
	<td><?=$value->PU?></td>
	<td><?=$value->stock?></td>
</tr>
<?php
$row++;
}
?>
</table>

<?php

$content = ob_get_clean();

try{
	$pdf = new HTML2PDF('P' , 'A4' , 'fr');
	$pdf->pdf->setDisplayMode('fullpage');
	$pdf->writeHTML($content);
	$pdf->Output('produit.pdf' , 'D');
}
catch(HTML2PDF_exception $e){
	die($e);
}
?>
