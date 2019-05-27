<?php
/**
 * Created by PhpStorm.
 * User: Azhe
 * Date: 28/10/2018
 * Time: 14.19
 */

namespace Longman\TelegramBot\Commands\UserCommands;

use GuzzleHttp\Exception\GuzzleException;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use src\Handlers\MessageHandlers;
use src\Model\Pemilu;

class RibutCommand extends UserCommand
{
	protected $name = 'ribut';
	protected $description = 'Lets ribut in 2019';
	protected $usage = '<ribut>';
	protected $version = '1.0.0';
	/**
	 * @inheritdoc
	 */
	/**
	 * Execute command
	 *
	 * @return ServerResponse
	 * @throws GuzzleException
	 * @throws TelegramException
	 */
	public function execute()
	{
		$message = $this->getMessage();
		$mHandler = new MessageHandlers($message);

//		$pecah = explode(' ', $message->getText(true));
//		$repMssg = $message->getReplyToMessage();

//		if ($repMssg != '') {
//			$tr_data = Translator::Exe($repMssg->getText(), $pecah[0], $pecah[1]);
//			$text = '<b>Translate from</b> <code>' . $tr_data['from'] . '</code> <b>to</b> <code>' . $tr_data['to'] . "</code>\n";
//			$text .= '<code>' . $tr_data['text'] . '</code>';
//		} else {
//			$text = 'Reply yang mau di terjemahkan';
//		}
		
		$mHandler->sendText("Loading..");
		
		$text = Pemilu::getPiplres();

//        $text = "wik";
		
		return $mHandler->editText($text);
	}
}