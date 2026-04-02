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
 * Strings for component 'exeweb', language 'gl', version '4.1'.
 *
 * @package     mod_exeweb
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['areapackage'] = 'Ficheiro de paquete';
$string['badexelearningpackage'] = 'O paquete non cumpre coas normas dos contidos definidas para o sitio.';
$string['clicktodownload'] = 'Faga clic en {$a} para descargar o ficheiro.';
$string['clicktoopen2'] = 'Faga clic en {$a} para ver o ficheiro.';
$string['configdisplayoptions'] = 'Pode seleccionar calquera das opcións dispoñibles (os axustes existentes non se modificarán). Manteña premida a tecla CTRL para seleccionar varios campos simultaneamente.';
$string['configframesize'] = 'Cando se amosa unha páxina web ou un ficheiro cargado dentro dun marco (FRAME), este valor é o tamaño en píxeles do marco superior que contén a navegación.';
$string['configparametersettings'] = 'Configura o valor por defecto do panel de axustes cando se agregan novos recursos. Logo desta primeira vez, convértese nunha preferencia do usuario.';
$string['configpopup'] = 'Cando se agrega un recurso que pode amosarse nunha xanela emerxente ("popup"), esta opción débese activar por defecto?';
$string['configpopupdirectories'] = 'As xanelas "popup", deben amosar por defecto as ligazóns do directorio?';
$string['configpopupheight'] = 'Que altura deben ter por defecto as xanelas "popup"?';
$string['configpopuplocation'] = 'As xanelas "popup", deben amosar a barra de situación por defecto?';
$string['configpopupmenubar'] = 'As xanelas "popup", deben amosar a barra de menú por defecto?';
$string['configpopupresizable'] = 'As xanelas "popup", deben ser redimensionables por defecto?';
$string['configpopupscrollbars'] = 'As xanelas "popup", deben amosar as barras de desprazamento por defecto?';
$string['configpopupstatus'] = 'As xanelas "popup", deben amosar a barra de estado por defecto?';
$string['configpopuptoolbar'] = 'As xanelas "popup", deben amosar a barra de ferramentas por defecto?';
$string['configpopupwidth'] = 'Que ancho deben ter por defecto as xanelas "popup"?';
$string['contentheader'] = 'Contido';
$string['defaultdisplaysettings'] = 'Configuración de pantalla predeterminada';
$string['displayoptions'] = 'Opcións dispoñibles';
$string['displayselect'] = 'Amosar';
$string['displayselect_help'] = 'Este axuste determina como se amosa o contido. As opcións poden incluír:

* Incrustar - Un IFRAME dentro dunha páxina de actividade de Moodle, cos seus bloques laterais (dependerá do estilo de eXeLearning).
* No marco - Un FRAMESET con dous marcos. O superior amosa algún dato do curso no que estás e as opcións para ir ás actividades anterior e seguinte. O inferior amosa o contido do paquete.
* Nova xanela - Ábrese unha nova xanela do navegador.
* Abrir - Ábrese na mesma xanela do navegador.
* En xanela emerxente - Xanela tipo "popup".';
$string['displayselect_link'] = 'mod/exeweb/mod';
$string['displayselectexplain'] = 'Elixir tipo. Non todos os tipos funcionan con todos os contidos.';
$string['dnduploadexeweb'] = 'Crear un sitio web';
$string['exeonline:connectionsettings'] = 'Configuración da conexión co servidor eXeLearning';
$string['exeonline:baseuri'] = 'URI remoto';
$string['exeonline:baseuri_desc'] = 'URL de eXeLearning';
$string['exeonline:hmackey1'] = 'Clave de sinatura';
$string['exeonline:hmackey1_desc'] = 'Clave empregada para asinar os datos enviados ao servidor de eXeLearning, de xeito que poidamos estar seguros de que se orixinaron neste servidor. Empregue un máximo de 32 caracteres.';
$string['exeonline:provider_name'] = 'Provider name';
$string['exeonline:provider_name_desc'] = 'Name of the eXeLearning provider. This is used to identify the provider in the eXeLearning interface.';
$string['exeonline:provider_version'] = 'Provider version';
$string['exeonline:provider_version_desc'] = 'Version of the eXeLearning provider. This is used to identify the provider in the eXeLearning interface.';
$string['exeonline:tokenexpiration'] = 'Caducidade do token';
$string['exeonline:tokenexpiration_desc'] = 'Tempo máximo (en segundos) para editar o paquete en eXeLearning e volver a Moodle.';
$string['exeweb:forbiddenfileslist'] = 'Ficheiros prohibidos, lista RE';
$string['exeweb:forbiddenfileslist_desc'] = 'Aquí pode configurar unha lista de ficheiros prohibidos. Introduza cada ficheiro prohibido como unha expresión regular PHP (RE) nunha nova liña. Por exemplo:';
$string['exeweb:mandatoryfileslist'] = ' Ficheiros obrigatorios, lista RE';
$string['exeweb:mandatoryfileslist_desc'] = 'Aquí pódese configurar unha lista de ficheiros obrigatorios. Introduza cada ficheiro obrigatorio como unha expresión regular PHP (RE) nunha nova liña.';
$string['exeweb:onlinetypehelp'] = 'Cando faga clic en calquera dos botóns de gardar na parte inferior desta páxina, levarao a eXeLearning para crear ou editar o contido. Cando remate, eXeLearning enviarao de volta a Moodle.';
$string['exeweb:sendtemplate'] = 'Enviar modelo';
$string['exeweb:sendtemplate_desc'] = 'Envía o modelo predeterminado a eXeLearning ao crear un novo contido.';
$string['exeweb:template'] = 'Novo modelo de paquete.';
$string['exeweb:template_desc'] = 'O paquete (.zip ou .elpx) subido aquí empregarase como paquete por defecto para os novos contidos. Amosarase ata que sexa substituído polo enviado por eXeLearning. NON descomprima o paquete.';
$string['exeweb:editonlineanddisplay'] = 'Ir a eXeLearning e amosar';
$string['exeweb:editonlineandreturntocourse'] = 'Ir a eXeLearning e volver ao curso';
$string['filenotfound'] = 'Sentímolo, o ficheiro non se atopa.';
$string['filterfiles'] = 'Utilizar filtros de contido do ficheiro';
$string['filterfilesexplain'] = 'Seleccione o tipo de ficheiro que contén o filtro. Esto pode causar problemas nalgúns contidos. Por favor, revise que todos os ficheiros de texto están en UTF-8.';
$string['filtername'] = 'Auto-ligazón de nomes de recursos';
$string['forcedownload'] = 'Forzar descarga';
$string['framesize'] = 'Altura do marco';
$string['indicator:cognitivedepth'] = 'Ficheiro cognitivo';
$string['indicator:cognitivedepth_help'] = 'Este indicador está baseado na profundidade cognitiva acadada polo estudante.';
$string['indicator:cognitivedepthdef'] = 'Ficheiro cognitivo';
$string['indicator:cognitivedepthdef_help'] = 'O participante acadou esta porcentaxe de compromiso cognitivo ofrecido polos recursos durante este intervalo de análise (Niveis = Sen vista, Ver)';
$string['indicator:cognitivedepthdef_link'] = 'Learning_analytics_indicators#Cognitive_depth';
$string['indicator:socialbreadth'] = 'Ficheiro social';
$string['indicator:socialbreadth_help'] = 'Este indicador está baseado na amplitude social acadada polo estudante.';
$string['indicator:socialbreadthdef'] = 'Ficheiro social';
$string['indicator:socialbreadthdef_help'] = 'O participante acadou esta porcentaxe de compromiso social ofrecido polos recursos durante este intervalo de análise (Niveis = Sen participación, Participante só)';
$string['indicator:socialbreadthdef_link'] = 'Learning_analytics_indicators#Social_breadth';
$string['invalidpackage'] = 'Paquete inválido.';
$string['modifieddate'] = 'Actualizado  {$a}';
$string['modulename'] = 'eXeLearning (sitio web)';
$string['modulename_help'] = 'O módulo eXeLearning (sitio web) permite ao profesorado crear unha actividade partindo dun sitio web xerado con eXeLearning. O contido pode ser subido, creado e editado directamente en eXeLearning.';
$string['modulename_link'] = 'mod/exeweb/view';
$string['modulenameplural'] = 'eXeLearning (sitios web)';
$string['optionsheader'] = 'Amosar opcións';
$string['player:toogleFullscreen'] = 'Alternar pantalla completa';
$string['package'] = 'Paquete';
$string['package_help'] = 'O ficheiro do paquete é un ficheiro que contén un sitio web comprimido en zip xerado con eXeLearning.';
$string['packagehdr'] = 'Paquete';
$string['page-mod-exeweb-x'] = 'Calquera páxina do módulo';
$string['pluginadministration'] = 'Administración do módulo';
$string['pluginname'] = 'eXeLearning (sitio web)';
$string['popupheight'] = 'Altura (en píxeles) da xanela emerxente';
$string['popupheightexplain'] = 'Especifica a altura por defecto das xanelas emerxentes.';
$string['popupexeweb'] = 'Este recurso debe aparecer nunha xanela emerxente';
$string['popupexeweblink'] = 'Se non, faga clic aquí: {$a}';
$string['popupwidth'] = 'Largura (en píxeles) da xanela emerxente';
$string['popupwidthexplain'] = 'Especifica a largura por defecto das xanelas emerxentes.';
$string['printintro'] = 'Amosar descrición do recurso';
$string['printintroexplain'] = 'Amosar a descrición do recurso debaixo do contido? Algúns tipos de visualización poden non amosar a descrición inda que estea activada esa opción.';
$string['privacy:metadata'] = 'O complemento non almacena ningún dato persoal.';
$string['exeweb:addinstance'] = 'Engadir un novo recurso';
$string['exewebcontent'] = 'Ficheiros e subcartafoles';
$string['exewebdetails_'] = 'Evitar mdlcode unknown-string error message';
$string['exewebdetails_size'] = 'Evitar mdlcode unknown-string error message';
$string['exewebdetails_type'] = 'Evitar mdlcode unknown-string error message';
$string['exewebdetails_date'] = 'Evitar mdlcode unknown-string error message';
$string['exewebdetails_sizetype'] = '{$a->size} {$a->type}';
$string['exewebdetails_sizedate'] = '{$a->size} {$a->date}';
$string['exewebdetails_typedate'] = '{$a->type} {$a->date}';
$string['exewebdetails_sizetypedate'] = '{$a->size} {$a->type} {$a->date}';
$string['exeorigin'] = 'Tipo';
$string['exeorigin_help'] = 'Este axuste determina como se inclúe o paquete no curso. Hai dúas opcións:

* Paquete subido - Permite elixir o zip creado con eXeLearning por medio do selector de ficheiros.
* Crear/Editar con eXeLearning - Crea a actividade e abre eXeLearning para editar o contido. Ao rematar, eXeLearning enviará o paquete de contido de volta a Moodle.';
$string['exeweb:exportexeweb'] = 'Exportar recurso';
$string['exeweb:view'] = 'Ver recurso';
$string['search:activity'] = 'Ficheiro';
$string['selectmainfile'] = 'Selecciona o ficheiro principal premendo na icona que hai xunta o seu nome.';
$string['showdate'] = 'Amosar a data de subida/modificación';
$string['showdate_desc'] = 'Amosar a data de subida/modificación na páxina do curso?';
$string['showdate_help'] = 'Amosa a data de subida/modificación xunta a ligazón ao ficheiro.';
$string['showsize'] = 'Amosar tamaño';
$string['showsize_help'] = 'Amosa o tamaño do ficheiro, co formato \'3.1 MB \', xunta a ligazón ao ficheiro.';
$string['showsize_desc'] = 'Amosar o tamaño do ficheiro na páxina do curso?';
$string['showtype'] = 'Amosar tipo';
$string['showtype_desc'] = 'Amosar tipo de ficheiro (ex. \'Documento de Texto\') na páxina do curso?';
$string['showtype_help'] = 'Amosa o tipo de documento (ex. \'Documento de Texto\') a carón da ligazón ao ficheiro.

Se hai varios ficheiros no recurso, amosa o tipo del ficheiro inicial.

Se o tipo de ficheiro é descoñecido para o sistema, nos se amosa.';
$string['uploadeddate'] = 'Enviado {$a}';
$string['embeddededitorsettings'] = 'Tipo de editor';
$string['embeddededitorstatus'] = 'Editor embebido';
$string['editorlatestversionongithub'] = 'Última versión en GitHub:';
$string['manageembeddededitor'] = 'Xestionar editor embebido';
$string['manageembeddededitor_desc'] = 'Instalar, actualizar ou reparar o editor embebido de eXeLearning.';
$string['editorsource_moodledata'] = 'Instalado (xestionado pola administración)';
$string['editorsource_bundled'] = 'Incluído co plugin';
$string['editorsource_none'] = 'Non instalado';
$string['editorinstall'] = 'Instalar a última versión';
$string['editorupdate'] = 'Actualizar editor';
$string['editoruninstall'] = 'Eliminar';
$string['editorinstallsuccess'] = 'O editor eXeLearning v{$a} instalouse correctamente.';
$string['editoruninstallsuccess'] = 'Eliminouse a instalación do editor embebido.';
$string['editorversion'] = 'Versión';
$string['editorinstalledat'] = 'Instalado o';
$string['editorsource'] = 'Orixe';
$string['editoractivesource'] = 'Orixe activa';
$string['editormoodledatadir'] = 'Directorio de datos';
$string['editorbundleddir'] = 'Directorio incluído';
$string['editorlatestversion'] = 'Última versión dispoñible';
$string['editorstatusinfo'] = 'O editor embebido serve recursos estáticos para o editor integrado de eXeLearning. As orixes compróbanse nesta orde: instalado pola administración (moodledata) e despois incluído co plugin (dist/).';
$string['editorgithubconnecterror'] = 'Non se puido conectar con GitHub: {$a}';
$string['editorgithubapierror'] = 'GitHub devolveu o estado HTTP {$a}. Ténteo de novo máis tarde.';
$string['editorgithubparseerror'] = 'Non se puido interpretar a información da última versión publicada en GitHub.';
$string['editordownloaderror'] = 'Produciuse un erro ao descargar o paquete do editor: {$a}';
$string['editordownloademptyfile'] = 'O ficheiro descargado está baleiro.';
$string['editorinvalidzip'] = 'O ficheiro descargado non é un ZIP válido.';
$string['editorzipextensionmissing'] = 'A extensión PHP ZipArchive non está dispoñible. Pídalle ao administrador do servidor que a habilite.';
$string['editorextractfailed'] = 'Produciuse un erro ao extraer o paquete do editor: {$a}';
$string['editorextractwriteerror'] = 'Non se puideron escribir os ficheiros extraídos no directorio temporal.';
$string['editorinvalidlayout'] = 'O paquete non contén os ficheiros esperados do editor (index.html e directorios de recursos).';
$string['editorinstallfailed'] = 'Produciuse un erro ao instalar o editor: {$a}';
$string['editormkdirerror'] = 'Non se puido crear o directorio: {$a}';
$string['editorbackuperror'] = 'Non se puido crear unha copia de seguridade da instalación existente do editor.';
$string['editorcopyfailed'] = 'Non se puideron copiar os ficheiros do editor ao directorio de destino.';
$string['editorinstallconcurrent'] = 'Xa hai unha instalación en curso. Agarde uns minutos e ténteo de novo.';
$string['editorconfirmuninstall'] = 'Está seguro de que desexa eliminar o editor instalado pola administración? Utilizarase a versión incluída ou remota.';
$string['editorupdateavailable'] = 'Actualización dispoñible: v{$a}';
$string['editorcurrentversion'] = 'Versión actual: v{$a}';
$string['editornotyetinstalled'] = 'Non se atopou ningún editor instalado pola administración.';
$string['editormoodledatasource'] = 'Instalado polo administrador (moodledata)';
$string['editorbundledsource'] = 'Incluído co plugin';
$string['editoravailable'] = 'Dispoñible';
$string['editornotavailable'] = 'Non dispoñible';
$string['editormanagelink'] = 'Xestionar editor embebido';
$string['editorsourceprecedence'] = 'Prioridade de orixe: instalado pola administración > incluído.';
$string['exeweb:manageembeddededitor'] = 'Xestionar a instalación do editor embebido de eXeLearning';
$string['editorcheckingerror'] = 'Non se puideron comprobar as actualizacións. É posible que GitHub non estea dispoñible temporalmente.';
$string['editorinstallconfirm'] = 'Isto descargará e instalará a última versión do editor eXeLearning (v{$a}) desde GitHub. Desexa continuar?';
$string['editoradminrequired'] = 'O editor embebido de eXeLearning non está instalado. Contacte co administrador do sitio.';
$string['editormanagementhelp'] = 'Descargue e instale desde GitHub a última versión do editor de eXeLearning. A versión instalada polo administrador ten prioridade sobre a incluída co plugin.';
$string['editorbundleddesc'] = 'O plugin inclúe unha versión. Pode instalar a última versión publicada en GitHub.';
$string['editornotinstalleddesc'] = 'Instale o editor desde GitHub para habilitar o modo de edición embebido.';
$string['invalidaction'] = 'Acción non válida: {$a}';
$string['installing'] = 'Instalando...';
$string['checkingforupdates'] = 'Comprobando actualizacións...';
$string['operationtakinglong'] = 'A operación está tardando máis do esperado. Comprobando estado...';
$string['checkingstatus'] = 'Comprobando estado...';
$string['stillworking'] = 'Segue en proceso...';
$string['operationtimedout'] = 'A operación superou o tempo de espera. Comprobe o estado do editor e ténteo de novo.';
$string['latestversionchecking'] = 'Comprobando...';
$string['latestversionerror'] = 'Non se puideron comprobar as actualizacións';
$string['updateavailable'] = 'Actualización dispoñible';
$string['installstale'] = 'A instalación pode fallar. Ténteo de novo.';
$string['noeditorinstalled'] = 'Non hai ningún editor instalado';
$string['confirmuninstall'] = 'Está seguro de que desexa desinstalar o editor embebido? Isto eliminará a copia instalada pola administración de moodledata.';
$string['confirmuninstalltitle'] = 'Confirmar desinstalación';
$string['editorinstalledsuccess'] = 'Editor instalado correctamente';
$string['editoruninstalledsuccess'] = 'Editor desinstalado correctamente';
$string['editorupdatedsuccess'] = 'Editor actualizado correctamente';
$string['editorrepairsuccess'] = 'Editor reparado correctamente';
$string['editormode'] = 'Modo de editor';
$string['editormodedesc'] = 'Seleccione que editor usar para crear e editar contido eXeLearning. A configuración de conexión online só aplica cando se selecciona o modo "eXeLearning Online".';
$string['editormodeonline'] = 'eXeLearning Online (servidor remoto)';
$string['editormodeembedded'] = 'Editor integrado (embebido)';
$string['embeddednotinstalled'] = 'Os ficheiros do editor integrado non están instalados.';
$string['embeddednotinstalledcontactadmin'] = 'Os ficheiros do editor integrado non están instalados. Contacte co administrador do sitio para instalalo.';
$string['embeddednotinstalledadmin'] = 'Os ficheiros do editor integrado non están instalados. Pode instalalo desde a configuración do complemento.';$string['editembedded'] = 'Editar con eXeLearning';
$string['editembedded_integrated'] = 'Integrado';
$string['editembedded_help'] = 'Abre o editor eXeLearning integrado para editar o contido directamente dentro de Moodle.';
$string['editormissing'] = 'O editor integrado eXeLearning non está instalado. Contacte co administrador.';
$string['editorreaderror'] = 'Non se puideron ler os ficheiros do editor integrado eXeLearning. Comprobe os permisos dos ficheiros e contacte co administrador.';
$string['embeddedtypehelp'] = 'Crearase a actividade e poderá editala usando o editor eXeLearning integrado dende a páxina de visualización da actividade.';
$string['saving'] = 'Gardando...';
$string['savedsuccess'] = 'Cambios gardados correctamente';
$string['savetomoodle'] = 'Gardar en Moodle';
$string['savingwait'] = 'Por favor, agarde mentres se garda o ficheiro.';
$string['unsavedchanges'] = 'Ten cambios sen gardar. Está seguro de que desexa pechar?';
$string['typeembedded'] = 'Crear con eXeLearning (editor integrado)';
$string['typeexewebcreate'] = 'Crear con eXeLearning';
$string['typeexewebedit'] = 'Editar con eXeLearning';
$string['typelocal'] = 'Paquete enviado';
