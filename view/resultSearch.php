<?php $title = 'result search'; ?>

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
                            Place
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
                    <tr>
                        <td>
                            System of a down on tour
                        </td>
                        <td>
                            Rock wertcher
                        </td>
                        <td>
                            05/07/2020
                        </td>
                        <td>
                            22:00
                        </td>
                        <td> Concert</td>
                        <td><a href="#">link page of this event</a></td>
                    </tr>
                    <tr class="table-active">
                        <td>
                            A Conversation about Race in the Boardroom
                        </td>
                        <td>
                            Online Event
                        </td>
                        <td>
                            23/07/2020
                        </td>
                        <td>
                            21:00
                        </td>
                        <td>Conference</td>
                        <td><a href="#">link page of this event</a></td>

                    </tr>
                    <tr class="table-success">
                        <td>
                            Everlast: The Live Acoustic
                        </td>
                        <td>
                            Online Event
                        </td>
                        <td>
                            26/07/2020
                        </td>
                        <td>
                            3:00
                        </td>
                        <td>Concert</td>
                        <td><a href="#">link page of this event</a></td>

                    </tr>
                    <tr class="table-warning">
                        <td>
                            Social Justice Summit for Educators
                        </td>
                        <td>
                            Online Event
                        </td>
                        <td>
                            05/08/2020
                        </td>
                        <td>
                            1:00
                        </td>
                        <td>Conference</td>
                        <td><a href="#">link page of this event</a></td>
                    </tr>
                    <tr class="table-danger">
                        <td>
                            Wallifornia MusicTech
                        </td>
                        <td>
                            Online Event
                        </td>
                        <td>
                            07/07/2020
                        </td>
                        <td>
                            Unknow
                        </td>
                        <td>Hackathon</td>
                        <td><a href="#">link page of this event</a></td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div><!-- /.row -->

</main><!-- /.container -->

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>