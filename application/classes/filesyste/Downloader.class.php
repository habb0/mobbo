<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Downloader
 *
 * @author Gisele Santoro
 */
class Downloader
    {

    public static
            function get_data($url)
        {
        $ch      = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data    = curl_exec($ch);
        curl_close($ch);
        return $data;
        }

    public static
            function getHeaders($url)
        {
        $ch      = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_exec($ch);
        $headers = curl_getinfo($ch);
        curl_close($ch);

        return $headers;
        }

    /**
     * Download
     * @param str $url, $path
     * @return bool || void
     */
    public static
            function Download($url, $path)
        {
        # open file to write
        set_time_limit(0);
        $fp = fopen($path, 'w+');
        chmod($path, 0777);
        # start curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        # set return transfer to false
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        # increase timeout to download big file
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        # write data to local file
        curl_setopt($ch, CURLOPT_FILE, $fp);
        # execute curl
        curl_exec($ch);
        # close curl
        curl_close($ch);
        # close local file
        fclose($fp);

        if (filesize($path) > 0)
            return true;
        }

    }
