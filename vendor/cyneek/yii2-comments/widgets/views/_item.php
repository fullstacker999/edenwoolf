<?php
use yii\helpers\Html;

/* @var $model \cyneek\comments\models\CommentModel */
/* @var $this \yii\web\View */
/* @var $widget \cyneek\comments\widgets\Comment */
?>
<li class="comment" id="comment-<?php echo $model->id ?>">
    <div class="comment-content" data-comment-content-id="<?php echo $model->id ?>">
        <div class="comment-author-avatar">
            <?php echo $model->getAvatar(['alt' => $model->getAuthorName()]); ?>
        </div>
        <div class="comment-details">
            <?php if ($model->isActive && !Yii::$app->user->isGuest): ?>
                <div class="comment-action-buttons">
                    <span class="likes-num">
                        <?php echo $model->likes == NULL ? "": $model->likes." likes" ?>
                    </span>
                    <?php if ($model->createdBy != Yii::$app->getUser()->id): ?>
                        <?php echo Html::a('<span class="glyphicon glyphicon-thumbs-up"></span> ' . Yii::t('app', 'Like'), '#', ['data' => ['action' => 'like', 'url' => \yii\helpers\Url::to(['/comment/default/like', 'id' => $model->id]), 'comment-id' => $model->id]]); ?>
                    <?php endif; ?>
                    <?php if (($model->canCreate() && ($model->createdBy != Yii::$app->getUser()->id)) && (($model->level < $widget->maxLevel || is_null($widget->maxLevel)) || $widget->nestedBehavior == FALSE)): ?>
                        <?php echo Html::a('<span class="glyphicon glyphicon-share-alt"></span> ' . Yii::t('app', 'Reply'), '#', ['class' => 'comment-reply', 'data' => ['action' => 'reply', 'comment-id' => $model->id]]); ?>
                    <?php endif; ?>
                    <?php if ($model->createdBy != Yii::$app->getUser()->id): ?>
                        <?php echo Html::a('<span class="glyphicon glyphicon-ban-circle"></span> ' . Yii::t('app', 'Report'), '#', ['data' => ['action' => 'report', 'url' => \yii\helpers\Url::to(['/comment/default/report', 'id' => $model->id]), 'comment-id' => $model->id]]); ?>
                    <?php endif; ?>
                    <?php if ($model->canUpdate()): ?>
                        <?php echo Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('app', 'Edit'), '#', ['class' => 'comment-edit', 'data' => ['action' => 'edit', 'comment-id' => $model->id]]); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="comment-author-name">
                <span><?php echo $model->getAuthorName(); ?></span>
                        <span class="comment-date">
                            <?php echo $model->getPostedDate(); ?>
                        </span>
            </div>
            <div class="comment-body">
                <?php echo $model->getContent(); ?>
            </div>
            <?php if ($model->canUpdate()): ?>
                <div class="comment-body-edit">
                    <?php echo $this->render('_form', ['commentModel' => $model, 'widget' => $widget]); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($widget->nestedBehavior == TRUE && $model->hasChildren()): ?>
        <ul class="children">
            <?php
            $provider = new \yii\data\ArrayDataProvider([
                'allModels' => $model->children,
                'sort' => $widget->sort
            ]);
            echo $this->render('_list', ['provider' => $provider, 'widget' =>  $widget]);
            ?>
        </ul>
    <?php endif; ?>
</li>
