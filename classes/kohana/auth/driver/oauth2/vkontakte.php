<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class Kohana_Auth_Driver_OAuth2_VKontakte extends Auth_Driver_OAuth2 {

	protected $_provider = 'vkontakte';

	/**
	 * @param   string  $user object (response from provider)
	 * @return  Array
	 */
	protected function _get_user_data($user)
	{
		$user = json_decode($user);
		$user = current($user->response);

		$login = trim($user->first_name.' '.$user->last_name);
		return array(
			'service_id'    => $user->nickname ? $user->nickname : $login,
			'realname'      => $login,
			'service_name'  => 'oauth2.vkontakte',
			'email'         => NULL,
		);
	}

	protected function _url_verify_credentials()
	{
		return 'https://api.vkontakte.ru/method/getProfiles';
	}

	protected function _credential_params(OAuth2_Client $client, OAuth2_Token_Access $token)
	{
		return array(
			'uid'          => $token->user_id,
			'access_token' => $token->token,
			'fields'       => 'nickname',
		);
	}

}