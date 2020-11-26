# Introducción
Se realiza el desarrollo con TDD siguiendo los criterios SOLID e introduciendo dos patrones de diseño: arquitectura hexagonal y patrón de repositorio.
Se deja en el archivo de configuración un cuarto afiliado con el host 172.0.0.1 para poder probar en local sin necesidad de cambiar los vhost. 

## app\Http\Controllers\WhiteLabelController

El controlador del modelo de negocio WhiteLabel, captura el host de la petición y construye su modelo de negocio mediante su repositorio y este host para pasarle los datos a la vista whiteLabel

En el también gestionamos donde enviar los posibles BMErrors capturados, al no ser importante para esta prueba se deja el trozo de código:

```php

    if($whiteLabel->returnWebCamsValues() instanceof BMErrors) {
        //in this place we must persist or show the error.
    }  

```
## app\BM\BMFormaters\Interfaces\IModeles

Interface que deben implementar todos los modelos de negocio

## app\BM\WhiteLabel

Implementa la interface IModels 

El modelo de negocio white label se construye inyectado la interface de repositorio y el valor del host del afiliado
El core de la aplicación en concreto es el método returnWebCamsValues()

Devolverá los datos que necesita la vista o un BMError si encuentra algún error

- Su suite de test está en test\feature\app\BM\WhiteLabel

## app\BM\BMFormaters\Interfaces\IWhiteLabelReposity

Interface que debe implementar el repositorio de whiteLabel

## app\BM\Repositories\WhiteLabel\WhiteLabelRepository

Siguiendo el patrón de diseño de repositorios, el repositorio de whiteLabel es una capa de abstracción entre el modelo de negocio y el modelo de persistencia.
En este momento los datos de las webCams nos llegan a través de un json en una url. Pero en un futuro se puede querer cambiar por una consulta a la base de datos o explotar una api que devuelva estos resultados. 
Al estar desacoplado el modelo de negocio de su modelo de persistencia mediante esta capa de abstracción, llegado el momento el momento de cambiar el modelo de persistencia no hay que tocar el modelo de negocio, queda inmutable. Cambiamos la capa de abstracción implementando su interface y todo sigue funcionando.

Este reopistorio no debe encargarse de las validaciones, ha de dar por supuesto que sus datos son correctos, para ello le inyectamos un validador de los datos.

Comunicará al modelo de negocio posibles errores del validador en forma de un BMError

- Su suite de test está en test\feature\app\BM\Repositories\WhiteLabel\WhiteLabelRepositoryTest

## App\BM\BMFormatters\Interfaces\IWhiteLabelRepository

Interface que debe implementar cualquier otro repositorio para whiteLabel que sustituya a este.

## App\BM\BMFormatters\Interfaces\IValidators

Interface que deben implementar todos los validadores de datos.

## App\BM\Validators\WhiteLabelJSONValidator

Este validador implementa la interface IValidators, se encarga de validar si el json tiene un formato correcto y los campos en concreto que necesitamos para el desarrollo, en caso contrario devuelve un BMError

- Su suite de test está en test\feature\app\BM\Validators\WhiteLabelJSONValidatorTest

## App\BM\Wrappers\BMErrors

Implement la interface IBMErrors

Clase para guardar los posibles errores, estos errores en un 'ecosistema' completo deberían ser persistidos o renderizados de algún modo.
Como no era importante para el desarrollo llegan hasta el controlador y ahí quedan a la espera de una decisión de como persistirlos y/o mostrarlos

## App\BM\BMFormatters\Interfaces\IBMErrors

Si se desea crear una clase para un tipo de error especifico o modificar la actual, deberá implementar esta interface

## config\config

Todas las variables de configuración necesarias para el desarrollo en concreto

## routes\web

Contiene el enrutamiento al controlador

## resources\views\whiteLabel

vista de white label
