$(document).ready(function() {
	$('#frm_login').bootstrapValidator({
		message: 'この値は有効ではありません',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			'data[User][email]': {
				validators: {
					notEmpty: {
						message: 'メールアドレスを入力してください'
					},
					emailAddress: {
						message: 'メールアドレスを入力してください'
					}
				}
			},
			'data[User][password]': {
				validators: {
					notEmpty: {
						message: 'パスワードを入力してください。'
					}
				}
			},
		}
	});


	$('#frm_register1').bootstrapValidator({
		message: 'この値は有効ではありません',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			'data[User][name]': {
				message: 'ユーザー名を入力してください。',
				validators: {
					notEmpty: {
						message: 'ユーザー名を入力してください。'
					},
					// stringLength: {
					// 	min: 6,
					// 	max: 30,
					// 	message: 'ユーザー名は6文字以上にする必要があります。'
					// },
					// regexp: {
					// 	regexp: /^[a-zA-Z0-9_\.]+$/,
					// 	message: 'The username can only consist of alphabetical, number, dot and underscore'
					// }
				}
			},
			'data[User][email]': {
				validators: {
					notEmpty: {
						message: 'メールアドレスを入力してください。'
					},
					emailAddress: {
						message: 'メールアドレスを入力してください。'
					}
				}
			},
			'data[User][password]': {
				validators: {
					notEmpty: {
						message: 'パスワードを入力してください。'
					},
					stringLength: {
						min: 8,
						max: 100,
						message: 'パスワードは8文字以上にする必要があります。'
					}, 
					regexp: {
                        regexp: /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]+$/,
                        message: 'パスワードには大文字と数字を混ぜて、８文字以上を入力する必要があります'
                    }
				}
			},
			'data[User][cpassword]': {
				validators: {
					notEmpty: {
						message: '確認パスワードを入力してください。'
					},
					identical: {
						field: 'data[User][password]',
						message: 'パスワードと確認パスワードは同じではありません。'
					}
				}
			},

			// confirmPassword: {
			// 	validators: {
			// 		notEmpty: {
			// 			message: 'The confirm password is required and can\'t be empty'
			// 		},
			// 		identical: {
			// 			field: 'password',
			// 			message: 'The password and its confirm are not the same'
			// 		}
			// 	}
			// }
			'data[User][birthday]': {
				validators: {
					// notEmpty: {
					// 	message: '生年月日を入力してください。'
					// },
					date: {
						format: 'YYYY-MM-DD'
					}
				}
			},
			'data[User][province]': {
				validators: {
					notEmpty: {
						message: '都道府県を選択してください。'
					},
				}
			},
			'data[User][region]': {
				validators: {
					notEmpty: {
						message: '地区を選択してください。'
					},
				}
			},
			'data[User][constituency]': {
				validators: {
					notEmpty: {
						message: '選挙区を選択してください。'
					},
				}
			},
		}
	});
	
	
	$('#frm_register2').bootstrapValidator({
		message: 'この値は有効ではありません',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			'data[User][name]': {
				message: 'ユーザー名を入力してください。',
				validators: {
					notEmpty: {
						message: 'ユーザー名を入力してください。'
					},
					// stringLength: {
					// 	min: 6,
					// 	max: 30,
					// 	message: 'ユーザー名は6文字以上にする必要があります。'
					// },
					// regexp: {
					// 	regexp: /^[a-zA-Z0-9_\.]+$/,
					// 	message: 'The username can only consist of alphabetical, number, dot and underscore'
					// }
				}
			},
			'data[User][email]': {
				validators: {
					notEmpty: {
						message: 'メールアドレスを入力してください'
					},
					emailAddress: {
						message: 'メールアドレスを入力してください'
					}
				}
			},
			'data[User][password]': {
				validators: {
					notEmpty: {
						message: 'パスワードを入力してください。'
					},
					stringLength: {
						min: 8,
						max: 30,
						message: 'パスワードは8文字以上にする必要があります。'
					},
					regexp: {
                        regexp: /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]+$/,
                        message: 'パスワードには大文字と数字を混ぜて、８文字以上を入力する必要があります'
                    }
					// identical: {
					// 	field: 'confirmPassword。',
					// 	message: 'The password and its confirm are not the same'
					// }
				}
			},
			'data[User][cpassword]': {
				validators: {
					notEmpty: {
						message: '確認パスワードを入力してください。'
					},
					identical: {
						field: 'data[User][password]',
						message: 'パスワードと確認パスワードは同じではありません。'
					}
				}
			},

			// 'data[User][party]': {
			// 	validators: {
			// 		notEmpty: {
			// 			message: '所属政党を入力してください。'
			// 		},
			// 	}
			// },
			'data[User][affiliation]': {
				validators: {
					notEmpty: {
						message: '所属を選択してください。'
					},
				}
			},
			'data[User][address]': {
				validators: {
					notEmpty: {
						message: '住所を入力してください。'
					},
				}
			},
			'data[User][province]': {
				validators: {
					notEmpty: {
						message: '都道府県を選択してください。'
					},
				}
			},
			'data[User][region]': {
				validators: {
					notEmpty: {
						message: '地区を入選択てください。'
					},
				}
			},
			'data[User][constituency]': {
				validators: {
					notEmpty: {
						message: '選挙区を選択してください。'
					},
				}
			},
			'data[User][phonenum]': {
				validators: {
					notEmpty: {
						message: '電話番号を入力してください。'
					},
				}
			},
			'data[User][cardname]': {
				validators: {
					notEmpty: {
						message: 'カード名前を入力してください。'
					},
				}
			},
			'data[User][cardnumber]': {
				validators: {
					notEmpty: {
						message: 'カード番号を入力してください。'
					},
				}
			},
			'data[User][cardexpiration]': {
				validators: {
					date: {
						format: 'YYYY-MM-DD'
					}
				}
			},
			'data[User][cardcode]': {
				validators: {
					notEmpty: {
						message: 'セキュリティコードを入力してください。'
					},
					digits: {
						message: '10進法の数字(0 - 9)'
					}
				}
			},
		}
	});

	
	$('#frm_updatepassword').bootstrapValidator({
		message: 'この値は有効ではありません',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			'data[User][password_old]': {
				validators: {
					notEmpty: {
						message: 'パスワードを入力してください。'
					},
				}
			},
			'data[User][password]': {
				validators: {
					notEmpty: {
						message: '新しいパスワードを入力してください。'
					},
					stringLength: {
						min: 8,
						max: 30,
						message: 'パスワードは8文字以上にする必要があります。'
					}, 
					regexp: {
                        regexp: /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]+$/,
                        message: 'パスワードには大文字と数字を混ぜて、８文字以上を入力する必要があります'
                    }
				}
			},
			'data[User][cpassword]': {
				validators: {
					notEmpty: {
						message: '確認パスワードを入力してください。'
					},
					identical: {
						field: 'data[User][password]',
						message: 'パスワードと確認パスワードは同じではありません。'
					}
				}
			}
		}
	});

	$('#frm_sendinquiry').bootstrapValidator({
		message: 'この値は有効ではありません',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			'data[Inquiry][question]': {
				validators: {
					notEmpty: {
						message: 'メッセージを入力してください。'
					},
				}
			}
		}
	});

	$('#post_activity').bootstrapValidator({
		message: 'この値は有効ではありません',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			'data[Activity][content]': {
				validators: {
					notEmpty: {
						message: '内容を入力してください。'
					},
				}
			},
			'data[Activity][activity_type_id]': {
				validators: {
					notEmpty: {
						message: '分類を入力してください。'
					},
				}
			}
		}
	});

	$('#edit_activity').bootstrapValidator({
		message: 'この値は有効ではありません',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			'data[Activity][content]': {
				validators: {
					notEmpty: {
						message: '内容を入力してください。'
					},
				}
			}
		}
	});



	$('#post_timeline').bootstrapValidator({
		message: 'この値は有効ではありません',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			'data[Timeline][content]': {
				validators: {
					notEmpty: {
						message: '内容を入力してください。'
					},
				}
			},
			'data[Timeline][activity_type_id]': {
				validators: {
					notEmpty: {
						message: '分類を入力してください。'
					},
				}
			}
		}
	});


	$('#frm_payment').bootstrapValidator({
		message: 'この値は有効ではありません',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			'data[User][name]': {
				message: 'ユーザー名を入力してください。',
				validators: {
					notEmpty: {
						message: 'ユーザー名を入力してください。'
					},
				}
			},
			'data[User][phonenum]': {
				validators: {
					notEmpty: {
						message: '電話番号を入力してください。'
					},
				}
			},
			'data[User][email]': {
				validators: {
					notEmpty: {
						message: 'メールアドレスを入力してください'
					},
					emailAddress: {
						message: 'メールアドレスを入力してください'
					}
				}
			},
			'data[User][address]': {
				validators: {
					notEmpty: {
						message: '住所を入力してください。'
					}
				}
			},
		}
	});

	$('#frm_reset1').bootstrapValidator({
		message: 'この値は有効ではありません',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			'data[User][email]': {
				validators: {
					notEmpty: {
						message: 'メールアドレスを入力してください'
					},
					emailAddress: {
						message: 'メールアドレスを入力してください'
					}
				}
			},
		}
	});

	$('#frm_reset2').bootstrapValidator({
		message: 'この値は有効ではありません',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			'data[User][email]': {
				validators: {
					notEmpty: {
						message: 'メールアドレスを入力してください'
					},
					emailAddress: {
						message: 'メールアドレスを入力してください'
					}
				}
			},
			'data[User][sanswer]': {
				validators: {
					notEmpty: {
						message: '秘密回答を入力してください'
					}
				}
			},
			'data[User][new_password]': {
				validators: {
					notEmpty: {
						message: 'パスワードを入力してください。'
					},
					stringLength: {
						min: 8,
						max: 100,
						message: 'パスワードは8文字以上にする必要があります。'
					}, 
					regexp: {
                        regexp: /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]+$/,
                        message: 'パスワードには大文字と数字を混ぜて、８文字以上を入力する必要があります'
                    }
				}
			},
			'data[User][confirm]': {
				validators: {
					notEmpty: {
						message: '確認パスワードを入力してください。'
					},
					identical: {
						field: 'data[User][password]',
						message: 'パスワードと確認パスワードは同じではありません。'
					}
				}
			},
		}
	});


	$('#ExampleBootstrapValidationForm').bootstrapValidator({
		message: 'この値は有効ではありません',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			username: {
				message: 'The username is not valid',
				validators: {
					notEmpty: {
						message: 'The username is required and can\'t be empty'
					},
					stringLength: {
						min: 6,
						max: 30,
						message: 'The username must be more than 6 and less than 30 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_\.]+$/,
						message: 'The username can only consist of alphabetical, number, dot and underscore'
					}
				}
			},
			country: {
				validators: {
					notEmpty: {
						message: 'The country is required and can\'t be empty'
					}
				}
			},
			acceptTerms: {
				validators: {
					notEmpty: {
						message: 'You have to accept the terms and policies'
					}
				}
			},
			email: {
				validators: {
					notEmpty: {
						message: 'The email address is required and can\'t be empty'
					},
					emailAddress: {
						message: 'The input is not a valid email address'
					}
				}
			},
			website: {
				validators: {
					uri: {
						message: 'The input is not a valid URL'
					}
				}
			},
			phoneNumber: {
				validators: {
					digits: {
						message: 'The value can contain only digits'
					}
				}
			},
			color: {
				validators: {
					hexColor: {
						message: 'The input is not a valid hex color'
					}
				}
			},
			zipCode: {
				validators: {
					zipCode: {
						country: 'US',
						message: 'The input is not a valid US zip code'
					}
				}
			},
			password: {
				validators: {
					notEmpty: {
						message: 'The password is required and can\'t be empty'
					},
					identical: {
						field: 'confirmPassword',
						message: 'The password and its confirm are not the same'
					}
				}
			},
			confirmPassword: {
				validators: {
					notEmpty: {
						message: 'The confirm password is required and can\'t be empty'
					},
					identical: {
						field: 'password',
						message: 'The password and its confirm are not the same'
					}
				}
			},
			ages: {
				validators: {
					lessThan: {
						value: 100,
						inclusive: true,
						message: 'The ages has to be less than 100'
					},
					greaterThan: {
						value: 10,
						inclusive: false,
						message: 'The ages has to be greater than or equals to 10'
					}
				}
			}
		}
	});

	$('#frm_squestion').bootstrapValidator({
		message: 'この値は有効ではありません',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			'data[User][sanswer]': {
				validators: {
					notEmpty: {
						message: '秘密回答を入力してください'
					}
				}
			},
		}
	});

	$('#theme_select').bootstrapValidator({
		message: 'この値は有効ではありません',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			'data[Activity][theme_id]': {
				validators: {
					notEmpty: {
						message: 'テーマを選択してください'
					}
				}
			},
		}
	});
	
	
});