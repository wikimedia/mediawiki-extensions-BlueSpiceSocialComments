/**
 *
 * @author     Patric Wirth <wirth@hallowelt.com>
 * @package    BluespiceSocial
 * @subpackage BSSocialComments
 * @copyright  Copyright (C) 2017 Hallo Welt! GmbH, All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License v2 or later
 */

bs.social.EntityComment = function( $el, type, data ) {
	bs.social.EntityText.call( this, $el, type, data );
	var me = this;
};
OO.initClass( bs.social.EntityComment );
OO.inheritClass( bs.social.EntityComment, bs.social.EntityText );

bs.social.EntityComment.static.name = "\\BlueSpice\\Social\\Comments\\Entity\\Comment";
bs.social.factory.register( bs.social.EntityComment );
