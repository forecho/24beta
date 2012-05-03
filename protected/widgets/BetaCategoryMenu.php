<?php
class BetaCategoryMenu extends CWidget
{
    public $showAll = false;
    
    public function init()
    {
        $this->showAll = (bool)$this->showAll;
    }
        
    public function run()
    {
        $rows = $this->fetchCategories();
        if (empty($rows)) return ;
        
        foreach ($rows as $row) {
            $url = aurl('category/posts', array('id'=>(int)$row['id']));
            $html .= '<li>' . l($row['name'], $url) . '</li>';
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

