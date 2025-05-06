<?php
session_start();
session_unset();
session_destroy();
header("loginn.html");
exit();
