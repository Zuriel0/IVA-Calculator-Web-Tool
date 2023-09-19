<?php 

function convertToDecimal ($fraction)
    {   
        if($fraction!=0){
            $numbers=explode("/",$fraction);
            return round($numbers[0]/$numbers[1],20);
        }
        else{
            return 0;
        }
        
    }

$narticulos="";
$particulos="";
$gastosg="";
$gananpre="";
$percentv="";
$remtpr="";
$fgastosg="";
$fgananpre="";
$fpercentv="";

if ($_POST){
  
    $narticulos = (isset($_POST['narticulos']))?$_POST['narticulos'] : "";
    $particulos = (isset($_POST['particulos']))?$_POST['particulos'] : "";
    $gastosg = (isset($_POST['gastosg']))?$_POST['gastosg'] : "";
    $gananpre = (isset($_POST['gananpre']))?$_POST['gananpre'] : "";
    $percentv = (isset($_POST['percentv']))?$_POST['percentv'] : "";
    $remtpr = (isset($_POST['remtpr']))?$_POST['remtpr'] : "";
    $fgastosg = (isset($_POST['fgastosg']))?$_POST['fgastosg'] : "";
    $fgananpre = (isset($_POST['fgananpre']))?$_POST['fgananpre'] : "";
    $fpercentv = (isset($_POST['fpercentv']))?$_POST['fpercentv'] : "";

    //print_r($_POST);
    //echo ($gananpre + convertToDecimal($fgananpre))*0.01;
    $faltante=  ($percentv==0)?((100-convertToDecimal($fpercentv)*100)): 100-$percentv;
    $gastosCos= $gastosg + convertToDecimal($fgastosg) ;
    $valueProducts = $narticulos*$particulos;
    $valueProductsIva = $valueProducts*0.16;
    $valueProducPlusIva = $valueProducts + $valueProductsIva;
    $gastosCostos = $valueProducPlusIva * ($gastosCos*0.01) ;
    $totalValueGastos=$valueProducPlusIva+$gastosCostos;
    $totalValueGastosIva=$totalValueGastos*(($gananpre + convertToDecimal($fgananpre))*0.01);
    $totalValueGanan=$totalValueGastos+$totalValueGastosIva;
    $ivaAcreditado= $totalValueGanan*.16;
    $total=$totalValueGanan + $ivaAcreditado;

    //Ventas

    $ventas= $totalValueGanan * (($percentv+convertToDecimal($fpercentv) )*0.01); 
    $ivaVentas= $ventas*0.16;
    $totalVentas= $ventas+$ivaVentas;

    //Iva perdido
    $ivaLost=$ivaAcreditado-$ivaVentas;

    //Fisco
    $fisco=$ivaAcreditado-$valueProductsIva;

    //Faltante
    $off= $totalValueGanan * ($faltante*0.01);
    $offRe = $off*(($remtpr)*0.01);
    $totalFaltante=$off-$offRe;
    $ivaFaltan=$totalFaltante*0.16;
    $totalFaltanteIva=$totalFaltante+ $ivaFaltan;

    //Perdida de IVA

    $ivaPerdida=$ivaLost-$ivaFaltan;

}




?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingenieria Economica </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <form action="index.php" method="post">
        <br>
        <div class="row">
            <div class="col">
                <label for="exampleInputEmail1" class="form-label">Numero de articulos</label>
                <input type="text" class="form-control" name="narticulos" placeholder="Numero de articulos" aria-label="First name">
            </div>
            <div class="col">
                <label for="exampleInputPassword1" class="form-label">Precio de articulos</label>
                <input type="text" class="form-control" name="particulos" placeholder="Precio de articulos" aria-label="Last name">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="exampleInputEmail1" class="form-label">Gastos Generado</label>
                <input type="text" class="form-control" name="gastosg" placeholder="Entero de gastos" aria-label="First name">
            </div>
            <div class="col">
                <label for="exampleInputEmail1" class="form-label">Fraccion de Gastos Generado</label>
                <input type="text" class="form-control" name="fgastosg" placeholder="Ejemplo: 2/7" aria-label="First name">
            </div>
            <div class="col">
                <label for="exampleInputPassword1" class="form-label">Ganacias pretendidas</label>
                <input type="text" class="form-control" name="gananpre" placeholder="Porcentaje sin signo" aria-label="Last name">
            </div>
            <div class="col">
                <label for="exampleInputPassword1" class="form-label">Fraccion Ganacias pretendidas</label>
                <input type="text" class="form-control" name="fgananpre" placeholder="Ejemplo: 5/9" aria-label="Last name">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="exampleInputEmail1" class="form-label">porcentaje de venta</label>
                <input type="text" class="form-control" name="percentv" placeholder="Numero de porsentaje sin signos" aria-label="First name">
            </div>
            <div class="col">
                <label for="exampleInputEmail1" class="form-label">Fraccion de porcentaje de venta</label>
                <input type="text" class="form-control" name="fpercentv" placeholder="Ejemplo: 14/17" aria-label="First name">
            </div>
            <div class="col">
                <label for="exampleInputPassword1" class="form-label">Remate de productos</label>
                <input type="text" class="form-control" name="remtpr" placeholder="porcentaje sin signo" aria-label="Last name">
            </div>
        </div>
        
    
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <br>
    <div class="container">

        <div class="row">
            <div class="col">
                <?php echo number_format($narticulos,2) ?> </br>
                x<?php echo number_format($particulos,2) ?> </br>
                <hr>
                <?php echo number_format($valueProducts,2) ?> </br>
                +<?php echo number_format($valueProductsIva,2) ?> iva del 16%  Iva sin acreditar</br>
                <hr>
                <?php echo number_format($valueProducPlusIva,2) ?> </br>
                +<?php echo number_format($gastosCostos,2) ?> Gastos y costos <?php echo $gastosg." ". $fgastosg ?> % </br>
                <hr>
                <?php echo number_format($totalValueGastos,2) ?> </br>
                +<?php echo number_format($totalValueGastosIva,2) ?> Ganacias del <?php echo $gananpre." ".$fgananpre ?> %  </br>
                <hr>
                <?php echo number_format($totalValueGanan,2) ?> </br>
                +<?php echo number_format($ivaAcreditado,2) ?> iva del 16%  Iva acreditado</br>
                <hr>
                <?php echo number_format($total,2) ?> </br>
            </div>
            <div class="col">
                <h5>Ventas</h5>
                <?php echo number_format($totalValueGanan,2) ?> </br>
                x<?php echo "                  ".$percentv." "."$fpercentv" ?>% </br>
                <hr>
                <?php echo number_format($ventas,2) ?> </br>
                +<?php echo number_format($ivaVentas,2) ?> iva del 16% del fisco que se obtuvo</br>
                <hr>
                <?php echo number_format($totalVentas,2) ?> </br>
    
                <h5>Iva Almacenado</h5>
                <?php echo number_format($ivaAcreditado,2) ?> Iva acreditado </br>
                -<?php echo number_format($ivaVentas,2) ?> iva del 16% del fisco que se obtuvo</br>
                <hr>
                <?php echo number_format($ivaLost,2) ?> Iva almacenado</br>
    
                <h5>Fisco</h5>
                <?php echo number_format($ivaAcreditado,2) ?> Iva acreditado </br>
                -<?php echo number_format($valueProductsIva,2) ?> iva del 16%  Iva sin acreditar</br>
                <hr>
                <?php echo number_format($fisco,2) ?> Iva acreditado </br>
    
                <h5>Faltante</h5>
                <?php echo number_format($totalValueGanan,2) ?> </br>
                x <?php echo $faltante?> % Faltante por vender
                <hr>
                <?php echo number_format($off,2) ?> </br>
                x <?php echo number_format($offRe,2)?>  <?php echo $remtpr?>% descuento 
                <hr>
                <?php echo number_format($totalFaltante,2) ?> </br>
                +<?php echo number_format($ivaFaltan,2) ?> iva del 16% Iva del faltante </br>
                <hr>
                <?php echo number_format($totalFaltanteIva,2) ?> </br>
    
                <h5>Perdida de IVA</h5>
                <?php echo number_format($ivaLost,2) ?> Iva almacenado</br>
                -<?php echo number_format($ivaFaltan,2) ?> iva del 16% Iva del faltante </br>
                <hr>
                <?php echo number_format($ivaPerdida,2) ?> Iva perdido</br>
    
            
    
            </div>
        </div>
    </div>
    
    
</body>
</html>