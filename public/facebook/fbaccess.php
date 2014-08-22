<?php

/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */
include_once('facebook.php');
// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
    'appId'  => $app_id,
    'secret' => $app_secret,
        ));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user)
    {
    try
        {
        // Proceed knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');
        }
    catch (FacebookApiException $e)
        {
        error_log($e);
        $user = null;
        }
    }

// Login or logout url will be needed depending on current user state.
if ($user)
    {
    $logoutUrl = $facebook->getLogoutUrl();
    }
else
    {
    $loginUrl = $facebook->getLoginUrl(array(
        'scope'        => 'read_stream, publish_stream, user_birthday, user_location, user_work_history, user_hometown, user_photos',
        'redirect_uri' => $site_url,
    ));
    }


if ($user)
    {
    // Proceed knowing you have a logged in user who has a valid session.
//========= Batch requests over the Facebook Graph API using the PHP-SDK ========
    // Save your method calls into an array
    $queries = array(
        array('method' => 'GET', 'relative_url' => '/' . $user),
        array('method' => 'GET', 'relative_url' => '/' . $user . '/home?limit=50'),
        array('method' => 'GET', 'relative_url' => '/' . $user . '/friends'),
        array('method' => 'GET', 'relative_url' => '/' . $user . '/photos?limit=6'),
    );

    // POST your queries to the batch endpoint on the graph.
    try
        {
        $batchResponse = $facebook->api('?batch=' . json_encode($queries), 'POST');
        }
    catch (Exception $o)
        {
        error_log($o);
        }

    //Return values are indexed in order of the original array, content is in ['body'] as a JSON
    //string. Decode for use as a PHP array.
    $user_info    = json_decode($batchResponse[0]['body'], TRUE);
    $feed         = json_decode($batchResponse[1]['body'], TRUE);
    $friends_list = json_decode($batchResponse[2]['body'], TRUE);
    $photos       = json_decode($batchResponse[3]['body'], TRUE);
    }
?>
