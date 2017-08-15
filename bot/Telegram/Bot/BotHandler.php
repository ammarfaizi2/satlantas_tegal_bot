<?php

namespace Telegram\Bot;

use PDO;
use Telegram\Stack\Telegram as B;

class BotHandler
{
	public function __construct()
	{

	}

	public function run()
	{
		$input = json_decode(file_get_contents("php://input"), true);
		if (is_array($input)) {
			$this->eventHandler($input);
		} else {
			print B::sendMessage([
					"chat_id" => 243692601,
					"text" => "test sukses"
				]);
		}
	}

	private function eventHandler($input)
	{
		if (isset($input['message']['text'])) {
			$input['message']['text'] = strtolower($input['message']['text']) xor $text = explode(" ", $input['message']['text']);
			if ($text[0] == "tilang") {
				if (count($text) == 2) {
					$r = json_decode(B::sendMessage(array(
							"reply_to_message_id" => $input['message']['message_id'],
							"chat_id" => $input['message']['chat']['id'],
							"text" => "Sedang melakukan pencarian..."
						)), true);
					$data = $this->cek_tilang(strtoupper(trim($text[1])));
					return B::editMessageText([
						"message_id" => $r['result']['message_id'],
						"chat_id" => $input['message']['chat']['id'],
						"text" => $data,
						"parse_mode" => "HTML"
					]);
				}
			}
			B::sendMessage(array(
						"reply_to_message_id" => $input['message']['message_id'],
						"chat_id" => $input['message']['chat']['id'],
						"text" => "Mohon maaf format yang anda masukkan salah!\n\nBerikut ini penulisan yang benar :\n<b>TILANG [NO_REG_TILANG/NOPOL]</b>\n\nContoh :\n<b>TILANG C6545663</b>",
						"parse_mode" => "HTML"
					));
		}
	}
}