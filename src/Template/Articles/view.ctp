<!-- File: src/Template/Articles/view.ctp -->

<h1><?= h($article->title) ?></h1>
<p><?= h($article->body) ?></p>
<p><small>Created: <?= $article->created->format(DATE_RFC850) ?></small></p>

<?php if ($comments): ?>
この記事へのコメント
<?php endif; ?>
<?php foreach ($comments as $comment): ?>
<div>
  <p><small><?= h($comment->name); ?></small></p>
  <p><?= h($comment->content); ?></p>
</div>
<?php endforeach;?>

<?= $this->Form->create(); ?>
<?= $this->Form->input('name'); ?>
<?= $this->Form->input('content', ['type' => 'text']); ?>
<?= $this->Form->end(); ?>
