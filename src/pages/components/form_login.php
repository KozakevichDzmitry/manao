<form action="auth/login" method="post" class="form" id="logInForm">
    <div class="form__body">
        <div class="form__item lift-animation">
            <div class="form__input-wrapper">
                <input class="form__input blur-checking" type="text" name="login" id="login"
                       data-required="login" placeholder="login">
                <label class="form__label form__label--anime" for="login">Login</label>
                <p class="form__input-error-message">Login is invalid. It should more 6 letters.</p>
            </div>
        </div>
        <div class="form__item lift-animation">
            <div class="form__input-wrapper">
                <input class="form__input blur-checking" type="password" name="password" id="password"
                       data-required="pass" placeholder="password">
                <label class="form__label form__label--anime" for="password">Password</label>
                <p class="form__input-error-message">Password is invalid. It should more 6 characters and consist of numbers and letters.</p>
            </div>
        </div>
    </div>
    <p class="form__error-message"></p>
    <div class="form__bottom">
        <div class="form__bottom-button lift-animation-btn">
            <button class="button button-animated" type="submit">Log in</button>
        </div>
    </div>
</form>