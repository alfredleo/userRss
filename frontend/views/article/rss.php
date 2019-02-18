<?php
/* @var $this yii\web\View */
/* @var $model Zend\Feed\Reader\Feed\FeedInterface */
/* @var $feed Zend\Feed\Reader\Entry\Rss */
$this->title = 'RSS view';
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Rss'), 'url' => ['rss']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <article class="article-item">
        <h1><?php echo $model->getTitle() ?></h1>
        <a><?php echo $model->getLink() ?></a>
        <p><?php echo $model->getDescription() ?></p>
        <p><img src="<?php echo $model->getImage()['uri']; ?>" alt="main image"></p>

        <?php if (!empty($model)): ?>
            <h3><?php echo Yii::t('frontend', 'Entries') ?></h3>
            <ul>
                <?php foreach ($model as $feed): ?>
                    <li>
                        <p><?= $feed->getDescription(); ?></p>
                        <?php if (method_exists($feed, 'getMedia')) : ?>
                            <p><img src="<?php echo $feed->getMedia()->url; ?>" alt="feed image"></p>
                        <?php endif; ?>
                        <a href="<?= $feed->getLink(); ?>"><?= $feed->getTitle(); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    </article>
</div>