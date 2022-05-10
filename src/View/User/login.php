<div class="col-md-4">
    <form method="POST" action="/user/login">
        <div class="form-group">
            <label class="" for="mail">Adresse Mail</label>
            <input class="form-control" type="email" name="email" id="email">
        </div>
        <div class="form-group">
            <label class="" for="pass">Password</label>
            <input class="form-control" type="password" name="password" id="password">
        </div>
        <input class="btn btn-primary" type="submit" value="Envoyer">
    </form>
    <p><a href="/user/add">Vous n'avez pas de compte ?</a></p>
</div>