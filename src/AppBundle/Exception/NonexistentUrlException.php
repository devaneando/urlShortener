<?php

namespace AppBundle\Exception;

/**
 * This exception is used you must have a URL, and it does not exist.
 */
class NonexistentUrlException extends \Exception
{
    protected $message = 'The given URL does not exist in the database.';
}
