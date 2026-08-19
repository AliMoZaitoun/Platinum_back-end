<?php

namespace App\DTOs\Chat\Faq\Create;

class CreateFaqNodeDTO
{
    public function __construct(
        public array $title,
        public string $type,
        public ?int $parent_id = null,
        public ?array $content = null,
        public int $sort_order = 0,
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            title: $request['title'],
            type: $request['type'] ?? 'category',
            parent_id: $request['parent_id'] ?? null,
            content: $request['content'] ?? null,
            sort_order: $request['sort_order'] ?? 0,
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
