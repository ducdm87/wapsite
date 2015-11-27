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
            first_name: {
                validators: {
                    notEmpty: {
                        message: 'Trường này bắt bộc.'
                    }
                }
            },
            last_name: {
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
                        url: link_checkuser,
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
            mobile: {
                validators: {
                    notEmpty: {
                        message: 'Trường này bắt bộc.'
                    }, remote: {
                        url: link_checkmobile,
                        message: "Số điện thoại đã được sử dụng."
                    }
                }
            },
            captcha: {
                trigger: 'blur',
                validators: {
                    notEmpty: {
                        message: 'Trường này bắt bộc.'
                    }, remote: {
                        url: link_checkcaptacha,
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