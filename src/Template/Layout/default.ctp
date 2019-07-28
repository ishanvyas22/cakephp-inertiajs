<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>

    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>

    <?= $this->Html->script('InertiaCake.dist/app.js', ['type' => 'module']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <?= $this->Inertia->make($page, 'app', 'container clearfix') ?>
</body>
</html>
