<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            Task Auth
        </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

        <?= $this->fetch('meta') ?>
        <?=$this->Html->script('jQuery-2.2.0.min.js');?>
    </head>
    <body class="bg-white">
        <div id="container" class="container-fluid">
            <nav class="navbar navbar-default ">
            </nav>
            <nav class="navbar navbar-expand-lg  fixed-top navbar-light bg-light">
                <a class="navbar-brand" href="<?= $this->Url->build('/'); ?>">Task-Auth-CakePHP</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="col-12">
                    <?php
                        if(!empty($auth_user)){
                            ?>
                            <div class="dropdown open float-right">
                                <button class="btn btn-light dropdown-toggle"
                                        type="button" id="dropdownMenu1" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <?= $auth_user['name']; ?>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="./logout">Logout</a>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                    </div>
                </div>
            </nav>
            <div class="container-fluid my-5">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>

        </div>

        <?=$this->Html->script('Common/ajax');?>
        <?=$this->Html->script('Common/helper');?>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            var js_webroot = '<?= $this->Url->build('/'); ?>';
            var csrfToken = '<?= $this->request->getAttribute('csrfToken') ?>';
        </script>
    </body>
</html>
