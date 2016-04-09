<?php

namespace TM\Config\Components\Http;

class JsonResponse
{

    /**
     * @var boolean
     */
    private $success;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $data;

    public function __construct()
    {
        $this->success = true;
        $this->message = '';
        $this->data    = array();
    }

    public function success($message = '', $data = array())
    {
        if(is_array($message) && empty($data)) {
            $data = $message;
            $message = '';
        }

        $this->success = true;
        $this->message = $message;
        $this->data    = $data;

        return $this->send();
    }

    public function failure($message = '', $data = array())
    {
        if(is_array($message) && empty($data)) {
            $data = $message;
            $message = '';
        }

        $this->success = false;
        $this->message = $message;
        $this->data    = $data;

        return $this->send();
    }

    private function send()
    {
        header('Content-Type: application/json');

        return json_encode($this->getResponse());
    }

    private function getResponse()
    {
        $response = array(
            'success' => $this->success
        );

        if(!empty($this->message)) {
            $response['message'] = $this->message;
        }

        if(!empty($this->data) && is_array($this->data)) {
            $response = array_merge($this->data, $response);
        }

        return $response;
    }

}