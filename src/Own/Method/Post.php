<?php

namespace Own\Method;

use Own\Http;

/**
 * Http POST method
 *
 * @author Pablo Sanches <sanches.webmaster@gmail.com>
 * @license MIT
 */
class Post extends Http
{
    /**
     * The construct
     *
     * @param string $url
     * @param array $options
     */
    public function __construct($url, $options = null)
    {
        parent::__construct($url, $options);

        $this->prepare();
    }

    /**
     * Prepare the request
     *
     * @return void
     */
    public function prepare()
    {
        $this->setCurlOptions(CURLOPT_CUSTOMREQUEST, 'POST');

        if (isset($this->options['data'])) {
            $data = ((bool) $this->options['is_payload'])
                ? json_encode($this->options['data'])
                : http_build_query($this->options['data']);

            $this
                ->setCurlOptions(CURLOPT_POST, 1)
                ->setCurlOptions(CURLOPT_POSTFIELDS, $data);
        }
    }
}
