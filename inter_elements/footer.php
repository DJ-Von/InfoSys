<?php

if(isset($_SESSION['teacher_login']) && $_SESSION['teacher_login'] == 'admin'){
echo '
    </div>
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