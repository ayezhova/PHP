#!/usr/bin/php
<?php
    /*
    The goal of this program is to look through the HTML of a website
    and download all images stored in a <img></img> tag.
    
    We can use curl to find the html of the page after setting it's oprions
    to follow the given URL and to return the html it finds there. After saving
    the HTML in a variable, we can now parse through the HTML, looking for
    "<img" and then the "src=" within that tag. After saving the src information
    to another variable, we can use that path to download the image that the src
    points to.
    */
    function get_html($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    
    function get_picture_url($output, $matches)
    {
        $picture_urls = array();
        foreach ($matches[0] as $match)
        {
            //we want to match either the close of the image tag or the source.
            //Matching the tag end is just as a precaution for code without an
            //image
            preg_match('/\/>|src="/', $output, $src, PREG_OFFSET_CAPTURE, $match[1]);
            //echo $match[1] . "\n";
            //print_r($src);
            $src_start = $src[0][1] + strlen($src[0][0]);
            if ($src[0][0] !== "\/>")
            {
                //Now we need to find the end of the source, which is at the
                //closing "
                preg_match('/"/', $output, $src_end, PREG_OFFSET_CAPTURE, $src_start);
                $picture_urls[] = substr($output, $src_start, $src_end[0][1] - $src_start);
            }
        }
        return $picture_urls;
    }
    
    function check_arg($url)
    {
        if (strpos($url, "http://www") !== FALSE && strpos($url, "http://www") === 0)
            return true;
        else if (strpos($url, "https://www") !== FALSE && strpos($url, "https://www") === 0)
            return true;
        return false;
    }
    
    if ($argc != 2 || check_arg($argv[1]) === false)
        return;
    //echo strpos($argv[1], "http://www") . "\n";
    $output = get_html($argv[1]);
    preg_match_all('/<img /', $output, $matches, PREG_OFFSET_CAPTURE);
    $pictures = get_picture_url($output, $matches);
    $dir = substr($argv[1], strpos($argv[1], "www."));
    if (is_dir($dir) === false)
        mkdir($dir);
    foreach($pictures as $picurl)
    {
        $file = basename($picurl);
        $save_location = $dir . $file;
        $fp = fopen($save_location, 'wb');
        $churl = $picurl;
        if (strpos($picurl, "http://www") === false && strpos($picurl, "https://www") === false)
        {
            if ($churl[0] === "/")
                $churl = substr($churl, 1);
            $churl = $argv[1] . $churl;
        }
        echo $churl . "\n";
        $ch = curl_init($churl);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }
    
?>