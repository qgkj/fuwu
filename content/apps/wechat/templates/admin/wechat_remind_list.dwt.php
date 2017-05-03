<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_remind.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
{if $warn}
	{if $type eq 0}
	 	<div class="alert alert-error">
	        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
	    </div>
	{/if}
{/if}

{if $errormsg}
 	<div class="alert alert-error">
        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
    </div>
{/if}

{platform_account::getAccountSwtichDisplay('wechat')}

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="{if $tab eq 'order_remind'}		active{/if}"><a class="data-pjax" href='{url path="wechat/admin_remind/init" args="tab=order_remind"}'>		{lang key='wechat::wechat.order_remind'}</a></li>
				<li class="{if $tab eq 'pay_remind'}		active{/if}"><a class="data-pjax" href='{url path="wechat/admin_remind/init" args="tab=pay_remind"}'>		{lang key='wechat::wechat.pay_remind'}</a></li>
				<li class="{if $tab eq 'send_remind'}		active{/if}"><a class="data-pjax" href='{url path="wechat/admin_remind/init" args="tab=send_remind"}'>		{lang key='wechat::wechat.send_remind'}</a></li>
				<li class="{if $tab eq 'register_remind'}	active{/if}"><a class="data-pjax" href='{url path="wechat/admin_remind/init" args="tab=register_remind"}'>	{lang key='wechat::wechat.register_remind'}</a></li>
			</ul>
			<div class="tab-content">
				<!-- {if $tab eq 'order_remind'} -->
				<div class="tab-pane active" id="order_remind">
					<form class="form-horizontal" action="{$form_action}" method="post" name="the_form">
						<fieldset>
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_title'}</label>
								<div class="controls">
									<input type="text" name="data[template_name]" value="{$order_remind['template_name']}" placeholder="{lang key='wechat::wechat.title_placeholder'}" />
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_status'}</label>
								<div class="controls">
									<input type="radio" name="data[status]" value="1" {if $order_remind['status'] == 1}checked{/if} />{lang key='wechat::wechat.open'}
									<input type="radio" name="data[status]" value="0" {if $order_remind['status'] == 0}checked{/if} />{lang key='wechat::wechat.close'}
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_remind_template'}</label>
								<div class="controls">
									<textarea class="form-control" placeholder="{lang key='wechat::wechat.remind_template_placeholder'}" name="data[template_content]" rows="3">{$order_remind['template_content']}</textarea>
									<span class="help-block">{lang key='wechat::wechat.order_remind_template_help'}</span>
								</div>
							</div>
							
							<div class="control-group" >
								<div class="controls">
									<input type="hidden" name="template_code" value="order_remind" />
	                  				<input type="submit" value="{lang key='wechat::wechat.ok'}" class="btn btn-gebo" />
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<!-- {/if} -->
				
				<!-- {if $tab eq 'pay_remind'} -->
				<div class="tab-pane active" id="pay_remind">
				   <form class="form-horizontal" action="{$form_action}" method="post" name="the_form">
						<fieldset>
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_title'}</label>
								<div class="controls">
									<input type="text" name="data[template_name]" value="{$pay_remind['template_name']}" placeholder="{lang key='wechat::wechat.title_placeholder'}" />
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_status'}</label>
								<div class="controls">
									<input type="radio" name="data[status]" value="1" {if $pay_remind['status'] == 1}checked{/if} />{lang key='wechat::wechat.open'}
									<input type="radio" name="data[status]" value="0" {if $pay_remind['status'] == 0}checked{/if} />{lang key='wechat::wechat.close'}
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_remind_template'}</label>
								<div class="controls">
									<textarea class="form-control" placeholder="{lang key='wechat::wechat.remind_template_placeholder'}" name="data[template_content]" rows="3">{$pay_remind['template_content']}</textarea>
									<span class="help-block">{lang key='wechat::wechat.pay_remind_template_help'}</span>
								</div>
							</div>
							
							<div class="control-group" >
								<div class="controls">
									<input type="hidden" name="template_code" value="pay_remind" />
	                  				<input type="submit" value="{lang key='wechat::wechat.ok'}" class="btn btn-gebo" />
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<!-- {/if} -->
				
				<!-- {if $tab eq 'send_remind'} -->
				<div class="tab-pane active" id="send_remind">
					<form class="form-horizontal" action="{$form_action}" method="post" name="the_form">
						<fieldset>
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_title'}</label>
								<div class="controls">
									<input type="text" name="data[template_name]" value="{$send_remind['template_name']}" placeholder="{lang key='wechat::wechat.title_placeholder'}" />
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_status'}</label>
								<div class="controls">
									<input type="radio" name="data[status]" value="1" {if $send_remind['status'] == 1}checked{/if} />{lang key='wechat::wechat.open'}
									<input type="radio" name="data[status]" value="0" {if $send_remind['status'] == 0}checked{/if} />{lang key='wechat::wechat.close'}
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_remind_template'}</label>
								<div class="controls">
									<textarea class="form-control" placeholder="{lang key='wechat::wechat.remind_template_placeholder'}" name="data[template_content]" rows="3">{$send_remind['template_content']}</textarea>
									<span class="help-block">{lang key='wechat::wechat.send_remind_template_help'}</span>
								</div>
							</div>
							
							<div class="control-group" >
								<div class="controls">
									<input type="hidden" name="template_code" value="send_remind" />
	                  				<input type="submit" value="{lang key='wechat::wechat.ok'}" class="btn btn-gebo" />
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<!-- {/if} -->
				
				<!-- {if $tab eq 'register_remind'} -->
				<div class="tab-pane active" id="register_remind">
					<form class="form-horizontal" action="{$form_action}" method="post" name="the_form">
						<fieldset>
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_user_pre'}</label>
								<div class="controls">
									<input type="text" name="config[user_pre]" placeholder="{lang key='wechat::wechat.user_pre_placeholder'}" value="{$register_remind['config']['user_pre']}" />
									<span class="help-block">{lang key='wechat::wechat.user_pre_help'}</span>
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_pwd_pre'}</label>
								<div class="controls">
									<input type="text" name="config[pwd_pre]" placeholder="{lang key='wechat::wechat.pwd_pre_placeholder'}" value="{$register_remind['config']['pwd_pre']}" />
									<span class="help-block">{lang key='wechat::wechat.pwd_pre_help'}</span>
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_pwd_rand'}</label>
								<div class="controls">
									<input type="text" name="config[pwd_rand]" placeholder="{lang key='wechat::wechat.pwd_rand_placeholder'}" value="{$register_remind['config']['pwd_rand']}" />
									<span class="help-block">{lang key='wechat::wechat.pwd_rand_help'}</span>
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_status'}</label>
								<div class="controls">
									<input type="radio" name="data[status]" value="1" {if $register_remind['status'] == 1}checked{/if} />{lang key='wechat::wechat.open'}
									<input type="radio" name="data[status]" value="0" {if $register_remind['status'] == 0}checked{/if} />{lang key='wechat::wechat.close'}
								</div>
							</div>
							
							<div class="control-group formSep" >
								<label class="control-label">{lang key='wechat::wechat.label_remind_template'}</label>
								<div class="controls">
									<textarea class="form-control" placeholder="{lang key='wechat::wechat.remind_template_placeholder'}" name="data[template_content]" rows="3">{$register_remind['template_content']}</textarea>
									<span class="help-block">{lang key='wechat::wechat.register_remind_help'}</span>
								</div>
							</div>
							
							<div class="control-group" >
								<div class="controls">
									<input type="hidden" name="template_code" value="register_remind" />
	                  				<input type="submit" value="{lang key='wechat::wechat.ok'}" class="btn btn-gebo" />
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<!-- {/if} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->