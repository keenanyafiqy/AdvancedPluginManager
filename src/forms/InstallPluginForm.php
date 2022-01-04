<?php

declare(strict_types=1);

namespace thebigcrafter\APM\forms;

use dktapps\pmforms\CustomForm;
use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Input;
use pocketmine\player\Player;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\error\ErrorHandler;
use thebigcrafter\APM\tasks\Installer;

class InstallPluginForm {
    /**
     * @return CustomForm
     */
    public static function get(): CustomForm {
        return new CustomForm(APM::getLanguage()->translateString("install.plugin.form.title"), [
            new Input("pluginName", APM::getLanguage()->translateString("install.plugin.form.input"))
        ], function (Player $player, CustomFormResponse $res): void {
            if (empty($res->getString("pluginName"))) {
                return;
            }

            if (Installer::install($res->getString("pluginName"))) {
                $player->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("install.plugin.success"));
            } else {
                ErrorHandler::sendErrorToPlayer($player, ErrorHandler::$PLUGIN_NOT_FOUND);
            }
        });
    }
}