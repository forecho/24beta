<div class="hero-unit">
    <h2>欢迎使用<?php echo app()->name;?>管理中心</h2>
    <p><?php echo date('Y-m-d H:i:s');?></p>
    <p>
        现在有&nbsp;<b><?php echo $unVerifyCount;?></b>&nbsp;个投稿未处理。
        <a class="btn btn-primary btn-small" href="<?php echo url('admin/post/verify');?>">查看最新投稿</a>
    </p>
</div>