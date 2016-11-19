<div class="generic-content-wrapper">
	<div class="section-title-wrapper">
		<a title="{{$removeaccount}}" class="btn btn-danger btn-xs pull-right" href="removeaccount"><i class="fa fa-trash-o"></i>&nbsp;{{$removeme}}</a>
		<h2>{{$title}}</h2>
		<div class="clear"></div>
	</div>
	<form action="settings/account" id="settings-account-form" method="post" autocomplete="off" >
		<input type='hidden' name='form_security_token' value='{{$form_security_token}}'>
		<div class="section-content-tools-wrapper">
			{{include file="field_input.tpl" field=$email}}
			{{include file="field_password.tpl" field=$origpass}}
			{{include file="field_password.tpl" field=$password1}}
			{{include file="field_password.tpl" field=$password2}}

			{{if $z_server_role == 'pro' && ! $techlock}}
			{{include file="field_select.tpl" field=$techlevel}}
			{{else}}
			<input type="hidden" name="techlevel" value="{{$techlevel.2}}" />
			{{/if}}

			<div class="settings-submit-wrapper" >
				<button type="submit" name="submit" class="btn btn-primary">{{$submit}}</button>
			</div>
			{{$account_settings}}
		</div>
	</form>
</div>

