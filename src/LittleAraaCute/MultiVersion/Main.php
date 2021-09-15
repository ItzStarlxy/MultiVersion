<?php

namespace LittleAraaCute\MultiVersion;

use pocketmine\{Server, Player};
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

class Main extends PluginBase implements Listener {
	
	protected $version = ProtocolInfo::MINECRAFT_VERSION_NETWORK;
	
	public function onEnable(){
		$this->getLogger()->info("Plugin Enable");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function getVersion(){
        return $this->version;
    }
    
    public function onLogin(DataPacketReceiveEvent $event) {

        $pk = $event->getPacket();

        if(!$pk instanceof LoginPacket) {
            return;
        }

        $player = $event->getPlayer();
        $currentProtocol = ProtocolInfo::CURRENT_PROTOCOL;

        if($pk->protocol !== $currentProtocol) {
            $pk->protocol = $currentProtocol;
            $this->getLogger()->alert("Sending protocol (" . $currentProtocol . ") to " . $player->getName());
        }
    }
}