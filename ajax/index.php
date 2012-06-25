<?php
/***********************************************************
| eXtreme-Fusion 5.0 Beta 5
| Content Management System       
|
| Copyright (c) 2005-2012 eXtreme-Fusion Crew                	 
| http://extreme-fusion.org/                               		 
|
| This product is licensed under the BSD License.				 
| http://extreme-fusion.org/ef5/license/						 
***********************************************************/

require_once '../config.php';
require_once DIR_SYSTEM.'sitecore.php';

// Wczytywanie g��wnej klasy
require_once DIR_CLASS.'themes.php';

// Tworzenie emulatora statyczno�ci klasy OPT
TPL::build($_theme = new Theme($_sett, $_user));

$_tpl = new SiteAjax;

try
{
	$file = $_request->get('file')->strip();

	if (file_exists(DIR_AJAX.DS.$file.'.php'))
	{
		require_once DIR_AJAX.DS.$file.'.php';
	}
	else
	{
		throw new systemException('Plik '.$file.' nie zosta� odnaleziony w katalogu <span class="italic">/ajax/</span>.');
	}

	// Metoda za�aduje plik TPL je�li istnieje w szablonie lub katalogu ajax.
	// Je�li nie istnieje, to nie zwr�ci �adnej warto�ci.
	$_tpl->template($file.'.tpl', $_tpl->themeTplExists($file.'.tpl'));
}
catch(optException $exception)
{
	optErrorHandler($exception);
}
catch(systemException $exception)
{
	systemErrorHandler($exception);
}
catch(userException $exception)
{
	userErrorHandler($exception);
}
catch(PDOException $exception)
{
    PDOErrorHandler($exception);
}