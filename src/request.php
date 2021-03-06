<?php
 
namespace Src;
 
 
class Request
{
    protected $base;
    protected $uri;
    protected $method;
    protected $protocol;
    protected $data = [];
 
    public function __construct()
    {
        $this->base = $_SERVER['REQUEST_URI'];
        $this->uri  = $_REQUEST['uri'] ?? '/';
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
        $this->setData();
 
    }
 
    protected function setData()
    {
        switch($this->method)
        {
            case 'post':
            $this->data = $_POST;
            break;
            case 'get':
            $this->data = $_GET;
            break;
            case 'head':
            case 'put':
            case 'delete':
            case 'options':
            parse_str(file_get_contents('php://input'), $this->data);
        }
    }
 
    public function base()
    {
        return $this->base;
    }
 
    public function uri(){
        return $this->uri;
    }
 
    public function method(){
         
        return $this->method;
    }
 
    public function __isset($key)
    {
        return isset($this->data[$key]);
    }
 
    public function __get($key)
    {
        if(isset($this->data[$key])) 
        {
            return $this->data[$key];
        }
    }
}