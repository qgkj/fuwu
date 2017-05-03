// JavaScript Document
;(function(app, $) {
app.admin_remind = {
	init : function() {
		$(".ajaxswitch").on('click', function(e){
			e.preventDefault();
			var url = $(this).attr('href');
			$.get(url, function(data){
				ecjia.admin.showmessage(data);
			}, 'json');
		});	
		app.admin_remind.submit_form();
	},
	
	submit_form : function() {
		var $form = $("form[name='the_form']");
		var option = {
			submitHandler : function() {
				$form.ajaxSubmit({
					dataType : "json",
					success : function(data) {
						ecjia.admin.showmessage(data);
					}
				});
			},
		}
		var options = $.extend(ecjia.admin.defaultOptions.validate, option);
		$form.validate(options);
	}
};
})(ecjia.admin, jQuery);

// end