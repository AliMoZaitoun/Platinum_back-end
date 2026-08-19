<?php

namespace App\DTOs\Chat\Faq\Update;

class UpdateFaqNodeDTO
{
    public function __construct(
        public ?array $title,
        public ?string $type = null,
        public ?int $parent_id = null,
        public ?array $content,
        public ?int $sort_order = null,
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            title: $request['title'] ?? null,
            type: $request['type'] ?? null,
            parent_id: $request['parent_id'] ?? null,
            content: $request['content'] ?? null,
            sort_order: $request['sort_order'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'title'      => $this->title,
            'type'       => $this->type,
            'parent_id'  => $this->parent_id,
            'content'    => $this->content,
            'sort_order' => $this->sort_order,
        ], fn($value) => !is_null($value));
    }
}
