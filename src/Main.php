<?php

declare(strict_types=1);

namespace Dzheyden8561\AuctionsHouse;

use JsonException;
use Dzheyden8561\AuctionsHouse\commands\AuctionCommand;
use libs\NhanAZ\libBedrock\libBedrockException;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase {

    private AuctionManager $auctionManager;

    /**
     * @throws libBedrockException
     */
    public function onEnable(): void {
        $this->saveResource("auction.yml");
        $config = new Config($this->getDataFolder() . "auction.yml", Config::YAML);

        $this->auctionManager = new AuctionManager($config);
        $this->getServer()->getCommandMap()->register("auction", new AuctionCommand($this->auctionManager));
        $this->getLogger()->info("AuctionsHouse enabled!");
    }

    /**
     * @throws JsonException
     */
    public function onDisable(): void {
        $this->auctionManager->saveAuctions();
    }

    public function getAuctionManager(): AuctionManager {
        return $this->auctionManager;
    }
}
