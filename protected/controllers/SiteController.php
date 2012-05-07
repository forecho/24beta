<?php
class SiteController extends Controller
{
    public function actionIndex()
    {
        $data = self::fetchLatestPosts();
        $data['hottest'] = self::fetchHottestPosts();
        $data['recommend'] = self::fetchRecommendPosts();
        $data['comments'] = self::fetchRecommendComments();
        
        $this->setSiteTitle(null);
        $this->setPageKeyWords(param('site_keywords'));
        $this->setPageDescription(param('site_description'));
        
        cs()->registerMetaTag('all', 'robots');
        
        
        $this->render('index', $data);
    }
    
    private static function fetchHottestPosts()
    {
        $criteria = new CDbCriteria();
        $criteria->select = array('t.id', 't.title', 't.thumbnail', 't.state', 't.hottest');
        $criteria->limit = 4;
        $criteria->scopes = array('hottest', 'published');
        $models = Post::model()->findAll($criteria);
        
        return (array)$models;
    }
    
    private static function fetchRecommendPosts()
    {
        $criteria = new CDbCriteria();
        $criteria->select = array('t.id', 't.title', 't.thumbnail', 't.state', 't.recommend', 't.summary', 't.content');
        $criteria->limit = param('recommendPostsCount');
        $criteria->scopes = array('recommend', 'published');
        $models = Post::model()->findAll($criteria);
        
        return (array)$models;
    }
    
    private static function fetchRecommendComments()
    {
        $criteria = new CDbCriteria();
        $criteria->select = array('t.id', 't.content', 't.create_time', 't.user_id', 't.user_name', 't.post_id');
        $criteria->limit = param('recommendCommentsCount');
        $criteria->scopes = array('recommend', 'published');
        $criteria->with = array('post'=>array('select'=>'id, title'));
        $models = Comment::model()->findAll($criteria);
        
        return $models;
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
        
        cs()->registerMetaTag('noindex, follow', 'robots');
        $this->setSiteTitle(t('site_login'));
        
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
        
        cs()->registerMetaTag('noindex, follow', 'robots');
        $this->setSiteTitle(t('site_signup'));
        
        $this->render('signup', array('form'=>$model));
    }
    
    public function actionLogout()
    {
        user()->logout();
        user()->clearStates();
        app()->session->clear();
        app()->session->destroy();
        $this->redirect(app()->homeUrl);
    }
    
    private static function fetchLatestPosts()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 't.istop desc, t.create_time desc';
        $criteria->limit = param('postCountOfPage');
        $criteria->scopes = array('homeshow', 'published');

        $count = Post::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->setPageSize(param('postCountOfPage'));
        $pages->applyLimit($criteria);
        $posts = Post::model()->findAll($criteria);

        return array(
            'posts' => $posts,
            'pages' => $pages,
        );
    }
    
    public function actionTop()
    {
        exit;
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
        phpinfo();
        exit;
        
        $auth=Yii::app()->authManager;
        $auth->createOperation('create_post','create a post');
        $auth->createOperation('update_post','update a post');
        $auth->createOperation('delete_post','delete a post');
        $auth->createOperation('enter_admin_system','login into admin system');
        $auth->createOperation('upload_file','upload a file');
        $auth->createOperation('create_post_in_home','create post in home page');

        $bizRule='return Yii::app()->user->id==$params["post"]->user_id;';
        $task=$auth->createTask('update_own_post','update a post by author himself',$bizRule);
        $task->addChild('update_post');
         
        $role=$auth->createRole('author');
        $role->addChild('create_post');
        $role->addChild('update_own_post');
        $role->addChild('upload_file');
         
        $role=$auth->createRole('editor');
        $role->addChild('update_post');
        $role->addChild('enter_admin_system');
        $role->addChild('author');

        $role=$auth->createRole('chief_editor');
        $role->addChild('editor');
        
        $role=$auth->createRole('admin');
        $role->addChild('chief_editor');
        $role->addChild('delete_post');
         
        $auth->assign('admin','1');
        

    }


    public function actionError()
    {
        $error = app()->errorHandler->error;;
        if ($error) {
            $this->setPageTitle('Error ' . $error['code']);
            $this->render('/system/error', $error);
        }
    }
}

