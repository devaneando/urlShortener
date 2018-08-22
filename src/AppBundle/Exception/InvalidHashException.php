<?php

namespace AppBundle\Exception;

/**
 * This exception is used when an existant hash is being used in a new Url.
 */
class InvalidHashException extends \Exception
{
    protected $message = 'The given hash is invalid.';
}
