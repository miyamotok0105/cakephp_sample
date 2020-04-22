<?php
// src/Controller/ArticlesController.php

namespace App\Controller;

class ArticlesController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // FlashComponent をインクルード
    }

    // www.example.com/articles/index
    public function index()
    {
        $this->loadComponent('Paginator');
        $articles = $this->Paginator->paginate($this->Articles->find());
        // setでテンプレートに自動で描画
        $this->set(compact('articles'));
    }

    // www.example.com/articles/foobar
    public function foobar()
    {
    }

    // Template/Articles/view.ctp
    public function view($slug = null)
    {
        // findBySlugは動的ファインダー
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        $article2 = $this->Articles->findBySlug($slug)->firstOrFail();

        // htmlテンプレで使うオブジェクトを設定
        $this->set(compact('article'));
        $this->set(compact('article2'));
    }

    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            // user_id の決め打ちは一時的なもので、あとで認証を構築する際に削除されます。
            $article->user_id = 1;

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        // タグのリストを取得
        $tags = $this->Articles->Tags->find('list');
        // ビューコンテキストに tags をセット
        $this->set('tags', $tags);

        $this->set('article', $article);
    }

    public function edit($slug)
    {
        $article = $this->Articles
            ->findBySlug($slug)
            // ->contain('Tags') // 関連づけられた Tags を読み込む
            ->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            // patchEntityでエンティティを更新
            $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }
        // タグのリストを取得
        $tags = $this->Articles->Tags->find('list');
        // ビューコンテキストに tags をセット
        $this->set('tags', $tags);

        $this->set('article', $article);
    }

    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The {0} article has been deleted.', $article->title));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function tags()
    {
        // 'pass' キーは CakePHP によって提供され、リクエストに渡された
        // 全ての URL パスセグメントを含みます。
        $tags = $this->request->getParam('pass');
        // ArticlesTable を使用してタグ付きの記事を検索します。
        $articles = $this->Articles->find('tagged', [
            'tags' => $tags
        ]);
        // 変数をビューテンプレートのコンテキストに渡します。
        $this->set([
            'articles' => $articles,
            'tags' => $tags
        ]);
    }

}