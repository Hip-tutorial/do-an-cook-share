/**
 * Client-side form validation for register, login, add-recipe, and comment forms.
 */
document.addEventListener('DOMContentLoaded', function () {
    var registerForm = document.getElementById('register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            clearErrors(registerForm);

            var fullname = registerForm.querySelector('#fullname');
            var email = registerForm.querySelector('#email');
            var username = registerForm.querySelector('#username');
            var password = registerForm.querySelector('#password');
            var confirmPassword = registerForm.querySelector('#confirm_password');
            var valid = true;

            if (!fullname.value.trim()) {
                markError(fullname);
                valid = false;
            }
            if (!email.value.trim() || !isValidEmail(email.value.trim())) {
                markError(email);
                valid = false;
            }
            if (!username.value.trim()) {
                markError(username);
                valid = false;
            }
            if (!password.value.trim()) {
                markError(password);
                valid = false;
            }
            if (!confirmPassword.value.trim() || password.value !== confirmPassword.value) {
                markError(confirmPassword);
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
                alert('Vui lòng kiểm tra lại thông tin đăng ký.');
            }
        });
    }

    var loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            clearErrors(loginForm);

            var username = loginForm.querySelector('#username');
            var password = loginForm.querySelector('#password');
            var valid = true;

            if (!username.value.trim()) {
                markError(username);
                valid = false;
            }
            if (!password.value.trim()) {
                markError(password);
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
                alert('Vui lòng nhập đầy đủ thông tin đăng nhập.');
            }
        });
    }

    var addRecipeForm = document.getElementById('add-recipe-form');
    if (addRecipeForm) {
        addRecipeForm.addEventListener('submit', function (e) {
            clearErrors(addRecipeForm);

            var fields = ['title', 'description', 'ingredients', 'steps'];
            var image = addRecipeForm.querySelector('#image');
            var valid = true;

            fields.forEach(function (id) {
                var field = addRecipeForm.querySelector('#' + id);
                if (!field.value.trim()) {
                    markError(field);
                    valid = false;
                }
            });

            if (!image.files || image.files.length === 0) {
                markError(image);
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
                alert('Vui lòng điền đầy đủ thông tin công thức.');
            }
        });
    }

    var commentForm = document.getElementById('comment-form');
    if (commentForm) {
        commentForm.addEventListener('submit', function (e) {
            clearErrors(commentForm);

            var content = commentForm.querySelector('#content');
            if (!content.value.trim()) {
                markError(content);
                e.preventDefault();
                alert('Nội dung bình luận không được để trống.');
            }
        });
    }
});

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function markError(field) {
    field.classList.add('error');
}

function clearErrors(form) {
    form.querySelectorAll('.error').forEach(function (el) {
        el.classList.remove('error');
    });
}
