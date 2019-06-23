//== Class Definition
var SnippetLogin = function() {

    var login = $('#m_login');

    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="m-alert m-alert--outline alert alert-' + type + ' alert-dismissible" role="alert">\
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
			<span></span>\
		</div>');

        form.find('.alert').remove();
        alert.prependTo(form);
        //alert.animateClass('fadeIn animated');
        mUtil.animateClass(alert[0], 'fadeIn animated');
        alert.find('span').html(msg);
    }

    var handleSignInFormSubmit = function() {
        $('#m_login_signin_form').on('submit', function () {
            return false;
        });

        $('#m_login_signin_submit').on('click', function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    'LoginForm[username]': {
                        required: true,
                        email: true,
                    },
                    'LoginForm[password]': {
                        required: true
                    }
                },
                messages: {
                    'LoginForm[username]': {
                        required: 'Введіть логін',
                        email: 'Введій коректний Email',
                    },
                    'LoginForm[password]': {
                        required: 'Введіть пароль'
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            form.ajaxSubmit({
                url: form[0].action,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                    if (response.status === 'error') {
                        setTimeout(function() {
                            btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                            showErrorMsg(form, 'danger', response.message);
                        }, 100);
                    } else if (response.status === 'success') {
                        window.location = response.redirect;
                    } else {
                        btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                        showErrorMsg(form, 'danger', 'Виникла помилка. Будь ласка, спробуйте пізніше.')
                    }
                }
            });
        });
    }

    //== Public Functions
    return {
        // public functions
        init: function() {
            handleSignInFormSubmit();
        }
    };
}();

//== Class Initialization
jQuery(document).ready(function() {
    SnippetLogin.init();
});