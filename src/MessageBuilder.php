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
     * @param array<int, RuleCollection> $defines
     */
    public function build(array $defines, string $attribute, RuleInterface $rule) : string
    {
        if ($rule instanceof OverwriteMessage) {
            return $rule->getMessage();
        }

        $template = $this->repository->get(get_class($rule));

        if ($template === null) {
            throw new LogicException();
        }

        /** @var array<string, Keys|string> $replacements */
        $replacements = array_merge(['attribute' => $attribute], $rule->getAttributes());
        foreach ($replacements as $key => $replacement) {
            if ($replacement instanceof Keys) {
                $replacement = $this->getAlias($defines, $replacement) ?? '';
            }

            $template = str_replace(":${key}", $replacement, $template);
        }

        return $template;
    }

    /**
     * @param array<int, RuleCollection> $defines
     */
    private function getAlias(array $defines, Keys $keys) : ?string
    {
        /** @var RuleCollection $define */
        foreach ($defines as $define) {
            if ($define->getKeys()->equals($keys)) {
                return $define->getAttributeName();
            }
        }

        return null;
    }
}
