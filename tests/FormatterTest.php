<?php

namespace Hyqo\Cli\Test;

use Hyqo\Cli\Formatter;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{
    public function test_normalize_string(): void
    {
        $message = 'test';
        $expected = 'test' . PHP_EOL;

        $this->assertEquals($expected, (new Formatter())->normalize($message));
    }

    public function test_normalize_array(): void
    {
        $message = ['foo', 'bar'];
        $expected = 'foo' . PHP_EOL . 'bar' . PHP_EOL;

        $this->assertEquals($expected, (new Formatter())->normalize($message));
    }

    public function test_format_without_ansi(): void
    {
        $message = ["<error>line 1\nline 2</error> <error>foo</error>", '<trace>bar</trace>'];
        $expected = 'line 1' . PHP_EOL . 'line 2 foo' . PHP_EOL . 'bar' . PHP_EOL;

        $this->assertEquals($expected, (new Formatter())->format($message));
    }

    public function test_format_with_ansi(): void
    {
        $message = ['error: <error>foo</error>', 'text', '<trace>bar</trace>'];
        $expected = "error: \033[31mfoo\033[0m" . PHP_EOL . "text" . PHP_EOL . "\033[90mbar\033[0m" . PHP_EOL;

        $this->assertEquals($expected, (new Formatter(true))->format($message));
    }
}
