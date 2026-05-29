<?php

class MageOne_Qps_Helper_GlobalGetter
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

        $value = $this->getFrom($GLOBALS, explode('[', $expr));

        return is_array($value) ? $this->flattenArray($value) : (string)$value;
    }

    /**
     * Collect all values from the array and concat them with space - ignores keys
     *
     * @param array $value
     *
     * @return string
     */
    private function flattenArray(array $value): string
    {
        $parts = [];
        $stack = [$value];

        while (!empty($stack)) {
            $current = array_shift($stack);
            foreach ($current as $item) {
                if (is_array($item)) {
                    $stack[] = $item;
                } else {
                    $parts[] = (string)$item;
                }
            }
        }

        return implode(' ', $parts);
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
