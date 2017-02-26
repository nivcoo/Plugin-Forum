<?= $this->Html->css('Forum.forum-style.css?'.rand(1, 1000000)) ?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<div class="container marge">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center"><?= $Lang->get('FORUM__MYPROFILE'); ?></h1>
            <?= @$this->Session->flash(); ?>
            <form action="" method="post">
                <input name="data[_Token][key]" value="<?= $csrfToken ?>" type="hidden" />
                <div class="forum-forum">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="forum-forum-header">
                                <p class="forum-forum-title"> <i class="fa fa-id-card" aria-hidden="true"></i> <?= $Lang->get('FORUM__DESCRIPTION'); ?></p>
                            </div>
                            <div class="forum-category">
                                <textarea name="description" class="form-control" rows="5"><?= $infos['description']; ?></textarea>
                                <div class="pull-right font-min"> Max 167</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt30">
                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="submit" class="btn btn-theme"><i class="fa fa-share"></i> <?= $Lang->get('FORUM__EDIT__MYPROFILE'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>