<?php

namespace Enums;

enum OrderStatus: string
{
    case PENDING = 'Pendiente';
    case PAYED = 'Pagado';
    case PREPARACION = 'En preparacion';
    case READY = 'Listo para servir';
    case DELIVERED = 'Entregado';

}
