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

    public function add($name, $value = null)
    {
        if(is_string($name) && $value === null)
        {
            $this->message = $name;
        }
        else if(is_string($name) && isset($value))
        {
            $this->data[$name] = $value;
        }
        else if(is_array($name) && $value === null)
        {
            $this->data = array_merge($this->data, $name);
        }

        return $this;
    }

    public function success()
    {
        $this->success = true;

        return $this->send();
    }

    public function failure()
    {
        $this->success = false;

        return $this->send();
    }

    /**
     * @return string
     */
    private function send()
    {
        header('Content-Type: application/json');

        echo json_encode($this->getResponse());
        exit();
    }

    private function getResponse()
    {
        $response = array(
            'success' => $this->success
        );

        if(!empty($this->message)) {
            $response['message'] = $this->message;
        }

        if(!empty($this->data)) {
            $response = array_merge($this->data, $response);
        }

        return $response;
    }

}