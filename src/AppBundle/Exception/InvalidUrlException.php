<?php

namespace AppBundle\Exception;

/**
 * This exception is a URL is invalid, normally because it has invalid characters.
 */
class InvalidUrlException extends \Exception
{
    protected $message = 'The given URL is invalid.';
}
