<head>
<script type="text/javascript" src="<?php echo base_url('assets/js/consulting/jquery.algorithm.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/consulting/style.algorithm.css'); ?>">
</head>
<div class="line-box" style="text-align: left;">
	<div class="highlight-color" style="text-align: center; font-size: 14px;">알고리즘의 기본 이념</div>
	<br />
	<ul class="default-list">
		<li>문제를 해결하려 하지 말고, 문제가 발생하지 않는 조건을 만들어라.</li>
		<li>문제가 최초로 발생한 지점에서 문제를 분석하고 그 곳에 존재하고 있는 자원들을 이용해서 문제를 해결하라.</li>
		<li>문제를 발생시킨 것으로 문제를 해결하라.</li>
		<li>올바르게 모델링 된 과제는 그 안에 답을 가지고 있다.</li>
	</ul>
</div>
<div class="content-group">
	<div class="highlight-color" style="text-align: center; font-size: 14px;">알고리즘의 주요 단계</div>
	<ul class="border-list">
		<li class="content-group">
			<span class="content-group-title">01. 정보수집 및 문제구성</span>
			<p>다음의 질문에 대한 답변을 토대로 문제 상황을 기술한다: «무엇이 발생하는가?» «어디에서 발생하는가?» «언제 발생하는가» «왜 발생하는가?»</p>
		</li>
		<li class="content-group">
			<span class="content-group-title">02. 문제의 진위성 검증</span>
			<p>문제의 진위성은 이 문제를 해결하지 않았을 때 미래 어떤 결과가 발생할 것인지를 분석함으로써 검증한다. 문제를 과거 프로세스 단계에서 해결하거나, 상위 시스템으로의 이전을 통해서도 가능하다. 긍정적인 결과를 얻지 못했다면 3단계를 거친다.</p>
		</li>
		<li class="content-group">
			<span class="content-group-title">03. 문제분석 및 Operating zone의 규정</span>
			<p>불필요한 원하지 않는 현상이 무엇인지 정확하게 규정한다. 원하지 않는 현상과 이 현상을 불러일으킨 요소(한가지 혹은 여러 가지 요소)가 최초로 발생한 시간과 장소를 찾아낸다.</p>
		</li>
		<li class="content-group">
			<span class="content-group-title">04. 물질-장 자원 분석과 선택</span>
			<p>Operating zone과 그 근접 시스템 및 상위시스템에 존재하고 있는 자원을 찾아낸다. 이 자원들을 유해한, 중립적인, 과잉의, 유용한 자원으로 구분한다. 유해하며 중립적이고 과잉의 자원들 가운데 가장 에너지 함유가 높은 자원을 선택한다.</p>
		</li>
		<li class="content-group">
			<span class="content-group-title">05. 이상적 해결한(IFR) 도출</span>
			<p>선택한 자원을 활용하여 이상적인 해결안을 구성한다. 이상적 해결안 모델링 공식은 다음과 같다: «(3단계에서 규정한 요소)는 (4단계에서 선택한 자원을) 이용하여, (원하는 기능)을 수행한다. 이 때 (3단계에서 규정한 원하지 않는 현상)을 허용하지 않는다».</p>
			<p>만약 해결안 개념이 확실하여 기본적인 공학적 지식으로 해결할 수 있는지 검증한다.</p>
			<p>답변이 명확하지 않을 경우, 6단계로 넘어간다.</p>
		</li>
		<li class="content-group">
			<span class="content-group-title">07. 물리적 모순 도출</span>
			<p>답변이 명확하지 않는 과제의 경우 물리적 모순을 가지고 있는 요소를 규명해 낸다. 즉 서로 반대되는 물리적 성질을 나타내야 하는 요소를 찾아낸다. 그리고 이 모순을 해결하는 원리를 선택한다.</p>
		</li>
		<li class="content-group">
			<span class="content-group-title">06. 물리적 모순 해결</span>
			<p>6단계에서 선택한 원리에 따라 다음과 같이 물리적 모순을 해결한다.</p>
			<ul class="default-list line-box" style="text-align: left;">
				<li>
					<div class="highlight-color">모순을 시간 분리를 통해 해결할 경우</div>
					<p>«(3단계에서 규정한 요소)는 (4단계에서 규정한 자원)을 이용하여 어떤 때에는 (첫 번째 특성)을 가지고 있으나, 다른 때에는 (두 번째 특성)을 가지고 있다. 이렇게 (원하는 기능)을 수행하며, 이 때 (3단계에서 규명한 원하지 않는 현상)을 허용하지 않는다»</p>
					<br />
				</li>
				<li>
					<div class="highlight-color">모순을 공간 분리를 통해 해결할 경우</div>
					<p>«(3단계에서 규명한 요소)는 (4단계에서 규정한 자원)을 이용하여 특정 장소에서는 (첫 번째 특성)을 보유하고 있으나, 다른 장소에서는 (두 번째 특성)을 가지고 있다. 이렇게 (원하는 기능)을 수행하며 이 때 (원하지 않는 현상)을 허용하지 않는다».</p>
					<br />
				</li>
				<li>
					<div class="highlight-color">모순을 상호관계를 통해 해결할 경우</div>
					<p>«(3단계에서 규명한 요소)는 (4단계에서 규정한 자원이나 필요한 물리적 효과)를 이용하여 (이중시스템, 다중시스템, 액체형, 기체형, 안티 시스템)으로 변한다. 이 때 (3단계에서 규명한 원하지 않는 현상)을 허용하지 않는다 »</p>
				</li>
			</ul>
		</li>
		<li class="content-group">
			<span class="content-group-title">08. 해결안 분석</span>
			<p>가장 최적의 해결안은 최대한 이상성에 근접한 것으로, 상위 시스템과 조화를 이루는 것이다.</p>
		</li>
	</ul>
</div>