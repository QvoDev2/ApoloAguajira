# ApoloServigtec
# Clonar desde 0:
*   git clone https://github.com/bscloudsas/BaseLaravel.git
*   composer install --ignore-platform-reqs
*   cp .env.example .env
*   php artisan key:generate
*   php artisan migrate --seed

##  Actualizar:
*   git pull
*   composer update --ignore-platform-reqs
*   php artisan migrate --seed

#   GENERAR DEPLOY KEY EN EL SERVIDOR
*   ssh-keygen -t rsa -f ~/.ssh/nombre_key -C "Nombre del Proyecto"
*   cat .ssh/nombre_key.pub (Copiar respuesta en deploy key del proyecto)
*   Se agrega al config en ssh
*   ssh-add ~/.ssh/nombre_key
*   ssh-add -l (Verifica las keys adicionadas)
*   git remote -v
*   git remote rm origin
*   git remote add origin git@nombre_key:<username>/<repo>
*   git branch --set-upstream-to=origin/main
*   git pull
##  Estructura
    Host nombre_key
    HostName github.com
    IdentityFile ~/.ssh/nombre_key
#   Notas
*   Si no funcionan los tooltip revisar que no este ingresado el tooltip de Jquery UI
##  Si no corren las migraciones correr
*   php artisan clear-compiled
*   php artisan optimize:clear
*   composer dump-autoload
*   php artisan optimize
*   php artisan view:clear
*   php artisan config:clear
*   php artisan route:clear
*   php artisan cache:clear

##  Si no se deja clonar el proyecto desde ssh agregar la key al proyecto
*   ssh-add ~/.ssh/id_rsa

# PORBLEMAS AL ACTUALIZAR EN EL SERVIDOR
*   Si se actualiza en el servidor y no clona revisar que el puerto sea el correcto
*   Si se corren las migraciones y se genera un error con las vistas se debe agregar \PDO::ATTR_EMULATE_PREPARES => true a la linea options en config/database.php


#   Si el desarrollo en laravel se debe agregar a un QVO
*   crear la aplicación en la intranet
*   Crear los perfiles correspondientes al aplicativo
*   Crear la base de datos del proyecto
*   Modificar las vistas de vusuarios y vperfiles en el proyecto
*   Modificar vaplicaciones en la documentación, agregar el proyecto y correr la vista en vaplicaciones
