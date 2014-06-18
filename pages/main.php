

<div class="new_container">

    <div class="panel panel-primary">
        <div class="panel-heading">Оставте ваше сообщение</div>
        <div class="panel-body">
            <form method="POST" enctype="multipart/form-data"action="index.php" role="form">
                <div class="form-group">
                    <label for="text">Тема сообщения</label>
                    <input type="text" name="theme" class="form-control"id="text">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Ваш Email</label>
                    <input type="email" name="mail" class="form-control" id="exampleInputEmail1" placeholder="Введите email">
                </div>

                <div class="form-group">
                    <label for="TextArea">Введите сообщение</label>
                    <textarea name="text" class="form-control" rows="4" id="TextArea"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Прикрепить файл</label>
                    <input type="file" name="file" id="exampleInputFile">
                    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                </div>

                <button type="submit" name="send" class="btn btn-primary">Отправить</button>
            </form>
        </div>
    </div>
</div>