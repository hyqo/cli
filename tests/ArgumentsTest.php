<?php

namespace Hyqo\Cli\Test;

use Hyqo\Cli\Arguments;
use PHPUnit\Framework\TestCase;

class ArgumentsTest extends TestCase
{
    private array $input = [
        'arg0',
        'arg1',
        'arg2',
        '-fa',
        '--l1=foo',
        '--l2=false',
        '--l3',
    ];

    private Arguments $arguments;

    protected function setUp(): void
    {
        $this->arguments = new Arguments($this->input);
    }

    public function test_get_all_argument(): void
    {
        $this->assertEquals($this->input, $this->arguments->getAll());
    }

    public function test_get_first_argument(): void
    {
        $this->assertEquals('arg1', $this->arguments->getFirst());
    }

    public function test_get_argument(): void
    {
        $this->assertEquals('arg1', $this->arguments->get(1));
        $this->assertEquals('arg2', $this->arguments->get(2));
    }

    public function test_get_short_options(): void
    {
        $this->assertEquals(['f' => true, 'a' => true], $this->arguments->getShortOptions());
    }

    public function test_get_long_options(): void
    {
        $this->assertEquals(
            ['l1' => 'foo', 'l2' => false, 'l3' => true],
            $this->arguments->getLongOptions()
        );
    }
}
