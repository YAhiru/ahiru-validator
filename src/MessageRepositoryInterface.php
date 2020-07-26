<?php
declare(strict_types=1);
namespace Yahiru\Validator;

interface MessageRepositoryInterface
{
    /**
     * @phpstan-param class-string<RuleInterface> $id
     */
    public function get(string $id) : ?string;
}
