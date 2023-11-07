<?php

namespace Enums;

enum TableStatus: string
{
    case WAITING = 'Esperando Pedido';
    case SERVED = 'Comiendo';
    case PAYING = 'Pagando';
    case CLOSE = 'Cerrada';
    case DOWN = 'Baja';


    case PENDING = 'Pendiente';
    case PAYED = 'Pagado';


    case PREPARACION = 'En preparacion';
    case READY = 'Listo para servir';
    case DELIVERED = 'Entregado';

}
