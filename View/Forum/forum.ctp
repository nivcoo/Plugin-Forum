<?= $this->Html->css('Forum.forum-style.css?'.rand(1, 1000000)) ?>
<div class="container marge">
    <div class="row">
        <div class="col-md-10">
            <ol class="forum-breadcrumb">
                <li class="forum-breadcrumb-home">
                    <a href="/forum"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="forum-breadcrumb-child">
                    <!-- TODO : bug here -->
                    <?= $parent['forum_parent']['name']; ?>
                </li>
            </ol>
        </div>
        <div class="col-md-2">
            <a href="/topic/add/<?= $id; ?>" class="btn btn-theme mt30">Créer un topic</a>
        </div>
        <?= @$this->Session->flash(); ?>
    </div>

    <div class="forum-forum">
        <div class="forum-forum-header">
            <p class="forum-forum-title"> <?= $slug; ?></p>
        </div>
        <?php foreach ($forums as $f => $forum): ?>
            <div class="forum-category">
                <div class="row">
                    <div class="forum-category-icone col-xs-2 col-md-1 text-center">
                        <?php if(filter_var($forum['Forum']['forum_image'], FILTER_VALIDATE_URL)): ?>
                            <img src="<?= $forum['Forum']['forum_image']; ?>" class="forum-category-icon" alt="" />
                        <?php else: ?>
                            <i class="fa fa-<?= $forum['Forum']['forum_image']; ?> forum-category-fa" aria-hidden="true"></i>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-7 col-md-7 col-sm-6">
                        <h3 class="forum-category-title"><a href="/forum/<?= $this->requestAction('Forum/replaceSpace/'.$forum['Forum']['forum_name']); ?>.<?= $forum['Forum']['id']; ?>/"><?= $forum['Forum']['forum_name']; ?></a></h3>
                        <div class="forum-category-description"><span>Discussions :</span> <?= $forum['Forum']['nb_discussion']; ?> <span>Message :</span> <?= $forum['Forum']['nb_message']; ?></div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-3 hidden-mob forum-category-last">
                        <a href="/forum/<?= $this->requestAction('Forum/replaceSpace/'.$forum['Forum']['forum_last_title']); ?>.<?= $forum['Forum']['forum_last_id']; ?>/"><?= $forum['Forum']['forum_last_title']; ?></a><br/>
                        <a style="color:#<?= $forum['Forum']['forum_last_author_color']; ?>" href="/user/<?= $forum['Forum']['forum_last_author']; ?>.<?= $forum['Forum']['forum_last_authorid']; ?>/"><?= $forum['Forum']['forum_last_author']; ?></a>, <?= $forum['Forum']['forum_last_date']; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if(!empty($forums)): ?>
        <div class="forum-separator"><i class="fa fa-bell-o" aria-hidden="true"></i> Topics épinglés</div>
        <?php endif; ?>
        <?php foreach ($topics_stick as $topic_stick): ?>
            <div class="forum-category">
                <div class="row">
                    <div class="forum-category-icone col-xs-2 col-md-1 text-center">
                        <i class="fa fa-comment forum-category-fa" aria-hidden="true"></i>
                    </div>
                    <div class="col-xs-7 col-md-5 col-sm-6">
                        <h3 class="forum-category-title"><a href="/topic/<?= $this->requestAction('Forum/replaceSpace/'.$topic_stick['Topic']['name']); ?>.<?= $topic_stick['Topic']['id']; ?>/"><?= $topic_stick['Topic']['name']; ?></a></h3>
                        <div class="forum-category-description"><a href="/user/<?= $topic_stick['Topic']['author']; ?>.<?= $topic_stick['Topic']['id_user']; ?>/"><?= $topic_stick['Topic']['author']; ?></a>, <?= $topic_stick['Topic']['date']; ?></div>
                    </div>
                    <div class="hidden-mob col-md-2 forum-category-last">
                        <div class="forum-category-description"><span>Message :</span> <?= $topic_stick['Topic']['nb_message']; ?></div>
                        <div class="forum-category-description"><span>View :</span> <?= $topic_stick['Topic']['total_view']; ?></div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-3 hidden-mob forum-category-last">
                        <a style="color:#<?= $topic_stick['Topic']['topic_last_author_color']; ?>" href="/user/<?= $topic_stick['Topic']['forum_last_author']; ?>.<?= $topic_stick['Topic']['forum_last_authorid']; ?>/"><?= $topic_stick['Topic']['forum_last_author']; ?></a>, <?= $topic_stick['Topic']['forum_last_date']; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if(!empty($topics_stick) && !empty($topics)): ?>
            <div class="forum-separator">Topics</div>
        <?php endif; ?>
        <div id="easyPaginate">
            <?php foreach ($topics as $topic): ?>
                <div class="forum-category">
                    <div class="row">
                        <div class="forum-category-icone col-xs-2 col-md-1 text-center">
                            <i class="fa fa-comment forum-category-fa" aria-hidden="true"></i>
                        </div>
                        <div class="col-xs-7 col-md-5 col-sm-6">
                            <h3 class="forum-category-title"><a href="/topic/<?= $this->requestAction('Forum/replaceSpace/'.$topic['Topic']['name']); ?>.<?= $topic['Topic']['id']; ?>/"><?= $topic['Topic']['name']; ?></a></h3>
                            <div class="forum-category-description"><a href="/user/<?= $topic['Topic']['author']; ?>.<?= $topic['Topic']['id_user']; ?>/"><?= $topic['Topic']['author']; ?></a>, <?= $topic['Topic']['date']; ?></div>
                        </div>
                        <div class="hidden-mob col-md-2 forum-category-last">
                            <div class="forum-category-description"><span>Message :</span> <?= $topic['Topic']['nb_message']; ?></div>
                            <div class="forum-category-description"><span>View :</span> <?= $topic['Topic']['total_view']; ?></div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-3 hidden-mob forum-category-last">
                            <a style="color:#<?= $topic['Topic']['topic_last_author_color']; ?>" href="/user/<?= $topic['Topic']['forum_last_author']; ?>.<?= $topic['Topic']['forum_last_authorid']; ?>/"><?= $topic['Topic']['forum_last_author']; ?></a>, <?= $topic['Topic']['forum_last_date']; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
            <div class="col-md-2">
                <a href="/topic/add/<?= $id; ?>" class="btn btn-theme mt30">Créer un topic</a>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script('Forum.easy_paginate.js?'.rand(1, 1000000)) ?>
<script>
    $('#easyPaginate').easyPaginate({
        paginateElement: 'div',
        step:20,
    });
</script>