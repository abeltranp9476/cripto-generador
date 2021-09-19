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

try {
$criptoGen->set_pub('Tu Master Public Key'); /* Escriba la clave maestra publica de su wallet Bitcoin */
} catch(\Exception $ex) {
    echo $ex->getMessage();
}

try {
echo $criptoGen->address_from_master_pub('0/0'); /* Genera la primera direccion BTC para depositos */
} catch(\Exception $ex) {
    echo $ex->getMessage();
}

```
En los demas casos, asegurese de colocar la xpub, ypub o zpub de la wallet de la criptomoneda especificada anteriormente en **set_network**. Para escoger otros Networks, guiese por la lista de criptos soportadas.
