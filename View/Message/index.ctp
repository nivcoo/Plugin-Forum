<?= $this->Html->css('Forum.forum-style.css?'.rand(1, 1000000)) ?>
<div class="container">
    <div class="mt10">
        <div class="row">
            <div class="col-md-9">

            </div>
            <div class="col-md-3">
                <a href="/message/new" class="btn btn-theme mt30"><i class="fa fa-plus" aria-hidden="true"></i> <?= $Lang->get('FORUM__WRITE__MSG'); ?></a>
            </div>
        </div>
        <div class="row mt20">
            <div class="col-md-12">
                <div id="easyPaginate">
                    <?php if(!empty($mps)): ?>
                        <?php foreach ($mps as $mp): ?>
                            <div class="forum-bloc p10">
                                <div class="row">
                                    <div class="forum-category-icone col-xs-2 col-md-1 text-center">
                                        <?php if(!$mp['Conversation']['read']): ?>
                                            <i class="fa fa-envelope-open forum-category-fa" aria-hidden="true"></i>
                                        <?php else: ?>
                                            <i class="fa fa-envelope forum-category-fa" aria-hidden="true"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-xs-7 col-md-7 col-sm-6">
                                        <h3 class="forum-category-title"><a href="/message/<?= $this->requestAction('Forum/replaceSpace/'.$mp['Conversation']['title'], ['plugin' => 'forum']); ?>.<?= $mp['Conversation']['id_conversation']; ?>/"><?= $mp['Conversation']['title']; ?></a></h3>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-3 hidden-mob forum-category-last">
                                        De : <?= $mp['Conversation']['user']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script('Forum.easy_paginate.js?'.rand(1, 1000000)) ?>
<script>
    $('#easyPaginate').easyPaginate({
        paginateElement: 'div',
        step:10,
    });
</script>