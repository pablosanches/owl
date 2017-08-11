<?php

namespace Own;

/**
 * Http abstract class
 *
 * @author Pablo Sanches <sanches.webmaster@gmail.com>
 * @license MIT
 */
abstract class Http
{
    /**
     * Curl instance
     *
     * @var cURL
     */
    protected $ch = null;

    /**
     * cURL options
     *
     * @var array
     */
    protected $curl_options = null;

    /**
     * Options
     *
     * @var array
     */
    protected $options = null;

    /**
     * Http status code
     *
     * @var integer
     */
    protected $status;

    /**
     * Http header
     *
     * @var string
     */
    protected $header;

    /**
     * Http response
     *
     * @var string
     */
    protected $response;

    /**
     * The constructor
     *
     * @param string $url
     * @param array $options
     */
    public function __construct($url, $options = null)
    {
        if (isset($url)) {
            $this->options = $options;
            $this->options['request_headers'] = array();

            // Init cURL
            $this->ch = curl_init($url);
        }
    }

    /**
     * Get http status code
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get header
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Get response
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get cURL options
     *
     * @return array
     */
    public function getCurlOptions()
    {
        return $this->curl_options;
    }

    /**
     * Set cURL option
     *
     * @param string $option
     * @param string $value
     * @return Own\Http
     */
    public function setCurlOptions($option, $value)
    {
        curl_setopt($this->ch, $option, $value);
        $this->curl_options[$option] = $value;

        return $this;
    }

    /**
     * Get cURL info
     *
     * @param  string $info
     * @return string
     */
    public function getCurlInfo($info)
    {
        return curl_getinfo($this->ch, $info);
    }

    /**
     * Sends the request
     *
     * @return Own\Http
     */
    public function send()
    {
        // Defaults options
        $this
            ->setCurlOptions(CURLOPT_RETURNTRANSFER, true)
            ->setCurlOptions(CURLINFO_HEADER_OUT, true);

        // Additional headers
        if (!empty($this->options['headers'])) {
            $this->options['request_headers'] = array_merge(
                $this->options['request_headers'],
                $this->options['headers']
            );
        }

        // SSL
        if (isset($this->options['ssl'])) {
            $this
                ->setCurlOptions(CURLOPT_SSL_VERIFYPEER, true)
                ->setCurlOptions(CURLOPT_SSL_VERIFYHOST, 2)
                ->setCurlOptions(CURLOPT_CAINFO, getcwd() . $this->options['ssl']);
        }

        // Payload
        if ((bool) $this->options['is_payload']) {
            $this->options['request_headers'] = array_merge(
                $contentLength = ((isset($this->options['data']))
                    ? strlen(json_encode($this->options['data']))
                    : 0);

                $this->options['request_headers'],
                [
                    'Content-Type: application/json',
                    'Content-Length: ' . $contentLength
                ]
            );
        }

        // Set headers
        if (!empty($this->options['request_headers'])) {
            $this->setCurlOptions(CURLOPT_HTTPHEADER, $this->options['request_headers']);
        }

        // Retrieving HTTP response body
        $this->response = curl_exec($this->ch);

        // Retrieving HTTP status code
        $this->status = $this->getCurlInfo(CURLINFO_HTTP_CODE);

        // Retrieving HTTP header
        $this->header = $this->getCurlInfo(CURLINFO_HEADER_OUT);

        // Autoclose handle
        if(
            !isset($this->options['autoclose']) ||
            (isset($this->options['autoclose']) &&
                $this->options['autoclose'] !== false)
        ) {
            $this->close();
        }

        return $this;
    }

    /**
     * Close the handle
     *
     * @return Own\Http
     */
    public function close()
    {
        curl_close($this->ch);

        return $this;
    }
}
