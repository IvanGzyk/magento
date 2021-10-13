<!doctype html>
<html lang="pt-BR">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
    #selecao {
        border: 2px #aaf solid;
        position: absolute;
        display: none;
        background-color rgba(255, 0, 0, 0.3);
    }
    </style>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<?php
$img = '';
$img_tmp = '';
if(isset($_FILES)){
    $img = $_FILES['arquivo']['name'];
    $img_tmp = $_FILES['arquivo']['tmp_name'];
@    copy($img_tmp,"/var/www/html/magento2/pub/media/img/$img");
    $img_cam = "http://192.168.0.241:5000/magento2/pub/media/img/$img";
}
if($_POST){
    //print_r($_POST);
    echo $_POST['html'];
}
?>

<body>
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="custom-file col-md-4">
            <input type="file" class="custom-file-input" name="arquivo" id="arquivo">
            <label class="custom-file-label" for="validatedCustomFile">Carregar diagrama...</label>
        </div>
        <input type="submit" class="btn btn-primary" value="Enviar">
    </form>
    <?php
    if(isset($img_cam)){ 
    ?>
    <div id="selecao"></div>
    <img src="<?=$img_cam?>" alt="" />
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Titulo</label>
                            <input type="text" class="form-control" name="titulo" id="titulo">
                        </div>
                        <div class="form-group col-md-6">
                            <label>ID Modal</label>
                            <input type="text" class="form-control" name="id" id="id">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Descrição</label>
                            <input type="text" class="form-control" name="desc" id="desc">
                        </div>
                        <div class="form-group col-md-6">
                            <label>link para produto</label>
                            <input type="text" class="form-control" name="link" id="link">
                        </div> 
                        <div class="form-group col-md-6">
                            <label>ID Produto</label>
                            <input type="text" class="form-control" name="id_prod" id="id_prod">
                        </div>                   
                    </div>
                    <button type="button" class="btn btn-secondary text-white" id="add">Adicionar</button>
                </form><br>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="#" method="POST">
                    <div id="info">
                    </div>
                    <button type="submit" class="btn btn-primary text-white">Salvar</button>
                </form>
            </div>
        </div>
    </div>
    <?php
    }
    ?>

    <!-- Optional JavaScript -->

    <script>
    let info = document.getElementById('info');
    let img = document.querySelector('img');
    let selecao = document.getElementById('selecao');
    let titulo = document.getElementById('titulo');
    let id = document.getElementById('id');
    let id_prod = document.getElementById('id_prod');
    let desc = document.getElementById('desc');
    let link = document.getElementById('link');
    const add = document.querySelector('#add');
    let inicio;
    let texto_map = '';
    let texto_modal = '';
    let pos;

    add.addEventListener('click', () => adicionar());

    function arrastador(e) {
        e.preventDefault();
        selecao.style.width = e.pageX - inicio.x + 'px';
        selecao.style.height = e.pageY - inicio.y + 'px';
        gerarInfo();
    }

    function adicionar() {
        texto_map +=`<area alt="${titulo.value}" title="${titulo.value}" data-toggle="modal" and data-target="#${id.value}" coords="${pos.left}, ${pos.top}, ${pos.right}, ${pos.bottom}" shape="rect">\n`;
        texto_modal += `
        <div id="${id.value}" class="modal fade"  role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h2>${titulo.value}</h2>
                        <p>${desc.value}</p>
                        <a class="btn btn-primary" href="${link.value}">Comprar</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>\n
            `;
        gerarInfo();
    }

    function gerarInfo() {
        pos = selecao.getBoundingClientRect();

        if (texto_map != '') {
            var texto = `
            <input type="hidden" name="id_prod" value="${id_prod.value}">
            <textarea class="form-control" name="html" rows="12">
                <div class="container-fluid" style="align: center;">
                    <img src="<?= $img_cam?>" usemap="#image_map">
                    <map name="image_map">
                        ${texto_map}</map>
                </div>
                ${texto_modal}
            </textarea>`;

            info.innerHTML = texto;
        }
    }
    img.addEventListener('mousedown', function(e) {
        inicio = {
            x: e.pageX,
            y: e.pageY
        };
        selecao.style.display = 'block';
        selecao.style.left = inicio.x + 'px';
        selecao.style.top = inicio.y + 'px';
        selecao.style.width = 0;
        selecao.style.height = 0;
        window.addEventListener('mousemove', arrastador);
    });
    window.addEventListener('mouseup', function(e) {
        inicio = null;
        window.removeEventListener('mousemove', arrastador);
        gerarInfo();
    });
    </script>
</body>

</html>