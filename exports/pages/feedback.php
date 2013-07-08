<?php
global $user;
?>
<link rel="stylesheet" type="text/css" href="/feedback/styles/main.css" />
<div class="modal hide" id="feedbackDialog" role="dialog" aria-labelledby="feedbackTitle" style="display:block;top:20%">
	<div class="modal-header">
		<h3 id="feedbackTitle">Got Feedback?</h3>
	</div>
	<form name="feedbackForm" id="feedbackForm" action="" method="post" enctype="multipart/form-data">
		<div class="modal-body">

			<div class="formItem first">
				<label for="selType">Issue type</label>
				<select name="selType" id="selType">
					<option value="bug">Bug</option>
					<option value="feature">Feature Request</option>
					<option value="chore">Other</option>
				</select>
				<span id="msg-selType" class="err">&nbsp;</span>
			</div>
			
			<input type="hidden" name="username" value="<?php echo $user->name ?>" />
			<input type="hidden" name="email" value="<?php echo $user->mail ?>" />			

			<div class="formItem newline">
				<label for="txtaDescription">What happened?</label>
				<textarea name="txtaDescription" id="txtaDescription" class="width400 height6em" maxlength="2000"></textarea>
				<span id="msg-txtaDescription" class="err">&nbsp;</span>
			</div>

			<div class="formItem newline">
				<label for="txtaSteps">Steps needed to reproduce this bug</label>
				<textarea name="txtaSteps" id="txtaSteps" class="width400 height6em" maxlength="2000"></textarea>
				<span id="msg-txtaSteps" class="err">&nbsp;</span>
			</div>

			<div class="formItem newline">
				<label for="filAttachment">Attachment <span class="ro">(jpg, gif, png, pdf)</span></label>
				<input class="clear-both block" type="file" name="filAttachment" id="filAttachment" class="width250" />
				<span id="msg-filAttachment" class="err">&nbsp;</span>
			</div>

			<div class="formItem newline">
				*Your name, system specs, time, and URL will be submitted automatically.
			</div>

		</div>
		<div class="modal-footer">
			<button type="submit" name="submit" value="Leave feedback" id="feedbackBtn" class="btn btn-primary">
				Leave feedback
			</button>
			<button type="button" name="cancel" value="Cancel" id="cancelBtn" class="btn">
				Cancel
			</button>
		</div>
	</form>
</div>
<script type="text/javascript" src="/feedback/scripts/jquery-1.7.2.js" language="javascript"></script>
<script type="text/javascript" src="/feedback/scripts/bootstrap-modal.js" language="javascript"></script>
<script type="text/javascript" src="/feedback/scripts/jquery.trap.min.js" language="javascript"></script>
<script type="text/javascript" src="/feedback/scripts/Util.js" language="javascript"></script>
<script type="text/javascript" src="/feedback/scripts/NodeManager.js" language="javascript"></script>
<script language="javascript">
    
	$(function() {
		var NodeMgrFeedback = new NodeManager();
		var feedbackFieldNames = {
			"type" : "selType",
			"description" : "txtaDescription",
			"steps" : "txtaSteps",
			"attachment" : "filAttachment"
		};
		var $whichLink = $('.feedbackLink').last();

		$('html').on("click keypress", ".feedbackLink", function(e) {
			if (e.type == 'click' || (e.type == 'keypress' && e.which == 13)) {
				e.preventDefault();
				$whichLink = $(e.currentTarget);
				$("#feedbackDialog.modal").trap();

				//reset the dialog

				if (window.FormData === undefined) {
					//show a msg with a link to caniuse for supported browsers instead of file input.
					$('#' + feedbackFieldNames['attachment']).replaceWith("<span>Your browser doesn't support attachments. " + '<a href="http://caniuse.com/#feat=xhr2" target="_blank">Here are some that do.</a></span>');
				}

				$('#feedbackMsg').remove();
				$("#feedbackDialog .modal-body .formItem").show();
				$('#feedbackBtn').show();
				$('#feedbackDialog.modal button[name="cancel"]').html('Cancel');
				$("#feedbackDialog .modal-footer .footerRight").remove();
				$('#feedbackDialog input[type="text"], #feedbackDialog textarea').val('');
				var control = $('#feedbackDialog input[type="file"]').first();
				control.replaceWith(control.val('').clone(true));
				$('#feedbackDialog select').val($('#feedbackDialog select option:first').val());
				$('#feedbackDialog input.ui-widget').val('');
				$('#feedbackDialog input[type="checkbox"]').attr('checked', false);

				//change desc label
				$('#feedbackDialog label[for="' + feedbackFieldNames['description'] + '"]').html('What happened?');
				//show the steps field.
				$('#feedbackDialog #' + feedbackFieldNames['steps']).parents('.formItem').filter(':first').show();

				NodeMgrFeedback.removeErrors();

				// show the dialog.
				$("#feedbackDialog").modal('show');
			}
		});
		//end feedbackLink click handler

		$('#feedbackDialog').on('shown', function() {
			$('#feedbackDialog select:visible:first').focus().select();
		});

		$('#feedbackDialog #' + feedbackFieldNames['type']).change(function(e) {
			NodeMgrFeedback.removeErrors();
			switch($(e.currentTarget).val()) {
				case 'bug':
					//change desc label and erase textarea contents.
					$('#feedbackDialog label[for="' + feedbackFieldNames['description'] + '"]').html('What happened?');
					$('#feedbackDialog #' + feedbackFieldNames['description']).val('');
					//show the steps field.
					$('#feedbackDialog #' + feedbackFieldNames['steps']).parents('.formItem').filter(':first').show();
					//change attachments label to screenshot.
					//$('#feedbackDialog label[for="' + feedbackFieldNames['description'] + '"]').html('What happened?');
					break;
				case 'feature':
				case 'chore':
					//change desc label and erase textarea contents.
					$('#feedbackDialog label[for="' + feedbackFieldNames['description'] + '"]').html('Description');
					$('#feedbackDialog #' + feedbackFieldNames['description']).val('');
					//hide the steps field.
					$('#feedbackDialog #' + feedbackFieldNames['steps']).parents('.formItem').filter(':first').hide();
					//change attachments label to attachment.
					//$('#feedbackDialog label[for="' + feedbackFieldNames['description'] + '"]').html('What happened?');
					break;
			}
		});

		//handle the cancel and close events
		$('#feedbackDialog.modal button.close, ' + '#feedbackDialog.modal button[name="cancel"]').on('click keypress', function(e) {
			if (e.type == 'click' || (e.type == 'keypress' && e.which == 13)) {
				//$whichLink.focus();
				//e.preventDefault();//ie wasn't closing the modal on enter keypress. this fixed it.
				//$('#feedbackDialog').modal('hide');
				//alert("Your feedback has been submitted");
				window.location = '/';
			}
		});

		// handle modal add, save, and delete click events
		$('#feedbackForm .modal-footer button[name="submit"]').click(function(e) {
			e.preventDefault();
			//Prevents the form from submitting which produces a Firefox error. http://stackoverflow.com/questions/5545577/ajax-post-handler-causing-uncaught-exception

			//disable the buttons. show loading indicator.
			$("#feedbackDialog .modal-footer button").attr("disabled", "disabled");
			$("#feedbackDialog .modal-footer .footerRight").remove();
			$("#feedbackDialog .modal-footer").prepend('<span class="footerRight">Please wait <img class="vertical-align-children-middle" src="' + Util.rootdir + 'feedback/images/loading.gif" alt="loading animation"/></span>');

			// grab all input text, radio, checkbox, textarea, select
			var o = {};
			var a = $('#feedbackForm').serializeArray();

			$.each(a, function() {
				if (o[this.name] !== undefined) {
					if (!o[this.name].push) {
						o[this.name] = [o[this.name]];
					}
					o[this.name].push($.trim(this.value) || '');
				} else {
					o[this.name] = $.trim(this.value) || '';
				}
			});

			var formData = {
				method : 'feedback',
				args : [o, feedbackFieldNames]
			};
			var ctype = 'application/x-www-form-urlencoded; charset=UTF-8';
			var pdata = true;

			if (window.FormData !== undefined) {
				ctype = false;
				pdata = false;
				formData = new FormData();
				formData.append("method", "feedback");
				$.each(o, function(key, value) {
					formData.append("args[0][" + key + "]", value);
				});

				$.each(feedbackFieldNames, function(key, value) {
					formData.append("args[1][" + key + "]", value);
				});

				formData.append(feedbackFieldNames['attachment'], $('#'+feedbackFieldNames['attachment'])[0].files[0]);
			}

			$.ajax({
				url : Util.rootdir + 'feedback/remoteInterface.php',
				type : 'POST',
				data : formData,
				contentType : ctype,
				processData : pdata,
				dataType : 'json',
				dataFilter : Util.parseJSON,
				error : function(jqXHR, textStatus, errorThrown) {
					// enable the buttons
					$("#feedbackDialog .modal-footer button").removeAttr("disabled");
					//replace loading text with error text.
					$("#feedbackDialog .modal-footer .footerRight").addClass('errorText').html('I\'m sorry. Something went wrong.');
					var retVal2 = '';
					return false;
				},
				success : function(data, textStatus, jqXHR) {
					var retVal2 = data['result']['value'];

					$("#feedbackDialog .modal-footer .footerRight").remove();
					NodeMgrFeedback.removeErrors();

					var focusSet = false;

					//no errors so submit the form.
					if (data['result']['status'] === 'success') {
						$("#feedbackDialog .modal-footer button").removeAttr("disabled");
						$("#feedbackDialog .modal-body .formItem").hide();
						$('#feedbackBtn').hide();
						$('#feedbackDialog.modal button[name="cancel"]').html('Close');

						$('#feedbackDialog .modal-body').prepend('<div id="feedbackMsg" role="alert" aria-label="Your feedback has been successfully submitted." class="fade in alert alert-success">Your feedback has been successfully submitted.</div>');
					} else {// there were errors
						var fi, formField, msgElement;
						// UI Exception

						//loop over retVal structure. find element with name that matches retVal.item name. Find the first parent with formItem class and add class inError. Inside the formItem class find the element with err class and set inner html to retVal.item value.
						$.each(retVal2, function(key, val) {
							if (!focusSet) {
								NodeMgrFeedback.addError('#feedbackDialog', feedbackFieldNames[key], val, true);
								focusSet = true;
							} else {
								NodeMgrFeedback.addError('#feedbackDialog', feedbackFieldNames[key], val, false);
							}
						});
						// enable the buttons
						$("#feedbackDialog .modal-footer button").removeAttr("disabled");
					} //end if there are no errors.
				}//end success
			});
			//end ajax
		});
		//end add, save, delete button click event handler
	}); 
</script>