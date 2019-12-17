$.fn.eclassTable = function (data) {

	var $self				= $(this).addClass('e-class');
	var $table 				= $('<table class="eclass-table"></table>').appendTo($self);
	var $thead				= $('<thead></thead>').appendTo($table);
	var $tbody				= $('<tbody></tbody>').appendTo($table);

	var $headRow			= $('<tr></tr>').appendTo($thead);
	$('<th></th>').text('과목').appendTo($headRow);
	$('<th></th>').text('개설일').appendTo($headRow);

	$self.add = function (item) {

		var $row 			= $('<tr></tr>').appendTo($tbody);
		var $title			= $('<td></td>').appendTo($row);
		var $date			= $('<td style="text-align: center;"></td>').text(item.date.split(' ')[0]).appendTo($row);

		$('<a style="cursor: pointer;"></a>').attr('href', 'eclass/board/' + item.name).text(item.title).appendTo($title);

		return $self;
	}

	$(data).each(function () {

		$self.add(this);
	} );
}