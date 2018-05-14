/**
 *
 * @author     Patric Wirth <wirth@hallowelt.com>
 * @package    BluespiceSocial
 * @subpackage BSSocialComments
 * @copyright  Copyright (C) 2017 Hallo Welt! GmbH, All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License v2 or later
 */

$( document ).bind( 'BSSocialEntityInit', function( event, Entity, $el, type, data ) {
	if( !Entity.getConfig().CanHaveChildren ) {
		return;
	}
	var $anchor = Entity.getContainer( Entity.AFTER_CONTENT_CONTAINER )
			.find('.bs-social-entityaftercontent-comment');

	$anchor.on( 'click', function() {
		Entity.getContainer( Entity.CHILDREN_CONTAINER ).toggle();
	});
});