<?php

namespace App\Models;

readonly class Page
{
    public function __construct(
        private string $title,
        private string $description,
        private string $vueComponent,
        private string|null $formRequest,
        private string|null $action
    ) {
    }

    public static function make(
        string $title,
        string $description,
        string $vueComponent,
        string $formRequest = null,
        string $action = null,
    ): static {
        return new static($title, $description, $vueComponent, $formRequest, $action);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getVueComponent(): string
    {
        return $this->vueComponent;
    }

    /**
     * @return string
     */
    public function getFormRequest(): string
    {
        return $this->formRequest;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

}
