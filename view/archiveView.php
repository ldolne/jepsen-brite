<?php $title = 'Past events'; ?>

<?php ob_start(); ?>

<main role="main" class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Event</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Hour
                    </th>
                    <th>
                        Type
                    </th>
                    <th>See more ...</th>
                </tr>
                </thead>
                <tbody>
                <?php

                while ($data = $events->fetch()) {
                    ?>
                    <tr>
                        <td style="color: white;">
                            <?= htmlspecialchars_decode(html_entity_decode($data['title'])); ?>
                        </td>
                        <td>
                            <?= $data['event_date_formatted'] ?>
                        </td>
                        <td>
                            <?= $data['event_hour_formatted'] ?>
                        </td>
                        <td> <?= $data['category'] ?></td>
                        <td><a href="./index.php?action=showEvent&amp;id=<?= $data['id'] ?>"><button class="btn btn-light"><div style="color: #ff0060;">See this event<div></button></a></td>
                    </tr>
                <?php }
                $events->closeCursor(); ?>
                </tbody>
            </table>
        </div>
    </div><!-- /.row -->
</main><!-- /.container -->

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>



