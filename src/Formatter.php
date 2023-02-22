<?php

namespace Hyqo\Cli;

class Formatter
{
    protected bool $colorize = false;

    protected const STYLES = [
        'error' => '31m',
        'trace' => '90m',
    ];

    public function __construct(bool $colorize = false)
    {
        $this->colorize = $colorize;
    }

    public function format(string|array $message): string
    {
        $message = $this->normalize($message);

        foreach (self::STYLES as $tag => $style) {
            $message = (string)preg_replace(
                sprintf('/<%1$s>(.*)<\/%1$s>/sU', $tag),
                $this->colorize ? sprintf("\033[%s$1\033[0m", $style) : '$1',
                $message
            );
        }

        return $message;
    }

    public function normalize(string|array $message): string
    {
        if (is_array($message)) {
            return array_reduce($message, static function (string $carry, string $line) {
                return $carry . $line . PHP_EOL;
            }, '');
        }

        return $message . PHP_EOL;
    }
}
