<?php

namespace Dzheyden8561\AuctionsHouse\data;

use libs\NhanAZ\libBedrock\libBedrockException;
use libs\NhanAZ\libBedrock\StringToItem;
use pocketmine\item\Item;

class Auction {

    private string $seller;
    private Item $item;
    private int $startingBid;
    private ?int $buyNowPrice = null;
    private int $currentBid;
    private ?string $highestBidder = null;
    private int $endTime;

    public function __construct(string $seller, Item $item, int $startingBid, ?int $buyNowPrice, int $duration) {
        $this->seller = $seller;
        $this->item = $item;
        $this->startingBid = $startingBid;
        $this->buyNowPrice = $buyNowPrice;
        $this->currentBid = $startingBid;
        $this->endTime = time() + $duration;
    }

    public function getSeller(): string {
        return $this->seller;
    }

    public function getItem(): Item {
        return $this->item;
    }

    public function getStartingBid(): int {
        return $this->startingBid;
    }

    public function getBuyNowPrice(): ?int {
        return $this->buyNowPrice;
    }

    public function getCurrentBid(): int {
        return $this->currentBid;
    }

    public function getHighestBidder(): ?string {
        return $this->highestBidder;
    }

    public function getEndTime(): int {
        return $this->endTime;
    }

    public function placeBid(string $player, int $bidAmount): bool {
        if ($bidAmount > $this->currentBid) {
            $this->currentBid = $bidAmount;
            $this->highestBidder = $player;
            return true;
        }
        return false;
    }

    public function buyNow(string $player): bool {
        if ($this->buyNowPrice !== null && $this->currentBid <= $this->buyNowPrice) {
            $this->currentBid = $this->buyNowPrice;
            $this->highestBidder = $player;
            return true;
        }
        return false;
    }

    public function isExpired(): bool {
        return time() > $this->endTime;
    }

    public function serialize(): array {
        return [
            "seller" => $this->seller,
            "item" => $this->item->jsonSerialize(),
            "startingBid" => $this->startingBid,
            "buyNowPrice" => $this->buyNowPrice,
            "currentBid" => $this->currentBid,
            "highestBidder" => $this->highestBidder,
            "endTime" => $this->endTime
        ];
    }

    /**
     * @throws libBedrockException
     */
    public static function deserialize(array $data): Auction {
        $item = StringToItem::parse(json_encode($data["item"]));
        $auction = new Auction(
            $data["seller"],
            $item,
            $data["startingBid"],
            $data["buyNowPrice"] ?? null,
            $data["endTime"] - time()
        );
        $auction->placeBid($data["highestBidder"] ?? "", $data["currentBid"]);
        return $auction;
    }
}
