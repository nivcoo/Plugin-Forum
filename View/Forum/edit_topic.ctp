<?= $this->Html->css('Forum.forum-style.css?'.rand(1, 1000000)) ?>
<?= $this->Html->css('Forum.custom.css') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.3/tinymce.min.js"></script>

<div class="background-forum">
    <div class="<?= $theme; ?> marge">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="<?= $this->Html->url('/'.$this->request->url); ?>">
                    <input name="data[_Token][key]" value="<?= $csrfToken ?>" type="hidden" />
                    <div class="form-group mt20">
                        <script type="text/javascript">
                            tinymce.init({
                                external_plugins: {
                                    "emoticons": "<?= $this->Html->url('/forum/js/plugins/emoticons/plugin.min.js'); ?>"
                                },
                                selector: "textarea",
                                height : 400,
                                width : '100%',
                                menubar: false,
                                plugins: "textcolor table code image link contextmenu emoticons",
                                toolbar: "fontselect fontsizeselect | styleselect | insert | bold italic underline strikethrough | forecolor backcolort | alignleft aligncenter alignright alignjustifyt | cut copy paste | bullist numlist outdent | emoticons indent blockquote code table"
                            });
                        </script>
                        <textarea id="editor" name="content" cols="30" rows="7"><?= $content['content']; ?></textarea>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn-theme btn-themehover"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?= $Lang->get('FORUM__EDIT__MYMSG'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>