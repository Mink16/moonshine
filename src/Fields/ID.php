<?php

declare(strict_types=1);

namespace MoonShine\Fields;

use Closure;

class ID extends Hidden
{
    protected string $field = 'id';

    protected Closure|string $label = 'ID';
}
