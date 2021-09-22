<!doctype html>
<html lang="pt-BR">

<head>
    <title>Integracao</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<?php
$userData = array("username" => "ivan", "password" => "Ap175483");
$ch = curl_init("http://192.168.0.241:5000/magento2/rest/V1/integration/admin/token");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Lenght: " . strlen(json_encode($userData))));

$token = curl_exec($ch);

//$ch = curl_init("http://192.168.0.241:5000/magento2/rest/V1/orders/1");
$ch = curl_init("http://192.168.0.241:5000/magento2/rest/all/V1/orders?searchCriteria%5BfilterGroups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bfield%5D=status&searchCriteria%5BfilterGroups%5D%5B0%5D%5Bfilters%5D%5B0%5D%5Bvalue%5D=pending");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . json_decode($token)));

$result = curl_exec($ch);

$result = json_decode($result, 1);

?>

<body>
    <div class="container">
        <div class="row">
            <h1>Teste de integração Magento</h1>
        </div>
        <pre>
            <?php 
            $cont = count($result['items']);
            $result = $result['items'];
            for($b = 0; $b < $cont; $b++){
                $endereco = $result[$b]['billing_address'];
                ?>
                <div class="row col-12">
                <h3>Endereço Cliente</h3>
                <?php
                print_r($endereco);
                ?>
                </div>
                <div class="row col-12">
                <h3>Dados do pedido</h3>>
                <?php
                $total = count($result[$b]['items']);
                $items = $result[$b]['items'];
                for($a =0; $a < $total; $a++){
                    print_r($items[$a]);
                }

            }
            //print_r($result);
            ?>
            </div>
        </pre>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>