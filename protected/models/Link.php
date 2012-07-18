<?php

/**
 * This is the model class for table "{{link}}".
 *
 * The followings are the available columns in table '{{link}}':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $logo
 * @property string $desc
 * @property integer $orderid
 * @property string $nameLink
 * @property string $logoLink
 */
class Link extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Link the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return TABLE_LINK;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
    		array('orderid', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('url, logo, desc', 'length', 'max'=>250),
    		array('url, logo', 'url'),
		    array('name, url', 'required'),
		    array('name, url', 'unique'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => t('link_name'),
			'url' => t('link_url'),
			'logo' => t('link_logo'),
			'desc' => t('link_desc'),
			'orderid' => t('orderid'),
		);
	}
	
	public function getNameLink($target = '_blank')
	{
	    $html = '';
	    if ($this->name && $this->url)
	        $html = l($this->name, $this->url, array('class'=>'beta-link-item', 'target'=>$target, 'title'=>$this->desc));
	    
	    return $html;
	}
	
	public function getLogoLink($target = '_blank')
	{
	    $html = '';
	    if ($this->logo && $this->url) {
	        $image = image($this->logo, $this->name, array('class'=>'link-logo'));
	        $html = l($image, $this->url, array('class'=>'beta-link-item', 'target'=>$target, 'title'=>$this->desc));
	    }
	    
	    return $html;
	}
	
	public function getUrlValid()
	{
	    $pos = strpos($this->url, 'http://');
	    return $pos === 0;
	}
	
	public function getLogoValid()
	{
	    $pos = strpos($this->logo, 'http://');
	    return $pos === 0;
	}

}