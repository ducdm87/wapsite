/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    $('#formRegister').bootstrapValidator({
        framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            firstname: {
                validators: {
                    notEmpty: {
                        message: 'Trường này bắt bộc.'
                    }
                }
            },
            lastname: {
                validators: {
                    notEmpty: {
                        message: 'Trường này bắt bộc.'
                    }
                }
            }, username: {
                trigger: 'blur',
                validators: {
                    notEmpty: {
                        message: 'Trường này bắt bộc.'
                    }, remote: {
                        url: 'users/checkuser',
                        message: "Tên này đã tồn tại."
                    }
                }
            }
            , password: {
                validators: {
                    notEmpty: {
                        message: 'Trường này bắt bộc.'
                    }, stringLength: {
                        min: 6,
                        message: "Nhập lớn hơn 6 kỹ tự."
                    }
                }
            },
            re_password: {
                validators: {
                    notEmpty: {
                        message: 'Trường này bắt bộc.'
                    }, stringLength: {
                        min: 6,
                        message: "Nhập lớn hơn 6 kỹ tự."
                    },
                    identical: {
                        field: 'password',
                        message: "Mật khẩu không khớp."
                    }
                }
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: 'Trường này bắt bộc.'
                    }
                }
            },
            captcha: {
                trigger: 'blur',
                validators: {
                    notEmpty: {
                        message: 'Trường này bắt bộc.'
                    }, remote: {
                        url: 'users/checkcaptcha',
                        message: "Mã nhập không hợp lệ."
                    }
                }
            }
        }
    });

    $('#formLogin').bootstrapValidator({
        framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                trigger: 'blur',
                validators: {
                    notEmpty: {
                        message: 'Trường này bắt bộc.'
                    }
                }
            }
            , password: {
                validators: {
                    notEmpty: {
                        message: 'Trường này bắt bộc.'
                    }, stringLength: {
                        min: 6,
                        message: "Nhập lớn hơn 6 kỹ tự."
                    }
                }
            }
        }
    });
});