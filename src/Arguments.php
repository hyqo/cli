<?php

namespace Hyqo\Cli;

class Arguments
{
    protected array $argv;

    protected ?array $shortOptions = null;

    protected ?array $longOptions = null;

    public function __construct(array $argv)
    {
        $this->argv = array_values($argv);
    }

    public function getFirst(): ?string
    {
        return $this->get(1);
    }

    public function getAll(): array
    {
        return $this->argv;
    }

    public function get(int $index): ?string
    {
        return $this->argv[$index] ?? null;
    }

    public function getShortOptions(): array
    {
        return $this->shortOptions ??= iterator_to_array(
            (function () {
                foreach ($this->argv as $argument) {
                    if (!preg_match('/^-([a-zA-Z0-9]+)$/', $argument, $match)) {
                        continue;
                    }

                    foreach (str_split($match[1]) as $option) {
                        yield $option => true;
                    }
                }
            })()
        );
    }

    /**
     * @return array<bool|string>
     */
    public function getLongOptions(): array
    {
        return $this->longOptions ??= (function () {
            $arguments = [];

            foreach ($this->argv as $argument) {
                if (!preg_match('/^--(?P<key>\w+)(?: *= *(?P<value>.+))?/', $argument, $matches)) {
                    continue;
                }

                $key = $matches['key'];
                $value = $matches['value'] ?? true;

                if (is_string($value) && strtolower($value) === 'false') {
                    $value = false;
                }

                $arguments[$key] = $value;
            }

            return $arguments;
        })();
    }
}
