<?php

    function errorUpload($number){
        $array_erro = array(
            UPLOAD_ERR_OK => "Sem erro.",
            UPLOAD_ERR_INI_SIZE => "O arquivo enviado excede o limite definido na diretiva upload_max_filesize do php.ini.",
            UPLOAD_ERR_FORM_SIZE => "O arquivo excede o limite de 1MB no formulário HTML",
            UPLOAD_ERR_PARTIAL => "O upload do arquivo foi feito parcialmente.",
            UPLOAD_ERR_NO_FILE => "Nenhum arquivo foi enviado.",
            UPLOAD_ERR_NO_TMP_DIR => "Pasta temporária ausente.",
            UPLOAD_ERR_CANT_WRITE => "Falha em escrever o arquivo em disco.",
            UPLOAD_ERR_EXTENSION => "Uma extensão do PHP interrompeu o upload do arquivo."
        );
        
        return $array_erro[$number];
    }

    function uploadCommand($file, $pasta_destino){
        if($file['error'] == 0){
            $nome = nomeUnico($file['name']);
            $pastatemporaria = $file['tmp_name'];
            $pasta = $pasta_destino;
            $extensao = strrchr($nome, ".");
            $tipo = $file['type'];

            if($tipo == 'image/png' || $tipo == 'image/jpeg' || $tipo == 'image/gif'){
                    if(move_uploaded_file($pastatemporaria, $pasta . "/" . $nome)){
                        $msg = errorUpload($file['error']);
                    }else{
                        $msg = "erro no upload";
                    }
            }else{
                $msg = "Não carrega arquivo de extensão " . $extensao;
            }
        }else{
            $msg = errorUpload($file['error']);
        }

        return array(
            0 => $msg,
            1 => $nome
        );

    }

    function nomeUnico($arquivo){
        $extensao = strrchr($arquivo, ".");
        $alfabeto = "ABCDEFGHIJKLMNOPQRSTUVXZ0123456789";
        $letra = "";
        $resultado = "";


        for($i=1; $i<=13; $i++){
            $letra = substr($alfabeto, rand(0,strlen($alfabeto)-1) , 1);
            $resultado .= $letra;
            
        }
        
        $data = getdate();
        $tempo = "";
        $tempo .= $data['year'] . '_';
        $tempo .= $data['yday'];
        $tempo .= $data['hours'];
        $tempo .= $data['minutes'];
        $tempo .= $data['seconds'];
        $nomeunico = $resultado . '_'. $tempo;
    
        return 'X_' . $nomeunico . $extensao;
    }
      


?>
