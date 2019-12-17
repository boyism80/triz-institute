$.fn.ereadform = function (board, comments, option) {

	if(option == undefined)
		option				= {};

	if(option.linfo == undefined)
		option.linfo		= {};

	var $self				= $(this).readform(board, comments, option);
	var $attachFilesRow		= $self.find('.attach-files');

	var $submitRow			= $('<div class="readform-column"></div>').insertBefore($attachFilesRow);
	$('<span class="column_head"></span>').text('마감일').appendTo($submitRow);
	$('<span></span>').text(option.linfo.submit_date).appendTo($submitRow);

	if(option.linfo.limit_date != null) {

		var $limitRow			= $('<div class="readform-column"></div>').insertBefore($attachFilesRow);
		$('<span class="column_head"></span>').text('최종 마감일').appendTo($limitRow);
		$('<span></span>').text(option.linfo.limit_date).appendTo($limitRow);
	} else {

		var $limitRow			= $('<div class="readform-column"></div>').insertBefore($attachFilesRow);
		$('<span class="column_head"></span>').text('지각').appendTo($limitRow);
		$('<span></span>').text('불허').appendTo($limitRow);
	}

	var $scoreRow			= $('<div class="readform-column"></div>').insertBefore($attachFilesRow);
	$('<span class="column_head"></span>').text('점수').appendTo($scoreRow);
	$('<span></span>').text(option.linfo.score).appendTo($scoreRow);


	return $self;
}

$.fn.submitForm = function (option) {

	if(option == undefined)
		option				= {};

	if(option.data == undefined)
		option.data			= {};

	if(option.uploadFiles == undefined)
		option.uploadFiles	= function (name, files) {}

	if(option.deleteFiles == undefined)
		option.deleteFiles	= function (name, files) {}

	if(option.submit == undefined)
		option.submit 		= function () {}

	var $self				= $(this).addClass('submit-form');

	var $table				= $('<table class="lecture-table"></table>').appendTo($self);
	var $thead				= $('<thead></thead>').appendTo($table);
	var $tbody				= $('<tbody></tbody>').appendTo($table);

	var $titleRow			= $('<tr></tr>').appendTo($tbody);
	var $title 				= $('<div class="title highlight-color" style="font-size: 18px;"></div>').text('과제물 제출내용');
	$('<td></td>').attr('colspan', '2').append($title).appendTo($titleRow);

	var $editRow			= $('<tr></tr>').appendTo($tbody);
	var $editBox			= $('<div name="editbox-content"></div>');
	$('<td></td>').attr('colspan', '2').append($editBox).appendTo($editRow);
	$editBox.Editor();

	var $fileRow 			= $('<tr></tr>').appendTo($tbody);
	var $attaches			= $('<div id="lecture-files" name="lecture-files"></div>').appendTo($self).fileform({onupload: option.uploadFiles, ondelete: option.deleteFiles});
	$('<th></th>').text('첨부 파일').appendTo($fileRow);
	$('<td></td>').append($attaches).appendTo($fileRow);

	var $buttonBox			= $('<div class="button-box"></div>').appendTo($self);
	$('<div class="default-button"></div>').text('제출').bind('click', function () {

		var content 		= $editBox.Editor('getText');
		var files 			= $attaches.files();

		option.submit(content, files);
	} ).appendTo($buttonBox);

	$editBox.Editor('setText', option.data.content);
	$(option.data.files).each(function () {

		$attaches.add(this);
	} );

	return $self;
}

$.fn.manageForm = function () {

	var $self				= $(this);

	return $self;
}