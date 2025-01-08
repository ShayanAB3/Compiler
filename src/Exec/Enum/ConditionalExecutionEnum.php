<?php

namespace User\ComposerTest\Exec\Enum;

enum ConditionalExecutionEnum : string{
    case AND = "&&";
    case OR = "||";
}