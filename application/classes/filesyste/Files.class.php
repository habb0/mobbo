<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Files
 *
 * @author RADIO
 */
class Files
    {

    //put your code here

    public static
            function copy_dir($src, $dst)
        {
        $dir  = opendir($src);
        @mkdir($dst);
        while (false !== ( $file = readdir($dir)))
            {
            if (( $file != '.' ) && ( $file != '..' ))
                {
                if (is_dir($src . '/' . $file))
                    {
                    self::copy_dir($src . '/' . $file, $dst . '/' . $file);
                    }
                else
                    {
                    copy($src . '/' . $file, $dst . '/' . $file);
                    }
                }
            }
        closedir($dir);
        return 1;
        }

    public static
            function move_dir($srcDir, $destDir)
        {
        if (file_exists($destDir))
            {
            if (is_dir($destDir))
                {
                if (is_writable($destDir))
                    {
                    if ($handle = opendir($srcDir))
                        {
                        while (false !== ($file = readdir($handle)))
                            {
                            if (is_file($srcDir . '/' . $file))
                                {
                                rename($srcDir . '/' . $file, $destDir . '/' . $file);
                                }
                            }
                        closedir($handle);
                        return 1;
                        }
                    else
                        {
                        echo "$srcDir could not be opened.\n";
                        }
                    }
                else
                    {
                    echo "$destDir is not writable!\n";
                    }
                }
            else
                {
                echo "$destDir is not a directory!\n";
                }
            }
        else
            {
            echo "$destDir does not exist\n";
            }
        }

    public static
            function getLines($file)
        {
        $linecount = 0;
        $handle    = fopen($file, "r");
        while (!feof($handle))
            {
            $line      = fgets($handle, 4096);
            $linecount = $linecount + substr_count($line, PHP_EOL);
            }
        fclose($handle);
        return $linecount;
        }

    public static
            function getLineF($file, $line = 0)
        {
        $lines = file($file); //file in to an array
        return $lines[$line];
        }

    public static
            function getLineWithString($fileName, $str)
        {
        $lines = file($fileName);
        foreach ($lines as $lineNumber => $line)
            {
            if (strpos($line, $str) !== false)
                {
                return $line;
                }
            }
        return -1;
        }

    public static
            function del_dir($dirPath)
        {
        if (!is_dir($dirPath))
            {
            echo ( "$dirPath must be a directory" );
            }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/')
            {
            $dirPath .= '/';
            }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file)
            {
            if (is_dir($file))
                {
                self::del_dir($file);
                }
            else
                {
                unlink($file);
                }
            }
        rmdir($dirPath);
        }

    public static
            function copy_directory($source, $destination)
        {
        if (is_dir($source))
            {
            mkdir($destination);
            $directory     = dir($source);
            while (FALSE !== ( $readdirectory = $directory->read() ))
                {
                if ($readdirectory == '.' || $readdirectory == '..')
                    {
                    continue;
                    }
                $PathDir = $source . '/' . $readdirectory;
                if (is_dir($PathDir))
                    {
                    self::copy_directory($PathDir, $destination . '/' . $readdirectory);
                    continue;
                    }
                copy($PathDir, $destination . '/' . $readdirectory);
                }

            $directory->close();
            }
        else
            {
            copy($source, $destination);
            }
        }

    }
