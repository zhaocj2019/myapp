<?php

namespace framework\bin\widget\database;

use Exception;
use framework\bin\AUtils;
use framework\lib\Log;

/**
 *
 * @author heypigg
 */
class ADBException extends Exception
{

    public function __construct($message, $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        Log::set('db_error_' . date('Y-m-d') . '.txt', $message . ' >>-----<' . AUtils::currentUrl() . '>');
    }

}
