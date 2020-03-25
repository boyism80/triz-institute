<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/numeric/jquery.numeric.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.content.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/member/signin/jquery.registration.js'); ?>"></script>
<script type="text/javascript">

	function isExists() {

	    var id          = $('input[name=member_id]').val();

	    $.ajax({type: 'POST',
	            url: '<?php echo base_url(); ?>member/exists/' + id,
	            processData: false,
	            contentType: false,
	            dataType: 'json',
	            success: function (result) {
	                if(result.success == false) {

	                	alert(result.error);
	                	return;
	                }

	                if(result.data == true)
	                	alert('이미 존재하는 ID입니다.');
	                else
	                	alert('사용 가능한 ID입니다.');
	            },
	            error: function (request, status, error) {
	                console.log(request, status, error);
	            },
	        });
	}


	$(document).ready(function () {

		$('input[name=hp_01], input[name=hp_02], input[name=tel_01], input[name=tel_02]').numeric();
	} );
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.content.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/member/signin/style.signin.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/member/signin/style.registration.css'); ?>">
</head>
<body>
	<div id="contents">
		<form action="<?php echo base_url('member/request'); ?>" method='post'>
			<div class="signin-header">
				<div class="top">
					<span class="title">회원약관 동의</span>
					<img class="state-image" src="<?php echo cdn('assets/image/member/signin/step_02.png'); ?>" />
				</div>
				<div class="bottom">
					<div class="desc">
						<p style="font-size: 18px;"><font class="highlight-color">회원가입</font>을 환영합니다.</p>
						<p style="font-size: 12px; color: gray">회원가입을 위해 회원약관 및 개인정보취급방침을 반드시 숙지하시고 동의하시기 바랍니다.</p>
					</div>
				</div>
			</div>
			<table class="default-table member-info-table">
				<tbody>
					<tr>
						<th>이름</th>
						<td><input type="text" name="member_name" /></td>
					</tr>
					<tr>
						<th>회원아이디</th>
						<td>
							<input type="text" name="member_id" maxlength="12"/>
							<a href="javascript:isExists()"><span class="round-button" name="idcheck">아이디 중복 확인</span></a>
							<span>회원 ID는 가입 후 변경이 불가능합니다.</span>

						</td>
					</tr>
					<tr>
						<th>비밀번호</th>
						<td>
							<input type="password" name="member_pw" maxlength="12"/>
							<span> 4~12자의 영문,숫자,특문을 조합하셔서 공백없이 기입해주세요.</span>
						</td>
					</tr>
					<tr>
						<th>비밀번호 확인</th>
						<td><input type="password" name="member_pw_confirm" maxlength="12"/></td>
					</tr>
					<tr>
						<th>직업</th>
						<td>
							<select name="member_job">
								<option value="teaching">교직</option>
								<option value="student">학생</option>
								<option value="engineer">엔지니어/연구원</option>
								<option value="office">사무직</option>
								<option value="executive">임원</option>
								<option value="other">기타</option>
							</select>
						</td>
<!-- 						<th>주소</th>
							<td>
								<input type="text" name="member_zonecode" readonly="readonly" maxlength="5" style="width: 100px;" placeholder="우편주소" />
								<span class="round-button">
									<a href="javascript:openBrWindow()">우편번호 찾기</a>
								</span>
								<br />
								<input type="text" name="member_addr" readonly="readonly" style="width: 500px;" placeholder="주소" />
								<input type="text" name="member_addr_detail" style="width: 380px;" placeholder="상세주소" />
							</td> 
-->
					</tr>
					<tr>
						<th>보유 자격증</th>
						<td>
							<select name="member_level">
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
							<input type="text" name="member_mail_account" style="width: 100px;">
							<span>@</span>
							<input type="text" name="member_mail_domain" style="width: 200px;">
							<select onchange="onchangeDomain(this.value)">
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
							<input type="checkbox" name="member_recvmail" id="agree_recvmail" checked="checked" <?php if($this->agent->is_mobile() == false) echo 'class="desktop-checkbox"'; ?> >
							<label for="agree_recvmail">이메일 수신에 동의합니다.</label>
						</td>
					</tr>
					<tr>
						<th>전화번호</th>
						<td>
							<select name="tel_id">
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
							<input type="text" name="tel_01" style="width: 50px;" maxlength="4">
							<span>-</span>
							<input type="text" name="tel_02" style="width: 50px;" maxlength="4">
						</td>
					</tr>
					<tr>
						<th>휴대폰</th>
						<td>
							<select name="hp_id">
								<option selected>010</option>
								<option>011</option>
								<option>016</option>
								<option>017</option>
								<option>018</option>
								<option>019</option>
							</select>
							<span>-</span>
							<input type="text" name="hp_01" style="width: 50px;" maxlength="4">
							<span>-</span>
							<input type="text" name="hp_02" style="width: 50px;" maxlength="4">
						</td>
					</tr>
				</tbody>
			</table>
			<div class="button-box content-group" style="text-align: center;">
				<input type="submit" class="default-button" name="btnok" value="확인"></input>
				<a href="<?php echo base_url(); ?>">
					<div class="cancel-button" name="btncancel">취소</div>
				</a>
			</div>
		</form>
	</div>
</body>
</html>