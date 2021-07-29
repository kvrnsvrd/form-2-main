<?php
function debug($tableau)
{
    echo '<pre style="height:200px;overflow: scroll; font-size: .8em;padding: 10px;font-family: Consolas, Monospace; background-color: #000;color:#fff;">';
    print_r($tableau);
    echo '</pre>';
}


function validText($errors,$value,$key,$min,$max,$mandatory=true){
    if(!empty($value)){
        // renseigner, pas vide
        if(mb_strlen($value) < $min){
            $errors[$key] = 'Min '.$min.' caractères';
        } elseif(mb_strlen($value) >= $max){
            $errors[$key] = 'Max '.$max.' caractères';
        } else{
            // no error
        }
    } else{
        if($mandatory){
            $errors[$key] = 'Veuillez renseigner ce champ';
        }
    }
    return $errors;
}

function validEmail($errors, $value, $key = "email"){
    if(!empty($value)){
        if(filter_var($value,FILTER_VALIDATE_EMAIL) == false){
            $errors[$key] = 'Veuillez renseigner un email valide';
        }
    } else{
        $errors[$key] = 'Veuillez renseigner un email';
    }
    return $errors;
}

function viewError($errors,$key){
    if (!empty($errors[$key])) {
        echo $errors[$key];
    }
}

function xss($value){
    return trim(strip_tags($value));
}