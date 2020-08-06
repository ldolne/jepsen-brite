<?php $title = 'Admin Dashboard'; ?>

<?php ob_start(); ?>

<main role="main" class="container">

    <div class="row">
        <div class="card col-md-12 pr-1 pl-1">
                    
            <div class="card-header">
                <h2>Jepsen Brite Users</h2>
            </div>

            <ul class="list-group list-group-flush">
                <?php foreach($usersArr as $user)
                    { 
                        if($user['id'] != 51)
                        {?>

                    <li class="list-group-item d-flex justify-content-between">
                        <div class="d-inline-block mb-2 text-primary"><strong><?= $user['username'] ?></strong></div>
                        <div>
                            <a href="./index.php?action=deleteprofile" onclick="if(!confirm('Are you sure you want to delete this account?')) return false;" class="btn-sm btn-danger">Delete this user</a>
                        </div>
                    </li>
                <?php
                        }
                    }
                ?>
            </ul>
        </div>
    </div><!-- /.row -->
</main><!-- /.container -->

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>