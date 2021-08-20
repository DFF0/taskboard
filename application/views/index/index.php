<? if ( isset($this->data['error_message']) && !empty($this->data['error_message']) ): ?>
    <div class="alert alert-danger" role="alert">
        <?=$this->data['error_message']?>
    </div>
<? endif; ?>
<? if ( isset($this->data['success_message']) && !empty($this->data['success_message']) ): ?>
    <div class="alert alert-success" role="alert">
        <?=$this->data['success_message']?>
    </div>
<? endif; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        Новая задача
    </div>
    <div class="panel-body">
        <form action="/taskboard/add/" method="post">
            <div class="form-group mb-3">
                <label for="name">Имя</label>
                <input id="name" type="text" name="name" class="form-control" maxlength="64" value="" required>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input id="email" type="text" name="email" class="form-control" maxlength="64" value="" required>
            </div>
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>

            <div class="line-dashed"></div>

            <div class="d-flex justify-content-end">
                <button class="btn btn-primary btn-block">Создать</button>
            </div>
        </form>
    </div>
</div>

<nav aria-label="Page navigation">
    <ul class="pagination">
        <li class="page-item disabled">
            <span class="page-link">Сортировать:</span>
        </li>
        <li class="page-item <?=($this->data['sort'] == 'id' && $this->data['dir'] == 'asc')? 'active' : ''?>">
            <a class="page-link" href="/?sort=id&dir=asc">По умолчанию</a>
        </li>
        <li class="page-item <?=($this->data['sort'] == 'name' && $this->data['dir'] == 'desc')? 'active' : ''?>">
            <a class="page-link" href="/?sort=name&dir=desc">Имя ▼</a>
        </li>
        <li class="page-item <?=($this->data['sort'] == 'name' && $this->data['dir'] == 'asc')? 'active' : ''?>">
            <a class="page-link" href="/?sort=name&dir=asc">Имя ▲</a>
        </li>
        <li class="page-item <?=($this->data['sort'] == 'email' && $this->data['dir'] == 'desc')? 'active' : ''?>">
            <a class="page-link" href="/?sort=email&dir=desc">Почта ▼</a>
        </li>
        <li class="page-item <?=($this->data['sort'] == 'email' && $this->data['dir'] == 'asc')? 'active' : ''?>">
            <a class="page-link" href="/?sort=email&dir=asc">Почта ▲</a>
        </li>
        <li class="page-item <?=($this->data['sort'] == 'is_completed' && $this->data['dir'] == 'desc')? 'active' : ''?>">
            <a class="page-link" href="/?sort=is_completed&dir=desc">Статус ▼</a>
        </li>
        <li class="page-item <?=($this->data['sort'] == 'is_completed' && $this->data['dir'] == 'asc')? 'active' : ''?>">
            <a class="page-link" href="/?sort=is_completed&dir=asc">Статус ▲</a>
        </li>
    </ul>
</nav>

<nav aria-label="Page navigation">
    <ul class="pagination">
        <li class="page-item <?=($this->data['cur_page'] <= 1)? 'disabled' : ''?>">
            <a class="page-link" href="/?page=<?=$this->data['cur_page']-1?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <? for ($i = 1; $i <= $this->data['max_page']; $i++): ?>
            <li class="page-item <?=($i == $this->data['cur_page'])? 'active' : ''?>">
                <a class="page-link" href="/?page=<?=$i?>"><?=$i?></a>
            </li>
        <? endfor; ?>
        <li class="page-item <?=($this->data['cur_page'] >= $this->data['max_page'])? 'disabled' : ''?>">
            <a class="page-link" href="/?page=<?=$this->data['cur_page']+1?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>

<? foreach ( $this->data['tasks'] as $task ): ?>
    <? if ( empty($this->data['user_auth']) ): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <? if ( $task['is_completed'] ): ?>
                    <span class="btn btn-sm btn-outline-success me-1">Завершено</span>
                <? endif; ?>
                <? if ( $task['is_edited'] ): ?>
                    <span class="btn btn-sm btn-outline-warning">Отредактировано</span>
                <? endif; ?>
            </div>
            <div class="panel-body">
                <div class="form-group mb-3">
                    <label for="name<?=$task['id']?>">Имя</label>
                    <input id="name<?=$task['id']?>" type="text" class="form-control" maxlength="64" value="<?=htmlspecialchars($task['name'], ENT_QUOTES)?>" required readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="email<?=$task['id']?>">Email</label>
                    <input id="email<?=$task['id']?>" type="text" class="form-control" maxlength="64" value="<?=htmlspecialchars($task['email'], ENT_QUOTES)?>" required readonly>
                </div>
                <div class="form-group">
                    <label for="description<?=$task['id']?>">Описание</label>
                    <textarea id="description<?=$task['id']?>" class="form-control" required readonly><?=$task['description']?></textarea>
                </div>
            </div>
        </div>
    <? else: ?>
        <div class="panel panel-default">
            <div class="panel-heading d-flex">
                <div class="d-flex">
                    <? if ( $task['is_completed'] ): ?>
                        <div class="btn btn-sm btn-outline-success me-1">Завершено</div>
                    <? else: ?>
                        <form action="/taskboard/complete/" method="post">
                            <input type="hidden" name="id" value="<?=$task['id']?>">
                            <button class="btn btn-sm btn-success btn-block me-3">Завершить</button>
                        </form>
                    <? endif; ?>

                    <? if ( $task['is_edited'] ): ?>
                        <div class="btn btn-sm btn-outline-primary">Отредактировано</div>
                    <? endif; ?>
                </div>
            </div>
            <div class="panel-body">
                <form action="/taskboard/edit/" method="post">
                    <input type="hidden" name="id" value="<?=$task['id']?>">
                    <div class="form-group mb-3">
                        <label for="nameA<?=$task['id']?>">Имя</label>
                        <input id="nameA<?=$task['id']?>" type="text" name="name" class="form-control" maxlength="64" value="<?=htmlspecialchars($task['name'], ENT_QUOTES)?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="emailA<?=$task['id']?>">Email</label>
                        <input id="emailA<?=$task['id']?>" type="text" name="email" class="form-control" maxlength="64" value="<?=htmlspecialchars($task['email'], ENT_QUOTES)?>" required>
                    </div>
                    <div class="form-group">
                        <label for="descriptionA<?=$task['id']?>">Описание</label>
                        <textarea id="descriptionA<?=$task['id']?>" name="description" class="form-control" required><?=$task['description']?></textarea>
                    </div>

                    <div class="line-dashed"></div>

                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary btn-block">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    <? endif; ?>
<? endforeach; ?>
