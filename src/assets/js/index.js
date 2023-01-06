window.onload = function() {
    const form = document.querySelector('form')
    if (form) {
        const elemWithLiftAnimation = document.querySelectorAll('.lift-animation')
        const deleteALLMarksErrors = (classError) => {
            const inputsWithError = document.querySelectorAll(`.${classError}`)
            inputsWithError.forEach(elem => elem.classList.remove(`${classError}`))
        }
        const markErrorsFields = (errors) => {
            deleteALLMarksErrors('form__input--invalid')
            for (let key in errors) {
                document.querySelector(`#${key}`).classList.add('form__input--invalid')
                document.querySelector(`#${key} ~ .form__input-error-message`).textContent = errors[key]
            }
        }
        const addAuthMessage = (message, className) => {
            const errorBlock = document.querySelector(`.${className}`)
            if (errorBlock) {
                errorBlock.textContent = message
                errorBlock.classList.add('active')
            }
        }
        const deleteAuthMessage = (className) => {
            const errorBlock = document.querySelector(`.${className}`)
            if (errorBlock) {
                errorBlock.textContent = ''
                errorBlock.classList.remove('active')
            }
        }
        const validareForm = className => {
            const validateElems = document.querySelectorAll(`.${className}`)
            const errorClass = 'form__input--invalid';
            let validForm = true
            validateElems.forEach(elem => {
                const field = elem.dataset.required
                const value = elem.value
                const error = () => {
                    elem.classList.add(errorClass)
                    validForm = false
                }
                switch (field) {
                    case 'login':
                        value.trim().length < 6 ? error() : elem.classList.remove(errorClass);
                        break
                    case 'name':
                        /^(?=.*[a-zA-ZА-Яа-яЁё]).{2,}/.test(value.trim()) ? elem.classList.remove(errorClass) : error();
                        break
                    case 'email':
                        value.trim().match(
                            /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                        ) ? elem.classList.remove(errorClass) : error();
                        break
                    case 'pass':
                        /^(?=.*[a-zA-ZА-Яа-яЁё])(?=.*[0-9]).{6,}/.test(value) ? elem.classList.remove(errorClass) : error();
                        break
                    case 'pass-confirm':
                        document.querySelector(`.${className}[data-required="pass"]`).value === value ? elem.classList.remove(errorClass) : error();
                        break
                }
            })
            return validForm
        }

        document.documentElement.style.setProperty('--delay', elemWithLiftAnimation.length*0.5+'s')

        form.addEventListener('submit', e => {
            e.preventDefault()
            const isValid = validareForm('blur-checking')
            const action = '/' + e.target.getAttribute('action')
            const data = new FormData(e.target);
            if(isValid){
                fetch(action, {
                    "method": 'POST',
                    "body": data,
                })
                    .then(response => {
                        response.json()
                            .then(result => {
                                deleteAuthMessage('form__error-message')
                                deleteAuthMessage('form__success-message')
                                if (result.isLogin) {
                                    location.reload();
                                } else {
                                    markErrorsFields(result.validate)
                                    if (result.isRegistered) {
                                        addAuthMessage('You have successfully registered', 'form__success-message')
                                        e.target.reset();
                                    }
                                    if (result.authError) addAuthMessage(result.authError, 'form__error-message')
                                }
                            })
                    })
                    .catch(error => {
                        const message = `${error.name}: An error has occurred. Contact customer support.`
                        addAuthMessage(message, 'form__error-message')
                    })
            }
        })
    }

}




