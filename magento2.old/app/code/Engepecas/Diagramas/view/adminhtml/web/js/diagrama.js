define(['jquery'], function($){
    "use strict";
    return function diagrama()
    {
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
            texto_map +=
                `<area alt="${titulo.value}" title="${titulo.value}" data-toggle="modal" and data-target="#${id.value}" coords="${pos.left}, ${pos.top}, ${pos.right}, ${pos.bottom}" shape="rect">\n`;
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
    }
});
