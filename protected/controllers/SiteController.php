<?php
class SiteController extends Controller
{
    public function actionIndex()
    {
        echo __FILE__;
        echo $this->createAbsoluteUrl('site/aaa');
    }
    
    public function actionAaa()
    {
        $this->render('aaa', array('data'=>time()));
        print_r(app()->params['abc']);
        
        echo Cdc::t('cdc', 'asdfasdf{aa}sadf{cccc}', array('{aa}'=>111111, '{cccc}'=>22222));
        echo '<hr />';
        
        $d = new CDbCriteria();
        $d->select = 'a,b,c';
        $d->addBetweenCondition('a', 100, 500);
        echo (string)$d->condition;
    }
    
    public function actionTop()
    {
        //CdTopApi::debug();
        $api_key = '12228873';
        $api_secret = '226deeb654bf7c233cb8e06886d7dd7d';
        $sandbox_secret = 'sandbox654bf7c233cb8e06886d7dd7d';
        $client = new CdTopApi($api_key, $api_secret, $sandbox_secret);
        $data = $client->method('taobao.taobaoke.items.get')
            ->add_args('fields', 'num_iid,title,nick,pic_url,price,click_url,commission,commission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume')
            ->add_args('nick', 'cdcchencdc')
            ->add_args('cid', '50006843')
            ->request()->data();
        print_r($client->error());
        print_r($data);
    }

}