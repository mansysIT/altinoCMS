<?php

class FilesystemUtil
{
	public static function getFiles($DIR)
	{
		$result = array_diff(scandir($DIR), array('..', '.'));
		$result = array_merge(Array(), $result);
		
		return $result;
	}
	
	public static function getProperties($FILE)
	{
		$result['pathinfo'] 				= pathinfo($FILE);
		$result['size']['B'] 				= filesize($FILE);
		$result['size']['kB'] 				= round(filesize($FILE)/1024, 2);
		$result['size']['MB']               = round(filesize($FILE)/1024/1024, 2);
		$result['size']['GB']               = round(filesize($FILE)/1024/1024/1024, 2);
		$result['created']					= filectime($FILE);
		$result['modified']					= filemtime($FILE);
		$result['owner']					= fileowner($FILE);
		$result['perms']					= fileperms($FILE);
		$result['flags']['isReadable']		= is_readable($FILE);
		$result['flags']['isWriteable']     = is_writable($FILE);
        $result['flags']['isExecutable']    = is_executable($FILE);
		
		return $result;
	}
	
	public static function getFilesProperties($DIR)
	{
		$result = Array();
		$files = static::getFiles($DIR);
		
		if(!empty($files))
		{
			foreach($files as $file)
			{
				$result[] = array_merge(Array("filename" => $file), static::getProperties($DIR."/".$file));
			}
		}
		
		return $result;
	}
	
	public static function getSource($FILE, $INTOARRAY = FALSE)
	{
		$result = "";
		
		if(!is_dir($FILE))
		{
			if($INTOARRAY)
			{
				$result = file($FILE);
			}
			else
			{
				$result = file_get_contents($FILE);
			}
		}
		
		return $result;
	}
	
	public static function saveFile($CONTENT, $FILENAME, $OVERWRITE = TRUE)
	{
		$result = false;
		
		if((file_exists($FILENAME) && $OVERWRITE) || (!file_exists($FILENAME)))
		{
			$put = file_put_contents($FILENAME, $CONTENT);
			$result = ($put === false) ? false : true;
		}
		
		return $result;
	}
	
	public static function _formatFilePermission($FILEPERMS, $FORMAT = 'UNIX')
	{
		switch($FORMAT)
		{
			case 'UNIX':
			
			if(($FILEPERMS & 0xC000) == 0xC000)
			{
				// Gniazdo (socket)
				$info = 's';
			}
			elseif (($FILEPERMS & 0xA000) == 0xA000)
            {
              // Link symboliczny
              $info = 'l';
            }
            elseif (($FILEPERMS & 0x8000) == 0x8000)
            {
              // Zwykły plik
              $info = '-';
            }
            elseif (($FILEPERMS & 0x6000) == 0x6000)
            {
              // Urządzenie blokowe
              $info = 'b';
            }
            elseif (($FILEPERMS & 0x4000) == 0x4000)
            {
              // Katalog
              $info = 'd';
            }
            elseif (($FILEPERMS & 0x2000) == 0x2000)
            {
              // Urządzenie znakowe
              $info = 'c';
            }
            elseif (($FILEPERMS & 0x1000) == 0x1000)
            {
              // Potok (FIFO)
              $info = 'p';
            }
            else
            {
              // Nieznane
               $info = 'u';
            }
			
			// Właściciel
			$info .= (($FILEPERMS & 0x0100) ? 'r' : '-');
			$info .= (($FILEPERMS & 0x0080) ? 'w' : '-');
            $info .= (($FILEPERMS & 0x0040) ?
                     (($FILEPERMS & 0x0800) ? 's' : 'x' ) :
                     (($FILEPERMS & 0x0800) ? 'S' : '-'));
					 
			// Grupa
            $info .= (($FILEPERMS & 0x0020) ? 'r' : '-');
            $info .= (($FILEPERMS & 0x0010) ? 'w' : '-');
            $info .= (($FILEPERMS & 0x0008) ?
                     (($FILEPERMS & 0x0400) ? 's' : 'x' ) :
                     (($FILEPERMS & 0x0400) ? 'S' : '-'));
            
            // Świat
            $info .= (($FILEPERMS & 0x0004) ? 'r' : '-');
            $info .= (($FILEPERMS & 0x0002) ? 'w' : '-');
            $info .= (($FILEPERMS & 0x0001) ?
                     (($FILEPERMS & 0x0200) ? 't' : 'x' ) :
                     (($FILEPERMS & 0x0200) ? 'T' : '-'));
					 
			return $info;
			break;
				
			default:
            return fileperms($FILE);
		}
	}

	public static function _formatFileOwner($FILEOWNER)
	{
		$fo = posix_getpwuid($FILEOWNER);
		return $fo['name'];
	}
	
}

?>