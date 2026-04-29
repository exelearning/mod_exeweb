<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Strings for component 'exeweb', language 'es', version '4.1'.
 *
 * @package     mod_exeweb
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['areapackage'] = 'Archivo de paquete';
$string['badexelearningpackage'] = 'El paquete no cumple las normas de los contenidos definidas para el sitio.';
$string['clicktodownload'] = 'Haga clic en {$a} para descargar el archivo.';
$string['clicktoopen2'] = 'Haga clic en {$a} para ver el archivo.';
$string['configdisplayoptions'] = 'Puede seleccionar cualquiera de las opciones disponibles (los ajustes existentes no se modificarán). Mantenga pulsada la tecla CTRL para seleccionar varios campos simultáneamente.';
$string['configframesize'] = 'Cuando se muestra una página web o un archivo cargado dentro de un marco (FRAME), este valor es el tamaño en píxeles del marco superior, que contiene la navegación.';
$string['configparametersettings'] = 'Configura el valor por defecto del panel de ajustes cuando se agregan nuevos recursos. Tras esta primera vez, se convierte en una preferencia del usuario.';
$string['configpopup'] = 'Cuando se agrega un recurso que puede mostrarse en un ventana emergente ("popup"), ¿esta opción se debe activar por defecto?';
$string['configpopupdirectories'] = 'Las ventanas "popup", ¿deben mostrar por defecto los enlaces del directorio?';
$string['configpopupheight'] = '¿Qué altura deben tener por defecto las ventanas "popup"?';
$string['configpopuplocation'] = 'Las ventanas "popup", ¿deben mostrar la barra de ubicación por defecto?';
$string['configpopupmenubar'] = 'Las ventanas "popup", ¿deben mostrar la barra de menú por defecto?';
$string['configpopupresizable'] = 'Las ventanas "popup", ¿deben ser redimensionables por defecto?';
$string['configpopupscrollbars'] = 'Las ventanas "popup", ¿deben mostrar las barras de desplazamiento por defecto?';
$string['configpopupstatus'] = 'Las ventanas "popup", ¿deben mostrar la barra de estado por defecto?';
$string['configpopuptoolbar'] = 'Las ventanas "popup", ¿deben mostrar la barra de herramientas por defecto?';
$string['configpopupwidth'] = '¿Qué ancho deben tener por defecto las ventanas "popup"?';
$string['contentheader'] = 'Contenido';
$string['defaultdisplaysettings'] = 'Configuración de pantalla predeterminada';
$string['displayoptions'] = 'Opciones disponibles';
$string['displayselect'] = 'Mostrar';
$string['displayselect_help'] = 'Este ajuste determina cómo se muestra el contenido. Las opciones pueden incluir:

* Incrustar - Un IFRAME dentro de una página de actividad de Moodle, con sus bloques laterales (dependerá del tema).
* En el marco - Un FRAMESET con dos marcos. El superior muestra algún dato del curso en el que estás y las opciones para ir a las actividades anterior y siguiente. El inferior muestra el contenido del paquete.
* Nueva ventana - Se abre en una nueva ventana del navegador.
* Abrir - Se abre en la misma ventana del navegador.
* En ventana emergente - Ventana tipo "popup".';
$string['displayselect_link'] = 'mod/exeweb/mod';
$string['displayselectexplain'] = 'Elegir tipo. No todos los tipos funcionan con todos los contenidos.';
$string['dnduploadexeweb'] = 'Crear un sitio web';
$string['exeonline:connectionsettings'] = 'Configuración de la conexión con el servidor eXeLearning';
$string['exeonline:baseuri'] = 'URI remoto';
$string['exeonline:baseuri_desc'] = 'URL de eXeLearning';
$string['exeonline:hmackey1'] = 'Clave de firma';
$string['exeonline:hmackey1_desc'] = 'Clave utilizada para firmar los datos enviados al servidor de eXeLearning, de forma que podamos estar seguros de que se originaron en este servidor. Utilice un máximo de 32 caracteres.';
$string['exeonline:tokenexpiration'] = 'Caducidad del token';
$string['exeonline:tokenexpiration_desc'] = 'Tiempo máximo (en segundos) para editar el paquete en eXeLearning y volver a Moodle.';
$string['exeonline:provider_name'] = 'Nombre del entorno';
$string['exeonline:provider_name_desc'] = 'Nombre del proveedor de eXeLearning. Este se utiliza para identificar el proveedor en la interfaz de eXeLearning.';
$string['exeonline:provider_version'] = 'Versión del entorno';
$string['exeonline:provider_version_desc'] = 'Versión del proveedor de eXeLearning. Este se utiliza para identificar el proveedor en la interfaz de eXeLearning.';
$string['exeweb:forbiddenfileslist'] = 'Archivos prohibidos, lista RE';
$string['exeweb:forbiddenfileslist_desc'] = 'Aquí puede cofigurar una lista de archivos prohibidos. Introduzca cada archivo prohibido como una expresión regular PHP (RE) en una nueva línea. Por ejemplo:';
$string['exeweb:mandatoryfileslist'] = ' Ficheros obligatorios, lista RE';
$string['exeweb:mandatoryfileslist_desc'] = 'Aquí se puede cofigurar una lista de archivos obligatorios. Introduzca cada archivo obligatorio como una expresión regular PHP (RE) en una nueva línea.';
$string['exeweb:onlinetypehelp'] = 'Cuando haga clic en cualquiera de los botones de guardar en la parte inferior de esta página, le llevará a eXeLearning para crear o editar el contenido. Cuando termine, eXeLearning lo enviará de vuelta a Moodle.';
$string['exeweb:sendtemplate'] = 'Enviar plantilla';
$string['exeweb:sendtemplate_desc'] = 'Envía la plantilla predeterminada a eXeLearning al crear un nuevo contenido.';
$string['exeweb:template'] = 'Nueva plantilla de paquete.';
$string['exeweb:template_desc'] = 'El paquete (.zip o .elpx) subido aquí se utilizará como paquete por defecto para los nuevos contenidos. Se mostrará hasta que sea sustituido por el enviado por eXeLearning. NO descomprima el paquete.';
$string['exeweb:editonlineanddisplay'] = 'Ir a eXeLearning y mostrar';
$string['exeweb:editonlineandreturntocourse'] = 'Ir a eXeLearning y volver al curso';
$string['filenotfound'] = 'Lo sentimos, el archivo no se ha encontrado.';
$string['filterfiles'] = 'Utilizar filtros del contenido del archivo';
$string['filterfilesexplain'] = 'Seleccione el tipo de archivo que contiene el filtro. Esto puede causar problemas en algunos contenidos. Por favor, asegúrese de que todos los archivos de texto están en UTF-8.';
$string['filtername'] = 'Auto-enlace de nombres de recursos';
$string['forcedownload'] = 'Forzar descarga';
$string['framesize'] = 'Altura del marco';
$string['indicator:cognitivedepth'] = 'Archivo cognitivo';
$string['indicator:cognitivedepth_help'] = 'Este indicador está basado en la profundidad cognitiva alcanzada por el estudiante.';
$string['indicator:cognitivedepthdef'] = 'Archivo cognitivo';
$string['indicator:cognitivedepthdef_help'] = 'El participante ha alcanzado este porcentaje del compromiso cognitivo ofrecido por los recursos durante este intervalo de análisis (Niveles = Sin vista, Ver)';
$string['indicator:cognitivedepthdef_link'] = 'Learning_analytics_indicators#Cognitive_depth';
$string['indicator:socialbreadth'] = 'Archivo social';
$string['indicator:socialbreadth_help'] = 'Este indicador está basado en la amplitud social alcanzada por el estudiante.';
$string['indicator:socialbreadthdef'] = 'Archivo social';
$string['indicator:socialbreadthdef_help'] = 'El participante ha alcanzado este porcentaje del compromiso social ofrecido por los recursos durante este intervalo de análisis (Niveles = Sin participación, Participante solo)';
$string['indicator:socialbreadthdef_link'] = 'Learning_analytics_indicators#Social_breadth';
$string['invalidpackage'] = 'Paquete inválido.';
$string['modifieddate'] = 'Actualizado  {$a}';
$string['modulename'] = 'eXeLearning (sitio web)';
$string['modulename_help'] = 'El módulo eXeLearning (sitio web) permite a los profesores crear una actividad partiendo de un sitio web generado con eXeLearnig. El contenido puede ser subido, o crearse y editarse
directamente en eXeLearning.';
$string['modulename_link'] = 'mod/exeweb/view';
$string['modulenameplural'] = 'eXeLearning (sitios web)';
$string['optionsheader'] = 'Mostrar opciones';
$string['player:toogleFullscreen'] = 'Alternar pantalla completa';
$string['package'] = 'Paquete';
$string['package_help'] = 'El archivo del paquete es un archivo que contiene un sitio web comprimido en zip generado con eXeLearning.';
$string['packagehdr'] = 'Paquete';
$string['page-mod-exeweb-x'] = 'Cualquier página del módulo';
$string['pluginadministration'] = 'Administración del módulo';
$string['pluginname'] = 'eXeLearning (sitio web)';
$string['popupheight'] = 'Altura (en píxeles) de la ventana emergente';
$string['popupheightexplain'] = 'Especifica la altura por defecto de las ventanas emergentes.';
$string['popupexeweb'] = 'Este recurso debe aparecer en una ventana emergente';
$string['popupexeweblink'] = 'Si no, haga clic aquí: {$a}';
$string['popupwidth'] = 'Ancho (en píxeles) de la ventana emergente';
$string['popupwidthexplain'] = 'Especifica la anchura por defecto de las ventanas emergentes.';
$string['printintro'] = 'Mostrar descripción del recurso';
$string['printintroexplain'] = '¿Mostrar la descripción del recurso debajo del contenido? Algunos tipos de visualización pueden no mostrar la descripción aunque esté activada esa opción.';
$string['privacy:metadata'] = 'El complemento no almacena ningún dato personal.';
$string['exeweb:addinstance'] = 'Añadir un nuevo recurso';
$string['exewebcontent'] = 'Archivos y subcarpetas';
$string['exewebdetails_'] = 'Evitar mdlcode unknown-string error message';
$string['exewebdetails_size'] = 'Evitar mdlcode unknown-string error message';
$string['exewebdetails_type'] = 'Evitar mdlcode unknown-string error message';
$string['exewebdetails_date'] = 'Evitar mdlcode unknown-string error message';
$string['exewebdetails_sizetype'] = '{$a->size} {$a->type}';
$string['exewebdetails_sizedate'] = '{$a->size} {$a->date}';
$string['exewebdetails_typedate'] = '{$a->type} {$a->date}';
$string['exewebdetails_sizetypedate'] = '{$a->size} {$a->type} {$a->date}';
$string['exeorigin'] = 'Tipo';
$string['exeorigin_help'] = 'Este ajuste determina cómo se incluye el paquete en el curso. Las opciones pueden incluir:

* Paquete subido - Permite elegir el zip creado con eXeLearning por medio del selector de archivos.
* Crear con eXeLearning (editor integrado) - Crea la actividad usando el editor integrado. Podrá editarla directamente desde la página de visualización de la actividad.
* Crear/Editar con eXeLearning - Crea la actividad y te lleva a eXeLearning para editar el contenido. Al terminar, eXeLearning lo enviará de vuelta a Moodle.';
$string['exeweb:exportexeweb'] = 'Exportar recurso';
$string['exeweb:view'] = 'Ver recurso';
$string['search:activity'] = 'Fichero';
$string['selectmainfile'] = 'Selecciona el fichero principal haciendo clic en el icono que hay junto a su nombre.';
$string['showdate'] = 'Mostrar la fecha de subida/modificación';
$string['showdate_desc'] = '¿Mostrar la fecha de subida/modificación en la página del curso?';
$string['showdate_help'] = 'Muestra la fecha de subida/modificación junto al enlace al archivo.';
$string['showsize'] = 'Mostrar tamaño';
$string['showsize_help'] = 'Muestra el tamaño del archivo, con el formato \'3 1 MB \', junto al enlace al archivo.';
$string['showsize_desc'] = '¿Mostrar el tamaño del archio en la página del curso?';
$string['showtype'] = 'Mostrar tipo';
$string['showtype_desc'] = '¿Mostrar tipo de archivo (ej. \'Documento de Texto\') en la página del curso?';
$string['showtype_help'] = 'Muestra el tipo de documento (ej. \'Documento de Texto\') al lado del enlace al archivo.

Si hay varios archivos en el recurso, se muestra el tipo del archivo inicial.

Si el tipo de archivo es desconocido para el sistema, no se muestra.';
$string['uploadeddate'] = 'Subido {$a}';
$string['embeddededitorsettings'] = 'Tipo de editor';
$string['embeddededitorstatus'] = 'Editor embebido';
$string['editorlatestversionongithub'] = 'Última versión en GitHub:';
$string['manageembeddededitor'] = 'Gestionar editor embebido';
$string['manageembeddededitor_desc'] = 'Instalar, actualizar o reparar el editor embebido de eXeLearning.';
$string['editorsource_moodledata'] = 'Instalado (gestionado por administración)';
$string['editorsource_bundled'] = 'Incluido con el plugin';
$string['editorsource_none'] = 'No instalado';
$string['editorinstall'] = 'Instalar última versión';
$string['editorupdate'] = 'Actualizar editor';
$string['editoruninstall'] = 'Eliminar';
$string['editorinstallsuccess'] = 'El editor eXeLearning v{$a} se ha instalado correctamente.';
$string['editoruninstallsuccess'] = 'Se ha eliminado la instalación del editor embebido.';
$string['editorversion'] = 'Versión';
$string['editorinstalledat'] = 'Instalado el';
$string['editorsource'] = 'Origen';
$string['editoractivesource'] = 'Origen activo';
$string['editormoodledatadir'] = 'Directorio de datos';
$string['editorbundleddir'] = 'Directorio incluido';
$string['editorlatestversion'] = 'Última versión disponible';
$string['editorstatusinfo'] = 'El editor embebido sirve recursos estáticos para el editor integrado de eXeLearning. Los orígenes se comprueban en este orden: instalado por administración (moodledata) y después incluido en el plugin (dist/).';
$string['editorgithubconnecterror'] = 'No se pudo conectar con GitHub: {$a}';
$string['editorgithubapierror'] = 'GitHub devolvió el estado HTTP {$a}. Inténtelo de nuevo más tarde.';
$string['editorgithubparseerror'] = 'No se pudo interpretar la información de la última versión publicada en GitHub.';
$string['editordownloaderror'] = 'Error al descargar el paquete del editor: {$a}';
$string['editordownloademptyfile'] = 'El archivo descargado está vacío.';
$string['editorinvalidzip'] = 'El archivo descargado no es un ZIP válido.';
$string['editorzipextensionmissing'] = 'La extensión PHP ZipArchive no está disponible. Pida al administrador del servidor que la habilite.';
$string['editorextractfailed'] = 'Error al extraer el paquete del editor: {$a}';
$string['editorextractwriteerror'] = 'No se pudieron escribir los archivos extraídos en el directorio temporal.';
$string['editorinvalidlayout'] = 'El paquete no contiene los archivos esperados del editor (index.html y directorios de recursos).';
$string['editorinstallfailed'] = 'Error al instalar el editor: {$a}';
$string['editormkdirerror'] = 'No se pudo crear el directorio: {$a}';
$string['editorbackuperror'] = 'No se pudo crear una copia de seguridad de la instalación existente del editor.';
$string['editorcopyfailed'] = 'No se pudieron copiar los archivos del editor al directorio de destino.';
$string['editorinstallconcurrent'] = 'Ya hay una instalación en curso. Espere unos minutos e inténtelo de nuevo.';
$string['editorconfirmuninstall'] = '¿Está seguro de que desea eliminar el editor instalado por administración? Se utilizará la versión incluida o remota.';
$string['editorupdateavailable'] = 'Actualización disponible: v{$a}';
$string['editorcurrentversion'] = 'Versión actual: v{$a}';
$string['editornotyetinstalled'] = 'No se ha encontrado ningún editor instalado por administración.';
$string['editormoodledatasource'] = 'Instalado por el administrador (moodledata)';
$string['editorbundledsource'] = 'Incluido con el plugin';
$string['editoravailable'] = 'Disponible';
$string['editornotavailable'] = 'No disponible';
$string['editormanagelink'] = 'Gestionar editor embebido';
$string['editorsourceprecedence'] = 'Prioridad de origen: instalado por administración > incluido.';
$string['exeweb:manageembeddededitor'] = 'Gestionar la instalación del editor embebido de eXeLearning';
$string['editorcheckingerror'] = 'No se pudieron comprobar las actualizaciones. Es posible que GitHub no esté disponible temporalmente.';
$string['editorinstallconfirm'] = 'Esto descargará e instalará la última versión del editor eXeLearning (v{$a}) desde GitHub. ¿Desea continuar?';
$string['editoradminrequired'] = 'El editor embebido de eXeLearning no está instalado. Contacte con el administrador del sitio.';
$string['editormanagementhelp'] = 'Descargue e instale desde GitHub la última versión del editor de eXeLearning. La versión instalada por el administrador tiene prioridad sobre la incluida con el plugin.';
$string['editorbundleddesc'] = 'El plugin incluye una versión. Puede instalar la última versión publicada en GitHub.';
$string['editornotinstalleddesc'] = 'Instale el editor desde GitHub para habilitar el modo de edición embebido.';
$string['invalidaction'] = 'Acción no válida: {$a}';
$string['installing'] = 'Instalando...';
$string['checkingforupdates'] = 'Comprobando actualizaciones...';
$string['operationtakinglong'] = 'La operación está tardando más de lo esperado. Comprobando estado...';
$string['checkingstatus'] = 'Comprobando estado...';
$string['stillworking'] = 'Sigue en proceso...';
$string['editorinstalling'] = 'Instalando...';
$string['editordownloadingmessage'] = 'Descargando e instalando el editor. Esto puede tardar un minuto...';
$string['editoruninstalling'] = 'Eliminando...';
$string['editoruninstallingmessage'] = 'Eliminando la instalación del editor...';
$string['operationtimedout'] = 'La operación ha superado el tiempo de espera. Compruebe el estado del editor e inténtelo de nuevo.';
$string['latestversionchecking'] = 'Comprobando...';
$string['latestversionerror'] = 'No se pudieron comprobar las actualizaciones';
$string['updateavailable'] = 'Actualización disponible';
$string['installstale'] = 'La instalación puede haber fallado. Inténtelo de nuevo.';
$string['noeditorinstalled'] = 'No hay ningún editor instalado';
$string['confirmuninstall'] = '¿Está seguro de que desea desinstalar el editor embebido? Esto eliminará la copia instalada por administración de moodledata.';
$string['confirmuninstalltitle'] = 'Confirmar desinstalación';
$string['editorinstalledsuccess'] = 'Editor instalado correctamente';
$string['editoruninstalledsuccess'] = 'Editor desinstalado correctamente';
$string['editorupdatedsuccess'] = 'Editor actualizado correctamente';
$string['editorrepairsuccess'] = 'Editor reparado correctamente';
$string['editormode'] = 'Modo de editor';
$string['editormodedesc'] = 'Seleccione qué editor usar para crear y editar contenido eXeLearning. La configuración de conexión online solo aplica cuando se selecciona el modo "eXeLearning Online".';
$string['editormodeonline'] = 'eXeLearning Online (servidor remoto)';
$string['editormodeembedded'] = 'Editor integrado (embebido)';
$string['embeddednotinstalledcontactadmin'] = 'Los archivos del editor integrado no están instalados. Contacte con el administrador del sitio para instalarlo.';
$string['embeddednotinstalledadmin'] = 'Los archivos del editor integrado no están instalados. Puede instalarlo desde la configuración del plugin.';
$string['editembedded'] = 'Editar con eXeLearning';
$string['editembedded_integrated'] = 'Integrado';
$string['editembedded_help'] = 'Abre el editor eXeLearning integrado para editar el contenido directamente dentro de Moodle.';
$string['editormissing'] = 'El editor integrado eXeLearning no está instalado. Contacte con el administrador.';
$string['editorreaderror'] = 'No se pudieron leer los archivos del editor integrado eXeLearning. Compruebe los permisos de los archivos y contacte con el administrador.';
$string['embeddedtypehelp'] = 'Se creará la actividad y podrá editarla usando el editor eXeLearning integrado desde la página de visualización de la actividad.';
$string['saving'] = 'Guardando...';
$string['savedsuccess'] = 'Cambios guardados correctamente';
$string['savetomoodle'] = 'Guardar en Moodle';
$string['savingwait'] = 'Por favor, espere mientras se guarda el archivo.';
$string['unsavedchanges'] = 'Tiene cambios sin guardar. ¿Está seguro de que desea cerrar?';
$string['typeembedded'] = 'Crear con eXeLearning (editor integrado)';
$string['typeexewebcreate'] = 'Crear con eXeLearning';
$string['typeexewebedit'] = 'Editar con eXeLearning';
$string['typelocal'] = 'Paquete subido';

$string['teachermodevisible'] = 'Mostrar el selector de capa docente';
$string['teachermodevisible_help'] = 'Si se desactiva, se ocultará el selector de capa docente dentro del recurso incrustado.';

$string['editoruploadmissingfile'] = 'No se ha subido ningún archivo ZIP del editor.';
$string['editoruploadfailed'] = 'No se pudo subir el paquete del editor: {$a}';

// Gestión de estilos.
$string['stylesmanager'] = 'Estilos';
$string['stylesmanager_hint'] = 'Sube paquetes de estilos de eXeLearning y controla qué estilos expone el editor integrado.';
$string['stylesmanager_intro'] = 'Gestiona los estilos de eXeLearning disponibles para el editor integrado. Los estilos integrados se pueden ocultar de forma individual. Los estilos subidos se pueden habilitar, deshabilitar o eliminar en cualquier momento.';
$string['stylesmanager_manage'] = 'Gestionar estilos instalados';
$string['stylesmanager_manage_hint'] = 'Abre la página de estilos para habilitar o deshabilitar los estilos integrados, o para eliminar estilos subidos.';
$string['stylesonlywhenembedded'] = 'El editor integrado no está activado. Los estilos gestionados aquí sólo se aplican cuando el modo del editor es «integrado».';
$string['stylesblockimport'] = 'Bloquear estilos importados por el usuario';
$string['stylesblockimport_desc'] = 'Cuando está activado, el editor integrado oculta la pestaña «Estilos importados» y rechaza instalar un estilo incluido en un proyecto .elpx importado. El usuario sólo podrá elegir entre la lista aprobada por el administrador. Equivale al comportamiento de eXeLearning ONLINE_THEMES_INSTALL=false.';
$string['stylesupload_label'] = 'Paquete ZIP de estilo';
$string['stylesupload_submit'] = 'Subir estilo';
$string['stylesupload_hint'] = 'Tamaño máximo: {$a}. Solo se aceptan paquetes .zip con un config.xml válido.';
$string['stylesupload_success'] = 'Estilo «{$a}» instalado.';
$string['stylesupload_success_many'] = 'Instalados: {$a}';
$string['stylesupload_goto_settings'] = 'Subir estilos desde la página de configuración del plugin';
$string['stylesupload_failed'] = 'La subida del estilo ha fallado.';
$string['stylesupload_missing'] = 'El archivo subido no existe o no se puede leer.';
$string['stylesupload_empty'] = 'El archivo subido está vacío.';
$string['stylesupload_toolarge'] = 'El estilo subido supera el tamaño máximo permitido de {$a}.';
$string['stylesupload_nozip'] = 'La extensión PHP ZipArchive no está disponible.';
$string['stylesupload_badzip'] = 'El archivo subido no es un ZIP válido.';
$string['stylesupload_badentry'] = 'El archivo ZIP contiene entradas que no se pueden leer.';
$string['stylesupload_unsafe'] = 'Entrada de archivo no segura rechazada: {$a}';
$string['stylesupload_multiconfig'] = 'El archivo contiene más de un config.xml.';
$string['stylesupload_noconfig'] = 'Al paquete de estilo le falta el config.xml.';
$string['stylesupload_mixedroots'] = 'El archivo debe contener una única carpeta raíz o tener todos los archivos en la raíz.';
$string['stylesupload_badext'] = 'Tipo de archivo no permitido en el paquete de estilo: {$a}';
$string['stylesupload_configread'] = 'No se pudo leer config.xml del archivo.';
$string['stylesupload_badxml'] = 'config.xml no es XML válido.';
$string['stylesupload_noname'] = 'config.xml debe declarar un elemento <name>.';
$string['stylesupload_traversal'] = 'Se ha bloqueado un intento de escalado de directorios durante la extracción.';
$string['stylesupload_readfailed'] = 'No se pudo leer un archivo del ZIP durante la extracción.';
$string['stylesupload_writefailed'] = 'No se pudo escribir un archivo extraído.';
$string['stylesnocss'] = 'El estilo subido no contiene ninguna hoja de estilos.';
$string['stylesinstallfailed'] = 'No se pudo instalar el estilo: {$a}';
$string['stylesuploaded'] = 'Estilos subidos';
$string['stylesuploaded_empty'] = 'Todavía no hay estilos subidos.';
$string['stylesuploaded_hint'] = 'Activa o desactiva los estilos subidos. Desmárcalos para ocultarlos del editor; elimínalos para borrarlos definitivamente.';
$string['stylesbuiltin'] = 'Estilos integrados';
$string['stylesbuiltin_empty'] = 'Los estilos integrados no están disponibles porque el editor integrado no está instalado.';
$string['stylesbuiltin_hint'] = 'Desmarca un estilo para ocultarlo del editor. Los estilos integrados desactivados no se eliminan; el proyecto siempre puede recurrir al estilo por defecto.';
$string['stylestable_title'] = 'Título';
$string['stylestable_id'] = 'Id';
$string['stylestable_version'] = 'Versión';
$string['stylestable_installed'] = 'Instalado';
$string['stylestable_enabled'] = 'Habilitado';
$string['stylestable_actions'] = 'Acciones';
$string['stylesenable'] = 'Habilitar';
$string['stylesdisable'] = 'Deshabilitar';
$string['stylesdelete'] = 'Eliminar';
$string['stylesdelete_confirm'] = '¿Eliminar este estilo? Esta acción no se puede deshacer.';
$string['stylesdelete_success'] = 'Estilo eliminado.';
