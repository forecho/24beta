<?php

/**
 * This is the model class for table "{{filter_keyword}}".
 *
 * The followings are the available columns in table '{{config}}':
 * @property integer $id
 * @property string $keyword
 * @property string $replace
 */
class FilterKeyword extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FilterKeyword the static model class
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
		return TABLE_FILTER_KEYWORD;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
	        array('keyword', 'required'),
	        array('keyword', 'unique'),
			array('keyword, replace', 'length', 'max'=>50),
			array('replace', 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
	        'keyword' => t('filter_keyword'),
			'replace' => t('filter_replace'),
		);
	}

    public static function fetchAllArray()
    {
        $cmd = app()->getDb()->createCommand()
            ->from(TABLE_FILTER_KEYWORD)
            ->order('id asc');
        
        $rows = $cmd->queryAll();
        
        return $rows;
    }
    
    public static function updateCacheFile()
    {
        $rows = app()->getDb()->createCommand()
            ->select(array('keyword', 'replace'))
            ->from(TABLE_FILTER_KEYWORD)
            ->queryAll();
        
        if (empty($rows)) return true;
        
        foreach ($rows as $index => $row) {
            $pattern = '/\{(\d+)\}/is';
            $replacement = '.{0,$1}?';
            $rows[$index]['keyword'] = preg_replace($pattern, $replacement, $row['keyword']);
        }
        
        $rows = CHtml::listData($rows, 'keyword', 'replace');
        $data = "<?php\nreturn " . var_export($rows, true) . ';';
        $filename = dp('filter_keywords.php');
        
        return file_put_contents($filename, $data);
    }
}

