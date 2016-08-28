<?php

/**
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 *
 * Two-factor backup codes for Nextcloud
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OCA\TwoFactor_BackupCodes\Controller;

use OCA\TwoFactor_BackupCodes\Service\BackupCodeStorage;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\IUserSession;

class SettingsController extends Controller {

	/** @var BackupCodeStorage */
	private $storage;

	/** @var IUserSession */
	private $userSession;

	public function __construct($appName, IRequest $request, BackupCodeStorage $storage, IUserSession $userSession) {
		parent::__construct($appName, $request);
		$this->userSession = $userSession;
		$this->storage = $storage;
	}

	/**
	 * @NoAdminRequired
	 * @return JSONResponse
	 */
	public function state() {
		$user = $this->userSession->getUser();
		return $this->storage->getBackupCodesState($user);
	}

	/**
	 * @NoAdminRequired
	 * @return JSONResponse
	 */
	public function createCodes() {
		$user = $this->userSession->getUser();
		$codes = $this->storage->createCodes($user);
		return [
		    'codes' => $codes,
		    'state' => $this->storage->getBackupCodesState($user),
		];
	}

}
