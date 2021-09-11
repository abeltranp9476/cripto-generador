### Criptomonedas soportadas

- Bitcoin
- Dash
- Dogecoin
- Litecoin
- Viacoin
- Zcash

### Requerimientos

- PHP version >= 7.3
- Composer
- bitwasp/bitcoin
- Extension PHP **gmp**

### Ejemplo de uso

- Caso para Bitcoin:

```
require(__DIR__ . "/vendor/autoload.php");
require("class_criptogen.php"); /* Cargue la clase desde la ruta donde se encuentre */
$criptoGen= new HD();
$criptoGen->set_network('bitcoin');
$criptoGen->set_xpub('Tu xpub de Bitcoin'); /* Escriba la clave maestra de su wallet Bitcoin */
echo $criptoGen->address_from_master_pub('0/0'); /* Genera la primera direccion BTC para depositos */
```
En los demas casos, asegurese de colocar la xpub de la wallet de la criptomoneda especificada en **network**. Para escoger otros Networks, guiese por la lisa de criptos soportadas.