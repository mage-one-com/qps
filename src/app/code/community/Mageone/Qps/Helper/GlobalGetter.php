<?php

class Mageone_Qps_Helper_GlobalGetter
{
    public function get($expr)
    {
        $expr = str_replace([']', '\'', '"'], '', $expr);

        return $this->getFrom($GLOBALS, explode('[', $expr));
    }

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
}
