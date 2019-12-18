<?php

echo '<div id="login-form">
        <form method="POST" action="logowanie/index">
            <input type="text" name="login" id="login-input" value="Nazwa użytkownika" />
            <input type="password" name="password" id="password-input" value="Hasło" />
            <input type="submit" name="login-submit" id="login-submit" value="OK" />
        </form>
        <span class="options"><a href="rejestracja/index">Nowe konto</a> | <a href="przypomnienie_hasla/index">Zapomniane hasło ?</a></span>
                        
        <span class="title">'.model_load('homemodel', 'getLoginPanelTitle', '').'</span>            
    </div>';

?>