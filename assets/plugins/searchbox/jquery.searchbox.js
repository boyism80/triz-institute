$.fn.searchbox = function (types, callback) {
	var $self 			= $(this).addClass('searchbox');
    
    // methods
    $self.keyword 		= function (text) {
    	if(text == undefined)
    		return $inputbox.val();
    	$inputbox.val(text);
    	return $self;
    };

    $self.type = function (value) {
    	if(value == undefined)
    		return $boardtypes.children('option:selected').attr('type');
    	$boardtypes.children('option[type=' + value + ']').prop('selected', true);
    	return $self;
    };

    var $boardtypes 	= null;
    if(types != null)
        $boardtypes     = $('<select name="board-type" data-inline="true"></select>').appendTo($self);
    
    var $inputbox 		= $('<input type="text" name="keyword"></input>').bind('keyup', function (event) {
    	if(event.keyCode == 13)
    		$searchbtn.trigger('click');
    } ).appendTo($self);

    var $searchbtn 		= $('<span class="default-button" name="search">검색</span>').bind('click', function () {
    	if(callback != undefined)
    		callback($boardtypes.children('option:selected').attr('type'), $inputbox.val());
    } ).appendTo($self);

    if (types != null) {
    	$(types).each(function (i) {
    		$('<option></option>').attr('value', i).text(this.text).attr('type', this.type).appendTo($boardtypes);
    	});
    }

    return $self;
}