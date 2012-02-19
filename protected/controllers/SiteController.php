<?php
class SiteController extends Controller
{
    public function actionIndex()
    {
        $data = self::fetchLatestPosts();
        
        $this->setSiteTitle(null);
        $this->setPageKeyWords(param('siteKeywords'));
        $this->setPageDescription(param('siteDescription'));
        $this->render('index', $data);
    }
    
    public function actionLogin()
    {
        if (!user()->getIsGuest()) {
            $returnUrl = strip_tags(trim($_GET['url']));
            if (empty($returnUrl)) $returnUrl = aurl('user/default');
            request()->redirect($returnUrl);
            exit(0);
        }
        
        
        $model = new LoginForm('login');
        if (request()->getIsPostRequest() && isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login())
                ;
            else
                $model->captcha = '';
        }
        else {
            $returnUrl = strip_tags(trim($_GET['url']));
            if (empty($returnUrl))
                $returnUrl = request()->getUrlReferrer();
            if (empty($returnUrl))
                $returnUrl = aurl('user/default');
            $model->returnUrl = urlencode($returnUrl);
        }
        
        $this->render('login', array('form'=>$model));
    }
    
    public function actionSignup()
    {
        if (!user()->getIsGuest()) {
            $this->redirect(aurl('user/default'));
            exit(0);
        }
        
        
        $model = new LoginForm('signup');
        if (request()->getIsPostRequest() && isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->signup())
                ;
            else
                $model->captcha = '';
        }
        $this->render('signup', array('form'=>$model));
    }
    
    public function actionLogout()
    {
        user()->logout();
        user()->clearStates();
        $this->redirect(app()->homeUrl);
    }
    
    public function actionError()
    {
        $error = app()->errorHandler;
    }
    
    private static function fetchLatestPosts()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 't.istop desc, t.create_time desc, t.id desc';
        $criteria->limit = param('postCountOfPage');
        $criteria->scopes = 'published';

        $count = Post::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->setPageSize(param('postCountOfPage'));
        $pages->applyLimit($criteria);
        $posts = Post::model()->with('category', 'topic')->together()->findAll($criteria);

        return array(
            'posts' => $posts,
            'pages' => $pages,
        );
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
    
    public function actionTest()
    {
        /* $p = new Post();
        $p->category_id = 1;
        $p->topic_id = 1;
        $p->title = 'testtest title';
        $p->content = 'test content';
        $p->save();
        echo CHtml::errorSummary($p);
        exit; */
        
        /* $c = new Comment();
        $c->post_id = 782;
        $c->content = 'comment test';
        $c->up_nums = 30;
        $c->save(); */

        $c = Comment::model()->findByPk(9);
        echo $c->delete();

    }

}