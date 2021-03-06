<?php

namespace CriptoGenerador;

use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Key\Deterministic\HdPrefix\GlobalPrefixConfig;
use BitWasp\Bitcoin\Key\Deterministic\HdPrefix\NetworkConfig;
use BitWasp\Bitcoin\Network\Slip132\BitcoinRegistry;
use BitWasp\Bitcoin\Key\Deterministic\Slip132\Slip132;
use BitWasp\Bitcoin\Key\KeyToScript\KeyToScriptHelper;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Serializer\Key\HierarchicalKey\Base58ExtendedKeySerializer;
use BitWasp\Bitcoin\Serializer\Key\HierarchicalKey\ExtendedKeySerializer;

class HD
{

    private $network = NULL;
    private $xpub = NULL;
    private $ypub = NULL;
    private $zpub = NULL;

    public function set_network($network)
    {
        $this->network = $network;
    }

    public function set_pub($pub)
    {   
        $type= $this->getPublicMasterKeyType($pub);
        $this->$type= $pub;
    }    

    public function address_from_master_pub($path = '0/0')
    {
        if (empty($this->network)) {
            throw new \Exception("Network is not present!");
        }

        $adapter = Bitcoin::getEcAdapter();
        $slip132 = new Slip132(new KeyToScriptHelper($adapter));

        // We're using bitcoin, and need the slip132 bitcoin registry
        $network= $this->network;
        $btc = NetworkFactory::$network();
        $bitcoinPrefixes = new BitcoinRegistry();

        if(!empty($this->xpub)){
            $pub= $this->xpub;
            $pubPrefix = $slip132->p2pkh($bitcoinPrefixes);
        }

        if(!empty($this->ypub)){
            $pub= $this->ypub;
            $pubPrefix = $slip132->p2shP2wpkh($bitcoinPrefixes);
        }

        if(!empty($this->zpub)){
            $pub= $this->zpub;
            $pubPrefix = $slip132->p2wpkh($bitcoinPrefixes);
        }

        if (empty($pub)) {
            throw new \Exception("XPUB, YPUB or ZPUB key is not present!");
        }

        // Keys with ALL of these prefixes will be supported.
        // You can chose a subset if desired (for some networks it's
        // a good idea!)
        $config = new GlobalPrefixConfig([
            new NetworkConfig($btc, [
             $pubPrefix
            ])
        ]);

        $serializer = new Base58ExtendedKeySerializer(
            new ExtendedKeySerializer($adapter, $config)
          );

        $key = $serializer->parse($btc, $pub);
        $child_key = $key->derivePath($path);

        return $child_key->getAddress(new AddressCreator())->getAddress($btc);
    }


    private function getPublicMasterKeyType($key)
    {
        return substr($key, 0, 4);
    }
}