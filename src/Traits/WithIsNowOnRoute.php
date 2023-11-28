<?php

declare(strict_types=1);

namespace MoonShine\Traits;

use MoonShine\Enums\PageType;

trait WithIsNowOnRoute
{
    protected bool $forceNowOnIndex = false;

    protected bool $forceNowOnDetail = false;

    protected bool $forceNowOnCreate = false;

    protected bool $forceNowOnUpdate = false;

    public function forceNowOnIndex(): static
    {
        $this->forceNowOnIndex = true;

        return $this;
    }

    public function forceNowOnDetail(): static
    {
        $this->forceNowOnDetail = true;

        return $this;
    }

    public function forceNowOnCreate(): static
    {
        $this->forceNowOnCreate = true;

        return $this;
    }

    public function forceNowOnUpdate(): static
    {
        $this->forceNowOnUpdate = true;

        return $this;
    }

    public function isNowOnIndex(): bool
    {
        if($this->forceNowOnDetail || $this->forceNowOnCreate || $this->forceNowOnUpdate) {
            return false;
        }

        if($this->forceNowOnIndex) {
            return true;
        }

        return (request()?->route('pageUri') && moonshineRequest()->getPage()->pageType() === PageType::INDEX)
            || (request('pageUri') && moonshineRequest()->getPage()->pageType() === PageType::INDEX);
    }

    public function isNowOnDetail(): bool
    {
        if($this->forceNowOnIndex || $this->forceNowOnCreate || $this->forceNowOnUpdate) {
            return false;
        }

        if ($this->forceNowOnDetail) {
            return true;
        }

        return (request()?->route('pageUri') && moonshineRequest()->getPage()->pageType() === PageType::DETAIL)
            || (request('pageUri') && moonshineRequest()->getPage()->pageType() === PageType::DETAIL);
    }

    public function isNowOnForm(): bool
    {
        if($this->forceNowOnDetail || $this->forceNowOnIndex) {
            return false;
        }

        return $this->isNowOnCreateForm()
            || $this->isNowOnUpdateForm();
    }

    public function isNowOnCreateForm(): bool
    {
        if($this->forceNowOnDetail || $this->forceNowOnIndex) {
            return false;
        }

        if ($this->forceNowOnCreate) {
            return true;
        }

        return (
            is_null(request()?->route('resourceItem'))
            && request()?->route('pageUri') && moonshineRequest()->getPage()->pageType() === PageType::FORM
        ) && (
            is_null(request('resourceItem'))
            && request('pageUri') && moonshineRequest()->getPage()->pageType() === PageType::FORM
        );
    }

    public function isNowOnUpdateForm(): bool
    {
        if($this->forceNowOnDetail || $this->forceNowOnIndex) {
            return false;
        }

        if ($this->forceNowOnUpdate) {
            return true;
        }

        return (
            ! is_null(request()?->route('resourceItem'))
            && request()?->route('pageUri') && moonshineRequest()->getPage()->pageType() === PageType::FORM
        ) || (
            ! is_null(request('resourceItem'))
            && request('pageUri') && moonshineRequest()->getPage()->pageType() === PageType::FORM
        );
    }
}
