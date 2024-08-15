<?php

namespace Dzheyden8561\AuctionsHouse\inventory;

use Dzheyden8561\AuctionsHouse\AuctionManager;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\player\Player;

class AuctionMenu {

    private AuctionManager $auctionManager;

    public function __construct(AuctionManager $auctionManager) {
        $this->auctionManager = $auctionManager;
    }

    public function sendAuctionMenu(Player $player): void {
        $menu = InvMenu::create(InvMenuTypeIds::TYPE_DOUBLE_CHEST);
        $menu->setName("Auction House");

        $auctions = $this->auctionManager->getAuctions();

        foreach ($auctions as $auction) {
            $item = $auction->getItem();
            $item->setCustomName("Seller: " . $auction->getSeller() . "\nStarting Bid: " . $auction->getStartingBid() . "\nBuy Now: " . ($auction->getBuyNowPrice() ?? "None") . "\nEnds In: " . ($auction->getEndTime() - time()) . "s");
            $menu->getInventory()->addItem($item);
        }

        $menu->setListener(function(Player $player, $itemClicked) {
            // Handle bid or buy now actions when an item is clicked.
            // Can open a BidMenu or handle Buy Now directly.
        });

        $menu->send($player);
    }
}