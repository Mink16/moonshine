<?php

declare(strict_types=1);

namespace Leeto\MoonShine\Actions;

use Leeto\MoonShine\Contracts\Resources\ResourceContract;
use Leeto\MoonShine\Traits\Makeable;
use Leeto\MoonShine\Traits\WithLabel;
use Leeto\MoonShine\Traits\WithView;

abstract class Action
{
    use Makeable;
    use WithView;
    use WithLabel;

    protected bool $inDropdown = true;

    protected ResourceContract|null $resource;

    final public function __construct(string $label)
    {
        $this->setLabel($label);
    }

    public function resource(): ResourceContract|null
    {
        return $this->resource;
    }

    public function setResource(ResourceContract $resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function inDropdown(): bool
    {
        return $this->inDropdown;
    }

    public function showInDropdown(): static
    {
        $this->inDropdown = true;

        return $this;
    }

    public function render(): string
    {
        return view($this->getView(), [
            'action' => $this,
        ])->render();
    }
}
