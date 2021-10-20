<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Engepecas\Pedidos\Api;

interface PedidosManagementInterface
{

    /**
     * GET for pedidos api
     * @param string $param
     * @return string
     */
    public function getPedidos();
}
