<main>
    <h1>Login</h1>
    
    <?php if ($data->loginError === true) {
    ?>
    <div class="message alert">username or password are incorrect</div>
    <?php 
} ?>
    
    <form method="post" action="<?php echo URL; ?>dologin">
        <fieldset>
            <div>
                <label for="user">user name</label>
                <input name="user" id="user" type="text" size="48"/>
            </div>
            <div>
                <label for="password">password</label>
                <input name="password" id="password" type="password"  size="48"/>
            </div>
            <div>
            <button type="submit">login</button>
            </div>
        </fieldset>
    </form>
</main>
