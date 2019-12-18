<?php

/**
 * ModuleName: Menu główne
 * ModuleDesc: Menu głowne serwisu SuperCMS
 */

echo '<div class="content">       
        <h1><a href="/">Design klasy biznes</a></h1>        
        <ul>
            <li><a href="home/index">Home</a></li>
            <li><a href="administrator/index">ADMIN</a></li>'.
            model_load('homemodel', 'addLogoutBtn', '').'
        </ul>
    </div>';

?>