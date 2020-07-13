<?php

class Mageone_Qps_Helper_GlobalGetter
{
    /**
     * @var callable
     */
    private $inputStreamReader = null;

    public function __construct(callable $inputStreamReader = null)
    {
        if ($inputStreamReader) {
            $this->inputStreamReader = $inputStreamReader;
        }
    }

    /**
     * @param string $expr
     *
     * @return string
     */
    public function get($expr)
    {
        if (!is_string($expr)) {
            throw new InvalidArgumentException('$expr must be a string.');
        }
        if ($expr === 'php://input') {
            return $this->getPhpInput();
        }

        $expr = str_replace([']', '\'', '"'], '', $expr);

        return (string)$this->getFrom($GLOBALS, explode('[', $expr));
    }

    /**
     * @param array  $array
     * @param string $keys
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
    private function getPhpInput()
    {
        if ($this->inputStreamReader) {
            return (string)call_user_func($this->inputStreamReader);
        }

        return (string)file_get_contents('php://input');
    }
}
