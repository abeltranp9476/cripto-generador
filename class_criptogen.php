<?php

use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Key\Deterministic\HdPrefix\GlobalPrefixConfig;
use BitWasp\Bitcoin\Key\Deterministic\HdPrefix\NetworkConfig;
use BitWasp\Bitcoin\Key\Factory\HierarchicalKeyFactory;
use BitWasp\Bitcoin\Mnemonic\Bip39\Bip39SeedGenerator;
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

    public function set_network($network)
    {
        $this->network = $network;
    }

    public function set_xpub($xpub)
    {
        $this->xpub = $xpub;
    }


    public function address_from_master_pub($path = '0/0')
    {
        $xpub= $this->xpub;
        $adapter = Bitcoin::getEcAdapter();
        $slip132 = new Slip132(new KeyToScriptHelper($adapter));
        $addrCreator = new AddressCreator();

        // We're using bitcoin, and need the slip132 bitcoin registry
        $network= $this->network;
        $btc = NetworkFactory::$network();
        $bitcoinPrefixes = new BitcoinRegistry();

        // Keys with ALL of these prefixes will be supported.
        // You can chose a subset if desired (for some networks it's
        // a good idea!)
        $config = new GlobalPrefixConfig([
            new NetworkConfig($btc, [
            $slip132->p2pkh($bitcoinPrefixes)
            ])
        ]);

        $btcPrefixConfig = $config->getNetworkConfig($btc);
        $serializer = new Base58ExtendedKeySerializer(new ExtendedKeySerializer($adapter, $config));


        // This shows how we create such keys. You
        // don't actually need the config until serialize
        // time
        $hdFactory = new HierarchicalKeyFactory($adapter);
        $p2shP2wshP2pkhKey = $hdFactory->fromExtended($xpub);
        $addrKey = $p2shP2wshP2pkhKey->derivePath($path);
        return $addrKey->getAddress($addrCreator)->getAddress($btc);
    }

}