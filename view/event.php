<?php $title = 'event'; ?>

<?php ob_start(); ?>

<main role="main" class="container">
    <div class="row">

        <div class="col-md-12">
            <h2>Event</h2>
            <select name="categories" class="form-control">
                <option value="all">All</option>
                <option value="1">Concert</option>
                <option value="2">Exhibition</option>
                <option value="3">Conference</option>
                <option value="4">Hackathon</option>
                <option value="5">Game Jam</option>
            </select><br />
            <button type="submit" class="btn btn-primary">
                Search
            </button><br />
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
                    <tr>
                        <td>
                            System of a down on tour
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
                    <tr>
                        <td>
                            A Conversation about Race in the Boardroom
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
                    <tr>
                        <td>
                            Everlast: The Live Acoustic
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
                    <tr>
                        <td>
                            Social Justice Summit for Educators
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
                    <tr>
                        <td>
                            Wallifornia MusicTech
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
        <button type="submit" class="btn btn-info">
            <a href="index.php?action=search">Search more...</a>
        </button>
    </div><!-- /.row -->

</main><!-- /.container -->

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>