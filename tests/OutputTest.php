<?php

namespace Hyqo\Cli\Test;

use Hyqo\Cli\Output;
use PHPUnit\Framework\TestCase;

class OutputTest extends TestCase
{
    public function test_send(): void
    {
        $tmp = tmpfile();

        Output::send('test', $tmp);

        $content = file_get_contents(stream_get_meta_data($tmp)['uri']);
        fclose($tmp);

        $this->assertEquals("test\n", $content);
    }
}
