<?php

namespace Enums;

enum UserType: string
{
    case PARTNER = 'socio';
    case BARTENDER = 'bartender';
    case BREWER = 'cervecero';
    case COOKER = 'cocinero';
    case WAITER = 'mozo';
    case CANDYBAR = 'candybar';
}