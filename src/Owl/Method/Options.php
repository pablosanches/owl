<?php

namespace Owl\Method;

use Owl\Http;

/**
 * Http Options
 *
 * @author Pablo Sanches <sanches.webmaster@gmail.com>
 * @license MIT
 */
class Options extends Http
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
            ->setCurlOption(CURLOPT_CUSTOMREQUEST, 'OPTIONS');
    }
}
