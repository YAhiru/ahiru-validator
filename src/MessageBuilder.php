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

    public function build(string $attribute, RuleInterface $rule) : string
    {
        if ($rule instanceof OverwriteMessage) {
            return $rule->getMessage();
        }

        $template = $this->repository->get(get_class($rule));

        if ($template === null) {
            throw new LogicException();
        }

        /** @var array<string, string> $replacements */
        $replacements = array_merge(['attribute' => $attribute], $rule->getReplacements());
        foreach ($replacements as $key => $replacement) {
            $template = str_replace(":${key}", $replacement, $template);
        }

        return $template;
    }
}
