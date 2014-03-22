phpMyDL
=======

PHP interface for youtube-dl
----------------------------

1. Login system with a password
2. Download videos through youtube-dl with some preferences
3. View downloaded files with deletion possibility

Configure
----------------------------
Create *config.php* with a MD5 encoded password.
Example with an empty password:
    <?php
    $hash_pwd="d41d8cd98f00b204e9800998ecf8427e";
    ?>
