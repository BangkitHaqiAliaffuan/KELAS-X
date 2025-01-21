<?php
// Pastikan tidak ada output sebelumnya
// Hancurkan session
session_destroy();
session_unset();
// Redirect ke halaman home
header("location:index.php?menu=home");