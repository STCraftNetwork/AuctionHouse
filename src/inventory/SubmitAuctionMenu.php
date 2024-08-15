<?php

namespace Dzheyden8561\AuctionsHouse\inventory;

use Dzheyden8561\AuctionsHouse\AuctionManager;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class SubmitAuctionMenu {

    private AuctionManager $auctionManager;

    public function __construct(AuctionManager $auctionManager) {
        $this->auctionManager = $auctionManager;
    }

    public function sendSubmitMenu(Player $player): void {
        $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);
        $menu->setName("Submit Item for Auction");

        $menu->setListener(function(Player $player, $itemClicked) use ($menu) {
            $item = $itemClicked->getItem();

            if ($item->isNull()) {
                $player->sendMessage(TextFormat::RED . "You must select a valid item!");
                return;
            }

            $startingBid = 1000;
            $buyNowPrice = 5000;
            $duration = 3600;
            $player->getInventory()->removeItem($item);
            $this->auctionManager->createAuction($player->getName(), $item, $startingBid, $buyNowPrice, $duration);

            $player->sendMessage(TextFormat::GREEN . "Your item has been submitted to the auction!");
            $player->removeCurrentWindow();
        });

        $menu->send($player);
    }
}