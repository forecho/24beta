<?php
class BetaCaptcha extends CCaptcha
{
    public $lazy = false;
    
    /**
     * Renders the CAPTCHA image.
     */
    protected function renderImage()
    {
        if(!isset($this->imageOptions['id']))
            $this->imageOptions['id']=$this->getId();
    
        $url=$this->getController()->createUrl($this->captchaAction,array('v'=>uniqid()));
        $alt=isset($this->imageOptions['alt'])?$this->imageOptions['alt']:'';
        if ($this->lazy === true) {
            $this->imageOptions['lazy-src'] = $url;
            echo CHtml::image('javascript:void(0);', $alt, $this->imageOptions);
        }
        else
            echo CHtml::image($url, $alt, $this->imageOptions);
    }
}