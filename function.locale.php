<?php
/**
 * ------------------------------------------------------------------------- *
 * This library is free software; you can redistribute it and/or             *
 * modify it under the terms of the GNU Lesser General Public                *
 * License as published by the Free Software Foundation; either              *
 * version 2.1 of the License, or (at your option) any later version.        *
 *                                                                           *
 * This library is distributed in the hope that it will be useful,           *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of            *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU         *
 * Lesser General Public License for more details.                           *
 *                                                                           *
 * You should have received a copy of the GNU Lesser General Public          *
 * License along with this library; if not, write to the Free Software       *
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA *
 * ------------------------------------------------------------------------- *
 *
 * Installation: 
 *
 * @package smarty-gettext
 * @link  http://code.google.com/p/smarty-gettext/
 * @link  https://github.com/glensc/smarty-gettext/
 * @author  Karlheinz Toni <karlheinz.toni@gmail.com>
 * @author  Boleslaw Tekielski <bolek@gvault13.pl>
 * @copyright 2012 Karlheinz Toni
 * @copyright 2015 Boleslaw Tekielski
 */

function smarty_function_locale($params, &$smarty){
  $path = is_null($smarty) ? $params['path'] : $smarty->joined_template_dir . $params['path'];
  $domain = (isset($params['domain']) ? str_replace(array( "'", '"' ), '', $params[ 'domain' ]) : 'messages'); 
  bind_textdomain_codeset($domain, 'UTF-8');
  bindtextdomain($domain, $path); 
  textdomain($domain);
}
?>