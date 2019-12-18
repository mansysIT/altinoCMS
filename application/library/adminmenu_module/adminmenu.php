<?php

$config = registry::register('config');
if($_SESSION[$config->default_session_admin_priv_var] == 'admin')
{
	echo '<ul>
            <li><a class="_ico icon1" href="administrator/dashboard">Home<span>Najważniejsze informacje</span></a></li>
            <li><a class="_ico icon5" href="administrator/wylogowanie">Wylogowanie<span>Zakończ pracę z serwisem</span></a></li>
        </ul>';
}
else
{
	echo '<ul>
            <li><a class="_ico icon1" href="administrator/dashboard">Home<span>Najważniejsze informacje</span></a></li>
            <li><a class="_ico icon5" href="administrator/wylogowanie">Wylogowanie<span>Zakończ pracę z serwisem</span></a></li>
        </ul>';
}

?>