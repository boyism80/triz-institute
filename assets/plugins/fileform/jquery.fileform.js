$.fn.fileform = function (option) {

	if(option == undefined)
		option				= {};

	if(option.maxsize == undefined)
		option.maxsize 		= 10 * Math.pow(1024, 2);

	if(option.onupload == undefined)
		option.onupload 	= function (name, files) {};

	if(option.onuploaded == undefined)
		option.onuploaded	= function (name, files) {};

	if(option.ondelete == undefined)
		option.ondelete 	= function (name, files) {};

	var $self				= $(this).addClass('fileform');
	var $select 			= $('<select class="list" name="attach-files" size="3"></select>)').appendTo($self);

	var $buttonBox			= $('<div class="ctrl-file-btns""></div>').appendTo($self);
	var $btnbrowse			= $('<span class="default-button uploadform"></span>').text('파일찾기').appendTo($buttonBox);
	var $btnfile			= $('<input type="file" class="hidden-file" multiple="multiple" />').bind('change', function () {

		var files 			= $(this).prop('files');
		var result			= option.onupload($self.attr('name'), files);

		$(result).each(function () {

			if($self.add(this) == false)
				return false;

			option.onuploaded(this);
		} );

		$(this).val('');
	} ).appendTo($btnbrowse);
	if(option.accept != undefined)
		$btnfile.attr('accept', option.accept);

	var $btnupload 			= $('<span class="default-button"></span>').text('파일삭제').bind('click', function () {

		$self.delete();
	} ).appendTo($buttonBox);


	var $capacityview 		= $('<span class="capacity-viewer"></span>').appendTo($self);
	var $currentRange 		= $('<span class="current-range highlight-background"></span>').appendTo($capacityview);
	var $capacityText 		= $('<span class="current-size" style="margin-left: 10px;"></span>').appendTo($self);


	$self.add 				= function (file) {

		if($self.size() + (file.size) > option.maxsize) {

			alert('최대 업로드 크기를 초과했습니다.');
			return false;
		}

		$('<option></option>').text(file.title).data('file', file).appendTo($select);
		$self.update();
		return $self;
	}

	$self.delete 			= function () {

		try {
			var $option 	= $select.children('option:selected');
			if($option.length == 0)
				throw '선택된 파일이 없습니다.';

			var file 		= $option.data('file');
			if(file == null) 
				throw '파일이 없습니다.';

			option.ondelete(file);

			$option.remove();
			$self.update();

		} catch(err) {

			alert(err);
		}

		return this;
	}


	$self.files 			= function () {

		var ret 			= [];
		$select.find('option').each(function (idx, val) {

			ret[idx]		= $(val).data('file');
		} );

		return ret;
	}

	$self.size 				= function () {

		var ret 			= 0;
		var files 			= $self.files();
		$(files).each(function () {

			ret 			+= this.size;
		} );

		return ret;
	}

	$self.update = function () {

		function sizetostr(size) {
			var cvtstr 		= null;

			if(size >= Math.pow(1024, 2))
				cvtstr 		= (size / Math.pow(1024, 2)).toFixed(2) + 'MB';
			else if(size >= Math.pow(1024, 1))
				cvtstr 		= (size / Math.pow(1024, 1)).toFixed(1) + 'KB';
			else
				cvtstr 		= size + 'Bytes';

			return cvtstr;
		}

		var size 			= $self.size();
		$capacityText.text(sizetostr(size) + ' / ' + sizetostr(option.maxsize));


		var percent 		= 100 * (size / option.maxsize);
		$currentRange.css('width', percent + '%');

		return $self;
	};

	$self.update();
	return $self;
}