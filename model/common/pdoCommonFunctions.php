<?php


abstract class FunctionDefinitions
{
    abstract public function ListFromTable($SQL);
    abstract public function AddToTable($SQL);
    abstract public function UpdateTable($SQL);
    abstract public function DeleteFromTable($SQL);
    abstract public function AddToTableAndReturnSpecifiedColumn($sql,$retColumnName,$tableName);
    abstract public function Begin();
    abstract public function Commit();
    abstract public function Rollback();
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

    //$db->delete("DELETE FROM tbl_users WHERE id = ?",[$id]);
    
    public function Begin()
    {
        $this->varDBPDO->beginTransaction();
    }
    
    public function Commit()
    {
        $this->varDBPDO->commit();
    }
    
    public function Rollback()
    {
        $this->varDBPDO->rollBack();
    }
    
  
    
}



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
