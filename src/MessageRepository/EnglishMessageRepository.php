<?php
declare(strict_types=1);
namespace Yahiru\Validator\MessageRepository;

use Yahiru\Validator\MessageRepositoryInterface;
use Yahiru\Validator\RuleInterface;

class EnglishMessageRepository implements MessageRepositoryInterface
{
    /**
     * @phpstan-var array<class-string<RuleInterface>, string>
     */
    protected array $messages = [
        \Yahiru\Validator\Rule\ArrayMax::class => 'size of :attribute must be smaller than :max.',
        \Yahiru\Validator\Rule\DateTimeAfter::class => ':attribute must be a date after :after.',
        \Yahiru\Validator\Rule\Distinct::class => ':attribute must be unique.',
        \Yahiru\Validator\Rule\Nullable::class => '',
        \Yahiru\Validator\Rule\OverwriteMessage::class => '',
        \Yahiru\Validator\Rule\Regex::class => ':attribute is invalid format.',
        \Yahiru\Validator\Rule\Required::class => ':attribute is required.',
        \Yahiru\Validator\Rule\StringRange::class => ':attribute must be between :min and :max characters.',
    ];

    public function get(string $id) : ?string
    {
        return $this->messages[$id] ?? null;
    }
}
