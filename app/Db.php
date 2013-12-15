<?
    class Db {
        private static $instance;
        private $server = "";   //database server 
        private $user = "";     //database login name 
        private $pass = "";     //database login password 
        private $database = ""; //database name
        private $link_id, $query_id;
        
        private function __construct($server=null, $user=null, $pass=null, $database=null){ 
            $this->server=$server; 
            $this->user=$user; 
            $this->pass=$pass; 
            $this->database=$database; 
            
            $this->link_id = @mysql_connect(
                $this->server,
                $this->user,
                $this->pass, 
                false
            );
            
            @mysql_set_charset('utf8',$this->link_id); 
            
            if (!$this->link_id){//open failed 
                echo mysql_errno() . ": " . mysql_error() . "\n";
                die("connection to db failed");
            }
            
            if(!@mysql_select_db($this->database, $this->link_id)) {
                die("Could not open database: <b>$this->database</b>."); 
            }
        }
        
        public static function get_instance($server=null, $user=null, $pass=null, $database=null){ 
            if (!self::$instance){  
                self::$instance = new Db($server, $user, $pass, $database);  
            }  
            return self::$instance;  
        }
        
        public function query ($sql) {
            // do query 
                $this->query_id = @mysql_query($sql, $this->link_id); 
                

                if (!$this->query_id){ 
                    die("<b>MySQL Query fail:</b> $sql"); 
                    return 0; 
                } 

                $this->affected_rows = @mysql_affected_rows($this->link_id); 

                return $this->query_id;
        }
        
        public function fetch($query_id=-1){ 
            // retrieve row 
            if ($query_id!=-1){ 
                $this->query_id=$query_id; 
            } 

            if (isset($this->query_id)){ 
                $record = @mysql_fetch_assoc($this->query_id); 
            }else{ 
                die("Invalid query_id: <b>$this->query_id</b>. Records could not be fetched."); 
            } 

            return $record; 
        }
        
        public function fetch_array($sql){ 
            $query_id = $this->query($sql); 
            $out = array(); 

            while ($row = $this->fetch($query_id)){ 
                $out[] = $row; 
            } 

            $this->free_result($query_id); 
            return $out; 
        }
        
        public function insert($table, $data){ 
            $q="INSERT INTO `$table` "; 
            $v=''; $n=''; 

            foreach($data as $key=>$val){ 
                $n.="`$key`, "; 
                if(strtolower($val)=='null') $v.="NULL, "; 
                elseif(strtolower($val)=='now()') $v.="NOW(), "; 
                else $v.= "'".$this->escape($val)."', "; 
            } 

            $q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");"; 

            if($this->query($q)){ 
                return mysql_insert_id($this->link_id); 
            } 
            else return false; 

        }
        
        public function escape($string){
            if(get_magic_quotes_runtime()) $string = stripslashes($string); 
            return @mysql_real_escape_string($string,$this->link_id);
        }
        
        public function update($table, $data, $where='1'){ 
            $q="UPDATE `$table` SET "; 

            foreach($data as $key=>$val){ 
                if(strtolower($val)=='null') $q.= "`$key` = NULL, "; 
                elseif(strtolower($val)=='now()') $q.= "`$key` = NOW(), "; 
                elseif(preg_match("/^increment\((\-?\d+)\)$/i",$val,$m)) $q.= "`$key` = `$key` + $m[1], ";  
                else $q.= "`$key`='".$this->escape($val)."', "; 
            } 

            $q = rtrim($q, ', ') . ' WHERE '.$where.';'; 
            return $this->query($q); 
        }
        
        private function free_result($query_id=-1){ 
            if ($query_id!=-1){ 
                $this->query_id=$query_id; 
            } 
            if($this->query_id!=0 && !@mysql_free_result($this->query_id)){ 
                die("Result ID: <b>$this->query_id</b> could not be freed."); 
            } 
        }
    }
?>
