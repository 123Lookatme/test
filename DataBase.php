<?php

class DataBase
{
    private  $DB_connect;
    private static $instance;
    static $offset=0;

    private function __construct()
    {
        $this->DB_connect= mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
        mysql_select_db(DB_NAME, $this->DB_connect);
    }

    private function __clone(){}
//Singleton pattern
    public static function getInstance()
    {
        self::$instance?:self::$instance=new self;
        return self::$instance;
    }
//Добавление записей пользователей
    public function insert($post,$file)
    {
        $theme=$post['theme'];$mail=$post['mail'];$msg=nl2br($post['text']);$date=time();
        if($file)
            $query=("INSERT INTO ".TABLE_NAME." (theme,mail,msg,file,date) VALUES ('".$theme ."','".$mail."','".$msg."','".$file."','".$date."')");
        else
            $query=("INSERT INTO ".TABLE_NAME." (theme,mail,msg,date) VALUES ('".$theme."','".$mail."','".$msg."','".$date."')");
        mysql_query($query) or die(mysql_error());
        return TRUE;
    }
//Общее кол-во записей
    public function num_rows()
    {
        $query=("SELECT * FROM ".TABLE_NAME." ");
        $result=mysql_query($query);
        $num=mysql_num_rows($result);
        return $num;
    }
//pagination
    public function get_pages($limit,$offset,$order='ORDER BY date', $option='DESC')
    {
        $result=array();
        $query=("SELECT theme,mail,msg,file,date FROM ".TABLE_NAME." ".$order." ".$option." LIMIT ".$limit." "." OFFSET ".$offset." " );

        $rows= mysql_query($query) or die(mysql_error());
        while($row=mysql_fetch_assoc($rows))
        {
            $result[]=$row;
        }
        return $result;

    }
//Проверка админа
    public function login($post)
    {
        if(is_array($post))
        {
            $login=$post['login'];$pass=$post['pass'];
            $query=("SELECT* FROM ".TABLE_USERS." ");
            $rows=mysql_query($query);
            $row=mysql_fetch_assoc($rows);
            if($row['login']==$login && $row['password']==$pass)
            {
                return TRUE;
            }
            else
                return FALSE;
        }
        else
            return FALSE;

    }
}