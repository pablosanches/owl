<?php

namespace Owl\Method;

use Owl\Http;

/**
 * Http DELETE method
 *
 * @author Pablo Sanches <sanches.webmaster@gmail.com>
 * @license MIT
 */
class Delete extends Http
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
        $this->setCurlOption(CURLOPT_CUSTOMREQUEST, 'DELETE');
    }
}
