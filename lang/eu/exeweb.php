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
 * Strings for component 'exeweb', language 'eu', version '4.1'.
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
$string['exeonline:provider_name'] = 'Provider name';
$string['exeonline:provider_name_desc'] = 'Name of the eXeLearning provider. This is used to identify the provider in the eXeLearning interface.';
$string['exeonline:provider_version'] = 'Provider version';
$string['exeonline:provider_version_desc'] = 'Version of the eXeLearning provider. This is used to identify the provider in the eXeLearning interface.';
$string['exeonline:tokenexpiration'] = 'Caducidad del token';
$string['exeonline:tokenexpiration_desc'] = 'Tiempo máximo (en segundos) para editar el paquete en eXeLearning y volver a Moodle.';
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
$string['exeorigin_help'] = 'Este ajuste determina cómo se incluye el paquete en el curso. Hay dos opciones:

* Paquete subido - Permite elegir el zip creado con eXeLearning por medio del selector de archivos.
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
$string['embeddededitorsettings'] = 'Editore mota';
$string['embeddededitorstatus'] = 'Editore txertatua';
$string['editorlatestversionongithub'] = 'GitHub-eko azken bertsioa:';
$string['manageembeddededitor'] = 'Kudeatu editore txertatua';
$string['manageembeddededitor_desc'] = 'Instalatu, eguneratu edo konpondu eXeLearning editore txertatua.';
$string['editorsource_moodledata'] = 'Instalatua (administrazioak kudeatua)';
$string['editorsource_bundled'] = 'Pluginarekin batera dator';
$string['editorsource_none'] = 'Instalatu gabe';
$string['editorinstall'] = 'Instalatu azken bertsioa';
$string['editorupdate'] = 'Eguneratu editorea';
$string['editoruninstall'] = 'Ezabatu';
$string['editorinstallsuccess'] = 'eXeLearning editorea ondo instalatu da: v{$a}.';
$string['editoruninstallsuccess'] = 'Editore txertatuaren instalazioa ezabatu da.';
$string['editorversion'] = 'Bertsioa';
$string['editorinstalledat'] = 'Instalazio-data';
$string['editorsource'] = 'Jatorria';
$string['editoractivesource'] = 'Jatorri aktiboa';
$string['editormoodledatadir'] = 'Datuen direktorioa';
$string['editorbundleddir'] = 'Barneko direktorioa';
$string['editorlatestversion'] = 'Eskuragarri dagoen azken bertsioa';
$string['editorstatusinfo'] = 'Editore txertatuak baliabide estatikoak zerbitzatzen ditu eXeLearning editore integraturako. Jatorriak ordena honetan egiaztatzen dira: administrazioak instalatutakoa (moodledata) eta, ondoren, pluginarekin datorrena (dist/).';
$string['editorgithubconnecterror'] = 'Ezin izan da GitHub-era konektatu: {$a}';
$string['editorgithubapierror'] = 'GitHub-ek HTTP egoera hau itzuli du: {$a}. Saiatu berriro geroago.';
$string['editorgithubparseerror'] = 'Ezin izan da GitHub-eko azken argitalpenaren informazioa interpretatu.';
$string['editordownloaderror'] = 'Errorea editorearen paketea deskargatzean: {$a}';
$string['editordownloademptyfile'] = 'Deskargatutako fitxategia hutsik dago.';
$string['editorinvalidzip'] = 'Deskargatutako fitxategia ez da ZIP balioduna.';
$string['editorzipextensionmissing'] = 'PHP ZipArchive hedapena ez dago erabilgarri. Eskatu zerbitzariaren administratzaileari gaitzeko.';
$string['editorextractfailed'] = 'Errorea editorearen paketea erauztean: {$a}';
$string['editorextractwriteerror'] = 'Ezin izan dira erauzitako fitxategiak aldi baterako direktorioan idatzi.';
$string['editorinvalidlayout'] = 'Paketeak ez ditu espero diren editore-fitxategiak (index.html eta baliabideen direktorioak).';
$string['editorinstallfailed'] = 'Errorea editorea instalatzean: {$a}';
$string['editormkdirerror'] = 'Ezin izan da direktorioa sortu: {$a}';
$string['editorbackuperror'] = 'Ezin izan da lehendik zegoen editore-instalazioaren babeskopia sortu.';
$string['editorcopyfailed'] = 'Ezin izan dira editore-fitxategiak helmugako direktoriora kopiatu.';
$string['editorinstallconcurrent'] = 'Badago beste instalazio bat martxan. Itxaron minutu batzuk eta saiatu berriro.';
$string['editorconfirmuninstall'] = 'Ziur zaude administrazioak instalatutako editorea ezabatu nahi duzula? Barneko edo urruneko bertsioa erabiliko da.';
$string['editorupdateavailable'] = 'Eguneraketa eskuragarri: v{$a}';
$string['editorcurrentversion'] = 'Uneko bertsioa: v{$a}';
$string['editornotyetinstalled'] = 'Ez da administrazioak instalatutako editorerik aurkitu.';
$string['editormoodledatasource'] = 'Administratzaileak instalatua (moodledata)';
$string['editorbundledsource'] = 'Pluginarekin batera dator';
$string['editoravailable'] = 'Eskuragarri';
$string['editornotavailable'] = 'Ez dago erabilgarri';
$string['editormanagelink'] = 'Kudeatu editore txertatua';
$string['editorsourceprecedence'] = 'Jatorri-lehentasuna: administrazioak instalatua > barnekoa.';
$string['exeweb:manageembeddededitor'] = 'Kudeatu eXeLearning editore txertatuaren instalazioa';
$string['editorcheckingerror'] = 'Ezin izan dira eguneraketak egiaztatu. Baliteke GitHub aldi baterako erabilgarri ez egotea.';
$string['editorinstallconfirm'] = 'Honek GitHub-etik eXeLearning editorearen azken bertsioa (v{$a}) deskargatu eta instalatuko du. Jarraitu?';
$string['editoradminrequired'] = 'eXeLearning editore txertatua ez dago instalatuta. Jarri harremanetan guneko administratzailearekin.';
$string['editormanagementhelp'] = 'Deskargatu eta instalatu GitHub-etik eXeLearning editorearen azken bertsioa. Administratzaileak instalatutako bertsioak lehentasuna du pluginarekin datorrenaren aurrean.';
$string['editorbundleddesc'] = 'Pluginak bertsio bat dakar. GitHub-en argitaratutako azken bertsioa instala dezakezu.';
$string['editornotinstalleddesc'] = 'Instalatu editorea GitHub-etik edizio txertatuko modua gaitzeko.';
$string['invalidaction'] = 'Ekintza baliogabea: {$a}';
$string['installing'] = 'Instalatzen...';
$string['checkingforupdates'] = 'Eguneraketak egiaztatzen...';
$string['operationtakinglong'] = 'Eragiketa espero baino gehiago ari da irauten. Egoera egiaztatzen...';
$string['checkingstatus'] = 'Egoera egiaztatzen...';
$string['stillworking'] = 'Oraindik lanean...';
$string['operationtimedout'] = 'Eragiketak denbora-muga gainditu du. Egiaztatu editorearen egoera eta saiatu berriro.';
$string['latestversionchecking'] = 'Egiaztatzen...';
$string['latestversionerror'] = 'Ezin izan dira eguneraketak egiaztatu';
$string['updateavailable'] = 'Eguneraketa eskuragarri';
$string['installstale'] = 'Baliteke instalazioak huts egin izana. Saiatu berriro.';
$string['noeditorinstalled'] = 'Ez dago editorerik instalatuta';
$string['confirmuninstall'] = 'Ziur zaude editore txertatua desinstalatu nahi duzula? Honek moodledata-ko administrazioak instalatutako kopia ezabatuko du.';
$string['confirmuninstalltitle'] = 'Berretsi desinstalazioa';
$string['editorinstalledsuccess'] = 'Editorea ondo instalatu da';
$string['editoruninstalledsuccess'] = 'Editorea ondo desinstalatu da';
$string['editorupdatedsuccess'] = 'Editorea ondo eguneratu da';
$string['editorrepairsuccess'] = 'Editorea ondo konpondu da';
$string['editormode'] = 'Editore modua';
$string['editormodedesc'] = 'Aukeratu zein editore erabili eXeLearning edukia sortu eta editatzeko. Online konexio-ezarpenak soilik aplikatzen dira "eXeLearning Online" modua hautatzen denean.';
$string['editormodeonline'] = 'eXeLearning Online (urruneko zerbitzaria)';
$string['editormodeembedded'] = 'Editore txertatua (integratua)';
$string['embeddednotinstalledcontactadmin'] = 'Editore txertatuaren fitxategiak ez daude instalatuta. Jarri harremanetan guneko administratzailearekin instalatzeko.';
$string['embeddednotinstalledadmin'] = 'Editore txertatuaren fitxategiak ez daude instalatuta. Pluginaren ezarpenetan instala dezakezu.';
$string['editembedded'] = 'Editatu eXeLearning-ekin';
$string['editembedded_integrated'] = 'Integratua';
$string['editembedded_help'] = 'Ireki eXeLearning editore txertatua edukia zuzenean Moodle-n editatzeko.';
$string['editormissing'] = 'eXeLearning editore txertatua ez dago instalatuta. Jarri harremanetan administratzailearekin.';
$string['editorreaderror'] = 'Ezin izan dira eXeLearning editore txertatuaren fitxategiak irakurri. Egiaztatu fitxategien baimenak eta jarri harremanetan administratzailearekin.';
$string['embeddedtypehelp'] = 'Jarduera sortuko da eta eXeLearning editore txertatuarekin editatu ahal izango duzu jardueraren ikuspegi-orritik.';
$string['saving'] = 'Gordetzen...';
$string['savedsuccess'] = 'Aldaketak ondo gorde dira';
$string['savetomoodle'] = 'Moodle-n gorde';
$string['savingwait'] = 'Mesedez, itxaron fitxategia gordetzen den bitartean.';
$string['unsavedchanges'] = 'Gorde gabeko aldaketak dituzu. Ziur zaude itxi nahi duzula?';
$string['typeembedded'] = 'Sortu eXeLearning-ekin (editore txertatua)';
$string['typeexewebcreate'] = 'Crear con eXeLearning';
$string['typeexewebedit'] = 'Editar con eXeLearning';
$string['typelocal'] = 'Paquete subido';
