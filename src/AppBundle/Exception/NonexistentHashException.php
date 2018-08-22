<?php

namespace AppBundle\Exception;

/**
 * This exception is used you must have a hash, and it does not exist.
 */
class NonexistentHashException extends \Exception
{
    protected $message = 'The given hash does not exist in the database.';
}
