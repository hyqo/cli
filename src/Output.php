<?php

namespace Hyqo\Cli;

class Output
{
    public static array $cache = [];

    protected Formatter $formatter;

    /** @var resource */
    protected mixed $stream;

    /**
     * @param resource $stream
     */
    public function __construct($stream)
    {
        $this->stream = $stream;
        $this->formatter = new Formatter(stream_isatty($this->stream));
    }

    public function write(string|array $message): void
    {
        fwrite($this->stream, $this->formatter->format($message));
    }

    /**
     * @param resource $stream
     */
    public static function send(string|array $message, mixed $stream): void
    {
        $id = get_resource_id($stream);

        $output = self::$cache[$id] ??= new self($stream);

        $output->write($message);
    }
}
