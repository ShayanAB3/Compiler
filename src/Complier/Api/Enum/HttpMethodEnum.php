<?php

namespace User\ComposerTest\Complier\Api\Enum;

enum HttpMethodEnum : string{
    case GET = "GET";
    case POST = "POST";
    case PUT = "PUT";
    case PATCH = "PATCH";
    case DELETE = "DELETE";
}