<?php

if(isset($_SESSION['logged_teacher']) && $_SESSION['logged_teacher'] == 'admin'){
echo '
    </div>

    <link href="../css/foot.css" rel="stylesheet">
    <div class="foot">
    <p>Котрунцев Глеб 32928/1</p>
    <p>Экзамен - Информационная система</p>
    <p>2023</p>
    </div>
    
    </div>
    </body>
    </html>';
}

else{
    echo '

    </div>
    <link href="css/foot.css" rel="stylesheet">
    <div class="foot">
    <p>Котрунцев Глеб 32928/1</p>
    <p>Экзамен - Информационная система</p>
    <p>2023</p>
    </div>
    
    </div>
    </body>
    </html>';
}

?>