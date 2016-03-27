<?php

namespace Framework\Response;

/**
 * Class ResponseRedirect
 * @package Framework\Response
 */
class ResponseRedirect extends Response
{
    /**
     * ResponseRedirect constructor.
     * @param string $redirect_to
     * @param int $code
     */
    public function __construct($redirect_to, $code = 302)
    {
        $this->setHeader('Location', $redirect_to);
        parent::__construct('', 'text/html', $code);
    }

    public function sendBody()
    {
        // empty
    }
}
