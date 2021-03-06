<?php
/**
 * Created by PhpStorm.
 * User: Azhe
 * Date: 06/08/2018
 * Time: 13.23
 */

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use WinTenDev\Utils\Time;

class File2urlCommand extends UserCommand
{
	protected $name = 'url2file';
	protected $description = 'Konversi URL jadi Files';
	protected $usage = '/file2url';
	protected $version = '1.0.0';
	
	/**
	 * Execute command
	 *
	 * @return ServerResponse
	 * @throws TelegramException
	 */
	public function execute()
	{
		$message = $this->getMessage();
		
		$chat_id = $message->getChat()->getId();
		$mssg_id = $message->getMessageId();
		$text = '';
		$time = $message->getDate();
		$time = Time::jeda($time);
		
		$repMssg = $message->getReplyToMessage();
		$file_id = $repMssg->getDocument()->getFileId();
		
		if ($repMssg !== null) {
			$respFile = Request::getFile(['file_id' => $file_id]);
			if ($respFile->isOk()) {
				$files = $respFile->getResult();
				Request::downloadFile($files);
				$text .= "<b>File2URL</b>\n" .
					"<b>URL : </b>" . $respFile->getResult()->getFilePath();
				// $dirUpl = $this->telegram->getDownloadPath();
				// $text .= FtpUpload::aplod($dirUpl . '/documents/file_0.exe');
			} else {
				$text .= $respFile->getErrorCode();
			}
		} else {
			$text = '🚫 <b>Reply File yang akan di conpert!!</b>';
		}
		$data = [
			'chat_id'             => $chat_id,
			'text'                => $text . $time,
			'reply_to_message_id' => $mssg_id,
			'parse_mode'          => 'HTML'
		];
		
		return Request::sendMessage($data);
	}
}
