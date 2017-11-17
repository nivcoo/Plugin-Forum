<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_general" data-toggle="tab">Général</a></li>
                    <li><a href="#tab_forum" data-toggle="tab">Forum</a></li>
                    <!--<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>-->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_general">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="tab_general accordion" class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Arrière plan</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12" id="dropdown">
                                                <?php echo $this->Form->create(false, ['type' => 'post', 'data-ajax' => 'true']); ?>
                                                <div class="radio">
                                                    <input type="radio" name="[background]" value="[background][none]" />
                                                    <label>De base</label>
                                                </div>

                                                <div class="radio">
                                                    <input type="radio" name="[background]" id="background-color" value="[background][color]" />
                                                    <label>Couleur</label>
                                                </div>
                                                <div id="type-dropdown" class="hidden">
                                                    <div class="form-group">
                                                        <label>Couleur</label>
                                                        <input type="text" class="form-control" name="[background][color]" placeholder="#b2b2b2" />
                                                    </div>
                                                </div>

                                                <div class="radio">
                                                    <input type="radio" name="[background]" id="background-image" value="[background][image]" />
                                                    <label>Image</label>
                                                </div>
                                                <div id="type-dropdown2" class="hidden">
                                                    <div class="form-group">
                                                        <label>Url</label>
                                                        <input type="text" class="form-control" name="[background][image]" placeholder="https://images.unsplash.com/photo-1420768255295-e871cbf6eb81" />
                                                    </div>
                                                </div>
                                                <?php echo $this->Form->end(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="tab_general accordion" class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Gestion des descriptions</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo $this->Form->create(false, ['type' => 'post', 'data-ajax' => 'true']); ?>
                                                <div class="radio">
                                                    <input type="radio" name="[description]" value="[description][base]" />
                                                    <label>Normal (A droite du titre)</label>
                                                </div>
                                                <div class="radio">
                                                    <input type="radio" name="[description]" value="[description][tooltip]" />
                                                    <label>Toopltip (Nécessite un passage de la souris)</label>
                                                </div>
                                                <?php echo $this->Form->end(); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $("#dropdown").change(function () {
        if ($("#background-color").is(':checked')) {
            $("#type-dropdown").removeClass('hidden');
        } else {
            $("#type-dropdown").addClass('hidden');
        }
        if ($("#background-image").is(':checked')) {
            $("#type-dropdown2").removeClass('hidden');
        } else {
            $("#type-dropdown2").addClass('hidden');
        }
    });
</script>