<head>
<script type="text/javascript">

	function createEClass () {

		var title			= $('input[name="title"]').val();
		var name			= $('input[name="name"]').val();
		var pw				= $('input[name="pw"]').val();

		$.ajax({type: 'POST',
				async: false,
				url: '<?php echo base_url('eclass/add'); ?>',
				data: {title: title, name: name, pw: pw},
				dataType: 'json',
				success: function (result) {

					if(result.success == false) {

						alert(result.error);
						return;
					}

					location.reload();
				}, 
				error: function (request, status, error) {
					console.log(request.responseText);
				}});
	}
</script>
</head>

<form action="<?php echo base_url('eclass/add'); ?>" data-ajax="false">
	<table class="default-table">
		<thead>
			<tr>
				<td>구분</td>
				<td>값</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>과목 이름</th>
				<td>
					<input name="title" type="text" placeholder="Ex) 트리즈 Level 1">
				</td>
			</tr>
			<tr>
				<th>URL 태그</th>
				<td>
					<input name="name" type="text" placeholder="Ex) level1">
				</td>
			</tr>
			<tr>
				<th>비밀번호</th>
				<td>
					<input name="pw" type="password">
				</td>
			</tr>
		</tbody>
	</table>
	<div id="create" class="default-button" onclick="createEClass()">생성</div>
</form>