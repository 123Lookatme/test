<?php
session_start();

class Controller{

    private $get;
    private $post;
    private $file;
    static $instance;
    private $db;

    private function __construct()
    {
        $this->get=$_GET;
        $this->post=$_POST;
        $this->db=DataBase::getInstance();
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
            $str=strtolower(substr(strrchr($file['name'],'.'),0));
            $this->file=time().$str;
            move_uploaded_file($file['tmp_name'],UPLOAD_DIR.$this->file);
            return TRUE;
        }
        else
            return FALSE;
    }

               //Pagination
    public function pagination($limit)
    {
        $result=array();
        $rows=$this->db->num_rows();
        $max_pages=ceil($rows/$limit);
        $page=$this->get['page'];
        if($page<=0)$page=1;
        if($page>$max_pages) $page=$max_pages;
        $list=$page-1;
        $offset=$list*$limit;
        if($page==1)$offset=0;
        if($page==2)$offset=$limit;
        $query=$this->db->get_pages($limit,$offset);
        if(!empty($query))
        {
            array_push($result,$max_pages,$query);
            return $result;
        }
        else return FALSE;

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
                                    //Загрузка файла с сервера
                    case 'file' :  $file_name=$this->get['file'];
                                    if (is_file(UPLOAD_DIR.$file_name))
                                    {
                                        $file=strtolower(substr(strrchr($file_name,'.'),1));

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
                                    }break;
                    case'exit': session_unset($_SESSION['check']);header('Location:index.php');break;

                }
            }
        }           //Главная страница
        else
            include_once('pages/main.php');
    }
}
