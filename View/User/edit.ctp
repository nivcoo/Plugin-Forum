<?= $this->Html->css('Forum.forum-style.css?'.rand(1, 1000000)) ?>
<div class="container marge">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center">Mon profil forum</h1>
            <?= @$this->Session->flash(); ?>
            <form action="" method="post">
                <input name="data[_Token][key]" value="<?= $csrfToken ?>" type="hidden" />
                <div class="forum-forum">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="forum-forum-header">
                                <p class="forum-forum-title"> <i class="fa fa-address-card-o" aria-hidden="true"></i> Description</p>
                            </div>
                            <div class="forum-category">
                                <textarea name="description" class="form-control" rows="5"><?= $infos['description']; ?></textarea>
                                <div class="pull-right" style="font-size: 10px"> Max 167</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt30">
                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="submit" class="btn btn-theme"><i class="fa fa-share"></i> Envoyer</button>
                        </div>
                    </div>
                </div>
        </div>
            </form>
    </div>
</div>