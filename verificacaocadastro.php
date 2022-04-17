<?php
    
function validateCadastro($InputArray, $redirecionar){
    
    if($InputArray){
        require('../../conexao/conexao.php');

        $email = $InputArray['email'];
        $name = $InputArray['name'];
        $lastname = $InputArray['lastname'];
        $password = $InputArray['password'];
        $passconf = $InputArray['passconfirmation'];

        $nomecompleto = $name . ' ' . $lastname;
    
        $dados_recebidos = array(
            email => $email,
            name => $name,
            lastname => $lastname,
            password => $password,
            passconf => $passconf
        );


        //buscando emails no banco de dados
        $Qemail = "SELECT * FROM CADASTRO ";
        $Qemail .= "WHERE EMAIL = '$email' ";

        $Bemail = mysqli_query($con, $Qemail);
        $Remail = mysqli_fetch_assoc($Bemail);
    
    
        //validacao nomes
        $str_invalidos = "!,@,#,$,%x*,(,),-,+,*,-,/";
        $arr_invalidos = explode(',', $str_invalidos);
    
        $str1_invalidos = implode('', $arr_invalidos);
        
        $errorname = false;
        foreach($arr_invalidos as $str){
            if(  stristr($dados_recebidos['name'], $str) ){
                    $errorname = true;
            }
        }

        $errorlastname = false;
        foreach($arr_invalidos as $str){
            if(  stristr($dados_recebidos['lastname'], $str) ){
                    $errorlastname = true;
            }
        }

        //Array de Erros
        $error = array();
    

        //VER campo vazio (0)
        if(in_array('', $dados_recebidos)){
        $erro['0'] = 'Necessário preencher todos os campos';
        }

        //Email valido (1)
        if(!filter_var($dados_recebidos['email'], FILTER_VALIDATE_EMAIL)){
            $erro['1'] = 'Email fornecido invalido. Ex: usuario@gmail.com';
        }

        //Email ja cadastrado
        if($Remail['EMAIL'] == $email){
            $erro['1+'] = "Email cadastrado";
        }

        //Nome Invalido (2)
        if($errorname){
            $erro['2'] = "Não é permitido os caracteres: " . $str1_invalidos;
        }
        
        //SobreNome Invalido (2+)
        if($errorlastname){
            $erro['2+'] = "Não é permitido os caracteres: " . $str1_invalidos;
        }

        //Numero minimo de caracteres para senha (3)
        if( strlen($dados_recebidos['password']) < 6 OR strlen($dados_recebidos['passconf']) < 6 ){
            $erro['3'] = "Senha precisa de pelo menos 6 caracteres";
        }
        //Caracters invalidos para senha (4)
        if( stristr($dados_recebidos['password'], "'" ) OR stristr($dados_recebidos['passconf'], "'" )){
            $erro['4'] = "Caracter (') Invalido na senha";
        }
        //Senhas diferentes (5)
        if($dados_recebidos['password'] != $dados_recebidos['passconf']){
            $erro['5'] = "As senhas não coincidem";
        }


        //Erros Banco de Dados  

        if($erro){
            return $erro;
        }{
            $Qcad = "INSERT INTO CADASTRO VALUES(NULL, '$email', '$nomecompleto', '$password')";
            $Icad = mysqli_query($con, $Qcad);

            if(!$Icad){
                die("Erro no Banco de Dados");
            }

            header('location: ' . $redirecionar);
        }
    }

}
?>
