<!-- File: src/Template/Articles/index.ctp -->

<h1>Blog articles</h1>
<?php if ($this->request->session()->read('Auth.User.username') === $username): ?>
  <?= $this->Html->link('Add Article', ['action' => 'add']); ?>
<?php endif; ?>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Created</th>
    </tr>

    <!-- ここから、$articlesのクエリオブジェクトをループして、投稿記事の情報を表示 -->
    <?php foreach ($articles as $article): ?>
    <tr>
        <td><?= $article->id ?></td>
        <td>
            <?= $this->Html->link($article->title, ['action' => 'view', $article->id]) ?>
        </td>
        <td>
            <?= $article->created->format(DATE_RFC850); ?>
        </td>
        <?php if ($this->request->session()->read('Auth.User.username') === $username): ?>
          <td>
              <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $article->id],
                ['confirm' => 'Are you sure?']
              )?>
              <?= $this->Html->link('Edit', ['action' => 'edit', $article->id])?>
          </td>
        <?php endif;?>
    </tr>
    <?php endforeach; ?>
</table>
