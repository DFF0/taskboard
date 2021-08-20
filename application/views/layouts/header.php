<header>
    <div class="container bg-light p-4">
        <? if ( isset($this->data['user_auth']) && !empty($this->data['user_auth']) ): ?>
            <form action="/user/exit/" method="post" class="form-inline">
                <div class="me-1"><?=$this->data['user_auth']['login']?></div>
                <button class="btn btn-primary btn-block">Выйти</button>
            </form>
        <? else: ?>
            <form action="/user/login/" method="post" class="form-inline">
                <div class="form-group me-1">
                    <input type="text" placeholder="Логин" name="login" class="form-control" maxlength="64"
                           value="" required
                    >
                </div>
                <div class="form-group me-1">
                    <input type="password" placeholder="Пароль" name="pass" class="form-control" maxlength="64"
                           value="" required
                    >
                </div>
                <button class="btn btn-primary btn-block">Войти</button>
            </form>
        <? endif; ?>
    </div>
</header>