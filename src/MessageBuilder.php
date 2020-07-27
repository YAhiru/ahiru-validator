<?php
declare(strict_types=1);
namespace Yahiru\Validator;

use LogicException;
use Yahiru\Validator\Rule\OverwriteMessage;

final class MessageBuilder
{
    private MessageRepositoryInterface $repository;

    public function __construct(MessageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array<string, string> $aliases
     */
    public function build(string $attribute, RuleInterface $rule, array $aliases) : string
    {
        if ($rule instanceof OverwriteMessage) {
            return $rule->getMessage();
        }

        $template = $this->repository->get(get_class($rule));

        if ($template === null) {
            throw new LogicException();
        }

        /** @var array<string, string> $replacements */
        $replacements = array_merge(['attribute' => $attribute], $rule->getAttributes());
        foreach ($replacements as $key => $replacement) {
            $replacement = $aliases[$replacement] ?? $replacement;
            $template = str_replace(":${key}", $replacement, $template);
        }

        return $template;
    }
}
