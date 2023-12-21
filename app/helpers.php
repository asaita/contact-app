<?php



function sortable($label, $column){

    $sortBy=request()->query('sort_by');
    
    //iki kere basınca - koyuyuor url nin önüne
    $sortBy=!$sortBy||strpos($sortBy,"-")===0 ? $column : "-{$column}";
    $url=request()->fullUrlWithQuery(['sort_by'=>$sortBy]);

    return "<a href='{$url}'>{$label}</a>";

}

?>