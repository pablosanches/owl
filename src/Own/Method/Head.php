<?php

namespace Own\Method;

use Own\Http;

/**
 * Http Head
 *
 * @author Pablo Sanches <sanches.webmaster@gmail.com>
 * @license MIT
 */
class Head extends Http
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
        $this
            ->setCurlOptions(CURLOPT_HEADER, true)
            ->setCurlOptions(CURLOPT_CUSTOMREQUEST, 'HEAD');
    }
}
