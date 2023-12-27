<?php



function sortable($label, $column){

    $sortBy=request()->query('sort_by');

    $direction="";


    if(ltrim($sortBy,'-')===$column){

        $direction=strpos($sortBy,'-')===0 ? "desc" : "asc";
    }
    
    //iki kere basınca - koyuyuor url nin önüne
    $sortBy=!$sortBy||strpos($sortBy,"-")===0 ? $column : "-{$column}";
    $url=request()->fullUrlWithQuery(['sort_by'=>$sortBy]);

    

    return "<a href='{$url}' class='sortable {$direction}'>{$label}</a>";

}

?>