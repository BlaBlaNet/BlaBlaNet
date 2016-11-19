<?php
namespace Zotlabs\Module;



class Lostpass extends \Zotlabs\Web\Controller {

	function post() {
	
		$loginame = notags(trim($_POST['login-name']));
		if(! $loginame)
			goaway(z_root());
	
		$r = q("SELECT * FROM account WHERE account_email = '%s' LIMIT 1",
			dbesc($loginame)
		);
	
		if(! $r) {
			notice( t('No valid account found.') . EOL);
			goaway(z_root());
		}
	
		$aid = $r[0]['account_id'];
		$email = $r[0]['account_email'];
	
		$hash = random_string();
	
		$r = q("UPDATE account SET account_reset = '%s' WHERE account_id = %d",
			dbesc($hash),
			intval($aid)
		);
		if($r)
			info( t('Password reset request issued. Check your email.') . EOL);
	
		$email_tpl = get_intltext_template("lostpass_eml.tpl");
		$message = replace_macros($email_tpl, array(
				'$sitename' => get_config('system','sitename'),
				'$siteurl' =>  z_root(),
				'$username' => sprintf( t('Site Member (%s)'), $email),
				'$email' => $email,
				'$reset_link' => z_root() . '/lostpass?verify=' . $hash
		));
	
		$subject = email_header_encode(sprintf( t('Password reset requested at %s'),get_config('system','sitename')), 'UTF-8');
	
		$res = z_mail(
			[ 
			'toEmail' => $email,
			'messageSubject' => sprintf( t('Password reset requested at %s'), get_config('system','sitename')),
			'textVersion' => $message,
			]
		);

		goaway(z_root());
	}
	
	
	function get() {
	
	
		if(x($_GET,'verify')) {
			$verify = $_GET['verify'];
	
			$r = q("SELECT * FROM account WHERE account_reset = '%s' LIMIT 1",
				dbesc($verify)
			);
			if(! $r) {
				notice( t("Request could not be verified. (You may have previously submitted it.) Password reset failed.") . EOL);
				goaway(z_root());
				return;
			}
	
			$aid = $r[0]['account_id'];
			$email = $r[0]['account_email'];
	
			$new_password = autoname(6) . mt_rand(100,9999);
	
			$salt = random_string(32);
			$password_encoded = hash('whirlpool', $salt . $new_password);
			
			$r = q("UPDATE account SET account_salt = '%s', account_password = '%s', account_reset = '', account_flags = (account_flags & ~%d) where account_id = %d",
				dbesc($salt),
				dbesc($password_encoded),
				intval(ACCOUNT_UNVERIFIED),
				intval($aid)
			);
	
			if($r) {
				$tpl = get_markup_template('pwdreset.tpl');
				$o .= replace_macros($tpl,array(
					'$lbl1' => t('Password Reset'),
					'$lbl2' => t('Your password has been reset as requested.'),
					'$lbl3' => t('Your new password is'),
					'$lbl4' => t('Save or copy your new password - and then'),
					'$lbl5' => '<a href="' . z_root() . '/login">' . t('click here to login') . '</a>.',
					'$lbl6' => t('Your password may be changed from the <em>Settings</em> page after successful login.'),
					'$newpass' => $new_password,
					'$baseurl' => z_root()
	
				));
				
				info("Your password has been reset." . EOL);
	
				$email_tpl = get_intltext_template("passchanged_eml.tpl");
				$message = replace_macros($email_tpl, array(
					'$sitename' => \App::$config['sitename'],
					'$siteurl' =>  z_root(),
					'$username' => sprintf( t('Site Member (%s)'), $email),
					'$email' => $email,
					'$new_password' => $new_password,
					'$uid' => $newuid )
				);
	
				$res = z_mail(
					[ 
					'toEmail'        => $email,
					'messageSubject' => sprintf( t('Your password has changed at %s'), get_config('system','sitename')),
					'textVersion'    => $message,
					]
				);

				return $o;
			}
		
		}
		else {
			$tpl = get_markup_template('lostpass.tpl');
	
			$o .= replace_macros($tpl,array(
				'$title' => t('Forgot your Password?'),
				'$desc' => t('Enter your email address and submit to have your password reset. Then check your email for further instructions.'),
				'$name' => t('Email Address'),
				'$submit' => t('Reset') 
			));
	
			return $o;
		}
	
	}
	
}
