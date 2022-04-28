

<?php
//A PASTA DEVERÁ SER REFERENCIA, FIZ UMA PASTA TEMP PARA ARMAZENAR

class NetworkScan{
    private $simpleScan;
    private $portScan;
    
    public function setSimpleScan($ipv4){

        $archive = new UniqueName;
        $archive->setUniqueName();
        $archive = $archive->getUniqueName();

        $scan = "nmap -sn $ipv4 -oG /var/www/Temp/$archive";
        $filtragem = "cat /var/www/Temp/$archive | grep 'Up' | cut -d ' ' -f2";
    
        $scanning = shell_exec($scan);
        $out = shell_exec($filtragem);
        $output = explode("\n", $out);

        

        $this->simpleScan = $output;

        $delete = shell_exec("rm -rf /var/www/Temp/$archive");
    
    }

    public function getSimpleScan(){
        return $this->simpleScan;
    }


    public function setPortScan($ipv4){
        $archive = new UniqueName;
        $archive->setUniqueName();
        $archive = $archive->getUniqueName();
        
        $Qscan = "nmap -sV $ipv4 -oG /var/www/Temp/$archive";
        $filtragem = "cat /var/www/Temp/$archive| grep 'Ports:' ";
        $filtragem .= "| sed 's/, //g' | cut -d':' -f3 | sed 's/\t/=/g' | cut -d'=' -f1 |  cut -d: -f3 | sed 's/\//;/g' | sed 's/;;/;/g' | grep ';'";
        

        $scan = shell_exec($Qscan);
        $ports = shell_exec($filtragem);

        

        $arr = explode(";", $ports);
        $num = count($arr)-1;
        unset($arr[$num]);
    
        $this->portScan = $arr;


        $delete = shell_exec("rm -rf /var/www/Temp/$archive");
    
    
    }

    public function getPortScan(){
        return $this->portScan;
    }



}
