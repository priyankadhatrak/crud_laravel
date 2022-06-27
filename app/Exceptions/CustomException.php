<?php

namespace App\Exceptions;

use Exception;
use resources\views\errors; 

class CustomException extends Exception
{
    public function report()
    {
    }
  
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->view(
                'errors.custom',
                array(
                    'exception' => $this
                )
        );
    }
}
