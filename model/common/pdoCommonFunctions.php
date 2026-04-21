<?php
abstract class FunctionDefinitions
{
    abstract public function ListFromTable($SQL);
    abstract public function AddToTable($SQL);
    abstract public function UpdateTable($SQL);
    abstract public function DeleteFromTable($SQL);
    abstract public function AddToTableAndReturnSpecifiedColumn($sql,$retColumnName,$tableName);
    abstract public function callProcedure($procedureName);
    abstract public function Begin();
    abstract public function Commit();
    abstract public function Rollback();
    abstract public function validateUser($data);
    abstract public function executeQuery($sql);
    abstract public function selectexecuteQuery($sql);
    
    
}
class CommonPDOModel extends FunctionDefinitions
{
	public $varDBPDO;
	var $result;
	var $flag=0;
	

	function __construct()
	{
		$DBPDO = new ClassDatabaseConnection();
		$this->varDBPDO = $DBPDO->pdo;
   
	}
    public function ListFromTable($sql, $params = [])
    {
        try {
                $stmt = $this->varDBPDO->prepare($sql);
                $stmt->execute($params);
        
                Logger::ActivityLog('ListFromTable',$sql,$params);
                return json_encode([
                    'status' => true,
                    'data'   => $stmt->fetchAll(PDO::FETCH_ASSOC)
                ]);
        
            } catch (PDOException $e) {
        
                Logger::dbError($e->getMessage(),$sql,$params);
                return json_encode([
                    'status'  => false,
                    'message' => 'Database error occurred'
                ]);
            }
    }


    // Usage If ListFromTable in Controller 
    //echo $db->listFromTable("SELECT * FROM tbl_users WHERE status = ?", ['Active']);
    public function AddToTable($sql, $params = [])
    {
        try {
            Logger::ActivityLog('AddToTable',$sql,$params);
            $this->varDBPDO->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
            $stmt = $this->varDBPDO->prepare($sql);
            $stmt->execute($params);
            Logger::ActivityLog('AddToTable',$sql,$params);
            return json_encode([
                'status'  => true,
                'message' => 'Record inserted successfully',
                'data'    => [
                    'last_insert_id' => $this->varDBPDO->lastInsertId(),
                    'rows_affected' => $stmt->rowCount()
                ]
            ]);
    
        } catch (PDOException $e) {
    
            Logger::dbError(
                $e->getMessage(),
                $sql,
                $params
            );
    
            return json_encode([
                'status'  => false,
                'message' => 'Failed to insert record'
            ]);
        }
    }
    //$db->AddToTable("INSERT INTO tbl_users (name, email) VALUES (?, ?)",[$name, $email]);
    public function AddToTableAndReturnSpecifiedColumn($sql,$retColumnName,$tableName,$params = [])
    {
        try {
            $this->varDBPDO->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
            $stmt = $this->varDBPDO->prepare($sql);
            $stmt->execute($params);
            Logger::ActivityLog('Modal - AddToTableAndReturnSpecifiedColumn 97 ',$sql,$params);
            
            $returnColunValue = $this->ListFromTable('select '.$retColumnName.' from '.$tableName.' where ids=?',[$this->varDBPDO->lastInsertId()]);
            
            Logger::ActivityLog('Return Colum After ',$returnColunValue);
            
            return json_encode([
                'status'  => true,
                'message' => 'Record Returned successfully',
                'data'    => [
                    'return_'.$retColumnName.'_value' => $returnColunValue,
                    'rows_affected' => $stmt->rowCount()
                ]
            ]);
    
        } catch (PDOException $e) {
    
            Logger::dbError(
                $e->getMessage(),
                $sql,
                $params
            );
    
            return json_encode([
                'status'  => false,
                'message' => 'Failed to insert record'
            ]);
        }
    }
    
    public function UpdateTable($sql, $params = [])
    {
        try {
            $stmt = $this->varDBPDO->prepare($sql);
            $stmt->execute($params);
            Logger::ActivityLog('UpdateTable',$sql,$params);
            return json_encode([
                'status'  => true,
                'message' => 'Record updated successfully',
                'data'    => [
                    'rows_affected' => $stmt->rowCount()
                ]
            ]);
    
        } catch (PDOException $e) {
    
            Logger::dbError(
                $e->getMessage(),
                $sql,
                $params
            );
    
            return json_encode([
                'status'  => false,
                'message' => 'Failed to update record'
            ]);
        }
    }
    //$rows = $db->update("UPDATE tbl_users SET name = ? WHERE id = ?",[$name, $id]);
   
    public function DeleteFromTable($sql, $params = [])
    {
        try {
            $stmt = $this->varDBPDO->prepare($sql);
            $stmt->execute($params);
            Logger::ActivityLog('DeleteFromTable',$sql,$params);
            return json_encode([
                'status'  => true,
                'message' => 'Record deleted successfully',
                'data'    => [
                    'rows_affected' => $stmt->rowCount()
                ]
            ]);
    
        } catch (PDOException $e) {
    
            Logger::dbError(
                $e->getMessage(),
                $sql,
                $params
            );
    
            return json_encode([
                'status'  => false,
                'message' => 'Failed to delete record'
            ]);
        }
    }

    public function callProcedure($procedureName, $inputParams = [], $outputParams = [])
    {
        try {
            
            $inputPlaceholders = array_fill(0, count($inputParams), "?");
    
            $outputPlaceholders = array_map(function($p) { return "@$p"; }, $outputParams);
    
            $allPlaceholders = array_merge($inputPlaceholders, $outputPlaceholders);
            $placeholders = '';
            if (!empty($allPlaceholders)) {
                $placeholders = implode(", ", $allPlaceholders);
            }
    
            $callStatement = "CALL $procedureName" . (!empty($placeholders) ? "($placeholders)" : "()");
    
            $stmt = $this->varDBPDO->prepare($callStatement);
    
            foreach ($inputParams as $i => $value) {
                $stmt->bindValue($i + 1, $value); // PDO is 1-based for bindValue
            }
    
            $stmt->execute();
            $stmt->closeCursor();
    
            $outputValues = array();
            if (!empty($outputParams)) {
                $selectOutput = "SELECT " . implode(", ", array_map(function($p) { return "@$p AS $p"; }, $outputParams));
                $result = $this->varDBPDO->query($selectOutput);
                $outputValues = $result->fetch(PDO::FETCH_ASSOC);
            }
    
            return $outputValues;
    
        } catch (Exception $e) {
            throw new Exception("Error calling procedure '$procedureName': " . $e->getMessage());
        }
    }
    
    public function Begin()
    {
        $this->varDBPDO->beginTransaction();
    }
    
    public function Commit()
    {
        if ($this->varDBPDO->inTransaction()) {
        $this->varDBPDO->commit();
        }
        
    }
    
    public function Rollback()
    {
        if ($this->varDBPDO->inTransaction()) {
        $this->varDBPDO->rollBack();
    }
        
    }
    public function executeQuery($sql, $params = [])
        {
            $stmt = $this->varDBPDO->prepare($sql);
            return $stmt->execute($params);
        }
    public function selectexecuteQuery($sql, $params = [])
    {
        $stmt = $this->varDBPDO->prepare($sql);
        $stmt->execute($params);
        return $stmt; // ✅ FIX
    }
    public function JWTokenToRealJSON($JWTokenFromClient,$user_name)
    {
                $this->JWT = new JWTClass($_ENV['JWTKEY'],$_ENV['MAINSERVER'],$user_name); 
			    $JWToken=  $this->JWT->ReadJWToken($JWTokenFromClient);
			    if($JWToken['status'] === true){
                    $password = $JWToken['data']->token->password;
                    $encryption = new EncryptionHelper($_ENV['ENCRIPTION_KEY']);
                    $decriptPassword = $encryption->decrypt($password);
                    $JWToken['data']->token->password = $decriptPassword;
                    // Now $JWToken['data']->token->password contains decrypted password
                    // You can return it as JSON
                    return json_encode($JWToken);
                    
                } else {
                    return json_encode([
                        'status'  => false,
                        'message' => "Error : ".$JWToken['message']
                    ]);
                }
    }
    
    public function validateUser($data)
    {
        
                $username   = $data['data']['token']['username'];
                $password   = $data['data']['token']['password'];
                $company_id = $data['data']['token']['company_id'];
                $user_id    = $data['data']['token']['user_id'];
                
        $sql = "SELECT user_name, user_passkey, company_json
                FROM tbl_users
                WHERE user_id = :user_id
                AND user_name = :username
                AND user_status = 'Active'
                LIMIT 1";
    
        $stmt = $this->varDBPDO->prepare($sql);
    
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$row) {
            return ["status"=>false,"message"=>"User not found"];
        }
    
        // Check password
        if ($row['user_passkey'] != $password) {
            return ["status"=>false,"message"=>"Invalid password"];
        }
    
        // Decode company JSON
        $companies = json_decode($row['company_json'], true);
    
        foreach ($companies as $company) {
            if ($company['ids'] == $company_id) {
                return [
                    "status"=>true,
                    "message"=>"Login success"
                ];
            }
        }
    
        return ["status"=>false,"message"=>"Company not allowed"];
    }
    public function UserStatus($JWTokenFromClient)
	{
	     
			    $return = $this->JWTokenToRealJSON($JWTokenFromClient,'user');
			    $data = json_decode($return, true);
			   
			    $username   = $data['data']['token']['username'];
                $password   = $data['data']['token']['password'];
                $company_id = $data['data']['token']['company_id'];
                $user_id    = $data['data']['token']['user_id'];
			   
			    $validateStatus = $this->validateUser($data);
                $status = $validateStatus['status'];
                if($status==false){
                    return json_encode([
                        'status'  => false,
                        'message' => $validateStatus['message']
                    ]);
                }
                else
                {
                    return json_encode([
                        'status'  => true,
                        'message' => 'Validated'
                    ]);
                }
	}
  
    
}// Close of Class



class Logger
{
    private static function getLogPath($fileName = 'DB_ERROR')
    {
        
        $basePath = realpath(__DIR__ . '/../../logs');
    
        $year  = date('Y');
        $month = date('m');
        $date  = date('Y-m-d');
    
        $path = $basePath . "/$year/$month";
    
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    
        return $path . "/{$fileName}_{$date}.log";
    }
    public  static function getClientIP() {
        
        $ipKeys = [
            'HTTP_CLIENT_IP',        // Shared internet
            'HTTP_X_FORWARDED_FOR',  // Proxies / load balancers
            'HTTP_X_FORWARDED',      
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'            // Default fallback
        ];
    
        foreach ($ipKeys as $key) {
            if (!empty($_SERVER[$key])) {
                // Sometimes multiple IPs (comma separated)
                $ipList = explode(',', $_SERVER[$key]);
                foreach ($ipList as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP)) {
                        return $ip;
                    }
                }
            }
        }
    
        return 'UNKNOWN';
    }
    public static function getCurrentURL()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
    
        return $protocol . $host . $uri;
    }

    public static function dbError($message, $sql = '', $params = [])
    {
        $logFile = self::getLogPath('DB_ERROR');
        $url = self::getCurrentURL();
        $ip = self::getClientIP();
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'level'     => 'DB_ERROR',
            'url'       => $url,
            'clientip'  => $ip,
            'message'   => $message,
            'sql'       => $sql,
            'params'    => $params
            
        ];
    
        file_put_contents(
            $logFile,
            json_encode($logData, JSON_UNESCAPED_SLASHES) . PHP_EOL,
            FILE_APPEND
        );
    }
    public static function ActivityLog($message, $event = '', $params = [])
    {
        $logFile = self::getLogPath('ACTIVITY_LOG');
        $url = self::getCurrentURL();
        $ip = self::getClientIP();
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'level'     => 'ACTIVITY_LOG',
            'url'       => $url,
            'clientip'  => $ip,
            'message'   => $message,
            'event'     => $event,
            'params'    => $params
        ];
    
        file_put_contents(
            $logFile,
            json_encode($logData, JSON_UNESCAPED_SLASHES) . PHP_EOL,
            FILE_APPEND
        );
    }
    
    


}
