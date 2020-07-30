<?php $title = 'events'; ?>

<?php ob_start(); ?>

<main role="main" class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Events by category</h2>
            <div class="search">
                <a href="./index.php?action=allcategorycontroller"> <button class="btn btn-primary">All</button></a>
                <a href="./index.php?action=onecategorycontroller&amp;category_id=1"><button class="btn btn-primary">Concert</button></a>
                <a href="./index.php?action=onecategorycontroller&amp;category_id=2"><button class="btn btn-primary">Exhibition</button></a>
                <a href="./index.php?action=onecategorycontroller&amp;category_id=3"><button class="btn btn-primary">Conference</button></a>
                <a href="./index.php?action=onecategorycontroller&amp;category_id=4"><button class="btn btn-primary">Hackathon</button></a>
                <a href="./index.php?action=onecategorycontroller&amp;category_id=5"><button class="btn btn-primary">Game Jam</button></a>
            </div>
            <br />
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
                            Category
                        </th>
                        <th>See more...</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    while ($data = $search->fetch()) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $data['title']; ?>
                            </td>
                            <td>
                                <?php echo $data['event_date_formatted']; ?>
                            </td>
                            <td>
                            <?php echo $data['event_hour_formatted']; ?>
                            </td>
                            <td> <?php echo $data['category']; ?></td>
                            <td><a href="./index.php?action=showEvent&amp;id=<?= $data['id'] ?>">See this event</a></td>
                        </tr>
                    <?php }
                    $search->closeCursor(); ?>
                </tbody>
            </table>
        </div>
        <!-- <a  class="btn btn-info" href="index.php?action=search">Search more...</a> -->
    </div><!-- /.row -->
</main><!-- /.container -->

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>