<?php
class UserSearchForm extends CFormModel
{
    public $userid;
    public $email;
    public $name;
    public $createTime;
    public $createIp;
    public $emailFuzzy;
    public $nameFuzzy;
    
    public function rules()
    {
        return array(
            array('userid', 'numerical', 'integerOnly'=>true),
            array('email, name', 'filter', 'filter'=>'trim'),
            array('emailFuzzy, nameFuzzy', 'in', 'range'=>array(BETA_YES, BETA_NO)),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'userid' => t('userid', 'admin'),
            'email' => t('user_email'),
            'name' => t('user_name'),
            'createTime' => t('create_time'),
            'createIp' => t('create_ip'),
        );
    }
    
    public function search()
    {
        $criteria = new CDbCriteria();
        if ($this->userid)
            $criteria->addColumnCondition(array('id'=>$this->userid));
        
        if ($this->email) {
            if ($this->emailFuzzy)
                $criteria->addSearchCondition('email', $this->email);
            else
                $criteria->addColumnCondition(array('email'=>$this->email));
        }
        if ($this->name) {
            if ($this->nameFuzzy)
                $criteria->addSearchCondition('name', $this->name);
            else
                $criteria->addColumnCondition(array('name'=>$this->name));
        }
         
        $data = $criteria->condition ? AdminUser::fetchList($criteria) : null;
        return $data;
    }
}