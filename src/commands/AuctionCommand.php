<?php

namespace Dzheyden8561\AuctionsHouse\commands;

use Dzheyden8561\AuctionsHouse\AuctionManager;
use Dzheyden8561\AuctionsHouse\inventory\AuctionMenu;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class AuctionCommand extends Command {

    private AuctionManager $auctionManager;

    public function __construct(AuctionManager $auctionManager) {
        $this->setPermission("auctionshouse.command.auction");
        parent::__construct("auction", "Access the Auction House", "/auction");
        $this->auctionManager = $auctionManager;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return false;
        }

        $auctionMenu = new AuctionMenu($this->auctionManager);
        $auctionMenu->sendAuctionMenu($sender);
        return true;
    }
}