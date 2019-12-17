<head>
<script type="text/javascript" src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/numeric/jquery.numeric.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/mypage/jquery.modify.js'); ?>"></script>
<script type="text/javascript">

	function openBrWindow() {

	    new daum.Postcode({
	        oncomplete: function (data) {
	            var addrFull = ''; // 최종 주소 변수
	            var addrExtra = ''; // 조합형 주소 변수

	            // R : 도로명 주소, J : 지번주소
	            if (data.userSelectedType === 'R')
	                addrFull = data.roadAddress;
	            else
	                addrFull = data.jibunAddress;

	            // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
	            if (data.userSelectedType === 'R') {
	                
	                // 법정동명이 있는 경우
	                if (data.bname !== '')
	                    addrExtra += data.bname;
	                
	                // 건물명이 있는 경우
	                if (data.buildingName !== '')
	                    addrExtra += (addrExtra !== '' ? ', ' + data.buildingName : data.buildingName);
	                
	                // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
	                addrFull += (addrExtra !== '' ? ' (' + addrExtra + ')' : '');
	            }

	            $('input[name=zcode]').val(data.zonecode);
	            $('input[name=addr]').val(addrFull);
	            $('input[name=addr_detail]').val('');
	        }
	    }).open();
	}
	
	$(document).ready(function () {

		var hp_id				= <?php echo json_encode($user['hp_id']); ?>;
		var tel_id				= <?php echo json_encode($user['tel_id']); ?>;
		var job					= <?php echo json_encode($user['job']); ?>;
		var level				= <?php echo json_encode($user['level']); ?>;

		$('#hp_id > option[value=' + hp_id + ']').attr('selected', 'selected');
		$('#tel_id > option[value=' + tel_id + ']').attr('selected', 'selected');
		$('#job > option[value=' + job + ']').attr('selected', 'selected');
		$('#level > option[value=' + level + ']').attr('selected', 'selected');


		$('#member_new_pw').on('input', function (event) {
            
            var $confirm = $('#member_pw_confirm');
            $confirm.attr('readonly', $(this).val().length == 0);
            if($confirm.attr('readonly'))
                $confirm.val('');

        } );

		$('#tel_01, #tel_02, #hp_01, #hp_02').numeric();
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mypage/style.modify.css'); ?>">
</head>
<form action="requestModify" method="post">
	<table class="default-table member-info-table">
		<tbody>
			<tr>
				<th>이름</th>
				<td id="member-name"><?php echo $user['name']; ?></td>
			</tr>
			<tr>
				<th>회원아이디</th>
				<td id="member-id"><?php echo $user['id']; ?></td>
			</tr>
			<tr>
				<th>현재 비밀번호</th>
				<td><input id="member_pw" name="pw" type="password" /></td>
			</tr>
			<tr>
				<th>새로운 비밀번호</th>
				<td><input id="member_new_pw" name="newpw" type="password" /></td>
			</tr>
			<tr>
				<th>비밀번호 확인</th>
				<td><input id="member_pw_confirm" name="confirm" type="password" readonly="readonly" /></td>
			</tr>
			<tr>
				<th>직업</th>
				<td>
					<select id="job" name="job" data-inline="true" data-icon="false">
						<option value="teaching">교직</option>
						<option value="student">학생</option>
						<option value="engineer">엔지니어/연구원</option>
						<option value="office">사무직</option>
						<option value="executive">임원</option>
						<option value="other">기타</option>
					</select>
				</td>
<!-- 			<th>주소</th>
				<td>
					<input type="text" id="member_zcode" name="zcode" readonly="readonly" maxlength="5" style="width: 100px;" placeholder="우편주소" value="<?php echo $user['zonecode']; ?>"/>
					<span class="round-button">
						<a href="javascript:openBrWindow()">우편번호 찾기</a>
					</span>
					<br />
					<input type="text" id="member_addr" name="addr" readonly="readonly" style="width: 500px;" placeholder="주소" value="<?php echo $user['addr']; ?>"/>
					<input type="text" id="member_addr_detail" name="addr_detail" style="width: 380px;" placeholder="상세주소" value="<?php echo $user['addr_detail']; ?>" />
				</td> 
-->
			</tr>
			<tr>
				<th>보유 자격증</th>
				<td>
					<select id="level" name="level" data-inline="true" data-icon="false">
						<option value="none">없음</option>
						<option value="level1">트리즈 Level 1</option>
						<option value="level2">트리즈 Level 2</option>
						<option value="level3">트리즈 Level 3</option>
						<option value="level4">트리즈 Level 4</option>
						<option value="level5">트리즈 Level 5(Master)</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>이메일</th>
				<td>
					<input type="text" id="member_mail_account" name="email_account" value="<?php echo $user['email_account']; ?>" style="width: 100px;">
					<span>@</span>
					<input type="text" id="member_mail_domain" name="email_domain" value="<?php echo $user['email_domain']; ?>" style="width: 200px;">
					<select onchange="onchangeDomain(this.value)" data-inline="true" data-icon="false">
						<option>직접입력</option>
						<option>chollian.net</option>
						<option>dreamwiz.com</option>
						<option>empal.com</option>
						<option>freechal.com</option>
						<option>hananet.net</option>
						<option>hanafos.com</option>
						<option>hanmail.net</option>
						<option>hitel.net</option>
						<option>hanmir.com</option>
						<option>intizen.com</option>
						<option>kebi.com</option>
						<option>korea.com</option>
						<option>kornet.net</option>
						<option>lycos.co.kr</option>
						<option>msn.com</option>
						<option>nate.com</option>
						<option>naver.com</option>
						<option>netsgo.com</option>
						<option>netian.com</option>
						<option>orgio.net</option>
						<option>paran.com</option>
						<option>sayclub.com</option>
						<option>shinbiro.com</option>
						<option>unitel.co.kr</option>
						<option>yahoo.co.kr</option>
						<option>yahoo.com</option>
					</select>
					<p>* daum과 hanmail은 온라인우표제로 인해 각종정보 발송이 불가능하오니 다른 메일 계정이용을 권장합니다. </p>
					<p>※ 행사안내 및 상품정보에 대한 메일을 수신하겠습니까?</p>
					<input type="checkbox" name="recvmail" id="agree_recvmail" <?php if($this->agent->is_mobile() == false) echo 'class="desktop-checkbox"'; ?> <?php if(intval($user['recvmail']) != 0) echo 'checked'; ?> >
					<label for="agree_recvmail">이메일 수신에 동의합니다.</label>
				</td>
			</tr>
			<tr>
				<th>전화번호</th>
				<td>
					<select id="tel_id" name="tel_id" data-inline="true" data-icon="false">
						<option value="02">02</option>
						<option value="031">031</option>
						<option value="032">032</option>
						<option value="033">033</option>
						<option value="041">041</option>
						<option value="042">042</option>
						<option value="043">043</option>
						<option value="051">051</option>
						<option value="052">052</option>
						<option value="053">053</option>
						<option value="054">054</option>
						<option value="055">055</option>
						<option value="061">061</option>
						<option value="062">062</option>
						<option value="063">063</option>
						<option value="064">064</option>
						<option value="070">070</option>
					</select>
					<span>-</span>
					<input type="text" id="tel_01" name="tel_01" style="width: 50px;" maxlength="4" value="<?php echo $user['tel_01']; ?>">
					<span>-</span>
					<input type="text" id="tel_02" name="tel_02" style="width: 50px;" maxlength="4" value="<?php echo $user['tel_02']; ?>">
				</td>
			</tr>
			<tr>
				<th>휴대폰</th>
				<td>
					<select id="hp_id" name="hp_id" data-inline="true" data-icon="false">
						<option value="010">010</option>
						<option value="011">011</option>
						<option value="016">016</option>
						<option value="017">017</option>
						<option value="018">018</option>
						<option value="019">019</option>
					</select>
					<span>-</span>
					<input type="text" id="hp_01" name="hp_01" style="width: 50px;" maxlength="4" value="<?php echo $user['hp_01']; ?>">
					<span>-</span>
					<input type="text" id="hp_02" name="hp_02" style="width: 50px;" maxlength="4" value="<?php echo $user['hp_02']; ?>">
				</td>
			</tr>
		</tbody>
	</table>
	<div class="button-box content-group" style="text-align: center;">
		<input type="submit" class="default-button" value="확인" data-role="none">
		<a href="javascript:history.back()">
			<span class="cancel-button">취소</span>
		</a>
	</div>
</form>