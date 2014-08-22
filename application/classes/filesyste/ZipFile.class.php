<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ZipFile
 *
 * @author RADIO
 */
class ZipFile
    {
    /* creates a compressed zip file */

    public static
            function create_zip($files = array(), $destination = '', $overwrite = false)
        {
        //if the zip file already exists and overwrite is false, return false
        if (file_exists($destination) && !$overwrite)
            {
            return false;
            }
        //vars
        $valid_files = array();
        //if files were passed in...
        if (is_array($files))
            {
            //cycle through each file
            foreach ($files as $file)
                {
                //make sure the file exists
                if (file_exists($file))
                    {
                    $valid_files[] = $file;
                    }
                }
            }
        //if we have good files...
        if (count($valid_files))
            {
            //create the archive
            $zip = new ZipArchive();
            if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE ) !== true)
                {
                return false;
                }
            //add the files
            foreach ($valid_files as $file)
                {
                $zip->addFile($file, $file);
                }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
            }
        else
            {
            return false;
            }
        }

    public static
            function processUnZip($sourceFileName, $destinationPath)
        {
        if (stristr(PHP_OS, 'WIN'))
            {
            if (self::unZipOnWindows($sourceFileName, $destinationPath))
                return 1;
            }
        else
            {
            if (self::unZipOnLinux($sourceFileName, $destinationPath))
                return 1;
            }
        }

    /**
     * Function: unZipOnWindows($sourceFileName,$destinationPath)
     * Unzipping a zip file on windows
     * @param string $sourceFileName, source zip file name with absolute path
     * @param string $destinationPath, destination fath for unzipped file (absolute path)
     */
    private static
            function unZipOnWindows($sourceFileName, $destinationPath)
        {

        $directoryPos = strrpos($sourceFileName, '/');
        $directory    = substr($sourceFileName, 0, $directoryPos + 1);
        $dir          = opendir($directory);
        $info         = pathinfo($sourceFileName);
        if (strtolower($info['extension']) == 'zip')
            {
            $zip      = new ZipArchive;
            $response = $zip->open($sourceFileName);
            if ($response === TRUE)
                {
                $zip->extractTo($destinationPath);
                $zip->close();
                return 1;
                }
            }
        closedir($dir);
        }

    /**
     * Function: unZipOnLinux($sourceFileName,$destinationPath)
     * Unzipping a zip file on linux
     * @param string $sourceFileName, source zip file name with absolute path
     * @param string $destinationPath, destination fath for unzipped file (absolute path)
     */
    private static
            function unZipOnLinux($sourceFileName, $destinationPath)
        {

        $directoryPos = strrpos($sourceFileName, '/');
        $directory    = substr($sourceFileName, 0, $directoryPos + 1);
        $dir          = opendir($directory);
        $info         = pathinfo($sourceFileName);
        if (strtolower($info['extension']) == 'zip')
            {
            system('unzip -q ' . $sourceFileName . '  -d ' . $destinationPath);
            return 1;
            }
        closedir($dir);
        }

    }
