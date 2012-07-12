<?php require dirname(__FILE__) . '/header.php';?>

<p>本网页用于确认您的服务器配置是否能满足运行<a href="http://www.yiiframework.com/">Yii</a> Web应用的要求。它将检查服务器所运行的PHP版本，查看是否安装了合适的PHP扩展模块，以及确认php.ini文件是否正确设置。</p>
<h2>检查结果</h2>
<p>
<?php if($result>0):?>
恭喜！您的服务器配置完全符合Yii的要求。
<?php elseif($result<0): ?>
您的服务器配置符合Yii的最低要求。如果您需要使用特定的功能，请关注如下警告。
<?php else: ?>
您的服务器配置未能满足Yii的要求。
<?php endif; ?>
</p>

<h2>具体结果</h2>
<table class="result">
    <tr><th>项目名称</th><th>结果</th><th>使用者</th><th>备注</th></tr>
<?php foreach($requirements as $requirement): ?>
    <tr>
    	<td><?php echo $requirement[0]; ?></td>
    	<td class="<?php echo $requirement[2] ? 'passed' : ($requirement[1] ? 'failed' : 'warning'); ?>">
    	<?php echo $requirement[2] ? '通过' : '未通过'; ?>
    	</td>
    	<td><?php echo $requirement[3];?></td>
    	<td><?php echo $requirement[4];?></td>
    </tr>
<?php endforeach; ?>
</table>

<table>
    <tr>
        <td class="passed">&nbsp;</td><td>通过</td>
        <td class="failed">&nbsp;</td><td>未通过</td>
        <td class="warning">&nbsp;</td><td>警告</td>
    </tr>
</table>
<div class="start-install">
    <a class="beta-btn" href="./index.php?step=1">重新检测</a>
    <a class="beta-btn" href="./index.php?step=2">下一步</a>
</div>


<?php require dirname(__FILE__) . '/footer.php';?>