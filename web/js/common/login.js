(function (Vue, $, window, document) {
    //页面加载完处理
    $(document).ready(function () {
        var login = {
            login: function () {
                var username = $('[bmid="username"]').val();
                var password = $('[bmid="password"]').val();
                $.bmajax.ajax({
                    url: 'ajax/common/common.ajax.php',
                    data: {"optype": "login", "username": username, "password": password},
                    success: function (data) {
                        if (data && typeof (data.success) !== "undefined") {
                            if (data.success == 1) {
                                $('.bmloginerr').html('');
                                window.location.replace(window.location.protocol + "//"
                                        + window.location.hostname + '/home');
                            } else {
                                $('.bmloginerr').html(data.errmsg);
                            }
                        }
                    }
                });
            },
            bindevent: function () {
                $('[bmid="login"]').on('click', function () {
                    login.login();
                });
                $('html').on('keydown', function (event) {
                    if (event.keyCode == 13) {
                        login.login();
                    }
                });
            },
            init: function () {
                login.bindevent();
            }
        };
        login.init();
    });
}(Vue, jQuery, window, document));