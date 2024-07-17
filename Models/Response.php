<?php
namespace App\Models;

class Response
{
    public function Response($num, $message)
    {
        return [
            'status' => $num,
            'message' => $message
        ];
    }
    public function ResponseData($num, $message, $data)
    {
        return [
            'status' => $num,
            'message' => $message,
            'data' => $data
        ];
    }
}