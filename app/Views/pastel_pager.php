<?php $pager->setSurroundCount(2) ?>

<nav>
    <?php if ($pager->hasPrevious()): ?>
        <a href="<?= $pager->getPrevious() ?>">← Prev</a>
    <?php endif; ?>

    <?php foreach ($pager->links() as $link): ?>
        <?php if ($link['active']): ?>
            <span><?= $link['title'] ?></span>
        <?php else: ?>
            <a href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if ($pager->hasNext()): ?>
        <a href="<?= $pager->getNext() ?>">Next →</a>
    <?php endif; ?>
</nav>
