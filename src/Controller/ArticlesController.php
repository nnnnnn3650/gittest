<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class ArticlesController extends AppController
{
  public function initialize()
  {
    parent::initialize();

    $this->loadComponent('Flash');
  }

  public function index($username)
  {
    $users = TableRegistry::get('Users');
    $user = $users->find()->where(['username' => $username])->first();
    $this->set('articles', $this->Articles->find('all',
                  ['conditions' => ['user_id' => $user->id]]));
    $this->set('username', $username);
  }

  public function view($id)
  {
    $article = $this->Articles->get($id);
    $this->set(compact('article'));
  }

  public function add()
  {
    $article = $this->Articles->newEntity();
    if ($this->request->is('post')) {
      $article = $this->Articles->patchEntity($article, $this->request->data);
      $article->user_id = $this->Auth->user('id');
      if ($this->Articles->save($article)) {
        $this->Flash->success(__('Your article has been saved.'));
        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('Unabel to add your article.'));
    }
    $this->set('article', $article);

    $categories = $this->Articles->Categories->find('treeList');
    $this->set(compact('categories'));
  }

  public function edit($id = null)
  {
    $article = $this->Articles->get($id);
    if ($this->request->is(['post', 'put'])) {
      $this->Articles->patchEntity($article, $this->request->data);
      if ($this->Articles->save($article)) {
        $this->Flash->success(__('Your article has been updated.'));
        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('Unable to update your article.'));
    }
    $this->set('article', $article);

    $categories = $this->Articles->Categories->find('treeList');
    $this->set(compact('categories'));
  }

  public function delete($id)
  {
    $this->request->allowMethod(['post', 'delete']);

    $article = $this->Articles->get($id);
    if ($this->Articles->delete($article)) {
      $this->Flash->success(__('The article with id: {0} has been deleted.', h($id)));
      return $this->redirect(['action' => 'index']);
    }
  }

  public function isAuthorized($user)
  {
    if ($this->request->action === 'add') {
      return true;
    }

    if (in_array($this->request->action, ['edit', 'delete'])) {
      $articleId = (int)$this->request->params['pass'][0];
      if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
        return true;
      }
    }

    return parent::isAuthorized($user);
  }
}
?>
