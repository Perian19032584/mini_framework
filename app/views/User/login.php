<h2 class="text-center">Авторизация</h2>


<div class="row">
    <div class="col-md-6">
        <form action="/user/login" method="post">
            <div class="form-group">
                <label for="login">Email</label>
                <input type="text" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="login">Пароль</label>
                <input type="text" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-dark">Авторизация</button>
        </form>
    </div>
</div>