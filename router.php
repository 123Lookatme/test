<?php
session_start();

class Router{

    private $get;
    private $post;
    private $file;
    static $instance;
    private $db;
    public $num_rows;

    private function __construct()
    {
        $this->get=$_GET;
        $this->post=$_POST;
        $this->db=DataBase::getInstance();
        $this->num_rows=$this->db->num_rows();
    }

    private function __clone(){}
                    ////Singleton pattern
    public static function getInstance()
    {
        self::$instance?:self::$instance=new self;
        return self::$instance;
    }
                    //загрузка файла на сервер
    public function file_upload($file)
    {

        if(is_uploaded_file($file['tmp_name']))
        {
            $pos=strpos($file['name'],".");
            $str=substr($file['name'],$pos);
            $this->file=time().$str;
            move_uploaded_file($file['tmp_name'],UPLOAD_DIR.$this->file);
            return TRUE;
        }
        else
            return FALSE;
    }
                    //выборка блоков из БД
    public function get_content($limit,$offset)
    {
        $result=$this->db->get_pages($offset,$limit);
        return $result;
    }


    public function route()
    {
        if($this->post)
            foreach($this->post as $k=>$v)
            {
                switch ($k)
                {
                    //Проверка логина, пароля
                    case 'submit': if($this->db->login($this->post))
                                            $_SESSION['check']=TRUE;
                                    else
                                            $_SESSION['check']=FALSE;break;
                    //Отправка сообщений пользователей
                    case 'send':  if(!empty($this->post['theme'])&& !empty($this->post['mail'])&& !empty($this->post['text']))
                                  {
                                      $this->file_upload($_FILES['file']);
                                      $result=$this->db->insert($this->post,$this->file);
                                      if($result)
                                          echo"<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> Сообщение успешно отправлено</div>";;exit;break;
                                  }
                                  else
                                      echo "<div class='new_container3'><div class='alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign'></span> Не все поля заполнены</div></div>";

                }
            }
        if($this->get)
        {
            foreach($this->get as $key=>$val)
            {
                switch($key)
                {                   //если уже прошел логин перенаправляем на страницу с блоками
                                    //если нет - обратно на регистрацию
                    case 'admin':   if(isset($_SESSION['check']) &&$_SESSION['check']==TRUE)
                                        header('Location:index.php?page=1');
                                    else
                                        include_once('pages/login.php');break;
                                     //если уже прошел логин перенаправляем на страницу с блоками
                                     //если нет - обратно на регистрацию
                    case 'page' :   if($_SESSION['check']==TRUE)
                                    {
                                        include_once('pages/admin.php');break;
                                    }
                                    else
                                        header('Location:index.php?admin=login');break;
                                    //
                    case 'file' :  $file_name=$_GET['file'];
                                    if (is_file(UPLOAD_DIR.$file_name))
                                    {
                                        $file=strtolower(substr(strrchr($file_name,'.'),1));
                                        echo basename($file_name);

                                        switch($file)
                                        {
                                            case 'pdf': $type = 'application/pdf'; break;
                                            case 'zip': $type = 'application/zip'; break;
                                            case 'doc':
                                            case 'docx': $type = 'application/msword';break;
                                            case 'jpeg':
                                            case 'jpg': $type = 'image/jpeg'; break;
                                            case 'gif': $type= 'image/gif';break;
                                            case 'bmp': $type= 'image/bmp';break;
                                            default: $type = 'application/force-download';
                                        }
                                            header('Pragma: public');
                                            header('Expires: 0');
                                            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                                            header('Content-Type: '.$type);
                                            header('Content-Disposition: attachment; filename='.basename($file_name));
                                            header('Content-Transfer-Encoding: binary');
                                            header('Content-Length: '.filesize(UPLOAD_DIR.$file_name));
                                            ob_clean();
                                            flush();
                                            readfile(UPLOAD_DIR.$file_name);
                                            exit();
                                    }

                }
            }
        }           //Главная страница
        else
            include_once('pages/main.php');
    }
}