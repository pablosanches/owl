<?php

namespace Owl\Method;

use Owl\Http;

/**
 * Http Patch
 *
 * @author Pablo Sanches <sanches.webmaster@gmail.com>
 * @license MIT
 */
class Patch extends Http
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
            ->setCurlOption(CURLOPT_CUSTOMREQUEST, 'PATCH');

        if (isset($this->options['data'])) {
            $data = ((bool) $this->options['is_payload'])
                ? json_encode($this->options['data'])
                : http_build_query($this->options['data']);

            $this->setCurlOption(CURLOPT_POSTFIELDS, $data);
        }
    }
}
