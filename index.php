<?php
include 'shoes.php';
$token = writeCookie();

if (isset($_GET['token']) && ! empty($_GET['token'])) {
    if (strlen($_GET['token']) == 50) {
        $token = writeCookie($_GET['token']);
        header('Location: /');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en" charset="UTF-8">
<head>
    <title>Sneaker Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link href="css/jquery-ui-1.10.2.custom.min.css" rel="stylesheet" media="screen" />
    <script src="js/jquery-1.9.1.js"></script>
    <script src="js/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function()
    {
        $('#shoe').autocomplete({
            source: 'shoes.php',
            minLength: 1
        });

        $('#submit').click(function()
        {
            var shoe  = encodeURIComponent($('#shoe').val());
            var miles = encodeURIComponent($('#miles').val());

            $.ajax({
                'dataType': 'json',
                'cache': false,
                'url': 'add.php',
                'type': 'POST',
                'data': 'shoe=' + shoe + '&miles=' + miles,
                'success': function (res)
                {
                    if($('#' + res.key + '-miles').length == 0) {
                        var html = '<tr><td>' + res.shoe + '</td>';
                        html += '<td id="' + res.key + '-miles">' + res.miles + '</td>';
                        html += '<td id="' + res.key + '-percent">' + res.percent + '</td></tr>';
                        $('table tbody').append(html);
                    }
                    else {
                        $('#' + res.key + '-miles').html(res.miles);
                        $('#' + res.key + '-percent').html(res.percent);
                    }
                    $('#shoe, #miles').val('');
                },
                'error': function(xhr, status, error)
                {
                    console.log(status);
                    console.log(error);
                }
            });
        });
    });
    </script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-39561557-1', 'sneakertracker.com');
        ga('send', 'pageview');
    </script>
</head>
<body>
    <div class="container-fluid">
        <div class="row-fluid">
            <h5>Your Key: <?php print $token; ?></h5>

            <p>Drag the following bookmarklet <a style="background-color: #f1f1f1; color: #666; padding: 3px; border: 1px solid #ccc;" href="javascript:window.location='http://<?php print $_SERVER['HTTP_HOST']; ?>?token=<?php print $token; ?>';">Log into Sneaker Keeper</a> to your bookmarks bar. When clicked it will log you in using the token above.</p>

            <p>This is your account, no logins. So save it because I don't want to know who you are :).</p>

            <p>If you are interested in the source for this project, you can find it here for <a href="https://github.com/phpfunk/sneakertracker.com" target="_blank">free</a>.</p>
            <div class="span3">
                <fieldset>
                    <legend>Add Miles</legend>
                    <label>Shoe</label>
                    <input type="text" id ="shoe" placeholder="Merrell Barefoot">
                    <label>Miles</label>
                    <input type="text" id ="miles" placeholder="4.5">
                    <button type="button" class="btn btn-success" id="submit">Add Miles</button>
                </fieldset>
            </div>

            <div class="span6">
                <legend>Shoe List</legend>
            <table class="table table-striped">
                <thead>
                    <tr>
                       <th>Shoe</th>
                       <th>Miles</th>
                       <th>% Remaining</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($shoes)): ?>
                    <?php foreach ($shoes as $shoe => $arr): ?>
                    <tr>
                       <td><?php print $shoe; ?></td>
                       <td id="<?php print $arr['key'] ?>-miles"><?php print $arr['miles']; ?></td>
                       <td id="<?php print $arr['key']; ?>-percent"><?php print $arr['percent']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</body>
</html>
