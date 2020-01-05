<?php

namespace App\Http;

class Flash
{

    public function create($message, $type)
    {
        session()->flash('flash_message', [
            'type' => $type,
            'message' => $message,
        ]);
    }

    public function message($message, $type)
    {

        return $this->create($message, $type, 'bell', '');
    }

    public function success($message, $title = null)
    {

        return $this->create($message, 'success', $title, 'ok');
    }

    public function danger($message, $title = null)
    {

        return $this->create($message, 'danger', $title, 'fire');
    }

    public function error($message, $title = null)
    {
        return $this->create($message, 'error', $title, 'info-sign');
    }

}
