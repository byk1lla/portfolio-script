

<?php
class Main{
  public $log;
  public $url;
  public $user;
  public function var_Assign(){
    $this->log = new Log();
    $this->url = $_SERVER['REQUEST_URI'];
    $this->user = new User();
  }
  public function errorDisplay(Exception $message){
      return "An Error Occured!
    Type->" . get_class($message)."
    Message->" . $message->getMessage();
  }
}
class SQL extends Main{
  
public $conn;
    public function connect(){
      $this->url = $_SERVER['REQUEST_URI'];
      $host = "localhost";
      $dbname = "godless";
      $username = "root";
      $password = "";
      
      try{
        $this->conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return true;
      }
      catch(Exception $ex){
        $this->log->error($this->url,$ex->getMessage());
        $this->conn = null;
        throw $ex;
      }
    }
}
class User extends SQL {
  private $visit = 0;
  function getuserid($username){
    try{
      if (!$this->connect()) {
        $this->log->error($this->url,"Database is Offline!");
        throw new PDOException("Database Offline!");
      }
      $stmt = $this->conn->prepare("SELECT unique_id as userid from users where username = :username");
      $stmt->bindParam(":username",$username,PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result['userid'];
    }
    catch(Exception $ex){
        define("log", new Log());
        log->error($this->url,$this->errorDisplay($ex));
        throw $ex;
    }
  }
  function updateLastLogin($userid){
    $this->url = $_SERVER['REQUEST_URI'];
    if (!$this->connect()) {
      $this->log->error($this->url,"Database is Offline!");
      throw new PDOException("Database Offline!");
    }
    else{
      $stmt = $this->conn->prepare("UPDATE users SET last_visit = NOW() where userid= :userid");
      $stmt->bindParam(":userid",$userid);
    }
  }
  function getLastvisit($userid){
    $this->url = $_SERVER['REQUEST_URI'];
    if (!$this->connect()) {
      $this->log->error($this->url,"Database is Offline!");
      throw new PDOException("Database Offline!");
    }
    else{
      try{
        $stmt = $this->conn->prepare("SELECT last_visit from user_visitors where userid = :user_id");
        $stmt->bindParam(":user_id",$userid,PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['last_visit'];
      }
      catch(Exception $ex){
          throw $ex;
      }
    }
  }
  function getvisit($userid){
    $this->url = $_SERVER['REQUEST_URI'];
    if (!$this->connect()) {
      $this->log->error($this->url,"Database is Offline!");
      throw new PDOException("Database Offline!");
    }
    try{
        $stmt = $this->conn->prepare("SELECT visitcount from user_visitors where userid = :user_id");
        $stmt->bindParam(":user_id",$userid,PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['visitcount'] ?? 0;
    }
    catch(Exception $ex){
        $this->log->error($this->url,$this->errorDisplay($ex));
        throw $ex;
    }
    
  
  }
  function addVisit($userid){
    $this->url = $_SERVER['REQUEST_URI'];
    if (!$this->connect()) {
      $this->log->error($this->url,"Database is Offline!");
      throw new PDOException("Database Offline!");
    }
    else{
      try{
        $visit =+ 1;
        $stmt = $this->conn->prepare("INSERT INTO uservisitors (user_id, visitcount,last_visit) 
                                        VALUES (:user_id, :visit, NOW())");
            $stmt->bindParam(":user_id", $userid);
            $stmt->bindParam(":visit",$visit);
        return true;
      }
      catch(Exception $ex){
        $this->log->error($this->url,$this->errorDisplay($ex));
        throw $ex;
      }
    }
  }
  function login($userid,$device,$browser){
    $this->url = $_SERVER['REQUEST_URI'];
    if (!$this->connect()) {
        throw new PDOException("Database Offline!");
    }
    else{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        try {
            $arr = [
                'userid' => $userid,
                'ip' => $_SERVER['REMOTE_ADDR'],
                'device' => $device,
                'browser' => $browser
            ];
            $stmt = $this->conn->prepare("INSERT INTO login_log (user_id, IP, device, browser, last_login) 
                                        VALUES (:user_id, :IP, :device, :browser, NOW())");
            $stmt->bindParam(":user_id", $arr['userid']);
            $stmt->bindParam(":IP", $arr['ip']);
            $stmt->bindParam(":device", $arr['device']);
            $stmt->bindParam(":browser", $arr['browser']);
    
            $stmt->execute();
        } catch (Exception $ex) {
          $this->log->error($this->url,$this->errorDisplay($ex));
          throw $ex;
        }
      }
    }
    }
  public function generateimgname($userid,$username){
    $date = date("Ymd_His");  
    $filename = $username. "-" . $userid . "_" . $date;
    return $filename;    
  }
  public function isloggedin(){
    if(isset($_SESSION['userid'])){
      return true;
    }
    else{
      return false;
    }
  }
  private function generateRandomChars($length) {
      $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $randomChars = "";
      for ($i = 0; $i < $length; $i++) {
          $randomChars .= $chars[rand(0, strlen($chars) - 1)];
      }
      return $randomChars;
  }

  public function generateID($username) {
      $dateTime = date("dmYHis"); 
      $randomChars = $this->generateRandomChars(10); 

      $uniqueId = $dateTime . "-" . $randomChars . "-" . $username;

      if (strlen($uniqueId) > 20) {
          $uniqueId = substr($uniqueId, 0, 20);
      }

      return $uniqueId;
  }
}
class Log {
  public $logPath;
  private function getLogFilename($logType) {
    date_default_timezone_set("UTC");
    $date = date("m_d_Y");
    return "{$this->logPath}{$logType}-{$date}.log";
  }
  private function writeLog($file, $content) {
    $timestamp = date("Y/m/d H:i:s");
    $logEntry = "[$timestamp] $content\n";
    file_put_contents($file, $logEntry, FILE_APPEND | LOCK_EX);
  }
  public function error($file, $content) {
    $logFilename = $this->getLogFilename("error");
    $this->writeLog($logFilename, "[ERROR][$file] $content");
  }
  public function activity($file, $content) {
    $logFilename = $this->getLogFilename("activity");
    $this->writeLog($logFilename, "[ACTIVITY][$file] $content");
  }
  public function sys($file, $content) {
    $logFilename = $this->getLogFilename("SYSYTEM");
    $this->writeLog($logFilename, "[SYSTEM][$file] $content");
  }
  public function alert($file, $content) {
    $logFilename = $this->getLogFilename("alert");
    $this->writeLog($logFilename, "[ALERT][$file] $content");
  }
  public function info($file, $content) {
    $logFilename = $this->getLogFilename("info");
    $this->writeLog($logFilename, "[INFO][$file] $content");
  }
}


class Portfolio extends SQL {
  
  public function check($user_id){
    $this->url = $_SERVER['REQUEST_URI'];
    if (!$this->connect()) {
      $this->log->error($this->url,"Database is Offline!");
      throw new PDOException("Database Offline!");
    }
    try{
      
      $stmt = $this->conn->prepare("SELECT COUNT(user_id) as cc FROM portfolio WHERE user_id = :user_id");
      $stmt->bindParam(":user_id",$user_id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if($result['cc'] > 0){
        return true;
      }
      else{
        return false;
      }
    }
    catch (Exception $ex) {
      $this->log->error($this->url,$this->errorDisplay($ex));
      throw $ex;
    }
  }
  public function getPost($username) {
    $this->url = $_SERVER['REQUEST_URI'];
    if (!$this->connect()) {
      $this->log->error($this->url,"Database is Offline!");
      throw new PDOException("Database Offline!");
    }
    try {
      $user = new User();
      $user_id = $user->getuserid($username);
      $stmt = $this->conn->prepare("SELECT * FROM portfolio WHERE user_id = :user_id");
      $stmt->bindParam(":user_id",$user_id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;
    } catch (Exception $ex) {
      
      throw $ex;
    }
  }
  public function addPost($user_id, $title, $description,$sign, $pic_path, $link1, $link2, $link3, $link4, $link5, $link6, $visit_count, $last_visit) {
    
    $this->url = $_SERVER['REQUEST_URI'];
    $this->log = new Log();
    try{
      if (!$this->connect()) {
        $this->log->error($this->url,"Database is Offline!");
        throw new PDOException("Database Offline!");
      }
        $stmt = $this->conn->prepare("INSERT INTO portfolio (user_id, title, description,sign, pic_path, link1, link2, link3, link4, link5, link6, visit_count, last_visit) 
        VALUES (:user_id, :title, :description, :sign, :pic_path, :link1, :link2, :link3, :link4, :link5, :link6, :visit_count, :last_visit)");
        $stmt->bindParam(":user_id",$user_id);
        $stmt->bindParam(":title",$title);
        $stmt->bindParam(":description",$description);
        $stmt->bindParam(":sign",$sign);
        $stmt->bindParam(":pic_path",$pic_path);
        $stmt->bindParam(":link1",$link1);
        $stmt->bindParam(":link2",$link2);
        $stmt->bindParam(":link3",$link3);
        $stmt->bindParam(":link4",$link4);
        $stmt->bindParam(":link5",$link5);
        $stmt->bindParam(":link6",$link6);
        $stmt->bindParam(":visit_count",$visit_count);
        $stmt->bindParam(":last_visit",$last_visit);
        $stmt->execute();
        
      }
    catch(Exception $ex){
        
        $this->log->error($this->url,$this->errorDisplay($ex));
        throw $ex;
    }
}
public function editPost($user_id, $title, $description,$sign, $pic_path, $link1, $link2, $link3, $link4, $link5, $link6, $visit_count, $last_visit) {
  $this->url = $_SERVER['REQUEST_URI'];
  if (!$this->connect()) {
    $this->log->error($this->url,"Database is Offline!");
    throw new PDOException("Database Offline!");
  }
    try{
        $stmt = $this->conn->prepare("UPDATE portfolio SET user_id=?, title=?, description=?, sign=?, pic_path=?, link1=?, link2=?, link3=?, link4=?, link5=?, link6=?, visit_count=?, last_visit=? WHERE user_id=?");
        $stmt->execute([$user_id, $title, $description,$sign, $pic_path, $link1, $link2, $link3, $link4, $link5, $link6, $visit_count, $last_visit,$user_id]);
    }  
    catch(Exception $ex){
        throw $ex;
    }
}
}
?>