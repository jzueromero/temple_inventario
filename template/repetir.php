<?php
session_start();

?>
<html>
<body>
<?php

for ($i=1; $i <= 5 ; $i++) { 
    echo "Ant: "."$"."h$i"." Actual: $"."S$i -";

    echo "<hr ><label>". $_SESSION['token_temp_entrada']."</label><hr >";
 }

?>
</body>
</html>