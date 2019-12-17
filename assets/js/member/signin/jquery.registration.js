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

            $('input[name=member_zonecode]').val(data.zonecode);
            $('input[name=member_addr]').val(addrFull);
        }
    }).open();
}

function onchangeDomain(domain) {
    if(domain == '직접입력') {
        $('input[name=member_mail_domain]').val('');
    }
    else {
        $('input[name=member_mail_domain]').val(domain);
    }
}

$(document).on("pageshow",function(event,data){

    $('input[name=hp_01], input[name=hp_02], input[name=tel_01], input[name=tel_02]').numeric();
});