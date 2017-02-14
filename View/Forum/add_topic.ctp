<?= $this->Html->css('Forum.forum-style.css?'.rand(1, 1000000)) ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.3/tinymce.min.js"></script>
<div class="container mt30 marge">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12">
            <?= @$this->Session->flash(); ?>
            <form method="post" action="/<?= $this->request->url ?>/<?= $idParent; ?>">
                <input name="data[_Token][key]" value="<?= $csrfToken ?>" type="hidden" />
                <input name="title" class="form-control" placeholder="Titre du topic" />
                <div class="row">
                    <div class="col-md-6">
                        <?php if($configs['stick']): ?>
                            <div class="checkbox">
                                <label class="checkbox-inline"><input type="checkbox" name="stick" value="stick" /> Epingler le topic</label>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <?php if($configs['lock']): ?>
                            <div class="checkbox">
                                <label class="checkbox-inline"><input type="checkbox" name="lock" value="lock" /> Empecher l'ajout de réponse</label>
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
                    <button type="submit" id="submit_update" class="btn btn-primary">Publier mon topic</button>
                </div>
            </form>
        </div>
    </div>
</div>
