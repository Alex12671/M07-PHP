<?php
    session_start();
    if($_SESSION) {
        session_destroy();
        echo "Sessió destruida amb èxit";
        echo "<meta http-equiv=refresh content='2; url=index.php'>";
    }
    else {
        echo "No estás autoritzat a veure aquesta pàgina";
        echo "<meta http-equiv=refresh content='2; url=index.php'>";
    }
?>