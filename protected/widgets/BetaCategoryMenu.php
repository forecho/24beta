<?php
class BetaCategoryMenu extends CWidget
{
    public $showAll = false;
    public $channel = 0;
    
    public function init()
    {
        $this->showAll = (bool)$this->showAll;
    }
        
    public function run()
    {
        $rows = $this->fetchCategories();
        if (empty($rows)) return ;
        
        foreach ($rows as $row) {
            $id = (int)$row['id'];
            $url = aurl('category/posts', array('id'=>$id));
            $htmlOptions = ($id == $this->channel) ? array('class'=>'active') : array();
            $html .= '<li>' . l($row['name'], $url, $htmlOptions) . '</li>';
        }
        echo $html;
    }
    
    private function fetchCategories()
    {
        $cmd = app()->getDb()->createCommand()
            ->select(array('id', 'name'))
            ->from(TABLE_CATEGORY)
            ->order(array('orderid desc', 'id desc'));
        
        if (!$this->showAll)
            $cmd->where('state = :showInNav', array(':showInNav' => Category::STATE_SHOW_IN_NAV_MENU));
        
        $rows = $cmd->queryAll();
        return $rows;
    }
}

