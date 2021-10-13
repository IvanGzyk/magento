<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Engepecas\Pedidos\Model;

use Magento\Framework\App\ResourceConnection;

class PedidosManagement implements \Engepecas\Pedidos\Api\PedidosManagementInterface
{
    protected $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }
    /**
     * {@inheritdoc}
     */
    public function getPedidos()
    {
        $connection = $this->resourceConnection->getConnection();

        $query = " SELECT
                    o.entity_id id,
                    o.`status`,
                    o.base_grand_total total,
                    o.base_shipping_amount frete,
                    o.base_subtotal valor,
                    o.customer_email email,
                    o.customer_firstname 'Primeiro nome',
                    o.customer_lastname sobrenome,
                    o.created_at pedido,
                    o.updated_at atualizado,
                    a.city cidade,
                    a.region estado,
                    a.postcode cep,
                    a.street endereço,
                    a.telephone fone,
                    a.company empresa
                    FROM sales_order o
                        JOIN sales_order_address a on a.parent_id = o.entity_id
                    WHERE
                        DATE_FORMAT(o.updated_at, '%Y-%m-%d') = DATE(CURRENT_DATE() - INTERVAL 2 DAY)
                    AND
                    `status` <> 'complete'
                    GROUP BY a.entity_id;";

        $pedido = $connection->fetchAll($query);

        $query = "SELECT
                    order_id id,
                    NAME produto,
                    description descricao,
                    qty_ordered qtd,
                    price valor_uni
                    FROM sales_order_item
                WHERE
                    order_id = 1;";

        $cliente = $connection->fetchAll($query);

        $retorno = $pedido + $cliente;

        return $retorno;
    }
}
