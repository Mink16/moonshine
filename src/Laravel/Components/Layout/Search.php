<?php

declare(strict_types=1);

namespace MoonShine\Laravel\Components\Layout;

use MoonShine\UI\Components\MoonShineComponent;

/**
 * @method static static make(string $key = 'search', string $action = '', string $placeholder = '')
 */
final class Search extends MoonShineComponent
{
    protected string $view = 'moonshine::components.layout.search';

    public function __construct(
        private readonly string $key = 'search',
        private string $action = '',
        private string $placeholder = '',
    ) {
        parent::__construct();

        if($this->placeholder === '') {
            $this->placeholder = __('moonshine::ui.search') . ' (Ctrl+K)';
        }

        if($this->action === '') {
            $this->action = moonshineRouter()->to('global-search');
        }
    }

    protected function isGlobalSearchEnabled(): bool
    {
        return filled(
            moonshineConfig()->getGlobalSearch()
        );
    }

    protected function resourceSearchEnabled(): bool
    {
        $resource = moonshineRequest()->getResource();

        return ! is_null($resource) && method_exists($resource, 'search') && $resource->search();
    }

    protected function prepareBeforeRender(): void
    {
        if (! $this->isGlobalSearchEnabled() && $this->resourceSearchEnabled()) {
            $this->action = moonshineRequest()->getResource()?->getUrl();
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected function viewData(): array
    {
        return [
            'action' => $this->action,
            'value' => moonshine()->getRequest()->get($this->key, ''),
            'placeholder' => $this->placeholder,
            'isEnabled' => $this->isGlobalSearchEnabled() || $this->resourceSearchEnabled(),
            'isGlobal' => $this->isGlobalSearchEnabled(),
        ];
    }
}