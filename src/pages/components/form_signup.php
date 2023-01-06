<form action="auth/signup" method="post" class="form" id="signUpForm">
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
                <input class="form__input blur-checking" type="text" name="name" id="name"
                       data-required="name" placeholder="name">
                <label class="form__label form__label--anime" for="name">Name</label>
                <p class="form__input-error-message">Name is invalid.It should more 2 letters and consist only letters.</p>
            </div>
        </div>
        <div class="form__item lift-animation">
            <div class="form__input-wrapper">
                <input class="form__input blur-checking" type="email" name="email" id="email"
                       data-required="email" placeholder="email">
                <label class="form__label form__label--anime" for="email">E-mail</label>
                <p class="form__input-error-message">E-mail is invalid.</p>
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
        <div class="form__item lift-animation">
            <div class="form__input-wrapper">
                <input class="form__input blur-checking" type="password" name="confirmPassword"
                       id="confirmPassword" data-required="pass-confirm" placeholder="password">
                <label class="form__label form__label--anime" for="confirmPassword">Confirm Password</label>
                <p class="form__input-error-message">"Confirm password" and password should match.</p>
            </div>
        </div>
    </div>
    <p class="form__error-message"></p>
    <p class="form__success-message"></p>
    <div class="form__bottom">
        <div class="form__bottom-button lift-animation-btn">
            <button class="button button-animated" type="submit">Sign up</button>
        </div>
    </div>
</form>
