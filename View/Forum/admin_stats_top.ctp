<?= $this->Html->css('Forum.billboard.min.css') ?>
<?= $this->Html->script('Forum.d3.v4.min.js'); ?>
<?= $this->Html->script('Forum.billboard.min.js'); ?>
<?= $this->Html->css('Forum.forum-style.css') ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">TITRE</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="chart-bb-spline-topMessage"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    var chart = bb.generate({
        "data": {
            "columns": [
                ["data1", 30, 200, 100, 200, 100]
            ],
            "type": "bar"
        },
        "bar": {
            "width": {
                "ratio": 0.6
            }
        },
        "axis": {
            "rotated": true,
            "x": {
                "type": "category",
                "categories": [
                    "cat1",
                    "cat2",
                    "cat3",
                    "cat2",
                    "cat3"
                ]
            }
        },
        "bindto": "#chart-bb-spline-topMessage"
    });
</script>