//VALIDATE IPV4
function validateIPv4($ipv4){
    $str_invalidos = "!,@,#,$,%x*,(,),-,+,*,-,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,x,z,w,y,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,X,Z,W,Y,*,-,+, ,|";

    $arr_invalidos = explode(',', $str_invalidos);

    $exemplo = strlen("255.255.255.255");
    $ip = $ipv4;
    $ponto = explode(".", $ip);
    $num_ponto = count($ponto)-1;


    foreach($arr_invalidos as $carac){
        if(stristr($ip, $carac)){
            $msg = true;
        }
    }

    if(strlen($ip) < 7 || strlen($ip) > ($exemplo+1)){
            $msg = true;
    }elseif( !($num_ponto == 3) ){
            $msg = true;
    }elseif(stristr($ip, ",")){
            $msg = true;
    }

    if($msg){
        return 1;
    }else{
        return 0;
    }

}
// this function is to integration with nmap and
// I didn't use the function filter_var($ip, FILTER_VALIDATE_IP), because don't accept the range 0/24

