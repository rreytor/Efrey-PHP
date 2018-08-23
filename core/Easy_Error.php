<?php
/**
 * Created by PhpStorm.
 * User: rreytor
 * Date: 18/06/2015
 * Time: 10:26 AM
 */

class Easy_Error {

    private $level;
    private $msg_error;

    function __construct($msg_error,$level="error")
    {
        $this->level = $level;
        $this->msg_error = $msg_error;

        switch($level)
        {
            case "error":
                    $this->msgError();
                break;
            case "404":
                    $this->msg404();
                break;
        }

    }

    function msg404()
    {
        $msg_error = $this->msg_error;
        include  APP_PATH."404".DS."msg404.php";

    }

    function msgError()
    {
        $msg_error = $this->msg_error;
        include  APP_PATH."404".DS."msgError.php";
    }

} 