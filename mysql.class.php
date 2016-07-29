<?php

// mysql连接类 
// author: bluemaple , emaile: bluemaple@x263.net 
// 可以执行一般mysql命令，如insert,delete,select,update 
// 使用方法：在需要的文件前面加入 
// require("./mysql.class.php"); 
// $DB=new DB_MYSQL;            // 加载类 
// $DB->dbServer="localhost";   // 连接数据库地址 
// $DB->dbUser="root";          // 用户名 
// $DB->dbPwd="";               // 密码 
// $DB->dbDatabase="we";        // 数据库名称 
// $DB->connect();             // 连接数据库 
// 使用中可以更改数据库 
// 可以用到的函数说明 
// query($sql,$dbbase);         // 可以直接执行 
// query_first($sql,$dbbase);   // 查询返回只有一条记录,$sql为sql语句，$dbbase为你选者数据库（可以不要） 
// fetch_array($sql,$dbbase);   // 查询返回一组记录，可以用num_rows得到返回的数字 
// insert,update,delete 皆为执行命令，其中可用$affected_rows;得到返回的数目 
// 在insert时，可以用insert_id得到插入结果的返回id数 
// count_records($table,$index,$where,$dbbase)// 为得到一个表记录的数目，$table为表名，$index为key，$where为条件，$dbbase为数据库，后两个可以不选 
//####################### End Introduce ######################################## 
class DB_MYSQL {          // 数据库mysql查询的类  

    var $dbServer;        // 数据库连接服务地址 
    var $dbDatabase;      // 所选择的数据库,初始状态 
    var $dbbase = "";       // 后面可以改变的 
    var $dbUser;          // 登陆用户名 
    var $dbPwd;           // 登陆用户密码
    var $dbcharset;    // 编码  
    var $dbLink;          // 数据库连接指针 
    var $query_id;        // 执行query命令的指针 
    var $num_rows;        // 返回的条目数 
    var $insert_id;       // 传回最后一次使用 INSERT 指令的 ID 
    var $affected_rows;   // 传回query命令所影响的列数目 

    // INSERT、UPDATE 或 DELETE 所影响的列 (row) 数目。 
    // delete 如果不带where，那么则返回0 

    /* 连接数据库函数,包括连接数据库 */
    function connect($dbbase = "") {
        global $usepconnect;   // 是否采用永久连接，$userpconnect在外部设置。 
        if ($usepconnect == 1) {
            $this->dbLink = @mysql_pconnect($this->dbServer, $this->dbUser, $this->dbPwd);
        } else {
            $this->dbLink = @mysql_connect($this->dbServer, $this->dbUser, $this->dbPwd);
        }

        if (!$this->dbLink) {
            $this->halt("连接出错，无法连接！！！");
        }
        if ($dbbase == "") {
            $dbbase = $this->dbDatabase;
        }
        if (!mysql_select_db($dbbase, $this->dbLink)) {  // 连接数据库 
            $this->halt("不能够用这个数据库，请检查这个数据库是否正确！！！");
        }
        mysql_query("SET NAMES $this->dbcharset");
    }

    /* 改变数据库 */
    function change_db($dbbase = "") {
        $this->connect($dbbase);
    }

    /* 返回一个值的sql命令 */
    function query_first($sql, $dbbase = "") {
        $query_id = $this->query($sql, $dbbase);
        $returnarray = mysql_fetch_array($query_id);
        $this->num_rows = mysql_num_rows($query_id);
        $this->free_result($query_id);
        return $returnarray;
    }

    /* 返回一个值的sql命令 */
    function fetch_array($sql, $dbbase = "", $type = 0) {//type为传递值是name=>value,还是4=>value 
        $array = array();
        $query_id = $this->query($sql, $dbbase);
        $this->num_rows = mysql_num_rows($query_id);
        for ($i = 0; $i < $this->num_rows; $i++) {
            if ($type == 0) {
                $array[$i] = mysql_fetch_array($query_id);
            } else {
                $array[$i] = mysql_fetch_row($query_id);
            }
        }
        $this->free_result($query_id);
        return $array;
    }

    /* 删除命令 */
    function delete($sql, $dbbase = "") {
        $query_id = $this->query($sql, $dbbase);
        $this->affected_rows = mysql_affected_rows($this->dbLink);
        $this->free_result($query_id);
    }

    /* 插入命令 */
    function insert($sql, $dbbase = "") {
        $query_id = $this->query($sql, $dbbase);
        $this->insert_id = mysql_insert_id($this->dbLink);
        $this->affected_rows = mysql_affected_rows($this->dbLink);
        $this->free_result($query_id);
    }

    /* 更新命令 */
    function update($sql, $dbbase = "") {
        $query_id = $this->query($sql, $dbbase);
        $this->affected_rows = mysql_affected_rows($this->dbLink);
        $this->free_result($query_id);
    }

    /* 记录总共表的数目 */
    //where为条件,dbbase为数据库,index为所选key，默认为id 
    function count_records($table, $index = "id", $where = "", $dbbase = "") {
        if ($dbbase != "")
            $this->change_db($dbbase);
        $result = @mysql_query("select count(" . $index . ") as 'num' from $table " . $where, $this->dbLink);
        if (!$result)
            $this->halt("错误的SQL语句: " . $sql);
        @$num = mysql_result($result, 0, "num");
        return $num;
    }

    /* 执行queyr指令 */
    function query($sql, $dbbase = "") {
        if ($dbbase != "")
            $this->change_db($dbbase);
        $this->query_id = @mysql_query($sql, $this->dbLink);
        if (!$this->query_id)
            $this->halt("错误的SQL语句: " . $sql);
        return $this->query_id;
    }

    /* 数据库出错，无法连接成功 */
    function halt($errmsg) {
        $msg = "<h3><b>数据库出错!</b></h3><br>";
        $msg.=$errmsg;
        echo $msg;
        die();
    }

    /* 释放query选者 */
    function free_result($query_id) {
        @mysql_free_result($query_id);
    }

    /* 开启事务 */
    function begin() {
        mysql_query('start transaction');
    }

    /* 提交事务 */
    function commit() {
        mysql_query('commit');
    }

    /* 回滚事务 */
    function rollback() {
        mysql_query('rollback');
    }

    /* 关闭数据库连接 */

    function close() {
        mysql_close($this->dbLink);
    }

}

?>