jQuery(document).ready(function($) {

	// Retrieve the clear conversation button from the panel
	var element = jQuery('#Panel > .ClearConversation');
	
	// If it exists, move it to content
	if ( element.length > 0 )
		moveElement(element);
	
	// Takes a element and moves it to the top of the content div
	function moveElement(element)
	{
		// Remove the original element from its original location
		element.remove();
		
		// The element must be placed after the New Conversation button
		$('.NewConversation').after(element);
	}
});