<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\ArticleAttachment;
use frontend\models\search\ArticleSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Zend\Feed\Exception\RuntimeException;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $model = Article::find()->published()->andWhere(['slug' => $slug])->one();
        if (!$model) {
            throw new NotFoundHttpException;
        }

        $viewFile = $model->view ?: 'view';
        return $this->render($viewFile, ['model' => $model]);
    }

    /**
     * @param $id
     * @return \yii\console\Response|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\RangeNotSatisfiableHttpException
     */
    public function actionAttachmentDownload($id)
    {
        $model = ArticleAttachment::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException;
        }

        return Yii::$app->response->sendStreamAsFile(
            Yii::$app->fileStorage->getFilesystem()->readStream($model->path),
            $model->name
        );
    }

    /**
     * Show 20 rss news
     * @return string
     */
    public function actionRss()
    {
        try {
            $feed = Yii::$app->feed->reader()->import('https://www.delfi.lv/rss/?channel=delfi');
        } catch (RuntimeException $e) {
            return "error : " . $e->getMessage();
        }
        return $this->render('rss', ['model' => $feed]);
    }
}
