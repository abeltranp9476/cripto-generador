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
$criptoGen->set_network('bitcoin');
$criptoGen->set_xpub('Tu xpub de Bitcoin'); /* Escriba la clave maestra de su wallet Bitcoin */
echo $criptoGen->address_from_master_pub('0/0'); /* Genera la primera direccion BTC para depositos */

```
En los demas casos, asegurese de colocar la xpub de la wallet de la criptomoneda especificada en **set_network**. Para escoger otros Networks, guiese por la lisa de criptos soportadas.
