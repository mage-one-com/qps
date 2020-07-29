<?php

class Mageone_Qps_Helper_GlobalGetter
{
    /**
     * @var callable|null
     */
    private $inputStreamReader;
    /**
     * @var callable|null
     */
    private $stdinStreamReader;

    public function __construct(callable $inputStreamReader = null, callable $stdinStreamReader = null)
    {
        $this->inputStreamReader = $inputStreamReader;
        $this->stdinStreamReader = $stdinStreamReader;
    }

    /**
     * @param string $expr
     *
     * @return string
     */
    public function get($expr): string
    {
        if (!is_string($expr)) {
            throw new InvalidArgumentException('$expr must be a string.');
        }
        if ($expr === 'php://input') {
            return $this->getPhpInput();
        }

        if ($expr === 'php://stdin') {
            return $this->getPhpStdin();
        }

        $expr = str_replace([']', '\'', '"'], '', $expr);

        return (string)$this->getFrom($GLOBALS, explode('[', $expr));
    }

    /**
     * @param array  $array
     * @param array $keys
     *
     * @return array|string|mixed
     */
    private function getFrom($array, $keys)
    {
        if (!isset($array[current($keys)])) {
            return '';
        }

        if (count($keys) === 1) {
            return $array[current($keys)];
        }

        return $this->getFrom($array[array_shift($keys)], $keys);
    }

    /**
     * @return string
     */
    private function getPhpInput(): string
    {
        if ($this->inputStreamReader) {
            return (string)call_user_func($this->inputStreamReader);
        }

        return (string)file_get_contents('php://input');
    }

    private function getPhpStdin(): string
    {
        if ($this->stdinStreamReader) {
            return (string)call_user_func($this->stdinStreamReader);
        }

        return (string)file_get_contents('php://stdin');
    }
}
