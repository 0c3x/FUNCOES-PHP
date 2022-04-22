
function nomeUnico(){

    $alfabeto = "ABCDEFGHIJKLMNOPQRSTUVXZ0123456789";
    $letra = "";
    $resultado = "";


    for($i=1; $i<=10; $i++){
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

    return 'X_' . $nomeunico;
}



function varreduraSimples($range){

    $nomearquivo = nomeUnico();
    $scan = "nmap -sn $range -oG $nomearquivo";
    $filtragem = "cat $nomearquivo | grep 'Up' | cut -d ' ' -f2";

    $act = shell_exec($scan);
    $resultado = shell_exec($filtragem);

    $apagararquivo = shell_exec("rm -rf $nomearquivo");

    return $resultado;

}



function varreduraServices($ip){
    $nomearquivo = nomeUnico().'.txt';
    $range = $ip;
    $Qbusca = "nmap -sV $range -oG $nomearquivo";
    $Qportas = "cat $nomearquivo| grep 'Ports:' | sed 's/, //g' | cut -d':' -f3 | sed 's/\t/=/g' | cut -d'=' -f1 |  cut -d: -f3 | sed 's/\//;/g' | sed 's/;;/;/g' | grep ';'";
    
    for($i=0; $i<2; $i++){
      if($i==0){
         $busca = shell_exec($Qbusca);
      }
      if($i==1){
         $portas = shell_exec($Qportas);
         $delete = shell_exec("rm -rf $nomearquivo");
      }
    }
    $arr = explode(";", $portas);
    $num = count($arr)-1;
    $i = 0;
    unset($arr[$num]);

    return $arr;


}
