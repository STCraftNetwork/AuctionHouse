<?php

namespace Dzheyden8561\AuctionsHouse\commands;

use Dzheyden8561\AuctionsHouse\AuctionManager;
use Dzheyden8561\AuctionsHouse\inventory\AuctionMenu;
use Dzheyden8561\AuctionsHouse\inventory\SubmitAuctionMenu;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class AuctionCommand extends Command {

    private AuctionManager $auctionManager;

    public function __construct(AuctionManager $auctionManager) {
        parent::__construct("auction", "Access the Auction House or submit items", "/auction [submit]", ["ah"]);
        $this->auctionManager = $auctionManager;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return false;
        }

        if (isset($args[0]) && strtolower($args[0]) === "submit") {
            // Open the submission menu to add a new auction
            $submitAuctionMenu = new SubmitAuctionMenu($this->auctionManager);
            $submitAuctionMenu->sendSubmitMenu($sender);
        } else {
            // Open the auction house menu
            $auctionMenu = new AuctionMenu($this->auctionManager);
            $auctionMenu->sendAuctionMenu($sender);
        }
        return true;
    }
}