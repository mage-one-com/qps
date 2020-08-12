<?php

class Mageone_Qps_Model_HTTP_Client_Curl extends Mage_HTTP_Client_Curl
{
    /**
     * Parse headers - CURL callback functin
     *
     * @param resource $ch curl handle, not needed
     * @param string   $data
     *
     * @return int
     */
    protected function parseHeaders($ch, $data): int
    {
        if ($this->_headerCount === 0) {
            $line = explode(' ', trim($data), 3);

            $this->validateHttpVersion($line);
            $this->_responseStatus = (int)$line[1];
        } else {
            //var_dump($data);
            $name = $value = '';
            $out  = explode(': ', trim($data), 2);
            if (count($out) === 2) {
                [$name, $value] = $out;
            }

            if ('' !== $name) {
                if ('Set-Cookie' === $name) {
                    if (!isset($this->_responseHeaders[$name])) {
                        $this->_responseHeaders[$name] = [];
                    }
                    $this->_responseHeaders[$name][] = $value;
                } else {
                    $this->_responseHeaders[$name] = $value;
                }
            }

        }
        $this->_headerCount++;

        return strlen($data);
    }

    /**
     * @param array $line
     *
     * @throws Exception
     */
    protected function validateHttpVersion(array $line): void
    {
        if ($line[0] === 'HTTP/1.1') {
            if (count($line) !== 3) {
                $this->doError('Invalid response line returned from server: ' . implode(' ', $line));
            }

            return;
        }

        if ($line[0] === 'HTTP/2') {
            if (!in_array(count($line), [2, 3])) {
                $this->doError('Invalid response line returned from server: ' . implode(' ', $line));
            }

            return;
        }
        $this->doError('Invalid response line returned from server: ' . $data);
    }
}
