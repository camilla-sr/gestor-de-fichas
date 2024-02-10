<?php
defined('BASEPATH') or exit('No direct script access allowed');

    //primeiro verifica se os nomes do Front estão nos atributos necessários
   function verificarParam($atributos, $lista){
    //faz uma lista listando os valores como $key e olha os valores delas
    foreach($lista as $key => $value){
        //essa linha quebra as arrays e compara os valores para fazer uma comparação
        if(array_key_exists($key, get_object_vars($atributos))){
            $estatus = 1;
        }else{
            $estatus = 0;
            break;
        }
    }

    //verifica se a quantidade de elementos que vem do Front é o que o Back precisa
    if(count(get_object_vars($atributos)) != count($lista)){
        $estatus = 0;
    }
    
    return $estatus;
   }
?>