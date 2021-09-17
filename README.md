### Criptomonedas soportadas

Soporte para 3 tipos de direcciones: **legacy**, **compatibility** y **segwit**.

- Bitcoin
- Dash
- Dogecoin
- Litecoin
- Viacoin
- Zcash

### Requerimientos

- PHP version >= 7.3
- Composer

### Instalación
- Instalar el paquete a través de Composer

```
composer require abeltranp9476/cripto-generador
```

### Ejemplo de uso

- Caso para Bitcoin:

```
require_once __DIR__ . '/vendor/autoload.php';

use CriptoGenerador\HD;


$criptoGen = new HD(); /* Crear nueva instancia de la clase HD */

try {
$criptoGen->set_network('bitcoin');
} catch(\Exception $ex) {
    echo $ex->getMessage();
}

/* Si tu wallet es compatible con segwit utiliza set_zpub */
/* Si tu wallet es compatible con compatibility utiliza set_ypub */
try {
$criptoGen->set_xpub('Tu xpub de Bitcoin'); /* Escriba la clave maestra de su wallet Bitcoin */
} catch(\Exception $ex) {
    echo $ex->getMessage();
}

try {
echo $criptoGen->address_from_master_pub('0/0'); /* Genera la primera direccion BTC para depositos */
} catch(\Exception $ex) {
    echo $ex->getMessage();
}

```
En los demas casos, asegurese de colocar la xpub, ypub o zpub de la wallet de la criptomoneda especificada en **set_network**. Para escoger otros Networks, guiese por la lista de criptos soportadas.
