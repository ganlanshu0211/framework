<?php
/**
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2015, iBenchu.com
 */
namespace Notadd\Article\Controllers;
use Notadd\Article\Article;
use Notadd\Article\Events\OnArticleShow;
use Notadd\Foundation\Routing\Controller;
class ArticleController extends Controller {
    /**
     * @param type $id
     */
    public function show($id) {
        $article = new Article($id);
        $this->app->make('events')->fire(new OnArticleShow($this->app, $this->view, $article));
        $this->share('title', $article->getTitle());
        $this->share('content', $article->getContent());
        $this->share('category', $article->getCategory());
        $this->share('relations', $article->getCategory()->getRelationCategoryList());
        return $this->view($article->getShowTemplate());
    }
}