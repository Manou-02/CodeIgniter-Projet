<?php

ob_start();

?>
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

<page>

  <page_footer>
    <hr />
    <h1 style="font-size:13px;">Fait à .................................................... le <?= date('d/m/y')?></h1>
  </page_footer>
</page>
<table style="border-collapse:collapse;width:700px;margin:25px auto;" class="table table-bordered">
  <tr>
    <td colspan="3">LISTE DES FOURNISSEURS</td>
  </tr>
  <tr>
      <th style="width:25%;">Code du fournisseur</th>
      <th style="width: 35%">Nom</th>
      <th style="width: 40%">Adresse</th>
  </tr>
<?php
  foreach($fournisseur as $value) {
?>
    <tr>
      <td>F<?= $value->codeFrs ?></td>
      <td><?=$value->nomFrs ?></td>
      <td><?=$value->adresse ?></td>
    </tr>
<?php
  }
 ?>
</table>
<?php
$content = ob_get_clean();

try{
	$pdf = new HTML2PDF('P' , 'A4' , 'fr');
	$pdf->pdf->setDisplayMode('fullpage');
	$pdf->writeHTML($content);
	$pdf->Output('fournisseur.pdf');
}
catch(HTML2PDF_exception $e){
	die($e);
}

 ?>
