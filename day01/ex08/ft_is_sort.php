<?php
    function ft_is_sort($arr)
    {
        $arr_sort = $arr;
        sort($arr_sort);
        foreach ($arr as $index=>$word)
        {
            if ($word != $arr_sort[$index])
                return false;
        }
        return true;
    }
?>