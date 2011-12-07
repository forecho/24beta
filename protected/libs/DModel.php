<?php
class DModel
{
    private $_data;
    
    public function __construct(array $data)
    {
        $this->setData($data);
    }
    
    protected function afterConstruct()
    {
    }
    
    public function setData($data)
    {
        if (!is_array($data))
            throw new CDbException('$data参数必须为数组');
            
        $this->_data = $data;
    }
    public function getData()
    {
        return $this->_data;
    }
    

    public function __set($var, $value)
    {
        $this->$var = $value;
    }
    
    public function __get($val)
    {
        $method = 'get' . ucfirst(strtolower($val));
        return $this->$method();
    }
    
    public function __isset($var)
    {
    	return isset($this->$var);
    }
    
    public function  __unset($var)
    {
    	unset($this->$var);
    }
    
    
}