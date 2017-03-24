<?= $this->Html->css('Forum.forum-style.css?'.rand(1, 1000000)) ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.3/tinymce.min.js"></script>
<div class="<?= $theme; ?> mt30 marge">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12">
            <?= @$this->Session->flash(); ?>
            <form method="post" action="/<?= $this->request->url ?>">
                <input name="data[_Token][key]" value="<?= $csrfToken ?>" type="hidden" />
                <div class="input-group">
                    <input name="title" class="form-control" placeholder="<?= $Lang->get('FORUM__TITLE__TOPIC'); ?>" />
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default" aria-label="Help" data-toggle="collapse" data-target="#collapseInfo" aria-expanded="false" aria-controls="collapseInfo"><span class="glyphicon glyphicon-question-sign"></span></button>
                    </div>
                </div>
                <div class="collapse mt20" id="collapseInfo">
                    <div class="alert alert-warning" role="alert"><strong><?= $Lang->get('FORUM__WARNING!'); ?></strong> <?= $Lang->get('FORUM__PHRASE__PAGE__ADDTOPIC_1'); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php if($configs['stick']): ?>
                            <div class="checkbox">
                                <label class="checkbox-inline"><input type="checkbox" name="stick" value="stick" /> <?= $Lang->get('FORUM__TOPIC__STICK__ALT'); ?></label>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <?php if($configs['lock']): ?>
                            <div class="checkbox">
                                <label class="checkbox-inline"><input type="checkbox" name="lock" value="lock" /> <?= $Lang->get('FORUM__TOPIC__LOCK__ALT'); ?></label>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group mt20">
                    <script type="text/javascript">
                        tinymce.init({
                            external_plugins: {
                                "emoticons": "/forum/js/plugins/emoticons/plugin.min.js"
                            },
                            selector: "textarea",
                            height : 300,
                            width : '100%',
                            menubar: false,
                            plugins: "textcolor table code image link contextmenu emoticons",
                            toolbar: "fontselect fontsizeselect | styleselect | insert | bold italic underline strikethrough | forecolor backcolort | alignleft aligncenter alignright alignjustifyt | cut copy paste | bullist numlist outdent | emoticons indent blockquote code table"
                        });
                    </script>
                    <textarea id="editor_insert" name="content_insert" cols="30" rows="10"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" id="submit_update" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> <?= $Lang->get('FORUM__SEND__MYTOPIC'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
