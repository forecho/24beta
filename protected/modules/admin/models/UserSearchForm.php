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
    public $state;
    
    public function rules()
    {
        return array(
            array('userid, state', 'numerical', 'integerOnly'=>true),
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
            'state' => t('user_state'),
        );
    }
    
    public function search()
    {
        $criteria = new CDbCriteria();
        $criteria->addColumnCondition(array('t.state' => $this->state));
        if ($this->userid)
            $criteria->addColumnCondition(array('t.id'=>$this->userid));
        
        if ($this->email) {
            if ($this->emailFuzzy)
                $criteria->addSearchCondition('t.email', $this->email);
            else
                $criteria->addColumnCondition(array('t.email'=>$this->email));
        }
        if ($this->name) {
            if ($this->nameFuzzy)
                $criteria->addSearchCondition('t.name', $this->name);
            else
                $criteria->addColumnCondition(array('t.name'=>$this->name));
        }
         
        $data = $criteria->condition ? AdminUser::fetchList($criteria) : null;
        return $data;
    }
}