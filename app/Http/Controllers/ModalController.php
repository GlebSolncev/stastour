<?php

namespace App\Http\Controllers;

class ModalController
{
    public function create(string $code)
    {
        return view('component.modal.'.$code, request()->toArray());
    }
}
