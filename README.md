phpMyDL
=======

A web-interface for youtube-dl
----------------------------

1. Login in the system with a password;
2. Download some videos using youtube-dl;
3. View the files and optionally delete them.

Configure
----------------------------
Create *config.php* and set a MD5-encoded password.

Example with an empty password:

```
<?php
$hash_pwd="d41d8cd98f00b204e9800998ecf8427e";
?>
```
