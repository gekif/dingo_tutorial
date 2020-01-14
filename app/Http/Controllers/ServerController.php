<?php

namespace App\Http\Controllers;

class ServerController extends Controller
{
    public function test()
    {
        return "Hello World";
    }

    public function ping()
    {
        return $this->success();
    }

    public function version()
    {
        if (file_exists(base_path('version'))) {
            return $this->success(file_get_contents(base_path('version')));
        }

        return $this->success('dev');
    }
}
